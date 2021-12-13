<?php
class Booking extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pages_model','page');
        $this->load->model('member_model');
        $this->load->model('order_model');
        $this->load->model('OrderD_model', 'orderd_model');
    }
    
    function index($mem_id, $miles)
    {
        $this->if_booking_running();  
        check_valid_id('members', $mem_id, 'mem_id');
        $mem_id = doDecode($mem_id);
        $this->data['miles']  = doDecode($miles);
        $this->data['vendor_id'] = $mem_id;

        $meta = $this->page->getMetaContent('booking');
		$this->data['page_title'] = $meta->page_name;
		$this->data['slug'] = $meta->slug;
		$data = $this->page->getPageContent('booking');
        $this->data['selections'] = $selections = $this->session->selection;
        $this->data['services']  = $selections['selected_service'];
        $this->data['qty']       = $qty = $selections['qty'];
        $this->data['zipcode']   = $selections['zipcode'];
        $this->data['facility_hours'] = $facility_hours = $this->master->get_data_row('mem_facility_hours', ['mem_id'=> $this->data['vendor_id']]);
        //VENDOR
        $this->data['vendor'] = $vendor = $this->member_model->getMember($this->data['vendor_id']);
        $this->data['estimated_total'] = 0; 
        foreach($selections['selected_service'] as $index => $value):
            $row = sub_service_price($value, $this->data['vendor_id']);
            $this->data['estimated_total'] += $row->price*$qty[$index];
        endforeach;
        // OPEN DAYS
        $tomorrow   = date('Y-m-d', strtotime('tomorrow'));
        $daysToshow = date('Y-m-d', strtotime("$tomorrow +11 days"));
        $this->data['close_days'] = [];
        foreach(weekDays() as $index => $day):
            $key = $day.'_opening';
            if($facility_hours->$key == 'closed' || $facility_hours->$key == ''):
                $this->data['close_days'][] = $day;
            endif;
        endforeach;
        $this->data['open_days'] = [];
        $start      = new DateTime($tomorrow);
        $daysToshow = new DateTime($daysToshow);
        $open_days = [];
        while ($start <= $daysToshow) {
            $day = strtolower(date('D', strtotime($start->format('Y-m-d'))));
            if(!in_array($day, $this->data['close_days']))
            {
                $open_days[] = $start->format('Y-m-d');
            }
            $start->modify('+1 day');
        }
        $this->data['open_days'] = $open_days;
        $coming_date = new DateTime($open_days[0]);
        $coming_day  = strtolower(date('D', strtotime($coming_date->format('Y-m-d'))));

        $facility_hours = $this->master->get_data_row('mem_facility_hours', ['mem_id' => $mem_id]);
        $coming_day = strtotime($coming_day);
        $coming_day = date('D', $coming_day);
        $coming_day = strtolower($coming_day);
        $key_opening = $coming_day . '_opening';
        $key_closing = $coming_day . '_closing';

        $opening_time = $facility_hours->$key_opening;
        $closing_time = $facility_hours->$key_closing;

        $html = oneHourTimeByGiven('', $opening_time, $closing_time);
        $this->data['coming_day_times'] = $html;

        //First Opened Day
        $this->data['selected_day'] = date_picker_format_date($open_days[0], 'D, d M', false);
        //START END SELECTED DAY TIME
        $day = $selections['place-order']['collection_date'];
        $dayIndex = explode('-', $day);
        $day = $dayIndex[2].'-'.$dayIndex[0].'-'.$dayIndex[1];
        $day = strtotime($day);
        $day = date('D', $day);
        $day = strtolower($day);
        $key_opening = $day.'_opening';
        $key_closing = $day.'_closing';
        $this->data['collection_opening'] = $facility_hours->$key_opening;
        $this->data['collection_closing'] = $facility_hours->$key_closing;
        $day = $selections['place-order']['delivery_date'];
        $dayIndex = explode('-', $day);
        $day = $dayIndex[2].'-'.$dayIndex[0].'-'.$dayIndex[1];
        $day = strtotime($day);
        $day = date('D', $day);
        $day = strtolower($day);
        $key_opening = $day.'_opening';
        $key_closing = $day.'_closing';
        $this->data['delivery_opening'] = $facility_hours->$key_opening;
        $this->data['delivery_closing'] = $facility_hours->$key_closing;
        if($this->input->post())
        {
            $res = array();
            $res['frm_reset'] = 0;
            $res['hide_msg'] = 0;
            $res['scroll_to_msg'] = 0;
            $res['status'] = 0;
            $res['redirect_url'] = 0;
            $post = html_escape($this->input->post());
            $this->form_validation->set_rules('address_type', 'Address Type', 'trim|required');
            if(empty($this->session->mem_id))
            {
                $this->form_validation->set_rules('mem_fname', 'First Name', 'trim|required|alpha|min_length[2]|max_length[20]', ['alpha'=> 'First Name should contains only letters and avoid space.', 'min_length'=> 'First Name should contains atleast 2 letters.', 'max_length'=> 'First Name should not be greater than 20 letters.']);
                $this->form_validation->set_rules('mem_lname', 'Last Name', 'trim|required|alpha|min_length[2]|max_length[20]', ['alpha'=> 'Last Name should contains only letters and avoid space.', 'min_length'=> 'Last Name should contains atleast 2 letters.', 'max_length'=> 'Last Name should not be greater than 20 letters.']);
                $this->form_validation->set_rules('mem_email', 'Email', 'trim|required|valid_email');
                $this->form_validation->set_rules('mem_phone', 'Phone', 'trim|required');
                $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|callback_is_password_strong', ['is_password_strong'=> 'Password should contains alteast 1 small letter, 1 capital letter, 1 number, and one special characher.']);
                $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]', ['matches'=> 'Confirm password must be the as the password.']);
                $this->form_validation->set_rules('address_country', 'Country', 'trim|required');
                $this->form_validation->set_rules('address_state', 'State', 'trim|required');
                $this->form_validation->set_rules('address_city', 'City', 'trim|required');
                $this->form_validation->set_rules('address_zip', 'Zip', 'trim|required');
                $this->form_validation->set_rules('address_field', 'Address', 'trim|required');
            }
            else
            {
                $this->form_validation->set_rules('address', 'Address', 'trim|required');
            }
            
            if($post['use_pickdrop'] == 'on')
            {
                $this->form_validation->set_rules('collection_date', 'Collection Date', 'trim|required');
                $this->form_validation->set_rules('collection_time', 'Collection Time', 'trim|required');
                $this->form_validation->set_rules('collection_from', 'Collection From', 'trim|required');
                $this->form_validation->set_rules('delivery_date', 'Delivery Date', 'trim|required');
                $this->form_validation->set_rules('delivery_time', 'Delivery Time', 'trim|required');
                $this->form_validation->set_rules('delivery_from', 'Delivery From', 'trim|required');
            }
            if($this->form_validation->run() === FALSE) 
            {
                $res['msg'] = validation_errors();
            }
            else
            {
                $order = [];
                if(empty($this->session->mem_id))
                {
                    // IF NEW MEMBER
                    $mem_row = $this->member_model->emailExists($post['mem_email']);
                    if (count($mem_row) == '0')
                    {
                        $rando = doEncode(rand(99, 999).'-'.$post['email']);
                        $rando = strlen($rando) > 225 ? substr($rando, 0, 225) : $rando;
                        $buyer_data['mem_fname'] = ucfirst($post['mem_fname']);
                        $buyer_data['mem_lname'] = ucfirst($post['mem_lname']);
                        $buyer_data['mem_email'] = $post['mem_email'];
                        $buyer_data['mem_phone'] = $post['mem_phone'];
                        $buyer_data['mem_pswd'] = doEncode($post['password']);
                        $buyer_data['mem_code'] = $rando;
                        $buyer_data['mem_type'] = 'buyer';
                        $buyer_data['mem_status'] = 1;
                        $buyer_data['mem_last_login'] = date('Y-m-d h:i:s');

                        $order['buyer_fname'] = ucfirst($post['mem_fname']);
                        $order['buyer_lname'] = ucfirst($post['mem_lname']);
                        $order['buyer_email'] = $post['mem_email'];
                        $order['buyer_phone'] = $post['mem_phone'];
                        if($post['address_type'] == 'home')
                        {
                            $buyer_data['mem_country'] = $post['address_country']; 
                            $buyer_data['mem_state']   = $post['address_state']; 
                            $buyer_data['mem_city']    = trim($post['address_city']); 
                            $buyer_data['mem_address'] = trim($post['address_field']); 
                            $buyer_data['mem_zip']     = trim($post['address_zip']); 
                            $buyer_data['mem_map_lat'] = $post['mem_map_lat']; 
                            $buyer_data['mem_map_lng'] = $post['mem_map_lng']; 
                        }
                        elseif($post['address_type'] == 'office')
                        {
                            $buyer_data['mem_business_country'] = $post['address_country']; 
                            $buyer_data['mem_business_state']   = $post['address_state']; 
                            $buyer_data['mem_business_city']    = trim($post['address_city']); 
                            $buyer_data['mem_business_address'] = trim($post['address_field']); 
                            $buyer_data['mem_business_zip']     = trim($post['address_zip']); 
                            $buyer_data['mem_business_map_lat'] = $post['mem_map_lat']; 
                            $buyer_data['mem_business_map_lng'] = $post['mem_map_lng']; 
                        }
                        elseif($post['address_type'] == 'hotel')
                        {
                            $buyer_data['mem_hotel_country'] = $post['address_country']; 
                            $buyer_data['mem_hotel_state']   = $post['address_state']; 
                            $buyer_data['mem_hotel_city']    = trim($post['address_city']); 
                            $buyer_data['mem_hotel_address'] = trim($post['address_field']); 
                            $buyer_data['mem_hotel_zip']     = trim($post['address_zip']); 
                            $buyer_data['mem_hotel_map_lat'] = $post['mem_map_lat']; 
                            $buyer_data['mem_hotel_map_lng'] = $post['mem_map_lng']; 
                        }
                        $buyer_id = $this->member_model->save($buyer_data);
                        $order['address'] = trim($post['address_city']).' '.trim($post['address_field']).' '.trim($post['address_zip']);
                        $verify_link = site_url('verification/' .$rando);
                        $mem_data = array('name' => ucfirst($post['mem_fname']).' '.ucfirst($post['mem_lname']), "email" => $post['mem_email'], "link" => $verify_link);
                        $this->send_site_email($mem_data, 'signup');
                    }
                    else
                    {
                        $res['status'] = 0;
                        $res['msg'] = 'E-mail Address Already In Use';
                        exit(json_encode($res));
                    }
                }   
                else
                {
                    $buyer_id = $this->session->mem_id;
                    $buyer = $this->member_model->getMember($buyer_id);
                    $order['buyer_fname'] = $buyer->mem_fname;
                    $order['buyer_lname'] = $buyer->mem_lname;
                    $order['buyer_email'] = $buyer->mem_email;
                    $order['buyer_phone'] = $buyer->mem_phone;
                    $order['address']     = $post['address'];
                }
                // CHECK BUYER CREDIT
                $total_buyer_order = intval($this->master->num_rows('orders', ['order_status'=>'Completed', 'buyer_id'=>$buyer_id]));
                $buyer_credits     = $total_buyer_order % 10;
                #ORDER DATA
                $order['buyer_id']  = $buyer_id;
                $order['vendor_id'] = $this->data['vendor_id'];
                $order['searched_zipcode']  = $selections['zipcode'];
                $order['extra_address_detail'] = $post['extra_address_detail'];
                $order['address_type']      = $post['address_type'];
                $order['location_map_lat']  = $selections['lat'];
                $order['location_map_long'] = $selections['long'];
                $order['order_price'] = 0; 
                foreach($post['selected_service'] as $key => $value):
                    $row = sub_service_price($value, $this->data['vendor_id']);
                    $order['order_price'] += $row->price*($post['qty'][$key]);
                endforeach;
                if($post['use_pickdrop'] == 'on')
                {
                    $order['pick_and_drop_service'] = '1';
                    if($order['order_price'] > $vendor->mem_charges_free_over)
                    {
                        $order['free_pick_and_drop_service'] = '1';
                        $order['pick_and_drop_charges'] = 0;
                    }
                    else
                    {
                        $order['pick_and_drop_charges'] = $vendor->mem_charges_per_miles*2;
                    }
                    $order['collection_from'] = $order['address'];
                    $order['collection_date'] = db_format_date($post['collection_date']);
                    $order['collection_time'] = $post['collection_time'];
                    $order['delivery_to']     = $order['address'];
                    $order['delivery_date']   = db_format_date($post['delivery_date']);
                    $order['delivery_time']   = $post['delivery_time'];
                    $order['collection_or_delivery_notes'] = $post['collection_or_delivery_notes'];
                    $order['drop_type']       = $post['drop_type'];
                }
                else
                {
                    $order['delivery_date']   = db_format_date($post['delivery_date']);
                    $order['delivery_time']   = $post['delivery_time'];
                    $order['address'] = $vendor->mem_business_city.'@'.$vendor->mem_business_address.'@'.$vendor->mem_business_zip;
                }
                $order['order_total_price'] = price_format($order['order_price'] + $order['pick_and_drop_charges']);
                if($buyer_credits === intval(BUYER_ORDER_CREDITS))
                {
                    $order['buyer_get_credit'] = '1';
                    $order['buyer_credit_discount']   = price_format($order['order_total_price'] / 100 * intval($this->data['site_settings']->site_buyer_credit_percentage));
                    $order['buyer_credit_percentage'] = intval($this->data['site_settings']->site_buyer_credit_percentage);
                    $order['order_total_price']      -= $order['buyer_credit_discount'];
                }
                
                $order['order_status'] = 'New';
                $order['site_percentage'] = $this->data['site_settings']->site_percentage;
                $order_total_price = price_format($order['order_total_price']); 
                if ($post['payment_type'] == 'paypal') 
                    $order['paypal_pending'] = 'yes';
                unset($order['order_price']);
                unset($order['order_total_price']);
                unset($order['buyer_credit_discount']);
                $order_id = $this->order_model->save($order);
                if($order_id > 0)
                {
                    foreach($post['selected_service'] as $key => $value):
                        $order_detail = [];
                        $row = get_sub_service($value, $this->data['vendor_id']);
                        $order_detail['order_id']           = $order_id;
                        $order_detail['sub_service_id']     = $value;
                        $order_detail['quantity']           = $post['qty'][$key];
                        $order_detail['sub_service_price']  = $row->price;
                        $order_detail['sub_service_name']   = $row->name;
                        $this->orderd_model->save($order_detail);
                    endforeach;
                }
                $payment_status = [];
                if ($post['payment_type'] == 'credit-card') 
                {
                    include_once APPPATH . "libraries/stripe/init.php";
                    \Stripe\Stripe::setApiKey(API_SECRET_KEY);
                    try {
                        if (!isset($post['nonce']))
                            throw new Exception("The Stripe Token was not generated correctly");
                        $cents   = $order_total_price*100;
                        $charge = \Stripe\Charge::create([
                            "amount"      => $cents,
                            "currency"    => "gbp",
                            "source"      => $post['nonce'],
                            "description" => "Customer Charge",
                            "statement_descriptor" => "Paid successfully"
                        ]);
                    }
                    catch (Exception $e)
                    {
                        $res['msg']    = $e->getMessage();
                        $res['status'] = 0;
                        exit(json_encode($res));
                    }
                    $order_invoice = [];
                    $order_invoice['order_id']  = $order_id;
                    $order_invoice['charge_id'] = $charge['id'];
                    $order_invoice['payment_method'] = 'stripe';
                    $order_invoice['payment_status'] = 'paid';
                    $this->master->save('order_invoices', $order_invoice);
                    # ORDER LOG
                    $this->master->save('order_logs', ['mem_id'=> $this->data['vendor_id'], 'order_id'=> $order_id, 'mem_type'=> 'vendor', 'status'=> 'dirty']);
                    $this->master->save('order_logs', ['mem_id'=> $buyer_id, 'order_id'=> $order_id, 'mem_type'=> 'buyer', 'status'=> 'dirty']);
                }
                if ($order_id > 0)
                {
                    $notify_txt = 'You have recieved new order. <a href="@@vendor/order-detail/'.doEncode($order_id).'">Click here</a> to view.';
                    $notify = ['mem_id'=> $this->data['vendor_id'], 'from_id'=> $buyer_id, 'txt'=> $notify_txt, 'cat'=> 'new_order'];
                    $this->master->save('notifications', $notify);
                    $this->session->set_userdata('mem_id', $buyer_id);
                    $this->session->set_userdata('mem_type', 'buyer');
                    if ($post['payment_type'] == 'credit-card') 
                    {
                        $res['msg'] = 'Your order has been completed successfully. We will contact you shortly.';
                        $res['status'] = 1;
                        $res['redirect_url'] = base_url('order-success/'.doEncode($order_id));
                    }
                    else
                    {
                        $res['msg'] = 'Your order has been completed successfully. Your are reditect to paypal for payment';
                        $res['status'] = 1;
                        $res['redirect_url'] = base_url('paypal/'.doEncode($order_id));
                    }
                }
                else
                {
                    $res['status'] = 0;
                    $res['msg'] = 'Your order has not been completed successfully. Please try again';
                }
            }
            exit(json_encode($res));
        }
		if($data)
        {
			$this->data['content']       = unserialize($data->code);
			$this->data['meta_desc']     = json_decode($meta->content);
			$this->data['wash_and_dry']  = $this->master->get_data_row('services', ['id'=> '1']);
            $this->data['wash_and_iron'] = $this->master->get_data_row('services', ['id'=> '3']);
            $this->data['dry_cleaning']  = $this->master->get_data_row('services', ['id'=> '4']);
            $this->data['iron_only']     = $this->master->get_data_row('services', ['id'=> '5']);
            $this->data['buly_items']    = $this->master->get_data_row('services', ['id'=> '6']);
            $this->data['deals']         = $this->master->get_data_row('services', ['id'=> '7']);
			$this->load->view('booking/booking',$this->data);
		}
        else
        {
			show_404();
		}
    }
	function success($order_id)
    {
        $this->if_booking_running();
        $this->session->unset_userdata('selections');
        $meta = $this->page->getMetaContent('terms_conditions');
        $this->data['page_title'] = $meta->page_name;
        $this->data['slug'] = $meta->slug;
        $this->data['order_id'] = $order_id;
        $order = $this->order_model->get_row(doDecode($order_id)); 
        $this->data['vendor'] = $this->member_model->get_row($order->vendor_id); 
        $data = $this->page->getPageContent('terms_conditions');
        if($data)
        {
            $this->data['content'] = unserialize($data->code);
            $this->data['details'] = ($data->full_code);
            $this->data['meta_desc'] = json_decode($meta->content);
            $this->load->view('buyer/order-confirmed', $this->data);
        }
        else
        {
            show_404();
        }
	}
	function cancel()
    {
        $this->if_booking_running();
        $this->session->unset_userdata('selections');
        $meta = $this->page->getMetaContent('terms_conditions');
        $this->data['page_title'] = $meta->page_name;
        $this->data['slug'] = $meta->slug;
        $this->data['order_id'] = $order_id;
        $data = $this->page->getPageContent('terms_conditions');
        if($data)
        {
            $this->data['content'] = unserialize($data->code);
            $this->data['details'] = ($data->full_code);
            $this->data['meta_desc'] = json_decode($meta->content);
            $this->load->view('buyer/order-cancelled', $this->data);
        }
        else
        {
            show_404();
        }
	}
    function error()
    {
        $this->load->view("pages/404", $this->data);
    }
    ### callback functions
    public function is_password_strong($password)
    {
        $whiteListedSpecial = "\$\@\#\^\|\!\~\=\+\-\_\.";
        if (preg_match('#[0-9]#', $password) && preg_match('#[a-zA-Z]#', $password) && preg_match('/['.$whiteListedSpecial.']/', $password)) {
            return TRUE;
        }
        return FALSE;
    }
}
