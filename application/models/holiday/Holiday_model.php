<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Holiday_model extends CI_Model {

	public function save_holiday($data){
		$users=implode(',', $data['user']);
		$report_date = explode('-',$data['start_date'] );
        $followstart_date =  trim($report_date[0]);
        $newstartdate = str_replace('/', '-', $followstart_date);
	//  echo $newstartdate;
        $followend_date =  trim($report_date[1]);
        $newenddate = str_replace('/', '-', $followend_date);
        $from_date = date('Y-m-d', strtotime($newstartdate));
        $to_date = date('Y-m-d', strtotime($newenddate));
		$interval = date_diff(date_create($from_date), date_create($to_date));//difference between date
		$holiday_data = array(
			'from_date'=>$from_date,
			'to_date'=>$to_date,
			'user_ids'=>$users,
			'remark'=>$data['remark'],
			'assign_by'=> logged_user_data(),
			'created_date'=>savedate(),                  
			'updated_date'=>savedate(),                  
			'status'=>1, 
		);
		$this->db->insert('user_holiday',$holiday_data); 
		return ($this->db->affected_rows() == 1) ? true : false; 
		
    }
	
	public function get_holiday_list(){
		$col='holiday_id,user_ids,assign_by,remark,,status,from_date,to_date';
		$this->db->select($col); 
		$this->db->from('user_holiday'); 
		$this->db->where('status',1);
		$query= $this->db->get(); 
		if($this->db->affected_rows()){
			return $query->result_array(); 
		}	
		else{
            return FALSE;
        }
    }

    public function get_holiday_user(){
		$col='holiday_id,user_ids,assign_by,remark,,status,from_date,to_date';
		$con='find_in_set('.logged_user_data().',user_ids)<>0';
		$this->db->select($col); 
		$this->db->from('user_holiday'); 
		$this->db->where($con);
		$query= $this->db->get(); 
		if($this->db->affected_rows()){
			return $query->result_array(); 
		}	
		else{
            return FALSE;
        }
    }
	
	public function get_holiday_data($id){
		$col='holiday_id,user_ids,assign_by,remark,,status,from_date,to_date';
		$this->db->select($col); 
		$this->db->from('user_holiday'); 
		$this->db->where('holiday_id',$id); 
		$query= $this->db->get(); 
		if($this->db->affected_rows()){
			return $query->row(); 
		}	
		else{
            return FALSE;
        }
    }
	
	public function edit_holiday_data($data){
		$users=implode(',', $data['user']);
		$report_date = explode('-',$data['start_date'] );
        $followstart_date =  trim($report_date[0]);
        $newstartdate = str_replace('/', '-', $followstart_date);
		//  echo $newstartdate;
        $followend_date =  trim($report_date[1]);
        $newenddate = str_replace('/', '-', $followend_date);
        $from_date = date('Y-m-d', strtotime($newstartdate));
        $to_date = date('Y-m-d', strtotime($newenddate));
		$interval = date_diff(date_create($from_date), date_create($to_date));//difference between date
		$holiday_data = array(
			'from_date'=>$from_date,
			'to_date'=>$to_date,
			'user_ids'=>$users,
			'remark'=>$data['remark'],
			'updated_date'=>savedate(),  
			'assign_by'=> logged_user_data(),
		);
		$this->db->set($holiday_data);
		$this->db->where('holiday_id',$data['holiday_id']); 
		$this->db->update('user_holiday'); 
		return ($this->db->affected_rows() == 1) ? true : false; 
	
	}
}
?>