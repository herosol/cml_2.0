<?php

class Orders extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        $this->load->model('order_model');
        $this->load->model('OrderD_model', 'orderd_model');
        $this->load->model('master');
    }

    function index()
    {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN . '/orders';
        $this->data['rows'] = $this->order_model->get_admin_orders('', $start, $per_page, 'desc');
        // pr($this->data['rows']);
        $this->load->view(ADMIN.'/includes/siteMaster', $this->data);
    }

    function detail($id = 0)
    {
        $id = intval($id);
        if($this->data['row'] = $this->order_model->get_admin_order($id)){
            if ($this->input->post()) {
                $vals = $this->input->post();

                $mem_data = array('name' => format_name($this->data['row']->fname, $this->data['row']->lname), 'to_name' => $this->data['row']->fname, "email" => $this->data['row']->email, 'row' => $this->data['row']);
                if ($this->data['row']->status != $vals['status'] && $vals['status'] == 1) {
                    $mem_data['order_status'] = 'Cancelled';
                    // $mem_data['order_line'] = $vals['shipping_msg'];
                    send_site_email($mem_data, 'order', 'order');
                } elseif ($this->data['row']->status != $vals['status'] && $vals['status'] == 2) {
                    $mem_data['order_status'] = 'DELIVERED';
                    // $mem_data['order_line'] = 'Your order has been shipped and you can start tracking your order';
                    send_site_email($mem_data, 'order', 'order');
                }

               
                $this->order_model->save($vals, $id);
                setMsg('success', 'Order status has been saved successfully.');
                redirect(ADMIN . '/Orders/detail/'.$id, 'refresh');
                exit;
            }
            // pr($this->data['row']->vendor_id);
            $this->data['row']->products = $this->order_model->get_detail($id);
            $this->data['buyer'] = $this->master->getRow('members',array('mem_id'=>$this->data['row']->buyer_id));
            $this->data['vendor'] = $this->master->getRow('members',array('mem_id'=>$this->data['row']->vendor_id));
            $this->data['pageView'] = ADMIN . '/orders';
            $this->load->view(ADMIN . '/includes/siteMaster',$this->data);
        }
        else
            show_404();
    }
}

?>