<?php

class Delivery_proof extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        $this->load->model('master');
    }

    function index()
    {
        $type= $this->uri->segment(2);
        // pr($type);
        if($type == 'accepted-proof'){
            $this->data['rows'] = $this->master->getRows('order_delivery_proof', array('status'=>'accepted'));
        }else if($type == 'pending-proof'){
            $this->data['rows'] = $this->master->getRows('order_delivery_proof', array('status'=>'pending'));
        }else if($type == 'rejected-proof'){
            $this->data['rows'] = $this->master->getRows('order_delivery_proof', array('status'=>'rejected'));

        }
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN . '/delivery_proof';
        
        // pr($this->data['rows']);
        $this->load->view(ADMIN.'/includes/siteMaster', $this->data);
    }

    function manage()
    {
        $id = $this->uri->segment(4);
        if($this->data['row'] = $this->master->getRow('order_delivery_proof',array('proof_id'=>$id))){
            if ($this->input->post()) {
                $vals = $this->input->post();

                $this->master->save('order_delivery_proof',$vals,'proof_id', $id);
                setMsg('success', 'Delivery Proof status has been changed successfully.');
                redirect(ADMIN . '/delivery_proof/manage/'.$id, 'refresh');
                exit;
            }
            // pr($this->data['row']->vendor_id);
            $this->data['pageView'] = ADMIN . '/delivery_proof';
            $this->load->view(ADMIN . '/includes/siteMaster',$this->data);
        }
        else
            show_404();
    }
}

?>