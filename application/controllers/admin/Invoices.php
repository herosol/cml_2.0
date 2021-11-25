<?php

class Invoices extends Admin_Controller {

    private $table_name = "order_invoices";

    public function __construct() {
        parent::__construct();
        $this->isLogged();
        has_access(3);
        $this->load->model('Master_model','master');
    }

    public function index() {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = 'admin/invoices';
        $this->data['rows'] = $this->master->getRows('order_invoices','','','','DESC','invoice_id');
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }
    function manage() {
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = 'admin/invoices';
        $this->data['row'] = $this->master->getRow($this->table_name, array('invoice_id' => $this->uri->segment(4)));
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }
    function changestatus($id){
        $this->data['row'] = $this->master->getRow($this->table_name, array('invoice_id' => $this->uri->segment(4)));
        $arr = $this->data['row'];
        
        if($arr->payment_status == 'paid'){
            $arr->payment_status = 'pending';
            
        }else if($arr->payment_status == 'pending'){
            $arr->payment_status = 'paid';
        }
        $this->master->save($this->table_name,$arr,'invoice_id', $this->uri->segment(4));
        setMsg('success', 'Status Changed successfully !');
        redirect(ADMIN . '/invoices', 'refresh');
    }
    function delete() {
        $this->master->delete($this->table_name, 'invoice_id', $this->uri->segment('4'));
        setMsg('success', 'Delete successfully !');
        redirect(ADMIN . '/invoices', 'refresh');
    }
    function deleteAll(){
        $ids = $this->input->post('checkbox_id');
        if(!empty($ids)){
            $delete=$this->master->delete($this->table_name,'invoice_id',$ids);
            setMsg('success', 'Deleted successfully !');
        }
        else{
            setMsg('error', 'Please Select atleast 1 Record !');
        }
        redirect(ADMIN . '/invoices', 'refresh');
    }
}

?>