<?php

class Buyer extends MY_Controller
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
            $res = array();
            $res['hide_msg'] = 0;
            $res['scroll_to_msg'] = 1;
            $res['status'] = 0;
            $res['frm_reset'] = 0;
            $res['redirect_url'] = 0;

            $post = html_escape($this->input->post());
            $this->form_validation->set_message('integer', 'Please select a valid {field}');

            $this->form_validation->set_rules('mem_fname', 'First name', 'trim|required|alpha|min_length[2]|max_length[20]', ['alpha' => 'First Name should contains only letters and avoid space.', 'min_length' => 'First Name should contains atleast 2 letters.', 'max_length' => 'First Name should not be greater than 20 letters.']);
            $this->form_validation->set_rules('mem_lname', 'Last name', 'trim|required|alpha|min_length[2]|max_length[20]', ['alpha' => 'Last Name should contains only letters and avoid space.', 'min_length' => 'Last Name should contains atleast 2 letters.', 'max_length' => 'Last Name should not be greater than 20 letters.']);
            $this->form_validation->set_rules('mem_phone', 'Phone number', 'trim|required');
            $this->form_validation->set_rules('mem_dob', 'Date of birth', 'trim|required');
            $this->form_validation->set_rules('mem_sex', 'Gender', 'trim|required');
            $this->form_validation->set_rules('mem_country', 'Home Address country', 'trim|required');
            $this->form_validation->set_rules('mem_state', 'Home Address state', 'trim|required');
            $this->form_validation->set_rules('mem_city', 'Home Address city', 'trim|required');
            $this->form_validation->set_rules('mem_zip', 'Home Address zip', 'trim|required');
            $this->form_validation->set_rules('mem_address', 'Home Address', 'trim|required');
            // $this->form_validation->set_rules('mem_address_type', 'Home Address Type', 'required');


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
                $post['mem_image'] = $image['file_name'];
                $res['dp_image'] = '<img src="' . get_site_image_src("members", $post['mem_image'], '300p_') . '" alt="">';
            }

            // unset($post['address_type']);
            $post['mem_dob'] = db_format_date($post['mem_dob']);
            $this->member_model->save($post, $mem_id);

            $res['msg'] = showMsg('success', 'Profile update successfully!');
            $res['status'] = 1;
            $res['hide_msg'] = 1;
            $res['name_head'] = '<span class="regular">Welcome,</span> Dear, ' . $post['mem_fname'] . ' ' . $post['mem_lname'] . '!<span class="regular">Nice to see you again.</span>';
            exit(json_encode($res));
        }

        $this->load->view('buyer/dashboard', $this->data);
    }

    public function notifications()
    {
        $this->isMemLogged($this->session->mem_type, true, $this->uri->segment(1));
        // $this->data['notifications'] = $this->order_model->buyer_notifications();
        $this->load->view('buyer/notifications', $this->data);
    }

    public function orders()
    {
        $this->isMemLogged($this->session->mem_type, true, $this->uri->segment(1));
        $orders = $this->order_model->get_buyer_orders();
        $services = [];
        foreach ($orders as $index => $order) :
            $order_detail = $this->master->getRows('order_detail', array('order_id' => $order->order_id));
            $orders[$index]->services = $order_detail;
        endforeach;

        $this->data['orders'] = $orders;
        // pr($orders);
        $this->load->view('buyer/orders', $this->data);
    }

    public function order_detail($o_id)
    {
        $this->isMemLogged($this->session->mem_type, true, $this->uri->segment(1));
        $o_id = intval(doDecode($o_id));
        $this->master->update('order_logs', ['status' => 'clean'], ['mem_id' => $this->session->mem_id, 'mem_type' => $this->session->mem_type, 'order_id' => $o_id]);
        $this->data['order'] = $this->master->getRow('orders', array('order_id' => $o_id));
        $this->data['order_detail'] = $this->master->getRows('order_detail', array('order_id' => $o_id, 'service_type' => 'basic'));
        $this->data['amended'] = $this->orderd_model->get_rows(['order_id' => $o_id, 'service_type' => 'amended']);
        $this->data['delivery_proof'] = $this->master->getRow('order_delivery_proof', array('order_id' => $o_id, 'status' => 'pending'));
        $this->load->view('buyer/order-detail', $this->data);
    }

    public function accept_proof_delivery()
    {
        $this->isMemLogged($this->session->mem_type, true, $this->uri->segment(1));
        if ($this->input->post()) {
            $res = array();
            $res['hide_msg'] = 0;
            $res['scroll_to_msg'] = 1;
            $res['status'] = 0;
            $res['frm_reset'] = 0;
            $res['redirect_url'] = 0;
            // pr($_POST);
            $post = html_escape($this->input->post());
            $this->form_validation->set_rules('review_comment', 'Comment', 'trim|required');

            if ($this->form_validation->run() === FALSE)
                $res['msg'] = validation_errors();

            if (!empty($res['msg']))
                exit(json_encode($res));

            $proof_id = intval(doDecode($post['proof_id']));
            $proof = $this->master->getRow('order_delivery_proof', ['proof_id' => $proof_id]);

            $this->order_model->save(['order_status' => 'Completed', 'completed_date' => date('Y-m-d')], $proof->order_id);
            $proof_data['status'] = 'accepted';
            $this->master->save('order_delivery_proof', $proof_data, 'proof_id', $proof_id);

            //EARNING AMOUNT
            $order   = $this->order_model->get_row($proof->order_id);
            $amended_price = $this->orderd_model->order_amended_price($proof->order_id);
            $amended_price = price_format($amended_price);
            $price = price_format($order->order_total_price + $amended_price);

            $earning_amount = buyer_transaction_price($order->order_id);
            $earning_amount -= price_format($earning_amount / 100 * intval($order->site_percentage));


            $review['mem_id']   = $order->vendor_id;
            $review['rating']   = $post['rating'];
            $review['order_id'] = $proof->order_id;
            $review['review_comment'] = $post['review_comment'];

            $is_added = $this->master->save('reviews', $review);
            $earning = [];
            if ($is_added) {
                $earning['order_id'] = $proof->order_id;
                $earning['mem_id']   = $order->vendor_id;
                $earning['amount']   = price_format($earning_amount);
            }

            $this->master->save('earnings', $earning);
            generate_order_log_for_vendor($proof->order_id);
            //RATING
            $res['msg'] = showMsg('success', 'Request accepted successfully!');
            $res['status'] = 1;
            $res['hide_msg'] = 1;
            exit(json_encode($res));
        }
    }

    public function reject_proof_delivery()
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
            $proof_id = intval(doDecode($post['proof_id']));
            $proof = $this->master->getRow('order_delivery_proof', ['proof_id' => $proof_id]);
            $order   = $this->order_model->get_row($proof->order_id);
            $proof_data['status'] = 'rejected';
            $this->master->save('order_delivery_proof', $proof_data, 'proof_id', $proof_id);
            generate_order_log_for_vendor($proof->order_id);

            //RATING
            $res['msg'] = showMsg('success', 'Request rejected successfully!');
            $res['status'] = 1;
            $res['hide_msg'] = 1;
            exit(json_encode($res));
        }
    }

    public function transactions()
    {
        $this->isMemLogged($this->session->mem_type, true, $this->uri->segment(1));
        $this->data['transactions'] = $this->order_model->buyer_transactions();
        $this->load->view('buyer/transactions', $this->data);
    }

    public function credits()
    {
        $this->isMemLogged($this->session->mem_type, true, $this->uri->segment(1));
        $buyer_id = $this->session->mem_id;
        $total_orders = intval($this->master->num_rows('orders', array('order_status' => 'completed', 'buyer_id' => $buyer_id)));
        $cal_orders = $total_orders % 10;

        $this->data['orders'] = $this->master->getRows('orders', array('order_status' => 'completed', 'buyer_id' => $buyer_id), '', $cal_orders, 'desc', 'order_id');
        // pr($this->data['orders']);
        $this->load->view('buyer/credits', $this->data);
    }

    ### PAY AMENDED INVOICE AMOUNT METHODS
    public function pay_amend_invoice()
    {
        $this->isMemLogged($this->session->mem_type, true, $this->uri->segment(1));
        if ($this->input->post()) {
            $res = array();
            $res['frm_reset'] = 0;
            $res['hide_msg'] = 0;
            $res['scroll_to_msg'] = 0;
            $res['status'] = 0;
            $res['redirect_url'] = 0;

            $post = html_escape($this->input->post());
            $amended_records = $this->orderd_model->get_rows(['order_id' => doDecode($post['order_id']), 'service_type' => 'amended']);
            $amend_pending = 0;
            foreach ($amended_records as $key => $row) :
                if (check_amend_item_pay_status($row->order_id, $row->id) == 'Pending') {
                    $amend_pending += price_format($row->sub_service_price * $row->quantity);
                }
            endforeach;

            generate_order_log_for_vendor(doDecode($post['order_id']));
            // echo price_format($amend_pending); die;

            if ($post['payment_type'] == 'credit-card') {
                include_once APPPATH . "libraries/stripe/init.php";
                \Stripe\Stripe::setApiKey(API_SECRET_KEY);
                try {
                    if (!isset($post['nonce']))
                        throw new Exception("The Stripe Token was not generated correctly");

                    $cents   = $amend_pending * 100;
                    $charge = \Stripe\Charge::create([
                        "amount"      => $cents,
                        "currency"    => "gbp",
                        "source"      => $post['nonce'],
                        "description" => "Customer Charge",
                        "statement_descriptor" => "Paid successfully"
                    ]);
                } catch (Exception $e) {
                    $res['msg']    = $e->getMessage();
                    $res['status'] = 0;
                    exit(json_encode($res));
                }

                $amended_item_ids = [];
                foreach ($amended_records as $key => $row) :
                    if (check_amend_item_pay_status($row->order_id, $row->id) == 'Pending') {
                        $amended_item_ids[] = $row->id;
                    }
                endforeach;

                $amended_item_ids = implode(',', $amended_item_ids);

                $order_invoice = [];
                $order_invoice['order_id']  = doDecode($post['order_id']);
                $order_invoice['charge_id'] = $charge['id'];
                $order_invoice['payment_method']   = 'stripe';
                $order_invoice['amended_item_ids'] = $amended_item_ids;
                $order_invoice['invoice_type']     = 'amended';
                $order_invoice['payment_status']   = 'paid';
                $this->master->save('order_invoices', $order_invoice);
                generate_order_log_for_vendor(doDecode($post['order_id']));
            }

            if (doDecode($post['order_id']) > 0) {
                if ($post['payment_type'] == 'credit-card') {
                    $res['msg'] = 'Your paymnet transaction done successfully.';
                    $res['status'] = 1;
                    $res['html'] = amended_invoice($row->order_id, $amended_records);
                    // $res['redirect_url'] = base_url('order_success/'.doEncode($order_id));
                } else {
                    $res['msg'] = 'Your are reditecting to paypal for payment';
                    $res['status'] = 1;
                    $res['redirect_url'] = base_url('paypal-amended-invoice/' . doEncode($row->order_id));
                }
            } else {
                $res['status'] = 0;
                $res['msg'] = 'Your order has not been completed successfully. Please try again';
            }
            exit(json_encode($res));
        }
    }

    public function save_address()
    {
        if ($this->input->post()) {
            $post = html_escape($this->input->post());
            $buyer_data = [];
            if ($post['address_type'] == 'home') {
                $buyer_data['mem_country'] = $post['address_country'];
                $buyer_data['mem_state']   = $post['address_state'];
                $buyer_data['mem_city']    = trim($post['address_city']);
                $buyer_data['mem_address'] = trim($post['address_field']);
                $buyer_data['mem_zip']     = trim($post['address_zip']);
                $buyer_data['mem_map_lat'] = $post['mem_map_lat'];
                $buyer_data['mem_map_lng'] = $post['mem_map_lng'];
            } elseif ($post['address_type'] == 'office') {
                $buyer_data['mem_business_country'] = $post['address_country'];
                $buyer_data['mem_business_state']   = $post['address_state'];
                $buyer_data['mem_business_city']    = trim($post['address_city']);
                $buyer_data['mem_business_address'] = trim($post['address_field']);
                $buyer_data['mem_business_zip']     = trim($post['address_zip']);
                $buyer_data['mem_business_map_lat'] = $post['mem_map_lat'];
                $buyer_data['mem_business_map_lng'] = $post['mem_map_lng'];
            } elseif ($post['address_type'] == 'hotel') {
                $buyer_data['mem_hotel_country'] = $post['address_country'];
                $buyer_data['mem_hotel_state']   = $post['address_state'];
                $buyer_data['mem_hotel_city']    = trim($post['address_city']);
                $buyer_data['mem_hotel_address'] = trim($post['address_field']);
                $buyer_data['mem_hotel_zip']     = trim($post['address_zip']);
                $buyer_data['mem_hotel_map_lat'] = $post['mem_map_lat'];
                $buyer_data['mem_hotel_map_lng'] = $post['mem_map_lng'];
            }
            $is_updated = $this->member_model->save($buyer_data, $this->session->mem_id);
            if ($is_updated) {
                $res['mem_data'] = $this->member_model->get_row($this->session->mem_id);
                $res['status'] = 1;
                exit(json_encode($res));
            } else {
                exit(json_encode(['status' => '0']));
            }
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
