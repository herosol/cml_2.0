<?php

class Vendor extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('member_model');
        $this->load->model('order_model');
        $this->load->model('OrderD_model', 'orderd_model');
    }

    public function dashboard()
    {
        $this->isMemLogged($this->session->mem_type, false, $this->uri->segment(1));
        $mem_id = $this->session->mem_id;
        if ($this->input->post()) {
            $res = [];
            $user_info = [];
            $res['hide_msg'] = 0;
            $res['scroll_to_msg'] = 1;
            $res['status'] = 0;
            $res['frm_reset'] = 0;
            $res['redirect_url'] = 0;

            $post = html_escape($this->input->post());
            $this->form_validation->set_message('integer', 'Please select a valid {field}');
            $this->form_validation->set_rules('mem_fname', 'First Name', 'trim|required|alpha|min_length[2]|max_length[20]', ['alpha' => 'First Name should contains only letters and avoid space.', 'min_length' => 'First Name should contains atleast 2 letters.', 'max_length' => 'First Name should not be greater than 20 letters.']);
            $this->form_validation->set_rules('mem_lname', 'Last Name', 'trim|required|alpha|min_length[2]|max_length[20]', ['alpha' => 'Last Name should contains only letters and avoid space.', 'min_length' => 'Last Name should contains atleast 2 letters.', 'max_length' => 'Last Name should not be greater than 20 letters.']);
            $this->form_validation->set_rules('mem_company_name', 'Company name', 'trim|required');
            $this->form_validation->set_rules('mem_company_email', 'Company email', 'trim|required|valid_email');
            $this->form_validation->set_rules('mem_company_phone', 'Company phone', 'trim|required');
            $this->form_validation->set_rules('mem_company_order_email', 'Company order email', 'trim|required|valid_email');
            $this->form_validation->set_rules('mem_company_website', 'Company website', 'trim|required');
            $this->form_validation->set_rules('mem_company_trustpilot', 'Trustpilot And Google Review URL', 'trim|required');
            $this->form_validation->set_rules('mem_company_pickdrop', 'Company Pickup & Drop', 'trim|required');
            $this->form_validation->set_rules('mem_company_walkin_facility', 'Company walk in facility', 'trim|required');
            if ($post['mem_company_walkin_facility'] == 'no' && $post['mem_company_pickdrop'] == 'no') {
                $res['msg'] = 'Please Choose altleast one of the following<br>1. Pick And Drop Service <br>2.Walk In Facility';
                exit(json_encode($res));
            }
            if ($post['mem_company_walkin_facility'] == 'yes') {
                $this->form_validation->set_rules('mem_business_country', 'Business country', 'trim|required');
                $this->form_validation->set_rules('mem_business_state', 'Business state', 'trim|required');
                $this->form_validation->set_rules('mem_business_city', 'Business city', 'trim|required');
                $this->form_validation->set_rules('mem_business_zip', 'Business zip', 'trim|required');
                $this->form_validation->set_rules('mem_business_address', 'Business address', 'trim|required');
                $scheduleCheck = true;
                foreach (weekDays() as $dayPrefix) {
                    $day_opening = '';
                    $day_closing = '';
                    $day_opening = $dayPrefix . '_opening';
                    $day_closing = $dayPrefix . '_closing';
                    if (!empty($post[$day_opening]) && $post[$day_opening] != 'closed')
                        $scheduleCheck = false;

                    if (!empty($post[$day_closing]) && $post[$day_closing] != 'closed')
                        $scheduleCheck = false;
                }
                if ($scheduleCheck)
                    $this->form_validation->set_rules('atleast_one_day', 'Atleast One Day', 'required', ['required' => 'Please enter opening and closing hours of atleast one day.']);
            }

            if ($post['mem_company_pickdrop'] == 'yes') {
                if (!empty($post['pickup_zip']))
                    $this->form_validation->set_rules('mem_map_lat', 'Pick Up', 'required', ['required'  => 'You have not provided Correct Zip for %s.']);

                $this->form_validation->set_rules('pickup_zip', 'Pickup and collection zip', 'trim|required');
                $this->form_validation->set_rules('mem_charges_per_miles', 'Charges per mils', 'trim|required');
                $this->form_validation->set_rules('mem_charges_free_over', 'Charges free over', 'trim|required');
                $this->form_validation->set_rules('mem_charges_min_order', 'Minimum order value', 'trim|required');
            }


            if ($this->form_validation->run() === FALSE)
                $res['msg'] = validation_errors();

            if (!empty($res['msg']))
                exit(json_encode($res));

            if (isset($_FILES["dp_image"]["name"]) && $_FILES["dp_image"]["name"] != "") {
                $image = upload_file(UPLOAD_PATH . 'members', 'dp_image');
                if (!empty($image['file_name'])) {
                    $this->remove_file($mem_id, 'image');
                    generate_thumb(UPLOAD_PATH . "members/", UPLOAD_PATH . "members/", $image['file_name'], 100, 'thumb_');
                    generate_thumb(UPLOAD_PATH . "members/", UPLOAD_PATH . "members/", $image['file_name'], 300, '300p_');
                } else {
                    $res['msg'] = '<p> Please upload a valid image file >> ' . strip_tags($image['error']) . '</p>';
                    exit(json_encode($res));
                }
                $user_info['mem_image'] = $image['file_name'];
                $res['dp_image'] = '<img src="' . get_site_image_src("members", $user_info['mem_image'], '300p_') . '" alt="">';
            }

            # MEMBER INFO TO BE SAVE
            $user_info['mem_fname'] = $post['mem_fname'];
            $user_info['mem_lname'] = $post['mem_lname'];
            $user_info['mem_company_name']        = $post['mem_company_name'];
            $user_info['mem_company_email']       = $post['mem_company_email'];
            $user_info['mem_company_phone']       = $post['mem_company_phone'];
            $user_info['mem_company_order_email'] = $post['mem_company_order_email'];
            $user_info['mem_company_website']     = $post['mem_company_website'];
            $user_info['mem_company_trustpilot']  = $post['mem_company_trustpilot'];
            $user_info['mem_company_pickdrop']    = $post['mem_company_pickdrop'];
            $user_info['mem_company_walkin_facility'] = $post['mem_company_walkin_facility'];
            if ($post['mem_company_walkin_facility'] == 'yes') {
                $user_info['mem_business_country'] = $post['mem_business_country'];
                $user_info['mem_business_state']   = $post['mem_business_state'];
                $user_info['mem_business_city']    = $post['mem_business_city'];
                $user_info['mem_business_zip']     = $post['mem_business_zip'];
                $user_info['mem_business_address'] = $post['mem_business_address'];
            }
            if ($user_info['mem_company_pickdrop'] == 'yes') {
                $user_info['pickup_zip']      = $post['pickup_zip'];
                $user_info['mem_map_lat'] = $post['mem_map_lat'];
                $user_info['mem_map_lng'] = $post['mem_map_lng'];
                $user_info['mem_charges_per_miles'] = $post['mem_charges_per_miles'];
                $user_info['mem_charges_free_over'] = $post['mem_charges_free_over'];
                $user_info['mem_charges_min_order'] = $post['mem_charges_min_order'];
                $user_info['mem_travel_radius']     = $post['mem_travel_radius'];
            }

            $this->member_model->save($user_info, $mem_id);

            # MEMBER FACILITY HOURS
            if ($post['mem_company_walkin_facility'] == 'yes') {
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
                if ($this->master->num_rows('mem_facility_hours', ['mem_id' => $mem_id]) > 0) {
                    $this->master->save('mem_facility_hours', $facility_hours, 'mem_id', $mem_id);
                } else {
                    $facility_hours['mem_id'] = $mem_id;
                    $this->master->save('mem_facility_hours', $facility_hours);
                }
            }

            $res['msg'] = showMsg('success', 'Profile update successfully!');
            $res['status'] = 1;
            $res['hide_msg'] = 1;
            $res['name_head'] = '<span class="regular">Welcome,</span> Dear, ' . $user_info['mem_fname'] . ' ' . $user_info['mem_lname'] . '!<span class="regular">Nice to see you again.</span>';
            exit(json_encode($res));
        }

        $this->data['facility_hours'] = $this->master->get_data_row('mem_facility_hours', ['mem_id' => $mem_id]);
        $this->load->view('vendor/dashboard', $this->data);
    }

    public function notifications()
    {
        $this->isMemLogged($this->session->mem_type, true, $this->uri->segment(1));
        $clear = $this->member_model->clear_notifs();
        $this->data['notifications'] = $this->master->get_data_rows('notifications', ['mem_id'=> $this->session->mem_id], 'DESC');
        $this->load->view('vendor/notifications', $this->data);
    }

    public function orders()
    {
        $this->isMemLogged($this->session->mem_type, true, $this->uri->segment(1));
        // ALL ORDERS
        $orders = $this->order_model->get_vendor_orders();
        $services = [];
        foreach ($orders as $index => $order) :
            $order_detail = $this->orderd_model->get_rows(['order_id' => $order->order_id]);
            foreach ($order_detail as $key => $row) :
                $sub_service = $this->master->get_data_row('sub_services', ['id' => $row->sub_service_id]);
                $service     = $this->master->get_data_row('services', ['id' => $sub_service->service_id]);
                if (!in_array($service->name, $services)) {
                    $services[] = $service->name;
                }
            endforeach;
            $orders[$index]->services = $services;
        endforeach;
        $this->data['orders'] = $orders;

        // DELIVERED ORDERS
        $delivered_orders = $this->order_model->get_vendor_orders(['order_status'=> 'Delivered']);
        $services = [];
        foreach ($delivered_orders as $index => $order) :
            $order_detail = $this->orderd_model->get_rows(['order_id' => $order->order_id]);
            foreach ($order_detail as $key => $row) :
                $sub_service = $this->master->get_data_row('sub_services', ['id' => $row->sub_service_id]);
                $service     = $this->master->get_data_row('services', ['id' => $sub_service->service_id]);
                if (!in_array($service->name, $services)) {
                    $services[] = $service->name;
                }
            endforeach;
            $delivered_orders[$index]->services = $services;
        endforeach;
        $this->data['delivered_orders'] = $delivered_orders;

        // CANCELED ORDERS
        $canceled_orders = $this->order_model->get_vendor_orders(['order_status'=> 'Cancelled']);
        $services = [];
        foreach ($canceled_orders as $index => $order) :
            $order_detail = $this->orderd_model->get_rows(['order_id' => $order->order_id]);
            foreach ($order_detail as $key => $row) :
                $sub_service = $this->master->get_data_row('sub_services', ['id' => $row->sub_service_id]);
                $service     = $this->master->get_data_row('services', ['id' => $sub_service->service_id]);
                if (!in_array($service->name, $services)) {
                    $services[] = $service->name;
                }
            endforeach;
            $canceled_orders[$index]->services = $services;
        endforeach;
        $this->data['canceled_orders'] = $canceled_orders;

        $this->load->view('vendor/orders', $this->data);
    }

    public function order_detail($order_id)
    {
        $this->isMemLogged($this->session->mem_type, true, $this->uri->segment(1));
        $order_id = doDecode($order_id);
        $this->master->update('order_logs', ['status' => 'clean'], ['mem_id' => $this->session->mem_id, 'mem_type' => $this->session->mem_type, 'order_id' => $order_id]);
        $this->data['order'] = $this->order_model->vendor_order_detail($order_id);
        $this->data['order_detail'] = $this->orderd_model->get_rows(['order_id' => $order_id, 'service_type' => 'basic']);
        $this->data['amended'] = $this->orderd_model->get_rows(['order_id' => $order_id, 'service_type' => 'amended']);
        $this->data['review']  = $this->order_model->mem_review($order_id);
        $delivery_proofs = $this->master->get_data_rows('order_delivery_proof', ['order_id' => $order_id], 'DESC', 'proof_id');
        $this->data['delivery_proof'] = false;

        if (empty($delivery_proofs)) {
            $this->data['delivery_proof'] = true;
        } else {
            foreach ($delivery_proofs as $index => $row) :
                if ($index == 0) :
                    if ($row->status == 'rejected')
                        $this->data['delivery_proof'] = true;
                endif;
            endforeach;
        }

        $this->load->view('vendor/order-detail', $this->data);
    }

    public function credits()
    {
        $this->isMemLogged($this->session->mem_type, true, $this->uri->segment(1));
        $order = $this->order_model->get_latest_order();
        $order_detail = $this->orderd_model->get_rows(['order_id' => $order->order_id]);
        $services = [];
        foreach ($order_detail as $key => $row) :
            $sub_service = $this->master->get_data_row('sub_services', ['id' => $row->sub_service_id]);
            $service     = $this->master->get_data_row('services', ['id' => $sub_service->service_id]);
            if (!in_array($service->name, $services)) {
                $services[] = $service->name;
            }
        endforeach;
        if (!empty($order)) {
            $order->services = $services;
        }
        $this->data['latest_order'] = $order;
        $this->data['today_sales']  = $this->order_model->vendor_today_sales();
        $this->data['week_sales']   = $this->order_model->vendor_week_sales();
        $this->data['month_sales']  = $this->order_model->vendor_month_sales();
        $this->load->view('vendor/credits', $this->data);
    }

    public function facility_hours()
    {
        $this->isMemLogged($this->session->mem_type, true, $this->uri->segment(1));
        $this->data['facility_hours'] = $this->master->get_data_row('mem_facility_hours', ['mem_id' => $this->session->mem_id]);
        $this->load->view('vendor/facility-hours', $this->data);
    }

    public function price_list()
    {
        $this->isMemLogged($this->session->mem_type, true, $this->uri->segment(1));
        if ($this->input->post()) {
            $res = array();
            $res['hide_msg'] = 0;
            $res['scroll_to_msg'] = 1;
            $res['status'] = 0;
            $res['frm_reset'] = 0;
            $res['redirect_url'] = 0;

            $post = html_escape($this->input->post());
            if ($this->form_validation->run() === FALSE)
                $res['msg'] = validation_errors();

            if (!empty($res['msg']))
                exit(json_encode($res));

            foreach ($post['sub_service'] as $sub_service_id => $sub_service) :
                $price =
                    [
                        'sub_service_id' => $sub_service_id,
                        'price'          => $sub_service['price'] == '' ? '0' : $sub_service['price'],
                        'mem_id'         => $this->session->mem_id
                    ];

                $row = $this->master->get_data_row('price_list', ['sub_service_id' => $sub_service_id, 'mem_id' => $this->session->mem_id]);
                if (count($row) > 0)
                    $this->master->save('price_list', $price, 'id', $row->id);
                else
                    $this->master->save('price_list', $price);

            endforeach;

            $res['msg'] = showMsg('success', 'Price list update successfully!');
            $res['status'] = 1;
            $res['hide_msg'] = 1;
            exit(json_encode($res));
        }

        $this->data['wash_and_dry']  = $this->master->get_data_row('services', ['id' => '1']);
        $this->data['wash_and_iron'] = $this->master->get_data_row('services', ['id' => '3']);
        $this->data['dry_cleaning']  = $this->master->get_data_row('services', ['id' => '4']);
        $this->data['iron_only']     = $this->master->get_data_row('services', ['id' => '5']);
        $this->data['buly_items']    = $this->master->get_data_row('services', ['id' => '6']);
        $this->data['deals']         = $this->master->get_data_row('services', ['id' => '7']);
        $this->load->view('vendor/price-list', $this->data);
    }

    public function bank_accounts()
    {
        $this->isMemLogged($this->session->mem_type, false, $this->uri->segment(1));
        if ($this->input->post()) {
            $res = [];
            $res['hide_msg'] = 0;
            $res['scroll_to_msg'] = 1;
            $res['status'] = 0;
            $res['frm_reset'] = 0;
            $res['redirect_url'] = 0;

            $post = html_escape($this->input->post());
            $this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required');
            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required');
            $this->form_validation->set_rules('short_code', 'Short Code', 'trim|required');
            $this->form_validation->set_rules('beneficiary_name', 'Beneficiary Name', 'trim|required');

            if ($this->form_validation->run() === FALSE)
                $res['msg'] = validation_errors();

            if (!empty($res['msg']))
                exit(json_encode($res));

            # BANK INFO TO BE SAVE
            $bank_id = intval(doDecode($post['bank_id']));
            unset($post['bank_id']);
            $post['mem_id'] = $this->session->mem_id;

            if ($bank_id > 0)
                $this->master->save('mem_bank_accounts', $post, 'id', $bank_id);
            else
                $this->master->save('mem_bank_accounts', $post);

            $res['msg'] = showMsg('success', 'Bank detail saved successfully!');
            $res['status'] = 1;
            $res['hide_msg'] = 1;
            $res['html'] = get_mem_banks($this->session->mem_id);
            exit(json_encode($res));
        } else {
            $this->data['banks'] = $this->master->get_data_rows('mem_bank_accounts', ['mem_id' => $mem_id], 'DESC');
            $this->load->view('vendor/bank-accounts', $this->data);
        }
    }

    public function get_location_and_initmap()
    {
        if ($this->input->post()) {
            $res = [];
            $coordinates = get_location_detail(trim($this->input->post('mem_business_zip')));
            echo json_encode(['status' => 'success', 'mem_map_lat' => $coordinates->Latitude, 'mem_map_lng' => $coordinates->Longitude]);
            exit;
        }
        echo json_encode(['status' => 'failed', 'lat' => '', 'long' => '']);
    }

    ### AJAX FUNCTION
    public function amend_invoice()
    {
        if ($this->input->post()) {
            $res = [];
            $res['hide_msg'] = 0;
            $res['scroll_to_msg'] = 0;
            $res['status'] = 0;
            $res['frm_reset'] = 0;
            $res['redirect_url'] = 0;

            $post = html_escape($this->input->post());
            $post['order_id'] = $order_id = doDecode($post['order_id']);

            $this->form_validation->set_rules('sub_service_name', 'Title', 'required|trim');
            $this->form_validation->set_rules('quantity', 'Quantity', 'required|trim');
            $this->form_validation->set_rules('sub_service_price', 'Unit Price', 'required|trim');
            if ($this->form_validation->run() === FALSE)
                $res['msg'] = validation_errors();
            if (!empty($res['msg']))
                exit(json_encode($res));

            $post['service_type'] = 'amended';
            # MEMBER INFO TO BE SAVE
            $is_added = $this->orderd_model->save($post);

            $order = $this->order_model->vendor_order_detail($post['order_id']);
            $order_detail = $this->orderd_model->get_rows(['order_id' => $post['order_id'], 'service_type' => 'basic']);
            $amended = $this->orderd_model->get_rows(['order_id' => $post['order_id'], 'service_type' => 'amended']);
            generate_order_log_for_buyer($post['order_id']);
            // NOTIF
            $notify = [];
            $notify_txt = 'Vendor has generated invoice. <a href="@@buyer/order-detail/'.doEncode($order_id).'">Click here</a> to view.';
            $notify = ['mem_id'=> $order->buyer_id, 'from_id'=> $order->vendor_id, 'txt'=> $notify_txt, 'cat'=> 'amended_invoice'];
            $this->master->save('notifications', $notify);

            $res['msg']       = showMsg('success', 'Invoice sent successfully!');
            $res['status']    = 1;
            $res['hide_msg']  = 1;
            $res['frm_reset'] = 1;
            $res['html'] = amended_invoice($post['order_id'], $amended);
            exit(json_encode($res));
        }
    }

    public function edit_bank_fetch()
    {
        if ($this->input->post()) {
            exit(json_encode(['html' => mem_bank_form($this->input->post('bank_id'))]));
        }
    }

    public function change_order_status()
    {
        if ($this->input->post()) {
            $post = html_escape($this->input->post());
            $status = $post['statusToChange'];
            $order_id = doDecode($post['order_id']);
            $order = $this->order_model->get_row($order_id);

            $is_update = $this->order_model->save(['order_status' => trim($status)], $order_id);
            if ($is_update) {
                $notify = [];
                if($status == 'Cancelled')
                {
                    $notify_txt = 'Your order has been cancelled. <a href="@@buyer/order-detail/'.doEncode($order_id).'">Click here</a> to view.';
                    $notify = ['mem_id'=> $order->buyer_id, 'from_id'=> $order->vendor_id, 'txt'=> $notify_txt, 'cat'=> 'order_cancelled'];
                }
                else if($status == 'In Progress')
                {
                    $notify_txt = 'Vendor has started working on your order. <a href="@@buyer/order-detail/'.doEncode($order_id).'">Click here</a> to view.';
                    $notify = ['mem_id'=> $order->buyer_id, 'from_id'=> $order->vendor_id, 'txt'=> $notify_txt, 'cat'=> 'order_progress'];
                }
                $this->master->save('notifications', $notify);

                exit(json_encode(['status' => 'success']));
            } else {
                exit(json_encode(['status' => 'failed']));
            }
        }
    }

    public function save_notes()
    {
        if ($this->input->post()) {
            $post = html_escape($this->input->post());
            $notes   = $post['notes'];
            $order_id = doDecode($post['order_id']);
            $order = $this->order_model->get_row($order_id);
            
            $is_update = $this->order_model->save(['order_note' => trim($notes)], $order_id);
            $notify = [];
            if ($is_update) {
                $notify_txt = 'Vendor has created order notes. <a href="@@buyer/order-detail/'.doEncode($order_id).'">Click here</a> to view.';
                $notify = ['mem_id'=> $order->buyer_id, 'from_id'=> $order->vendor_id, 'txt'=> $notify_txt, 'cat'=> 'order_notes'];
                $this->master->save('notifications', $notify);
                exit(json_encode(['status' => 'success']));
            } else {
                exit(json_encode(['status' => 'failed']));
            }
        }
    }

    public function complete_order()
    {
        if ($this->input->post()) {
            $res = [];
            $order_info  = [];
            $order_proof = [];
            $res['hide_msg'] = 0;
            $res['scroll_to_msg'] = 1;
            $res['status'] = 0;
            $res['frm_reset'] = 0;
            $res['redirect_url'] = 0;

            $post = html_escape($this->input->post());
            $post['order_id'] = $order_id = doDecode($post['order_id']);

            // pr($_FILES);
            if (empty($_FILES["proof_image"]["name"])) {
                $this->form_validation->set_rules('proof_image', 'Image', 'required');
            }
            $this->form_validation->set_rules('proof_comment', 'Comment', 'required|trim');
            if ($this->form_validation->run() === FALSE)
                $res['msg'] = validation_errors();
            if (!empty($res['msg']))
                exit(json_encode($res));

            $order_proof['order_id']      = $post['order_id'];
            $order_proof['proof_comment'] = $post['proof_comment'];
            if (isset($_FILES["proof_image"]["name"]) && $_FILES["proof_image"]["name"] != "") {
                $image = upload_file(UPLOAD_PATH . 'orders', 'proof_image');
                if (!empty($image['file_name'])) {
                    $order_proof['proof_image'] = $image['file_name'];
                    generate_thumb(UPLOAD_PATH . "orders/", UPLOAD_PATH . "orders/", $image['file_name'], 100, 'thumb_');
                    generate_thumb(UPLOAD_PATH . "orders/", UPLOAD_PATH . "orders/", $image['file_name'], 300, '300p_');
                } else {
                    $res['msg'] = '<p> Please upload a valid image file >> ' . strip_tags($image['error']) . '</p>';
                    exit(json_encode($res));
                }
            }

            # MEMBER INFO TO BE SAVE
            $is_added = $this->master->save('order_delivery_proof', $order_proof);
            # ORDER LOG
            generate_order_log_for_buyer($post['order_id']);
            if ($is_added) {
                $order_info['order_status'] = 'Delivered';
                $this->order_model->save($order_info, $post['order_id']);

                // NOTIFY
                $order = $this->order_model->get_row($order_id);
                $notify_txt = 'Vendor has delivered your order. <a href="@@buyer/order-detail/'.doEncode($order_id).'">Click here</a> to view.';
                $notify = ['mem_id'=> $order->buyer_id, 'from_id'=> $order->vendor_id, 'txt'=> $notify_txt, 'cat'=> 'order_recieved'];
                $this->master->save('notifications', $notify);
            }

            $res['msg'] = showMsg('success', 'Completions request sent successfully!');
            $res['status'] = 1;
            $res['hide_msg'] = 1;
            $res['frm_reset'] = 1;
            $res['status_dropdown'] = order_status_dropdown('Delivered', $post['order_id']);
            $res['delivery_proofs'] =  get_delivey_proof($post['order_id']);
            exit(json_encode($res));
        }
    }

    ### REMOVE FILE
    private function remove_file($id, $type = '')
    {
        $obj = $this->member_model->get_row($id);
        $filepath = UPLOAD_PATH . "members/" . $obj->mem_image;
        $filepath_thumb = UPLOAD_PATH . "members/thumb_" . $obj->mem_image;
        $filepath_300p = UPLOAD_PATH . "members/300p_" . $obj->mem_image;
        if (is_file($filepath))
            unlink($filepath);

        if (is_file($filepath_thumb))
            unlink($filepath_thumb);

        if (is_file($filepath_300p))
            unlink($filepath_300p);
        return;
    }
}
