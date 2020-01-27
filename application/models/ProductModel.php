<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductModel extends CI_Model
{
    public function InsertData($tableName,$data)
    {
        $this->db->insert($tableName, $data);

        return $this->db->insert_id();
    }
    public function GetRow($tableName,$condition)
    {
        $this->db->select('*');
        $this->db->from($tableName);
        $this->db->where($condition);
        $this->db->order_by("id", "DESC");
        $query = $this->db->get();
        return $query->row();
    }
    public function GetArray($tableName,$condition='')
    {
        $this->db->select('*');
        $this->db->from($tableName);
        if (!empty($condition))
        {
            $this->db->where($condition);
        }
        $this->db->order_by("id", "DESC");
        $query = $this->db->get();
        return $query->result_array();
    }
    public function updateData($tableName,$condition,$data)
    {
        $this->db->set($data, FALSE);
        $this->db->where($condition);
        $result = $this->db->update($tableName);
        if ($result)
        {
            return true;
        }else
        {
            return false;
        }
    }
    public function GetDistinctArray()
    {
        $this->db->select('product_entry.id,product_entry.vendor_name');
        $this->db->from('product_entry');
        $this->db->group_by('product_entry.vendor_name');
        $this->db->order_by("id", "DESC");
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getSearch($product_name,$product_size)
    {
        $this->db->select('*');
        $this->db->from('total_quantity');
        if (!empty($product_name))
        {
            $this->db->like('product_name', $product_name,'both');
        }
        if (!empty($product_size))
        {
            $this->db->where('size', $product_size);
        }
        $this->db->order_by("id", "DESC");
        $this->db->limit(5);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function GetInventoryProduct($tableName,$condition)
    {
        $this->db->select('*');
        $this->db->from($tableName);
        $this->db->where($condition);
        $this->db->order_by("id", "DESC");
        $query = $this->db->get();
        return $query->row();
    }

 public function get_products($limit, $offset, $search, $count)
    {
		 
        $this->db->select('*');
        $this->db->from('product_entry');
        if($search){
            $keyword = $search['keyword'];
            if($keyword){
                $this->db->where("product_name LIKE '%$keyword%'");
            }
        }
        if($count){
            return $this->db->count_all_results();
        }
        else {
            $this->db->limit($limit, $offset);
            $this->db->order_by("id", "DESC");
            $query = $this->db->get();

            if($query->num_rows() > 0) {
                return $query->result();
            }
        }

        return array();
    }
    public function get_inventory_products($limit, $offset, $search, $count)
    {
        $this->db->select('*');
        $this->db->from('inventory');
        if($search){
            $keyword = $search['keyword'];
            if($keyword){
                $this->db->where("name LIKE '%$keyword%'");
            }
        }
        if($count){
            return $this->db->count_all_results();
        }
        else {
            $this->db->limit($limit, $offset);
            $this->db->order_by("id", "DESC");
            $query = $this->db->get();

            if($query->num_rows() > 0) {
                return $query->result();
            }
        }

        return array();
    }
    public function get_products_quantity($limit, $offset, $search, $count)
    {
        $this->db->select('*');
        $this->db->from('total_quantity');
        if($search){
            $keyword = $search['keyword'];
            if($keyword){
                $this->db->where("product_name LIKE '%$keyword%'");
            }
        }
        if($count){
            return $this->db->count_all_results();
        }
        else {
            $this->db->limit($limit, $offset);
            $this->db->order_by("id", "DESC");
            $query = $this->db->get();

            if($query->num_rows() > 0) {
                return $query->result();
            }
        }

        return array();
    }
    public function get_issue_products($limit, $offset, $search, $count)
    {
        $this->db->select('*');
        $this->db->from('issue_product');
        if($search){
            $keyword = $search['keyword'];
            if($keyword){
                $this->db->where("product_name LIKE '%$keyword%'");
                $this->db->or_where("issuer_name LIKE '%$keyword%'");
            }
        }
        if($count){
            return $this->db->count_all_results();
        }
        else {
            $this->db->limit($limit, $offset);
            $this->db->order_by("id", "DESC");
            $query = $this->db->get();

            if($query->num_rows() > 0) {
                return $query->result();
            }
        }

        return array();
    }
}
