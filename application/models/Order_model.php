<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order_model extends CRUD_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table_name = "orders";
        $this->field = "order_id";
    }

    function get_buyer_orders($where = null)
    {
        $this->db->from($this->table_name.' o');
        $this->db->join('members m', 'o.vendor_id=m.mem_id');
        $this->db->select('o.*, m.mem_image, m.mem_company_phone');
        if($where !== null)
            $this->db->where($where);
        $this->db->where(['o.buyer_id'=> $this->session->mem_id, 'o.paypal_pending'=> 'no']);
        $this->db->group_by('o.order_id');
        $this->db->order_by('o.order_id', 'DESC');
        return $this->db->get()->result();
    }


    function mem_review($order_id)
    {
        $this->db->from($this->table_name.' o');
        $this->db->join('reviews r', 'o.order_id=r.order_id');
        $this->db->join('members m', 'o.buyer_id=m.mem_id');
        $this->db->select('r.*, m.mem_image, m.mem_fname, m.mem_lname');
        $this->db->where(['r.order_id'=> $order_id]);
        return $this->db->get()->row(); 
    }

    function buyer_order_detail($order_id)
    {
        $this->db->from($this->table_name.' o');
        $this->db->join('order_detail od', 'o.order_id=od.order_id');
        $this->db->select(' od.*');
        $this->db->where(['o.order_id'=> $order_id]);
        return $this->db->get()->row();
    }
    function get_vendor_orders($where = null)
    {
        $this->db->from($this->table_name.' o');
        $this->db->join('members m', 'o.buyer_id=m.mem_id');
        $this->db->select('o.*, m.mem_fname, m.mem_lname');
        if($where !== null)
            $this->db->where($where);
        $this->db->where(['o.vendor_id'=> $this->session->mem_id, 'o.paypal_pending'=> 'no']);
        $this->db->group_by('o.order_id');
        $this->db->order_by('o.order_id', 'DESC');
        return $this->db->get()->result();
    }

    function vendor_order_detail($order_id)
    {
        $this->db->from($this->table_name.' o');
        $this->db->join('members m', 'o.buyer_id=m.mem_id');
        $this->db->select('o.*, m.mem_fname, m.mem_lname, m.mem_email, m.mem_phone');
        $this->db->where(['o.order_id'=> $order_id]);
        return $this->db->get()->row();
    }


    function get_admin_orders()
    {
        $this->db->select("o.*,
         @product_total := IFNULL((select sum(quantity*sub_service_price) from tbl_order_detail where order_id = o.order_id), 0) as product_total, count(od.id) as product_count", FALSE);
        $this->db->from($this->table_name.' o');
        $this->db->join('order_detail od', 'od.order_id = o.order_id');
        $this->db->group_by('o.order_id');
        $query = $this->db->get();
        return $query->result();
    }

    function get_admin_order($oid)
    {

        $this->db->select("o.* ,
         @product_total := IFNULL((select sum(quantity*sub_service_price) from tbl_order_detail where order_id = o.order_id), 0) as product_total, count(od.id) as product_count", FALSE);
        $this->db->from($this->table_name.' o');
        $this->db->join('order_detail od', 'od.order_id = o.order_id');
        $this->db->where('o.order_id', $oid);
        $this->db->group_by('o.order_id');
        $query = $this->db->get();
        return $query->row();
    }

    function get_latest_order()
    {
        $this->db->from($this->table_name.' o');
        $this->db->join('members b', 'o.buyer_id=b.mem_id');
        $this->db->select('o.*, b.mem_image');
        $this->db->where(['o.vendor_id' => $this->session->mem_id, 'o.paypal_pending'=> 'no']);
        $this->db->order_by('o.order_id', 'DESC');
        $this->db->limit(1);
        return $this->db->get()->row();
    }

    function vendor_today_sales()
    {
        $this->db->from($this->table_name);
        $this->db->select('order_id');
        $this->db->where(['vendor_id'=> $this->session->mem_id, 'order_status'=> 'Completed', 'completed_date'=> TODAY_DATE]);
        $order =  $this->db->get()->row();

        if(empty($order))
        {
            return '0.00';
        }
        else
        {
            return order_total_price($order->order_id);
        }
    }

    function vendor_week_sales()
    {

        $this->db->from($this->table_name);
        $this->db->select('*');
        $this->db->where(['vendor_id'=> $this->session->mem_id, 'order_status'=> 'Completed', 'completed_date <=' => TODAY_DATE, 'completed_date >=' => THIS_WEEK_FIRST_DATE]);
        $orders = $this->db->get()->result();

        $total = 0;
        foreach($orders as $order)
        {
            $total += order_total_price($order->order_id);
        }

        return (object) ['total_sales'=> count($orders), 'total'=> number_format($total)];
    }
    
    function vendor_month_sales()
    {
        $this->db->from($this->table_name);
        $this->db->select('*');
        $this->db->where(['vendor_id'=> $this->session->mem_id, 'order_status'=> 'Completed', 'completed_date<=' => TODAY_DATE, 'completed_date>=' => THIS_MONTH_FIRST_DATE]);
        $orders = $this->db->get()->result();

        $total = 0;
        foreach($orders as $order)
        {
            $total += order_total_price($order->order_id);
        }

        return (object) ['total_sales'=> count($orders), 'total'=> number_format($total)];
    }

    function buyer_transactions()
    {
        $this->db->from($this->table_name);
        $this->db->select('*');
        $this->db->where(['buyer_id'=> $this->session->mem_id]);
        $this->db->order_by('order_id', 'DESC');
        $orders = $this->db->get()->result();

        $transactions = [];
        $total_used_balance = 0;
        foreach($orders as $index => $order):
            $order_amount = buyer_transaction_price($order->order_id);
            $total_used_balance += $order_amount;
            $transactions[] = (object)
            [
                'order_id'    => $order->order_id,
                'vendor_name' => get_mem_name($order->vendor_id), 
                'amount'      => $order_amount, 
                'date'        => date_picker_format_date($order->order_date, 'D, d M Y', false)
            ];
        endforeach;

        return ['transactions'=> (object)$transactions, 'total_used_balance'=> $total_used_balance];
    }

    function get_order_total($oid)
    {
        $this->db->select("o.* ,
         @product_total := IFNULL((select sum(quantity*sub_service_price) from tbl_order_detail where order_id = o.order_id), 0) as product_total, count(od.id) as product_count", FALSE);
        $this->db->from($this->table_name.' o');
        $this->db->join('order_detail od', 'od.order_id = o.order_id');
        $this->db->where('o.order_id', $oid);
        $this->db->group_by('o.order_id');
        $row = $this->db->get()->row();
        return floatval($row->total_sub_service_price);
    }

    function get_mem_orders($mem_id, $start = '', $offset = '', $order_by = 'desc')
    {
        $this->db->select("o.*,
         @product_total := IFNULL((select sum(quantity*sub_service_price) from tbl_order_detail where order_id = o.order_id), 0) as product_total, count(od.id) as product_count", FALSE);
        $this->db->from($this->table_name.' o');
        $this->db->join('order_detail od', "o.order_id = od.order_id");
        $this->db->join('sub_services p', "p.id = od.sub_service_id");
        $this->db->where('o.mem_id', $mem_id);
        // $this->db->where('o.status', 2);
        $this->db->group_by('o.order_id');

        if (!empty($order_by))
            $this->db->order_by("o.order_id", $order_by);
        if (!empty($offset))
            $this->db->limit($offset, $start);

        $query = $this->db->get($this->table_name);
        $rows = array();
        foreach ($query->result() as $key => $row) {
            $row->products = $this->get_detail($row->id);
            $rows[$key] = $row;
        }
        return $rows;
    }

    function get_mem_order($mem_id, $order_id)
    {
        $this->db->select("o.*, concat(m.mem_fname, ' ', m.mem_lname) as mem_name, m.mem_fname,
         @product_total := IFNULL((select sum(quantity*sub_service_price) from tbl_order_detail where order_id = o.order_id), 0) as product_total, count(od.id) as product_count", FALSE);
        $this->db->from($this->table_name.' o');
        $this->db->join('order_detail od', "o.order_id = od.order_id");
        $this->db->join('sub_services p', "p.id = od.sub_service_id");
        $this->db->join('members m', 'm.mem_id = o.mem_id');
        $this->db->where('o.mem_id', $mem_id);
        $this->db->where('o.order_id', $order_id);
        $this->db->group_by('o.order_id');
        
        $query = $this->db->get();
        $row = $query->row();
        if($row)
            $row->products = $this->get_detail($row->id);
        return $row;
    }

    function get_order($order_id)
    {
        $this->db->select("o.*,
         @product_total := IFNULL((select sum(quantity*sub_service_price) from tbl_order_detail where order_id = o.order_id), 0) as product_total, count(od.id) as product_count", FALSE);
        $this->db->from($this->table_name.' o');
        $this->db->join('order_detail od', "o.order_id = od.order_id");
        $this->db->join('sub_services p', "p.id = od.sub_service_id");
        $this->db->where('o.order_id', $order_id);
        $this->db->group_by('o.order_id');
        
        $query = $this->db->get();
        $row = $query->row();
        if($row)
            $row->products = $this->get_detail($row->id);
        return $row;
    }

    function get_mem_recent_order($mem_id)
    {
        $this->db->select('o.*');
        $this->db->from($this->table_name.' o');
        $this->db->join('order_detail od', "o.order_id = od.order_id");
        $this->db->join('sub_services p', "p.id = od.sub_service_id");
        $this->db->where('o.mem_id', $mem_id);
        $this->db->where('o.status<>', 2);
        $this->db->group_by('o.order_id');
        $this->db->order_by('od.id', 'desc');
        $this->db->limit(1);
        
        $query = $this->db->get();
        // die($this->db->last_query());
        $row = $query->row();
        if($row)
            $row->products = $this->get_detail($row->id);
        return $row;
    }

    function total_mem_orders($mem_id = 0)
    {
        $this->db->select('o.*');
        $this->db->from($this->table_name.' o');
        $this->db->join('order_detail od', "o.order_id = od.order_id");
        $this->db->join('sub_services p', "p.id = od.sub_service_id");
        $this->db->where('p.mem_id', $mem_id);
        $this->db->group_by('o.order_id');
        $query = $this->db->get();

        return intval($query->num_rows());
    }

    function get_mem_order_detail($mem_id, $order_id)
    {
        $this->db->select('od.*, name, details, service_id');
        $this->db->from('order_detail od ');
        $this->db->join('sub_services p', "p.id = od.sub_service_id");
        $this->db->where('order_id', $order_id);
        $this->db->where('p.mem_id', $mem_id);

        $query = $this->db->get();
        return $query->result();
    }



    function get_detail($order_id)
    {
        $this->db->select('od.*, name, details, service_id');
        $this->db->from('order_detail od');
        $this->db->join('sub_services p', "p.id = od.sub_service_id");
        $this->db->where('order_id', $order_id);
        $this->db->order_by('od.id', 'ASC');
        $query = $this->db->get();
        return $query->result();

    }

    function delete_detail($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('order_detail');
    }

    function save_detail($vals, $id = '')
    {
        $this->db->set($vals);
        if ($id != '') {
            $this->db->where('id', $id);
            $this->db->update('order_detail');
            return $id;
        } else {
            $this->db->insert('order_detail');
            return $this->db->insert_id();
        }
    }
}