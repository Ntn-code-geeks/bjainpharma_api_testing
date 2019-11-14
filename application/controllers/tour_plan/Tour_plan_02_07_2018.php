<?php

defined('BASEPATH') OR exit('No direct script access allowed');

 date_default_timezone_set('Asia/Kolkata');

/* 

 * Niraj Kumar

 * Dated: 07/10/2017

 * 

 * This Controller is for Appointment List

 */



class Tour_plan extends Parent_admin_controller {



   function __construct() 

    {

        parent::__construct();

            $loggedData=logged_user_data();

            

            if(empty($loggedData)){

                redirect('user'); 

            }

        $this->load->model('tour_plan/tour_plan_model','tour');

		$this->load->model('users/User_model','user');
		$this->load->model('holiday/Holiday_model','holiday');

    }

    

    public function index(){    
		$data['city_list']=array();
		$assigncity=array();
		$data['tour_list']='';
		$data['title'] = "Tour Plan";
        $data['page_name'] = "Tour Plan";
		$cityList= $this->tour->get_city();
		if($cityList!=FALSE)
		{
			$data['city_list'] =$this->tour->get_city(); 
			foreach ($data['city_list'] as $key => $value) {
				# code...
				// echo $value['id'];
				$assigncity[]=$value['id'];
			}
		}
        $tour = $this->tour->tour_info(); 
		if($tour!=FALSE)
		{
			$data['tour_list'] =$this->tour->tour_info(); 
		}
		$custcity=explode(',',logged_user_cities());
		$data['city_data']=array_unique (array_merge ($custcity, $assigncity));
		/*pr($custcity);
		pr($assigncity);
		pr($data['city_data']);
		die;*/
		$data['action'] = "tour_plan/tour_plan/save_tour_plan"; 
		$data['updateaction'] = "tour_plan/tour_plan/update_tour_plan"; 
//      pr(json_decode($data['ap_list'])); die;
        $this->load->get_view('tour_plan/tour_plan_view',$data);
    }


    public function create_tour(){    
		$data['city_list']=array();
		$assigncity=array();
		$data['tour_list']='';
		$data['title'] = "Tour Plan";
        $data['page_name'] = "Tour Plan";
		$cityList= $this->tour->get_city();
		if($cityList!=FALSE)
		{
			$data['city_list'] =$this->tour->get_city(); 
			foreach ($data['city_list'] as $key => $value) {
				$assigncity[]=$value['id'];
			}
		}
        $tour = $this->tour->tour_info(); 
		if($tour!=FALSE)
		{
			$data['tour_list'] =$this->tour->tour_info(); 
		}

		$holidayList = $this->holiday->get_holiday_user(); 
		if($holidayList!=FALSE)
		{
			$data['holiday_list'] =$holidayList; 
		}
		$custcity=explode(',',logged_user_cities());
		$data['city_data']=array_unique (array_merge ($custcity, $assigncity));
		$data['action'] = "tour_plan/tour_plan/save_bulk_plan"; 
		//$data['updateaction'] = "tour_plan/tour_plan/update_tour_plan"; 
        $this->load->get_view('tour_plan/create_tour_plan',$data);

    }

	public function save_bulk_plan(){
		$post_data = $this->input->post();
		$success = $this->tour->add_bulk_tour($post_data);
		if($success>0){  // on sucess
			set_flash('<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="icon fa fa-check"></i> Success!</h4>'.$success.'Tours Saved Successfully.</div>'); 
			redirect('tour_plan/tour_plan');
		}
		else{ // on unsuccess
			set_flash('<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="icon fa fa-ban"></i> Alert!</h4>Tour Does not Save.</div>');
			redirect('tour_plan/tour_plan');
		}
	}

    public function save_tour_plan(){
        $post_data = $this->input->post();
        $cust=explode(',',logged_user_cities());
        $check = $this->tour->check_city_path($post_data);
        if((in_array($post_data['source_city'],$cust) && in_array($post_data['dest_city'],$cust))|| $check)
        {
        	$success = $this->tour->add_tour($post_data);
			if($success=1){  // on sucess

				set_flash('<div class="alert alert-success alert-dismissible">

				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

				<h4><i class="icon fa fa-check"></i> Success!</h4>Tour Saved Successfully.</div>'); 

				redirect('tour_plan/tour_plan');
		   }

		   else{ // on unsuccess

				set_flash('<div class="alert alert-danger alert-dismissible">

				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

				<h4><i class="icon fa fa-ban"></i> Alert!</h4>Tour Does not Save.</div>');

				redirect('tour_plan/tour_plan');

		   }
        	
        }
		else{

			set_flash('<div class="alert alert-danger alert-dismissible">

			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

			<h4><i class="icon fa fa-ban"></i> Alert!</h4>You choose wrong path, please contact to admin.</div>');

			redirect('tour_plan/tour_plan');

		}

    }

	

	public function update_tour_plan(){

        $post_data = $this->input->post();

		$success = $this->tour->update_tour($post_data);

		if($success=1){  // on sucess

           

            set_flash('<div class="alert alert-success alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-check"></i> Success!</h4>

              Tour Updated Successfully.

              </div>'); 

            redirect('tour_plan/tour_plan');

           

       }

       else{ // on unsuccess

           set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

                Tour Does not Updated.

              </div>');

             redirect('tour_plan/tour_plan');

       }

    }

	

	public function insert_tour_data(){ 

		if(logged_user_data()==28 || logged_user_data()==29 ||  logged_user_data()==32 ){
			$data['title'] = "Add Standard Tour Plan";
			$data['page_name'] = "Add Standard Tour Plan";
			$data['city_list']=array();
			$data['user_list']=array();

			$cityList=get_all_city();

			if($cityList!=FALSE)

			{

				$data['city_list'] =get_all_city(); 

			}

			$userList=get_all_paharma_user();

			if($userList!=FALSE)

			{

				$data['user_list'] =get_all_paharma_user(); 

			}

			$data['action'] = "tour_plan/tour_plan/save_tour_data"; 

	//      pr($data['city_list']); die;

			$this->load->get_view('tour_plan/insert_plan_data',$data);

		}

        else{

            redirect('user');

        }

    }


    public function assign_tp(){ 

		if(logged_user_data()==28 || logged_user_data()==29 ||  logged_user_data()==32 ){

			$data['title'] = "Assign Tour Plan";
			$data['page_name'] = "Assign Tour Plan";
			$data['city_list']=array();
			$data['user_list']=array();
			$cityList=get_all_city();
			if($cityList!=FALSE)
			{
				$data['city_list'] =get_all_city(); 
			}
			$userList=get_all_paharma_user();
			if($userList!=FALSE)
			{
				$data['user_list'] =get_all_paharma_user(); 
			}
			$data['action'] = "tour_plan/tour_plan/save_assign_tp"; 
	//      pr($data['city_list']); die;
			$this->load->get_view('tour_plan/assign_tp_view',$data);
		}
        else{
            redirect('user');
        }
   }




	public function save_assign_tp(){

		if(logged_user_data()==28 || logged_user_data()==29 ||  logged_user_data()==32 ){
			$post_data = $this->input->post();
			$this->load->library('form_validation');
			$this->form_validation->set_rules('user_id[]', 'Pharma User', "required");
			$this->form_validation->set_rules('meeting_date', 'Meeting Date', "required");
			$this->form_validation->set_rules('city_to', 'Destination City', "required");
			//$this->form_validation->set_rules('remark', 'Remark', "required");
			// $this->form_validation->set_rules('city_fare', 'Fare of city', "required|numeric");
			// $this->form_validation->set_rules('city_distance', 'Distance of city', "required|numeric");
			if($this->form_validation->run() == TRUE){
				$success = $this->tour->save_assign_tour_data($post_data);
				if($success=1){  // on sucess
			   		set_flash('<div class="alert alert-success alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h4><i class="icon fa fa-check"></i> Success!</h4>
					  	Successfully Assign.
					  	</div>'); 
					redirect('tour_plan/tour_plan/');
			   }
			   else{ // on unsuccess
					set_flash('<div class="alert alert-danger alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h4><i class="icon fa fa-ban"></i> Alert!</h4>
						Tour Data Does not Save.
						</div>');
					redirect('tour_plan/tour_plan/assign_tp');
			   }
			}
			else
			{
				$this->assign_tp();
			}
		}
        else{
            redirect('user');
        }
    }



	public function save_tour_data(){

		if(logged_user_data()==28 || logged_user_data()==29 ||  logged_user_data()==32 ){

			$post_data = $this->input->post();

			$this->load->library('form_validation');

			$this->form_validation->set_rules('user_id', 'Pharma User', "required");

			$this->form_validation->set_rules('city_from', 'Source City', "required");

			$this->form_validation->set_rules('city_to', 'Destination City', "required");

			//$this->form_validation->set_rules('remark', 'Remark', "required");

			$this->form_validation->set_rules('city_fare', 'Fare of city', "required|numeric");

			$this->form_validation->set_rules('city_distance', 'Distance of city', "required|numeric");

			if($this->form_validation->run() == TRUE){

				$success = $this->tour->save_tour_data($post_data);

				if($success=1){  // on sucess
					set_flash('<div class="alert alert-success alert-dismissible">

						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

						<h4><i class="icon fa fa-check"></i> Success!</h4>

					  Tour Data Saved Successfully.

					  </div>'); 

					redirect('tour_plan/tour_plan/tour_data_list');
			   }

			   else{ // on unsuccess

				   set_flash('<div class="alert alert-danger alert-dismissible">

						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

						<h4><i class="icon fa fa-ban"></i> Alert!</h4>

						Tour Data Does not Save.

					  </div>');

					 redirect('tour_plan/tour_plan/insert_tour_data');

			   }

			}

			else
			{
				$this->insert_tour_data();
			}

		}

        else{

             redirect('user');

        }

    }

	

	public function tour_data_list(){ 

		if(logged_user_data()==28 || logged_user_data()==29 ||  logged_user_data()==32 ){

			$data['title'] = "Standard Tour Plan List";

			$data['page_name'] = "Standard  Tour Plan List";

			$data['tour_list']=array();

			$tourList=$this->tour->get_tour_list();

			if($tourList!=FALSE)

			{

				$data['tour_list'] =$this->tour->get_tour_list(); 

			}

			$data['action'] = "tour_plan/tour_plan/save_tour_data"; 

	//      pr($data['city_list']); die;

			$this->load->get_view('tour_plan/tour_plan_list',$data);

		}

        else{

             redirect('user');

        }

    }

	

	public function edit_tour_data($id=''){

		if(logged_user_data()==28 || logged_user_data()==29 ||  logged_user_data()==32 ){

			$tourId=urisafedecode($id);

			$data['title'] = "Edit Standard Tour Plan";

			$data['page_name'] = "Edit Standard Tour Plan";

			$data['tour_data']=array();

			$data['city_list']=array();

			$data['user_list']=array();

			$cityList=get_all_city();

			if($cityList!=FALSE)

			{

				$data['city_list'] =get_all_city(); 

			}

			$userList=get_all_paharma_user();

			if($userList!=FALSE)

			{

				$data['user_list'] =get_all_paharma_user(); 

			}

			

			$tourData=$this->tour->get_tour_data($tourId);

			if($tourData!=FALSE)

			{

				$data['tour_data'] = $this->tour->get_tour_data($tourId);

			}

			$data['action'] = "tour_plan/tour_plan/edit_save_tour_data/$id";

			$this->load->get_view('tour_plan/edit_plan_data',$data);

		}

        else{

            redirect('user');

        }

	}

	

	public function edit_save_tour_data($id=''){

		if(logged_user_data()==28 || logged_user_data()==29 ||  logged_user_data()==32 ){

			$post_data = $this->input->post();

			$this->load->library('form_validation');

			$this->form_validation->set_rules('user_id', 'Pharma User', "required");

			$this->form_validation->set_rules('city_from', 'Source City', "required");

			$this->form_validation->set_rules('city_to', 'Destination City', "required");

			$this->form_validation->set_rules('city_fare', 'Fare of city', "required|numeric");

			$this->form_validation->set_rules('city_distance', 'Distance of city', "required|numeric");

			if($this->form_validation->run() == TRUE){

				$success = $this->tour->save_tour_data_edit($post_data);

				if($success=1){  // on sucess

				   

					set_flash('<div class="alert alert-success alert-dismissible">

						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

						<h4><i class="icon fa fa-check"></i> Success!</h4>

					  Tour Data Edited Successfully.

					  </div>'); 

					redirect('tour_plan/tour_plan/tour_data_list');

				   

			   }

			   else{ // on unsuccess

				   set_flash('<div class="alert alert-danger alert-dismissible">

						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

						<h4><i class="icon fa fa-ban"></i> Alert!</h4>

						Tour Data Does not Edit.

					  </div>');

					 redirect('tour_plan/tour_plan/insert_tour_data');

			   }	

			}

			else{

				  if($id!=''){  // go to edit if id have

					   $this->edit_tour_data($id);

				 }else{

				  $this->tour_data_list();

				 }

			}

		}

        else{

             redirect('user');

        }

	}

	

	public function email_regarding_tour(){

		$lastday = date('t',strtotime('today'));//last day of month

		$time=strtotime(savedate());

		$subject="Reminder Mail";

		$message='Dear Partner,

            Greetings,



			Many Thanks!

		   ---------------------------- 

			B. Jain Publishers Pvt Ltd

			D 157 Sector 63, Noida

			201301, Uttar Pradesh 

			Tel: +91-120-49 33 333';

			

		$nextMonth = date('m', strtotime('+1 month'));//next month from current date

		//$month=date("m",$time);

		$day=date("d",$time);//current date

		if($day==$lastday-4 ||$day==$lastday-2|| $day==$lastday)

		{

			if($day==$lastday-4 || $day==$lastday-2)//send mail user 4 day and 2 day of last day of month

			{

				$result = $this->tour->get_user_tour($nextMonth);

				if($result){

					foreach($result as $userData)

					{

						try{

							echo $userData['email_id'].'<------>'.$userData['name'];

							//$success =send_email($userData['email_id'], $subject, $message);

						}

						catch(Exception $e)

						{

							// var_dump($e->getMessage());

						}

					}



				}

			}

			elseif($day==$lastday)//send mail user and boss last day of month

			{

				$result = $this->tour->get_user_tour($nextMonth);

				if($result){

					foreach($result as $userData)

					{

						try{

							echo $userData['email_id'].'<------>'.$userData['name'];

							//$success =send_email($userData['email_id'], $subject, $message);

						}

						catch(Exception $e)

						{

							//var_dump($e->getMessage());

						}

						

					}



				}

				try{

					$result = $this->tour->send_email_boss($nextMonth);//will send email to boss only

					$result = $this->tour->send_email_admin($nextMonth);//will send email to admin

				}

				catch(Exception $e)

				{

					//var_dump($e->getMessage());

				}

			}

		}

	}

	

	public function import_tour_data(){

		if(logged_user_data()==28 || logged_user_data()==29 ||  logged_user_data()==32 ){

			$data['user_list']='';

			if($this->user->getUserList()){

				$data['user_list']= $this->user->getUserList(); 

			}

			$data['title']="Import Standard Tour Plan";

			$data['page_name'] = "Import Standard Tour Plan";

			$data['action'] = "tour_plan/tour_plan/import_tour_save";

			$this->load->get_view('tour_plan/tour_plan_import',$data);    

		}

        else{

            redirect('user');

        }

    }

	

	public function import_tour_save(){

		if(logged_user_data()==28 || logged_user_data()==29 ||  logged_user_data()==32 ){

			$this->load->library('form_validation');

			$this->form_validation->set_rules('user', 'User', 'required');

			if($this->form_validation->run() == TRUE){

					$mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');

				if(in_array($_FILES['file']['type'],$mimes)){

					$filename=$_FILES["file"]["tmp_name"];

					if($_FILES["file"]["size"] > 0)

					{

						$file = fopen($filename, "r");

						$row=1;

						while (($importdata = fgetcsv($file, 1000000, ",")) !== FALSE)

						{

						   if($row == 1){ $row++; continue; }

							  $data = array(

								  'pharma_user_id' => $this->input->post('user'),

								  'source_city' =>strtoupper($importdata[0]),

								  'dist_city' =>strtoupper($importdata[1]),

								  'fare' =>strtoupper($importdata[2]),

								  'distance' =>strtoupper($importdata[3]),

								  'remark' =>strtoupper($importdata[4]),

								  'status' =>1,

								  'crm_user_id'=> logged_user_data(),

								  'created_date' =>date('Y-m-d H:i:s'),

								  'updated_date' =>date('Y-m-d H:i:s'),

								);

								$insert = $this->tour->save_bulk_tourdata($data);

						}                    

						fclose($file);

						set_flash('<div class="alert alert-success alert-dismissible">

						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

						<h4><i class="icon fa fa-check"></i> Success!</h4>

					   Data Imported successfully.</div>'); 

						redirect('tour_plan/tour_plan/tour_data_list'); 

					}else{

						set_flash('<div class="alert alert-danger alert-dismissible">

						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

						<h4><i class="icon fa fa-ban"></i> Alert!</h4>

						Empty File !!

						</div>');

						redirect('tour_plan/tour_plan/import_tour_data');

					}

				} else {

					set_flash('<div class="alert alert-danger alert-dismissible">

					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

					<h4><i class="icon fa fa-ban"></i> Alert!</h4>

					Sorry file not allowed. Try again !!

					</div>');

					redirect('tour_plan/tour_plan/import_tour_data');

				} 

			}

			else{

				$this->import_tour_data();

			}

		}

        else{

            redirect('user');

        }

    }

	

	public function get_tour_destination(){

		$post_data = $this->input->post();

		$success = $this->tour->get_tour_dest($post_data);

		echo $success;

		die;

	}



}



?>