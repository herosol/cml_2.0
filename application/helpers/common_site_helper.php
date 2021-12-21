<?php

$CI = &get_instance();

function format_name($fname, $lname)
{
    return ucwords($fname . ' ' . $lname);
    // return ucwords($fname.' '.substr($lname, 0,1).'.');
}



function get_gallery_images($ref_id, $ref_type = 'product', $main = 0, $admin = 0)
{
    $CI = &get_instance();
    return $CI->master->getRows('gallery', array('ref_id' => $ref_id, 'ref_type' => $ref_type, 'main' => $main, 'admin' => $admin));
}

function check_valid_id($table, $id, $field)
{
    $id = doDecode($id);
    global $CI;
    $CI->db->select("*");
    $CI->db->where($field, $id);
    $query = $CI->db->get($table);
    if ($query->num_rows() == 0) {
        show_404();
    }
}

function countries()
{
    global $CI;
    $CI->db->select("id, name");
    $query = $CI->db->get('countries');
    return $query->result();
}

function states_by_country($country_id)
{
    global $CI;
    $CI->db->select("id, name");
    $CI->db->where(['country_id' => $country_id]);
    $CI->db->order_by(['name' => 'asc']);
    $query = $CI->db->get('states');
    return $query->result();
}

function get_servicename($s_id)
{
    global $CI;
    $CI = get_instance();
    $row = $CI->master->getRow('services', array('id' => $s_id));
    return ($row->name);
}
function get_sub_services($service_id)
{
    global $CI;
    $CI->db->select("id, name, service_id");
    $CI->db->where(['service_id' => $service_id]);
    $CI->db->order_by(['name' => 'asc']);
    $query = $CI->db->get('sub_services');
    return $query->result();
}
function get_sub_services_active($service_id)
{
    global $CI;
    $CI->db->select("id, name, service_id");
    $CI->db->where(['service_id' => $service_id, 'status' => '1']);
    $CI->db->order_by(['name' => 'asc']);
    $query = $CI->db->get('sub_services');
    return $query->result();
}

function get_parent_service($sub_service_id)
{
    global $CI;
    $CI->db->select("name");
    $CI->db->where(['id' => $sub_service_id]);
    $query = $CI->db->get('services');
    return $query->row()->name;
}

function get_sub_service($sub_service_id, $mem_id)
{
    global $CI;
    $CI->db->from('sub_services ss');
    $CI->db->join('services s', 's.id=ss.service_id');
    $CI->db->join('price_list pl', 'ss.id=pl.sub_service_id');
    $CI->db->select('ss.id, ss.name, pl.price, s.name as service_name');
    $CI->db->where(['pl.mem_id' => $mem_id, 'pl.sub_service_id' => $sub_service_id]);
    return $CI->db->get()->row();
}

function mem_bank_form($bank_id = 0)
{
    global $CI;
    $bank_id = doDecode($bank_id);
    $CI->db->select("*");
    $CI->db->where(['id' => $bank_id]);
    $query = $CI->db->get('mem_bank_accounts');
    $bank  = $query->row();

    $html = '';
    $html .= '<div class="form_row row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <h6>Bank Name</h6>
            <div class="form_blk">
                <input type="hidden" name="bank_id" value="' . doEncode($bank_id) . '">
                <input type="text" name="bank_name" id="bank_name" value="' . $bank->bank_name . '" class="text_box" placeholder="eg: Wells Fargo Bank">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <h6>Account Number</h6>
            <div class="form_blk">
                <input type="text" name="account_number" id="account_number" value="' . $bank->account_number . '" class="text_box" placeholder="eg: 1234567890">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <h6>Short Code</h6>
            <div class="form_blk">
                <input type="text" name="short_code" id="short_code" value="' . $bank->short_code . '" class="text_box" placeholder="eg: 1234">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <h6>Beneficiary Name</h6>
            <div class="form_blk">
                <input type="text" id="beneficiary_name" name="beneficiary_name" value="' . $bank->beneficiary_name . '" class="text_box" placeholder="eg: John Wick">
            </div>
        </div> 
    </div>';

    return $html;
}

function get_mem_banks($mem_id)
{
    global $CI;
    $CI->db->select("*");
    $CI->db->where(['mem_id' => $mem_id]);
    $query = $CI->db->get('mem_bank_accounts');
    $banks = $query->result();

    $html = '';
    if (count($banks) == 0) {
        $html .= '<tr>
        <td>No Bank Account Added.</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>';
    } else {
        foreach ($banks as $key => $bank) :
            $html .= '<tr>
                <td>' . $bank->bank_name . '</td>
                <td>' . $bank->account_number . '</td>
                <td>' . $bank->short_code . '</td>
                <td>' . $bank->beneficiary_name . '</td>
                <td>
                    <button class="site_btn sm light edit-bank-account" data-bank-id="' . doEncode($bank->id) . '">Edit</button>
                </td>
            </tr>';
        endforeach;
    }

    return $html;
}

function sub_service_price($sub_service_id, $mem_id)
{
    global $CI;
    $CI->db->select("id, price");
    $CI->db->where(['sub_service_id' => $sub_service_id, 'mem_id' => $mem_id]);
    $query = $CI->db->get('price_list');
    return $query->row();
}

function vendor_service_check($mem_id, $services, $qty)
{
    $res = [];
    $res['return'] = true;
    $estimated_price = 0;
    foreach ($services as $index => $service) :
        $row = sub_service_price($service, $mem_id);
        if (empty($row))
            $res['return'] = false;
        else
            if ($row->price == '' || $row->price == '0.00')
            $res['return'] = false;
        else
            $estimated_price += $row->price * $qty[$index];
    endforeach;

    $res['estimated_price'] = $estimated_price;
    return $res;
}

function order_log($order_id = NULL)
{
    global $CI;
    $CI->db->where(['mem_id' => $CI->session->mem_id, 'mem_type' => $CI->session->mem_type, 'status' => 'dirty']);
    if ($order_id !== NULL)
        $CI->db->where(['order_id' => $order_id]);
    $row = $CI->db->get('order_logs');

    if ($order_id !== NULL) {
        if (intval($row->num_rows()) > 0)
            return 'tipi';
        else
            return '';
    } else {
        if (intval($row->num_rows()) > 0)
            return 'new_odr';
        else
            return '';
    }
}

function generate_order_log_for_buyer($order_id)
{
    global $CI;
    $order = $CI->master->getRow('orders', ['order_id' => $order_id]);
    $CI->master->update('order_logs', ['status' => 'dirty'], ['mem_id' => $order->buyer_id, 'mem_type' => 'buyer', 'order_id' => $order_id]);
    return true;
}

function generate_order_log_for_vendor($order_id)
{
    global $CI;
    $order = $CI->master->getRow('orders', ['order_id' => $order_id]);
    $CI->master->update('order_logs', ['status' => 'dirty'], ['mem_id' => $order->vendor_id, 'mem_type' => 'vendor', 'order_id' => $order_id]);
    return true;
}

/*** start notifications ***/
function save_notificaiton($mem_id, $from_id, $txt, $link = '', $cat = 'other', $note_id = 0, $status = 'new')
{
    global $CI;

    $link = empty($link) ? site_url('notifications') : $link;
    $noti_id = $CI->master->save('notifications', array('mem_id' => $mem_id, 'from_id' => $from_id, 'txt' => $txt, 'link' => $link, 'cat' => $cat, 'note_id' => $note_id, 'status' => $status, 'date' => date("Y-m-d H:i:s")));
    $encoded_id = doEncode('nti-' . $noti_id);
    $CI->master->save('notifications', array('encoded_id' => $encoded_id), 'id', $noti_id);
}

function mark_seen_notifications()
{
    global $CI;
    $CI->master->save('notifications', array('status' => 'seen'), 'mem_id', $CI->session->mem_id);
}

function count_new_header_notis()
{
    global $CI;
    $CI->db->select("count(id) as total");
    $CI->db->where('mem_id', $CI->session->mem_id);
    $CI->db->where("status", 'new');
    $query = $CI->db->get('notifications');
    return intval($query->row()->total);
}

function get_header_notis($limit = '', $order_by = 'desc')
{
    global $CI;
    $CI->db->select("n.*, concat(mem_fname, ' ', mem_lname) as mem_name, mem_image, mem_type");
    $CI->db->from('notifications n');
    $CI->db->join('members m', 'n.from_id = m.mem_id', 'left');

    $CI->db->where("n.mem_id", $CI->session->mem_id);

    if (!empty($order_by))
        $CI->db->order_by("n.id", $order_by);
    if (!empty($limit))
        $CI->db->limit($limit);

    return $CI->db->get()->result();
}
/*** end notifications ***/

function new_messages()
{
    global $CI;
    $CI->db->where('status', 0);
    $row = $CI->db->get('contact');
    return intval($row->num_rows());
}

function new_notifs()
{
    global $CI;
    $CI->db->where(['mem_id' => $CI->session->mem_id, 'status'=> 'new']);
    $row = $CI->db->get('notifications');
    return intval($row->num_rows());
}

function new_withdraws_requests()
{
    global $CI;
    $CI->db->where('status', 'pending');
    $row = $CI->db->get('withdraws');
    return intval($row->num_rows());
}

function new_orders()
{
    global $CI;
    $CI->db->where('order_status', 'New');
    $row = $CI->db->get('orders');
    return intval($row->num_rows());
}

function new_delivery_proofs()
{
    global $CI;
    $CI->db->where('status', 'pending');
    $row = $CI->db->get('order_delivery_proof');
    return intval($row->num_rows());
}


function new_subscribers()
{
    global $CI;
    $CI->db->where('status', 0);
    $row = $CI->db->get('newsletter');
    return intval($row->num_rows());
}
function new_traders()
{
    global $CI;
    $CI->db->where('status', 0);
    $row = $CI->db->get('trade');
    return intval($row->num_rows());
}


function get_header_msgs($limit = '', $order_by = 'desc')
{
    global $CI;
    $CI->db->select('c.*, cm.*, m.mem_id, m.mem_image, m.mem_fname, m.mem_lname');
    $CI->db->from('chat c');
    $CI->db->join('members m', 'm.mem_id = c.mem_one or m.mem_id = c.mem_two');
    $CI->db->join('(select MAX(id) as m_id, chat_id from tbl_chat_msgs GROUP BY chat_id) m_max', 'm_max.chat_id=c.id');
    $CI->db->join('chat_msgs cm', 'cm.id = m_max.m_id');
    $CI->db->where('m.mem_id<>', $CI->session->mem_id);
    $CI->db->group_start();
    $CI->db->where('c.mem_one', $CI->session->mem_id);
    $CI->db->or_where('c.mem_two', $CI->session->mem_id);
    $CI->db->group_end();

    if (!empty($order_by))
        $CI->db->order_by("c.time", $order_by);
    if (!empty($limit))
        $CI->db->limit($limit);

    return $CI->db->get()->result();
}

function get_mem_row($mem_id)
{
    global $CI;
    $CI = get_instance();
    return $CI->master->getRow('members', array('mem_id' => $mem_id));
}

function get_mem_image($mem_id)
{
    global $CI;
    $CI = get_instance();
    $row = $CI->master->getRow('members', array('mem_id' => $mem_id));
    return $row->mem_image;
}

function get_mem_name($mem_id)
{
    global $CI;
    $CI = get_instance();
    $row = $CI->master->getRow('members', array('mem_id' => $mem_id));
    return ucwords($row->mem_fname . ' ' . $row->mem_lname);
}
function get_mem_email($mem_id)
{
    global $CI;
    $CI = get_instance();
    $row = $CI->master->getRow('members', array('mem_id' => $mem_id));
    return ($row->mem_email);
}

function get_mem_type($mem_id)
{
    global $CI;
    $CI = get_instance();
    $row = $CI->master->getRow('members', array('mem_id' => $mem_id));
    return $row->mem_type;
}

function is_followed($mem_id)
{
    $CI = get_instance();
    if ($CI->master->getRow('followers', array('follower_id' => $CI->session->mem_id, 'mem_id' => $mem_id)))
        return '<i class="fa fa-check"></i> Following';
    else
        return 'Follow';
}

function is_subscribed($mem_id, $ref_id, $ref_type, $is_main = true)
{
    $CI = get_instance();
    if ($CI->master->getRow('subscribers', array('mem_id' => $mem_id, 'ref_id' => $ref_id, 'ref_type' => $ref_type)))
        return $is_main ? '<i class="fa fa-check"></i> Subscribed' : '<i class="fa fa-check"></i>';
    else
        return $is_main ? 'Subscribe' : '<i class="fas fa-plus"></i>';
}

function total_favorites($ref_id, $ref_type)
{
    $CI = get_instance();
    $CI->db->where('ref_id', $ref_id);
    $CI->db->where('ref_type', $ref_type);
    $query = $CI->db->get('favorites');
    return short_number_format(intval($query->num_rows()));
}

function get_delivey_proof($order_id)

{
    global $CI;
    $CI->db->select("*");
    $CI->db->from('order_delivery_proof');
    $CI->db->where('order_id', $order_id);
    $CI->db->order_by('proof_id', 'DESC');
    $query = $CI->db->get();
    $rows = $query->result();
    if (empty($rows)) {
        return $html = '';
    } else {
        $html .= '<h4 class="subheading">Delivery Proof</h4>';
        foreach ($rows as $key => $row) :
            $html .= '<div class="blk proof_blk" id="delivery_proof">
            <div class="done_blk">
                <a href="' . get_site_image_src("orders", $row->proof_image, '') . '" class="image" data-fancybox="proof"><img src="' . get_site_image_src("orders", $row->proof_image, '') . '" alt="" data-src="' . get_site_image_src("orders", $row->proof_image, '') . '"></a>
                <div class="txt">
                    <div class="top_head">
                        <h6>Comment</h6>
                        <span class="badge ' . get_delivery_proof_status($row->status) . '">' . ucfirst($row->status) . '</span>
                    </div>
                    <div class="txt">
                        <p>' . $row->proof_comment . '</p>
                    </div>
                </div>
            </div>
        </div>';
        endforeach;
        $html .= '';
    }
    return $html;
}

function amended_invoice($order_id, $amended_records)
{
    global $CI;
    $CI = get_instance();
    $html = '';
    $total = $services_total;
    $payButton = '';

    if ($CI->session->mem_type == 'buyer') {
        $payButton .= '<button type="button" class="site_btn md light pop_btn" data-popup="pay-amend-invoice"><img src="' . base_url() . 'assets/images/icon-price-list.svg" alt="">Pay</button>';
    }
    
    if (!empty($amended_records)) :
        $html .= '<hr>
        <h4>Amended Invoice</h4>
        <table class="sm pb amended data_list">
            <thead>
                <tr>
                    <th width="40%">Items</th>
                    <th width="15%">Unit Price</th>
                    <th width="15%">Qty</th>
                    <th width="15%">Price</th>
                    <th width="15%">Paid</th>
                </tr>
            </thead>
            <tbody>';
        $amend_total   = 0;
        $amend_pending = 0;
        foreach ($amended_records as $key => $row) :
            $total += $row->sub_service_price * $row->quantity;
            $amend_total += $row->sub_service_price * $row->quantity;
            if (check_amend_item_pay_status($row->order_id, $row->id) == 'Pending') {
                $amend_pending += price_format($row->sub_service_price * $row->quantity);
            }

            $html .= '<tr>
                        <td>' . $row->sub_service_name . '</td>
                        <td>£' . price_format($row->sub_service_price) . '</td>
                        <td>' . $row->quantity . '</td>
                        <td>£' . price_format($row->sub_service_price * $row->quantity) . '</td>
                        <td><span class="badge ' . amend_item_pay_status(check_amend_item_pay_status($row->order_id, $row->id)) . '">' . check_amend_item_pay_status($row->order_id, $row->id) . '</span></td>
                    </tr>';
        endforeach;
        $html .= '</tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="color text-right">Total Amended</td>
                    <td class="color">£' . price_format($amend_total) . '</td>
                </tr>';
        if ($amend_pending > 0) {
            if ($CI->session->mem_type == 'buyer') {
                $html .= '<tr>
                                <td colspan="4" class="color text-right">Pending <strong>£' . price_format($amend_pending) . '</strong></td>
                                <td class="color">' . $payButton . '</td>
                            </tr>';
            }
        }
        $html . '</tfoot>
        </table>';
    endif;

    $html .= '<table class="sm pb data_list">
        <thead>
        </thead>
        <tbody>
            <th width="40%"></th>
            <th width="15%"></th>
            <th width="15%"></th>
            <th width="15%"></th>
            <th width="15%"></th>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="">
                    Estimated Total
                </th>
                <th class="">£' . order_total_price($order_id) . '</th>
            </tr>
        </tfoot>
    </table>';

    return $html;
}

function check_amend_item_pay_status($order_id, $amend_id)
{
    global $CI;
    $CI = get_instance();
    $CI->db->where(['order_id' => $order_id, 'payment_status' => 'paid']);
    $CI->db->where('FIND_IN_SET("' . $amend_id . '", `amended_item_ids`) <>', '0');
    $query = $CI->db->get('order_invoices');
    // pr($CI->db->last_query());
    if ($query->num_rows() > 0) {
        return 'Paid';
    } else {
        return 'Pending';
    }
}

function order_total_price($order_id, $what_to_return = 'FINAL')
{
    global $CI;
    $CI = get_instance();
    $CI->db->where(['order_id' => $order_id]);
    $query = $CI->db->get('orders');
    $order = $query->row();


    $order_detail = $CI->orderd_model->get_rows(['order_id' => $order_id, 'service_type' => 'basic']);
    $amended      = $CI->orderd_model->get_rows(['order_id' => $order_id, 'service_type' => 'amended']);

    $total_price = 0;
    foreach ($order_detail as $key => $row) :
        $total_price += $row->sub_service_price * $row->quantity;
    endforeach;

    if ($what_to_return == 'SERVICES')
        return price_format($total_price);

    if ($order->pick_and_drop_service == '1') {
        $total_price += $order->pick_and_drop_charges;
    }

    $total_price = price_format($total_price);

    if ($what_to_return == 'SERVICES_PICKUP')
        return price_format($total_price);

    if ($order->buyer_get_credit == '1') {
        $discount = price_format($total_price / 100 * intval($order->buyer_credit_percentage));
        $total_price -= $discount;
    }

    if ($what_to_return == 'DISCOUNT')
        return $discount;

    if ($what_to_return == 'AFTER_DISCOUNT')
        return $total_price;

    foreach ($amended as $key => $row) :
        $total_price += $row->sub_service_price * $row->quantity;
    endforeach;

    if ($what_to_return == 'FINAL')
        return price_format($total_price);
}

function buyer_transaction_price($order_id)
{
    global $CI;
    $CI = get_instance();
    $CI->db->where(['order_id' => $order_id]);
    $query = $CI->db->get('orders');
    $order = $query->row();


    $order_detail = $CI->orderd_model->get_rows(['order_id' => $order_id, 'service_type' => 'basic']);
    $amended      = $CI->orderd_model->get_rows(['order_id' => $order_id, 'service_type' => 'amended']);

    $total_price = 0;
    foreach ($order_detail as $key => $row) :
        $total_price += $row->sub_service_price * $row->quantity;
    endforeach;


    if ($order->pick_and_drop_service == '1') {
        $total_price += $order->pick_and_drop_charges;
    }

    $total_price = price_format($total_price);

    if ($order->buyer_get_credit == '1') {
        $discount = price_format($total_price / 100 * intval($order->buyer_credit_percentage));
        $total_price -= $discount;
    }

    foreach ($amended as $key => $row) :
        if (check_amend_item_pay_status($row->order_id, $row->id) == 'Paid') {
            $total_price += $row->sub_service_price * $row->quantity;
        }
    endforeach;

    return price_format($total_price);
}

function amend_item_pay_status($status)
{
    if ($status == 'Pending') {
        return 'yellow';
    } else {
        return 'green';
    }
}

function get_categories($type = 'comic', $offset = '')
{
    global $CI;
    $CI = get_instance();
    $CI->db->where('type', $type);
    if (!empty($offset))
        $CI->db->limit($offset);
    $query = $CI->db->get('categories');
    return $query->result();
}

function get_bcat_name($id)
{
    global $CI;
    $row = $CI->master->getRow('blog_categories', array('id' => $id));
    return $row->name;
}

function get_cat_name($id)
{
    global $CI;
    $row = $CI->master->getRow('categories', array('id' => $id));
    return $row->name;
}

function get_cat_slug_id($slug)
{
    global $CI;
    $row = $CI->master->getRow('categories', array('slug' => $slug));
    return $row->id;
}

function profileComplete($row)
{
    $complete = 0;
    if (!empty($row->mem_email) && !empty($row->mem_fname) && !empty($row->mem_pswd) && !empty($row->mem_address1) && !empty($row->mem_phone) && !empty($row->mem_image) && !empty($row->mem_about)) {
        $complete = 1;
    }
    return $complete;
}

function shorString($url)
{
    if (strlen($url) >= 20) {
        return substr($url, 0, 15) . " ... " . substr($url, -4);
    } else {
        return $url;
    }
}
function url_text($url)
{
    $not_allowed = array(' ', '/', '$', '\'', '"', '.');
    $url = trim(str_replace($not_allowed, '-', strtolower($url)), '-');
    return strlen($url) >= 70 ? substr($url, 0, 70) : $url;
}

function getSiteText($type, $key, $column = 'value')
{
    global $CI;
    $CI = get_instance();
    $row = $CI->master->getRow('site_texts', array('txt_type' => $type, 'txt_key' => $key));
    $column = 'txt_' . $column;
    return $row->$column;
}

function get_countries_options($type, $selected = '')
{
    global $CI;
    $options = "";
    $rows = $CI->master->getRows("countries", array());
    foreach ($rows as $key => $row) {
        $options .= '<option value="' . $row->{$type} . '"' . ($selected != '' && ($selected == $row->id || $selected == $row->short_code || $selected == $row->name) ? ' selected' : '') . '>' . $row->name . '</option>';
    }
    return $options;
}

function get_country_name($key, $type = 'id', $default_text = "N/A")
{
    global $CI;
    $arr = $CI->master->getRow("countries", array($type => $key));
    if ($arr) {
        return $arr->name;
    } else {
        return $default_text;
    }
}

function get_states_options($type, $selected = '', $status = NULL)
{
    global $CI;
    $options = "";
    $contition = array();
    if (!is_null($status))
        $contition['status'] = $status;
    $rows = $CI->master->getRows("states", $contition);
    foreach ($rows as $key => $row) {
        $options .= '<option value="' . $row->{$type} . '"' . ($selected != '' && ($selected == $row->id || $selected == $row->code || $selected == $row->name) ? ' selected' : '') . '>' . $row->name . ' - ' . $row->code . '</option>';
    }
    return $options;
}
function get_state_name($key, $type = 'id', $default_text = "N/A")
{
    global $CI;
    $arr = $CI->master->getRow("states", array($type => $key));
    if ($arr) {
        return $arr->name;
    } else {
        return $default_text;
    }
}

function get_cities_options($type, $selected = '', $state = NULL)
{
    global $CI;
    $options = "";
    $contition = array();
    if (!is_null($state))
        $contition['state'] = $state;
    $rows = $CI->master->getRows("cities", $contition);
    foreach ($rows as $key => $row) {
        $options .= '<option value="' . $row->{$type} . '"' . ($selected != '' && ($selected == $row->id || $selected == $row->city) ? ' selected' : '') . '>' . $row->city . '</option>';
    }
    return $options;
}

function get_city_name($key, $type = 'id', $default_text = "N/A")
{
    global $CI;
    $arr = $CI->master->getRow("cities", array($type => $key));
    if ($arr) {
        return $arr->city;
    } else {
        return $default_text;
    }
}

function applyHTTP($url)
{
    if ((substr($url, 0, 3) == "www")) {
        return $httpUrl = "http://" . $url;
    }
    return $url;
}

function getPref($key, $field)
{
    global $CI;
    $CI = get_instance();
    $row = $CI->master->getRow('preferences', array('pref_key' => $key));
    return $row->{$field};
}


/*** comments ***/
function get_comments($ref_id, $ref_type, $parent_id = 0, $start = '', $offset = '', $order_by = 'desc')
{
    global $CI;
    $CI->db->select("c.*,concat(mem_fname,' ',mem_lname) as mem_name,mem_image,(select count(*) FROM `tbl_favorites` where ref_id=c.id and ref_type='comment') total_likes");
    $CI->db->from('comments c');
    $CI->db->join('members m', 'c.mem_id=m.mem_id');
    $CI->db->where('c.ref_id', $ref_id);
    $CI->db->where('c.ref_type', $ref_type);
    $CI->db->where('c.status', 1);

    // if (!empty($parent_id))
    $CI->db->where('c.parent_id', $parent_id);
    if (!empty($order_by))
        $CI->db->order_by("c.id", $order_by);
    if (!empty($offset)) {
        $CI->db->limit($offset, $start);
    }
    $query = $CI->db->get();
    return $query->result();
}

/** reviews **/
function get_mem_avg_rating($mem_id)
{
    $CI = get_instance();
    $CI->db->select('AVG(rating) as total')
        ->where('mem_id', $mem_id);
        // ->where('parent_id', NULL);
    $query = $CI->db->get('reviews');
    $total = $query->row()->total;
    return round(floatval($total), 1);
}

function count_mem_ratings($mem_id)
{
    $CI = get_instance();
    $CI->db->select('count(*) as total')
        ->where('mem_id', $mem_id);
        // ->where('parent_id', NULL);
    $query = $CI->db->get('reviews');
    $total = $query->row()->total;
    return intval($total);
}

function get_reviews($ref_id, $ref_type = 'booking')
{
    $CI = get_instance();
    $CI->db->where('ref_id', $ref_id);
    $CI->db->where('ref_type', $ref_type);
    $CI->db->where('parent_id', NULL);
    $query = $CI->db->get('reviews');
    return $query->result();
}

function count_reviews($ref_id, $ref_type = 'booking')
{
    $CI = get_instance();
    $CI->db->select('count(*) as total');
    $CI->db->where('ref_id', $ref_id);
    $CI->db->where('ref_type', $ref_type);
    $CI->db->where('parent_id', NULL);
    $query = $CI->db->get('reviews');
    $total = $query->row()->total;
    return intval($total);
}

function get_avg_rating($ref_id, $ref_type = 'booking')
{
    $CI = get_instance();
    $CI->db->select('AVG(rating) as total')
        ->where('ref_id', $ref_id)
        ->where('ref_type', $ref_type)
        ->where('parent_id', NULL);
    $query = $CI->db->get('reviews');
    $total = $query->row()->total;
    return round(floatval($total), 1);
}

function get_mem_reviews($mem_id, $start = '', $offset = '', $order_by = 'desc', $field = 'r.date')
{
    $CI = get_instance();
    $CI->db->select("r.*, mem_image, concat(mem_fname, ' ', mem_lname) as mem_name")
        ->from('reviews r')
        ->join('members mem', 'mem.mem_id=r.from_id')
        ->where('r.mem_id', $mem_id)
        ->where('r.parent_id', NULL);

    if (!empty($order_by))
        $CI->db->order_by($field, $order_by);
    if (!empty($offset))
        $CI->db->limit($offset, $start);

    $query = $CI->db->get();
    return $query->result();
}

function count_mem_reviews($mem_id)
{
    $CI = get_instance();
    $CI->db->select('count(*) as total')
        ->where('mem_id', $mem_id)
        ->where('parent_id', NULL);
    $query = $CI->db->get('reviews');
    $total = $query->row()->total;
    return intval($total);
}

function get_avg_mem_rating($mem_id)
{
    $CI = get_instance();
    $CI->db->select('AVG(rating) as total')
        ->where('mem_id', $mem_id)
        ->where('parent_id', NULL);
    $query = $CI->db->get('reviews');
    $total = $query->row()->total;
    return round(floatval($total), 1);
}

function get_mem_rating($mem_id, $ref_id, $ref_type = 'booking')
{
    $CI = get_instance();
    $CI->db->select('*')
        ->where('from_id', $mem_id)
        ->where('ref_id', $ref_id)
        ->where('ref_type', $ref_type);
    return $CI->db->get('reviews')->row();
}

function get_mem_review($mem_id, $ref_id, $ref_type = 'booking')
{
    $CI = get_instance();
    $CI->db->select("r.*, mem_image, concat(mem_fname,' ',mem_lname) as mem_name")
        ->from('reviews r')
        ->join('members mem', 'mem.mem_id = r.from_id')
        ->where('r.from_id', $mem_id)
        ->where('r.ref_id', $ref_id)
        ->where('r.ref_type', $ref_type)
        ->where('r.parent_id', NULL);
    return $CI->db->get()->row();
}
function get_reply($parent_id)
{
    $CI = get_instance();
    $CI->db->select("r.*, mem_image, concat(mem_fname, ' ', mem_lname) as mem_name")
        ->from('reviews r')
        ->join('members mem', 'mem.mem_id=r.from_id')
        ->where('r.parent_id', $parent_id);
    return $CI->db->get()->row();
}
