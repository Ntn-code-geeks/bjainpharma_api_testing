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
    
    public function insert_ta_da($data){
        //SELECT * FROM `pharma_interaction_doctor` WHERE create_date='2018-05-22' and crm_user_id=92 order by last_update DESC
       $previous=date('Y-m-d', strtotime('-1 day', strtotime($data->dateOfInteraction)));
       $interaction_day=date('D', strtotime($data->dateOfInteraction));
       $user_id=$data->user_id;
       $designation_id=get_user_deatils($user_id)->user_designation_id;
       $location_type=0;
       $internet_charge=10;
       $distance=1;
       $stp_distance=1;
       $source_city=get_interaction_source_api($user_id);//one date before from interaction
       $source_city_id=get_interaction_source_id_api($user_id);//one date before from interaction
       $destination_city=0;
       $destination_city_id=0;
       $ta=0;
       $stp_ta=0;
       $da=0;
       $rs_per_km=0;//get using distance
       $meet_id=$data->drId;
       if(!is_numeric($data->drId))
       {
            if(substr($data->drId,0,3)=='doc'){
                //doctor
                $destination_city=get_destination_interaction('doctor_list',$data->drId,1);
                $destination_city_id=get_destination_interaction_id('doctor_list',$data->drId,1);
            }
            else{
               //pharma 
                $destination_city=get_destination_interaction('pharmacy_list',$data->drId,2);
                $destination_city_id=get_destination_interaction_id('pharmacy_list',$data->drId,2);
            }
        }
        else{
           //dealer 
            $destination_city=get_destination_interaction('dealer',$data->drId,3);
            $destination_city_id=get_destination_interaction_id('dealer',$data->drId,3);
        }
        if($data->backHo && $destination_city==$source_city && $destination_city!=get_user_deatils($user_id)->headquarters_city)
        {

          $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=".$source_city."&destinations=".get_user_deatils($user_id)->hq_city_pincode;
          if($source_city_id==get_user_deatils($user_id)->headquarters_city)
          {
            $stp_distance=1;
          }
          else
          {
            $cityData=$this->check_city_path($source_city_id,get_user_deatils($user_id)->headquarters_city);
            if($cityData)
            {
              $stp_distance=$cityData->distance;
            }
          }
        }
        else
        {
          $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=".$source_city."&destinations=".$destination_city;
          if($source_city_id==$destination_city_id)
          {
            $stp_distance=1;
          }
          else
          {
            $cityData=$this->check_city_path($source_city_id,$destination_city_id);
            if($cityData)
            {
              $stp_distance=$cityData->distance;
            }
          }
          
        }
       /* echo $url;
        die;*/
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response);
        $status = $response_a->status;
        //die;
        if ($status == 'OK' && $response_a->rows[0]->elements[0]->status == 'OK')
        {
           $distance=explode(' ',$response_a->rows[0]->elements[0]->distance->text)[0];
        }
        else
        {
            $distance=1;
        }
        if($distance>=0 && $distance<=100)
        {
            if($designation_id==5 || $designation_id==6)
            {
                $rs_per_km=get_km_expanse(5);
            }
            else
            {
                $rs_per_km=get_km_expanse(1);
            }
        }
        elseif($distance>=101 && $distance<=300)
        {
            if($designation_id==5 || $designation_id==6)
            {
                $rs_per_km=get_km_expanse(6);
            }
            else
            {
                $rs_per_km=get_km_expanse(2);
            }
        }
        elseif($distance>=301 && $distance<=500)
        {
            if($designation_id==5 || $designation_id==6)
            {
                $rs_per_km=get_km_expanse(7);
            }
            else
            {
                $rs_per_km=get_km_expanse(3);
            }
        }
        else
        {
            $rs_per_km=get_km_expanse(4);
        }
        if( $rs_per_km==0)
        {
            $ta=0;
        }
        else
        {
            if($data->backHo)
            {
                if($destination_city==$source_city && $destination_city!=get_user_deatils($user_id)->headquarters_city)
                {
                    $ta=$rs_per_km*$distance;
                }
                else
                {
                    $ta=$rs_per_km*$distance*2;
                }
            }
            else
            {
                $ta=$rs_per_km*$distance;
            }
        }
        if($data->backHo)
        {
            if($destination_city==$source_city && $destination_city!=get_user_deatils($user_id)->headquarters_city)
            {
                $distance=$distance;
            }
            else
            {
                $distance=$distance*2;
            }
        }

        if($stp_distance>=0 && $stp_distance<=100)
        {
            if($designation_id==5 || $designation_id==6)
            {
                $rs_per_km=get_km_expanse(5);
            }
            else
            {
                $rs_per_km=get_km_expanse(1);
            }
        }
        elseif($stp_distance>=101 && $stp_distance<=300)
        {
            if($designation_id==5 || $designation_id==6)
            {
                $rs_per_km=get_km_expanse(6);
            }
            else
            {
                $rs_per_km=get_km_expanse(2);
            }
        }
        elseif($stp_distance>=301 && $stp_distance<=500)
        {
            if($designation_id==5 || $designation_id==6)
            {
                $rs_per_km=get_km_expanse(7);
            }
            else
            {
                $rs_per_km=get_km_expanse(3);
            }
        }
        else
        {
            $rs_per_km=get_km_expanse(4);
        }
        if( $rs_per_km==0)
        {
            $stp_ta=0;
        }
        else
        {
            if($data->backHo)
            {
                if($destination_city==$source_city && $destination_city!=get_user_deatils($user_id)->headquarters_city)
                {
                    $stp_ta=$rs_per_km*$stp_distance;
                }
                else
                {
                    $stp_ta=$rs_per_km*$stp_distance*2;
                }
            }
            else
            {
                $stp_ta=$rs_per_km*$stp_distance;
            }
        }
        if($data->backHo)
        {
            if($destination_city==$source_city && $destination_city!=get_user_deatils($user_id)->headquarters_city)
            {
                $stp_distance=$stp_distance;
            }
            else
            {
                $stp_distance=$stp_distance*2;
            }
        }

        $tour_date = date('Y-m-d', strtotime($data->dateOfInteraction));
        $tour_data = array(
            'user_id'=>$user_id,
            'designation_id'=>$designation_id,
            'internet_charge'=>10,
            'distance'=>$distance,
            'source_city'=>$source_city_id,
            'destination_city'=>$destination_city_id,
            'source_city_pin'=>$source_city,
            'destination_city_pin'=>$destination_city,
            'rs_per_km'=>$rs_per_km,
            'is_stay'=>$data->stay,
            'up_down'=>$data->backHo,
            'ta'=>$ta,
            'stp_ta'=>$stp_ta,
            'stp_distance'=>$stp_distance,
            'meet_id'=>$meet_id,
            'doi'=>$tour_date,
            'created_date'=>savedate(),
            'updated_date'=>savedate(),
            'status'=>1, 
        );
        $this->db->insert('ta_da_report',$tour_data); 
    }

        
}

