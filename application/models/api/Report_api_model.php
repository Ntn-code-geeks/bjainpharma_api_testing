<?php


/*
 * Developer: Niraj Sharma
 * Email: niraj@bjain.com
 * 
 * Dated: 28-08-2018
 * 
 */

class Report_api_model extends CI_Model {


    
    public function doctor_interaction_view($userid)
    {
	//echo $limit; die;  
     	$arr = " dl.doc_name as doctorname,pid.orignal_sale as actualsale,pid.id,`pid`.`meeting_sale` secondarysale, `pid`.`create_date` as `date_of_interaction`,d.dealer_name ,pl.company_name as pharmaname,pid.close_status";
        $this->db->select($arr);
        $this->db->from("pharma_interaction_doctor pid");
	$this->db->join("doctor_list dl","dl.doctor_id=pid.doc_id");
        $this->db->join("dealer d","d.dealer_id=pid.dealer_id","left");
        $this->db->join("pharmacy_list pl","pl.pharma_id=pid.dealer_id","left");
        $this->db->join("doctor_interaction_with_team team","team.pidoc_id=pid.id","left");
      	$this->db->where("pid.meeting_sale !=","");
      	$this->db->where("pid.status =",1);
	//$this->db->where("pid.dealer_id IS NOT NULL",NULL, FALSE);
        if($userid!=28 && $userid!=29 &&  $userid!=32)
        {
	        $this->db->where("(pid.crm_user_id=".$userid." or team.team_id=".$userid.")");
	}
        $query = $this->db->get();
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
    
    public function pharmacy_interaction_view($userid)
    {
        $arr = " pl.company_name as pharmaname,pip.orignal_sale as actualsale,pip.id,`pip`.`meeting_sale` as secondarysale, `pip`.`create_date` as `date_of_interaction`,d.dealer_name,pip.close_status";
        $this->db->select($arr);
        $this->db->from("pharma_interaction_pharmacy pip");
        $this->db->join("pharmacy_list pl","pl.pharma_id=pip.pharma_id");
        $this->db->join("dealer d","d.dealer_id=pip.dealer_id","left");
        $this->db->join("pharmacy_interaction_with_team team","team.pipharma_id=pip.id","left");
        $this->db->where("pip.meeting_sale !=","");
        $this->db->where("pip.status =",1);
        if($userid!=28 && $userid!=29 &&  $userid!=32)
        {
          $this->db->where("(pip.crm_user_id=".$userid." or team.team_id=".$userid.")");
        }
        $query = $this->db->get();
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
    
    public function get_tp_report($userid='',$start='',$end='')
    {
	/* Geting Pharma Interaction */
	$start=date('Y-m-d', strtotime($start));
	$end=date('Y-m-d', strtotime($end));
	$arr = "stp.source,stp.destination,stp.dot,stp.remark,stp.assign_by,c.city_name as destination_city,c1.city_name as source_city,u.name,tst as strtime,tet as endtime";
        $this->db->select($arr);        
        $this->db->from("user_stp stp");
        $this->db->join("pharma_users u","u.id=stp.assign_by",'left');
        $this->db->join("city c","c.city_id=stp.destination",'left');
        $this->db->join("city c1","c1.city_id=stp.source",'left');
        $this->db->where('stp.crm_user_id',$userid);
        $this->db->where('stp.dot  >=', $start);
	$this->db->where('stp.dot  <=', $end);
        $queryIntearction = $this->db->get();
        if($this->db->affected_rows())
        {
		return $queryIntearction->result_array();
        }
        else
        {
        	return False;
        }
    }
   
}

