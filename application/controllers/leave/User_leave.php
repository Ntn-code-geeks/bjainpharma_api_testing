<?php

defined('BASEPATH') OR exit('No direct script access allowed');



/* 

 * Niraj Kumar

 * Dated: 07/10/2017

 * 

 * This Controller is for Appointment List

 */



class User_leave extends Parent_admin_controller {



   function __construct() 

    {

        parent::__construct();

            $loggedData=logged_user_data();

            

            if(empty($loggedData)){

                redirect('user'); 

            }

        $this->load->model('leave/leave_model','leave');

    }

    

    public function index(){    

		$data['title'] = "Apply Leave";

        $data['page_name'] = "Apply Leave";

		$data['action'] = "leave/user_leave/save_user_leave"; 

        $this->load->get_view('user_leave/user_leave_view',$data);

    } 

	

	public function save_user_leave(){    

		$post_data = $this->input->post();

		$result=$this->leave->check_inteaction($post_data);

		if(!$result)

		{

			set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

               You have interaction on that day please change date!!

              </div>');

              redirect($_SERVER['HTTP_REFERER']);

		}

		$this->load->library('form_validation');

        $this->form_validation->set_rules('start_date', 'From date', "required");

        //$this->form_validation->set_rules('end_date', 'To date', "required");

       

		if($this->form_validation->run() == TRUE){

			

			$success=$this->leave->save_leave($post_data);

			if($success=1){  // on sucess

				set_flash('<div class="alert alert-success alert-dismissible">

				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

				<h4><i class="icon fa fa-check"></i> Success!</h4>

				Leave Successfully Applied. </div>'); 

				redirect('leave/user_leave/user_leave_list');

			   

		   }

		   else{ // on unsuccess

			   set_flash('<div class="alert alert-danger alert-dismissible">

				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

				<h4><i class="icon fa fa-ban"></i> Alert!</h4>

				Leave Not Successfully Applied.</div>');

			

				redirect('leave/user_leave/index');

		   }

		}

		else{

			$this->index();

		}

		

    }

	

	public function user_leave_list(){    

		$data['title'] = "Leave List";

        $data['page_name'] = "Leave List";

		$data['action'] = "leave/user_leave/index"; 

		$data['leave_list']=array();

		$leaveList=$this->leave->get_leave_list();

		if($leaveList!=FALSE)

		{

			$data['leave_list'] =$this->leave->get_leave_list(); 

		}

		$this->load->get_view('user_leave/user_leave_list',$data);

    }

	

	public function cancel_leave($id=''){    

		$leaveid= urisafedecode($id);

		$success=$this->leave->cancel_leave_data($leaveid);

		if($success=1){  // on sucess

			set_flash('<div class="alert alert-success alert-dismissible">

			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

			<h4><i class="icon fa fa-check"></i> Success!</h4>

			Leave Successfully cancelled . </div>'); 

			redirect('leave/user_leave/user_leave_list');

		   

		}

		else{ // on unsuccess

		   set_flash('<div class="alert alert-danger alert-dismissible">

			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

			<h4><i class="icon fa fa-ban"></i> Alert!</h4>

			Leave can not cancelled.</div>');

			redirect('leave/user_leave/user_leave_list');

		}

    }

	

	public function edit_leave($id=''){  

		$leaveid= urisafedecode($id);

		$data['title'] = "Edit Leave";

        $data['page_name'] = "Edit Leave";

		$data['action'] = "leave/user_leave/save_edit_data"; 

		$data['leave_data']=array();

		$leaveList=$this->leave->get_leave_data($leaveid);

		if($leaveList!=FALSE)

		{

			$data['leave_data'] =$leaveList; 

		}

		$this->load->get_view('user_leave/user_edit_leave',$data);

    }

	

	public function save_edit_data(){  

		$post_data = $this->input->post();

		$result=$this->leave->check_inteaction($post_data);

		if(!$result)

		{

			set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

               You have interaction on that day please change date!!

              </div>');

              redirect($_SERVER['HTTP_REFERER']);

		}

		$this->load->library('form_validation');

        $this->form_validation->set_rules('start_date', 'From date', "required");

      //  $this->form_validation->set_rules('end_date', 'To date', "required");

		if($this->form_validation->run() == TRUE){

			$success=$this->leave->edit_leave_data($post_data);

			if($success=1){  // on sucess

				set_flash('<div class="alert alert-success alert-dismissible">

				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

				<h4><i class="icon fa fa-check"></i> Success!</h4>

				Leave Successfully Edited. </div>'); 

				redirect('leave/user_leave/user_leave_list');

			   

		   }

		   else{ // on unsuccess

			   set_flash('<div class="alert alert-danger alert-dismissible">

				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

				<h4><i class="icon fa fa-ban"></i> Alert!</h4>

				Leave Not Successfully Edited.</div>');

			

				redirect('leave/user_leave/edit_leave/'.urisafeencode($post_data['leave_id']));

		   }

		}

		else{

            $this->edit_leave(urisafeencode($post_data['leave_id']));

		}

    }

}



?>