<?php

class Vendors extends Admin_Controller {

    public function __construct() 
    {
        parent::__construct();
        $this->isLogged();
        $this->load->model('master');
        $this->load->model('Member_model','member');
    }

    public function index() 
    {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN . '/vendors';
        $this->data['rows'] = $this->member->getMembers(array('mem_type'=>'Vendor'));
        
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }
    function manage() 
    {
        $this->data['pageView'] = ADMIN . '/vendors';
        
        if ($this->input->post()) {

            $post = html_escape($this->input->post());

            $this->form_validation->set_message('integer', 'Please select a valid {field}');

            $this->form_validation->set_rules('mem_fname', 'First Name', 'trim|required|alpha|min_length[2]|max_length[20]', ['alpha'=> 'First Name should contains only letters and avoid space.', 'min_length'=> 'First Name should contains atleast 2 letters.', 'max_length'=> 'First Name should not be greater than 20 letters.']);
            $this->form_validation->set_rules('mem_lname', 'Last Name', 'trim|required|alpha|min_length[2]|max_length[20]', ['alpha'=> 'Last Name should contains only letters and avoid space.', 'min_length'=> 'Last Name should contains atleast 2 letters.', 'max_length'=> 'Last Name should not be greater than 20 letters.']);
            $this->form_validation->set_rules('mem_email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('mem_company_name', 'Company name', 'trim|required');
            $this->form_validation->set_rules('mem_company_email', 'Company email', 'trim|required|valid_email');
            $this->form_validation->set_rules('mem_company_phone', 'Company phone', 'trim|required');
            $this->form_validation->set_rules('mem_company_order_email', 'Company order email', 'trim|required|valid_email');
            $this->form_validation->set_rules('mem_company_website', 'Company website', 'trim|required');
            $this->form_validation->set_rules('mem_company_trustpilot', 'Trustpilot And Google Review URL', 'trim|required');
            $this->form_validation->set_rules('mem_company_pickdrop', 'Company Pickup & Drop', 'trim|required');
            $this->form_validation->set_rules('mem_company_walkin_facility', 'Company walk in facility', 'trim|required');
            if($post['mem_company_walkin_facility'] == 'yes')
            {
                $this->form_validation->set_rules('mem_business_country', 'Business country', 'trim|required');
                $this->form_validation->set_rules('mem_business_state', 'Business state', 'trim|required');
                $this->form_validation->set_rules('mem_business_city', 'Business city', 'trim|required');
                $this->form_validation->set_rules('mem_business_zip', 'Business zip', 'trim|required');
                $this->form_validation->set_rules('mem_business_address', 'Business address', 'trim|required');
            }
            if($post['mem_company_pickdrop'] == 'yes')
            {
                if (!empty($post['pickup_zip'])) {
                    $this->form_validation->set_rules('mem_map_lat', 'Pick Up', 'required',
                    array(
                        'required'  => 'You have not provided Correct Zip for %s.',
                    ));
                }
                $this->form_validation->set_rules('pickup_zip', 'Pickup and collection zip', 'trim|required');
                $this->form_validation->set_rules('mem_charges_per_miles', 'Charges per mils', 'trim|required');
                $this->form_validation->set_rules('mem_charges_free_over', 'Charges free over', 'trim|required');
                $this->form_validation->set_rules('mem_charges_min_order', 'Minimum order value', 'trim|required');
                // $this->form_validation->set_rules('mem_show_cancellation', 'Show cancellation policy', 'trim|required');
            }

            if ($this->form_validation->run() === FALSE){
                setMsg('error', validation_errors() );
                redirect(ADMIN . '/vendors/manage/'.$this->uri->segment(4), 'refresh');
            }else{
                $vals = $this->input->post();
                if (empty($this->uri->segment(4)))
                {
                    $mem_row = $this->member->emailExists($vals['mem_email']);
                    if(count($mem_row) > 0){
                        SetMsg('error', 'Email Already Exists' );
                        redirect(ADMIN . '/vendors/manage', 'refresh');
                    }
                }    
                
                $vals['mem_pswd']=doEncode($vals['mem_pswd'] );
                if (($_FILES["mem_image"]["name"] != "")) {
                    $this->remove_file($this->uri->segment(4), 'mem_image');
                    $image = upload_file(UPLOAD_PATH . 'members', 'mem_image');
                    if (!empty($image['file_name'])) {
                        $user_info['mem_image'] = $image['file_name'];
                        generate_thumb(UPLOAD_PATH . "members/", UPLOAD_PATH . "members/", $image['file_name'], 100, 'thumb_');
                        generate_thumb(UPLOAD_PATH . "members/", UPLOAD_PATH . "members/", $image['file_name'], 300, '300p_');
                    } else {
                        setMsg('error', 'Please upload a valid image file >> ' . strip_tags($image['error']));
                        redirect(ADMIN . '/vendors/manage/' . $this->uri->segment(4), 'refresh');
                    }
                }

                $rando = doEncode(rand(99, 999).'-'.$post['email']);
                $rando = strlen($rando) > 225 ? substr($rando, 0, 225) : $rando;

                $user_info['mem_type'] = 'vendor';
                $user_info['mem_code'] = $rando;
                $user_info['mem_verified'] = $vals['mem_verified'];
                $user_info['mem_status'] = $vals['mem_status'];
                $user_info['mem_featured'] = $vals['mem_featured'];
                $user_info['mem_fname'] = $vals['mem_fname'];
                $user_info['mem_lname'] = $vals['mem_lname'];
                $user_info['mem_pswd'] = $vals['mem_pswd'];
                $user_info['mem_email'] = $vals['mem_email'];
                $user_info['mem_company_name'] = $vals['mem_company_name'];
                $user_info['mem_company_email']= $vals['mem_company_email'];
                $user_info['mem_company_phone']= $vals['mem_company_phone'];
                $user_info['mem_company_order_email'] = $vals['mem_company_order_email'];
                $user_info['mem_company_website']= $vals['mem_company_website'];
                $user_info['mem_company_trustpilot']= $vals['mem_company_trustpilot'];
                $user_info['mem_company_pickdrop']= $vals['mem_company_pickdrop'];
                if($user_info['mem_company_pickdrop'] == 'yes'){
                    $user_info['pickup_zip']      = $post['pickup_zip'];
                    $user_info['mem_map_lat'] = $post['mem_map_lat'];
                    $user_info['mem_map_lng'] = $post['mem_map_lng'];
                    $user_info['mem_charges_per_miles'] = $post['mem_charges_per_miles'];
                    $user_info['mem_charges_free_over'] = $post['mem_charges_free_over'];
                    $user_info['mem_charges_min_order'] = $post['mem_charges_min_order'];
                    $user_info['mem_travel_radius']     = $post['mem_travel_radius'];
                }
                $user_info['mem_company_walkin_facility'] = $vals['mem_company_walkin_facility'];
                if($user_info['mem_company_walkin_facility'] == 'yes'){
                    $user_info['mem_business_country'] = $vals['mem_business_country'];
                    $user_info['mem_business_state']   = $vals['mem_business_state'];
                    $user_info['mem_business_city']    = $vals['mem_business_city'];
                    $user_info['mem_business_zip']     = $vals['mem_business_zip'];
                    $user_info['mem_business_address'] = $vals['mem_business_address'];

                    $facility_hours['mon_opening'] = $post['mon_opening'] == '' ? NULL : $post['mon_opening'];
                    $facility_hours['mon_closing'] = $post['mon_closing'] == '' ? NULL : $post['mon_closing'];
                    $facility_hours['tue_opening'] = $post['tue_opening'] == '' ? NULL : $post['tue_opening'];
                    $facility_hours['tue_closing'] = $post['tue_closing'] == '' ? NULL : $post['tue_closing'];
                    $facility_hours['wed_opening'] = $post['wed_opening'] == '' ? NULL : $post['wed_opening'];
                    $facility_hours['wed_closing'] = $post['wed_closing'] == '' ? NULL : $post['wed_closing'];
                    $facility_hours['thu_opening'] = $post['thu_opening'] == '' ? NULL : $post['thu_opening'];
                    $facility_hours['thu_closing'] = $post['thu_closing'] == '' ? NULL : $post['thu_closing'];
                    $facility_hours['fri_opening'] = $post['fri_opening'] == '' ? NULL : $post['fri_opening'];
                    $facility_hours['fri_closing'] = $post['fri_closing'] == '' ? NULL : $post['fri_closing'];
                    $facility_hours['sat_opening'] = $post['sat_opening'] == '' ? NULL : $post['sat_opening'];
                    $facility_hours['sat_closing'] = $post['sat_closing'] == '' ? NULL : $post['sat_closing'];
                    $facility_hours['sun_opening'] = $post['sun_opening'] == '' ? NULL : $post['sun_opening'];
                    $facility_hours['sun_closing'] = $post['sun_closing'] == '' ? NULL : $post['sun_closing'];
                }
                $mem_id = $this->member->save($user_info,$this->uri->segment(4));
                
                if($this->uri->segment(4)){
                    $facility_hours['mem_id'] = $this->uri->segment(4);
                }else{
                    $facility_hours['mem_id'] = $mem_id;
                }

                $this->master->save('mem_facility_hours', $facility_hours, 'mem_id', $this->uri->segment(4));
                setMsg('success', 'Vendor has been saved successfully.');
                redirect(ADMIN . '/vendors', 'refresh');
                    
            }
        }

        $this->data['row'] = $this->member->getMember($this->uri->segment('4'));
        $this->data['facility_hours'] = $this->master->get_data_row('mem_facility_hours', ['mem_id'=> $this->uri->segment('4')]);
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function active() 
    {
        $mem_id = $this->uri->segment(4);
        $vals['mem_status'] = '1';
        $this->member->save($vals,$mem_id);
        setMsg('success', 'Vendor has been activated successfully.');
        redirect(ADMIN . '/vendors', 'refresh');
    }
    function inactive() 
    {
        $mem_id = $this->uri->segment(4);
        $vals['mem_status'] = '0';
        $this->member->save($vals,$mem_id );

        setMsg('success', 'Vendor has been deactivated successfully.');
        redirect(ADMIN . '/vendors', 'refresh');
    }
    function verify() 
    {
        $mem_id = $this->uri->segment(4);
        $vals['mem_verified'] = '1';
        $this->member->save($vals,$mem_id);
        setMsg('success', 'Vendor has been verified successfully.');
        redirect(ADMIN . '/vendors', 'refresh');
    }
    function unverify() 
    {
        $mem_id = $this->uri->segment(4);
        $vals['mem_verified'] = '0';
        $this->member->save($vals,$mem_id );

        setMsg('success', 'Vendor has been unverified successfully.');
        redirect(ADMIN . '/vendors', 'refresh');
    }
    function delete() 
    {
        $this->remove_file($this->uri->segment(4));
        $this->member->delete($this->uri->segment('4'));
        $this->master->delete('mem_facility_hours','mem_id',$this->uri->segment('4'));
        setMsg('success', 'Vendor has been deleted successfully.');
        redirect(ADMIN . '/vendors', 'refresh');
    }

    function remove_file($id, $type = '') 
    {
        $arr = $this->member->getMember($id);
        $filepath = "./" . SITE_IMAGES . "/members/" . $arr->mem_image;
        $filepath_thumb = "./" . SITE_IMAGES . "/members/thumbnails/thumb_" . $arr->mem_image;
        $filepath_thumb2 = "./" . SITE_IMAGES . "/members/thumbnails/300p_" . $arr->mem_image;
        if (is_file($filepath)) {
            unlink($filepath);
        }
        if (is_file($filepath_thumb)) {
            unlink($filepath_thumb);
        }
        if (is_file($filepath_thumb2)) {
            unlink($filepath_thumb2);
        }
        return;
    }
}
?>