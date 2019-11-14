<?php

/* 
 * Niraj Kuamr
 * Dated: 20-02-2018
 * 
 * model for doctor details 
 */

class City_model extends CI_Model {

	public function insertCity($data)
	{
		$this->db->insert('city', $data);
		return TRUE;
	}
	
	public function update_navigation($data)
	{
		/* pr($data);
		die; */
		if($data['visited']==1)//doctor
		{
			$arr = "id";
			$this->db->select($arr);
			$this->db->from("doctor_list");
			$this->db->order_by("id",'asc');
			$query = $this->db->get();
			if($this->db->affected_rows()){
				$docIds=$query->result_array();
			
				foreach($docIds as $id)
				{
					//echo $id['id'].'----'.$data['navigate_id']++; 
					$updateData = array(
					   'doc_navigate_id'=>$data['navigate_id']
					);
					$this->db->where('id', $id['id']);
					$this->db->update('doctor_list', $updateData);
					$data['navigate_id']++; 
				}
				return TRUE;;
			}
			else{
				return FALSE;
			}
		}
		elseif($data['visited']==2)//Dealer
		{
			$arr = "dealer_id";
			$this->db->select($arr);
			$this->db->from("dealer");
			$this->db->order_by("dealer_id",'asc');
			$query = $this->db->get();
			if($this->db->affected_rows()){
				$docIds=$query->result_array();
			
				foreach($docIds as $id)
				{
					$updateData = array(
					   'doc_navigate_id'=>$data['navigate_id']
					);
					$this->db->where('dealer_id', $id['dealer_id']);
					$this->db->update('dealer', $updateData);
					$data['navigate_id']++; 
				}
				return TRUE;;
			}
			else{
				return FALSE;
			}
		}
		elseif($data['visited']==3)//Pharamacy
		{	$arr = "id";
			$this->db->select($arr);
			$this->db->from("pharmacy_list");
			$this->db->order_by("id",'asc');
			$query = $this->db->get();
			if($this->db->affected_rows()){
				$docIds=$query->result_array();
			
				foreach($docIds as $id)
				{
					$updateData = array(
					   'doc_navigate_id'=>$data['navigate_id']
					);
					$this->db->where('id', $id['id']);
					$this->db->update('pharmacy_list', $updateData);
					$data['navigate_id']++; 
				}
				return TRUE;;
			}
			else{
				return FALSE;
			}
		}
	}
	
	public function get_last_city()
	{
		$col='city_id,city_name';
		$this->db->select($col);
		$this->db->from('city');
		$this->db->order_by('city_id','desc');
		$query= $this->db->get(); 
		if($this->db->affected_rows()){
			return $query->row()->city_name;
		}	
		else{
			return '';
		}
	}
	
	public function get_last_city_state()
	{
		$col='city_id,state_id';
		$this->db->select($col);
		$this->db->from('city');
		$this->db->order_by('city_id','desc');
		$query= $this->db->get(); 
		if($this->db->affected_rows()){
			return $query->row()->state_id;
		}	
		else{
			return '';
		}
	}

}