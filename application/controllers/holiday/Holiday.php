<?php

defined('BASEPATH') OR exit('No direct script access allowed');



/* 

 * Niraj Kumar

 * Dated: 07/10/2017

 * 

 * This Controller is for Appointment List

 */



class Holiday extends Parent_admin_controller {



   function __construct() 

    {

        parent::__construct();

            $loggedData=logged_user_data();

            

            if(empty($loggedData)){

                redirect('user'); 

            }

        $this->load->model('holiday/Holiday_model','holiday');
        $this->load->model('users/User_model','user');
    }

    

    public function index(){    
		$data['title'] = "Holiday List";
        $data['page_name'] = "Holiday List";
		$data['holiday_list']=array();
		$holidayList=$this->holiday->get_holiday_list();
		if($holidayList!=FALSE)
		{
			$data['holiday_list'] =$this->holiday->get_holiday_list(); 
		}
		$data['action'] = "holiday/holiday/add_holiday"; 
        $this->load->get_view('holiday/holiday_list',$data);
    } 

    public function add_holiday(){    
		if(is_admin()){
			$data['user_list']='';
			if($this->user->getUserList()){
				$data['user_list']= $this->user->getUserList(); 
			}
			$data['title'] = "Add Holiday";
	        $data['page_name'] = "Add Holiday";
			$data['action'] = "holiday/holiday/save_holiday"; 
	        $this->load->get_view('holiday/holiday_view',$data);
    	}
		else{
			redirect('user');
		}
    } 

	

	public function save_holiday(){    
		if(is_admin()){
			$post_data = $this->input->post();
			$this->load->library('form_validation');
	        $this->form_validation->set_rules('start_date', 'From date', "required");
	        $this->form_validation->set_rules('user[]', 'User', "required");
	        //$this->form_validation->set_rules('end_date', 'To date', "required");
	     	if($this->form_validation->run() == TRUE){
			$success=$this->holiday->save_holiday($post_data);
			if($success=1){  // on sucess
					set_flash('<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-check"></i> Success!</h4>
					Holiday Successfully Applied. </div>'); 
					redirect('holiday/holiday/');
			   }

			   else{ // on unsuccess
				   set_flash('<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-ban"></i> Alert!</h4>
					Holiday Not Successfully Applied.</div>');
					redirect('holiday/holiday/add_holiday');

			   }

			}

			else{

				$this->add_holiday();

			}
		}
		else{
			redirect('user');
		}

		

    }

	public function edit_holiday($id=''){
		if(is_admin()){ 
			$data['user_list']='';
			if($this->user->getUserList()){
				$data['user_list']= $this->user->getUserList(); 
			} 
			$holidayid= urisafedecode($id);
			$data['title'] = "Edit Leave";
	     	$data['page_name'] = "Edit Leave";
			$data['action'] = "holiday/holiday/save_edit_holiday"; 
			$data['holiday_data']=array();
			$holidayList=$this->holiday->get_holiday_data($holidayid);
			if($holidayList!=FALSE)
			{
				$data['holiday_data'] =$holidayList; 
			}
			$this->load->get_view('holiday/holiday_edit',$data);
		}
		else{
			redirect('user');
		}
    }

	

	public function save_edit_holiday(){  
		$post_data = $this->input->post();
		$this->load->library('form_validation');
	    $this->form_validation->set_rules('start_date', 'From date', "required");
	    $this->form_validation->set_rules('user[]', 'User', "required");
		if($this->form_validation->run() == TRUE){
			$success=$this->holiday->edit_holiday_data($post_data);
			if($success=1){  // on sucess
				set_flash('<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-check"></i> Success!</h4>
				Holiday Successfully Edited. </div>'); 
				redirect('holiday/holiday/');
	   	   }
		   else{ // on unsuccess
			   set_flash('<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-ban"></i> Alert!</h4>
				Holiday Not Successfully Edited.</div>');
				redirect('holiday/holiday/edit_holiday/'.urisafeencode($post_data['holiday_id']));
		   }
		}
		else{
            $this->edit_holiday(urisafeencode($post_data['holiday_id']));
		}
    }
}



?>