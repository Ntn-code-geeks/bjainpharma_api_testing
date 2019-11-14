<?php


/*
 * Developer: Niraj Sharma
 * Email: niraj@bjain.com
 * 
 * Dated: 28-08-2018
 * 
 */

class Users_api_model extends CI_Model {


    public function check_user_api($mail)
    {
 	$arr ="pu.sp_code,pu.switchStatus,pu.id,pu.email_id,pu.password,pu.name,pu.user_city_id as city_id,pu.user_designation_id as desig_id,(SELECT GROUP_CONCAT(`pharma_id` separator ', ') as pharma_id FROM `user_pharmacy_relation` `upr` WHERE `pu`.`id`=`upr`.`user_id`) as pharma_id,(SELECT GROUP_CONCAT(ubr.`boss_id` separator ', ') as boss_id FROM `user_bossuser_relation` `ubr` WHERE `pu`.`id`=`ubr`.`user_id`) as boss_ids ,(SELECT GROUP_CONCAT(udr.`doc_id` separator ', ') as doctor_id FROM `user_doctor_relation` `udr` WHERE `pu`.`id`=`udr`.`user_id`) as doctor_id ,"
        . "(SELECT GROUP_CONCAT(ubr.`user_id` separator ', ') as boss_id FROM `user_bossuser_relation` `ubr` WHERE `pu`.`id`=`ubr`.`boss_id`) as child_ids ";
        $this->db->select($arr);
        $this->db->from('pharma_users pu');
        $this->db->where('pu.email_id',$mail);
        $this->db->where('pu.user_status',1);
        $query= $this->db->get();
        //echo $this->db->last_query(); die;
        if($this->db->affected_rows())
        {
            return $query->row();
        }
        else
        {
            return FALSE;
        }
    }

    public function get_all_city()
    {
        $arr = "c.city_id,c.state_id,c.city_name,c.is_metro,s.state_name";
        $this->db->select($arr);
        $this->db->from('city c');
        $this->db->join("state s","s.state_id=c.state_id");
        $this->db->where('c.status',1);
        $query= $this->db->get();
	// echo $this->db->last_query(); die;
        if($this->db->affected_rows())
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }
    }
    
    
    public function get_all_state()
    {
        $arr = "state_id,state_name";
        $this->db->select($arr);
        $this->db->from('state');
        $this->db->where('status',1);
        $query= $this->db->get();
	// echo $this->db->last_query(); die;
        if($this->db->affected_rows())
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }
    }
    
    public function get_users_boss($userid)
    {
        $arr = "u.id,u.name";
        $this->db->select($arr);
        $this->db->from('user_bossuser_relation ur');
        $this->db->join("pharma_users u","ur.boss_id=u.id",'left');
        $this->db->where('u.user_status',1);
        $this->db->where('ur.user_id',$userid);
        $query= $this->db->get();
	// echo $this->db->last_query(); die;
        if($this->db->affected_rows())
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }
    }
    
    public function get_users_subordinates($userid)
    {
        $arr = "u.id,u.name";
        $this->db->select($arr);
        $this->db->from('user_bossuser_relation ur');
        $this->db->join("pharma_users u","ur.user_id=u.id",'left');
        $this->db->where('u.user_status',1);
        $this->db->where('ur.boss_id',$userid);
        $query= $this->db->get();
        if($this->db->affected_rows())
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }
    }
    
    function get_assign_task($user){
    //$ci = &get_instance();
    $col='at.id,c.city_name,at.tour_date,at.remark,u.name,at.destination as city_id,at.assign_by';
    $con='find_in_set('.$user.',user_ids)<>0 AND at.tour_date BETWEEN "'.present_date().'" AND "'.nextmonth_last_date().'"';
    $this->db->select($col); 
    $this->db->from('assign_tour at'); 
    $this->db->join("pharma_users u","u.id=at.assign_by",'left');
    $this->db->join("city c","c.city_id=at.destination",'left');
    $this->db->where($con);
    $query= $this->db->get(); 
//echo $this->db->last_query(); die;
    if($this->db->affected_rows()){
      return $query->result_array(); 
    } 
    else{
      return FALSE;
    }
  }
  
	// get doctor status list
	public function get_doctor_status()
    {
        $arr = "status_id,status_name";
        $this->db->select($arr);
        $this->db->from('doctor_status');
        $query= $this->db->get();
        if($this->db->affected_rows())
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }
    }
  
  
  
   
}

