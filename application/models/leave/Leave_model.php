<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Leave_model extends CI_Model {

	public function save_leave($data){

	$report_date = explode('-',$data['start_date'] );
        $followstart_date =  trim($report_date[0]);
        $newstartdate = str_replace('/', '-', $followstart_date);
	//  echo $newstartdate;
        $followend_date =  trim($report_date[1]);
        $newenddate = str_replace('/', '-', $followend_date);
        $from_date = date('Y-m-d', strtotime($newstartdate));
        $to_date = date('Y-m-d', strtotime($newenddate));
	$interval = date_diff(date_create($from_date), date_create($to_date));//difference between date
	$leave_data = array(
		'from_date'=>$from_date,
		'to_date'=>$to_date,
		'remark'=>$data['remark'],
		'user_id'=> logged_user_data(),
		'created_date'=>savedate(),                  
		'updated_date'=>savedate(),                  
		'status'=>1, 
		'leave_status'=>1,
	);
	$this->db->insert('user_leave',$leave_data); 
	return ($this->db->affected_rows() == 1) ? true : false; 
		
    }
	
	public function get_leave_list(){
		$col='leave_id,user_id,from_date,to_date,remark,status,leave_status';
		$this->db->select($col); 
		$this->db->from('user_leave'); 
		if(!is_admin()){
	        $this->db->where('user_id',logged_user_data());
	    }
		$query= $this->db->get(); 
		if($this->db->affected_rows()){
			return $query->result_array(); 
		}	
		else{
            return FALSE;
        }
    }
	
	public function cancel_leave_data($id){
		$leave_data = array(
			'updated_date'=>savedate(),                  
			'leave_status'=>0,
		);
		$this->db->set($leave_data);
		$this->db->where('leave_id',$id); 
		$this->db->update('user_leave'); 
		if($this->db->affected_rows()){
			return TRUE; 
		}	
		else{
            return FALSE;
        }
    }
	
	public function get_leave_data($id){
		$col='leave_id,user_id,from_date,to_date,remark,status,leave_status';
		$this->db->select($col); 
		$this->db->from('user_leave'); 
		$this->db->where('leave_id',$id); 
		$query= $this->db->get(); 
		if($this->db->affected_rows()){
			return $query->result_array(); 
		}	
		else{
            return FALSE;
        }
    }
	
	public function edit_leave_data($data){
		$report_date = explode('-',$data['start_date'] );
	        $followstart_date =  trim($report_date[0]);
	        $newstartdate = str_replace('/', '-', $followstart_date);
		//  echo $newstartdate;
	        $followend_date =  trim($report_date[1]);
	        $newenddate = str_replace('/', '-', $followend_date);
	        $from_date = date('Y-m-d', strtotime($newstartdate));
	        $to_date = date('Y-m-d', strtotime($newenddate));
		$interval = date_diff(date_create($from_date), date_create($to_date));//difference between date
		$leave_data = array(
			'from_date'=>$from_date,
			'to_date'=>$to_date,
			'remark'=>$data['remark'],
			'updated_date'=>savedate(),                  
		);
		$this->db->set($leave_data);
		$this->db->where('leave_id',$data['leave_id']); 
		$this->db->update('user_leave'); 
		return ($this->db->affected_rows() == 1) ? true : false; 
	
	}
	
	public function check_inteaction($data){
		$report_date = explode('-',$data['start_date'] );
        $followstart_date =  trim($report_date[0]);
        $newstartdate = str_replace('/', '-', $followstart_date);
	//  echo $newstartdate;
        $followend_date =  trim($report_date[1]);
        $newenddate = str_replace('/', '-', $followend_date);
        $from_date = date('Y-m-d', strtotime($newstartdate));
        $to_date = date('Y-m-d', strtotime($newenddate));
		$date = new DateTime($from_date);
		$todate = new DateTime($to_date);
		$date->modify('+1 day');
		$todate->modify('+1 day');
		$this->db->select('id');
		$this->db->from('pharma_interaction_dealer');
		$this->db->where('crm_user_id',logged_user_data());
		$this->db->where("create_date BETWEEN '".$date->format('Y-m-d')."' AND '".$todate->format('Y-m-d')."'");
		$query1 = $this->db->get();
		if($this->db->affected_rows()>0)
		{
			return FALSE;
		}
		$this->db->select('id');
		$this->db->from('pharma_interaction_pharmacy');
		$this->db->where('crm_user_id',logged_user_data());
		$this->db->where("create_date BETWEEN '".$date->format('Y-m-d')."' AND '".$todate->format('Y-m-d')."'");
		$query1 = $this->db->get();
		if($this->db->affected_rows()>0)
		{
			return FALSE;
		}
		$this->db->select('id');
		$this->db->from('pharma_interaction_doctor');
		$this->db->where('crm_user_id',logged_user_data());
		$this->db->where("create_date BETWEEN '".$date->format('Y-m-d')."' AND '".$todate->format('Y-m-d')."'");
		$query1 = $this->db->get();
		if($this->db->affected_rows()>0)
		{
			return FALSE;
		}

		$this->db->select('meeting_id');
		$this->db->from('user_meeting');
		$this->db->where('crm_user_id',logged_user_data());
		$this->db->where("meeting_date BETWEEN '".$date->format('Y-m-d')."' AND '".$todate->format('Y-m-d')."'");
		$query1 = $this->db->get();
		if($this->db->affected_rows()>0)
		{
			return FALSE;
		}
		return TRUE;
	}
}
?>