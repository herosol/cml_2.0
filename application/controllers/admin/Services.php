<?php

class Services extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->isLogged();
    }

    public function index() {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN . '/services';

        $this->data['rows'] = $this->master->getRows('services');
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }
    function manage() {
        $this->data['enable_editor'] = TRUE;
        $this->data['settings'] = $this->master->getRow('siteadmin');
        $this->data['pageView'] = ADMIN . '/services';
         if ($this->input->post()) {
            $vals = $this->input->post();
            
            $content_row = $this->master->getRow('services', array('id'=>$this->uri->segment(4)));
           
            if($_FILES['image']['name'] != ""){
                
                $this->removeImage($this->uri->segment(4));
                $image = upload_file(UPLOAD_PATH.'services/', 'image');
                generate_thumb(UPLOAD_PATH.'services/',UPLOAD_PATH.'services/',$image['file_name'],600,'thumb_');
                $vals["image"] = $image["file_name"];
            }
            else{
                $vals['image'] = $content_row->image;
            }
            $id=$this->master->save('services',$vals,'id', $this->uri->segment(4));
            //print_r($id);die;
            if($id>0){
                //print_r($count_title);die;
                setMsg('success', 'Data has been saved successfully.');
                redirect(ADMIN . '/services', 'refresh');
                exit;
            }
        }
        $this->data['row'] = $this->master->getRow('services',array('id'=>$this->uri->segment('4')));
         $this->load->view(ADMIN . '/includes/siteMaster', $this->data);        
    }
    function changestatus($id){
        $content = $this->master->getRow('services', array('id'=>$id));
        if ($content->status == 1 ){
            $content->status = 0;
            $content->deleted_date = date('Y-m-d H:i:s');
        }
        else{
            $content->status = 1;
        }
        $id=$this->master->save('services',$content,'id', $id);
        setMsg('success', 'Status Changed !');
        redirect(ADMIN . '/services', 'refresh');
    }
    function delete() {
        $this->removeImage($this->uri->segment('4'));
        $this->master->delete('services', 'id', $this->uri->segment('4'));
        setMsg('success', 'Delete successfully !');
        redirect(ADMIN . '/services', 'refresh');
    }
    function deleteAll(){
        $ids = $this->input->post('checkbox_id');
        if(!empty($ids)){
            $this->master->delete('services','id',$ids);
            setMsg('success', 'Deleted successfully !');
        }
        else{
            setMsg('error', 'Please Select atleast 1 Record !');
        }
        redirect(ADMIN . '/services', 'refresh');
    }
    function removeImage($id){
        $row = $this->master->getRow('services',array('id'=>$id));
        $filename = "./".UPLOAD_PATH.'services/'.$row->image;
        if(is_file($filename)){
             unlink($filename);
        }
        return;
    }
}

?>