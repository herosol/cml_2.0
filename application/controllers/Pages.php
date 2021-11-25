<?php
class Pages extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pages_model', 'page');
        $this->load->model('order_model');
        $this->load->model('OrderD_model', 'orderd_model');
    }

    function landing()
    {
        $meta = $this->page->getMetaContent('landing');
        $this->data['page_title'] = $meta->page_name;
        $this->data['slug'] = $meta->slug;
        $data = $this->page->getPageContent('landing');
        if ($data) {
            $this->data['content'] = unserialize($data->code);
            $this->data['meta_desc'] = json_decode($meta->content);
            $this->load->view('pages/landing', $this->data);
        } else {
            show_404();
        }
    }

    function promotions()
    {
        $meta = $this->page->getMetaContent('promotion');
        $this->data['page_title'] = $meta->page_name;
        $this->data['slug'] = $meta->slug;
        $data = $this->page->getPageContent('promotions');
        if ($data) {
            $this->data['content'] = unserialize($data->code);
            $this->data['meta_desc'] = json_decode($meta->content);
            $this->data['promos'] = $this->master->get_data_rows('promos', array('status' => '1'));

            $this->load->view('pages/promotions-offers', $this->data);
        } else {
            show_404();
        }
    }

    function about()
    {
        $meta = $this->page->getMetaContent('about_us');
        $this->data['page_title'] = $meta->page_name;
        $this->data['slug'] = $meta->slug;
        $data = $this->page->getPageContent('about_us');
        if ($data) {
            $this->data['content'] = unserialize($data->code);
            $this->data['details'] = ($data->full_code);
            $this->data['meta_desc'] = json_decode($meta->content);
            $this->data['blogs'] = $this->master->getRows('blogs', ['status' => '1'], 0, 3, 'DESC');
            $this->load->view('pages/about', $this->data);
        } else {
            show_404();
        }
    }

    function faq()
    {
        $meta = $this->page->getMetaContent('faq');
        $this->data['page_title'] = $meta->page_name;
        $this->data['slug'] = $meta->slug;
        $data = $this->page->getPageContent('faq');
        if ($data) {
            $this->data['content'] = unserialize($data->code);
            $this->data['meta_desc'] = json_decode($meta->content);
            $this->data['general_faqs'] = $this->master->get_data_rows('faqs', array('status' => '1', 'type' => '1'));
            $this->data['most_faqs'] = $this->master->get_data_rows('faqs', array('status' => '1', 'type' => '0'));

            $this->load->view('pages/faq', $this->data);
        } else {
            show_404();
        }
    }

    function contact()
    {
        if ($vals = $this->input->post()) {
            $res = array();
            $res['hide_msg'] = 0;
            $res['scroll_to_msg'] = 0;
            $res['status'] = 0;
            $res['frm_reset'] = 0;
            $res['redirect_url'] = 0;

            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('subject', 'Subject', 'required');
            $this->form_validation->set_rules('phone', 'Phone Number', 'required');
            $this->form_validation->set_rules('msg', 'Message', 'required');
            // $this->form_validation->set_rules('g-recaptcha-response','Robot','required',array('required'=>'Please verify that you are not robot!'));
            if ($this->form_validation->run() === FALSE) {
                $res['status'] = 0;
                $res['msg'] = validation_errors();
            } else {
                $vals['msg'] = html_escape($this->input->post('msg'));
                /*$secret = RECAPTCHA_SECRET_KEY;
                $response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$vals['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
                if($response['success'] == true){*/
                $vals['created_date'] = date('Y-m-d H:i:s');
                $vals['status'] = 0;
                $this->master->save('contact', $vals);
                $vals['site_email'] = $this->data['site_settings']->site_email;
                $vals['site_noreply_email'] = $this->data['site_settings']->site_noreply_email;
                $okmsg = send_email($vals);
                if ($okmsg) {
                    $res['msg'] = 'Message send sucessfully!';
                    $res['status'] = 1;
                    $res['frm_reset'] = 1;
                    $res['hide_msg'] = 1;
                    // $res['redirect_url'] = site_url('contact-us');
                } else {
                    $res['msg'] = 'Message send sucessfully!';
                    $res['status'] = 1;
                    $res['frm_reset'] = 1;
                    $res['hide_msg'] = 1;
                }
                /*}else{
                    $res['msg'] = showMsg('error','Please verify that you are not robot!');
                    $res['redirect_url'] = site_url('contact-us');
                }*/
            }
            exit(json_encode($res));
        } else {
            $meta = $this->page->getMetaContent('contact');
            $this->data['page_title'] = $meta->page_name;
            $this->data['slug'] = $meta->slug;
            $data = $this->page->getPageContent('contact');
            if ($data) {
                $this->data['content'] =  unserialize($data->code);
                $this->data['meta_desc'] = json_decode($meta->content);
                $this->load->view('pages/contact', $this->data);
            } else {
                show_404();
            }
        }
    }

    function blog()
    {
        /*$meta = $this->page->getMetaContent('blog');
        $this->data['page_title'] = $meta->page_name;
        $this->data['slug'] = $meta->slug;
        $data = $this->page->getPageContent('blog');
        if ($data) {
            $this->data['content'] = unserialize($data->code);
            $this->data['details'] = ($data->full_code);
            $this->data['meta_desc'] = json_decode($meta->content);
            $this->load->view('pages/blog', $this->data);
        } else {
            show_404();
        }*/
        $this->data['blogs'] = $this->master->getRows('blogs', ['status'=> 1], '', '', 'DESC', 'id');
        $this->load->view('pages/blog', $this->data);
    }

    function blog_detail($blogId)
    {
        $blogId = doDecode($blogId);
        // $meta = $this->page->getMetaContent('blog');
        // $this->data['page_title'] = $meta->page_name;
        // $this->data['slug'] = $meta->slug;
        // $data = $this->page->getPageContent('blog');
        // if ($data) {
        //     $this->data['content'] = unserialize($data->code);
        //     $this->data['details'] = ($data->full_code);
        //     $this->data['meta_desc'] = json_decode($meta->content);
        // } else {
        //     show_404();
        // }
        $this->data['row'] = $this->master->get_data_row('blogs', ['id' => $blogId]);
        $this->load->view('pages/blog-detail', $this->data);
    }

    function terms_conditions()
    {
        $meta = $this->page->getMetaContent('terms_conditions');
        $this->data['page_title'] = $meta->page_name;
        $this->data['slug'] = $meta->slug;
        $data = $this->page->getPageContent('terms_conditions');
        if ($data) {
            $this->data['content'] = unserialize($data->code);
            $this->data['details'] = ($data->full_code);
            $this->data['meta_desc'] = json_decode($meta->content);
            $this->load->view('pages/terms-and-conditions', $this->data);
        } else {
            show_404();
        }
    }

    function privacy_policy()
    {
        $meta = $this->page->getMetaContent('privacy_policy');
        $this->data['page_title'] = $meta->page_name;
        $this->data['slug'] = $meta->slug;
        $data = $this->page->getPageContent('privacy_policy');
        if ($data) {
            $this->data['content'] = unserialize($data->code);
            $this->data['details'] = ($data->full_code);
            $this->data['meta_desc'] = json_decode($meta->content);
            $this->load->view('pages/privacy-policy', $this->data);
        } else {
            show_404();
        }
    }

    function impact()
    {
        $meta = $this->page->getMetaContent('impact');
        $this->data['page_title'] = $meta->page_name;
        $this->data['slug'] = $meta->slug;
        $data = $this->page->getPageContent('impact');
        if ($data) {
            $this->data['content'] = unserialize($data->code);
            $this->data['details'] = ($data->full_code);
            $this->data['meta_desc'] = json_decode($meta->content);
            $this->load->view('pages/impact', $this->data);
        } else {
            show_404();
        }
    }

    function paypal($order_id)
    {
        $this->load->library('Paypal_lib');
        $order_id = intval(doDecode($order_id));
        // echo $order_id; die;
        $row = $this->order_model->get_row($order_id);
        if ($row) {
            $this->data['post'] = array(
                "item_name" => "Paypal Payment",
                "currency" => "GBP",
                "amount" => order_total_price($order_id),
                "custom" => $order_id
            );
            $notify_url = site_url('order-notify');
            $this->data['setting'] = array(
                "website_name" => "" . $this->data['site_settings']->site_name . "",
                "url" => "" . base_url() . "",
                "notify_url" => "" . $notify_url . "",
                "return_url" => "" . base_url() . "success/" . doEncode($order_id),
                "cancel_url" => "" . base_url() . "cancel",
            );

            if ($this->data['site_settings']->site_paypal_environment) :
                $this->data['setting']["sandbox"] = true;
                $this->data['setting']["sandbox_paypal"] = $this->data['site_settings']->site_sandbox_paypal;
            else :
                $this->data['setting']["live_paypal"] = $this->data['site_settings']->site_live_paypal;
            endif;
            // pr($this->data);
            $this->load->view("includes/processing", $this->data);
        } else
            exit('Access Denied!');
    }

    function paypal_amended_invoice($order_id)
    {
        $this->load->library('Paypal_lib');
        $order_id = intval(doDecode($order_id));
        echo $order_id;
        die;
        $row = $this->order_model->get_row($order_id);
        if ($row) {
            $this->data['post'] = array(
                "item_name" => "Paypal Payment",
                "currency" => "GBP",
                "amount" => order_total_price($order_id),
                "custom" => $order_id
            );
            $notify_url = site_url('order-notify');
            $this->data['setting'] = array(
                "website_name" => "" . $this->data['site_settings']->site_name . "",
                "url" => "" . base_url() . "",
                "notify_url" => "" . $notify_url . "",
                "return_url" => "" . base_url() . "success/" . $order_id,
                "cancel_url" => "" . base_url() . "cancel/" . $order_id,
            );

            if ($this->data['site_settings']->site_paypal_environment) :
                $this->data['setting']["sandbox"] = true;
                $this->data['setting']["sandbox_paypal"] = $this->data['site_settings']->site_sandbox_paypal;
            else :
                $this->data['setting']["live_paypal"] = $this->data['site_settings']->site_live_paypal;
            endif;
            // pr($this->data);
            $this->load->view("includes/processing", $this->data);
        } else
            exit('Access Denied!');
    }

    function error()
    {
        $this->load->view('pages/404', $this->data);
    }
}
