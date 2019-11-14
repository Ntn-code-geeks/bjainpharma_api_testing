<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Product_model extends CI_Model {

    
    public function get_product_list(){
      	$arr = "product_id,product_name,product_category,product_potency,product_packsize,product_price,status";
        $this->db->select($arr);
        $this->db->from("pharma_product");
        $query = $this->db->get();
        if($this->db->affected_rows()){
			return $query->result_array();
		}
        else{
            return FALSE;
        }
		
    }  

	public function get_product_active(){
      	$arr = "product_id,product_name,product_category,product_potency,product_packsize,product_price,status";
        $this->db->select($arr);
        $this->db->from("pharma_product");
        $this->db->where("status",1);
       // $this->db->group_by("product_category");
        $query = $this->db->get();
        if($this->db->affected_rows()){
			return $query->result_array();
		}
        else{
            return FALSE;
        }
		
    } 
	
	public function save_product($data){
      	$product_data = array(
			'product_name'=>$data['pro_name'],
			'product_category'=>$data['category_id'],
			'product_potency'=>$data['potency_id'],
			'product_packsize'=>$data['packsize_id'],
			'status'=>$data['status'],
			'product_price'=>$data['price'],
			'crm_user_id'=> logged_user_data(),
			'created_date'=>savedate(),                  
			'updated_date'=>savedate(),                  
		);
		$this->db->insert('pharma_product',$product_data); 
		return ($this->db->affected_rows() == 1) ? true : false; 
		
    }
	
	public function get_product_data($id){
		$col='product_id,product_name,product_category,product_potency,product_packsize,product_price,status';
		$this->db->select($col); 
		$this->db->from('pharma_product'); 
		$this->db->where('product_id',$id); 
		$query= $this->db->get(); 
		if($this->db->affected_rows()){
			return $query->result_array(); 
		}	
		else{
            return FALSE;
        }
    }
	
	public function update_product($data){
		$product_data = array(
			'product_name'=>$data['pro_name'],
			'product_category'=>$data['category_id'],
			'product_potency'=>$data['potency_id'],
			'product_packsize'=>$data['packsize_id'],
			'status'=>$data['status'],
			'product_price'=>$data['price'],
			'crm_user_id'=> logged_user_data(),
			'updated_date'=>savedate(),                      
		);
		$this->db->set($product_data);
		$this->db->where('product_id',$data['product_id']); 
		$this->db->update('pharma_product'); 
		return ($this->db->affected_rows() == 1) ? true : false; 
    }
	
	public function get_potency_list(){
      	$arr = "potency_id ,potency_value,status";
        $this->db->select($arr);
        $this->db->from("pharma_potency");
		$this->db->where('status',1); 
        $query = $this->db->get();
        if($this->db->affected_rows()){
			return $query->result_array();
		}
        else{
            return FALSE;
        }
		
    } 	
	
	public function get_packsize_list(){
      	$arr = "packsize_id ,packsize_value,status";
        $this->db->select($arr);
        $this->db->from("pharma_packsize");
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