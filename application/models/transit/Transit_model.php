<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Transit_model extends CI_Model {

	public function save_transit($data,$ticketAttachment,$billAttachment){
		$cityFare='';
		$transit_date = date('Y-m-d', strtotime($data['transit_date']));
		$transit_st_time = date('H:i:s', strtotime($data['transit_st_time']));
		$transit_time_end = date('H:i:s', strtotime($data['transit_time_end']));
		$travelData=$this->get_user_traveldata();
		$cityData=$this->check_city_path($data);
		$cityDistance=$cityData->distance;
		$cityFare=$cityData->fare;
		if($data['stay']==1)
		{
			$cityFare=$cityData->fare+$travelData->da_amount;
		}
		else
		{
			$cityFare=$cityData->fare;
		}
		$transit_data = array(
			'source'=>$data['source_city'],
			'destination'=>$data['dest_city'],
			'remark'=>$data['remark'],
			'transit_date'=>$transit_date,
			'transit_time_start'=>$transit_st_time,
			'transit_time_end'=>$transit_time_end,
			'crm_user_id'=> logged_user_data(),
			'total_fare'=> $cityFare,
			'total_distance'=> $cityDistance,
			'created_date'=>savedate(),                  
			'updated_date'=>savedate(),                  
			'status'=>1, 
			'stay'=>$data['stay'], 
			'ticket_attachment'=>$ticketAttachment, 
			'bill_attachment'=>$billAttachment, 
			'transit_status'=>0, 
		);
		$this->db->insert('user_transit',$transit_data); 
		return ($this->db->affected_rows() == 1) ? true : false; 
		
    }
	
	public function save_other_transit($data,$ticketAttachment,$billAttachment){
		$transit_date = date('Y-m-d', strtotime($data['transit_date']));
		$transit_st_time = date('H:i:s', strtotime($data['transit_st_time']));
		$transit_time_end = date('H:i:s', strtotime($data['transit_time_end']));
		$transit_data = array(
			'source'=>$data['source_city'],
			'destination'=>$data['dest_city'],
			'remark'=>$data['remark'],
			'transit_date'=>$transit_date,
			'transit_time_start'=>$transit_st_time,
			'transit_time_end'=>$transit_time_end,
			'crm_user_id'=> logged_user_data(),
			'created_date'=>savedate(),                  
			'updated_date'=>savedate(),                  
			'status'=>1, 
			'transit_status'=>1,
			'stay'=>$data['stay'], 
			'ticket_attachment'=>$ticketAttachment, 
			'bill_attachment'=>$billAttachment, 			
		);
		$this->db->insert('user_transit',$transit_data); 
		return ($this->db->affected_rows() == 1) ? true : false; 
		
    }
	
	public function get_transit_list(){
		$arr = "transit_id,source,destination,transit_date,transit_time_start,transit_time_end,remark,transit_status";
        $this->db->select($arr);
        $this->db->from("user_transit");
        $this->db->where('status',1);
		 $this->db->where('crm_user_id',logged_user_data());
        $query = $this->db->get();
        if($this->db->affected_rows()){
			return $query->result_array();
		}
        else{
            return FALSE;
        }
	}

	public function check_city_path($data){
		//SELECT * FROM `master_tour_data` WHERE  (source_city=11 or dist_city=11) AND (source_city=46 or dist_city=46) AND pharma_user_id=28
		$con='(source_city='.$data['source_city'].' or dist_city='.$data['source_city'].') AND (source_city='.$data['dest_city'].' or dist_city='.$data['dest_city'].') AND status=1 AND pharma_user_id='.logged_user_data();
		$arr = "source_city ,dist_city, fare ,distance";
		$this->db->distinct();
        $this->db->select($arr);
        $this->db->from("master_tour_data");
        $this->db->where($con);
        $query = $this->db->get();
        if($this->db->affected_rows()){
			return $query->row();
		}
        else{
            return FALSE;
        }
	}
	
	public function get_transit_data($id){
		$col='transit_id,source,destination,transit_date,transit_time_start,transit_time_end,remark,transit_status,stay,ticket_attachment,bill_attachment';
		$this->db->select($col); 
		$this->db->from('user_transit'); 
		$this->db->where('transit_id',$id); 
		$query= $this->db->get(); 
		if($this->db->affected_rows()){
			return $query->result_array(); 
		}	
		else{
            return FALSE;
        }
    }
	
	public function update_transit($data,$ticketAttachment,$billAttachment){
		$cityFare='';
		$transit_date = date('Y-m-d', strtotime($data['transit_date']));
		$transit_st_time = date('H:i:s', strtotime($data['transit_st_time']));
		$transit_time_end = date('H:i:s', strtotime($data['transit_time_end']));
		$cityData=$this->check_city_path($data);
		$cityDistance=$cityData->distance;
		if($data['stay']==1)
		{
			$cityFare=$cityData->fare+$travelData->da_amount;
		}
		else
		{
			$cityFare=$cityData->fare;
		}
		$transit_data = array(
			'source'=>$data['source_city'],
			'destination'=>$data['dest_city'],
			'remark'=>$data['remark'],
			'transit_date'=>$transit_date,
			'transit_time_start'=>$transit_st_time,
			'transit_time_end'=>$transit_time_end,
			'total_fare'=> $cityFare,
			'total_distance'=> $cityDistance,
			'stay'=>$data['stay'], 
			'ticket_attachment'=>$ticketAttachment, 
			'bill_attachment'=>$billAttachment, 	
			'updated_date'=>savedate(),                  
		);
		$this->db->set($transit_data);
		$this->db->where('transit_id',$data['transit_id']); 
		$this->db->update('user_transit'); 
		return ($this->db->affected_rows() == 1) ? true : false; 
    }
	
	public function update_other_transit($data,$ticketAttachment,$billAttachment){
		$transit_date = date('Y-m-d', strtotime($data['transit_date']));
		$transit_st_time = date('H:i:s', strtotime($data['transit_st_time']));
		$transit_time_end = date('H:i:s', strtotime($data['transit_time_end']));
		$transit_data = array(
			'source'=>$data['source_city'],
			'destination'=>$data['dest_city'],
			'remark'=>$data['remark'],
			'transit_date'=>$transit_date,
			'transit_time_start'=>$transit_st_time,
			'transit_time_end'=>$transit_time_end,
			'stay'=>$data['stay'], 
			'ticket_attachment'=>$ticketAttachment, 
			'bill_attachment'=>$billAttachment, 	
			'updated_date'=>savedate(),                  
		);
		$this->db->set($transit_data);
		$this->db->where('transit_id',$data['transit_id']); 
		$this->db->update('user_transit'); 
		return ($this->db->affected_rows() == 1) ? true : false; 
    }
	
	public function get_user_traveldata(){
		$col='id,name,da_amount';
		$this->db->select($col); 
		$this->db->from('pharma_users'); 
		$this->db->where('id',logged_user_data()); 
		$query= $this->db->get(); 
		if($this->db->affected_rows()){
			return $query->row(); 
		}	
		else{
            return FALSE;
        }
    }

}


?>