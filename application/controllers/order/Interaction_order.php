<?php

defined('BASEPATH') OR exit('No direct script access allowed');



/* 

 * Niraj Kumar

 * Dated: 07/10/2017

 * 

 * This Controller is for Appointment List

 */



class Interaction_order extends Parent_admin_controller {



   function __construct() 

    {

        parent::__construct();

		$loggedData=logged_user_data();

		if(empty($loggedData)){

			redirect('user'); 

		}

        $this->load->model('order/order_model','order');

        $this->load->model('category/category_model','category');

        $this->load->model('product/product_model','product');

    }

    

    public function index(){    

		$data['title'] = "Interaction Order List";

        $data['page_name'] = "Interaction Order List";

		$data['order_list']=array();

		$orderList=$this->order->get_order_list();

		if($orderList!=FALSE)

		{

			$data['order_list'] =$orderList; 

		}

        $this->load->get_view('order/order_list_view',$data);	

    }



	public function complete_order_list(){    

		$data['title'] = "Complete Order List";

        $data['page_name'] = "Complete Order List";

		$data['order_list']=array();

		$orderList=$this->order->get_order_list();

		if($orderList!=FALSE)

		{

			$data['order_list'] =$orderList; 

		}

        $this->load->get_view('order/complete_order_list_view',$data);	

    }

	

	public function cancel_order_list(){    

		$data['title'] = "Cancel Order List";

        $data['page_name'] = "Cancel Order List";

		$data['order_list']=array();

		$orderList=$this->order->get_order_list();

		if($orderList!=FALSE)

		{

			$data['order_list'] =$orderList; 

		}

        $this->load->get_view('order/cancel_order_list_view',$data);	

    }

	

    public function add_order($orderid='',$personId=''){
		$oId= urisafedecode($orderid);
		$pId= urisafedecode($personId);
        $data['order_id']=$oId;
		$data['person_id']=$pId;
		$data['category_list']=array();
		$data['title'] = "Product Details";
        $data['page_name'] = "Product Details";
		$productList= $this->product->get_product_active();
		if($productList!=FALSE)
		{
			$data['product_list'] = $productList; 
		}
		$categoryList= $this->category->get_active_category();
		if($categoryList!=FALSE)
		{
			$data['category_list'] = $categoryList; 
		}
		//$checkOrder=$this->order->check_order($oId,$pId);

		/*if($checkOrder)
		{
			$data['interaction_order_id']=$checkOrder;
			$data['order_details']='';
			$data['order_category']='';
			$data['order_product']='';
			$orderDeatils=$this->order->get_interaction_order($checkOrder);
			if($orderDeatils!=False)
			{
				$data['order_details']=$orderDeatils;
			}
			$orderCategory=$this->order->get_order_category($orderDeatils);
			if($orderCategory!=False)
			{
				$data['order_category']=$orderCategory;
			}
			$orderProduct=$this->order->get_order_product_id($checkOrder);
			if($orderProduct!=False)
			{
				$data['order_product']=$orderProduct;
			}

			$data['action'] = "order/interaction_order/product_select"; 
			$this->load->get_view('order/edit_product_view',$data);
		}
		else{*/
			$data['action'] = "order/interaction_order/add_product_interaction"; 
			$this->load->get_view('order/select_product_view',$data);
		//}
    }

    public function test($orderid='',$personId=''){
        $data['order_id']=$oId;
		$data['person_id']=$pId;
		$data['category_list']=array();
		$data['title'] = "Product Details";
        $data['page_name'] = "Product Details";
		$productList= $this->product->get_product_active();
		if($productList!=FALSE)
		{
			$data['product_list'] = $productList; 
		}
		$categoryList= $this->category->get_active_category();
		if($categoryList!=FALSE)
		{
			$data['category_list'] = $categoryList; 
		}
		$checkOrder=$this->order->check_order($oId,$pId);
	
		$data['action'] = "order/interaction_order/add_product_interaction"; 
		$this->load->get_view('order/test',$data);
		
    }

	
	public function get_product_packsize_list(){
		$catId= $this->input->post('id');
		$options='<option value="">---Select Packsize---</option>';
		$packsize= json_decode($this->order->get_cat_packsize($catId));
		foreach ($packsize as $key => $value) {
			$options=$options.'<option value="'.$value->product_packsize.'">'.$value->packsize_value.'</option>';
		}
		echo $options;
	}

	public function get_product_potency_list(){
		$catId= $this->input->post('id');
		$options='<option value="">---Select Potency---</option>';
		$potency= json_decode($this->order->get_cat_potency($catId));
		foreach ($potency as $key => $value) {
			# code...
				$options=$options.'<option value="'.$value->product_potency.'">'.$value->potency_value.'</option>';
		}
		echo $options;
	}

	public function product_select(){
		$post_data = $this->input->post();
		$data['interaction_order_id']=0;
		$this->form_validation->set_rules('category_list[]', 'Atleast One Category', "required");
		if($this->form_validation->run() == TRUE){
			$productIds=array();
			$data['category_list']=array();
			$data['order_id']=$post_data['order_id'];

			$data['person_id']=$post_data ['person_id'];

			foreach($post_data ['category_list']as $category)

			{

				if(isset($post_data ['product_list_'.$category]))

				{

					foreach($post_data ['product_list_'.$category]as $product)

					{

						$productIds[]=$product;

					}

				}

			}

			

			if(count($productIds)==0)

			{ // no product

			   set_flash('<div class="alert alert-danger alert-dismissible">

				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

				<h4><i class="icon fa fa-ban"></i> Alert!</h4>

				Please select atleast one product.</div>');

				redirect('order/interaction_order/add_order/'.urisafeencode($post_data['order_id']).'/'.urisafeencode($post_data['person_id']));

			}

			$data['title'] = "Product List";

			$data['page_name'] = "Product List";

			$data['product_list'] = $productIds; 

			

			if(isset($post_data['interaction_order_id']))

			{

				$data['action'] = "order/interaction_order/product_discount_edit"; 

				$data['interaction_order_id']=$post_data['interaction_order_id'];

				$this->load->get_view('order/product_discount_view_edit',$data);

			}

			else{

				$data['action'] = "order/interaction_order/product_discount"; 

				$this->load->get_view('order/product_discount_view',$data);

			}

			

		}

		else{

			$this->add_order(urisafeencode($post_data['order_id']),urisafeencode($post_data['person_id']));

		}



    }

	public function add_product_interaction(){
		$post_data = $this->input->post();
		foreach($post_data['pro_mrp_val'] as $k=>$val)
		{
			if($val!='')
			{
				if($post_data['pro_qnty'][$k]==''|| $post_data['pro_dis'][$k]=='')
				{
					set_flash('<div class="alert alert-danger alert-dismissible">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                <h4><i class="icon fa fa-ban"></i> Alert!</h4>Please Select Product quantity and Discount both!!
	              	</div>');
	              	redirect($_SERVER['HTTP_REFERER']);
				}
			}
		}
		$this->form_validation->set_rules('category_list[]', 'Atleast One Category', "required");
		$this->form_validation->set_rules('payment', 'Payment Terms ', "required");

		if(!isset($post_data['product_name']))
		{
			$this->form_validation->set_rules('product_name[]', 'Atleast One Product', "required");
		}

		if(!array_filter($post_data['product_name']))
		{
			$this->form_validation->set_rules('product_name[]', 'Atleast One Product', "required");
		}


		if($this->form_validation->run() == TRUE){

			$success=$this->order->save_product_interaction($post_data);
			if($success==1){  // on sucess
				if(!is_numeric($post_data['person_id']))
				{
					if(substr($post_data['person_id'],0,3)=='doc'){
						redirect('doctors/doctor/doctor_interaction_sales/'.urisafeencode($post_data['person_id']));
					}
					else{
						redirect('pharmacy/pharmacy/pharma_interaction_sales/'.urisafeencode($post_data['person_id']));
					}

				}
				else{
					redirect('dealer/dealer/dealer_interaction_sales/'.urisafeencode($post_data['person_id']));
				}
		   }

		   else{ // on fail

	

				if(!is_numeric($post_data['person_id']))

				{

					if(substr($post_data['person_id'],0,3)=='doc'){

					redirect('doctors/doctor/doctor_interaction_sales/'.urisafeencode($post_data['person_id']));

					}

					else{
						redirect('pharmacy/pharmacy/pharma_interaction_sales/'.urisafeencode($post_data['person_id']));

					}

				}
				else{
					redirect('dealer/dealer/dealer_interaction_sales/'.urisafeencode($post_data['person_id']));
				}

		   }

		}
		else
		{
			set_flash('<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>Please Select atleast Product or Category !!
              </div>');
              redirect($_SERVER['HTTP_REFERER']);
		}
		/*pr($post_data);
		die;*/
	}

	public function product_discount(){

		$post_data = $this->input->post();
		$success=$this->order->save_order($post_data);

		if($success==1){  // on sucess
				if(!is_numeric($post_data['person_id']))
				{

					if(substr($post_data['person_id'],0,3)=='doc'){

					redirect('doctors/doctor/doctor_interaction_sales/'.urisafeencode($post_data['person_id']));

					}
					else{
						redirect('pharmacy/pharmacy/pharma_interaction_sales/'.urisafeencode($post_data['person_id']));
					}
				}
				else{
					redirect('dealer/dealer/dealer_interaction_sales/'.urisafeencode($post_data['person_id']));
				}
		   }

		   else{ // on fail

	
				if(!is_numeric($post_data['person_id']))

				{

					if(substr($post_data['person_id'],0,3)=='doc'){

					redirect('doctors/doctor/doctor_interaction_sales/'.urisafeencode($post_data['person_id']));

					}

					else{
						redirect('pharmacy/pharmacy/pharma_interaction_sales/'.urisafeencode($post_data['person_id']));
					}

				}
				else{
					redirect('dealer/dealer/dealer_interaction_sales/'.urisafeencode($post_data['person_id']));
				}

		   }

    }

	

	public function product_discount_edit(){

		$post_data = $this->input->post();
		$success=$this->order->edit_save_order($post_data);

		if($success==1){  // on sucess
				if(!is_numeric($post_data['person_id']))
				{
					if(substr($post_data['person_id'],0,3)=='doc'){
						redirect('interaction/edit_doc_interaction/'.urisafeencode($post_data['order_id']));
					}

					else{
						redirect('interaction/edit_pharma_interaction/'.urisafeencode($post_data['order_id']));
					}

				}
				else{
					redirect('interaction/edit_dealer_interaction/'.urisafeencode($post_data['order_id']));
				}

			   

		   }

		   else{ // on fail

			   if(!is_numeric($post_data['person_id']))

				{

					if(substr($post_data['person_id'],0,3)=='doc'){
						redirect('doctors/doctor/doctor_interaction_sales/'.urisafeencode($post_data['person_id']));
					}

					else{
						redirect('pharmacy/pharmacy/pharma_interaction_sales/'.urisafeencode($post_data['person_id']));

					}
				}
				else{
					redirect('dealer/dealer/dealer_interaction_sales/'.urisafeencode($post_data['person_id']));
				}
		   }

    }

	

	public function get_product_list(){

		$data= $this->input->post();
		$options='<option value="">---Select Product---</option>';
		$productList= json_decode($this->order->get_cat_product($data));
		foreach ($productList as $key => $value) {
			$options=$options.'<option value="'.$value->product_id.'">'.$value->product_name.'</option>';
		}
		echo $options;
		//echo json_encode($productList);

    }

    public function get_product_details(){
		$productId= $this->input->post('productid');
		$productList= $this->order->get_single_product_details($productId);
		echo json_encode($productList);
		die;
    }
	

	

	public function complete_order($orderid='',$personId=''){

		$oId= urisafedecode($orderid);

		$pId= urisafedecode($personId);

		$success=$this->order->complete_order($oId,$pId);

		if($success==1){  // on sucess
				set_flash('<div class="alert alert-success alert-dismissible">

				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

				<h4><i class="icon fa fa-check"></i> Success!</h4>

				Order Successfully Completed. </div>'); 

				redirect('order/interaction_order/index');
		}
		else{ // on fail
		   set_flash('<div class="alert alert-danger alert-dismissible">
 
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

			<h4><i class="icon fa fa-ban"></i> Alert!</h4>

			Order can not completed.</div>');

			redirect('order/interaction_order/index');

		}

    }

	

	

	public function cancel_order($orderid='',$personId='',$price=''){

		$oId= urisafedecode($orderid);

		$pId= urisafedecode($personId);

		$amount= urisafedecode($price);

		$success=$this->order->cancel_order($oId,$pId,$amount);

		if($success==1){  // on sucess

			

				set_flash('<div class="alert alert-success alert-dismissible">

				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

				<h4><i class="icon fa fa-check"></i> Success!</h4>

				Order Successfully Canceled. </div>'); 

				redirect('order/interaction_order/index');

			   

		}

		else{ // on fail

		   set_flash('<div class="alert alert-danger alert-dismissible">

			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

			<h4><i class="icon fa fa-ban"></i> Alert!</h4>

			Order can not canceled.</div>');

			redirect('order/interaction_order/index');

		}

    }

	

	public function view_order($orderid='',$personId=''){  

		$oId= urisafedecode($orderid);

		$pId= urisafedecode($personId);

		$data['title'] = "Product Deatils View";

        $data['page_name'] = "Product Deatils View";

		$data['order_details']=array();

		$data['order_interaction']=array();

		$orderInteraction=$this->order->get_order($oId,$pId);

		if($orderInteraction!=FALSE)

		{

			$data['order_interaction'] =$orderInteraction; 

		}
		
		$orderDetails=$this->order->get_interaction_order_details($orderInteraction[0]['id']);

		if($orderDetails!=FALSE)

		{

			$data['order_details'] =$orderDetails; 

		}

		

        $this->load->get_view('order/order_details_view',$data);	

    }



}



?>