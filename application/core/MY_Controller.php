<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Controller extends CI_Controller {

    public $data = array();

    public function __construct() {
        parent::__construct();
        $this->data['site_settings'] = $this->getSiteSettings();
        $this->data['mem_data']      = $this->getActiveMem();
        $this->data['page']          = $this->uri->segment(1);
        $this->check_proofs();
    }

    public function isMemLogged($type, $is_verified = true, $route_check = '', $type_arr = array('buyer', 'vendor'))
    {
        if (intval($this->session->mem_id) < 1 || !$this->session->has_userdata('mem_type') || $this->session->mem_type != $type) 
        {
            $remember_cookie = $this->input->cookie('cml_remember');
            if($remember_cookie && $row = $this->master->getRow('members', array('mem_remember' => $remember_cookie)))
            {
                $this->session->set_userdata('mem_id', $row->mem_id);
                $this->session->set_userdata('mem_type', $row->mem_type);

            }else{
                $this->session->set_userdata('redirect_url', currentURL());
                redirect('signin', 'refresh');
                exit;
            }

        }
        # CHECK USER TYPE IF EXIST
        $this->type_logged_checked($type_arr);

        # IF USER EMAIL VERIFIED
        if($is_verified)
            $this->is_verified();

        # IF ROUTE ACCESSIBLE
        if(!empty($route_check))
            $this->if_route_accessible($route_check);
    }

    private function check_proofs(){
		$proofs = $this->master->getRows('order_delivery_proof',array('status'=>'pending'));
		// pr($proofs);
		
			
        $days=$this->data['site_settings']->site_accept_days;
        $email_days=$days-1;
		foreach( $proofs as $proof){
			$current_date=date('Y-m-d H:i:s');
			$added_date = $proof->date;
            $date = strtotime($added_date);
            $email_date = strtotime("+$email_days day", $date);
            $email_date = date('Y-m-d H:i:s', $email_date);
            $accept_date = strtotime("+".$days." day", $date);
            $accept_date = date('Y-m-d H:i:s', $accept_date);
			$email_date = str_replace('/', '-', $email_date);
    		$accept_date = str_replace('/', '-', $accept_date);
    		$current_date = str_replace('/', '-', $current_date);
			$email_date = new DateTime($email_date);
			$accept_date = new DateTime($accept_date);
			$current_date = new DateTime($current_date);
            // pr($email_date->format('Y-m-d H:i:s'));
			if ($current_date->format('Y-m-d H:i:s')>=$email_date->format('Y-m-d H:i:s') && $current_date->format('Y-m-d H:i:s') < $accept_date->format('Y-m-d H:i:s')) {
			    $email = $this->master->getRow('email_logs',array('proof_id'=>$proof->proof_id));
                if(empty($email)){
                    $ebody = $this->send_proof_mail(doEncode($proof->proof_id));
                    if($ebody != 0){
                        $vals = array(
                            'proof_id' => $proof->proof_id,
                            'ebody' => $ebody,
                        );
                        $this->master->save('email_logs',$vals);
                    }
                }
                
			}else if($current_date->format('Y-m-d H:i:s')>=$accept_date->format('Y-m-d H:i:s')){
                $vals = array(
                    'status' => 'accepted'
                );
                $this->master->save('order_delivery_proof',$vals,'proof_id',$proof->proof_id);
            }else{
                
            }
			
		}
			
	}
    function send_proof_mail($proof_id)
    {
        $proof_id = doDecode($proof_id);
        $proof = $this->master->getRow('order_delivery_proof',array('proof_id'=>$proof_id));
        $order = $this->master->getRow('orders',array('order_id'=>$proof->order_id));
        $settings = $this->data['site_settings'];
        
        $name = $mem_data['name'];
        
        $msg_body = "<h4 style='text-align:left;padding:0px 20px;margin-bottom:0px;'>Hi " . $order->buyer_fname . ' ' . $order->buyer_fname . ",</h4>
        <p style='text-align:left;padding:5px 20px;'>A Delivery Proof is send to your profile. Please respond to it.</p>
        <p style='text-align:left;padding:5px 20px;'>If you didn;t respond , it will be automatically accepted after 24 Hours.</p>";
        eval("\$msg_body = \"$msg_body\";");
        
        $emailto = $order->buyer_email;
        $subject = $settings->site_name." - Delivery Proof";
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html;charset=utf-8\r\n";
        $headers .= "From: " . $settings->site_name . " <" . $settings->site_email . ">" . "\r\n";
        $headers .= "Reply-To: " . $settings->site_name . " <" . $settings->site_email . ">" . "\r\n";

        $this->data['email_body'] = $msg_body;
        $this->data['email_subject'] = $subject;
        $ebody = $this->load->view('includes/email_template', $this->data, TRUE);
        // pr($ebody);
        if (@mail($emailto, $subject, $ebody, $headers)) {
            return $ebody;
        } else {
            return 0;
        }
    }

    public function type_logged_checked($type_arr) {
        if ($this->session->mem_type && !in_array($this->session->mem_type, $type_arr)) 
        {
            redirect('sigin', 'refresh');
            exit;
        }
    }

    function is_verified()
    {
        if(empty($this->data['mem_data']->mem_verified) || $this->data['mem_data']->mem_verified == 0) 
        {
            redirect($this->session->mem_type.'/dashboard', 'refresh');
            exit;
        }
    }

    function if_route_accessible($route)
    {
        if($this->session->mem_type != $route)
        {
            redirect($this->session->mem_type.'/dashboard', 'refresh');
        }
    }

    public function MemLogged()
    {
        $remember_cookie = $this->input->cookie('cml_remember');
        if($remember_cookie && $row = $this->master->getRow('members', array('mem_remember' => $remember_cookie)))
        {
            $this->session->set_userdata('mem_id', $row->mem_id);
            $this->session->set_userdata('mem_type', $row->mem_type);
            redirect($this->session->mem_type.'/dashboard', 'refresh');
            exit;
        }
        elseif (($this->session->mem_id > 0) && $this->session->has_userdata('mem_type'))
        {
            redirect($this->session->mem_type.'/dashboard', 'refresh');
            exit;
        }
    }

    function if_booking_running()
    {
        if(!isset($this->session->selection))
        {
            redirect(base_url(), 'refresh');
        }
    }

    function getActiveMem()
    {
        $row = $this->master->getRow('members', array('mem_id' => $this->session->mem_id));
        return $row;
    }

    function getSiteSettings()
    {
        return $this->master->getRow("siteadmin", array('site_id' => '1'));
    }

    

    function send_site_email($mem_data, $key)
    {

        // $this->load->model('member_model', 'member');
        $settings = $this->data['site_settings'];
        // $mem_row = $this->member->getMember($mem_id);
        
        $name = $mem_data['name'];
        // $name=$mem_row->mem_fname . ' ' . $mem_row->mem_lname;
        
        $msg_body = getSiteText('email',$key);
        eval("\$msg_body = \"$msg_body\";");
        
        if(!empty($mem_data['link'])){
            // $verify_link = site_url('verification/' .$mem_row->mem_code);
            $msg_body.="<p><a href='{$mem_data['link']}' style='color: #37b36f; text-decoration: none;'>".$mem_data['link']."</a></p>";
        }

        // $emailto = $mem_row->mem_email;
        $emailto = $mem_data['email'];
        $subject = $settings->site_name." - ".getSiteText('email', $key,'subject');
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html;charset=utf-8\r\n";
        $headers .= "From: " . $settings->site_name . " <" . $settings->site_email . ">" . "\r\n";
        $headers .= "Reply-To: " . $settings->site_name . " <" . $settings->site_email . ">" . "\r\n";

        $this->data['email_body'] = $msg_body;
        $this->data['email_subject'] = $subject;
        $ebody = $this->load->view('includes/email_template', $this->data, TRUE);
        if (@mail($emailto, $subject, $ebody, $headers)) {
            return 1;
        } else {
            return 0;
        }
    }
}

class Admin_Controller extends CI_Controller
{

    protected $data = array();

    public function __construct()
    {
        parent::__construct();
        $this->data['adminsite_setting'] = $this->getAdmineSettings();
    }

    public function isLogged()
    {
        if ($this->session->loged_in < 1) {
            $this->session->set_userdata('admin_redirect_url', currentURL());
            redirect(ADMIN . '/login', 'refresh');
            exit;
        }
    }

    public function logged()
    {
        if ($this->session->loged_in > 0) {
            redirect(ADMIN , 'refresh');
            exit;
        }
    }

    function getAdmineSettings()
    {
        return $this->master->getRow("siteadmin", array('site_id' => '1'));
    }
}

?>