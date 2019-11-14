<?php


defined('BASEPATH') OR exit('No direct script access allowed');





/* 


 * Niraj Kumar


 * Dated: 20/02/2018


 * 


 * This Controller is for Doctor Master


 */





class City extends Parent_admin_controller {


    


    function __construct() 


    {


        parent::__construct();


        $loggedData=logged_user_data();


            


            if(empty($loggedData)){


                redirect('user'); 


            }


        $this->load->model('city/City_model','city');
        $this->load->model('dealer/Dealer_model','dealer');


    }


    


    public function index(){


		if(is_admin()){


			$data['title']="Add City";


			$data['page_name'] = "Add City";


			$data['action'] = "city/city/import_city";


			$data['city_name'] =$this->city->get_last_city();
			$data['state_id'] =$this->city->get_last_city_state();


			


			$this->load->get_view('city/import_city',$data);    


		}


         else{


             redirect('user');


         }


	       


    }


	


	public function import_city(){
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
						'state_id' => $importdata[0],
						'city_name' =>strtoupper($importdata[1]),
						'status' =>1,
						'added_date' =>date('Y-m-d H:i:s'),
					);
					$insert = $this->city->insertCity($data);
				}                    
				fclose($file);
				set_flash('<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-check"></i> Success!</h4>City are imported successfully.</div>'); 
				redirect('city/city');
			}else{
				set_flash('<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-ban"></i> Alert!</h4>Empty File !!</div>');
				redirect('city/city');
			}
		}
		else
		{
			set_flash('<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="icon fa fa-ban"></i> Alert!</h4>Sorry file not allowed. Try again !!</div>');
			redirect('city/city');
		}
    }


	


	public function add_navigation(){


		if(is_admin()){


			$data['title']="Add Navigation ID";


			$data['page_name'] = "Add Navigation ID";


			$data['action'] = "city/city/save_navigation";


			$this->load->get_view('city/add_navigation',$data);    


		}


         else{


             redirect('user');


         }


	       


    }


	


	public function save_navigation(){


		if(is_admin()){


			$post_data = $this->input->post();


			$success=$this->city->update_navigation($post_data);


			if($success==1){  // on sucess


			


				set_flash('<div class="alert alert-success alert-dismissible">


				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>


				<h4><i class="icon fa fa-check"></i> Success!</h4>


				Successfully Added. </div>'); 


				redirect('city/city/add_navigation');


			   


		   }


		   else{ // on unsuccess


			   set_flash('<div class="alert alert-danger alert-dismissible">


				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>


				<h4><i class="icon fa fa-ban"></i> Alert!</h4>


				Not Successfully Added.</div>');


				redirect('city/city/add_navigation');


		   }


		}


        else{


             redirect('user');


        }


	       


    }


	public function add_city(){
		if(is_admin()){
			$data['title']="Add City";
			$data['page_name'] = "Add City";
			$data['action'] = "city/city/save_city";
			$data['statename'] = $this->city->get_state_list();
			$this->load->get_view('city/add_city',$data);    
		}
	    else{
            redirect('user');
        }
	}

	public function city_list(){
		if(is_admin()){
		    $data['title'] = "City List ";
		    $data['page_name'] = "City List";
		    $data['city_list']=array();
		    $cityList=$this->city->get_city_list();
		    if($cityList!=FALSE)
		    {
		      $data['city_list'] = $cityList; 
		    }
		    $data['action'] = "city/city/add_city"; 
		    $this->load->get_view('city/city_list',$data);
		}
    	else{
            redirect('user');
        }
    }

    public function save_city(){
		if(is_admin()){
		    $post_data = $this->input->post();
		    $this->load->library('form_validation');
		    $this->form_validation->set_rules('city_name', 'City Name', "required");
		    $this->form_validation->set_rules('state', 'State', "required");
		    $result=check_city_exist($post_data);
		    if($result)
		    {
			    if($this->form_validation->run() == TRUE){
			      $success=$this->city->save_city($post_data);
			      if($success=1){  // on sucess
			        set_flash('<div class="alert alert-success alert-dismissible">
			        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			        <h4><i class="icon fa fa-check"></i> Success!</h4>
			        City Successfully Added. </div>'); 
			        redirect('city/city/city_list');
			      }
			      else{ // on unsuccess
			        set_flash('<div class="alert alert-danger alert-dismissible">
			        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
			        Something went wrong. Please Try Again.</div>');
			        redirect('city/city/add_city');
			      }
			    }
			    else{
			      $this->add_city();
			    }
		    }
		    else
		    {
		    	set_flash('<div class="alert alert-danger alert-dismissible">
		        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
		        City Already Added.</div>');
		        redirect('city/city/add_city');
	    	}
		}
    	else{
            redirect('user');
        }
    }

    public function edit_city($id=''){ 
	    if(is_admin()){ 
		    $cityid= urisafedecode($id);
		    $data['title'] = "Edit City";
		    $data['page_name'] = "Edit City";
		    $data['action'] = "city/city/save_edited_city"; 
		    $data['city_data']=array();
		    $cityData=$this->city->get_city_data($cityid);
		    $data['statename'] = $this->city->get_state_list();
		    if($cityData!=FALSE)
		    {
		      $data['city_data'] =$cityData; 
		    }
		    $this->load->get_view('city/edit_city',$data);
	    }
		else{
	        redirect('user');
	    }
	}

	public function save_edited_city(){  
		if(is_admin()){ 
		    $post_data = $this->input->post();
		    $this->load->library('form_validation');
		    $this->form_validation->set_rules('city_name', 'City Name', "required");
		    $this->form_validation->set_rules('state', 'State', "required");
		    $result=check_city_exist($post_data);
		    if($result)
		    {
			    if($this->form_validation->run() == TRUE){
			      $success=$this->city->edit_city_data($post_data);
			      if($success=1){  // on sucess
			        set_flash('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Success!</h4>City Successfully Edited. </div>'); 
			        redirect('city/city/city_list');
			      }
			      else{ // on unsuccess
			        set_flash('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>City Not Successfully Edited.</div>');
			        redirect('city/city/edit_city/'.urisafeencode($post_data['city_id']));
			      }
			    }
			    else{
			      $this->edit_city(urisafeencode($post_data['city_id']));
			    }
		    }
		    else
		    {
		    	set_flash('<div class="alert alert-danger alert-dismissible">
		        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
		        City Already Added.</div>');
		        redirect('city/city/add_city');
	    	}
	    }
    	else{
            redirect('user');
        }
	}

	public function add_city_list(){
		if(is_admin()){
			$data['title']="Add City Pincode";
			$data['page_name'] = "Add City Pincode";
			$data['action'] = "city/city/import_city_pincode";
			$this->load->get_view('city/pincode_city',$data);    
		}
        else{
            redirect('user');
        }
	}

	public function import_city_pincode(){
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
						'city_code' => $importdata[0],
						'city_pincode' =>strtoupper($importdata[3]),
					);
					$insert = $this->city->update_city_pincode($data);
				}                    
				fclose($file);
				set_flash('<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-check"></i> Success!</h4>City Pincode Change successfully.</div>'); 
				redirect('city/city/add_city_list');
			}else{
				set_flash('<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-ban"></i> Alert!</h4>Empty File !!</div>');
				redirect('city/city/add_city_list');
			}
		}
		else
		{
			set_flash('<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="icon fa fa-ban"></i> Alert!</h4>Sorry file not allowed. Try again !!</div>');
			redirect('city/city/add_city_list');
		}
    }

    public function disabled_city($id=''){    
		$cityid= urisafedecode($id);
		$success=$this->city->disabled_city($cityid);
		if($success=1){  // on sucess
			set_flash('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Success!</h4>City Successfully Disabled. </div>'); 
			redirect('city/city/city_list');
		}
		else{ // on unsuccess
		   set_flash('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>Something went wrong!!.</div>');
			redirect('city/city/city_list');
		}
    }

    public function enable_city($id=''){    
		$cityid= urisafedecode($id);
		$success=$this->city->enable_city($cityid);
		if($success=1){  // on sucess
			set_flash('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Success!</h4>City Successfully Enabled. </div>'); 
			redirect('city/city/city_list');
		}
		else{ // on unsuccess
		   set_flash('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>Something went wrong!!.</div>');
			redirect('city/city/city_list');
		}
    }
}