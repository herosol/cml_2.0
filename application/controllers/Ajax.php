<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends MY_Controller
{

	function __construct()
    {
		parent::__construct();
		// $this->load->model('member_model', 'member');
	}

	function contact(){
		$res=array();
		$res['hide_msg']=0;
		$res['scroll_top']=0;

		$this->form_validation->set_rules('name',' Name','required');
		$this->form_validation->set_rules('phone',' Phone','required');
		$this->form_validation->set_rules('subject',' Subject','required');
		$this->form_validation->set_rules('email','Email','required|valid_email');
		$this->form_validation->set_rules('msg','Message','required');
		if($this->form_validation->run()===FALSE){
			$res['msg'] = validation_errors();
			$res['status'] = 0;
		}else{
			$vals=$this->input->post();
			$vals['created_date'] = date('Y-m-d H:i:s'); 
			$this->master->save('contact',$vals);
			$vals['site_email']=$this->data['site_settings']->site_email;
			// $vals['site_noreply_email']=$this->data['site_settings']->site_noreply_email;
			//$okmsg=send_email($vals);
			//$okmsg = $this->send_contact_email($vals,1);
			if($okmsg){
				$res['msg'] = showMsg('success', 'Message send sucessfully!');
				$res['status'] = 1;
				$res['frm_reset'] = 1;
				$res['hide_msg']=1;
			}else{
				$res['msg'] = showMsg('success', 'Message send sucessfully!');
				$res['status'] = 1;
				$res['frm_reset'] = 1;
				$res['hide_msg']=1;
				// $res['msg'] = '<div class="alert alert-danger alert-sm">Error Occured!</div>';
				// $res['status'] = 0;
			}
		}
		echo json_encode($res);
		exit();
	}

    function cron_jobs()
    {
        $this->load->library('twilio');
        $this->master->query("update tbl_members set mem_pkg_status = 2, mem_membership_pref = 0 where mem_membership_auto = 1 and mem_pkg_status = 1 and mem_pkg_expiry_date is not null and TIMESTAMPDIFF(DAY, mem_pkg_expiry_date, CURRENT_TIMESTAMP) > 1");
        $this->master->query("update tbl_bookings set completed=2 where status=2 and completed=1 and canceled=0 and checkout_time is not null and TIMESTAMPDIFF(HOUR, checkout_time, CURRENT_TIMESTAMP)>=72");
        $bkings_rows = $this->master->getRows("bookings", "status=0 and TIMESTAMPDIFF(HOUR, date, CURRENT_TIMESTAMP)>=72");
        foreach ($bkings_rows as $key => $bk_row) {
            $this->master->query("update tbl_members set mem_vacation_mode=1 where mem_vacation_mode=0 and mem_id=".$bk_row->sitter_id);
        }
        $this->master->query("update tbl_bookings set status=3 where status=0 and TIMESTAMPDIFF(HOUR, date, CURRENT_TIMESTAMP)>=72");

        $msg_rows = $this->master->getRows("chat_msgs", "status='new' and noti=0 and TIMESTAMPDIFF(MINUTE, time, CURRENT_TIMESTAMP) >= 10", '', '', '', 'id', 'chat_id');
        $this->master->query("update tbl_chat_msgs set noti=1 where status='new' and noti=0 and TIMESTAMPDIFF(MINUTE, time, CURRENT_TIMESTAMP) >= 10");
        foreach ($msg_rows as $key => $msg_row) {
            if ($chat_row = $this->master->getRow("chat", ['id' => $msg_row->chat_id])) {
                $mem_id = $chat_row->mem_one == $msg_row->sender_id ? $chat_row->mem_two : $chat_row->mem_one;
                if ($mem_row = $this->master->getRow("members", ['mem_id' => $mem_id])) {
                    $sender_row = $this->master->getRow("members", ['mem_id' => $msg_row->sender_id]);
                    if (!empty($mem_row->email_new_message)) {
                        $mem_data = array('receiver_name' => format_name($mem_row->mem_fname, $mem_row->mem_lname), "email" => $mem_row->mem_email, 'sender_name' => format_name($sender_row->mem_fname, $sender_row->mem_lname), 'sender_fname' => $sender_row->mem_fname, "image" => $sender_row->mem_image, "id" => $sender_row->mem_id, "msg" => (empty($msg_row->msg) ? 'Sent an Attachemnt' : $msg_row->msg));
                        send_site_email($mem_data, 'new_msg_email', 'send-msg');
                    }
                    if (!empty($mem_row->mobile_new_message)) {
                        $name = format_name($sender_row->mem_fname, $sender_row->mem_lname);
                        $msg = getSiteText('email', 'new_msg_email', 'msg');
                        $this->twilio->send_msg($mem_row->mem_phone, $msg, $name);
                    }
                }
            }
        }

        $date = date("d");
        if ($date == '01' || $date == '15') {
            $member_rows = $this->master->getRows("members", "mem_type = 'sitter' and mem_status = 1 and mem_verified = 1 and mem_sitter_verified = 1 and mem_reminder_calendar_email = 0");
            $this->master->query("update tbl_members set mem_reminder_calendar_email = 1 where mem_type = 'sitter' and mem_status = 1 and mem_verified = 1 and mem_sitter_verified = 1");
            foreach ($member_rows as $key => $mem_row) {
                if (!empty($mem_row->email_calendar)) {
                    $name = format_name($mem_row->mem_fname, $mem_row->mem_lname);

                    $mem_data = array('name' => $name, "email" => $mem_row->mem_email, 'to_name' => $mem_row->mem_fname, 'point_link' => site_url('profile-settings#calendar-settings'), 'point_text' => 'Update Calendar');
                    send_site_email($mem_data, 'calendar_update', 'general');
                }
                if (!empty($mem_row->mobile_calendar)) {
                    $name = format_name($mem_row->mem_fname, $mem_row->mem_lname);
                    $msg = getSiteText('email', 'calendar_update', 'msg');
                    $this->twilio->send_msg($mem_row->mem_phone, $msg, $name);
                }
            }
        } elseif ($date == '02' || $date == '16') {
            $this->master->query("update tbl_members set mem_reminder_calendar_email = 0 where mem_type = 'sitter' and mem_status = 1 and mem_verified = 1 and mem_sitter_verified = 1");
        }


        $reminder_rows = $this->master->getRows("members", "mem_status = 1 and mem_verified = 1 and mem_reminder_email = 0 and TIMESTAMPDIFF(HOUR, mem_date, CURRENT_TIMESTAMP) >= 4");
        $this->master->query("update tbl_members set mem_reminder_email = 1 where mem_reminder_email = 0 and TIMESTAMPDIFF(HOUR, mem_date, CURRENT_TIMESTAMP) >= 4");
        foreach ($reminder_rows as $key => $reminder_row) {
            $link = empty($reminder_row->mem_type) ? 'become-a-sitter' : 'become-pet-owner';
            $mem_data = array('name' => format_name($reminder_row->mem_fname, $reminder_row->mem_lname), "email" => $reminder_row->mem_email, 'point_link' => site_url($link), 'point_text' => 'Complete your profile');
            
            send_site_email($mem_data, 'profile-completion-'.$reminder_row->mem_type, 'profile-completion');
        }
    }

    /*** start summernote ***/

    function upload_summernote_attach()
    {
        if($_FILES['file']['name']!='') {
            $image = upload_file(UPLOAD_PATH."attachments/", 'file', 'att');
            if (!empty($image['file_name'])) {
                exit(SITE_IMAGES.'attachments/'.$image['file_name']);
            } else {
                exit(strip_tags($image['error']));
            }
        }
    }

    function remove_summernote_attachments()
    {
        $attach = $this->input->post('attach');
        if($attach != '') {
            $attach = str_replace(site_url(), '', $attach);
            if (unlink($attach)) {
                exit('ok');
            }
        }
        return false;
    }
    /*** end summernote ***/
	function report_profile($encoded_id)
    {
        $this->isMemLogged('owner');
        $id = intval(doDecode($encoded_id));
        if($this->data['row'] = $this->member->get_sitter($id)) {
            $res=array();
            $res['hide_msg']=0;
            $res['scroll_to_msg']=1;
            $res['status'] = 0;
            $res['frm_reset'] = 0;
            $res['redirect_url'] = 0;

            $this->form_validation->set_rules('reason','Reason','required');
            if($this->form_validation->run()===FALSE)
            {
                $res['msg'] = validation_errors();
            }else{
                $reason = html_escape($this->input->post('reason'));
                $this->master->save('reports', array('reason'=>$reason, 'mem_id' => $this->session->mem_id, 'profile_id' => $id));
                $res['msg'] = showMsg('success', 'Profile reported!');
                $res['status'] = 1;
                $res['frm_reset'] = 1;
                $res['hide_msg'] = 1;
            }
            exit(json_encode($res));
        }
        else
            show_404();
    }

    function newsletter()
    {
        $res = array();
        $res['hide_msg'] = 0;
        $res['scroll_to_msg'] = 1;
        $res['status'] = 0;
        $res['frm_reset'] = 0;
        $res['redirect_url'] = 0;

        $this->form_validation->set_rules('subsemail', 'Email', 'required|valid_email|is_unique[newsletter.email]',
            array(
                'required'      => 'You have not provided %s.',
                'is_unique'     => 'This %s already joined.'
            ));
        if($this->form_validation->run() === FALSE) {
            $res['msg'] = validation_errors();
            $res['status'] = 0;
        } else {
            $email = html_escape($this->input->post('subsemail'));

            $this->master->save('newsletter', array('email' => $email));
            $res['msg'] = 'Joined successful!';
            $res['status'] = 1;
            $res['frm_reset'] = 1;
            $res['hide_msg']=1;
        }
        exit(json_encode($res));
    }
	function search_promo(){
		$vals=$this->input->post();
		// pr($vals);
		if(!empty($vals['zip_promo'])){
			$promos = $this->master->getRows('promos',array('status'=>1,'zip'=>$vals['zip_promo']));
		}else{
			$promos = $this->master->getRows('promos',array('status'=>1));
		}
		
		exit(json_encode($promos));
		
	}
    function trade()
    {
        $res = array();
        $res['hide_msg'] = 0;
        $res['scroll_to_msg'] = 1;
        $res['status'] = 0;
        $res['frm_reset'] = 0;
        $res['redirect_url'] = 0;

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('phone', 'phone', 'required');
        $this->form_validation->set_rules('country', 'country', 'required');
        $this->form_validation->set_rules('brand', 'Brand and Model Reference', 'required');
        $this->form_validation->set_rules('conditions', 'Condition', 'required');
        $this->form_validation->set_rules('details', 'About Watch', 'required');
        $this->form_validation->set_rules('stuff', 'Stuff Attached', 'required');
           
        if($this->form_validation->run() === FALSE) {
            $res['msg'] = validation_errors();
            $res['status'] = 0;
        } else {
			$vals = $this->input->post();
            $vals['email'] = html_escape($this->input->post('email'));
			$vals['date'] =  date('Y-m-d H:i:s');
			if (($_FILES["image"]["name"] != "")) {
				$image = upload_file(UPLOAD_PATH . "images/", 'image');
				if (!empty($image['file_name'])) {
					
					$vals['image'] = $image['file_name'];
				} else {
					$res['msg'] = 'Please upload a valid image file >> ' . strip_tags($image['error']);
					$res['status'] = 1;
					exit(json_encode($res));
				}
			}	

            $this->master->save('trade', $vals);
            $res['msg'] = 'Message Sent successfully, We will contact you shortly!';
            $res['status'] = 1;
            $res['frm_reset'] = 1;
            $res['hide_msg']=1;
        }
        exit(json_encode($res));
    }

	function follow()
    {
		$this->isMemLogged('member');

		$id=intval(substr(doDecode($this->input->post('store')),2));
		if($this->member->getMember($id,array('mem_status'=>1,'mem_verified'=>1))){

			if($this->master->getRow('followers',array('follower_id'=>$this->session->mem_id,'mem_id'=>$id))){
				$this->db->where(array('follower_id'=>$this->session->mem_id,'mem_id'=>$id));
				$this->db->delete('followers');
				$res['data']='Follow';
			}
			else{
				$this->master->save('followers',array('follower_id'=>$this->session->mem_id,'mem_id'=>$id));
				$txt=' starts Following you';
				$this->save_notificaiton($id,$this->session->mem_id,$txt);
				$res['data']='<i class="fa fa-check"></i> Following';
			}
			// echo $res['data'];
			exit(json_encode($res));
		}
		die('access denied!');
	}
    
	function fb_callback()
    {
		include_once APPPATH . "libraries/Facebook/autoload.php";
		$fb = new Facebook\Facebook(array(
			'app_id' => '513833342331811',
			'app_secret' => '8a7378961461fd4c002f70e234e30a4a',
			'default_graph_version' => 'v2.9'
		));
		$helper = $fb->getRedirectLoginHelper();
		try {
			$accessToken = $helper->getAccessToken();
		} catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		} catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}

		if (!isset($accessToken)) {
			if ($helper->getError()) {
				header('HTTP/1.0 401 Unauthorized');
				echo "Error: " . $helper->getError() . "\n";
				echo "Error Code: " . $helper->getErrorCode() . "\n";
				echo "Error Reason: " . $helper->getErrorReason() . "\n";
				echo "Error Description: " . $helper->getErrorDescription() . "\n";
			} else {
				header('HTTP/1.0 400 Bad Request');
				echo 'Bad request';
			}
			exit;
		}
		$this->session->set_userdata('fb_access_token', (string) $accessToken);
		$res = $fb->get('/me', $accessToken);
		$user = $res->getGraphObject();
		$data = array();
		$data['access_token'] = $accessToken;
		$data['name'] = $user->getProperty('name');
		$data['email'] = $user->getProperty('email');
		$data['social_id'] = trim($user->getProperty('id'));

		if (!empty($data['name']) && !empty($data['social_id']) && !empty($data['access_token'])) {
			if ($mem = $this->member->socialIdExists('facebook', $data['social_id'])) {

				$this->member->update_last_login($mem->mem_id);
				$this->session->set_userdata('mem_type', $mem->mem_type);
				$this->session->set_userdata('mem_id', $mem->mem_id);
			} else {
				$image='';
				if(!empty($data['image'])){
					
					$image = file_get_contents($data['image']);
					$file_name=md5(rand(100, 1000)) . '_' .time() . '_' . rand(1111, 9999). '.jpg';

					$dir = UPLOAD_VPATH . 'vp/'.$file_name;
					@file_put_contents($dir, $image);

					generate_thumb(UPLOAD_VPATH . "vp/", UPLOAD_VPATH . "p50x50/", $file_name, 50);
					generate_thumb(UPLOAD_VPATH . "vp/", UPLOAD_VPATH . "p150x150/", $file_name, 150);
					generate_thumb(UPLOAD_VPATH . "vp/", UPLOAD_VPATH . "p300x300/", $file_name, 300);

					$image=$file_name;
				}

				if($data['email']!=''){
					$mem_row = $this->member->emailExists($data['email']);
					if (count($mem_row) > 0)
						$data['email']='';
				}

				$arr = explode(" ", $data['name']);
				$new_vals = array(
					'mem_type' => 'student',
					'mem_social_type' => 'facebook',
					'mem_social_id' => $data['social_id'],
					'mem_fname' => $arr[0],
					'mem_lname' => $arr[1],
					'mem_email' => $data['email'],
					'mem_status' => '1',
					'mem_verified' => '1',
					'mem_image' => $image
				);
				$this->load->library('my_braintree');
        		$new_vals['mem_braintree_id']=$this->my_braintree->create_customer(array('firstName' => ucfirst($new_vals['mem_fname']),'lastName' => ucfirst($new_vals['mem_lname']),'email' => $new_vals['mem_email']));
        		
				$mem_id = $this->member->save($new_vals);
				
				$this->member->update_last_login($mem_id);
				$this->session->set_userdata('mem_type', 'student');
				$this->session->set_userdata('mem_id', $mem_id);
				// $this->sendEmail();
			}
			$redirect_url=$this->session->mem_type=='student'?'account-settings':'dashboard';
			redirect($redirect_url, 'refresh');
			exit;
		}
	}

	function google_callback()
    {
		include_once APPPATH . "libraries/Google/autoload.php";

		$client_id = '64946543542-d5qjd9vp2f71qrd62p13l1ftbeon40dg.apps.googleusercontent.com';
		$client_secret = 'h3Fkf00VUVHvSAMf4aLFhefG';
		$redirect_uri = base_url('google-callback');

		$client = new Google_Client();
		$client->setClientId($client_id);
		$client->setClientSecret($client_secret);
		$client->setRedirectUri($redirect_uri);

		$client->authenticate($_GET['code']);
		$accessToken = $client->getAccessToken();
		$client->setAccessToken($accessToken);

		$service = new Google_Service_Oauth2($client);
		$data = array();
        $user = $service->userinfo->get(); //get user info 

        $data['access_token'] = $accessToken;
        $data['social_id'] = $user->id;
        $data['name'] = $user->name;
        $data['email'] = $user->email;
        $data['image'] = $user->picture;
        if (!empty($data['name']) && !empty($data['social_id']) && !empty($data['access_token'])) {


        	if ($mem = $this->member->socialIdExists('google', $data['social_id'])) {

        		$this->member->update_last_login($mem->mem_id);
        		$this->session->set_userdata('mem_type', $mem->mem_type);
        		$this->session->set_userdata('mem_id', $mem->mem_id);
        	} else {
        		$image = '';
        		if(!empty($data['image'])){
        			
        			/*
                    $image = @file_get_contents($data['image']);
        			$file_name = md5(rand(100, 1000)) . '_' .time() . '_' . rand(1111, 9999). '.jpg';

        			$dir = UPLOAD_VPATH . 'vp/'.$file_name;
        			@file_put_contents($dir, $image);

        			generate_thumb(UPLOAD_VPATH . "vp/", UPLOAD_VPATH . "p50x50/", $file_name, 50);
        			generate_thumb(UPLOAD_VPATH . "vp/", UPLOAD_VPATH . "p150x150/", $file_name, 150);
        			generate_thumb(UPLOAD_VPATH . "vp/", UPLOAD_VPATH . "p300x300/", $file_name, 300);

        			$image=$file_name;
                    */

                    $image = save_mem_social_image($data['image']);
        		}
        		if($data['email'] != '') {
        			$mem_row = $this->member->emailExists($data['email']);
        			if (count($mem_row) > 0)
        				$data['email'] = '';
        		}

        		$arr = @explode(" ", $data['name']);
        		$new_vals = array(
        			'mem_type' => 'owner',
        			'mem_social_type' => 'google',
        			'mem_social_id' => $data['social_id'],
        			'mem_fname' => $arr[0],
        			'mem_lname' => $arr[1],
        			'mem_email' => $data['email'],
        			'mem_status' => '1',
        			'mem_verified' => '1',
        			'mem_image' => $image
        		);

        		$this->load->library('my_stripe');
        		$new_vals['mem_stripe_id'] = $this->my_stripe->save_customer(array('name' => ucfirst($new_vals['mem_fname']).' '.ucfirst($new_vals['mem_lname']),'email' => $new_vals['mem_email'],"description" => "Crainly Customer ".ucfirst($new_vals['mem_fname']).' '.ucfirst($new_vals['mem_lname'])));

        		$mem_id = $this->member->save($new_vals);

        		$this->member->update_last_login($mem_id);
        		$this->session->set_userdata('mem_type', 'owner');
        		$this->session->set_userdata('mem_id', $mem_id);
        		// $this->sendEmail();
        	}
        }

        redirect('become-pet-owner', 'refresh');
        exit;
    }

    function twitter_callback()
    {
    	include_once APPPATH . "libraries/Twitter/autoload.php";
    	
    	$client_id = '  ihs0ekv7iq91XlLbvACwod4jA';
    	$client_secret = 'N0JnOSSL8BYH8a5ISPHp0YMSHatZFLa3TZfLcBfySTjetG6a0r';
    	$redirect_uri = site_url('ajax/twitter_callback');

    	$request_token = [];
    	$request_token['oauth_token'] = $this->session->oauth_token;
    	$request_token['oauth_token_secret'] = $this->session->oauth_token_secret;

    	$this->session->unset_userdata('oauth_token');
    	$this->session->unset_userdata('oauth_token_secret');

    	if ($this->input->get('oauth_token') && $request_token['oauth_token'] === $this->input->get('oauth_token')) {


    		$connection = new Abraham\TwitterOAuth\TwitterOAuth($client_id, $client_secret, $request_token['oauth_token'], $request_token['oauth_token_secret']);
    		$access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $this->input->get('oauth_verifier')));

    		$connection = new Abraham\TwitterOAuth\TwitterOAuth($client_id, $client_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);

    		$data = array();
    		$user = $connection->get("account/verify_credentials");
    		// pr($user);

    		$data['access_token'] = $accessToken;
    		$data['social_id'] = $user->id;
    		$data['name'] = $user->name;
    		$data['email'] = $user->email;
    		$data['image'] = $user->profile_image_url;
    		if (!empty($data['name']) && !empty($data['social_id']) && !empty($data['access_token'])) {


    			if ($mem = $this->member->socialIdExists('twitter', $data['social_id'])) {

    				$this->member->update_last_login($mem->mem_id);
    				$this->session->set_userdata('mem_type', $mem->mem_type);
    				$this->session->set_userdata('mem_id', $mem->mem_id);
    			} else {

    				$image='';
    				if(!empty($data['image'])){
    					$res = curl_call(SCONTENT_SITE.'ajax/save_mem_social_image',"image=".$data['image']);
    					if($res)
    						$image = $res;
    				}
    				if($data['email']!=''){
    					$mem_row = $this->member->emailExists($data['email']);
    					if (count($mem_row) > 0)
    						$data['email'] = '';

    				}

    				$arr = @explode(" ", $data['name']);
    				$new_vals = array(
    					'mem_type' => 'member',
    					'mem_social_type' => 'google',
    					'mem_social_id' => $data['social_id'],
    					'mem_fname' => $arr[0],
    					'mem_lname' => $arr[1],
    					'mem_email' => $data['email'],
    					'mem_status' => '1',
    					'mem_verified' => '1',
    					'mem_image' => $image
    				);

    				$mem_id = $this->member->save($new_vals);

    				$this->member->update_last_login($mem_id);
    				$this->session->set_userdata('mem_type', 'member');
    				$this->session->set_userdata('mem_id', $mem_id);
        		// $this->sendEmail();
    			}
    		}
    	}
    	$redirect_url = $this->session->mem_type == 'student' ? 'account-settings' : 'dashboard';
    	redirect($redirect_url, 'refresh');
    	exit;
    }

    function search_help()
    {
    	$q = $this->input->post('query');

    	$this->db->like('title', $q);
		$query = $this->db->get('help');
		// $this->db->limit(100);
    	$rows = array();
    	foreach ($query->result() as $row) {
    		$rows[] = array('label' => $row->title, 'value' => $row->title, 'id' => $row->id);
    	}
    	exit(json_encode($rows));
    }

    function get_categories()
    {
        $res['option'] = "";
        $category_rows = $this->master->getRows("categories", array('parent_id' => intval($this->input->post('cat'))));
        if (count($category_rows) > 0) {
            foreach ($category_rows as $category_row) {
                $res['option'] .= '<option value=' .$category_row->id. '>' . $category_row->name . '</option>';
                $res['found'] = 1;
            }
        } else {
            $res['msg'] = "No Result Found";
            $res['found'] = 0;
        }
        exit(json_encode($res));
    }
}

?>