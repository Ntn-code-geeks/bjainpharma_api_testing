<?php

	/* Check unique company phone number */
	function check_pharma_company_number($number,$pharmaid='')
	{
	  $ci = &get_instance();
	  $arr = "id";
	  $ci->db->select($arr);
	  $ci->db->from("pharmacy_list");
	  $ci->db->where('company_phone',$number);
	  if($pharmaid!='')
	  {
	  	$ci->db->where('pharma_id !=',$pharmaid);
	  }
	  $query = $ci->db->get();
	  if($ci->db->affected_rows())
	  {
	    return True;
	  }
	  else
	  {
	    return False;
	  }
	}
	
	/* Check unique doctor phone number */
	function check_doctor_number($number,$doctid='')
	{
	  $ci = &get_instance();
	  $arr = "id";
	  $ci->db->select($arr);
	  $ci->db->from("doctor_list");
	  $ci->db->where('doc_phone',$number);
	  if($doctid!='')
	  {
	  	$ci->db->where('doctor_id !=',$doctid);
	  }
	  $query = $ci->db->get();
	  if($ci->db->affected_rows())
	  {
	    return True;
	  }
	  else
	  {
	    return False;
	  }
	}
	
	/* Check unique dealer phone number */
	function check_dealer_number($number,$dealerid='')
	{
	  $ci = &get_instance();
	  $arr = "dealer_id";
	  $ci->db->select($arr);
	  $ci->db->from("dealer");
	  $ci->db->where('d_phone',$number);
	  if($dealerid!='')
	  {
	  	$ci->db->where('dealer_id!=',$dealerid);
	  }
	  $query = $ci->db->get();
	  if($ci->db->affected_rows())
	  {
	    return True;
	  }
	  else
	  {
	    return False;
	  }
	}
	
	/* get user sp code */
	function api_user_sp_code($id) {  // for user id
	  $ci = &get_instance();
	  $col='sp_code';
	  $ci->db->select($col); 
	  $ci->db->from('pharma_users'); 
	  $ci->db->where('id',$id);
	  $query= $ci->db->get(); 
	  if($ci->db->affected_rows()){
	    return  explode(',',$query->row()->sp_code)[0]; 
	  } 
	  else{
	    return '';
	  }
	}
	
	
	/* get user pharma id*/
//	function get_pharma_id($id) {  // for user id
//	  $ci = &get_instance();
//	  $col='pharma_id';
//	  $ci->db->select($col);
//	  $ci->db->from('pharmacy_list');
//	  $ci->db->where('cromp',$id);
//	  $query= $ci->db->get();
//	  if($ci->db->affected_rows()){
//	    return  $query->row()->pharma_id;
//	  }
//	  else{
//	    return '';
//	  }
//	}
	
	/* get user pharma id*/
	function get_doctor_id($id) {  // for user id
	  $ci = &get_instance();
	  $col='doctor_id';
	  $ci->db->select($col); 
	  $ci->db->from('doctor_list'); 
	  $ci->db->where('cromp',$id);
	  $query= $ci->db->get(); 
	  if($ci->db->affected_rows()){
	    return  $query->row()->doctor_id; 
	  } 
	  else{
	    return '';
	  }
	}
	
	/* get user doctor Number*/
	function get_doctor_number() {  // for user id
	  $ci = &get_instance();
	  $col='doc_phone';
	  $ci->db->select($col); 
	  $ci->db->from('doctor_list'); 
	  $query= $ci->db->get(); 
	  if($ci->db->affected_rows()){
	    return  $query->result_array();  
	  } 
	  else
	  {
	    return '';
	  }
	}
	
	/* get user pharma number */
	function get_pharma_number() {  // for user id
	  $ci = &get_instance();
	  $col='company_phone';
	  $ci->db->select($col); 
	  $ci->db->from('pharmacy_list'); 
	  $query= $ci->db->get(); 
	  if($ci->db->affected_rows()){
	    return  $query->result_array(); 
	  } 
	  else
	  {
	    return '';
	  }
	}
	
	
	
	function get_holiday_data($userid,$fromdate,$todate)
	{
		$ci = &get_instance();
		$col='remark,pu.name,from_date,to_date';
		$con='find_in_set('.$userid.',uh.user_ids) and (uh.from_date >="'.$fromdate.'" and uh.to_date<="'.$todate.'")';
		$ci->db->select($col); 
		$ci->db->from('user_holiday uh'); 
		$ci->db->join("pharma_users pu","pu.id=uh.assign_by");
		$ci->db->where($con);
		$query= $ci->db->get(); 
		if($ci->db->affected_rows())
		{
			return $query->result_array(); 
		} 
		else
		{
			return array();
		}
	}
	
	function get_assign_task_by($userid,$fromdate,$todate)
	{
		$ci = &get_instance();
		$col='at.id,at.tour_date,at.remark,c.city_name,pu.name';
		$con='find_in_set('.$userid.',at.user_ids) and (at.tour_date between "'.$fromdate.'" and "'.$todate.'")';
		$ci->db->select($col); 
		$ci->db->from('assign_tour at');
		$ci->db->join("pharma_users pu","pu.id=at.assign_by");
		$ci->db->join("city c","c.city_id=at.destination");
		$ci->db->where($con);
		$query= $ci->db->get(); 
		if($ci->db->affected_rows())
		{
			return $query->result_array();
		} 
		else
		{
			return array();
		}
	}
	
	function get_followup_data($userid,$fromdate,$todate)
	  {
            $followup=array();		
	    while($fromdate<=$todate)
	    {
		    $fromdate=date('Y-m-d', strtotime($fromdate. ' +1 day'));
		    $remark='';
		    $ci = &get_instance();
		    $col='GROUP_CONCAT(remark) as remark, d_id as cust_id';
		    $con='follow_up_action ="'.$fromdate.' 00:00:00"';
		    $ci->db->select($col); 
		    $ci->db->from('pharma_interaction_dealer'); 
		    $ci->db->where($con);
			$ci->db->where('crm_user_id',$userid);
		    $query= $ci->db->get(); 
		    if($ci->db->affected_rows()){
		      if(!is_null($query->row()->remark ))
		      {
				  $remark= $query->row()->remark.';'.$query->row()->cust_id;
		      }
		    }
		    $ci = &get_instance();
		    $col='GROUP_CONCAT(remark) as remark, doc_id as cust_id';
		    $con='follow_up_action ="'.$fromdate.' 00:00:00"';
		    $ci->db->select($col); 
		    $ci->db->from('pharma_interaction_doctor'); 
		    $ci->db->where($con);
			$ci->db->where('crm_user_id',$userid);
		    $query= $ci->db->get(); 
		    if($ci->db->affected_rows()){
		      if(!is_null($query->row()->remark))
		      {
				  $remark= $remark.','.$query->row()->remark.';'.$query->row()->cust_id;
		      }
		    }
		    $ci = &get_instance();
		    $col='GROUP_CONCAT(remark) as remark, pharma_id as cust_id';
		    $con='follow_up_action ="'.$fromdate.' 00:00:00"';
		    $ci->db->select($col); 
		    $ci->db->from('pharma_interaction_pharmacy'); 
		    $ci->db->where($con);
			$ci->db->where('crm_user_id',$userid);
		    $query= $ci->db->get(); 
		    if($ci->db->affected_rows()){
		      if(!is_null($query->row()->remark ))
		      {
				  $remark= $remark.','.$query->row()->remark.';'.$query->row()->cust_id;
		      }
		    }
		    if($remark!='')
		    {
				$filtered_remarks=array_filter(explode(',',$remark));
				$final_remarks=implode(',',$filtered_remarks);

		    	$followup[]=array('date'=>$fromdate,'remark'=>$final_remarks) ;
		    }
		    
	    	
	    }
	    return $followup;
	  }
	  
	function get_interaction_source_api($user_id){
    $ci = &get_instance();
    $col='source_city_pin,up_down';
    $ci->db->select($col); 
    $ci->db->from('ta_da_report'); 
    $ci->db->where('user_id',$user_id); 
    //$ci->db->where('up_down',1); 
    $ci->db->limit(1);
    $ci->db->order_by('id','DESC');
    $query= $ci->db->get(); 
    if($ci->db->affected_rows()){
      $up= $query->row()->up_down;
      if($up)
      {
        return  get_user_deatils($user_id)->hq_city_pincode;
      }
      else
      {
        $table='intearction_replica';
        $col='interaction_with';
        $ci->db->select($col); 
        $ci->db->from($table); 
        $ci->db->where('crm_user_id',$user_id); 
        $ci->db->limit(1,1);
        $ci->db->order_by('id','DESC');
        $query= $ci->db->get(); 
        if($ci->db->affected_rows()){
          $id= $query->row()->interaction_with; 
           $source=0;
          if(!is_numeric($id))
            {
                if(substr($id,0,3)=='doc'){
                    //doctor
                    $source=get_destination_interaction('doctor_list',$id,1);
                }
                else{
                   //pharma 
                    $source=get_destination_interaction('pharmacy_list',$id,2);
                }
            }
            else{
               //dealer 
                $source=get_destination_interaction('dealer',$id,3);
            }
            return $source;
        } 
        else{
          return get_user_deatils($user_id)->hq_city_pincode;
        }
      }
    } 
    else{
      $table='intearction_replica';
      $col='interaction_with';
      $ci->db->select($col); 
      $ci->db->from($table); 
      $ci->db->where('crm_user_id',$user_id); 
      $ci->db->limit(1,1);
      $ci->db->order_by('id','DESC');
      $query= $ci->db->get(); 
      if($ci->db->affected_rows()){
        $id= $query->row()->interaction_with; 
        $source=0;
        if(!is_numeric($id))
          {
              if(substr($id,0,3)=='doc'){
                  //doctor
                  $source=get_destination_interaction('doctor_list',$id,1);
              }
              else{
                 //pharma 
                  $source=get_destination_interaction('pharmacy_list',$id,2);
              }
          }
          else{
             //dealer 
              $source=get_destination_interaction('dealer',$id,3);
          }
          return $source;
      } 
      else{
        return get_user_deatils($user_id)->hq_city_pincode;
      }
    }
  }

    function get_interaction_source_id_api($user_id){

    $ci = &get_instance();
    $col='source_city,up_down';
    $ci->db->select($col); 
    $ci->db->from('ta_da_report'); 
    $ci->db->where('user_id',$user_id); 
    //$ci->db->where('up_down',1); 
    $ci->db->limit(1);
    $ci->db->order_by('id','DESC');
    $query= $ci->db->get(); 
    if($ci->db->affected_rows()){
      $up= $query->row()->up_down;
      if($up)
      {
        return get_user_deatils($user_id)->headquarters_city;
      }
      else
      {
        $table='intearction_replica';
        $ci = &get_instance();
        $col='interaction_with';
        $ci->db->select($col); 
        $ci->db->from($table); 
        $ci->db->where('crm_user_id',$user_id); 
        $ci->db->limit(1,1);
        $ci->db->order_by('id','DESC');
        $query= $ci->db->get(); 
        if($ci->db->affected_rows()){
          $id= $query->row()->interaction_with; 
           $source=0;
          if(!is_numeric($id))
            {
                if(substr($id,0,3)=='doc'){
                    //doctor
                    $source=get_destination_interaction_id('doctor_list',$id,1);
                }
                else{
                   //pharma 
                    $source=get_destination_interaction_id('pharmacy_list',$id,2);
                }
            }
            else{
               //dealer 
                $source=get_destination_interaction_id('dealer',$id,3);
            }
            return $source;
        } 
        else{
          return get_user_deatils($user_id)->headquarters_city;
        }
      }
    }
    else{
      $table='intearction_replica';
      $ci = &get_instance();
      $col='interaction_with';
      $ci->db->select($col); 
      $ci->db->from($table); 
      $ci->db->where('crm_user_id',$user_id); 
      $ci->db->limit(1,1);
      $ci->db->order_by('id','DESC');
      $query= $ci->db->get(); 
      if($ci->db->affected_rows()){
        $id= $query->row()->interaction_with; 
         $source=0;
        if(!is_numeric($id))
          {
              if(substr($id,0,3)=='doc'){
                  //doctor
                  $source=get_destination_interaction_id('doctor_list',$id,1);
              }
              else{
                 //pharma 
                  $source=get_destination_interaction_id('pharmacy_list',$id,2);
              }
          }
          else{
             //dealer 
              $source=get_destination_interaction_id('dealer',$id,3);
          }
          return $source;
      } 
      else{
        return get_user_deatils($user_id)->headquarters_city;
      }
    }
  }
  
    function get_holiday_details_data($user_id,$date){
    $ci = &get_instance();
    $col='holiday_id,user_ids,assign_by,remark,,status,from_date,to_date';
    $con='find_in_set('.$user_id.',user_ids) and (from_date <="'.$date.'" and to_date>="'.$date.'")';
    $ci->db->select($col); 
    $ci->db->from('user_holiday'); 
    $ci->db->where($con);
    $query= $ci->db->get(); 
    if($ci->db->affected_rows()){
      return $query->row(); 
    } 
    else{
      return FALSE;
    }
  }
	
	
	/* get check user leave */
	function check_leave($idate,$user_id)
{ 
   	$ci = &get_instance();
	$ci->db->select('from_date,to_date');
	$ci->db->from('user_leave');
	$ci->db->where('user_id',$user_id);
	$ci->db->where('leave_status',1);
	$query = $ci->db->get();
	//echo $ci->db->last_query();die;
	if ($query->num_rows() > 0) 
	{
		$dateData=$query->result_array();
		foreach($dateData as $dates)
		{
			$ci->db->select('leave_id');
			$ci->db->from('user_leave');
			$ci->db->where("'".date('Y-m-d',strtotime($idate))."' >= '".$dates['from_date']."' AND '".date('Y-m-d',strtotime($idate))."'<='".$dates['to_date']."'");
			$ci->db->where('user_id',$user_id);
			$ci->db->where('leave_status',1);
			$query1 = $ci->db->get();
			if ($query1->num_rows() > 0) {
				return FALSE;
			}
		}
		$con='find_in_set('.$user_id.',user_ids)<>0';
		$ci->db->select('from_date,to_date');
		$ci->db->from('user_holiday');
		$ci->db->where($con);
		// $ci->db->where('leave_status',1);
		$query = $ci->db->get();
		//echo $ci->db->last_query();die;
		if ($query->num_rows() > 0) {
			$dateData=$query->result_array();
			foreach($dateData as $dates)
			{
				$ci->db->select('holiday_id');
				$ci->db->from('user_holiday');
				$ci->db->where("'".date('Y-m-d',strtotime($idate))."' >= '".$dates['from_date']."' AND '".date('Y-m-d',strtotime($idate))."'<='".$dates['to_date']."'");
				$ci->db->where($con);
			  //  $ci->db->where('leave_status',1);
				$query1 = $ci->db->get();
				if ($query1->num_rows() > 0) {
					return FALSE;
				}
			}
			return TRUE;
		}
		else{
			return TRUE;
		}
		return TRUE;
	}
	else
	{
		$con='find_in_set('.$user_id.',user_ids)<>0';
		$ci->db->select('from_date,to_date');
		$ci->db->from('user_holiday');
		$ci->db->where($con);
		// $ci->db->where('leave_status',1);
		$query = $ci->db->get();
		//echo $ci->db->last_query();die;
		if ($query->num_rows() > 0) {
			$dateData=$query->result_array();
			foreach($dateData as $dates)
			{
				$ci->db->select('holiday_id');
				$ci->db->from('user_holiday');
				$ci->db->where("'".date('Y-m-d',strtotime($idate))."' >= '".$dates['from_date']."' AND '".date('Y-m-d',strtotime($idate))."'<='".$dates['to_date']."'");
				$ci->db->where($con);
			  //  $ci->db->where('leave_status',1);
				$query1 = $ci->db->get();
				if ($query1->num_rows() > 0) {
					return FALSE;
				}
			}
			return TRUE;
		}
		else{
			return TRUE;
		}
		return TRUE;
	}
}

	function check_inteaction($newstartdate,$newenddate,$user_id)
	{
		$ci = &get_instance();
        $from_date = date('Y-m-d', strtotime($newstartdate));
        $to_date = date('Y-m-d', strtotime($newenddate));
		$date = new DateTime($from_date);
		$todate = new DateTime($to_date);
		$date->modify('+1 day');
		$todate->modify('+1 day');
		$ci->db->select('id');
		$ci->db->from('pharma_interaction_dealer');
		$ci->db->where('crm_user_id',$user_id);
		$ci->db->where("create_date BETWEEN '".$date->format('Y-m-d')."' AND '".$todate->format('Y-m-d')."'");
		$query1 = $ci->db->get();
		if($ci->db->affected_rows()>0)
		{
			return FALSE;
		}
		$ci->db->select('id');
		$ci->db->from('pharma_interaction_pharmacy');
		$ci->db->where('crm_user_id',$user_id);
		$ci->db->where("create_date BETWEEN '".$date->format('Y-m-d')."' AND '".$todate->format('Y-m-d')."'");
		$query1 = $ci->db->get();
		if($ci->db->affected_rows()>0)
		{
			return FALSE;
		}
		$ci->db->select('id');
		$ci->db->from('pharma_interaction_doctor');
		$ci->db->where('crm_user_id',$user_id);
		$ci->db->where("create_date BETWEEN '".$date->format('Y-m-d')."' AND '".$todate->format('Y-m-d')."'");
		$query1 = $ci->db->get();
		if($ci->db->affected_rows()>0)
		{
			return FALSE;
		}

		$ci->db->select('meeting_id');
		$ci->db->from('user_meeting');
		$ci->db->where('crm_user_id',$user_id);
		$ci->db->where("meeting_date BETWEEN '".$date->format('Y-m-d')."' AND '".$todate->format('Y-m-d')."'");
		$query1 = $ci->db->get();
		if($ci->db->affected_rows()>0)
		{
			return FALSE;
		}
		return TRUE;
	}

	function get_leaves_deatils($userid,$date){
	$ci = &get_instance();
	$col='leave_id,user_id,remark,status,leave_status,from_date,to_date';
	$con='find_in_set('.$userid.',user_id) and (from_date <="'.$date.'" and to_date>="'.$date.'")';
	$ci->db->select($col);
	$ci->db->from('user_leave');
	$ci->db->where($con);
	$query= $ci->db->get();
	if($ci->db->affected_rows()){
		return $query->row();
	}
	else{
		return FALSE;
	}
}

	function get_user_child($id){
	$ci = &get_instance();
//	$results=array();
	$ci->db->select('user_id');
	$ci->db->from('user_bossuser_relation');
	$ci->db->where('boss_id',$id);
	$query= $ci->db->get();
//	echo $ci->db->last_query(); die;
	if($query->num_rows() > 0){
		$results=$query->result_array();
		$res_count=count($results);
		if($res_count >= 1 ){
			$mrge_res=array();
			foreach($results as $res){
				$mrge_res[]=$res['user_id'];
			}
			return $mrge_res;
		}
	}
	else{
		return FALSE;
	}

}


function get_leaves_inmonth($userid,$fromdate,$todate)
{
	$ci = &get_instance();
	$col='remark,user_id,from_date,to_date';
	$con='find_in_set('.$userid.',ul.user_id) and (ul.from_date >="'.$fromdate.'" and ul.to_date<="'.$todate.'")';
	$ci->db->select($col);
	$ci->db->from('user_leave ul');
	$ci->db->where($con);
	$query= $ci->db->get();
	if($ci->db->affected_rows())
	{
		return $query->result_array();
	}
	else
	{
		return array();
	}
}

?>
