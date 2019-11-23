<?php


/*
 * Developer: Niraj Sharma
 * Email: niraj@bjain.com
 * 
 * Dated: 28-08-2018
 * 
 */

class Interaction_api_model extends CI_Model {
   
    public function save_doctor_interaction($data)
    {
    //pr($data);
    $team_status=1;
    if(!empty($data->sample))
	{  // for multipile sample data
	  if(!(!isset ($data->totalSale) || empty($data->totalSale)))
	  {
	    $interaction_info = array(
	    'doc_id'=>$data->drId,
	    'dealer_id'=>isset($data->dealerId)?$data->dealerId :NULL,
	    'meeting_sale'=>$data->totalSale,
	    'meet_or_not_meet'=>$data->interactionType,
	    'remark'=>$data->remarks,
	    'follow_up_action'=>$data->followUpAction!='' ? date('Y-m-d', strtotime($data->followUpAction)): NULL,
	    'status'=>1,
	    'crm_user_id'=> $data->user_id,
	    'create_date'=> $data->dateOfInteraction!='' ? date('Y-m-d', strtotime($data->dateOfInteraction)):savedate(),
	    'last_update' => savedate(),    
	    );
	  }
	  else
	  {
	    $interaction_info = array(
	        'doc_id'=>$data->drId,
	        'meet_or_not_meet'=>$data->interactionType,
	        'remark'=>$data->remarks,
	        'follow_up_action'=>$data->followUpAction!='' ? date('Y-m-d', strtotime($data->followUpAction)): NULL,
	        'status'=>1,
	        'crm_user_id'=>  $data->user_id,
	        'create_date'=> $data->dateOfInteraction!='' ? date('Y-m-d', strtotime($data->dateOfInteraction)):savedate(),
	        'last_update' => savedate(),    
	      ); 
	  }
	  $insert = $this->db->insert('pharma_interaction_doctor',$interaction_info);

	  $pi_doc = $this->db->insert_id();
	  $replica_data = array(
	  'interaction_with'=>$data->drId,
	  'crm_user_id'=> $data->user_id,
	  ); 
	  $insert = $this->db->insert('intearction_replica',$replica_data);
	  if(isset($pi_doc) && !empty($data->totalSale))
	  {
    
	    /*Order info */
		$i=0;
		$year;
		$orderId;
		$incementId=get_increment_id('interaction_order')+1;
		if(date('m')>3)
		{
			$year= date('y').date('y')+1;
		}
		else
		{
			$year = (date('y')-1).date('y');
		}
		$orderId='PHO/'.$year.'/'.$incementId;
		/* echo $incementId;
		die; */
		$order_data = array(
			'interaction_id'=>$pi_doc,
			'order_amount '=>$data->totalSale,
			'payment_term '=>$data->paymentTerms,
			'interaction_person_id'=>$data->drId,
			'crm_user_id'=>  $data->user_id,
			'order_id'=> $orderId,
			'status'=> 1,
			'interaction_with_id'=>isset($data->dealerId)?$data->dealerId:NULL,
			'created_date'=>savedate(),                  
			'updated_date'=>savedate(),                  
		);
		$this->db->insert('interaction_order',$order_data); 	
		$newOrderId=$this->db->insert_id();
	    	foreach($data->productDataList as $key=>$val)
		{
	
			if(isset($val->potencyData))
			{
				$product_data = array(
					'product_id'=>$val->potencyData[0]->packSizeData[0]->productData[0]->id,
					'actual_value'=>$val->potencyData[0]->packSizeData[0]->productData[0]->product_price,
					'discount'=>$val->discount,
					'quantity'=>$val->productQuantity,
					'net_amount'=>$val->totalAmount,
					'order_id'=>$newOrderId,
					'crm_user_id'=>  $data->user_id,
					'created_date'=>savedate(),                  
					'updated_date'=>savedate(),                  
					);
					
			}
			else
			{
				//pr($val->packSizeData);
				$product_data = array(
					'product_id'=>$val->packSizeData[0]->productData[0]->id,
					'actual_value'=>$val->packSizeData[0]->productData[0]->product_price,
					'discount'=>$val->discount,
					'quantity'=>$val->productQuantity,
					'net_amount'=>$val->totalAmount,
					'order_id'=>$newOrderId,
					'crm_user_id'=>  $data->user_id,
					'created_date'=>savedate(),                  
					'updated_date'=>savedate(),                  
				);
			}
			$this->db->insert('order_details',$product_data); 
		}
	    /*End order info */
	  }
	  if(isset($pi_doc))
	  {
	    foreach($data->sample as $kms=>$val_ms)
	    {
	      $sample_doc_interraction_rel = array(
	        'pidoc_id'=>$pi_doc,
	        'sample_id'=>$val_ms->id,
	        'crm_user_id'=> $data->user_id,
	        'last_update'=> savedate(),
	        );
	      $status = $this->db->insert('doctor_interaction_sample_relation',$sample_doc_interraction_rel);
	    } 
	  }
	
	  if(isset($pi_doc) && isset($data->jointWorking))
	  {
	    foreach($data->jointWorking as $k_tm=>$val_tm)
	    {
	      $team_doc_interraction_rel = array(
	      'pidoc_id'=>$pi_doc,
	      'team_id'=>$val_tm->id,
	      'crm_user_id'=> $data->user_id,
	      'last_update'=> savedate(),
	      'doc_id'=>$data->drId,
	      'interaction_date'=>  date('Y-m-d', strtotime($data->dateOfInteraction)),
	      );
	      $team_status = $this->db->insert('doctor_interaction_with_team',$team_doc_interraction_rel);
	    } 
	  }
	
	  if(!empty($data->sample) && isset($data->jointWorking))
	  { 
	    if ($insert == TRUE && $status == 1 && $team_status==1)
	    {
	      //echo $insert."<br>"; echo "1---".$status."<br>"; die;
	      return true;                           
	    }
	    else
	    {
	    // echo $insert."<br>"; echo "----2---- ".$status."<br>"; die;
	      return false;
	    } 
	  }
	  elseif(!empty($data->sample) && !isset($data->jointWorking))
	  {
	    if ($insert== TRUE && $status == 1)
	    {
	      //echo $insert."<br>"; echo "3--".$status."<br>"; die; 
	      return true;                           
	    }
	    else
	    {
	      return false;
	    } 
	  }
	}
	else
	{  
	  if(!empty($data->totalSale))
	  {       
	    $interaction_info = array(
	    'doc_id'=>$data->drId,
	    'dealer_id'=>isset($data->dealerId)?$data->dealerId:NULL,
	    'meeting_sale'=>$data->totalSale,
	    'telephonic' => isset($data->orderBy)? $data->orderBy:NULL,
	    'meet_or_not_meet'=>$data->interactionType,
	    'remark'=>$data->remarks,
	    'follow_up_action'=>$data->followUpAction!='' ? date('Y-m-d', strtotime($data->followUpAction)):NULL,
	    'status'=>1,
	    'crm_user_id'=> $data->user_id,
	    'create_date'=> $data->dateOfInteraction!='' ? date('Y-m-d', strtotime($data->dateOfInteraction)):savedate(),
	    'last_update' => savedate(),
	    );
	  }
	  else
	  {
	    $interaction_info = array(
	    'doc_id'=>$data->drId,
	    'telephonic' => isset($data->orderBy)? $data->orderBy:NULL,
	    'meet_or_not_meet'=>$data->interactionType,
	    'remark'=>$data->remarks,
	    'follow_up_action'=>$data->followUpAction!='' ? date('Y-m-d', strtotime($data->followUpAction)):NULL,
	    'status'=>1,
	    'crm_user_id'=> $data->user_id,
	    'create_date'=> $data->dateOfInteraction!='' ? date('Y-m-d', strtotime($data->dateOfInteraction)):savedate(),
	    'last_update' => savedate(),
	    );
	  }
	  $insert =  $this->db->insert('pharma_interaction_doctor',$interaction_info);
	  //echo $this->db->last_query(); die;
	  $pi_doc = $this->db->insert_id();   
	  $replica_data = array(
	  'interaction_with'=>$data->drId,
	  'crm_user_id'=> $data->user_id,
	  ); 
	  $insert = $this->db->insert('intearction_replica',$replica_data);
	  if(isset($pi_doc) && !empty($data->totalSale))
	  {
	    /*Order info */
    
		$i=0;
		$year;
		$orderId;
		$incementId=get_increment_id('interaction_order')+1;
		if(date('m')>3)
		{
			$year= date('y').date('y')+1;
		}
		else
		{
			$year = (date('y')-1).date('y');
		}
		$orderId='PHO/'.$year.'/'.$incementId;
		/* echo $incementId;
		die; */
		$order_data = array(
			'interaction_id'=>$pi_doc,
			'order_amount '=>$data->totalSale,
			'payment_term '=>$data->paymentTerms,
			'interaction_person_id'=>$data->drId,
			'crm_user_id'=>  $data->user_id,
			'order_id'=> $orderId,
			'status'=> 1,
			'interaction_with_id'=>isset($data->dealerId)?$data->dealerId:NULL,
			'created_date'=>savedate(),                  
			'updated_date'=>savedate(),                  
		);
		$this->db->insert('interaction_order',$order_data); 	
		$newOrderId=$this->db->insert_id();
	    	foreach($data->productDataList as $key=>$val)
		{
			if(isset($val->potencyData))
			{
				$product_data = array(
					'product_id'=>$val->potencyData[0]->packSizeData[0]->productData[0]->id,
					'actual_value'=>$val->potencyData[0]->packSizeData[0]->productData[0]->product_price,
					'discount'=>$val->discount,
					'quantity'=>$val->productQuantity,
					'net_amount'=>$val->totalAmount,
					'order_id'=>$newOrderId,
					'crm_user_id'=>  $data->user_id,
					'created_date'=>savedate(),                  
					'updated_date'=>savedate(),                  
					);
					
			}
			else
			{
				//pr($val->packSizeData);
				$product_data = array(
					'product_id'=>$val->packSizeData[0]->productData[0]->id,
					'actual_value'=>$val->packSizeData[0]->productData[0]->product_price,
					'discount'=>$val->discount,
					'quantity'=>$val->productQuantity,
					'net_amount'=>$val->totalAmount,
					'order_id'=>$newOrderId,
					'crm_user_id'=>  $data->user_id,
					'created_date'=>savedate(),                  
					'updated_date'=>savedate(),                  
					);
			}
			$this->db->insert('order_details',$product_data); 
		}
	    
	    
	    /*End order info */
	  }
	  if(isset($pi_doc) && isset($data->jointWorking ))
	  {
	    foreach($data->jointWorking as $k_tm=>$val_tm)
	    {
	      $team_doc_interraction_rel = array(
	      'pidoc_id'=>$pi_doc,
	      'team_id'=>$val_tm->id,
	      'crm_user_id'=>  $data->user_id,
	      'last_update'=> savedate(),
	      'doc_id'=>$data->drId,
	      'interaction_date'=>  date('Y-m-d', strtotime($data->dateOfInteraction)),
	      );
	      $team_status = $this->db->insert('doctor_interaction_with_team',$team_doc_interraction_rel);
	    } 
	  }
	  if(isset($data->jointWorking ))
	  {      
	    if ($insert == TRUE && $team_status==1)
	    {
	    	//echo $insert."<br>"; echo "5----".$status."<br>"; die; 
	      return true;                           
	    }
	    else
	    {
	      //echo $insert."<br>"; echo "6----".$status."<br>"; die; 
	      return false;
	    } 
	  }
	  else
	  {
	    if ($insert == TRUE)
	    {
	    	//echo $insert."<br>"; echo "7----".$status."<br>"; die; 	
	      	return true;                           
	    }
	    else
	    {
	    	//echo $insert."<br>"; echo "8----".$status."<br>"; die; 
	      	return false;
	    } 
	  }
	}
    }

    public function save_pharma_interaction($data)
    {
	    //pr($data);
	    $team_status=1;
	    if(!empty($data->sample))
		{  // for multipile sample data
		  if(!(!isset ($data->totalSale) || empty($data->totalSale)))
		  {
		    $interaction_info = array(
		    'pharma_id'=>$data->drId,
		    'dealer_id'=>isset($data->dealerId)?$data->dealerId :NULL,
		    'meeting_sale'=>$data->totalSale,
		    'meet_or_not_meet'=>$data->interactionType,
		    'remark'=>$data->remarks,
		    'follow_up_action'=>$data->followUpAction!='' ? date('Y-m-d', strtotime($data->followUpAction)): NULL,
		    'status'=>1,
		    'crm_user_id'=> $data->user_id,
		    'create_date'=> $data->dateOfInteraction!='' ? date('Y-m-d', strtotime($data->dateOfInteraction)):savedate(),
		    'last_update' => savedate(),    
		    );
		  }
		  else
		  {
		    $interaction_info = array(
		        'pharma_id'=>$data->drId,
		        'meet_or_not_meet'=>$data->interactionType,
		        'remark'=>$data->remarks,
		        'follow_up_action'=>$data->followUpAction!='' ? date('Y-m-d', strtotime($data->followUpAction)): NULL,
		        'status'=>1,
		        'crm_user_id'=>  $data->user_id,
		        'create_date'=> $data->dateOfInteraction!='' ? date('Y-m-d', strtotime($data->dateOfInteraction)):savedate(),
		        'last_update' => savedate(),    
		    ); 
		  }
		  $insert = $this->db->insert('pharma_interaction_pharmacy',$interaction_info);
		  $pi_doc = $this->db->insert_id();
		  $replica_data = array(
		  'interaction_with'=>$data->drId,
		  'crm_user_id'=> $data->user_id,
		  ); 
		  $insert = $this->db->insert('intearction_replica',$replica_data);
		  if(isset($pi_doc) && !empty($data->totalSale))
		  {
	    
		    	/*Order info */
			$i=0;
			$year;
			$orderId;
			$incementId=get_increment_id('interaction_order')+1;
			if(date('m')>3)
			{
				$year= date('y').date('y')+1;
			}
			else
			{
				$year = (date('y')-1).date('y');
			}
			$orderId='PHO/'.$year.'/'.$incementId;
			/* echo $incementId;
			die; */
			$order_data = array(
				'interaction_id'=>$pi_doc,
				'order_amount '=>$data->totalSale,
				'payment_term '=>$data->paymentTerms,
				'interaction_person_id'=>$data->drId,
				'crm_user_id'=>  $data->user_id,
				'order_id'=> $orderId,
				'status'=> 1,
				'interaction_with_id'=>isset($data->dealerId)?$data->dealerId:NULL,
				'created_date'=>savedate(),                  
				'updated_date'=>savedate(),                  
			);
			$this->db->insert('interaction_order',$order_data); 	
			$newOrderId=$this->db->insert_id();
		    	foreach($data->productDataList as $key=>$val)
			{
		
				if(isset($val->potencyData))
				{
					$product_data = array(
						'product_id'=>$val->potencyData[0]->packSizeData[0]->productData[0]->id,
						'actual_value'=>$val->potencyData[0]->packSizeData[0]->productData[0]->product_price,
						'discount'=>$val->discount,
						'quantity'=>$val->productQuantity,
						'net_amount'=>$val->totalAmount,
						'order_id'=>$newOrderId,
						'crm_user_id'=>  $data->user_id,
						'created_date'=>savedate(),                  
						'updated_date'=>savedate(),                  
						);
						
				}
				else
				{
					//pr($val->packSizeData);
					$product_data = array(
						'product_id'=>$val->packSizeData[0]->productData[0]->id,
						'actual_value'=>$val->packSizeData[0]->productData[0]->product_price,
						'discount'=>$val->discount,
						'quantity'=>$val->productQuantity,
						'net_amount'=>$val->totalAmount,
						'order_id'=>$newOrderId,
						'crm_user_id'=>  $data->user_id,
						'created_date'=>savedate(),                  
						'updated_date'=>savedate(),                  
					);
				}
				$this->db->insert('order_details',$product_data); 
			}
		    /*End order info */
		  }
		  if(isset($pi_doc))
		  {
		    foreach($data->sample as $kms=>$val_ms)
		    {
		      $sample_doc_interraction_rel = array(
		        'pipharma_id'=>$pi_doc,
		        'sample_id'=>$val_ms->id,
		        'crm_user_id'=> $data->user_id,
		        'last_update'=> savedate(),
		        );
		      $status = $this->db->insert('pharmacy_interaction_sample_relation',$sample_doc_interraction_rel);
		    }
		  }
		
		  if(isset($pi_doc) && isset($data->jointWorking))
		  {
		    foreach($data->jointWorking as $k_tm=>$val_tm)
		    {
		      $team_doc_interraction_rel = array(
		      'pipharma_id'=>$pi_doc,
		      'team_id'=>$val_tm->id,
		      'crm_user_id'=> $data->user_id,
		      'last_update'=> savedate(),
		      'pharma_id'=>$data->drId,
		      'interaction_date'=>  date('Y-m-d', strtotime($data->dateOfInteraction)),
		      );
		      $team_status = $this->db->insert('pharmacy_interaction_with_team',$team_doc_interraction_rel);
		    }
		  }
		
		  if(!empty($data->sample) && isset($data->jointWorking))
		  { 
		    if ($insert == TRUE && $status == 1 && $team_status==1)
		    {
		      //echo $insert."<br>"; echo "1---".$status."<br>"; die;
		      return true;                           
		    }
		    else
		    {
		    // echo $insert."<br>"; echo "----2---- ".$status."<br>"; die;
		      return false;
		    } 
		  }
		  elseif(!empty($data->sample) && !isset($data->jointWorking))
		  {
		    if ($insert== TRUE && $status == 1)
		    {
		      //echo $insert."<br>"; echo "3--".$status."<br>"; die; 
		      return true;                           
		    }
		    else
		    {
		      return false;
		    } 
		  }
		}
		else
		{  
		  if(!empty($data->totalSale))
		  {       
		    $interaction_info = array(
		    'pharma_id'=>$data->drId,
		    'dealer_id'=>isset($data->dealerId)?$data->dealerId:NULL,
		    'meeting_sale'=>$data->totalSale,
		    'telephonic' => isset($data->orderBy)? $data->orderBy:NULL,
		    'meet_or_not_meet'=>$data->interactionType,
		    'remark'=>$data->remarks,
		    'follow_up_action'=>$data->followUpAction!='' ? date('Y-m-d', strtotime($data->followUpAction)):NULL,
		    'status'=>1,
		    'crm_user_id'=> $data->user_id,
		    'create_date'=> $data->dateOfInteraction!='' ? date('Y-m-d', strtotime($data->dateOfInteraction)):savedate(),
		    'last_update' => savedate(),
		    );
		  }
		  else
		  {
		    $interaction_info = array(
		    'pharma_id'=>$data->drId,
		    'telephonic' => isset($data->orderBy)? $data->orderBy:NULL,
		    'meet_or_not_meet'=>$data->interactionType,
		    'remark'=>$data->remarks,
		    'follow_up_action'=>$data->followUpAction!='' ? date('Y-m-d', strtotime($data->followUpAction)):NULL,
		    'status'=>1,
		    'crm_user_id'=> $data->user_id,
		    'create_date'=> $data->dateOfInteraction!='' ? date('Y-m-d', strtotime($data->dateOfInteraction)):savedate(),
		    'last_update' => savedate(),
		    );
		  }
		  $insert =  $this->db->insert('pharma_interaction_pharmacy',$interaction_info);
		  //echo $this->db->last_query(); die;
		  $pi_doc = $this->db->insert_id();   
		  $replica_data = array(
		  'interaction_with'=>$data->drId,
		  'crm_user_id'=> $data->user_id,
		  ); 
		  $insert = $this->db->insert('intearction_replica',$replica_data);
		  if(isset($pi_doc) && !empty($data->totalSale))
		  {
		    /*Order info */
	    
			$i=0;
			$year;
			$orderId;
			$incementId=get_increment_id('interaction_order')+1;
			if(date('m')>3)
			{
				$year= date('y').date('y')+1;
			}
			else
			{
				$year = (date('y')-1).date('y');
			}
			$orderId='PHO/'.$year.'/'.$incementId;
			/* echo $incementId;
			die; */
			$order_data = array(
				'interaction_id'=>$pi_doc,
				'order_amount '=>$data->totalSale,
				'payment_term '=>$data->paymentTerms,
				'interaction_person_id'=>$data->drId,
				'crm_user_id'=>  $data->user_id,
				'order_id'=> $orderId,
				'status'=> 1,
				'interaction_with_id'=>isset($data->dealerId)?$data->dealerId:NULL,
				'created_date'=>savedate(),                  
				'updated_date'=>savedate(),                  
			);
			$this->db->insert('interaction_order',$order_data); 	
			$newOrderId=$this->db->insert_id();
		    	foreach($data->productDataList as $key=>$val)
			{
				if(isset($val->potencyData))
				{
					$product_data = array(
						'product_id'=>$val->potencyData[0]->packSizeData[0]->productData[0]->id,
						'actual_value'=>$val->potencyData[0]->packSizeData[0]->productData[0]->product_price,
						'discount'=>$val->discount,
						'quantity'=>$val->productQuantity,
						'net_amount'=>$val->totalAmount,
						'order_id'=>$newOrderId,
						'crm_user_id'=>  $data->user_id,
						'created_date'=>savedate(),                  
						'updated_date'=>savedate(),                  
						);
						
				}
				else
				{
					//pr($val->packSizeData);
					$product_data = array(
						'product_id'=>$val->packSizeData[0]->productData[0]->id,
						'actual_value'=>$val->packSizeData[0]->productData[0]->product_price,
						'discount'=>$val->discount,
						'quantity'=>$val->productQuantity,
						'net_amount'=>$val->totalAmount,
						'order_id'=>$newOrderId,
						'crm_user_id'=>  $data->user_id,
						'created_date'=>savedate(),                  
						'updated_date'=>savedate(),                  
						);
				}
				$this->db->insert('order_details',$product_data); 
			}
		    
		    
		    /*End order info */
		  }
		  if(isset($pi_doc) && isset($data->jointWorking ))
		  {
		    foreach($data->jointWorking as $k_tm=>$val_tm)
		    {
		      $team_doc_interraction_rel = array(
		      'pipharma_id'=>$pi_doc,
		      'team_id'=>$val_tm->id,
		      'crm_user_id'=>  $data->user_id,
		      'last_update'=> savedate(),
		      'pharma_id'=>$data->drId,
		      'interaction_date'=>  date('Y-m-d', strtotime($data->dateOfInteraction)),
		      );
		      $team_status = $this->db->insert('pharmacy_interaction_with_team',$team_doc_interraction_rel);
		    }
		  }
		  if(isset($data->jointWorking ))
		  {      
		    if ($insert == TRUE && $team_status==1)
		    {
		    	//echo $insert."<br>"; echo "5----".$status."<br>"; die; 
		      return true;                           
		    }
		    else
		    {
		      //echo $insert."<br>"; echo "6----".$status."<br>"; die; 
		      return false;
		    } 
		  }
		  else
		  {
		    if ($insert == TRUE)
		    {
		    	//echo $insert."<br>"; echo "7----".$status."<br>"; die; 	
		      	return true;                           
		    }
		    else
		    {
		    	//echo $insert."<br>"; echo "8----".$status."<br>"; die; 
		      	return false;
		    } 
		  }
		}
    }
    
  /* Dealer Inteaction Save */
	public function save_dealer_interaction($data)
{
	if(!(!isset ($data->totalSale) || empty($data->totalSale)))
	{  // for multipile sample data
	    $interaction_info = array(
	        'd_id'=>$data->drId,
	        'meeting_sale'=>$data->totalSale,
	        'meeting_payment'=>isset($data->m_payment)?$data->m_payment:NULL,
	        'meeting_stock'=>isset($data->m_stock)?$data->m_stock:NULL,
	        'meet_or_not_meet'=>$data->interactionType,
	        'remark'=>$data->remarks,
	        'follow_up_action'=>$data->followUpAction!='' ? date('Y-m-d', strtotime($data->followUpAction)): NULL,
	        'status'=>1,
	        'crm_user_id'=> $data->user_id,
	        'create_date'=> $data->dateOfInteraction!='' ? date('Y-m-d', strtotime($data->dateOfInteraction)):savedate(),
	        'last_update' => savedate(),
	    );
	    $insert = $this->db->insert('pharma_interaction_dealer',$interaction_info);
	    $pi_dealer = $this->db->insert_id();    
	    $replica_data = array(
	       'interaction_with'=>$data->drId,
		   'crm_user_id'=> $data->user_id,
	    ); 
	    $insert = $this->db->insert('intearction_replica',$replica_data);
	    if(isset($pi_dealer) && !empty($data->totalSale))
	    {
	        /*Order info */
			$i=0;
			$year;
			$orderId;
			$incementId=get_increment_id('interaction_order')+1;
			if(date('m')>3)
			{
				$year= date('y').date('y')+1;
			}
			else
			{
				$year = (date('y')-1).date('y');
			}
			$orderId='PHO/'.$year.'/'.$incementId;
			/* echo $incementId;
			die; */
			$order_data = array(
				'interaction_id'=>$pi_dealer,
				'order_amount '=>$data->totalSale,
				'payment_term '=>$data->paymentTerms,
				'interaction_person_id'=>$data->drId,
				'crm_user_id'=>  $data->user_id,
				'order_id'=> $orderId,
				'status'=> 1,
				'interaction_with_id'=>$data->drId,
				'created_date'=>savedate(),                  
				'updated_date'=>savedate(),                  
			);
			$this->db->insert('interaction_order',$order_data); 	
			$newOrderId=$this->db->insert_id();
		    	foreach($data->productDataList as $key=>$val)
			{
		
				if(isset($val->potencyData))
				{
					$product_data = array(
						'product_id'=>$val->potencyData[0]->packSizeData[0]->productData[0]->id,
						'actual_value'=>$val->potencyData[0]->packSizeData[0]->productData[0]->product_price,
						'discount'=>$val->discount,
						'quantity'=>$val->productQuantity,
						'net_amount'=>$val->totalAmount,
						'order_id'=>$newOrderId,
						'crm_user_id'=>  $data->user_id,
						'created_date'=>savedate(),                  
						'updated_date'=>savedate(),                  
						);
						
				}
				else
				{
					//pr($val->packSizeData);
					$product_data = array(
						'product_id'=>$val->packSizeData[0]->productData[0]->id,
						'actual_value'=>$val->packSizeData[0]->productData[0]->product_price,
						'discount'=>$val->discount,
						'quantity'=>$val->productQuantity,
						'net_amount'=>$val->totalAmount,
						'order_id'=>$newOrderId,
						'crm_user_id'=>  $data->user_id,
						'created_date'=>savedate(),                  
						'updated_date'=>savedate(),                  
					);
				}
				$this->db->insert('order_details',$product_data); 
			}
		    /*End order info */
	    }
	    if(isset($pi_dealer))
	    {
	        foreach($data->sample as $kms=>$val_ms)
	        {
	            $sample_dealer_interaction_rel = array(
					'pidealer_id'=>$pi_dealer,
					'sample_id'=>$val_ms->id,
					'crm_user_id'=> $data->user_id,
					'last_update'=> savedate(),
	            );
	            //pr( $sample_dealer_interaction_rel);
	            //die;
	        	$status= $this->db->insert('dealer_interaction_sample_relation',$sample_dealer_interaction_rel);
	        } 
	    }
	    if(isset($pi_dealer) && isset($data->jointWorking))
	    {
			foreach($data->jointWorking as $k_tm=>$val_tm)
			{
				$team_dealer_interraction_rel = array(
					'pidealer_id'=>$pi_dealer,
					'team_id'=>$val_tm->id,
					'crm_user_id'=> $data->user_id,
					'last_update'=> savedate(),
					'dealer_id'=>$data->drId,
					'interaction_date'=>  date('Y-m-d', strtotime($data->dateOfInteraction)),
				);
				$team_status = $this->db->insert('dealer_interaction_with_team',$team_dealer_interraction_rel);
			} 
	    }
	    if(!empty($data->sample) && isset($data->jointWorking))
	    { 
	       if ($insert == TRUE && $status == 1 && $team_status==1)
	       {
	           return true;                           
	       }
	       else
	       {
	          return false;
	       } 
	    }
	    elseif(!empty($data->sample) && !isset($data->jointWorking))
	    {
	        if ( $insert == TRUE && $status == 1)
	        {
	            return true;                           
	        }
	        else
	        {
	            return false;
	        } 
	    }
	}
	else
	{  // for non sample data
	    $interaction_info = array(
	            'd_id'=>$data->drId,
	            'telephonic' => isset($data->orderBy)? $data->orderBy:NULL,
	            'meeting_sale'=>$data->totalSale,
				'meeting_payment'=>isset($data->m_payment)?$data->m_payment:NULL,
	        		'meeting_stock'=>isset($data->m_stock)?$data->m_stock:NULL,
				'meet_or_not_meet'=>$data->interactionType,
				'remark'=>$data->remarks,
				'follow_up_action'=>$data->followUpAction!='' ? date('Y-m-d', strtotime($data->followUpAction)):NULL,
				'status'=>1,
				'crm_user_id'=> $data->user_id,
				'create_date'=> $data->dateOfInteraction!='' ? date('Y-m-d', strtotime($data->dateOfInteraction)):savedate(),
				'last_update' => savedate(),
			);
	    $insert = $this->db->insert('pharma_interaction_dealer',$interaction_info);
	    $pi_doc = $this->db->insert_id();  
	    $replica_data = array(
	       'interaction_with'=>$data->drId,
		   'crm_user_id'=> $data->user_id,
	    ); 
	    $insert = $this->db->insert('intearction_replica',$replica_data);
	    if(isset($pi_doc)  && !empty($data->totalSale))
	    {
	        
			$i=0;
			$year;
			$orderId;
			$incementId=get_increment_id('interaction_order')+1;
			if(date('m')>3)
			{
				$year= date('y').date('y')+1;
			}
			else
			{
				$year = (date('y')-1).date('y');
			}
			$orderId='PHO/'.$year.'/'.$incementId;
			/* echo $incementId;
			die; */
			$order_data = array(
				'interaction_id'=>$pi_doc,
				'order_amount '=>$data->totalSale,
				'payment_term '=>$data->paymentTerms,
				'interaction_person_id'=>$data->drId,
				'crm_user_id'=>  $data->user_id,
				'order_id'=> $orderId,
				'status'=> 1,
				'interaction_with_id'=>$data->drId,
				'created_date'=>savedate(),                  
				'updated_date'=>savedate(),                  
			);
			$this->db->insert('interaction_order',$order_data); 	
			$newOrderId=$this->db->insert_id();
		    	foreach($data->productDataList as $key=>$val)
			{
				if(isset($val->potencyData))
				{
					$product_data = array(
						'product_id'=>$val->potencyData[0]->packSizeData[0]->productData[0]->id,
						'actual_value'=>$val->potencyData[0]->packSizeData[0]->productData[0]->product_price,
						'discount'=>$val->discount,
						'quantity'=>$val->productQuantity,
						'net_amount'=>$val->totalAmount,
						'order_id'=>$newOrderId,
						'crm_user_id'=>  $data->user_id,
						'created_date'=>savedate(),                  
						'updated_date'=>savedate(),                  
						);
						
				}
				else
				{
					//pr($val->packSizeData);
					$product_data = array(
						'product_id'=>$val->packSizeData[0]->productData[0]->id,
						'actual_value'=>$val->packSizeData[0]->productData[0]->product_price,
						'discount'=>$val->discount,
						'quantity'=>$val->productQuantity,
						'net_amount'=>$val->totalAmount,
						'order_id'=>$newOrderId,
						'crm_user_id'=>  $data->user_id,
						'created_date'=>savedate(),                  
						'updated_date'=>savedate(),                  
						);
				}
				$this->db->insert('order_details',$product_data); 
			}
	    }
	    if(isset($pi_doc)  && isset($data->jointWorking ))
	    {
			foreach($data->jointWorking as $k_tm=>$val_tm)
			{
	             $team_dealer_interraction_rel = array(
	                'pidealer_id'=>$pi_doc,
	                'team_id'=>$val_tm->id,
	                'crm_user_id'=> $data->user_id,
	                'last_update'=> savedate(),
	                'dealer_id'=>$data->drId,
	                'interaction_date'=>  date('Y-m-d', strtotime($data->dateOfInteraction)),
	            );
	           $team_status = $this->db->insert('dealer_interaction_with_team',$team_dealer_interraction_rel);
			} 
		}
		if(isset($data->jointWorking))
		{      
	        if ($insert == TRUE && $team_status==1)
	        {
	            return true;                           
	        }
	        else
	        {
	            return false;
	        } 
	    }
	    else
	    {
	        if ($insert == TRUE)
	        {
	            return true;                           
	        }
	        else
	        {
	            return false;
	        } 
	    }
	}                
}


/* End Dealer Inteaction Save */
    



    /*Nitin kumar
    	!!.Code starts here.!!
    */

    public function interaction_log_details($data){

		$this->db->where('crm_user_id',$data->user_id);
		$this->db->where('person_id',$data->dealer_view_id);
		$this->db->delete('log_interaction_data');
		$col='order_id';
		$this->db->select($col);
		$this->db->from('interaction_order');
		$this->db->where('interaction_id',0);
		$this->db->where('crm_user_id',$data->user_id);
		$this->db->where('interaction_person_id',$data->dealer_view_id);
		$query= $this->db->get();
		if($this->db->affected_rows()){
			$id= $query->row()->order_id;
			$this->db->where('order_id', $id);
			$this->db->delete('order_details');
			$this->db->where('interaction_id',0);
			$this->db->where('crm_user_id',$data->user_id);
			$this->db->where('interaction_person_id',$data->dealer_view_id);
			$this->db->delete('interaction_order');
		}

		$telephonic=0;
		$team_member='';
		$m_sample='';
		if(isset($data->telephonic)){
			$telephonic=$data->telephonic;
		}
		if(isset($data->team_member)){
//			$team_member=implode($data['team_member'],',');
			$team_member=$data->team_member;
		}
		if(isset($data->m_sample)){
			//$m_sample=implode($data['m_sample'],',');
			$m_sample=$data->m_sample;
		}

		$log_data = array(
			'person_id'=>$data->dealer_view_id,
			'followup_date'=>$data->fup_a,
			'interaction_date'=>$data->doi_doc,
			'stay'=>$data->stay,
			'telephonic'=>$telephonic,
			'joint_working '=>$team_member,
//			'path_info '=>$data->path_info,
			'path_info '=>1,
			'city_code '=>$data->city,
			'sample '=>$m_sample,
			'remark'=>$data->remark,
			'crm_user_id'=> $data->user_id,
		);
		$this->db->insert('log_interaction_data',$log_data);
		return ($this->db->affected_rows() == 1) ? true : false;
	}




}

