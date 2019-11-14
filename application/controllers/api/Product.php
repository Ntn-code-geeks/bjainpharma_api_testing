<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/*

 */



class Product extends REST_Controller {
    function __construct() {
       // Construct the parent class
        parent::__construct();
        $this->load->model('api/product_api_model','product');
       
    }

    function product_list_get()
    {
        # initialize variables
	$msg = '';
       	if ($msg == '') 
        {
	        $data = $this->product->get_product_list();
		if ($data!=FALSE) 
		{ 
	            $result = array(
	                'Data' => $data,
			// 'Status' => true,
	                'Message' => 'Successfully',
	                'Code' => 200
	            );
	        }
	        else 
	        {
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'No Product',
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
    
    function sample_list_get()
    {
        # initialize variables
	$msg = '';
       	if ($msg == '') 
        {
	        $data = $this->product->get_sample_list();
		if ($data!=FALSE) 
		{ 
	            $result = array(
	                'Data' => $data,
			// 'Status' => true,
	                'Message' => 'Successfully',
	                'Code' => 200
	            );
	        }
	        else 
	        {
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'No Product',
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

    function category_list_get(){
		# initialize variables
		$msg = '';
		if ($msg == '')
		{
			$data = $this->product->get_category_list();
			if ($data!=FALSE)
			{
				$result = array(
					'Data' => $data,
					// 'Status' => true,
					'Message' => 'Successfully',
					'Code' => 200
				);
			}
			else
			{
				$result = array(
					'Data' => new stdClass(),
					'Status' => false,
					'Message' => 'No Category',
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

	function product_catewise_post(){
		# initialize variables
		$msg = '';
		$post = array_map('trim', $this->input->post());
		$cat_id  = $post['cate_id'];
		if(!(isset($cat_id)&& !empty($cat_id)))
		{
			$msg='Category Id is required.';
		}
		if ($msg == '')
		{
			$data = $this->product->get_cat_products($cat_id);
			if ($data!=FALSE)
			{
				$result = array(
					'Data' => $data,
					// 'Status' => true,
					'Message' => 'Successfully',
					'Code' => 200
				);
			}
			else
			{
				$result = array(
					'Data' => new stdClass(),
					'Status' => false,
					'Message' => 'No Products',
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

	function interaction_order_post(){
		# initialize variables
		$msg = '';
		$post = json_decode($this->input->raw_input_stream);
//pr($post); die;
		if ($msg == '')
		{
			$dataArr=array();
			$dataArr['crm_user_id']=$post->crm_user_id;
			$dataArr['tot_amt']=$post->tot_amt;
			$dataArr['payment_term']=$post->payment_term;
			$dataArr['payment_mode']=$post->payment_mode;
			$dataArr['payment']=$post->payment;
			$dataArr['person_id']=$post->person_id;
			$dataArr['dealer_id']=$post->dealer_id;
			$dataArr['dealer_mail']=$post->dealer_mail;
			$dataArr['product_details']=$post->product_details;

			$data = $this->product->save_product_interaction($dataArr);
			if ($data!=FALSE)
			{
				$result = array(
					'Data' => $data,
					// 'Status' => true,
					'Message' => 'Successfully saved Order Details.',
					'Code' => 200
				);
			}
			else
			{
				$result = array(
					'Data' => new stdClass(),
					'Status' => false,
					'Message' => 'Error In Save Order Details',
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

}

