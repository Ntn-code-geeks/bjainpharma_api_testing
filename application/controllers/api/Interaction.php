<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/*
 * Developer: Niraj Sharma
 * Email: niraj@bjain.com
 * 
 * Dated: 28-08-2018
 * 
 */



class Interaction extends REST_Controller {
    function __construct() {
    // Construct the parent class
        parent::__construct();
        $this->load->model('api/interaction_api_model','interact');
        $this->load->model('doctor/Doctor_model','doctor');
        $this->load->model('dealer/Dealer_model','dealer');
        $this->load->model('pharmacy/Pharmacy_model','pharmacy');
        $this->load->model('users/User_model','user');
    
    }
     
	 /*Doctor Interaction*/
    function doctor_interaction_post()
    {
        # initialize variables
	$orderData='';
	$emailordt='';
	$emailorderdata='';
	$subject="Interaction Email.";
	$msg = '';
	$dealerEmail='';
	$interaction_data=json_decode($this->input->raw_input_stream);
	pr($interaction_data);
	die;
	if (!isset($interaction_data->dateOfInteraction) || empty($interaction_data->dateOfInteraction))
	{
	$msg = 'Please enter Date of Interaction';
	}
	elseif(!isset ($interaction_data->dateOfInteraction) || empty($interaction_data->dateOfInteraction))
	{
		$msg = 'Please Enter Meeting date.';
	}
	elseif($interaction_data->orderBy==1 && !check_leave($interaction_data->dateOfInteraction,$interaction_data->user_id))
	{
		$msg = 'You have taken leave  or holiday on that day please change date!!';
	}
	elseif((isset($interaction_data->totalSale) && !empty($interaction_data->totalSale)) && (!isset($interaction_data->paymentTerms) || empty($interaction_data->paymentTerms)))
	{
	   	$msg = 'Please Enter Payment Terms';
	}
	elseif((isset($interaction_data->totalSale) && !empty($interaction_data->totalSale)) && (!isset ($interaction_data->dealerId) || empty($interaction_data->dealerId)))
	{
	   	$msg = 'Please Enter Dealer or Pharma';
	}
	elseif(!isset($interaction_data->orderBy) && !isset($interaction_data->interactionType))
	{
		$msg = 'Please Enter any type of meeting.';
	}
	elseif(!isset ($interaction_data->user_id) || empty($interaction_data->user_id))
	{
	   	$msg = 'Please Enter User Id';
	}
	elseif(!isset ($interaction_data->city_pin) || empty($interaction_data->city_pin))
	{
	   	$msg = 'Please Enter City Pincode of doctor';
	}

       	if ($msg == '') 
        {
        	/*$dealers=$interaction_data->drId;
		$dealer_ids= explode(',',$dealers);
		foreach($dealer_ids as $id)
		{
			if(strpos($id, 'romp'))
			{
				$pharmaid=get_doctor_id($id);
				$dealers=str_replace($id,$pharmaid,$dealers);
			}
		}*/
	        $data = $this->interact->save_doctor_interaction($interaction_data);
		if ($data!=FALSE) 
		{
			 
		    $this->interact->insert_ta_da($interaction_data);
		    $senderemail=get_user_email($interaction_data->user_id);
    
	  	    if(isset($interaction_data->totalSale) && !empty($interaction_data->totalSale) )//only product 
		    {
		      $sms= 'Thank you Dear Doctor for your support to B. Jain Pharma. I am happy to receive your order which is mentioned below.';
		      //$orderDetails=$this->interact->get_orderdeatils_user($interaction_data);
		      foreach($interaction_data->productDataList as $key=>$details)
		      {
		      	if(isset($details->potencyData)){
		        $orderData=$orderData.' '.$details->potencyData[0]->packSizeData[0]->productData[0]->name.'('.$details->potencyData[0]->packSizeData[0]->name.') mrp='.$details->potencyData[0]->packSizeData[0]->productData[0]->product_price.',quantity='.$details->productQuantity.' ,discount='.$details->discount.'%, net amount='.$details->totalAmount.' ';
		        //$total_cost=$total_cost+$details['net_amount'];
		        
		        
		         $emailordt= $emailordt.'<tr><td>'.$details->potencyData[0]->packSizeData[0]->productData[0]->name.'('.$details->potencyData[0]->packSizeData[0]->name.')</td><td>'.$details->potencyData[0]->packSizeData[0]->productData[0]->product_price.'</td><td>'.$details->productQuantity.'</td><td>'.$details->discount.'%</td><td>'.$details->totalAmount.'</td></tr>';
		         
		         
		         
		         }
		         else
		         {
		         	$orderData=$orderData.' '.$details->packSizeData[0]->productData[0]->name.'('.$details->packSizeData[0]->name.') mrp='.$details->packSizeData[0]->productData[0]->product_price.',quantity='.$details->productQuantity.' ,discount='.$details->discount.'%, net amount='.$details->totalAmount.' ';
		        //$total_cost=$total_cost+$details['net_amount'];
		         $emailordt= $emailordt.'<tr><td>'.$details->packSizeData[0]->productData[0]->name.'('.$details->packSizeData[0]->name.')</td><td>'.$details->packSizeData[0]->productData[0]->product_price.'</td><td>'.$details->productQuantity.'</td><td>'.$details->discount.'%</td><td>'.$details->totalAmount.'</td></tr>';
		         }
		      }
		      $emailorderdata=' <h2>Your Order Details</h2> <table cellspacing="0" cellpadding="5" border="1" style="width:100%; border-color:#222;" ><thead><tr><th>Product</th><th>MRP</th><th>Qty.</th><th>Discount</th><th>Amount</th> </tr></thead> 
		      <tbody>'.$emailordt.'</tbody><tfoot><tr><th colspan="4" style="text-align:right; border-right:none !important;">Total</th> <th colspan="4" style="text-align:right; border-left:none;">Rs.'.$interaction_data->totalSale.'</th><tr></tfoot></table> ';
		    }
		    
			    
		  if(isset($interaction_data->dealerId))
		  {
			if(is_numeric($interaction_data->dealerId))
			{
				//for dealer;
				$data=$this->dealer->get_dealer_data($interaction_data->dealerId);
				if($data!=FALSE)
				{
					$dealerNumber=$data->d_phone;
					$dealerEmail=$data->d_email;
				}
			}
			else
			{
				//for pharmacy;
				$data=$this->pharmacy->get_pharmacy_data($interaction_data->dealerId);
				if($data!=FALSE)
				{
					$dealerNumber=$data->company_phone;
					$dealerEmail=$data->company_email;
				}
			}
		}
		$docdata=$this->doctor->get_doctor_data($interaction_data->drId);
		if($docdata!=FALSE)				{
			$docNumber=$docdata->doc_phone;
			$docEmail=$docdata->doc_email;
		}		
										
				try{	
          if(!isset($interaction_data->totalSale)){
              if ($interaction_data->interactionType==1){
                # code...
                $sms='Thank you Dear Doctor for your valuable time. We look forward to your kind support for B. Jain’s Product.';//but no sale or sample
                $emailbody='<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{ margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="'.base_url().'/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
                <h3>Dear,</h3> <p>'.$sms.'</p><p><i>This is an auto generated email.</i></p>
                <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">'.get_user_name($interaction_data->user_id).'<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
              }
              else{
                $sms= 'Doctor I visited your clinic today but was unable to meet you. May I request you for a suitable time for a meeting when I can see you.';
                $emailbody='<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;} .content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
                margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="'.base_url().'/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
                <h3>Dear,</h3> <p>'.$sms.'</p><p><i>This is an auto generated email.</i></p>
                <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">'.get_user_name($interaction_data->user_id).'<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
              }
            }
            else // for sale
            {
              if(isset($interaction_data->totalSale) && isset($interaction_data->sample))
              {
           
                 $sms= 'Thank you Dear Doctor for your support to B. Jain Pharma. Please give your valuable feedback for provided samples. I am happy to receive your order which is mentioned below.';
                 $sms1=$sms;
                 $sms=$sms.' '.$orderData;
                 $emailbody='<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
                     margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="'.base_url().'/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
                  <h3>Dear,</h3> <p>'.$sms1.'</p>'.$emailorderdata.'<p><i>This is an auto generated email.</i></p>
                  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">'.get_user_name($interaction_data->user_id).'<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';


                  $dealerSms='Dear Dealer/Sub Dealer, we have received an order from Dr.'.$interaction_data->name.'  Kindly deliver at mentioned time and discount.The order details are mentioned below. '.$orderData;

                  $dealerSms1='Dear Dealer/Sub Dealer, we have received an order from Dr.'.$interaction_data->name.'  Kindly deliver at mentioned time and discount.The order details are mentioned below. ';

                  $dealeremailbody='<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
                     margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="'.base_url().'/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
                  <h3>Dear,</h3> <p>'.$dealerSms1.'</p>'.$emailorderdata.'<p><i>This is an auto generated email.</i></p>
                  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">'.get_user_name($interaction_data->user_id).'<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
                  /*Dealer message or email*/
                  if($interaction_data->sendmailDealer==1)
                  {
                    //send_msg($dealerSms,$dealerNumber);
                    if($dealerEmail!='')
                    { 
                      // $success =send_email($dealerEmail, $senderemail, $subject, $dealeremailbody);//send message to pharmacy/dealer
                    }
                  }
              }
              else if(isset($interaction_data->sample))// only sample
              {
          
                $sms= 'Thank you Dear Doctor for your valuable time. Kindly give your feedback for samples.';
                $emailbody='<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
                  margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="'.base_url().'/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
                  <h3>Dear,</h3> <p>'.$sms.'</p><p><i>This is an auto generated email.</i></p>
                  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">'.get_user_name($interaction_data->user_id).'<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
              }
              else if(isset($interaction_data->totalSale))//only product 
              {
           
                $sms= 'Thank you Dear Doctor for your support to B. Jain Pharma. I am happy to receive your order which is mentioned below.';
                $sms1=$sms;
                  $sms=$sms.' '.$orderData;
                   $emailbody='<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
                     margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="'.base_url().'/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
                  <h3>Dear,</h3> <p>'.$sms1.'</p>'.$emailorderdata.'<p><i>This is an auto generated email.</i></p>
                  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">'.get_user_name($interaction_data->user_id).'<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
            
                  $dealerSms='Dear Dealer/Sub Dealer, we have received an order from Dr.'.$interaction_data->name.'  Kindly deliver at mentioned time and discount.The order details are mentioned below. '.$orderData;

                  $dealerSms1='Dear Dealer/Sub Dealer, we have received an order from Dr.'.$interaction_data->name.'  Kindly deliver at mentioned time and discount.The order details are mentioned below. ';

                  $dealeremailbody='<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
                     margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="'.base_url().'/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
                  <h3>Dear,</h3> <p>'.$dealerSms1.'</p>'.$emailorderdata.'<p><i>This is an auto generated email.</i></p>
                  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">'.get_user_name($interaction_data->user_id).'<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
       
                  /*Dealer */
                  if($interaction_data->sendmailDealer==1)
                  {
                   // send_msg($dealerSms,$dealerNumber);
                    if($dealerEmail!='')
                    { 
                     // $success =send_email($dealerEmail, $senderemail, $subject, $dealeremailbody);//send message to pharmacy/dealer
                    }
                  }
              }

              
          }

        //send_msg($sms,$docNumber);
	if($docEmail!='')
	{
		$success =send_email($docEmail, $senderemail, $subject, $emailbody );//send message to doctor	//send message to doctor
	
	}
	}
	catch(Exception $e){
		$result = array(
	                'Data' => $data,
			// 'Status' => true,
	                'Message' => 'Something Went wrong',
	                'Code' => 404
	            );
	}
	
		    
      if(isset($interaction_data->totalSale) && !empty($interaction_data->totalSale))
      {						
  	$userBoss=$this->user->getUserBoss($interaction_data->user_id);
        $username=get_user_name($interaction_data->user_id);
        $msname='';
        if(isset($interaction_data->dealerId))
        {
          if(is_numeric($interaction_data->dealerId))
            {
              //for dealer;
              $data=$this->dealer->get_dealer_data($interaction_data->dealerId);
              if($data!=FALSE)
              {
                $msname=$data->dealer_name;
               
              }
            }else{
              //for pharmacy;
              $data=$this->pharmacy->get_pharmacy_data($interaction_data->dealerId);
              if($data!=FALSE)
              {
                $msname=$data->company_name;
              }
            }
        }

        $userbossms='';
         $userbosemail='';
        if(isset($interaction_data->name))
        {
          $userbossms='Mr. '.$username. ' Has placed an order from Dr.'.$interaction_data->name.'. To M/S '.$msname.' the order details are as. '.$orderData;
          $userbossms1='Mr. '.$username. ' Has placed an order from Dr.'.$interaction_data->name.'. To M/S '.$msname.' the order details are as. ';
          $userbosemail='<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
                     margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="'.base_url().'/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
                  <h3>Dear,</h3> <p>'.$userbossms1.'</p>'.$emailorderdata.'<p><i>This is an auto generated email.</i></p>
                  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">'.get_user_name($interaction_data->user_id).'<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
        }

        $userbosssms='';
	if( $userBoss!=False)
	{
		foreach($userBoss as $boss)
		{
			if(!empty($boss['user_phone']))
			{
				//send_msg($userbossms,$boss['user_phone']);//send message to all boss

				try{
					if($boss['email_id']!='')
					{

				    		//send_email($boss['email_id'], $senderemail, $subject, $userbosemail);//send message to dealer
					}
				}
				catch(Exception $e){
		$result = array(
	                'Data' => $data,
			// 'Status' => true,
	                    'Message' => 'Something Went wrong',
	                'Code' => 404
	            );
	}
				}
			}
		}
	}

        //send_email('pharma.reports@bjain.com',  $senderemail,$subject, $userbosemail);//send only email to H.O.
         $result = array(
	                'Data' => $data,
			// 'Status' => true,
	                'Message' => 'Interaction save successfully',
	                'Code' => 200
	            );
      }	    
	        else 
	        {
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'Error in Save Interactio info.',
	                'Code' => 404
	            );
	        }
        }
        else 
        {
            $result = array(
                'Data' => new stdClass(),
                'Status' => false,
                'Message' => $msg,
                'Code' => 404
            );
        }
        $this->response($result);
    }
    
    function sync_doctor_interaction_post()
    {
        # initialize variables
	$orderData='';
	$emailordt='';
	$dealerEmail='';
	$emailorderdata='';
	$subject="Interaction Email.";
	$msg = '';
	$interaction_data_all=json_decode($this->input->raw_input_stream);
	//pr($interaction_data);

	foreach($interaction_data_all->syncdata as $interaction_data)
	{
	$emailordt='';
	$orderData='';
	
        	$doc=$interaction_data->drId;
		
		if(strpos($doc, 'romp'))
		{
			$interaction_data->drId=get_doctor_id($doc);
		}
	
	        $data = $this->interact->save_doctor_interaction($interaction_data);
		if ($data!=FALSE) 
		{
			 
		    $this->interact->insert_ta_da($interaction_data);
		    $senderemail=get_user_email($interaction_data->user_id);
    
	  	    if(isset($interaction_data->totalSale) && !empty($interaction_data->totalSale) )//only product 
		    {
		      $sms= 'Thank you Dear Doctor for your support to B. Jain Pharma. I am happy to receive your order which is mentioned below.';
		      //$orderDetails=$this->interact->get_orderdeatils_user($interaction_data);
		      foreach($interaction_data->productDataList as $key=>$details)
		      {
		      	if(isset($details->potencyData)){
		        $orderData=$orderData.' '.$details->potencyData[0]->packSizeData[0]->productData[0]->name.'('.$details->potencyData[0]->packSizeData[0]->name.') mrp='.$details->potencyData[0]->packSizeData[0]->productData[0]->product_price.',quantity='.$details->productQuantity.' ,discount='.$details->discount.'%, net amount='.$details->totalAmount.' ';
		        //$total_cost=$total_cost+$details['net_amount'];
		        
		         $emailordt= $emailordt.'<tr><td>'.$details->potencyData[0]->packSizeData[0]->productData[0]->name.'('.$details->potencyData[0]->packSizeData[0]->name.')</td><td>'.$details->potencyData[0]->packSizeData[0]->productData[0]->product_price.'</td><td>'.$details->productQuantity.'</td><td>'.$details->discount.'%</td><td>'.$details->totalAmount.'</td></tr>';
		         
		         }
		         else
		         {
		         	$orderData=$orderData.' '.$details->packSizeData[0]->productData[0]->name.'('.$details->packSizeData[0]->name.') mrp='.$details->packSizeData[0]->productData[0]->product_price.',quantity='.$details->productQuantity.' ,discount='.$details->discount.'%, net amount='.$details->totalAmount.' ';
		        //$total_cost=$total_cost+$details['net_amount'];
		         $emailordt= $emailordt.'<tr><td>'.$details->packSizeData[0]->productData[0]->name.'('.$details->packSizeData[0]->name.')</td><td>'.$details->packSizeData[0]->productData[0]->product_price.'</td><td>'.$details->productQuantity.'</td><td>'.$details->discount.'%</td><td>'.$details->totalAmount.'</td></tr>';
		         }
		      }
		      $emailorderdata=' <h2>Your Order Details</h2> <table cellspacing="0" cellpadding="5" border="1" style="width:100%; border-color:#222;" ><thead><tr><th>Product</th><th>MRP</th><th>Qty.</th><th>Discount</th><th>Amount</th> </tr></thead> 
		      <tbody>'.$emailordt.'</tbody><tfoot><tr><th colspan="4" style="text-align:right; border-right:none !important;">Total</th> <th colspan="4" style="text-align:right; border-left:none;">Rs.'.$interaction_data->totalSale.'</th><tr></tfoot></table> ';
		    }
		    
			    
		  if(isset($interaction_data->dealerId))
		  {
			if(is_numeric($interaction_data->dealerId))
			{
				//for dealer;
				$data=$this->dealer->get_dealer_data($interaction_data->dealerId);
				if($data!=FALSE)
				{
					$dealerNumber=$data->d_phone;
					$dealerEmail=$data->d_email;
				}
			}
			else
			{
				//for pharmacy;
				$data=$this->pharmacy->get_pharmacy_data($interaction_data->dealerId);
				if($data!=FALSE)
				{
					$dealerNumber=$data->company_phone;
					$dealerEmail=$data->company_email;
				}
			}
		}
		$docdata=$this->doctor->get_doctor_data($interaction_data->drId);
		if($docdata!=FALSE)				{
			$docNumber=$docdata->doc_phone;
			$docEmail=$docdata->doc_email;
		}		
										
	try{	
          if(!isset($interaction_data->totalSale)){
              if ($interaction_data->interactionType==1){
                # code...
                $sms='Thank you Dear Doctor for your valuable time. We look forward to your kind support for B. Jain’s Product.';//but no sale or sample
                $emailbody='<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{ margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="'.base_url().'/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
                <h3>Dear,</h3> <p>'.$sms.'</p><p><i>This is an auto generated email.</i></p>
                <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">'.get_user_name($interaction_data->user_id).'<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
              }
              else{
                $sms= 'Doctor I visited your clinic today but was unable to meet you. May I request you for a suitable time for a meeting when I can see you.';
                $emailbody='<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;} .content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
                margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="'.base_url().'/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
                <h3>Dear,</h3> <p>'.$sms.'</p><p><i>This is an auto generated email.</i></p>
                <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">'.get_user_name($interaction_data->user_id).'<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
              }
            }
            else // for sale
            {
              if(isset($interaction_data->totalSale) && isset($interaction_data->sample))
              {
           
                 $sms= 'Thank you Dear Doctor for your support to B. Jain Pharma. Please give your valuable feedback for provided samples. I am happy to receive your order which is mentioned below.';
                 $sms1=$sms;
                 $sms=$sms.' '.$orderData;
                 $emailbody='<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
                     margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="'.base_url().'/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
                  <h3>Dear,</h3> <p>'.$sms1.'</p>'.$emailorderdata.'<p><i>This is an auto generated email.</i></p>
                  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">'.get_user_name($interaction_data->user_id).'<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';


                  $dealerSms='Dear Dealer/Sub Dealer, we have received an order from Dr.'.$interaction_data->name.'  Kindly deliver at mentioned time and discount.The order details are mentioned below. '.$orderData;

                  $dealerSms1='Dear Dealer/Sub Dealer, we have received an order from Dr.'.$interaction_data->name.'  Kindly deliver at mentioned time and discount.The order details are mentioned below. ';

                  $dealeremailbody='<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
                     margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="'.base_url().'/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
                  <h3>Dear,</h3> <p>'.$dealerSms1.'</p>'.$emailorderdata.'<p><i>This is an auto generated email.</i></p>
                  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">'.get_user_name($interaction_data->user_id).'<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
                  /*Dealer message or email*/
                  if($interaction_data->sendmailDealer==1)
                  {
                    //send_msg($dealerSms,$dealerNumber);

                    if($dealerEmail!='')
                    { 
                      // $success =send_email($dealerEmail, $senderemail, $subject, $dealeremailbody);//send message to pharmacy/dealer

                    }
                  }
              }
              else if(isset($interaction_data->sample))// only sample
              {
          
                $sms= 'Thank you Dear Doctor for your valuable time. Kindly give your feedback for samples.';
                $emailbody='<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
                  margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="'.base_url().'/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
                  <h3>Dear,</h3> <p>'.$sms.'</p><p><i>This is an auto generated email.</i></p>
                  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">'.get_user_name($interaction_data->user_id).'<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
              }
              else if(isset($interaction_data->totalSale))//only product 
              {
           
                $sms= 'Thank you Dear Doctor for your support to B. Jain Pharma. I am happy to receive your order which is mentioned below.';
                $sms1=$sms;
                  $sms=$sms.' '.$orderData;
                   $emailbody='<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
                     margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="'.base_url().'/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
                  <h3>Dear,</h3> <p>'.$sms1.'</p>'.$emailorderdata.'<p><i>This is an auto generated email.</i></p>
                  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">'.get_user_name($interaction_data->user_id).'<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
            
                  $dealerSms='Dear Dealer/Sub Dealer, we have received an order from Dr.'.$interaction_data->name.'  Kindly deliver at mentioned time and discount.The order details are mentioned below. '.$orderData;

                  $dealerSms1='Dear Dealer/Sub Dealer, we have received an order from Dr.'.$interaction_data->name.'  Kindly deliver at mentioned time and discount.The order details are mentioned below. ';

                  $dealeremailbody='<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
                     margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="'.base_url().'/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
                  <h3>Dear,</h3> <p>'.$dealerSms1.'</p>'.$emailorderdata.'<p><i>This is an auto generated email.</i></p>
                  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">'.get_user_name($interaction_data->user_id).'<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
       
                  /*Dealer */
                  if($interaction_data->sendmailDealer==1)
                  {
                   // send_msg($dealerSms,$dealerNumber);
                    if($dealerEmail!='')
                    { 
                     // $success =send_email($dealerEmail, $senderemail, $subject, $dealeremailbody);//send message to pharmacy/dealer
                    }
                  }
              }

              
          }

        //send_msg($sms,$docNumber);
	if($docEmail!='')
	{
		$success =send_email($docEmail, $senderemail, $subject, $emailbody );//send message to doctor	//send message to doctor
	
	}
	}
	catch(Exception $e){
		
	}
	
		    
      if(isset($interaction_data->totalSale) && !empty($interaction_data->totalSale))
      {						
  	$userBoss=$this->user->getUserBoss($interaction_data->user_id);
        $username=get_user_name($interaction_data->user_id);
        $msname='';
        if(isset($interaction_data->dealerId))
        {
          if(is_numeric($interaction_data->dealerId))
            {
              //for dealer;
              $data=$this->dealer->get_dealer_data($interaction_data->dealerId);
              if($data!=FALSE)
              {
                $msname=$data->dealer_name;
               
              }
            }else{
              //for pharmacy;
              $data=$this->pharmacy->get_pharmacy_data($interaction_data->dealerId);
              if($data!=FALSE)
              {
                $msname=$data->company_name;
              }
            }
        }

        $userbossms='';
         $userbosemail='';
        if(isset($interaction_data->name))
        {
          $userbossms='Mr. '.$username. ' Has placed an order from Dr.'.$interaction_data->name.'. To M/S '.$msname.' the order details are as. '.$orderData;
          $userbossms1='Mr. '.$username. ' Has placed an order from Dr.'.$interaction_data->name.'. To M/S '.$msname.' the order details are as. ';
          $userbosemail='<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
                     margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="'.base_url().'/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
                  <h3>Dear,</h3> <p>'.$userbossms1.'</p>'.$emailorderdata.'<p><i>This is an auto generated email.</i></p>
                  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">'.get_user_name($interaction_data->user_id).'<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
        }

        $userbosssms='';
	if( $userBoss!=False)
	{
		foreach($userBoss as $boss)
		{
			if(!empty($boss['user_phone']))
			{
				//send_msg($userbossms,$boss['user_phone']);//send message to all boss

				try{
					if($boss['email_id']!='')
					{

				    		//send_email($boss['email_id'], $senderemail, $subject, $userbosemail);//send message to dealer
					}
				}
				catch(Exception $e){

					}
				}
			}
		}
	}

        //send_email('pharma.reports@bjain.com',  $senderemail,$subject, $userbosemail);//send only email to H.O.
      }	    

    }
    
	
        $result = array(
	                //'Data' => $data,
			// 'Status' => true,
	                'Message' => 'Doctor Interaction save successfully',
	                'Code' => 200
	            );
        $this->response($result);
    }

     /*Sub Dealer Interaction*/
    function pharma_interaction_post()
    {
        # initialize variables
$msg='';
		$interaction_data=json_decode($this->input->raw_input_stream);
		//pr($interaction_data);
		
	    if (!isset($interaction_data->dateOfInteraction) || empty($interaction_data->dateOfInteraction))
	    {
		   	$msg = 'Please enter Date of Interaction';
		}
		elseif(!isset ($interaction_data->dateOfInteraction) || empty($interaction_data->dateOfInteraction))
		{
			$msg = 'Please Enter Meeting date.';
		}
		elseif($interaction_data->orderBy==1 && !check_leave($interaction_data->dateOfInteraction,$interaction_data->user_id))
		{
			$msg = 'You have taken leave  or holiday on that day please change date!!';
		}
		elseif((isset($interaction_data->totalSale) && !empty($interaction_data->totalSale)) && (!isset($interaction_data->paymentTerms) || empty($interaction_data->paymentTerms)))
		{
		   	$msg = 'Please Enter Payment Terms';
		}
		elseif((isset($interaction_data->totalSale) && !empty($interaction_data->totalSale)) && (!isset ($interaction_data->dealerId) || empty($interaction_data->dealerId)))
		{
		   	$msg = 'Please Enter Dealer or Pharma';
		}
		elseif(!isset($interaction_data->orderBy) && !isset($interaction_data->interactionType))
		{
			$msg = 'Please Enter any type of meeting.';
		}
		elseif(!isset ($interaction_data->user_id) || empty($interaction_data->user_id))
		{
		   	$msg = 'Please Enter User Id';
		}
		elseif(!isset ($interaction_data->city_pin) || empty($interaction_data->city_pin))
		{
		   	$msg = 'Please Enter City Pincode of doctor';
		}

       	if ($msg == '') 
        {
		    $data = $this->interact->save_pharma_interaction($interaction_data);
			if ($data!=FALSE) 
			{
			    $this->interact->insert_ta_da($interaction_data);
	           	$result = array(
					'Data' => $data,
					// 'Status' => true,
					'Message' => 'Interaction save successfully',
					'Code' => 200
				);
	     	}	    
	        else 
	        {
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'Error in Save Interactio info.',
	                'Code' => 404
	            );
	        }
        }
        else 
        {
            $result = array(
                'Data' => new stdClass(),
                'Status' => false,
                'Message' => $msg,
                'Code' => 404
            );
        }
        $this->response($result);
    }
    
    function sync_pharma_interaction_post()
    {
        # initialize variables
	$interaction_data_all=json_decode($this->input->raw_input_stream);
		//pr($interaction_data);
	foreach($interaction_data_all->syncdata as $interaction_data)
	{
		$pharma=$interaction_data->drId;
		if(strpos($pharma, 'romp'))
		{
			$interaction_data->drId=get_pharma_id($pharma);
		}
		$data = $this->interact->save_pharma_interaction($interaction_data);
		if ($data!=FALSE) 
		{

		    $this->interact->insert_ta_da($interaction_data);
		}
	}
	$result = array(
                'Message' => 'Interaction save successfully',
                'Code' => 200
            );
        $this->response($result);
     }
     
     /*Dealer Interaction*/
    function dealer_interaction_post()
    {
    $msg='';
        # initialize variables
	$interaction_data=json_decode($this->input->raw_input_stream);
		//pr($interaction_data);
		
	    if (!isset($interaction_data->dateOfInteraction) || empty($interaction_data->dateOfInteraction))
	    {
		   	$msg = 'Please enter Date of Interaction';
		}
		elseif(!isset ($interaction_data->dateOfInteraction) || empty($interaction_data->dateOfInteraction))
		{
			$msg = 'Please Enter Meeting date.';
		}
		elseif($interaction_data->orderBy==1 && !check_leave($interaction_data->dateOfInteraction,$interaction_data->user_id))
		{
			$msg = 'You have taken leave  or holiday on that day please change date!!';
		}
		elseif((isset($interaction_data->totalSale) && !empty($interaction_data->totalSale)) && (!isset($interaction_data->paymentTerms) || empty($interaction_data->paymentTerms)))
		{
		   	$msg = 'Please Enter Payment Terms';
		}

		elseif(!isset($interaction_data->orderBy) && !isset($interaction_data->interactionType))
		{
			$msg = 'Please Enter any type of meeting.';
		}
		elseif(!isset ($interaction_data->user_id) || empty($interaction_data->user_id))
		{
		   	$msg = 'Please Enter User Id';
		}
		elseif(!isset ($interaction_data->city_pin) || empty($interaction_data->city_pin))
		{
		   	$msg = 'Please Enter City Pincode of doctor';
		}

       	if ($msg == '') 
        {
		    $data = $this->interact->save_dealer_interaction($interaction_data);
			if ($data!=FALSE) 
			{
			    $this->interact->insert_ta_da($interaction_data);
	           	$result = array(
					'Data' => $data,
					// 'Status' => true,
					'Message' => 'Interaction save successfully',
					'Code' => 200
				);
	     	}	    
	        else 
	        {
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'Error in Save Interactio info.',
	                'Code' => 404
	            );
	        }
        }
        else 
        {
            $result = array(
                'Data' => new stdClass(),
                'Status' => false,
                'Message' => $msg,
                'Code' => 404
            );
        }
        $this->response($result);
    }
    
    function sync_dealer_interaction_post()
    {
        # initialize variables
	$interaction_data_all=json_decode($this->input->raw_input_stream);
	//pr($interaction_data);
	foreach($interaction_data_all->syncdata as $interaction_data)
	{

		$data = $this->interact->save_dealer_interaction($interaction_data);
		if ($data!=FALSE) 
		{

		    $this->interact->insert_ta_da($interaction_data);
		}
	}
	$result = array(
                'Message' => 'Interaction save successfully',
                'Code' => 200
            );
        $this->response($result);
     }
}

