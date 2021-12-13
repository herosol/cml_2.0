<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Member_model extends CRUD_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table_name = "members";
        $this->field = "mem_id";
    }

    function getMember($mem_id, $where = '')
    {
        if(!empty($where))
            $this->db->where($where);
        $this->db->where('mem_id', $mem_id);
        $query = $this->db->get($this->table_name);
        return $query->row();
    }

    function getMembers($where = '', $start = '', $offset = '', $order_by = '')
    {
        if (!empty($where))
            $this->db->where($where);
        if (!empty($order_by))
            $this->db->order_by("mem_id", $order_by);
        if (!empty($offset))
            $this->db->limit($offset, $start);

        $query = $this->db->get($this->table_name);
        return $query->result();
    }

    function get_nearby_vendors($selections)
    {
        $search_radius = $this->data['site_settings']->site_radius > 0 ? $this->data['site_settings']->site_radius : '10'; 
        $this->db->select('*, ( 3959 * acos( cos( radians("'.$selections['lat'].'") ) * cos( radians( mem_map_lat ) )
        * cos( radians( mem_map_lng ) - radians("'.$selections['long'].'") ) + sin( radians("'.$selections['lat'].'") ) 
        * sin( radians( mem_map_lat ) ) ) ) AS distance');
        $this->db->from($this->table_name);
        $this->db->where(['mem_type'=> 'vendor', 'mem_status'=> '1', 'mem_verified'=> '1']);
        $this->db->having(['distance <=' => $search_radius, 'distance >=' => '0']);
        $nearby_vendors = $this->db->get()->result();

        $vendors = [];
        $locations = [];
        foreach($nearby_vendors as $key => $vendor):
            #CHECK IF WALK-IN FACILITY AND SET FACILITY HOURS
            $facilityCheck = $this->master->num_rows('mem_facility_hours', ['mem_id'=> $vendor->mem_id]);
            if($vendor->mem_company_walkin_facility == 'yes' && $facilityCheck == 0)
                continue;
            
            # CHECK IF VENDOR ALLOW SERVICE IN REQUIRED DISTANCE
            if($vendor->mem_travel_radius >= $vendor->distance):
                # CHECK IF USER PROVIDING ALL REQUIRED SERVICES
                $service_check = vendor_service_check($vendor->mem_id, $selections['selected_service'], $selections['qty']);
                if($service_check['return']):
                    $vendor->estimated_price = $service_check['estimated_price'];
                    $locations[] = [
                        $vendor->mem_business_zip.' ('. round($vendor->distance, 2) . ' miles away)',
                        $vendor->mem_map_lat,
                        $vendor->mem_map_lng,
                        '',
                        $vendor->mem_fname.' '.$vendor->mem_lname.' '. round($vendor->distance, 2) . ' miles away'.' at '.$vendor->mem_business_address. ' ('. $vendor->mem_business_zip .')'
                    ];
                    $vendors[] = $vendor;    
                endif;
            endif;
        endforeach;

        #SORT CHEAPEST FIRST
        usort($vendors, function($first,$second){
            return $first->estimated_price > $second->estimated_price;
        });

        return ['vendors'=> $vendors, 'locations'=> json_encode($locations)]; //json_encode for map locations   
    }

    function get_nearby_vendors_advanced($selections, $params)
    {
        $this->db->from($this->table_name.' mem');
        $this->db->select('mem.*, ( 3959 * acos( cos( radians("'.$selections['lat'].'") ) * cos( radians( mem.mem_map_lat ) )
        * cos( radians( mem.mem_map_lng ) - radians("'.$selections['long'].'") ) + sin( radians("'.$selections['lat'].'") ) 
        * sin( radians( mem.mem_map_lat ) ) ) ) AS distance');

        # IF DISTANCE RANGES
        if(isset($params['distance']))
        {
            $distanceIndexes = explode(';', $params['distance']);
            $distanceStart = $distanceIndexes[0];
            $distanceEnd   = $distanceIndexes[1];
        }
        else
        {
            $distanceStart = '0';
            $distanceEnd   =  $this->data['site_settings']->site_radius > 0 ? $this->data['site_settings']->site_radius : '10'; 
        }
        # IF RATING
        if(isset($params['star_rating']))
        {
            $avgRating = $params['star_rating'];
            $this->db->join('reviews r', 'mem.mem_id = r.mem_id', 'LEFT');
            $this->db->select('AVG(r.rating) as avgRating');
            $this->db->group_by('r.mem_id');
            $this->db->having(['avgRating >=' => $avgRating]);
        }

        $this->db->having(['distance <=' => $distanceEnd, 'distance >=' => $distanceStart]);        
        $this->db->where(['mem.mem_type'=> 'vendor', 'mem.mem_status'=> '1', 'mem.mem_verified'=> '1']);

        $nearby_vendors = $this->db->get()->result();

        $vendors = [];
        $locations = [];
        foreach($nearby_vendors as $key => $vendor):
            #CHECK IF WALK-IN FACILITY AND SET FACILITY HOURS
            $facilityCheck = $this->master->num_rows('mem_facility_hours', ['mem_id'=> $vendor->mem_id]);
            if($vendor->mem_company_walkin_facility == 'yes' && $facilityCheck == 0)
                continue;
            
            # CHECK IF VENDOR ALLOW SERVICE IN REQUIRED DISTANCE
            if($vendor->mem_travel_radius >= $vendor->distance):
                # CHECK IF VENDOR PROVIDING ALL REQUIRED SERVICES
                $service_check = vendor_service_check($vendor->mem_id, $selections['selected_service'], $selections['qty']);
                if($service_check['return']):
                    $vendor->estimated_price = $service_check['estimated_price'];
                    # IF PRICE RANGES
                    if(isset($params['price']))
                    {
                        $priceIndexes = explode(';', $params['price']);
                        $priceStart = $priceIndexes[0];
                        $priceEnd   = $priceIndexes[1];
                        if($service_check['estimated_price'] >= $priceStart && $service_check['estimated_price'] <= $priceEnd)
                        {
                            $locations[] = [
                                $vendor->mem_business_zip.' ('. round($vendor->distance, 2) . ' miles away)',
                                $vendor->mem_map_lat,
                                $vendor->mem_map_lng,
                                '',
                                $vendor->mem_fname.' '.$vendor->mem_lname.' '. round($vendor->distance, 2) . ' miles away'.' at '.$vendor->mem_business_address. ' ('. $vendor->mem_business_zip .')'
                            ];
                            $vendors[] = $vendor;
                        }
                    }
                    else
                    {
                        $locations[] = [
                            $vendor->mem_business_zip.' ('. round($vendor->distance, 2) . ' miles away)',
                            $vendor->mem_map_lat,
                            $vendor->mem_map_lng,
                            '',
                            $vendor->mem_fname.' '.$vendor->mem_lname.' '. round($vendor->distance, 2) . ' miles away'.' at '.$vendor->mem_business_address. ' ('. $vendor->mem_business_zip .')'
                        ];
                        $vendors[] = $vendor;
                    }

                endif;
            endif;
        endforeach;

        #SORT CHEAPEST FIRST
        usort($vendors, function($first,$second){
            return $first->estimated_price > $second->estimated_price;
        });

        return ['vendors'=> $vendors, 'locations'=> $locations];
    }

    function clear_notifs()
    {
        $this->db->set(['status'=> 'seen']);
        $this->db->where(['mem_id'=> $this->session->mem_id]);
        $this->db->update('notifications');
        return true;
    }

    function get_members_by_order($where = '', $start = '', $offset = '', $order_field = 'mem_id', $order_by = '')
    {

        $this->db->select("*, (SELECT AVG(rating) FROM `tbl_reviews` `r` WHERE `r`.`mem_id`=`tbl_members`.`mem_id`) as rating");
        if (!empty($where))
            $this->db->where($where);
        if (!empty($order_by))
            $this->db->order_by($order_field, $order_by);
        if (!empty($offset))
            $this->db->limit($offset, $start);

        $query = $this->db->get($this->table_name);
        return $query->result();
    }

    function get_active_members()
    {

        $this->db->where(array('mem_status' => 1, 'mem_verified' => 1));
        $this->db->order_by("mem_id", $order_by);

        $query = $this->db->get($this->table_name);
        return $query->result();
    }


    function get_player($mem_id)
    {

        $this->db->where(array('mem_status' => 1, 'mem_verified' => 1, 'mem_player_verified' => 1, 'mem_type' => 'player'/*, 'mem_phone_verified' => '1'*/));
        $this->db->where("mem_id", $mem_id);

        $query = $this->db->get($this->table_name);
        return $query->row();
    }
    
    function oldPswdCheck($mem_id, $mem_pswd)
    {
        $mem_pswd = doEncode($mem_pswd);
        $this->db->where('mem_id', $mem_id);
        $this->db->where('mem_pswd', $mem_pswd);
        $query = $this->db->get($this->table_name);
        return $query->row();
    }

    function search_members($post)
    {
        // $this->db->select('mem.*, ms.price, s.price_label, (SELECT AVG(rating) FROM `tbl_reviews` where `tbl_reviews`.mem_id=mem.mem_id and parent_id is NULL) as mem_avg_rating');
        $this->db->from($this->table_name.' mem');
        $this->db->join('characters c', "FIND_IN_SET(c.id, mem.mem_characters) > 0");
        if (!empty($post['character'])) {
            $this->db->group_start()
            // ->where("subject_id in(select id from tbl_subjects where name like '".$this->db->escape_like_str($post['subject'])."%')")
            ->like('c.title', $post['character'], 'both')
            ->or_like('mem.mem_profile_heading', $post['character'], 'both')
            ->or_like('mem.mem_fname', $post['character'], 'both')
            ->or_like('mem.mem_lname', $post['character'], 'both')
            ->group_end();
        }

        if (!empty($post['price'])) {
            $ary = @explode(';', $post['price']);
            $min_rate = floatval(trim($ary[0]));
            $max_rate = floatval(trim($ary[1]));
            $this->db->where("( mem.mem_rate >= $min_rate AND mem.mem_rate <= $max_rate ) ", null, false);
        }
        
        /*
        if (isset($keywords['gender']) && count($keywords['gender']) > 0) {
            $genders = $keywords['gender'];

            foreach ($genders as $gen) {
                $where_type[] = " (gender LIKE '%$gen%')";
            }
            if (count($where_type) > 0) {
                $where_type_string = @implode(' OR ', $where_type);
            }
            $this->db->where(" ( " . $where_type_string . " ) ", null, false);
        }

        if (isset($keywords['gender']) && count($keywords['gender']) > 0) {
            $genders = $keywords['gender'];

            foreach ($genders as $gen) {
                $where_type[] = " (p.gender LIKE '%$gen%')";
            }
            if (count($where_type) > 0) {
                $where_type_string = @implode(' OR ', $where_type);
            }
            $this->db->where(" ( " . $where_type_string . " ) ", null, false);
        }
        */

        $this->db->where('mem.mem_type', 'player');
        $this->db->where('mem.mem_verified', 1);
        $this->db->where('mem.mem_status', 1);
        // $this->db->where('mem.mem_phone_verified', 1);
        $this->db->where('mem.mem_player_verified', 1);

        if (!empty($post['city']))
            $this->db->like('mem.mem_city', $post['city']);
        if (!empty($post['country']))
            $this->db->where("FIND_IN_SET('".$post['country']."', mem.mem_availability) >0");
            // $this->db->where('mem.mem_country_id', $post['country']);

        if (!empty($post['zip'])){
            $coordinates = get_location_detail($post['zip']);
            $post['lat'] = $coordinates->Latitude;
            $post['lng'] = $coordinates->Longitude;
        }
        
        /*if (!empty($post['lat']) && !empty($post['lng'])) {
            $d=intval($post['distance']);
            $this->db->select("mem.*, (69.0 * DEGREES(ACOS(COS(RADIANS({$post['lat']}))
                      * COS(RADIANS(mem.mem_map_lat))
                      * COS(RADIANS({$post['lng']}) - RADIANS(mem.mem_map_lng))
                        + SIN(RADIANS({$post['lat']}))
                      * SIN(RADIANS(mem.mem_map_lat))))) AS distance, (SELECT AVG(rating) FROM `tbl_reviews` where `tbl_reviews`.mem_id = mem.mem_id and parent_id is NULL) as mem_avg_rating
                        ");
            $this->db->having('mem.mem_travel_radius >= distance');
            $this->db->having('distance<=',  50);
        }
        else*/
            $this->db->select('mem.*, (SELECT AVG(rating) FROM `tbl_reviews` where `tbl_reviews`.mem_id = mem.mem_id and parent_id is NULL) as mem_avg_rating');

        /*if (!empty($post['sort']) && in_array($post['sort'], array('asc', 'desc'))) 
            $this->db->order_by('mem.mem_hourly_rate', $post['sort']);*/
        
        $this->db->group_by('mem.mem_id');
        // $this->db->order_by('mem.mem_membership_pref', 'desc');
        return $this->db->get()->result();

        /*$query = $this->db->get();
        $rows = array();
        foreach ($query->result() as $key => $row) {
            $rows[$key] = $row;
            $rows[$key]->total_favorites = $this->total_favorites($row->id);
        }
        return $rows;*/
    }


    function changeStatus($mem_id)
    {
        $this->db->where('mem_id', $mem_id);
        $query = $this->db->get($this->table_name);
        $rs = $query->row();

        if ($rs->mem_status == '0') {
            $vals['mem_status'] = '1';
        } else {
            $vals['mem_status'] = '0';
        }
        $this->db->set($vals);
        $this->db->where('mem_id', $mem_id);
        $this->db->update($this->table_name);
        return $vals['mem_status'];
    }


    function emailExists($mem_email, $mem_id = 0)
    {
        $this->db->where('mem_email', $mem_email);
        $this->db->where('mem_id <> ' . $mem_id);
        $query = $this->db->get($this->table_name);
        return $query->row();
    }

    function phoneExists($mem_phone, $mem_id = 0)
    {
        $this->db->where('mem_phone', $mem_phone);
        $this->db->where('mem_id <> ' . $mem_id);
        $query = $this->db->get($this->table_name);
        return $query->row();
    }

    function forgotEmailExists($mem_email)
    {
        $this->db->where('mem_email', $mem_email);
        $this->db->where('mem_status', '1');
        $this->db->where('mem_verified', '1');
        $query = $this->db->get($this->table_name);
        return $query->row();
    }

    function memberExists($mem_keyword)
    {
        $this->db->where('mem_email', $mem_keyword);
        $this->db->or_where('mem_username', $mem_keyword);
        $query = $this->db->get($this->table_name);
        return $query->row();
    }

    function usernameExists($mem_username)
    {
        $this->db->where('mem_username', $mem_username);
        $query = $this->db->get($this->table_name);
        return $query->row();
    }

    function ipExists($mem_id, $mem_ip)
    {
        if (!empty($mem_ip)) {
            $this->db->where("mem_id <> " . $mem_id);
            $this->db->where('mem_ip', $mem_ip);
            $query = $this->db->get($this->table_name);
            if ($query->row())
                return true;
        }
        return false;
    }

    function socialIdExists($mem_type, $mem_id)
    {
        $this->db->where('mem_social_type', $mem_type);
        $this->db->where('mem_social_id', $mem_id);
        $query = $this->db->get($this->table_name);
        return $query->row();
    }

    function getMemCode($mem_code, $mem_id = 0)
    {
        if($mem_id>0)
            $this->db->where('mem_id', $mem_id);
        $this->db->where('mem_code', $mem_code);
        $query = $this->db->get($this->table_name);
        return $query->row();
    }

    function authenticate($mem_email, $mem_pswd, $mem_type = NULL) {
        $mem_pswd = doEncode($mem_pswd);
        if (!empty($mem_type))
            $this->db->where('mem_type', $mem_type);

        $this->db->where('mem_email', $mem_email);
        $this->db->where('mem_pswd', $mem_pswd);
        // $this->db->where('mem_status', '1');
        $query = $this->db->get($this->table_name);
        // return $this->db->last_query();
        return $query->row();
    }
    function update_last_login($id, $token = '')
    {
        /*
        $this->db->where('mem_id', $id);
        $query = $this->db->get($this->table_name);
        $rs = $query->row();
        */

        // $this->session->set_userdata('last_login', array('ip' => $rs->site_ip, 'time_date' => $rs->site_lastlogindate));

        // $vals['mem_ip'] = $_SERVER["REMOTE_ADDR"];
        if(!empty($token))
            $vals['mem_remember'] = $token;

        $vals['mem_token'] = $this->session->session_id;
        $vals['mem_last_login'] = date('Y-m-d h:i:s');
        $this->save($vals, $id);
    }

    function get_max_rate()
    {
        $this->db->select_max('mem_rate');
        $query = $this->db->get('members');
        return floatval($query->row()->mem_rate);
    }

    function get_max_distance()
    {
        $this->db->select_max('mem_travel_radius');
        $query = $this->db->get($this->table_name);
        return floatval($query->row()->mem_travel_radius);
    }
}
?>

