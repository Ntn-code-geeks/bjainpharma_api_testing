<?php

/* 
 * Niraj Kuamr
 * Dated: 20-02-2018
 * 
 * model for doctor details 
 */

class User_model extends CI_Model {

	public function getUserList()
	{
		$this->db->select('id,name');
        $this->db->from('pharma_users');
		$query= $this->db->get();   
        if($query->num_rows() > 0){
            
            return $query->result_array();
        }
        else{
            
            return FALSE;
        }
	}
	
	public function getUserBoss($id='')
	{
		$results[]=array();
		$this->db->select('user_id,boss_id');
        $this->db->from('user_bossuser_relation');
        $this->db->where('user_id',$id);
		$query= $this->db->get();   
        if($query->num_rows() > 0){
            $userData=$query->result_array();
			foreach($userData as $key => $value)
			{
				$this->db->select('id,name,	user_phone,email_id');
				$this->db->from('pharma_users');
				$this->db->where('id',$value['boss_id']);
				$query1= $this->db->get(); 
				$userBoss=$query1->result_array();
				$results[$key]["name"] = $userBoss[0]['name'];  
				$results[$key]["user_phone"] =$userBoss[0]['user_phone'];  
				$results[$key]["email_id"] = $userBoss[0]['email_id'];   
			}
			return $results;
        }
        else{
            return FALSE;
        }
	}
}