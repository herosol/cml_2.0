<?php

class Sub_services extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->isLogged();
    }

    public function index() {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN . '/sub_services';

        $this->data['rows'] = $this->master->getRows('sub_services');
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }
    function manage() {
        $this->data['enable_editor'] = TRUE;
        $this->data['settings'] = $this->master->getRow('siteadmin');
        $this->data['pageView'] = ADMIN . '/sub_services';
         if ($this->input->post()) {
            $vals = $this->input->post();
            
            $content_row = $this->master->getRow('sub_services', array('id'=>$this->uri->segment(4)));
           
            
            $id=$this->master->save('sub_services',$vals,'id', $this->uri->segment(4));
            //print_r($id);die;
            if($id>0){
                //print_r($count_title);die;
                setMsg('success', 'Data has been saved successfully.');
                redirect(ADMIN . '/sub_services', 'refresh');
                exit;
            }
        }
        $this->data['row'] = $this->master->getRow('sub_services',array('id'=>$this->uri->segment('4')));
         $this->load->view(ADMIN . '/includes/siteMaster', $this->data);        
    }
    function changestatus($id){
        $content = $this->master->getRow('sub_services', array('id'=>$id));
        if ($content->status == 1 ){
            $content->status = 0;
            $content->deleted_date = date('Y-m-d H:i:s');
        }
        else{
            $content->status = 1;
        }
        $id=$this->master->save('sub_services',$content,'id', $id);
        setMsg('success', 'Status Changed !');
        redirect(ADMIN . '/sub_services', 'refresh');
    }
    function delete() {
        $this->removeImage($this->uri->segment('4'));
        $this->master->delete('sub_services', 'id', $this->uri->segment('4'));
        setMsg('success', 'Delete successfully !');
        redirect(ADMIN . '/sub_services', 'refresh');
    }
    function deleteAll(){
        $ids = $this->input->post('checkbox_id');
        if(!empty($ids)){
            $this->master->delete('sub_services','id',$ids);
            setMsg('success', 'Deleted successfully !');
        }
        else{
            setMsg('error', 'Please Select atleast 1 Record !');
        }
        redirect(ADMIN . '/sub_services', 'refresh');
    }
}

?>