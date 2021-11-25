<?php

class Blogs extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->isLogged();
        // $this->load->model('newsletter_model');
        has_access(10);
    }

    public function index() {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN . '/blogs';
        $this->data['blogs'] = $this->master->get_data_rows('blogs');
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function manage() {
        $this->data['enable_editor'] = TRUE;
        $this->data['settings'] = $this->master->get_data_row('siteadmin');
        $this->data['pageView'] = ADMIN . '/blogs';
         if ($this->input->post()) {
            $vals = html_escape($this->input->post());
            $content_row = $this->master->get_data_row('blogs', array('id'=>$this->uri->segment(4)));
            if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] != "") {
                $image1 = upload_file(UPLOAD_PATH.'blogs/', 'image');
                generate_thumb(UPLOAD_PATH.'blogs/' , UPLOAD_PATH.'blogs/thumbs/', $image1['file_name'], 500);
                generate_thumb(UPLOAD_PATH.'blogs/' , UPLOAD_PATH.'blogs/large/', $image1['file_name'], 850);
                $vals['image']=$image1['file_name'];
            }
            else{
                $vals['image']=$content_row->image;
            }
            $created_date="";
            if(empty($content_row->created_date)){
                $created_date=date('Y-m-d h:i:s');
            }
            else{
                $created_date=$content_row->created_date;
            }
            //pr($image1);
            //$categories=implode(",",$vals['categories']);
            $values=array(
                'title'=>$vals['title'],
                'description'=>$vals['description'],
                'meta_title'=>$vals['meta_title'],
                'meta_keywords'=>$vals['meta_keywords'],
                'meta_description'=>$vals['meta_description'],
                'status'=>$vals['status'],
                'image'=>$vals['image'],
                'created_date'=>$created_date,
            );
            $id = $this->master->save('blogs', $values, 'id', $this->uri->segment(4));
            //print_r($id);die;
            if($id > 0){
                setMsg('success', 'Blog has been saved successfully.');
                redirect(ADMIN . '/blogs', 'refresh');
                exit;
            }
        }
        $this->data['row'] = $this->master->get_data_row('blogs',array('id'=>$this->uri->segment('4')));
         $this->load->view(ADMIN . '/includes/siteMaster', $this->data);        
    }

    function add_category(){
        $data=$this->input->post();
        $res=array();
        if(empty($data['cat_name'])){
            $res['status']=false;
            $res['empty']=true;
            echo json_encode($res);
        }
        else{
            $vals=array(
                'name'=>$data['cat_name']
            );
            $q=$this->master->save("categories",$vals);
            if($q>0){
                $res['status']=true;
                $res['success']=true;
                $res['cat_id']=$q;
            }
            else{
                 $res['status']=false; 
                 $res['fail']=false;  
            }
            echo json_encode($res);
        }
    }	
    
    function delete()
    {
        has_access(17);
        $this->master->delete('blogs','id', $this->uri->segment(4));
        setMsg('success', 'Blog has been deleted successfully.');
        redirect(ADMIN . '/Blogs', 'refresh');
    }
}

?>