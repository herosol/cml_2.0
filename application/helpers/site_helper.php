<?php

$CI = & get_instance();
function get_header()
{
    $CI = get_instance();
    if($CI->session->has_userdata('mem_id') && $CI->session->has_userdata('mem_type'))
        $CI->load->view('includes/header-logged');
    else
        $CI->load->view('includes/header');
}

function get_pages()
{
    $page_arr = [
        1 => 'index',
        2 => 'faq',
        3 => 'promotions-offers',
        4 => 'contact',
        5 => 'signin',
        6 => 'signup-as',
        7 =>' terms-and-conditions',
        8 => 'blogs',
        9 => 'impact',
        10 => 'privacy-policy'
    ];
    return $page_arr;  
}

function get_sub_service_name($id){
    $CI = get_instance();
    $service = $CI->master->getRow('sub_services',array('id'=>$id));
    return $service->name;
}
function get_service_name($id){
    $CI = get_instance();
    $service = $CI->master->getRow('services',array('id'=>$id));
    return $service->name;
}
function get_services(){
    $CI = get_instance();
    return $CI->master->getRows('services',array('status'=>1));
}
function get_partners(){
    $CI = get_instance();
    return $CI->master->getRows('partners',array('status'=>1));
}

function get_papular_products($limit)
{
    $CI = get_instance();
    $CI->db->select("p.*, (SELECT GROUP_CONCAT(DISTINCT size SEPARATOR ' ') FROM `tbl_product_sizes` WHERE p_id = p.id) as sizes", FALSE);
    $CI->db->where('status', 1);
    $CI->db->limit($limit);
    $CI->db->order_by('id', 'desc');
    return $CI->db->get('products p')->result();
}

function get_main_cats ($type = 'product')
{
    $CI = get_instance();
    return $CI->master->fetch_rows("SELECT * FROM `tbl_categories` WHERE type = '$type' AND parent_id = 0 AND status = 1");
}

function get_sub_cats ($type = 'product')
{
    $CI = get_instance();
    return $CI->master->fetch_rows("SELECT * FROM `tbl_categories` WHERE type = '$type' AND parent_id<>0 AND status = 1");
}

function get_group_colors ()
{
    $CI = get_instance();
    return $CI->master->fetch_rows("SELECT color, color_name FROM `tbl_product_colors` GROUP BY color_name");
}

function get_group_sizes ()
{
    $CI = get_instance();
    return $CI->master->fetch_rows("SELECT size FROM `tbl_product_sizes` GROUP BY size");
}

function get_max_price()
{
    $CI = get_instance();
    $CI->db->select_max('default_price');
    $query = $CI->db->get('products');
    return floatval($query->row()->default_price);
}

/*** stats ***/

function calc_booking_score($booking_rate, $review_rate, $response_time)
{
    if ($booking_rate == 0)
        $booking_score = 0;
    elseif ($booking_rate <= 30)
        $booking_score = 3;
    elseif ($booking_rate > 30 && $booking_rate < 50)
        $booking_score = 4;
    elseif ($booking_rate > 50)
        $booking_score = 5;
    
    $response_time = round($response_time/3600, 1);
    if ($response_time == 0)
        $booking_score += 0;
    elseif ($response_time <= 4)
        $booking_score += 5;
    elseif ($response_time >= 4 && $response_time <= 24)
        $booking_score += 4;
    elseif ($response_time > 24)
        $booking_score += 3;

    $booking_score += $review_rate;

    return $booking_score > 0 ? round(($booking_score/3) *10) +50 : 0;
}

function get_review_rate($mem_id)
{
    $CI = get_instance();
    $CI->db->select('AVG(rating) as total')
    ->where('mem_id', $mem_id)
    ->where('parent_id', NULL)
    ->where("TIMESTAMPDIFF(DAY, date, NOW())<=", 60);
    $query = $CI->db->get('reviews');
    $total = $query->row()->total;
    return round(floatval($total), 1);
}

function booking_rate($sitter_id)
{
    $CI = get_instance();
    $CI->db->select("((SELECT COUNT(*) FROM tbl_bookings where sitter_id=$sitter_id and STATUS=2 and canceled=0 and TIMESTAMPDIFF(DAY, date, NOW())<=60)/COUNT(*))*100 as rate");
    $CI->db->where("sitter_id", $sitter_id);
    $CI->db->where("TIMESTAMPDIFF(DAY, date, NOW())<=", 60);
    // $CI->db->where("status>", 0);
    $query = $CI->db->get('bookings');
    return round($query->row()->rate, 1);
}

function count_sitter_clients($sitter_id, $reaped = FALSE)
{
    $CI = get_instance();
    $CI->db->select("count(id) as total");
    // $CI->db->select("*, count(id) as total");
    $CI->db->where("sitter_id", $sitter_id);
    $CI->db->where("status", 2);
    $CI->db->where("canceled", 0);
    $CI->db->where("completed", 2);
    $CI->db->group_by('owner_id');
    if (!empty($reaped))
        $CI->db->having('total >', 1);
    $query = $CI->db->get('bookings');
    return intval($query->num_rows());
}

function count_repeat_stays($sitter_id)
{
    $CI = get_instance();
    $row = $CI->master->fetch_row("SELECT SUM(count) as total FROM (SELECT count(id) as count FROM `tbl_bookings` WHERE `sitter_id` = $sitter_id AND `status` = 2 AND `canceled` = 0 AND `completed` = 2 GROUP BY `owner_id` HAVING count>1) as a");
    return intval($row->total);
}

function get_response_rate($sitter_id)
{
    $CI = get_instance();
    $CI->db->select("((SELECT COUNT(*) FROM tbl_chat where (mem_one=$sitter_id or mem_two=$sitter_id) and response_time is not NULL and TIMESTAMPDIFF(DAY, response_date, NOW()) <= 60)/COUNT(*))*100 as rate");
    $CI->db->group_start()
    ->where("mem_one", $sitter_id)
    ->or_where("mem_two", $sitter_id)
    ->group_end();
    $CI->db->where("TIMESTAMPDIFF(DAY, time, NOW())<=", 60);
    $query = $CI->db->get('chat');
    return round($query->row()->rate);
}

function get_response_time($sitter_id)
{
    $CI = get_instance();
    $CI = get_instance();
    $CI->db->select("AVG(response_time) as total");

    $CI->db->group_start()
    ->where("mem_one", $sitter_id)
    ->or_where("mem_two", $sitter_id)
    ->group_end();
    $CI->db->where("TIMESTAMPDIFF(DAY, response_date, NOW())<=", 60);
    $res[0] = $response_time = round($CI->db->get('chat')->row()->total);
    if ($response_time>0) {

        $strTime = array("Second", "Minute", "Hour", "Day", "Month", "Year");
        // $strTime = array(" sec", " min", " hr", " day", " month", " year");
        $length = array("60", "60", "24", "30", "12", "10");

        for($i = 0; $response_time >= $length[$i] && $i < count($length)-1; $i++) {
            $response_time = $response_time / $length[$i];
        }
        $response_time = round($response_time);
        $s = $response_time > 1 ? 's' : '';
        $res[1] = $response_time." <small>".$strTime[$i].$s."</small>";
        return $res;
    }
    
    return 0;
}
/*** end stats ***/

function get_pkg_name($pkg_id)
{
    $CI = get_instance();
    $CI->db->where('id', $pkg_id);
    $query = $CI->db->get('packages');
    return $query->row()->title;
}

// function get_services()
// {
//     $CI = get_instance();
//     $query = $CI->db->get('services');
//     return $query->result();
// }

function get_cat_help($cat_id)
{
    $CI = get_instance();
    $CI->db->where('cat_id', $cat_id);
    $query = $CI->db->get('help');
    return $query->result();
}

function is_mem_service($mem_id, $service_id)
{
    $CI = get_instance();
    $CI->db->where('mem_id', $mem_id);
    $CI->db->where('service_id', $service_id);
    $query = $CI->db->get('mem_services');
    return $query->row();
}

function get_yes_no($status)
{
    return $status ==1 ? 'Yes' : 'No';
}

function get_booking_status($status)
{
    if ($status == 0)
        return '<span class="miniLbl gray">Pending</span>';
    elseif ($status == 1)
        return '<span class="miniLbl yellow">Accepted</span>';
    else if ($status == 2)
        return '<span class="miniLbl green">Booked</span>';
    else
        return '<span class="miniLbl red">Declined</span>';
}

function get_confirmed_status($booking, $sitter = 0)
{
    if ($booking->canceled == 0 && (($booking->completed == 2 && empty($sitter)) || (in_array($booking->completed, array(1, 2)) && !empty($sitter))))
        return  '<span class="miniLbl green">Complete</span>';
    elseif ($booking->status == 3 || ($booking->status == 2 && $booking->canceled == 1))
        return '<span class="miniLbl red">Cancelled</span>';
    elseif ($booking->status == 2 && $booking->canceled == 0 && $booking->completed < 2)
        return '<span class="miniLbl blue">Upcoming</span>';
    else
        return '<span class="miniLbl yellow">Pending</span>';
}

function get_completed_status($status)
{
    if ($status == 1)
        return '<span class="miniLbl yellow">Pending</span>';
    else if ($status == 2)
        return '<span class="miniLbl green">Completed</span>';
    
}

function count_panding_withdraws()
{
    $CI = get_instance();
    return $CI->master->num_rows('withdraws', array('status' => 0));
}

/*function count_cancelled_bookings()
{
    $CI = get_instance();
    return $CI->master->num_rows('bookings', array('cancelled_request' => 2, 'canceled' => 0));
}*/

function sitter_hours_sitted($sitter_id)
{
    $CI = get_instance();
    $CI->db->select_sum("hours", "total_time");
    $CI->db->where('sitter_id', $sitter_id);
    $CI->db->group_start()
    ->where("completed", 2)
    ->or_where("completed", 1)
    ->group_end();
    $query = $CI->db->get('bookings');
    return round($query->row()->total_time, 1);
}

function total_sitter_deliveries($sitter_id)
{
    $CI = get_instance();
    $CI->db->select("count(id) as total");
    $CI->db->where('sitter_id', $sitter_id);
    $CI->db->where("status", 2);
    $CI->db->where("completed", 2);
    $query = $CI->db->get('bookings');
    return intval($query->row()->total);
}

function num_size($num, $size = 6)
{
    return sprintf('%0'.$size.'d', $num);
}

function calc_booking_total($row, $for, $only_total = FALSE)
{
    $total = array();
    $total['stotal'] = 0;
    $total_pets = $row->puppies+$row->cats+$row->dogs;
    $total_stays = $row->num_stays-$row->num_holidays;
    if ($row->dogs>0 && $total_stays>0) {
        $total['stotal'] += ($row->rate*$total_stays);
        $total['dog_total'] += ($row->rate*$total_stays);
        if ($row->dogs-1>0) {
            $total['stotal'] += ($row->additional_dog_rate*$total_stays*($row->dogs-1));
            $total['additional_dog_total'] += ($row->additional_dog_rate*$total_stays*($row->dogs-1));
        }
    }
    if ($row->puppies>0) {
        $total['stotal'] += ($row->puppy_rate*$total_stays*($row->puppies));
        $total['puppies_total'] += ($row->puppy_rate*$total_stays*($row->puppies));
    }

    if ($row->extended_stays>0 && ($row->puppies+$row->dogs)>0) {
        $total['stotal'] += ($row->extended_stay_rate*$row->extended_stays*($row->puppies+$row->dogs));
        $total['extended_dog_total'] += ($row->extended_stay_rate*$row->extended_stay_rate*($row->puppies+$row->dogs));
    }

    if ($row->cats>0 && $total_stays>0) {
        $total['stotal'] += ($row->cat_care_rate*$total_stays);
        $stays_label = $total_stays > 1 ? ucfirst($row->price_label).'s' : ucfirst($row->price_label);

        $total['cat_total'] += ($row->cat_care_rate*$total_stays);

        if ($row->cats-1>0) {
            $pet_label = $row->cats-1 > 1 ? 'Cats' : 'Cat';

            $total['additional_cat_total'] += ($row->additional_cat_rate*$total_stays*($row->cats-1));

        }
    }
    if ($row->extended_stays>0 && $row->cats>0) {
        $total['stotal'] += ($row->extended_stay_rate*$row->extended_stays*$row->cats);
        $total['extended_cat_total'] += ($row->extended_stay_rate*$row->extended_stays*$row->cats);
    }
    if ($row->holiday_rate>0 && $row->num_holidays>0) {
        $total['stotal'] += ($row->holiday_rate*$row->num_holidays*$total_pets);
        $total['holiday_total'] += ($row->holiday_rate*$row->num_holidays*$total_pets);

    }

    if ($row->pickup_extra>0) {
        $total['pickup_extra'] = ($row->pickup_extra);
        $total['stotal'] += $total['pickup_extra'];
    }
    if ($row->sixty_minuts_extra>0) {
        $total['sixty_minuts_extra'] = $row->sixty_minuts_extra;
        $total['stotal'] += $total['sixty_minuts_extra'];
    }
    if ($row->bathing_extra>0) {
        $total['bathing_extra'] = $row->bathing_extra;
        $total['stotal'] += $total['bathing_extra'];
    }
    if ($row->play_dates_exta>0) {
        $total['play_dates_exta'] = $row->play_dates_exta;
        $total['stotal'] += $total['play_dates_exta'];
    }
    $total['pfsc_fee'] = round(($total['stotal'] * $row->site_percentage) / 100, 2);
    $total['pfsc_commission'] = round(($total['stotal'] * $row->site_commission) / 100, 2);
    if ($for=='sitter') {
        $total['total'] = $total['stotal']-$total['pfsc_commission'];
    }
    if ($for=='owner') {
        $total['stotal'] += $total['pfsc_fee'];
        $total['total'] = $total['stotal']-$row->discount_amount;
    }
    if ($for=='both') {
        $total['sitter_total'] = $total['stotal']-$total['pfsc_commission'];
        $total['owner_total'] = $total['stotal']+$total['pfsc_fee']-$row->discount_amount;
        $total['gtotal'] = $total['stotal'] + $total['pfsc_fee'];
    }

    if($only_total)
        return floatval($total['total']);
    return $total;
    
}

//***** PERMISSIONS*******///
function has_access($permission_id = 0)
{
    $CI = get_instance();
    if(is_admin())
        return true;
    if(!in_array($permission_id, $CI->session->permissions)){
    // if($permission_id>0 && !is_admin() && !in_array($permission_id,$CI->session->userdata('permissions'))){
        show_404();
        exit;
    }
    return $CI->session->loged_in['id'];
}

function access($permission_id)
{
    $CI = get_instance();
    if(is_admin()) return true;
    return in_array($permission_id, $CI->session->permissions);
}

function is_admin()
{
    $CI = get_instance();
    return $CI->session->loged_in['admin_type']=='admin' ? true : false;
}

function has_permissions($permission_id, $id = 0)
{
    $CI = get_instance();
    if($id<1)
        $id=$CI->session->loged_in['id'];
    return $CI->master->getRow('permissions_admin', array('permission_id' => $permission_id, 'admin_id' => $id));
}

function get_size_weight($size)
{
    $weights = array('small' => '0-15lbs', 'medium' => '16-40lbs', 'large' => '41-100lbs', 'giant' => '101+lbs');
    return $weights[$size];
}
//***** end PERMISSIONS*******///

function get_location_detail($zipcode, $country='gb')
{
    $url = 'https://geocoder.api.here.com/6.2/geocode.json?app_id=IAcDhEZWhrGYOn6m3JnI&app_code=52n2G76qxgU7qRyswkqYaw%20&searchtext='.urlencode($zipcode).',%20'.$country;
    $headers = array(
        'Accept: application/json',
        'Content-Type: application/json');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $data = curl_exec($ch);
    if (curl_error($ch)) {
        echo $error_msg = curl_error($ch);
    }
    curl_close($ch);
    $response = json_decode($data);
    return $response->Response->View[0]->Result[0]->Location->DisplayPosition;
    /*echo $response->Response->View[0]->Result[0]->Location->DisplayPosition->Latitude.'<br>';
    echo $response->Response->View[0]->Result[0]->Location->DisplayPosition->Longitude*/;
}
?>