<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->library('email');
        $this->load->helper(['url', 'language']);
        $this->load->model('ProductModel');
        $this->load->model('Ion_auth_model');

        // dashboard sequrity for unauthorized person
        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        else
        {
            $this->data['title'] = $this->lang->line('index_heading');

            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            //list the users
            $this->data['users'] = $this->ion_auth->users()->result();
        }

    }
    public function UserCommon()
    {
        $userInfo = array();
        $user_id = $_SESSION['user_id'];
        $condition =['id' => $user_id];
        $user = $this->ProductModel->GetRow('users',$condition);
        $userInfo['user_name'] = $user->username;
        $userInfo['role'] = $user->role;
        $userInfo['name'] = $user->first_name.' '.$user->last_name;
        return $userInfo;
    }
    public function Dashboard()
    {
        $data = array();
        $data['userInfo'] = $this->UserCommon();
        $data['page_title'] = 'Dashboard';
        $data['content']=$this->load->view('front-end/home',$data,true);
        $this->load->view('front-end/master',$data);
    }
    public function product_entry()
    {
        if (isset($_POST['product_btn']))
        {
            $this->form_validation->set_rules('product_name','product name','required');
            // $this->form_validation->set_rules('product_size','product Size','required');
            $this->form_validation->set_rules('product_quantity','product quantity','required');
            $this->form_validation->set_rules('unit_price','unit price','required');
            $this->form_validation->set_rules('amount','amount','required');
            $this->form_validation->set_rules('entry_date','entry date','required');
            $this->form_validation->set_rules('procurer_name','procurer name','required');
            $this->form_validation->set_rules('vendor_name','vendor name','required');
            $this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
            if ($this->form_validation->run()) {
                $user_id = $_SESSION['user_id'];
                $product_data['product_name']       = $this->input->post('product_name', TRUE);
                $product_data['product_quantity']   = $this->input->post('product_quantity', TRUE);
                $product_data['size']               = $this->input->post('product_size', TRUE);
                $product_data['unit_price']         = $this->input->post('unit_price', TRUE);
                $product_data['amount']             = $this->input->post('amount', TRUE);
                $product_data['entry_date']         = $this->input->post('entry_date', TRUE);
                $product_data['procurer_name']      = $this->input->post('procurer_name', TRUE);
                $product_data['vendor_name']        = $this->input->post('vendor_name', TRUE);
                $product_data['entry_user_id']      = $user_id;
                $product_quantity = $this->input->post('product_quantity', TRUE);

                $condition =['product_name' => $product_data['product_name'],'size'=>$product_data['size']];
                $total_quantity = $this->ProductModel->GetRow('total_quantity',$condition);
                if (!empty($total_quantity))
                {
                    $q_t['total_quantity'] = $total_quantity->total_quantity + $product_quantity;
                    $condition =['id' => $total_quantity->id];
                    $this->ProductModel->updateData('total_quantity',$condition,$q_t);
                }else{
                    $q_t['product_name']    = $product_data['product_name'];
                    $q_t['size']            = $product_data['size'];
                    $q_t['total_quantity']  = $product_quantity;
                    $this->ProductModel->InsertData('total_quantity',$q_t);
                }
                $condition =['name' => $product_data['product_name'],'size'=>$product_data['size']];
                $inventoryProduct = $this->ProductModel->GetInventoryProduct('inventory',$condition);

                if (!empty($inventoryProduct))
                {
                    $remaining = $inventoryProduct->remaining +$product_quantity;
                    $inventory_product['remaining'] = $remaining;
                    $inventory_product['date']      = date('d-m-y');
                    $inventory_product['name']      = $product_data['product_name'];
                    $inventory_product['size']      = $product_data['size'];
                    $inventory_product['procurer']  = $product_data['product_quantity'];

                    $this->ProductModel->InsertData('inventory',$inventory_product);
                }else{
                    if (!empty($total_quantity)) {
                        $inventory_product['remaining'] = $total_quantity->total_quantity + $product_quantity;
                    }else
                    {
                        $inventory_product['remaining'] = $product_quantity;
                    }

                    $inventory_product['date'] = date('d-m-y');
                    $inventory_product['name'] = $product_data['product_name'];
                    $inventory_product['size'] = $product_data['size'];
                    $inventory_product['procurer'] = $product_data['product_quantity'];
                    $this->ProductModel->InsertData('inventory',$inventory_product);
                }
                    $this->FilesUpload($product_data);
            }else
            {
                $data = array();
                $data['userInfo'] = $this->UserCommon();
                $data['page_title'] = 'Product Entry';
                $data['content']=$this->load->view('front-end/product-entry', $data, true);
                $this->load->view('front-end/master', $data);
            }
        }else{
            $data = array();
            $data['userInfo'] = $this->UserCommon();
            $data['page_title'] = 'Product Entry';
            $data['content']=$this->load->view('front-end/product-entry', $data, true);
            $this->load->view('front-end/master', $data);
        }
    }

    public function FilesUpload($product_data)
    {

        if(isset($_FILES['product_file']['name']) && $_FILES['product_file']['name'] != '') {
            $this->load->library('upload');
            $config['upload_path'] = "./assets/files";
            $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
            $config['file_name'] = date('YmdHms').'_'.rand(1, 999999);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('product_file')) {

                $uploaded = $this->upload->data();

                $product_data['product_file'] = $uploaded['file_name'];


                $result = $this->ProductModel->InsertData('product_entry',$product_data);
                if (!empty($result)) {
                    $this->session->set_flashdata('success_message','Successfully Insert data');
                    return redirect('product-entry');
                } else {

                    $this->session->set_flashdata('success_message','Data Insert Failed');
                    return redirect('product-entry');
                }
            }else
            {
                $this->session->set_flashdata('success_message','Please try valid files');
                return redirect('product-entry');
            }
        }else
        {
            $result = $this->ProductModel->InsertData('product_entry',$product_data);
            if (!empty($result)) {
                $this->session->set_flashdata('success_message','Successfully Insert data');
                return redirect('product-entry');
            } else {

                $this->session->set_flashdata('success_message','Data Insert Failed');
                return redirect('product-entry');
            }
        }
    }

    public function product_list()
    {
        $data = array();
        $data['userInfo'] = $this->UserCommon();
        $data['page_title'] = 'Product List';
        $data['content']=$this->load->view('front-end/product-list', $data, true);
        $this->load->view('front-end/master', $data);
    }
    public function edit_entry()
    {
        $entry_value     = $this->input->post('entry_value', TRUE);
        $condition =['id' => $entry_value];
        $entry = $this->ProductModel->GetRow('product_entry',$condition);
        echo json_encode($entry);
    }
    public function update_entry()
    {
        $product_data = array();
        $product_data['product_name']       = $this->input->post('product_name', TRUE);
        $product_data['product_quantity']   = $this->input->post('product_quantity', TRUE);
        $product_data['size']               = $this->input->post('product_size', TRUE);
        $product_data['unit_price']         = $this->input->post('unit_price', TRUE);
        $product_data['amount']             = $this->input->post('amount', TRUE);
        $product_data['entry_date']         = $this->input->post('entry_date', TRUE);
        $product_data['procurer_name']      = $this->input->post('procurer_name', TRUE);
        $product_data['vendor_name']        = $this->input->post('vendor_name', TRUE);
        $entry_id                           = $this->input->post('entry_id', TRUE);
        $condition =['id' => $entry_id];
        $result = $this->ProductModel->updateData('product_entry',$condition,$product_data);
        echo json_encode($result);
    }
    public function search_product()
    {
        $data = array();
        $data['userInfo'] = $this->UserCommon();
        $data['page_title'] = 'Search Product';
        $data['content']=$this->load->view('front-end/search-product', $data, true);
        $this->load->view('front-end/master', $data);
    }
    public function show_entry()
    {
        $search_id     = $this->input->post('id', TRUE);
        $condition = '';
        if ($search_id == 1)
        {
            $condition =['delete_flag' => 0];

        }elseif ($search_id == 2)
        {
            $condition =['delete_flag' => 1];
        }elseif ($search_id == 3)
        {

            $entryData     = $this->input->post('entryData', TRUE);
            $condition =['vendor_name' => $entryData,'delete_flag'=>0];
        }
        $entry_product = $this->ProductModel->GetArray('product_entry',$condition);

        echo json_encode($entry_product);
    }
    public function show_vendor()
    {
        $vendor_name = $this->ProductModel->GetDistinctArray();
        echo json_encode($vendor_name);
    }
    public function entry_by_date()
    {
        $entry_date     = $this->input->post('entry_date', TRUE);
        $query_init     = $this->input->post('query_init', TRUE);
        $condition      ='';
        if ($query_init == 1)
        {
            $condition =['entry_date' => $entry_date,'delete_flag'=>0];

        }elseif ($query_init == 2)
        {
            $condition =['entry_date !='=>$entry_date,'delete_flag'=>0];
        }elseif ($query_init == 3)
        {
            $condition =['entry_date >'=> $entry_date,'delete_flag'=>0];
        }elseif($query_init == 4)
        {
            $condition =['entry_date <'=> $entry_date,'delete_flag'=>0];
        }
        $entry_product = $this->ProductModel->GetArray('product_entry',$condition);
        echo json_encode($entry_product);
    }

    public function issue_product()
    {
        $data = array();
        $data['userInfo'] = $this->UserCommon();
        $data['page_title'] = 'Issue Product';
        $data['content']=$this->load->view('front-end/issue-product', $data, true);
        $this->load->view('front-end/master', $data);
    }
    public function show_vendor_name()
    {
        $vendor_name = $this->ProductModel->GetDistinctArray();
        echo json_encode($vendor_name);
    }
    public function show_two_type_data()
    {
        $search_id     = $this->input->post('id', TRUE);

        $condition = '';
        if ($search_id == 1)
        {
            $condition =['delete_flag' => 0];

        }elseif ($search_id == 2)
        {
            $condition =['delete_flag' => 1];
        }
        $entry_product = $this->ProductModel->GetArray('product_entry',$condition);

        echo json_encode($entry_product);
    }

    public function delete_entry()
    {

        $user_id = $_SESSION['user_id'];
        $condition =['id' => $user_id];
        $user = $this->ProductModel->GetRow('users',$condition);
        $name = $user->first_name.' '.$user->last_name;
        if ($name != '')
        {
            $name = $name;
        }else
        {
            $name = '';
        }
        $id = $this->input->get('id');
        $condition =['id' => $id];
        $data['delete_flag']=1;
        $data['issue_name']=$name;
        $result = $this->ProductModel->updateData('product_entry',$condition,$data);
        echo json_encode("successfully deleted");
    }
    public function Profile()
    {
        $data = array();
        $user_id = $_SESSION['user_id'];
        $condition =['id' => $user_id];
        $data['user'] = $this->ProductModel->GetRow('users',$condition);
        $condition =['entry_user_id' => $user_id];
        $data['entry_product'] = $this->ProductModel->GetArray('product_entry',$condition);
        $data['userInfo'] = $this->UserCommon();
        $data['page_title'] = 'Setting';
        $data['content']=$this->load->view('front-end/profile', $data, true);
        $this->load->view('front-end/master', $data);
    }
    public function update_profile()
    {

        $product_data = array();
        $this->form_validation->set_rules('first_name','First name','required');
        $this->form_validation->set_rules('last_name','Last name','required');
        $this->form_validation->set_rules('email_address','Email address','required');
//        $this->form_validation->set_rules('email_address','Email address','required|is_unique[users.email]');
        $this->form_validation->set_rules('password','Password','required');
        $this->form_validation->set_rules('confirm_password','Confirm Password','required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
        if ($this->form_validation->run()) {

            $product_data['password'] = $this->input->post('password', TRUE);
            $confirm_password = $this->input->post('confirm_password', TRUE);
            if ($product_data['password'] == $confirm_password)
            {
                $product_data['first_name'] = $this->input->post('first_name', TRUE);
                $product_data['last_name'] = $this->input->post('last_name', TRUE);
                $product_data['email'] = $this->input->post('email_address', TRUE);
                $id = $this->input->post('id', TRUE);
                $product_data['password'] = $this->Ion_auth_model->hash_password($this->input->post('password', TRUE));
                $condition =['id' => $id];
                $result = $this->ProductModel->updateData('users',$condition,$product_data);
                $this->session->set_flashdata('success_message','Successfully Updated Profile');
                return redirect('profile');

            }else
            {
                $this->session->set_flashdata('success_message',"Password and Confirm password don't match");
                return redirect('profile');
            }
        }
        else
        {
            $data = array();
            $user_id = $_SESSION['user_id'];
            $condition =['id' => $user_id];
            $data['user'] = $this->ProductModel->GetRow('users',$condition);
            $data['userInfo'] = $this->UserCommon();
            $data['page_title'] = 'Setting';
            $data['content']=$this->load->view('front-end/profile', $data, true);
            $this->load->view('front-end/master', $data);
        }
    }
    public function issue_view()
    {
        $data = array();
        $user_id = $_SESSION['user_id'];
        $condition =['id' => $user_id];
        $data['user'] = $this->ProductModel->GetRow('users',$condition);
        $data['userInfo'] = $this->UserCommon();
        $data['page_title'] = 'Setting';
        $data['content']=$this->load->view('front-end/issue-view', $data, true);
        $this->load->view('front-end/master', $data);
    }
    public function search_issue()
    {
        $product_name = $_POST['product_name'];
        $product_size = $_POST['product_size'];
        $data['product'] = $this->ProductModel->getSearch($product_name,$product_size);
        echo json_encode($data);
    }
    public function quantity_issue()
    {

        $result['error'] = false;
        $result['success'] = false;
        $result['msg'] = '';
        $this->form_validation->set_rules('product_name','product name','required');
        $this->form_validation->set_rules('product_size','product size','required');
        $this->form_validation->set_rules('product_quantity','product quantity','required');
        $this->form_validation->set_rules('issue_name','issuer name','required');
        $this->form_validation->set_rules('issue_type','issue type name','required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
        if ($this->form_validation->run()) {
            $data = array();
            $product_id                             = $this->input->post('product_id', TRUE);
            $product_quantity                       = $this->input->post('product_quantity', TRUE);
            $data['issue_type']                     = $this->input->post('issue_type', TRUE);
            $data['issuer_name']                     = $this->input->post('issue_name', TRUE);
            $condition =['id' => $product_id];
            $product = $this->ProductModel->GetRow('total_quantity',$condition);
            $product_quantity = $product->total_quantity - $product_quantity;
            $product_name = $product->product_name;
            $product_size = $product->size;
            $data['issue_date'] = date('d-m-Y');

            if ($product_quantity <1)
            {
                $this->session->set_flashdata('success_message','issued failed.product quantity can not 1 or less then 1');
                $result['msg'] = 'issued failed.product quantity can not 1 or less then 1';
            }else
            {
                $data['product_id'] = $product_id;
                $data['latest_quantity'] = $this->input->post('product_quantity', TRUE);
                $data['product_name'] = $product_name;
                $data['size'] = $product_size;

                $product_data['total_quantity']        = $product_quantity;
                $condition =['id' => $product_id];
                $this->ProductModel->updateData('total_quantity',$condition,$product_data);

                    $latest_quantity['latest_quantity']    = $this->input->post('product_quantity', TRUE);
                    $latest_quantity['issue_type']         = $this->input->post('issue_type', TRUE);
                    $latest_quantity['issuer_name']        = $this->input->post('issue_name', TRUE);
                    $this->ProductModel->InsertData('issue_product',$data);


                $condition =['name' => $product_name,'size'=>$product_size];
                $inventoryProduct = $this->ProductModel->GetInventoryProduct('inventory',$condition);

                if (!empty($inventoryProduct))
                {
                    $issue_type = $this->input->post('issue_type', TRUE);
                    $remaining = $inventoryProduct->remaining - $this->input->post('product_quantity', TRUE);
                    $inventory_product['remaining'] = $remaining;
                    $inventory_product['date'] = date('d-m-y');
                    $inventory_product['name'] = $product_name;
                    $inventory_product['size'] = $product_size;
                    $inventory_product[$issue_type] = $this->input->post('product_quantity', TRUE);

                    $this->ProductModel->InsertData('inventory',$inventory_product);
                }

                $this->session->set_flashdata('success_message','issued successfully');
                $result['msg'] = 'issued successfully';
            }

            //return redirect('product-list');
        }else
        {
            $result['error'] = true;
            $result['msg'] = validation_errors();

        }
        echo json_encode($result);

    }
    public function users()
    {
        $data = array();
        $user_id = $_SESSION['user_id'];
        $condition =['id' => $user_id];
        $data['user'] = $this->ProductModel->GetRow('users',$condition);
        $data['userInfo'] = $this->UserCommon();
        $data['all_users'] = $this->ProductModel->GetArray('users');
        $data['page_title'] = 'Users';
        $data['content']=$this->load->view('front-end/manage-users', $data, true);
        $this->load->view('front-end/master', $data);
    }
    public function edit_user($id)
    {
        $data = array();
        $condition =['id' => $id];
        $data['user'] = $this->ProductModel->GetRow('users',$condition);
        $data['userInfo'] = $this->UserCommon();
        $data['page_title'] = $data['user']->first_name.' '.$data['user']->last_name;
        $data['content']=$this->load->view('front-end/edit-users', $data, true);
        $this->load->view('front-end/master', $data);
    }
    public function delete_user()
    {
        $user_id         = $this->input->post('userId', TRUE);
        $condition =['id' => $user_id];
        $this->ProductModel->delete('users',$condition);

        echo 'success';
    }
    public function update_user()
    {
        $user_id         = $this->input->post('user_id', TRUE);
        $this->form_validation->set_rules('first_name','first name','required');
        $this->form_validation->set_rules('last_name','last name','required');
        $this->form_validation->set_rules('email','email','required');
        $this->form_validation->set_rules('phone','phone','required');
        $this->form_validation->set_rules('username','username','required');
        $this->form_validation->set_rules('user_role','user role','required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
        if ($this->form_validation->run()) {
            $user_data['first_name']       = $this->input->post('first_name', TRUE);
            $user_data['last_name']        = $this->input->post('last_name', TRUE);
            $user_data['phone']            = $this->input->post('phone', TRUE);
            $user_data['role']              = $this->input->post('user_role', TRUE);


            $condition =['id' => $user_id];
            $result = $this->ProductModel->updateData('users',$condition,$user_data);
            if (!empty($result)) {
                $this->session->set_flashdata('success_message','Successfully updated user');
                return redirect('edit-user/'.$user_id);
            } else {

                $this->session->set_flashdata('success_message','User update Failed');
                return redirect('edit-user/'.$user_id);
            }
        }else{

            $data = array();
            $condition =['id' => $user_id];
            $data['user'] = $this->ProductModel->GetRow('users',$condition);
            $data['userInfo'] = $this->UserCommon();
            $data['page_title'] = $data['user']->first_name.' '.$data['user']->last_name;
            $data['content']=$this->load->view('front-end/edit-users', $data, true);
            $this->load->view('front-end/master', $data);
        }
    }
    public function add_user()
    {

        if (isset($_POST['user_btn']))
        {
            $this->form_validation->set_rules('first_name','first name','required');
            $this->form_validation->set_rules('last_name','last name','required');
            $this->form_validation->set_rules('email','email','required|is_unique[users.email]');
            $this->form_validation->set_rules('phone','phone','required');
            $this->form_validation->set_rules('username','username','required|is_unique[users.username]');
            $this->form_validation->set_rules('user_role','user role','required');
            $this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
            if ($this->form_validation->run()) {

                $user_data['first_name']       = $this->input->post('first_name', TRUE);
                $user_data['last_name']        = $this->input->post('last_name', TRUE);
                $user_data['email']            = $this->input->post('email', TRUE);
                $user_data['phone']            = $this->input->post('phone', TRUE);
                $user_data['username']         = $this->input->post('username', TRUE);
                $user_data['role']         = $this->input->post('user_role', TRUE);
                $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz./$%#@!';
                $password =  substr(str_shuffle($permitted_chars), 0, 10);
                $user_data['password'] = $this->Ion_auth_model->hash_password($password);

                $message = '<p>Hi,'.$user_data['first_name'].' '.$user_data['last_name'] .'</p>
                            <p>This is your Email: '.$user_data["email"].'</p>
                            <p>This is your user name: '.$user_data["username"].'</p>
                            <p>This is your password: '.$password.'</p>
                            <p>click here and login your account: http://digi.therssoftware.com/product/auth/login</p>
                    
                ';
                $subject = 'User activation mail';
                $this->EmailConfig($message,$user_data['email'],$subject);

                $result = $this->ProductModel->InsertData('users',$user_data);
                if (!empty($result)) {
                    $this->session->set_flashdata('success_message','Successfully create user');
                    return redirect('add-user');
                } else {

                    $this->session->set_flashdata('success_message','User create Failed');
                    return redirect('add-user');
                }
            }else
            {
                $data = array();
                $user_id = $_SESSION['user_id'];
                $condition =['id' => $user_id];
                $data['user'] = $this->ProductModel->GetRow('users',$condition);
                $data['userInfo'] = $this->UserCommon();
                $data['all_users'] = $this->ProductModel->GetArray('users');
                $data['page_title'] = 'Users';
                $data['content']=$this->load->view('front-end/add-user', $data, true);
                $this->load->view('front-end/master', $data);
            }
        }else
        {
            $data = array();
            $user_id = $_SESSION['user_id'];
            $condition =['id' => $user_id];
            $data['user'] = $this->ProductModel->GetRow('users',$condition);
            $data['userInfo'] = $this->UserCommon();
            $data['all_users'] = $this->ProductModel->GetArray('users');
            $data['page_title'] = 'Users';
            $data['content']=$this->load->view('front-end/add-user', $data, true);
            $this->load->view('front-end/master', $data);
        }

    }
    public function EmailConfig($message,$emails,$subject)
    {
        $config = array(
                'mailtype'=>'html',
                // 'protocol'=>'smtp',
                // 'smtp_host'=>'smtp.gmail.com', //(SMTP server)
                // 'smtp_port'=>25, //(SMTP port)
                // 'smtp_timeout'=>'30',
                // 'smtp_user'=>'aftabuddin6222@gmail.com', //(user@gmail.com)
                // 'smtp_pass'=>'Sahajjo6222#@!.222', // (gmail password)
                // 'smtp_crypto' =>'tls',
                
                
            );
        $this->email->initialize($config);
        $this->email->from('aftabuddin6222@gmail.com');
        $this->email->to($emails);
        $this->email->reply_to('aftabuddin6222@gmail.com');
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
        echo $this->email->print_debugger();
        // $config['protocol']='smtp';
        // $config['smtp_host']='smtp.gmail.com'; //(SMTP server)
        // $config['smtp_port']=25; //(SMTP port)
        // $config['smtp_timeout']='30';
        // $config['smtp_user']='aftabuddin6222@gmail.com'; //(user@gmail.com)
        // $config['smtp_pass']='Aftab6222#@!.222'; // (gmail password)
        // //$config['smtp_crypto'] ='tls';

        // $this->email->initialize($config);

        // $this->email->from('aftabuddin6222@gmail.com');
        // $this->email->to($emails);
        // $this->email->reply_to($emails);
        // $this->email->subject($subject);
        // $this->email->message($message);
        // $this->email->send();
    }
    public function active_user($id)
    {
        $condition =['id' => $id];
        $user_data['active'] = 1;
        $result = $this->ProductModel->updateData('users',$condition,$user_data);
        $this->session->set_flashdata('success_message','Successfully activated user');
        return redirect('users');
    }
    public function deactivate_user($id)
    {
        $condition =['id' => $id];
        $user_data['active'] = 0;
        $result = $this->ProductModel->updateData('users',$condition,$user_data);
        $this->session->set_flashdata('success_message','Successfully deactivated user');
        return redirect('users');
    }
    public function inventory()
    {
        $data = array();
        $user_id = $_SESSION['user_id'];
        $condition =['id' => $user_id];
        $data['user'] = $this->ProductModel->GetRow('users',$condition);
        $data['userInfo'] = $this->UserCommon();
        $data['all_users'] = $this->ProductModel->GetArray('users');
        $data['inventories'] = $this->ProductModel->GetArray('inventory');

        $data['page_title'] = 'Inventory';
        $data['content']=$this->load->view('front-end/inventory', $data, true);
        $this->load->view('front-end/master', $data);
    }
    public function single_product($id)
    {
        $data = array();
        $user_id = $_SESSION['user_id'];
        $condition =['id' => $user_id];
        $data['user'] = $this->ProductModel->GetRow('users',$condition);
        $data['userInfo'] = $this->UserCommon();
        $data['all_users'] = $this->ProductModel->GetArray('users');
        $condition =['id' => $id];
        $data['single_product'] = $this->ProductModel->GetRow('product_entry',$condition);
        $data['page_title'] = 'Single Product';
        $data['content']=$this->load->view('front-end/single-product', $data, true);
        $this->load->view('front-end/master', $data);
    }
    
    public function index_ajax($offset=null)
    {
        $search = array(
            'keyword' => trim($this->input->post('search_key')),
        );

        $this->load->library('pagination');

        $limit = 5;
        $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $config['base_url'] = site_url('DashboardController/index_ajax/');
        $config['total_rows'] = $this->ProductModel->get_products($limit, $offset, $search, $count=true);
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $config['num_links'] = 3;
        $config['num_tag_open'] = '<li class="list_style">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><a style="padding: 5px 7px;background: #009688;margin-right: 5px; margin-left:5px;color: #fff;" href="" class="current_page">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li class="list_style">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = 'Previous';
        $config['prev_tag_open'] = '<li class="list_style">';
        $config['prev_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="list_style">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="list_style">';
        $config['last_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $products = $this->ProductModel->get_products($limit, $offset, $search, $count=false);

        $data['products'] = $products;
        $data['pagelinks'] = $this->pagination->create_links();

        $this->load->view('front-end/index_ajax', $data);
    }
    public function total_product_quantity()
    {
        $data = array();
        $data['userInfo'] = $this->UserCommon();
        $data['page_title'] = 'Product List';
        $data['content']=$this->load->view('front-end/product_quantity', $data, true);
        $this->load->view('front-end/master', $data);
    }
    public function issue_product_list()
    {
        $data = array();
        $data['userInfo'] = $this->UserCommon();
        $data['page_title'] = 'Product List';
        $data['content']=$this->load->view('front-end/issue_product_list', $data, true);
        $this->load->view('front-end/master', $data);
    }
    public function quantity_ajax($offset=null)
    {
        $search = array(
            'keyword' => trim($this->input->post('search_key')),
        );

        $this->load->library('pagination');

        $limit = 5;
        $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $config['base_url'] = site_url('DashboardController/quantity_ajax/');
        $config['total_rows'] = $this->ProductModel->get_products_quantity($limit, $offset, $search, $count=true);
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $config['num_links'] = 3;
        $config['num_tag_open'] = '<li class="list_style">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><a style="padding: 5px 7px;background: #009688;margin-right: 5px; margin-left:5px;color: #fff;" href="" class="current_page">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li class="list_style">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = 'Previous';
        $config['prev_tag_open'] = '<li class="list_style">';
        $config['prev_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="list_style">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="list_style">';
        $config['last_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $data['products'] = $this->ProductModel->get_products_quantity($limit, $offset, $search, $count=false);

        $data['pagelinks'] = $this->pagination->create_links();

        $this->load->view('front-end/total-quantity-ajax', $data);
    }
    public function issue_product_ajax($offset=null)
    {
        $search = array(
            'keyword' => trim($this->input->post('search_key')),
        );

        $this->load->library('pagination');

        $limit = 5;
        $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $config['base_url'] = site_url('DashboardController/issue_product_ajax/');
        $config['total_rows'] = $this->ProductModel->get_issue_products($limit, $offset, $search, $count=true);
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $config['num_links'] = 3;
        $config['num_tag_open'] = '<li class="list_style">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><a style="padding: 5px 7px;background: #009688;margin-right: 5px; margin-left:5px;color: #fff;" href="" class="current_page">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li class="list_style">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = 'Previous';
        $config['prev_tag_open'] = '<li class="list_style">';
        $config['prev_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="list_style">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="list_style">';
        $config['last_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $products = $this->ProductModel->get_issue_products($limit, $offset, $search, $count=false);
        $issue_product = array();
        $issue_product_list = array();

        foreach ($products as $product)
        {
            $issue_product['product_name'] = $product->product_name;
            $issue_product['size'] = $product->size;
            $issue_product['issuer_name'] = $product->issuer_name;
            $issue_product['issue_type'] = $this->issueType($product->issue_type);
            $issue_product['latest_quantity'] = $product->latest_quantity;
            $issue_product['issue_date'] = $product->issue_date;
            $issue_product_list[] = $issue_product;
        }

        $data['products'] = $issue_product_list;
        $data['pagelinks'] = $this->pagination->create_links();

        $this->load->view('front-end/issue-product-ajax', $data);
    }

    public function issueType($type)
    {
        if ($type == 'CSD_one'){
            return 'CSD - 1';
        }
        if ($type == 'WB_one'){
            return 'WB - 1';
        }
        if ($type == 'HB_one'){
            return 'HB - 1';
        }
        if ($type == 'CSD_two'){
            return 'CSD - 2';
        }
        if ($type == 'WB_two'){
            return 'WB - 2';
        }
        if ($type == 'HB_two'){
            return 'HB - 2';
        }
        if ($type == 'CSD_three'){
            return 'CSD - 3';
        }
        if ($type == 'WB_three'){
            return 'WB - 3';
        }
        if ($type == 'HB_three'){
            return 'HB - 3';
        }
        if ($type == 'CSD_four'){
            return 'CSD - 4';
        }
        if ($type == 'WB_four'){
            return 'WB - 4';
        }
        if ($type == 'HB_four'){
            return 'HB - 4';
        }
        if ($type == 'CSD_five'){
            return 'CSD - 5';
        }
        if ($type == 'WB_five'){
            return 'WB - 5';
        }
        if ($type == 'HB_five'){
            return 'HB - 5';
        }
        if ($type == 'CSD_six'){
            return 'CSD - 6';
        }
        if ($type == 'WB_six'){
            return 'WB - 6';
        }
        if ($type == 'HB_six'){
            return 'HB - 6';
        }else
        {
            return '';
        }
    }
    public function inventory_ajax($offset=null)
    {
        $search = array(
            'keyword' => trim($this->input->post('search_key')),
        );

        $this->load->library('pagination');

        $limit = 5;
        $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $config['base_url'] = site_url('DashboardController/inventory_ajax/');
        $config['total_rows'] = $this->ProductModel->get_inventory_products($limit, $offset, $search, $count=true);
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $config['num_links'] = 3;
        $config['num_tag_open'] = '<li class="list_style">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><a style="padding: 5px 7px;background: #009688;margin-right: 5px; margin-left:5px;color: #fff;" href="" class="current_page">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li class="list_style">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = 'Previous';
        $config['prev_tag_open'] = '<li class="list_style">';
        $config['prev_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="list_style">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="list_style">';
        $config['last_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $data['products'] = $this->ProductModel->get_inventory_products($limit, $offset, $search, $count=false);

        $data['pagelinks'] = $this->pagination->create_links();

        $this->load->view('front-end/inventory-ajax', $data);
    }

}
