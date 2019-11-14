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



class Doctor extends REST_Controller {
    function __construct() {
    // Construct the parent class
        parent::__construct();
        $this->load->model('api/doctor_api_model','doctor');
       
    }

    function doctor_list_post()
    {
        # initialize variables
        $post = array_map('trim', $this->input->post());
        $msg = '';
		if(!(isset($post['sp_code'])&& !empty($post['sp_code']))){
        	$msg='Sp code is required.';
        }
        else if(!(isset($post['city_id'])&& !empty($post['city_id']))){
        	$msg = "City ID is required.";
		}
       	if ($msg == '') 
        {
			$sp_code  = $post['sp_code'];
			$city_id  = $post['city_id'];
        	$dataArr['sp_code']=$sp_code;
        	$dataArr['city_id']=$city_id;
	        $data = $this->doctor->get_doctor_list($dataArr);
		if ($data!=FALSE) 
		{ 
	            $result = array(
	                'Data' => $data,
			// 'Status' => true,
	                'Message' => 'successfully',
	                'Code' => 200
	            );
	        }
	        else 
	        {
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'No Doctor',
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
    
    function add_doctor_post()
    {
        # initialize variables
	$msg = '';
	$doc_data=json_decode($this->input->raw_input_stream);
        if (!isset($doc_data->doctor_name) || empty($doc_data->doctor_name))
        {
	   $msg = 'Please Enter doctor name.';
	}
	elseif (!isset($doc_data->doctor_num) || empty($doc_data->doctor_num))
        {
	   $msg = 'Please Enter doctor number.';
	}
	elseif(check_doctor_number($doc_data->doctor_num))
	{
		$msg = 'Your Doctor number already exist in our database. Please use different one.';
	}
	elseif(!isset ($doc_data->dealer_id) || count($doc_data->dealer_id)==0)
	{
	  $msg = 'Please Select atleast one dealer.';
	}
	elseif(!isset ($doc_data->city_pin) || empty($doc_data->city_pin))
	{
	   $msg = 'Please Enter City Pincode';
	}
	elseif(!isset ($doc_data->doctor_state) || empty($doc_data->doctor_state))
	{
		$msg = 'Please Enter State.';
	}
	elseif(!isset ($doc_data->doctor_city) ||  empty($doc_data->doctor_city))
	{
	  $msg = 'Please Enter City.';
	}
	elseif(!isset ($doc_data->user_id) || empty($doc_data->user_id))
	{
	   $msg = 'Please Enter User Id';
	}
	//die;
       	if ($msg == '') 
        {
	        $data = $this->doctor->add_doctor($doc_data);
		if ($data!=FALSE) 
		{ 
	            $result = array(
	                'Data' => $data,
			// 'Status' => true,
	                'Message' => 'Doctor added successfully',
	                'Code' => 200
	            );
	        }
	        else 
	        {
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'Error in Save Doctor info.',
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
    
    function edit_doctor_post()
    {
       	$msg = '';
	$doc_data=json_decode($this->input->raw_input_stream);
        if (!isset($doc_data->doctor_name) || empty($doc_data->doctor_name))
        {
	   $msg = 'Please Enter doctor name.';
	}
	elseif (!isset($doc_data->doctor_num) || empty($doc_data->doctor_num))
        {
	   $msg = 'Please Enter doctor number.';
	}
	elseif(!isset ($doc_data->doc_id) || empty($doc_data->doc_id))
	{
	   $msg = 'Please Enter Doctor Id';
	}
	elseif(check_doctor_number($doc_data->doctor_num,$doc_data->doc_id))
	{
		$msg = 'Your Doctor number already exist in our database. Please use different one.';
	}
	elseif(!isset ($doc_data->dealer_id) || count($doc_data->dealer_id)==0)
	{
	  $msg = 'Please Select atleast one dealer.';
	}
	elseif(!isset ($doc_data->city_pin) || empty($doc_data->city_pin))
	{
	   $msg = 'Please Enter City Pincode';
	}
	elseif(!isset ($doc_data->doctor_state) || empty($doc_data->doctor_state))
	{
		$msg = 'Please Enter State.';
	}
	elseif(!isset ($doc_data->doctor_city) ||  empty($doc_data->doctor_city))
	{
	  $msg = 'Please Enter City.';
	}
	elseif(!isset ($doc_data->user_id) || empty($doc_data->user_id))
	{
	   $msg = 'Please Enter User Id';
	}

       	if ($msg == '') 
        {
  	        $data = $this->doctor->edit_doctor($doc_data);
		if ($data!=FALSE) 
		{ 
	            $result = array(
	                'Data' => $data,
			// 'Status' => true,
	                'Message' => 'Doctor edited successfully',
	                'Code' => 200
	            );
	        }
	        else 
	        {
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'Error in edit doctor info.',
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
    
    function sync_doctor_post()
    {
      	$msg = '';
	$doc_data=json_decode($this->input->raw_input_stream);
	foreach($doc_data->data as  $doc)
	{
		$dealers=$doc->dealers_id;
		$dealer_ids= explode(',',$dealers);
		foreach($dealer_ids as $id)
		{
			if(strpos($id, 'romp'))
			{
				$pharmaid=get_pharma_id($id);
				$dealers=str_replace($id,$pharmaid,$dealers);
			}
		}

		if(isset($doc->id))
		{
			 $data = $this->doctor->sync_edit_doctor($doc,$dealers);
		}
		else
		{
			$data = $this->doctor->sync_add_doctor($doc,$dealers);
		}
	}
	$result = array(
		'Data' => new stdClass(),
		// 'Status' => true,
		'Message' => 'Doctor Save successfully',
		'Code' => 200
	);
    
        $this->response($result);
    }
    
    function number_doctor_pharma_get()
    {
    	$number=array();
    	foreach(get_pharma_number() as $k=>$phrama)
    	{
    		$number['pharma_number'][$k]=$phrama['company_phone'];
    	}
    	foreach(get_doctor_number() as $k=>$doc)
    	{
    		$number['doc_number'][$k]=$doc['doc_phone'];
      	}
	$result = array(
		'Data' => $number,
		'Status' => false,
		'Message' => "Contact Number Of Doctor and Sub Dealer",
		'Code' => 200
	);
	$this->response($result);
    }
 
}

