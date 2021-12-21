<?php

class Dashboard extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        $this->load->model('Withdraw_model', 'withdraw_model');
    }
    
    public function index()
    {
        $this->data['pageView']  = ADMIN."/dashboard";
        $this->data['dashboard'] = "1";
        $this->data['completed_orders']   = intval($this->master->num_rows('orders', ['order_status'=>'Completed']));
        $this->data['inprogress_orders']  = intval($this->master->num_rows('orders', ['order_status'=>'In Progress']));
        $this->data['total_transactions'] = intval($this->master->num_rows('order_invoices', ['payment_status'=>'paid']));
        $this->data['total_payouts']      = intval($this->master->num_rows('withdraws', ['status'=>'completed']));
        $this->data['payouts_amount']     = intval($this->withdraw_model->admin_total_payouts_amount());
        $this->data['total_contact_msgs'] = intval($this->master->num_rows('contact'));
        $this->data['total_buyers']       = intval($this->master->num_rows('members', ['mem_type'=>'buyer']));
        $this->data['total_vendors']      = intval($this->master->num_rows('members', ['mem_type'=>'vendor']));
        $this->load->view(ADMIN.'/includes/siteMaster', $this->data);
    }
    
}

?>  