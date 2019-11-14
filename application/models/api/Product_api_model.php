<?php


/*
 * Developer: Niraj Sharma
 * Email: niraj@bjain.com
 * 
 * Dated: 28-08-2018
 * 
 */

class Product_api_model extends CI_Model {

    public function get_product_list()
    {
    	$category_list=array();
    	$product_list=array();
    	$catarr = "category_name,category_id";
	$this->db->select($catarr);
	$this->db->from("pharma_category");
	$this->db->where('status',1);
	$query= $this->db->get();

	if($this->db->affected_rows())
        {
            	$category_list[]=$query->result_array();
        }
        else
        {
        	return false;
        }
  	$catindx=0;
  	$proindx=0;
    	foreach($category_list[0] as $cat)
    	{
	 	$arr = "prod.product_id,prod.product_name,prod.product_price,pot.potency_id,pot.potency_value,pck.packsize_id,pck.packsize_value";
	        $this->db->select($arr);
	        $this->db->from("pharma_product prod");
	        $this->db->join("pharma_potency pot","pot.potency_id=prod.product_potency",'left');
	        $this->db->join("pharma_packsize pck","pck.packsize_id=prod.product_packsize",'left');
	        $this->db->where('prod.product_category',$cat['category_id']);
	        $this->db->where('prod.status',1);
	        $query= $this->db->get();
	        if($this->db->affected_rows())
	        {
        	    $product_list[$catindx]['category_id']=$cat['category_id'];
            	    $product_list[$catindx]['category_name']=$cat['category_name'];
	            foreach($query->result_array() as $phdata)
    		    {
    		    	
	            	$product_list[$catindx]['product'][$proindx]=$phdata;
	            	$proindx=$proindx+1;
	            }
	            $proindx=0;
	            $catindx = $catindx+1;
	        }
	       
	        
        }
        if(empty($product_list))
        {
        	return False;
        }
        else
        {
        	return $product_list;
        }
    }
    
    public function get_sample_list()
    {
     	$catarr = "id,sample_name";
	$this->db->select($catarr);
	$this->db->from("meeting_sample_master");
	$query= $this->db->get();
	if($this->db->affected_rows())
        {
            	return $query->result_array();
        }
        else
        {
        	return false;
        }
    }

    public function get_category_list(){
		$category_list=array();
		$catarr = "category_name,category_id";
		$this->db->select($catarr);
		$this->db->from("pharma_category");
		$this->db->where('status',1);
		$query= $this->db->get();
		if($this->db->affected_rows())
		{
			$category_list=$query->result_array();
			return $category_list;
		}
		else
		{
			return false;
		}
	}

	public function get_cat_products($cat_id){
		$arr = "prod.product_id,prod.product_name,prod.product_price,pot.potency_id,pot.potency_value,pck.packsize_id,pck.packsize_value";
		$this->db->select($arr);
		$this->db->from("pharma_product prod");
		$this->db->join("pharma_potency pot","pot.potency_id=prod.product_potency",'left');
		$this->db->join("pharma_packsize pck","pck.packsize_id=prod.product_packsize",'left');
		$this->db->where('prod.product_category',$cat_id);
		$this->db->where('prod.status',1);
		$query= $this->db->get();
		if($this->db->affected_rows())
		{
			$product_list=$query->result_array();
			return $product_list;
		}else{
			return FALSE;
		}
	}


	public function save_product_interaction($data){
//		 pr($data); die;
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
		$orderId = 'PHO/'.$year.'/'.$incementId;

		$order_data = array(
			'interaction_id'=>0,   /*$data['order_id']   which will update whsn interaction saved successfully.*/
			'order_amount '=>$data['tot_amt'],
			'payment_term '=>$data['payment_term'],
			'payment'=>$data['payment'],
			'payment_mode'=>$data['payment_mode'],
			'interaction_person_id'=>$data['person_id'],
			'provider'=>$data['dealer_id'],
			'mail_provider'=>$data['dealer_mail'],
			'crm_user_id'=> $data['crm_user_id'],
			'order_id'=> $orderId,
			'status'=> 1,
			'created_date'=>savedate(),
			'updated_date'=>savedate(),
		);
		$this->db->insert('interaction_order',$order_data);
		$newOrderId=$this->db->insert_id();
		if($this->db->affected_rows() == 1){
			if(count($data['product_details']) > 1){
				foreach ($data['product_details'] as $prod){
					$product_data = array(
						'product_id'=>$prod->pro_id,
						'actual_value'=>$prod->pro_mrp_val,
						'discount'=>isset($prod->pro_dis)?$prod->pro_dis:NULL,
						'quantity'=>$prod->pro_qnty,
						'net_amount'=>$prod->pro_amt,
						'order_id'=>$newOrderId,
						'crm_user_id'=> $data['crm_user_id'],
						'created_date'=>savedate(),
						'updated_date'=>savedate(),
					);
					$this->db->insert('order_details',$product_data);
				}
			}else{
				/*If one product*/
				$product_data = array(
					'product_id'=>$data['product_details'][0]->pro_id,
					'actual_value'=>$data['product_details'][0]->pro_mrp_val,
					'discount'=>isset($data['product_details'][0]->pro_dis)?$data['product_details'][0]->pro_dis:NULL,
					'quantity'=>$data['product_details'][0]->pro_qnty,
					'net_amount'=>$data['product_details'][0]->pro_amt,
					'order_id'=>$newOrderId,
					'crm_user_id'=> $data['crm_user_id'],
					'created_date'=>savedate(),
					'updated_date'=>savedate(),
				);
				$this->db->insert('order_details',$product_data);
			}

		}

		return 1;
	}
}

