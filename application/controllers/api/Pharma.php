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



class Pharma extends REST_Controller {
    function __construct() {
    // Construct the parent class
        parent::__construct();
        $this->load->model('api/pharma_api_model','pharma');
       
    }

    function pharma_list_post()
    {
        # initialize variables
		$post = array_map('trim', $this->input->post());
		$msg = '';

		if(!(isset( $post['sp_code'])&& !empty( $post['sp_code']))){
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
	        $data = $this->pharma->get_pharma_list($dataArr);
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
	                'Message' => 'No Pharma',
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
    
    function add_pharma_post()
    {
        # initialize variables
	$msg = '';
	$pharma_data=json_decode($this->input->raw_input_stream);
        if (!isset($pharma_data->com_number) || empty($pharma_data->com_number))
        {
	   $msg = 'Please enter company number';
	}
	elseif(check_pharma_company_number($pharma_data->com_number))
	{
		$msg = 'Your Company number already exist in our database. Please use different one.';
	}
	elseif(!isset ($pharma_data->dealer_id) || count($pharma_data->dealer_id)==0)
	{
	  $msg = 'Please Select atleast one dealer.';
	}
	elseif(!isset ($pharma_data->city_pin) || empty($pharma_data->city_pin))
	{
	   $msg = 'Please Enter City Pincode';
	}
	elseif(!isset ($pharma_data->com_state) || empty($pharma_data->com_state))
	{
		$msg = 'Please Enter State.';
	}
	elseif(!isset ($pharma_data->com_city) ||  empty($pharma_data->com_city))
	{
	  $msg = 'Please Enter City.';
	}
	elseif(!isset ($pharma_data->com_name) || empty($pharma_data->com_name))
	{
	   $msg = 'Please Enter Company Name';
	}
	elseif(!isset ($pharma_data->user_id) || empty($pharma_data->user_id))
	{
	   $msg = 'Please Enter User Id';
	}
	//die;
       	if ($msg == '') 
        {
	        $data = $this->pharma->add_pharma($pharma_data);
		if ($data!=FALSE) 
		{ 
	            $result = array(
	                'Data' => $data,
			// 'Status' => true,
	                'Message' => 'Pharma added successfully',
	                'Code' => 200
	            );
	        }
	        else 
	        {
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'Error in Save pharma info.',
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
    
    function edit_pharma_post()
    {
        # initialize variables
	$msg = '';
	$pharma_data=json_decode($this->input->raw_input_stream);
        if (!isset($pharma_data->com_number) || empty($pharma_data->com_number))
        {
	   $msg = 'Please enter company number';
	}
	elseif(!isset ($pharma_data->pharma_id) || empty($pharma_data->pharma_id))
	{
	   $msg = 'Please Enter Pharma Id';
	}
	elseif(check_pharma_company_number($pharma_data->com_number,$pharma_data->pharma_id))
	{
		$msg = 'Your Company number already exist in our database. Please use different one.';
	}
	elseif(!isset ($pharma_data->dealer_id) || count($pharma_data->dealer_id)==0)
	{
	  $msg = 'Please Select atleast one dealer.';
	}
	elseif(!isset ($pharma_data->city_pin) || empty($pharma_data->city_pin))
	{
	   $msg = 'Please Enter City Pincode';
	}
	elseif(!isset ($pharma_data->com_state) || empty($pharma_data->com_state))
	{
		$msg = 'Please Enter State.';
	}
	elseif(!isset ($pharma_data->com_city) ||  empty($pharma_data->com_city))
	{
	  $msg = 'Please Enter City.';
	}
	/*elseif(!isset ($pharma_data->com_name) || empty($pharma_data->com_name))
	{
	   $msg = 'Please Enter Company Name';
	}*/
	elseif(!isset ($pharma_data->user_id) || empty($pharma_data->user_id))
	{
	   $msg = 'Please Enter User Id';
	}

       	if ($msg == '') 
        {
	        $data = $this->pharma->edit_pharma($pharma_data);
		if ($data!=FALSE) 
		{ 
	            $result = array(
	                'Data' => $data,
			// 'Status' => true,
	                'Message' => 'Pharma edited successfully',
	                'Code' => 200
	            );
	        }
	        else 
	        {
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'Error in edit pharma info.',
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
    
    function sync_pharma_post()
    {
	$msg = '';
	$pharma_data=json_decode($this->input->raw_input_stream);
	foreach($pharma_data->data as  $pharma)
	{
		if(isset($pharma->id))
		{
			//echo 'edit'.'<br>';
			//echo $pharma->id.'<br>';
			$data = $this->pharma->sync_edit_pharma($pharma);
		}
		else
		{
			//echo 'add'.'<br>';
			//echo $pharma->id;
			$data = $this->pharma->sync_add_pharma($pharma);
		}
		
	}
	    $result = array(
	        'Data' => new stdClass(),
		// 'Status' => true,
	        'Message' => 'Pharma Save successfully',
	        'Code' => 200
	    );
     
        $this->response($result);
    }
 
}

