<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Category_model extends CI_Model {

    
    public function get_category(){
      	$arr = "category_id ,category_name,parent_category_id,remark,status";
        $this->db->select($arr);
        $this->db->from("pharma_category");
        $query = $this->db->get();
        if($this->db->affected_rows()){
			return $query->result_array();
		}
        else{
            return FALSE;
        }
		
    }    
	
	public function save_category($data){
      	$category_data = array(
			'parent_category_id'=>$data['parent_category'],
			'category_name'=>$data['cat_name'],
			'remark'=>$data['remark'],
			'status'=>$data['status'],
			'crm_user_id'=> logged_user_data(),
			'created_date'=>savedate(),                  
			'updated_date'=>savedate(),                  
		);
		$this->db->insert('pharma_category',$category_data); 
		return ($this->db->affected_rows() == 1) ? true : false; 
		
    }
	
	public function get_category_data($id){
		$col='category_id ,category_name,parent_category_id,remark,status';
		$this->db->select($col); 
		$this->db->from('pharma_category'); 
		$this->db->where('category_id',$id); 
		$query= $this->db->get(); 
		if($this->db->affected_rows()){
			return $query->result_array(); 
		}	
		else{
            return FALSE;
        }
    }
	
	public function update_category($data){
		$category_data = array(
			'parent_category_id'=>$data['parent_category'],
			'category_name'=>$data['cat_name'],
			'remark'=>$data['remark'],
			'status'=>$data['status'],
			'crm_user_id'=> logged_user_data(),
			'updated_date'=>savedate(),                  
		);
		$this->db->set($category_data);
		$this->db->where('category_id',$data['category_id']); 
		$this->db->update('pharma_category'); 
		return ($this->db->affected_rows() == 1) ? true : false; 
    }
	
	public function get_active_category(){
      	$arr = "category_id ,category_name,parent_category_id,remark,status";
        $this->db->select($arr);
        $this->db->from("pharma_category");
		$this->db->where('status',1); 
        $query = $this->db->get();
        if($this->db->affected_rows()){
			return $query->result_array();
		}
        else{
            return FALSE;
        }
		
    } 
    
}


?>