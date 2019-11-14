<?php

defined('BASEPATH') OR exit('No direct script access allowed');



/* 

 * Niraj Kumar

 * Dated: 06/03/2018

 * 

 * This Controller is for Meeting

 */



class Meeting extends Parent_admin_controller {



   function __construct() 

    {

        parent::__construct();

            $loggedData=logged_user_data();

            

            if(empty($loggedData)){

                redirect('user'); 

            }

        $this->load->model('meeting/meeting_model','meeting');

        $this->load->model('dealer/Dealer_model','dealer');

    }

    

    public function index(){    

		$data['title'] = "Meeting List";

        $data['page_name'] = "Meeting List";

		$data['meeting_list']=array();

		$data['action'] = "meeting/meeting/add_meeting"; 

		$meetingList=$this->meeting->get_meeting_list();

		if($meetingList!=FALSE)

		{

			$data['meeting_list'] =$this->meeting->get_meeting_list();

		}

        $this->load->get_view('meeting/meeting_plan_list',$data);	

    }



     public function add_meeting(){

        $data['city_list']=array();

		$data['tour_list']='';

		$data['title'] = "Add Meeting Plan";

        $data['page_name'] = "Add Meeting Plan";
        $data['meeting_master'] = $this->meeting->get_meeting_master();

		$cityList= get_all_city();

		if($cityList!=FALSE)

		{

			$data['city_list'] = $cityList; 

		}

		$data['action'] = "meeting/meeting/save_meeting_plan"; 

        $this->load->get_view('meeting/add_meeting',$data);

    }



	public function save_meeting_plan(){

        $post_data = $this->input->post();

		 $interactionDate=$post_data['meeting_date'];

		  $result=$this->dealer->checkleave($interactionDate);

		  if(!$result)

		  {

			  set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

               You have taken leave or holiday on that day please change date!!

              </div>');

              redirect($_SERVER['HTTP_REFERER']);

		  }

		

		$this->load->library('form_validation');

        $this->form_validation->set_rules('meeting_type', 'Meeting Type', "required");

        $this->form_validation->set_rules('meeting_city', 'Meeting City', "required");

        $this->form_validation->set_rules('meeting_date', 'Meeting Date', "required");

		if($this->form_validation->run() == TRUE){

			$success=$this->meeting->save_meeting($post_data);

			if($success==1){  // on sucess

				set_flash('<div class="alert alert-success alert-dismissible">

				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

				<h4><i class="icon fa fa-check"></i> Success!</h4>

				Meeting Successfully Added. </div>'); 

				redirect('meeting/meeting/index');

		   }

		   else{ // on unsuccess

			   set_flash('<div class="alert alert-danger alert-dismissible">

				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

				<h4><i class="icon fa fa-ban"></i> Alert!</h4>

				Meeting Not Successfully Added.</div>');

				redirect('meeting/meeting/save_meeting_plan');

		   }

		}

		else{

			$this->add_meeting();

		}

    }

	

	public function edit_meeting_data($id=''){

		$data['city_list']=array();

        $meetingid= urisafedecode($id);
		$data['meeting_master'] = $this->meeting->get_meeting_master();
		$cityList= get_all_city();

		if($cityList!=FALSE)

		{

			$data['city_list'] =get_all_city();

		}

		$data['title'] = "Edit Meeting Plan";

        $data['page_name'] = "Edit Other Meeting Plan";

		$data['action'] = "meeting/meeting/update_meeting_data"; 

		$data['meeting_data']=array();

		$meetingList=$this->meeting->get_meeting_data($meetingid);

		if($meetingList!=FALSE)

		{

			$data['meeting_data'] =$meetingList; 

		}

		$this->load->get_view('meeting/edit_meeting_data',$data);

    }

	

	public function update_meeting_data(){

        $post_data = $this->input->post();

		$interactionDate=$post_data['meeting_date'];

		  $result=$this->dealer->checkleave($interactionDate);

		  if(!$result)

		  {

			  set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

               You have taken leave  or holiday on that day please change date!!

              </div>');

              redirect($_SERVER['HTTP_REFERER']);

		  }

		$this->load->library('form_validation');

        $this->form_validation->set_rules('meeting_type', 'Meeting Type', "required");

        $this->form_validation->set_rules('meeting_city', 'Meeting City', "required");

        $this->form_validation->set_rules('meeting_date', 'Meeting Date', "required");

		if($this->form_validation->run() == TRUE){

			$success=$this->meeting->update_meeting($post_data);

			if($success==1){  // on sucess

			

				set_flash('<div class="alert alert-success alert-dismissible">

				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

				<h4><i class="icon fa fa-check"></i> Success!</h4>

				Meeting Successfully Updated. </div>'); 

				redirect('meeting/meeting/index');

			   

		   }

		   else{ // on unsuccess

			   set_flash('<div class="alert alert-danger alert-dismissible">

				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

				<h4><i class="icon fa fa-ban"></i> Alert!</h4>

				Meeting Not Successfully Updated.</div>');

				redirect('meeting/meeting/edit_meeting_data/'.urisafeencode($post_data['meeting_id']));

		   }

		}

		else{

			$this->edit_meeting_data(urisafeencode($post_data['meeting_id']));

		}

    }
    
    public function interact_with_ho(){
    	$category=array();
    	$all_category=array();
    	$vendorinfo=array();
		$data['title'] = "Interact with HO";
    	$data['page_name'] = "Interact with HO";
    	$data['action'] = "meeting/meeting/send_email_ho";
		$this->load->get_view('meeting/inteact_with_ho',$data);
    }    

    public function send_email_ho(){
    	$post_data = $this->input->post();
    	$sender_email=get_user_deatils(logged_user_data())->email_id;
    	$failedmail=array();
    	$vendoremail=array();
    	$new_name='';
    	$recipient=$post_data['mail_to'];
    	$message=$post_data['body'];
    	$subject=$post_data['subject'];
    	if (!empty($_FILES['file1']['name']))
        {
			$mimes = array('image/jpeg','image/png','image/jpg');
			if(in_array($_FILES['file1']['type'],$mimes))
			{
				$new_name = urisafeencode(logged_user_data()).'_'.time().'_'.$_FILES['file1']['name'];
				$config['file_name'] = $new_name;
				$config['upload_path']  = './assets/proof/';
				$config['allowed_types']= 'jpg|jpeg|png';
				$this->load->library('upload', $config);
				$fnm='file1';
				if (!$this->upload->do_upload($fnm))
				{
					set_flash('<div class="alert alert-danger alert-dismissible">
    				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    				<h4><i class="icon fa fa-ban"></i> Alert!</h4>Something Went wrong. Try again !!</div>');
    				redirect($_SERVER['HTTP_REFERER']);
				}
			}
			else
			{
				set_flash('<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-ban"></i> Alert!</h4>Sorry file not allowed. Try again !!</div>');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
		$this->load->library('email', email_setting());
		$this->email->to($recipient);
		$this->email->from($sender_email);
		$this->email->subject($subject); 
		if($new_name!='')
		{
			$attachpath=base_url().'assets/proof/'.$new_name;
			$this->email->attach( $attachpath);
		}
		$this->email->message($message);
		$result=$this->email->send();
		if($result){
			unlink( './assets/proof/'.$new_name);
			set_flash('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Success!</h4>Mail Successfully Sent.</div>');
			redirect('meeting/meeting/interact_with_ho');
		}
		else{
			unlink( './assets/proof/'.$new_name);
			set_flash('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>Something went wrong please.Try Again !!.</div>');
			redirect('meeting/meeting/interact_with_ho');
		}
    }

}



?>