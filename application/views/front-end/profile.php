<main class="app-content">
    <div class="row user">
        <div class="col-md-12">
            <div class="profile">
                <div class="info"><img class="user-img" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/128.jpg">
                    <h4><?= $user->first_name.' '.$user->last_name?></h4>
                    <p><?= $user->username?></p>
                </div>
                <div class="cover-image"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="tile p-0">
                <ul class="nav flex-column nav-tabs user-tabs">
                    <li class="nav-item"><a class="nav-link active" href="#user-timeline" data-toggle="tab">Timeline</a></li>
                    <li class="nav-item"><a class="nav-link" href="#user-settings" data-toggle="tab">Settings</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <div class="tab-content">
                <div style="text-align: center;">  <?php echo validation_errors(); ?> </div>
                <?php if ($error = $this->session->flashdata('success_message')): ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="alert alert-success">
                                <?= $error;?>
                            </div>
                        </div>
                    </div>
                <?php endif;?>
                <div class="tab-pane active" id="user-timeline">
                        <div class="tile">
                            <h3 class="tile-title">Product List</h3>
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered" id="sampleTable">
                                    <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Size</th>
                                        <th>Unit Price</th>
                                        <th>Amount</th>
                                        <th>Date of product</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (isset($entry_product)){?>
                                        <?php foreach($entry_product as $entry_product_value){?>
                                            <tr>
                                                <td><?= $entry_product_value['product_name']?></td>
                                                <td><?= $entry_product_value['product_quantity']?></td>
                                                <td><?= $entry_product_value['size']?></td>
                                                <td><?= $entry_product_value['unit_price']?></td>
                                                <td><?= $entry_product_value['amount']?></td>
                                                <td><?= $entry_product_value['entry_date']?></td>
                                                <td><a class="btn btn-primary text-white entry_edit" href="<?= base_url('single-product/')?><?= $entry_product_value['id']?>" entry_id="<?= $entry_product_value['id']?>">Details</a></td>
                                            </tr>
                                        <?php }?>
                                    <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>
                <div class="tab-pane fade" id="user-settings">
                    <div class="tile user-settings">
                        <h4 class="line-head">Settings</h4>
                        <form method="post" action="<?= base_url('update-profile')?>">
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label>First Name</label>
                                    <input class="form-control" type="text" name="first_name" value="<?= $user->first_name?>">
                                    <input class="form-control" type="hidden" name="id" value="<?= $user->id?>">
                                </div>
                                <div class="col-md-4">
                                    <label>Last Name</label>
                                    <input class="form-control" type="text" name="last_name" value="<?= $user->last_name?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 mb-4">
                                    <label>Email</label>
                                    <input class="form-control" type="text" disabled name="email_address" value="<?= $user->email?>">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label>Password</label>
                                    <input class="form-control" type="password" name="password">
                                </div>
                                <div class="col-md-4">
                                    <label>Confirm Password</label>
                                    <input class="form-control" type="password" name="confirm_password">
                                </div>
                            </div>
                            <div class="row mb-10">
                                <div class="col-md-12">
                                    <button class="btn btn-primary" type="submit" id="profile_btn"><i class="fa fa-fw fa-lg fa-check-circle"></i> Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!--<script>-->
<!--    $("#profile_btn").click(function () {-->
<!--        var data = $('#profile_form').serialize();-->
<!---->
<!--        $.ajax({-->
<!--            method: 'POST',-->
<!--            url: '--><?php //echo base_url("update-profile") ?>
<!--//            data: data,-->
<!--//            dataType: 'json',-->
<!--//            success: function(response){-->
<!--//                if (response.success == true)-->
<!--//                {-->
<!--//                    var text = response.msg;-->
<!--//                    showMessage(text);-->
<!--//                }else-->
<!--//                {-->
<!--//                    var text = response.msg;-->
<!--//                    showMessage(text);-->
<!--//                }-->
<!--//-->
<!--//                // document.location.reload(true);-->
<!--//            },-->
<!--//            error: function(){-->
<!--//                alert('Could not add data');-->
<!--//            }-->
<!--//        });-->
<!--//    });-->
<!--//-->
<!--//    function showMessage(text) {-->
<!--//        swal({-->
<!--//            title: "Profile Update",-->
<!--//            text: text,-->
<!--//            type: "success",-->
<!--//            showCancelButton: true,-->
<!--//            //confirmButtonText: "Admin Message",-->
<!--//            //cancelButtonText: "Cancel",-->
<!--//            closeOnConfirm: false,-->
<!--//            closeOnCancel: false-->
<!--//        })-->
<!--//    };-->
<!--//</script>-->