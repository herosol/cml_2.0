<?php

class Index extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('member_model');
        $this->load->model('pages_model', 'page');
    }

    function index()
    {
        $meta = $this->page->getMetaContent('home');
        $this->data['page_title'] = $meta->page_name;
        $this->data['slug'] = $meta->slug;
        $data = $this->page->getPageContent('home');
        if ($data) {
            $this->data['content'] = unserialize($data->code);

            $this->data['meta_desc'] = json_decode($meta->content);
            $this->data['testimonials'] = $this->master->get_data_rows('testimonials', ['status' => '1']);
            $this->data['blogs'] = $this->master->getRows('blogs', ['status' => '1'], 0, 3, 'DESC');

            $this->load->view('pages/index', $this->data);
        } else {
            show_404();
        }
    }

    function signin()
    {
        $this->MemLogged();
        if ($this->input->post()) {
            $res = array();
            $res['frm_reset'] = 0;
            $res['hide_msg'] = 0;
            $res['scroll_to_msg'] = 0;
            $res['status'] = 0;
            $res['redirect_url'] = 0;
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');
            if ($this->form_validation->run() === FALSE) {
                $res['msg'] = validation_errors();
            } else {
                $data = $this->input->post();
                $row = $this->member_model->authenticate($data['email'], $data['password']);
                if (count($row) > 0) {
                    if ($row->mem_status == 0) {
                        $res['msg'] = showMsg('error', 'Your account has been blocked!');
                        exit(json_encode($res));
                    }

                    $remember_token = '';
                    if (isset($data['remember'])) {
                        $remember_token = doEncode('member-' . $row->mem_id);
                        $cookie = ['name'   => 'remember', 'value'  => $remember_token, 'expire' => (86400 * 7)];
                        $this->input->set_cookie($cookie);
                    }

                    $this->member_model->save(['mem_first_time_login' => 'no'], $row->mem_id);
                    $this->member_model->update_last_login($row->mem_id, $remember_token);
                    $this->session->set_userdata('mem_id', $row->mem_id);
                    $this->session->set_userdata('mem_type', $row->mem_type);

                    $res['redirect_url'] = base_url() . $row->mem_type . '/dashboard';

                    $res['msg'] = showMsg('success', 'Login successful! Please wait...');

                    $res['status'] = 1;
                    $res['frm_reset'] = 1;
                    $res['hide_msg'] = 1;
                } else {
                    $res['msg'] = '<p>Invalid email or password</p>';
                }
            }
            exit(json_encode($res));
        } else {
            $meta = $this->page->getMetaContent('signin');

            $this->data['page_title'] = $meta->page_name;
            $this->data['slug'] = $meta->slug;
            $this->data['site_content'] = $this->master->getRow('sitecontent', array('ckey' => 'signin'));
            $this->data['content'] = unserialize($this->data['site_content']->code);

            $this->load->view("auth/signin", $this->data);
        }
    }

    function runTimeSignin()
    {
        if ($this->input->post()) {
            $res = array();
            $res['frm_reset'] = 0;
            $res['hide_msg'] = 0;
            $res['scroll_to_msg'] = 0;
            $res['status'] = 0;
            $res['redirect_url'] = 0;
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');
            if ($this->form_validation->run() === FALSE) {
                $res['msg'] = validation_errors();
            } else {
                $data = $this->input->post();
                $row = $this->member_model->authenticate($data['email'], $data['password'], 'buyer');
                if (count($row) > 0) {
                    if ($row->mem_status == 0) {
                        $res['msg'] = showMsg('error', 'Your account has been blocked!');
                        exit(json_encode($res));
                    }

                    $remember_token = '';
                    $this->member_model->update_last_login($row->mem_id, $remember_token);
                    $this->session->set_userdata('mem_id', $row->mem_id);
                    $this->session->set_userdata('mem_type', $row->mem_type);

                    $res['msg'] = showMsg('success', 'Login successful! Please wait...');

                    $slug = $this->uri->segment(1);
                    $html = '';
                    $html .= '<ul id="lnk">
                        <li class="' . ($slug == 'index' ? 'active' : '') . '">
                            <a href="' . base_url() . '">Home</a>
                        </li>
                        <li class="' . ($slug == 'promotions-offers' ? 'active' : '') . '">
                            <a href="' . base_url('promotions-offers') . '">Promotions & Offers</a>
                        </li>
                        <li class="' . ($slug == 'contact' ? 'active' : '') . '">
                            <a href="' . base_url('contact') . '">Contact us</a>
                        </li>
                    </ul>
                    <div id="pro_btn" class="drop_down">
                        <div class="ico drop_btn">
                            <img src="' . get_site_image_src("members", $row->mem_image, 'thumb_') . '" alt="">
                        </div>
                        <div class="drop_cnt">
                            <ul class="drop_lst">
                                <li><a href="' . base_url() . $row->mem_type . '/dashboard">Dashboard</a></li>
                                <li><a href="' . base_url() . $row->mem_type . '/orders">My Orders</a></li>';
                    if ($this->session->mem_type == 'vendor') :
                        $html .= '<li><a href="' . base_url('vendor/wallet') . '">My Earnings</a></li>';
                    else :
                        $html .= '<li><a href="' . base_url('buyer/transactions') . '">My Transactions</a></li>';
                    endif;
                    $html .= '<li><a href="' . base_url('index/logout') . '">Sign out</a></li>
                            </ul>
                        </div>
                    </div>';

                    $res['status'] = 1;
                    $res['frm_reset']  = 1;
                    $res['hide_msg']   = 1;
                    $res['mem_data']   = $row;
                    $res['header_nav'] = $html;
                } else {
                    $res['msg'] = '<p>Invalid email or password</p>';
                }
            }
            exit(json_encode($res));
        }
    }

    public function facebook_login()
    {
        include_once APPPATH . "libraries/Facebook/autoload.php";
        $fb = new Facebook\Facebook(array(
        'app_id' => '1621516391231142', // Replace {app-id} with your app id
        'app_secret' => '700dbe7cbdfe2ab506e58ce1e4afee53',
        'default_graph_version' => 'v2.9'
        ));

        $helper = $fb->getRedirectLoginHelper();
        $permissions = array('email'); // Optional permissions
        $loginUrl = $helper->getLoginUrl(base_url('facebook-callback'), $permissions);
        $fb_login_url = ($loginUrl);
        redirect($fb_login_url, 'refresh');
        exit;
    }

    public function google_login()
    {
        include_once APPPATH . "libraries/Google/autoload.php";
        $client_id = '64946543542-d5qjd9vp2f71qrd62p13l1ftbeon40dg.apps.googleusercontent.com';
        $client_secret = 'h3Fkf00VUVHvSAMf4aLFhefG';
        $redirect_uri = base_url('google-callback');
        $client = new Google_Client();
        $client->setClientId($client_id);
        $client->setClientSecret($client_secret);
        $client->setRedirectUri($redirect_uri);
        $client->addScope("email");
        $client->addScope("profile");
        $authUrl = $client->createAuthUrl();

        redirect(urldecode($authUrl), 'refresh');
    }

    function fb_callback() {
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

	function google_callback() {
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
        		$new_vals['mem_stripe_id']=$this->my_stripe->save_customer(array('name' => ucfirst($new_vals['mem_fname']).' '.ucfirst($new_vals['mem_lname']),'email' => $new_vals['mem_email'],"description" => "Crainly Customer ".ucfirst($new_vals['mem_fname']).' '.ucfirst($new_vals['mem_lname'])));

        		$mem_id = $this->member->save($new_vals);

        		$this->member->update_last_login($mem_id);
        		$this->session->set_userdata('mem_type', 'student');
        		$this->session->set_userdata('mem_id', $mem_id);
        		// $this->sendEmail();
        	}
        }
        $redirect_url=$this->session->mem_type=='student'?'account-settings':'dashboard';
        redirect($redirect_url, 'refresh');
        exit;
    }

    function signup_as()
    {
        $this->MemLogged();
        $meta = $this->page->getMetaContent('signup');
        $this->data['page_title'] = $meta->page_name;
        $this->data['slug'] = $meta->slug;
        $this->data['site_content'] = $this->master->getRow('sitecontent', array('ckey' => 'signup'));
        $this->data['content'] = unserialize($this->data['site_content']->code);
        $this->load->view('auth/signup-as', $this->data);
    }

    function signup($as)
    {
        $this->MemLogged();
        if ($this->input->post()) {
            $res = array();
            $res['hide_msg'] = 0;
            $res['scroll_to_msg'] = 0;
            $res['frm_reset'] = 0;
            $res['status'] = 0;

            $this->form_validation->set_rules('mem_fname', 'First Name', 'trim|required|alpha|min_length[2]|max_length[20]', 
                [
                    'alpha' => 'First Name should contains only letters and avoid space.',
                    'min_length' => 'First Name should contains atleast 2 letters.',
                    'max_length' => 'First Name should not be greater than 20 letters.'
                ]);
            $this->form_validation->set_rules('mem_lname', 'Last Name', 'trim|required|alpha|min_length[2]|max_length[20]', 
                [
                    'alpha' => 'Last Name should contains only letters and avoid space.',
                    'min_length' => 'Last Name should contains atleast 2 letters.',
                    'max_length' => 'Last Name should not be greater than 20 letters.'
                ]);
            $this->form_validation->set_rules('mem_email', 'Email', 'trim|required|valid_email|is_unique[members.mem_email]', 
                [
                    'valid_email' => 'Please enter a valid email.',
                    'is_unique' => 'This email is already in use.'
                ]);
            $this->form_validation->set_rules('mem_phone', 'Email', 'trim|required|is_unique[members.mem_phone]', 
            [
                'is_unique' => 'This phone is already in use.'
            ]);
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|callback_is_password_strong', 
                [
                    'is_password_strong' => 'Password should contains alteast 1 small letter, 1 capital letter, 1 number, and one special characher.'
                ]);
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]', 
                [
                    'matches' => 'Confirm password must be the as the password.'
                ]);
            $this->form_validation->set_rules('confirm', 'Confirm', 'required', ['required' => 'Please accept our terms and conditions.']);
            if ($this->form_validation->run() === FALSE) {
                $res['msg'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                $mem_row = $this->member_model->emailExists($post['mem_email']);
                if (count($mem_row) == '0') {
                    $rando = doEncode(rand(99, 999) . '-' . $post['email']);
                    $rando = strlen($rando) > 225 ? substr($rando, 0, 225) : $rando;
                    $save_data = [
                        'mem_fname' => ucfirst($post['mem_fname']),
                        'mem_lname' => ucfirst($post['mem_lname']),
                        'mem_email' => $post['mem_email'],
                        'mem_pswd' => doEncode($post['password']),
                        'mem_code' => $rando,
                        'mem_type' => $as,
                        'mem_status' => 1,
                        'mem_last_login' => date('Y-m-d h:i:s')
                    ];

                    $mem_id = $this->member_model->save($save_data);
                    $this->session->set_userdata('mem_id', $mem_id);
                    $this->session->set_userdata('mem_type', $as);

                    $res['msg'] = showMsg('success', getSiteText('alert', 'registration'));

                    $verify_link = site_url('verification/' . $rando);
                    $mem_data = array('name' => ucfirst($post['mem_fname']) . ' ' . ucfirst($post['mem_lname']), "email" => $post['mem_email'], "link" => $verify_link);
                    $this->send_site_email($mem_data, 'signup');

                    if ($as == 'vendor') {
                        $res['redirect_url'] = base_url() . 'vendor/dashboard';
                    } else {
                        $res['redirect_url'] = base_url() . 'buyer/dashboard';
                    }

                    $res['status'] = 1;
                    $res['frm_reset'] = 1;
                } else {
                    $res['msg'] = '<p>E-mail Address Already In Use</p>';
                }
            }
            exit(json_encode($res));
        } else {
            if ($as != 'buyer' && $as != 'vendor') {
                show_404();
            }
            $this->data['as'] = ucfirst($as);
            $meta = $this->page->getMetaContent('signup');
            $this->data['page_title'] = $meta->page_name;
            $this->data['slug'] = $meta->slug;
            $this->data['site_content'] = $this->master->getRow('sitecontent', array('ckey' => 'signup'));
            $this->data['content'] = unserialize($this->data['site_content']->code);
            $this->load->view("auth/signup", $this->data);
        }
    }

    function forgot_password()
    {
        $this->MemLogged();
        if ($this->input->post()) {
            $res = array();
            $res['hide_msg'] = 0;
            $res['scroll_to_msg'] = 0;
            $res['status'] = 0;
            $res['frm_reset'] = 0;
            $res['redirect_url'] = 0;

            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            if ($this->form_validation->run() === FALSE) {
                $res['msg'] = validation_errors();
                $res['status'] = 0;
            } else {
                $post    = $this->input->post();
                if ($mem = $this->member_model->forgotEmailExists($post['email'])) {
                    $rando = doEncode(randCode(rand(15, 20)));
                    $this->master->save('members', array('mem_code' => $rando), 'mem_id', $mem->mem_id);

                    $reset_link = site_url('reset/' . $rando);
                    $mem_data = array('name' => $mem->mem_fname . ' ' . $mem->mem_lname, "email" => $mem->mem_email, "link" => $reset_link);
                    $this->send_site_email($mem_data, 'forgot_password');

                    $res['msg'] = showMsg('success', 'We’ve sent a reset password link to the email address you entered to reset your password. If you don’t see the email, check your spam folder or email.');
                    $res['status'] = 1;
                    $res['frm_reset'] = 1;
                } else {
                    $res['msg'] = '<p>No such email address exists. Please try again.</p>';
                    $res['status'] = 0;
                }
            }
            exit(json_encode($res));
        } else {
            $this->data['site_content'] = $this->master->getRow('sitecontent', array('ckey' => 'forgot'));
            $this->data['site_content'] = unserialize($this->data['site_content']->code);
            $this->load->view("auth/forgot-password", $this->data);
        }
    }

    function reset($vcode)
    {
        if ($row = $this->member_model->getMemCode($vcode)) {
            $this->member_model->save(array('mem_code' => ''), $row->mem_id);
            $this->session->set_userdata('reset_id', $row->mem_id);
            redirect('reset-password', 'refresh');
            exit;
        } else {
            redirect('', 'refresh');
            exit;
        }
    }

    function reset_password()
    {
        $reset_id = intval($this->session->userdata('reset_id'));
        if ($row = $this->member_model->getMember($reset_id)) {
            if ($this->input->post()) {
                $res = array();
                $res['hide_msg'] = 0;
                $res['scroll_to_msg'] = 0;
                $res['status'] = 0;
                $res['frm_reset'] = 0;
                $res['redirect_url'] = 0;

                $reset_id = intval($this->session->userdata('reset_id'));
                if ($row = $this->member_model->getMember($reset_id)) {
                    $this->form_validation->set_rules('pswd', 'New Password', 'required|min_length[8]|callback_is_password_strong', ['is_password_strong' => 'Password should contains alteast 1 small letter, 1 capital letter, 1 number, and one special characher.']);
                    $this->form_validation->set_rules('cpswd', 'Confirm Password', 'required|matches[pswd]', ['matches' => 'Confirm password must be the as the password.']);
                    if ($this->form_validation->run() === FALSE) {
                        $res['msg'] = validation_errors();
                    } else {
                        $post = html_escape($this->input->post());
                        $this->member_model->save(array('mem_pswd' => doEncode($post['pswd'])), $reset_id);
                        $this->session->unset_userdata('reset_id');
                        $res['msg'] = showMsg('success', 'You have successfully reset your password.');

                        $res['redirect_url'] = site_url('signin');
                        $res['status'] = 1;
                        $res['frm_reset'] = 1;
                        $res['hide_msg'] = 1;
                    }
                } else {
                    $res['msg'] = '<p>Something is wrong, try again later.</p>';
                }
                exit(json_encode($res));
            } else {
                $this->data['site_content'] = $this->master->getRow('sitecontent', array('ckey' => 'reset'));
                $this->data['site_content'] = unserialize($this->data['site_content']->code);
                $this->load->view("auth/reset-password", $this->data);
            }
        } else {
            redirect('', 'refresh');
            exit;
        }
    }

    function verification($vcode = '')
    {
        //$this->MemLogged();
        if ($row = $this->member_model->getMemCode($vcode, intval($this->session->mem_id))) {
            if ($this->session->has_userdata('mem_id') && $this->session->mem_id != $row->mem_id) {
                setMsg('info', 'You are already logged in with different email.');
                if ($row->mem_type == 'vendor')
                    redirect('vendor/dashboard', 'refresh');
                else
                    redirect('buyer/dashboard', 'refresh');
                exit;
            }
            $this->member_model->save(['mem_verified' => 1, 'mem_code' => ''], $row->mem_id);

            setMsg('success', 'Your account has been successfully verified.');
            if ($row->mem_type == 'vendor')
                redirect('vendor/dashboard', 'refresh');
            else
                redirect('buyer/dashboard', 'refresh');
            exit;
        } else {
            redirect('', 'refresh');
            exit;
        }
    }

    function change_email()
    {
        if ($this->input->post()) {
            $res = array();
            $res['frm_reset'] = 0;
            $res['hide_msg'] = 0;
            $res['scroll_to_msg'] = 0;
            $res['status'] = 0;
            $res['redirect_url'] = 0;

            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

            if ($this->form_validation->run() === FALSE) {
                $res['msg'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                if (!$this->member_model->emailExists($post['email'], $this->session->mem_id)) {
                    $rando = doEncode($this->session->mem_id . '-' . $post['email']);
                    $rando = strlen($rando) > 225 ? substr($rando, 0, 225) : $rando;

                    $this->member_model->save(array('mem_code' => $rando, 'mem_email' => $post['email'], 'mem_verified' => 0), $this->session->mem_id);
                    $verify_link = site_url('verification/' . $rando);

                    $mem_data = array('name' => $this->data['mem_data']->mem_fname . ' ' . $this->data['mem_data']->mem_lname, "email" => $post['email'], "link" => $verify_link);
                    $this->send_site_email($mem_data, 'change_email');

                    $res['redirect_url'] = '';

                    $res['msg'] = showMsg('success', 'Email has been changed successfully.');
                    setMsg('info', getSiteText('alert', 'verify_email'));

                    $res['status'] = 1;
                    $res['frm_reset'] = 1;
                    $res['hide_msg'] = 1;
                    $res['updated_email'] = trim($post['email']);
                } else {
                    $res['msg'] = '<p>Email already exists.</p>';
                }
            }
            exit(json_encode($res));
        }
    }

    function resend_email()
    {
        $verification_check = $this->data['mem_data']->mem_verified == 0 ? false : true;
        $this->isMemLogged($this->session->mem_type, $verification_check, false);

        $res = array();
        $res['hide_msg'] = 0;
        $res['scroll_to_msg'] = 0;
        $res['status'] = 0;
        $res['frm_reset'] = 0;
        $res['redirect_url'] = 0;

        $rando = doEncode($this->session->mem_id . '-' . $this->data['mem_data']->mem_email);
        $rando = strlen($rando) > 225 ? substr($rando, 0, 225) : $rando;

        $this->member_model->save(array('mem_code' => $rando), $this->session->mem_id);

        $verify_link = site_url('verification/' . $rando);

        $mem_data = array('name' => $this->data['mem_data']->mem_fname . ' ' . $this->data['mem_data']->mem_lname, "email" => $this->data['mem_data']->mem_email, "link" => $verify_link);

        $ok = $this->send_site_email($mem_data, 'verify_email');

        $sucess_message = 'Verification email has been resent successfully to ' . $this->data['mem_data']->mem_email . '.';
        $res['msg'] = $ok ? showMsg('success', $sucess_message) : showMsg('error', 'There is an error occurred, Please try again later.');
        $res['status'] = 1;
        $res['hide_msg'] = 1;
        exit(json_encode($res));
    }

    function logout()
    {
        $this->session->unset_userdata('mem_id');
        $this->session->unset_userdata('mem_type');
        $this->session->unset_userdata('redirect_url');
        $this->session->unset_userdata('selections');
        $this->load->helper('cookie');
        delete_cookie('remember');
        redirect('signin', 'refresh');
        exit;
    }

    ### callback functions
    public function is_password_strong($password)
    {
        $whiteListedSpecial = "\$\@\#\^\|\!\~\=\+\-\_\.";
        if (preg_match('#[0-9]#', $password) && preg_match('#[a-zA-Z]#', $password) && preg_match('/[' . $whiteListedSpecial . ']/', $password)) {
            return TRUE;
        }
        return FALSE;
    }

    ### COMMON 
    function fetch_states()
    {
        if ($this->input->post()) {
            $country_id = html_escape($this->input->post('country_id'));

            $html = '';
            $html .= '<option value="">Select</option>';
            $states = $this->master->getRows('states', ['country_id' => $country_id], '', '', 'asc', 'name');
            foreach ($states as $state) :
                $html .= '<option value="' . $state->id . '">' . $state->name . '</option>';
            endforeach;

            echo json_encode(['status' => 'success', 'html' => $html]);
        }
    }

    function fetch_time()
    {
        if ($this->input->post()) {
            $facility_hours = $this->master->get_data_row('mem_facility_hours', ['mem_id' => $this->input->post('mem_id')]);
            $day = html_escape($this->input->post('day'));
            $dayIndex = explode('-', $day);
            $day = $dayIndex[2] . '-' . $dayIndex[0] . '-' . $dayIndex[1];
            $day = strtotime($day);
            $day = date('D', $day);
            $day = strtolower($day);
            $key_opening = $day . '_opening';
            $key_closing = $day . '_closing';

            $opening_time = $facility_hours->$key_opening;
            $closing_time = $facility_hours->$key_closing;

            $html = oneHourTimeByGiven('', $opening_time, $closing_time);
            echo json_encode(['status' => 'success', 'html' => $html]);
        }
    }

    function newsletter()
	{
        $res=array();
        $res['hide_msg']=0;
            $res['scroll_to_msg']=1;
            $res['status'] = 0;
            $res['frm_reset'] = 0;
            $res['redirect_url'] = 0;

        $this->form_validation->set_rules('email','Email','required|valid_email|is_unique[newsletter.email]',
            array(
                'required'      => 'You have not provided %s.',
                'is_unique'     => 'This %s already joined.'
            ));
        if($this->form_validation->run()===FALSE)
        {
            $res['msg'] = validation_errors();
            $res['status'] = 0;
        }else{
            $email=html_escape($this->input->post('email'));

            if($this->master->save('newsletter', ['email'=> $email]))
            {
                $res['msg'] = showMsg('success','Joined successful!');
                $res['status'] = 1;
                $res['frm_reset'] = 1;
                $res['hide_msg']=1;
            }
            else
            {
                $res['msg'] = showMsg('error', 'Something went wrong please try again.');
                $res['status'] = 0;
                $res['frm_reset'] = 0;
                $res['hide_msg'] = 1;
            }
        }
        exit(json_encode($res));
    }

    function change_password()
    {
        $this->isMemLogged($this->session->mem_type);
        if ($this->input->post()) {
            $res = array();
            $res['hide_msg'] = 0;
            $res['scroll_to_msg'] = 1;
            $res['redirect_url'] = 0;
            $res['status'] = 0;
            $res['frm_reset'] = 0;

            $this->form_validation->set_rules('pswd', 'Current Password', 'required');
            $this->form_validation->set_rules('npswd', 'New Password', 'required');
            $this->form_validation->set_rules('cpswd', 'Confirm Password', 'required|matches[npswd]');

            if ($this->form_validation->run() === FALSE) {
                $res['msg'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                $row = $this->member_model->oldPswdCheck($this->data['mem_data']->mem_id, $post['pswd']);
                if (count($row) > 0) {
                    $ary = array('mem_pswd' => doEncode($post['npswd']));
                    $this->member_model->save($ary, $this->data['mem_data']->mem_id);
                    $res['msg'] = showMsg('success', 'Password successfully updated!');

                    $res['status'] = 1;
                    $res['frm_reset'] = 1;
                    $res['hide_msg'] = 1;
                } else {
                    $res['msg'] = '<p>Old Password Does Not Match.</p>';
                }
            }
            exit(json_encode($res));
        }
    }
}
