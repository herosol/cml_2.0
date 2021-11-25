<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class OrderD_model extends CRUD_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table_name = "order_detail";
        $this->field = "id";
    }

    function order_amended_price($order_id)
    {
        $this->db->from($this->table_name);
        $this->db->select('SUM(quantity*sub_service_price) as price');
        $this->db->where(['order_id'=> $order_id, 'service_type'=> 'amended']);
        return $this->db->get()->row()->price;
    }

}