<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Order_model extends CI_Model {

    
    public function get_order_list(){
		
      	$interaction_doctor=array();
        $interaction_dealer=array();
        $interaction_pharmacy=array();
		
		/* Pharma Sell */
        $arr = "id,pharma_id as int_id,meeting_sale,crm_user_id,remark,create_date ";
        $this->db->select($arr);
        $this->db->from("pharma_interaction_pharmacy");
        $this->db->where('crm_user_id',logged_user_data());
        $this->db->where('meeting_sale !=','');
		$this->db->where('status ',1);
        $query = $this->db->get();
		//  echo $this->db->last_query(); die;
        if($this->db->affected_rows()){
			$interaction_pharmacy=$query->result_array();
	    }
		
		/* Dealer Sell */
		$arr = "id,d_id as int_id,meeting_sale,crm_user_id,remark,create_date";
        $this->db->select($arr);
        $this->db->from("pharma_interaction_dealer");
        $this->db->where('crm_user_id',logged_user_data());
		$this->db->where('meeting_sale !=','');
		$this->db->where('status ',1);
        $queryDealer = $this->db->get();
		//echo $this->db->last_query(); die;
        if($this->db->affected_rows()){
			$interaction_dealer=$queryDealer->result_array();
        }
		
		/* Doctor Sell */
		$arr = "id,doc_id as int_id,meeting_sale,crm_user_id,remark,create_date";
        $this->db->select($arr);
        $this->db->from("pharma_interaction_doctor");
        $this->db->where('crm_user_id',logged_user_data());
		$this->db->where('meeting_sale !=','');
		$this->db->where('status ',1);
        $queryDoc = $this->db->get();
		//echo $this->db->last_query(); die;
        if($this->db->affected_rows()){
			$interaction_doctor=$queryDoc->result_array();
        }
		
		$result=array_merge($interaction_doctor,$interaction_dealer,$interaction_pharmacy);
		return $result;
		/* pr($result);
		die;  */
		
    }    
	
	public function save_order($data){
		$i=0;
		$year;
		$orderId;
		$incementId=get_increment_id('interaction_order')+1;
		if(date('m')>3)
		{
			$year= date('y').date('y')+1;
			}
		else{
			$year = (date('y')-1).date('y');
		}
		$orderId='PHO/'.$year.'/'.$incementId;
		/* echo $incementId;
		die; */
      	$order_data = array(
			'interaction_id'=>$data['order_id'],
			'order_amount '=>$data['grand_total'],
			'interaction_person_id'=>$data['person_id'],
			'crm_user_id'=> logged_user_data(),
			'order_id'=> $orderId,
			'status'=> 1,
			'created_date'=>savedate(),                  
			'updated_date'=>savedate(),                  
		);
		$this->db->insert('interaction_order',$order_data); 	
		$newOrderId=$this->db->insert_id();
		foreach($data['productid'] as $productid)
		{
			$product_data = array(
				'product_id'=>$productid,
				'actual_value'=>$data['actual'][$i],
				'discount'=>$data['discount'][$i],
				'quantity'=>$data['quantity'][$i],
				'net_amount'=>$data['net'][$i],
				'order_id'=>$newOrderId,
				'crm_user_id'=> logged_user_data(),
				'created_date'=>savedate(),                  
				'updated_date'=>savedate(),                  
			);
			$this->db->insert('order_details',$product_data); 
			$i++;
		}
		
		
		/* if(is_numeric($data['person_id'])){ 
			$dealer_data = array(
				'meeting_sale'=>$data['grand_total'],
				'last_update'=>savedate(),                  
				);
			$this->db->set($dealer_data);
			$this->db->where('d_id',$data['person_id']); 
			$this->db->where('id',$data['order_id']); 
			$this->db->update('pharma_interaction_dealer'); 
			 
		}
		else{
			if(substr($data['person_id'],0,3)=='doc')
			{
				$dealer_data = array(
				'meeting_sale'=>$data['grand_total'],
				'last_update'=>savedate(),
				);
				$this->db->set($dealer_data);
				$this->db->where('doc_id',$data['person_id']); 
				$this->db->where('id',$data['order_id']); 
				$this->db->update('pharma_interaction_doctor');
			}
			else
			{
				$dealer_data = array(
				'meeting_sale'=>$data['grand_total'],
				'last_update'=>savedate(),   
				);
				$this->db->set($dealer_data);
				$this->db->where('pharma_id',$data['person_id']); 
				$this->db->where('id',$data['order_id']); 
				$this->db->update('pharma_interaction_pharmacy');
			}
		} */
		return 1;
		
    }
	


    public function save_product_interaction($data){
    	$i=0;
		$year;
		$orderId;
		$incementId=get_increment_id('interaction_order')+1;
		if(date('m')>3)
		{
			$year= date('y').date('y')+1;
			}
		else{
			$year = (date('y')-1).date('y');
		}
		$orderId='PHO/'.$year.'/'.$incementId;
		/* echo $incementId;
		die; */
      	$order_data = array(
			'interaction_id'=>$data['order_id'],
			'order_amount '=>$data['tot_amt'],
			'payment_term '=>$data['payment'],
			'interaction_person_id'=>$data['person_id'],
			'crm_user_id'=> logged_user_data(),
			'order_id'=> $orderId,
			'status'=> 1,
			'created_date'=>savedate(),                  
			'updated_date'=>savedate(),                  
		);
		$this->db->insert('interaction_order',$order_data); 	
		$newOrderId=$this->db->insert_id();
		//pr($post_data);
		$remove = array(0);
    	$pro_amt =array() ;  
    	$pro_mrp_val=array();
    	$pro_dis=array();
    	$pro_qnty=array();
    	foreach(array_diff($data['pro_amt'], $remove) as $d)
    	{
    		$pro_amt[]=$d;
    	}
		
		foreach(array_filter($data['pro_mrp_val']) as $d)
    	{
    		$pro_mrp_val[]=$d;
    	}
    	foreach(array_filter($data['pro_dis']) as $d)
    	{
    		$pro_dis[]=$d;
    	}
    	foreach(array_filter($data['pro_qnty']) as $d)
    	{
    		$pro_qnty[]=$d;
    	}
		foreach($data['product_name'] as $key=>$val)
		{
			if($val!='')
			{
				$product_data = array(
					'product_id'=>$val,
					'actual_value'=>$pro_mrp_val[$i],
					'discount'=>isset($pro_dis[$i])?$pro_dis[$i]:NULL,
					'quantity'=>$pro_qnty[$i],
					'net_amount'=>$pro_amt[$i],
					'order_id'=>$newOrderId,
					'crm_user_id'=> logged_user_data(),
					'created_date'=>savedate(),                  
					'updated_date'=>savedate(),                  
				);
				$this->db->insert('order_details',$product_data); 
			}
			
			$i++;
		}
		return 1;
		
    }

	public function edit_save_order($data){
		$i=0;
      	$order_data = array(
			'order_amount '=>$data['grand_total'],
			'updated_date'=>savedate(),                  
		);
		$this->db->set($order_data);
		$this->db->where('id',$data['interaction_order_id']); 
		$this->db->update('interaction_order'); 
		
		$this->db->where('order_id', $data['interaction_order_id']);
		$this->db->delete('order_details');
		$newOrderId=$data['interaction_order_id'];
		foreach($data['productid'] as $productid)
		{
			$product_data = array(
				'product_id'=>$productid,
				'actual_value'=>$data['actual'][$i],
				'discount'=>$data['discount'][$i],
				'quantity'=>$data['quantity'][$i],
				'net_amount'=>$data['net'][$i],
				'order_id'=>$newOrderId,
				'crm_user_id'=> logged_user_data(),
				'created_date'=>savedate(),                  
				'updated_date'=>savedate(),                  
			);
			$this->db->insert('order_details',$product_data); 
			$i++;
		}
		if(is_numeric($data['person_id'])){ 
			$dealer_data = array(
				'meeting_sale'=>$data['grand_total'],
				'last_update'=>savedate(),                  
				);
			$this->db->set($dealer_data);
			$this->db->where('d_id',$data['person_id']); 
			$this->db->where('id',$data['order_id']); 
			$this->db->update('pharma_interaction_dealer'); 
			 
		}
		else{
			if(substr($data['person_id'],0,3)=='doc')
			{
				$dealer_data = array(
				'meeting_sale'=>$data['grand_total'],
				'last_update'=>savedate(),
				);
				$this->db->set($dealer_data);
				$this->db->where('doc_id',$data['person_id']); 
				$this->db->where('id',$data['order_id']); 
				$this->db->update('pharma_interaction_doctor');
			}
			else
			{
				$dealer_data = array(
				'meeting_sale'=>$data['grand_total'],
				'last_update'=>savedate(),   
				);
				$this->db->set($dealer_data);
				$this->db->where('pharma_id',$data['person_id']); 
				$this->db->where('id',$data['order_id']); 
				$this->db->update('pharma_interaction_pharmacy');
			}
		}
		return 1;
		
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
	
	public function get_single_product_details($proId){
      	$arr = "product.product_id,product.product_name,product.product_category,product.product_potency,product.product_packsize,product.product_price,product.status,packsize.packsize_value";
        $this->db->select($arr);
        $this->db->from("pharma_product as product");       
		$this->db->join("pharma_packsize as packsize",'product.product_packsize=packsize.packsize_id');
		$this->db->where('product.product_id',$proId);		
        $query = $this->db->get();
        if($this->db->affected_rows()){
			return $query->result_array();
		}
        else{
            return FALSE;
        }
		
    }

	public function get_cat_product($data){

      	$arr = "product.product_id,product.product_name,product.product_category,product.product_potency,product.product_packsize,product.product_price,product.status,packsize.packsize_value";
        $this->db->select($arr);
        $this->db->from("pharma_product as product");       
		$this->db->join("pharma_packsize as packsize",'product.product_packsize=packsize.packsize_id');
		$this->db->where('product.product_category',$data['catid']);		
		$this->db->where('product.product_packsize',$data['packsize']);
		$this->db->order_by('product.product_name', "asc");
		if(isset($data['potency']))
		{
			$this->db->where('product.product_potency',$data['potency']);
		}		
				
		$this->db->where('product.status',1);
        $query = $this->db->get();
        /*echo $this->db->last_query();
        die;*/
        if($this->db->affected_rows()){
			return json_encode($query->result_array());
		}
        else{
            return FALSE;
        }
		
    }

    public function get_cat_packsize($catId){
      	$arr = "product.product_packsize,packsize.packsize_value";
        $this->db->select($arr);
        $this->db->from("pharma_product as product");       
		$this->db->join("pharma_packsize as packsize",'product.product_packsize=packsize.packsize_id');
		$this->db->where('product.product_category',$catId);		
		$this->db->where('product.status',1);
		$this->db->distinct();
        $query = $this->db->get();
        if($this->db->affected_rows()){
			return json_encode($query->result_array());
		}
        else{
            return FALSE;
        }
		
    }

    public function get_cat_potency($catId){
      	$arr = "product.product_potency,potency.potency_value";
        $this->db->select($arr);
        $this->db->from("pharma_product as product");       
		$this->db->join("pharma_potency as potency",'product.product_potency=potency.potency_id');
		$this->db->where('product.product_category',$catId);		
		$this->db->where('product.status',1);
		$this->db->distinct();
        $query = $this->db->get();
        if($this->db->affected_rows()){
			return json_encode($query->result_array());
		}
        else{
            return FALSE;
        }
		
    }
	
	/* Check weather order available or not */
	public function check_order($interaction_id,$interaction_person_id){
      	$arr = "id";
        $this->db->select($arr);
        $this->db->from("interaction_order");
        $this->db->where("interaction_person_id",$interaction_person_id);
        $this->db->where('interaction_id',$interaction_id);
		//$this->db->where('crm_user_id',logged_user_data());
        $query = $this->db->get();
        /*echo $this->db->last_query();
        die;*/
        if($this->db->affected_rows()){
			return $query->row()->id;
		}
        else{
            return FALSE;
        }
    }
	
	/* Get Interaction Order */
	public function get_interaction_order($interaction_order_id){
		$catid=array();
      	$arr = "id,product_id,actual_value";
        $this->db->select($arr);
        $this->db->from("order_details");
        $this->db->where("order_id",$interaction_order_id);
        //$this->db->where("crm_user_id",logged_user_data());
        $query = $this->db->get();
        if($this->db->affected_rows()){
			return $result=$query->result_array();
		}
        else{
            return FALSE;
        }
    }
	
	function get_product_category($id){
		$arr = "product_category";
        $this->db->select($arr);
        $this->db->from("pharma_product");
        $this->db->where('product_id',$id);
        $query = $this->db->get();
        if($this->db->affected_rows()){
			return $query->row()->product_category;
		}
        else{
            return ' ';
        }
	}
	
	public function get_order_category($data){
		$catid=array();
		
      	foreach($data as $order)
		{
			$cateId=$this->get_product_category($order['product_id']);
			if(!in_array($cateId, $catid))
			{
				$catid[]=$cateId;
			}
			
		}
		return $catid;		
    }
	
		
	public function get_order_product_id($interaction_order_id){
		$proid=array();
      	$arr = "id,product_id,actual_value";
        $this->db->select($arr);
        $this->db->from("order_details");
        $this->db->where("order_id",$interaction_order_id);
      //  $this->db->where("crm_user_id",logged_user_data());
        $query = $this->db->get();
        if($this->db->affected_rows()){
			$result=$query->result_array();
			foreach($result as $order)
			{
				$proid[]=$order['product_id'];
				
			}
			return $proid;
			
		}
        else{
            return FALSE;
        }
    }
	
    /* Complete Order */
	public function complete_order($oId,$pId){
		$order_data = array(
			'status'=>0,
			'updated_date'=>savedate(),                  
		);
		$this->db->set($order_data);
		$this->db->where('interaction_id',$oId); 
		$this->db->where('interaction_person_id',$pId); 
		$this->db->where('crm_user_id',logged_user_data()); 
		$this->db->update('interaction_order'); 
		return ($this->db->affected_rows() == 1) ? true : false;
    }
	
	   /* cancel Order */
	public function cancel_order($oId,$pId,$amount){
		$arr = "interaction_id";
        $this->db->select($arr);
        $this->db->from("interaction_order");
		$this->db->where('interaction_id',$oId); 
		$this->db->where('interaction_person_id',$pId); 
		$this->db->where('crm_user_id',logged_user_data()); 
        $query = $this->db->get();
        if($this->db->affected_rows()){
			$order_data = array(
			'cancel_status'=>0,
			'updated_date'=>savedate(),                  
			);
			$this->db->set($order_data);
			$this->db->where('interaction_id',$oId); 
			$this->db->where('interaction_person_id',$pId); 
			$this->db->where('crm_user_id',logged_user_data()); 
			$this->db->update('interaction_order'); 
			return ($this->db->affected_rows() == 1) ? true : false;
		}
		else{
		
			$i=0;
			$year;
			$orderId;
			$incementId=get_increment_id('interaction_order')+1;
			if(date('m')>3)
			{
				$year= date('y').date('y')+1;
				}
			else{
				$year = (date('y')-1).date('y');
			}
			$orderId='PHO/'.$year.'/'.$incementId;
			/* echo $incementId;
			die; */
			$order_data = array(
				'interaction_id'=>$oId,
				'order_amount '=>$amount,
				'interaction_person_id'=>$pId,
				'crm_user_id'=> logged_user_data(),
				'order_id'=> $orderId,
				'cancel_status'=> 0,
				'created_date'=>savedate(),                  
				'updated_date'=>savedate(),                  
			);
			$this->db->insert('interaction_order',$order_data);
			return ($this->db->affected_rows() == 1) ? true : false;
		}
    }
	
	/* Get Interaction Order by interaction id */
	public function get_order($interaction_id,$interaction_person_id){
		$catid=array();
      	$arr = "id,order_id,payment_term,order_amount";
        $this->db->select($arr);
        $this->db->from("interaction_order");
        $this->db->where("interaction_person_id",$interaction_person_id);
        $this->db->where('interaction_id',$interaction_id);
		//$this->db->where('crm_user_id',logged_user_data());
        $query = $this->db->get();
        if($this->db->affected_rows())
        {
			return $result=$query->result_array();
		}
        else
        {
            return FALSE;
        }
    }
	
	public function get_interaction_order_details($interaction_order_id){
		$catid=array();
      	$arr = "id,product_id,actual_value,discount,net_amount,quantity";
        $this->db->select($arr);
        $this->db->from("order_details");
        $this->db->where("order_id",$interaction_order_id);
       // $this->db->where("crm_user_id",logged_user_data());
        $query = $this->db->get();
        if($this->db->affected_rows()){
			return $result=$query->result_array();
		}
        else{
            return FALSE;
        }
    }
}


?>