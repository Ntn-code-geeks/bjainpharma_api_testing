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
    }
    
    public function index(){
		if(logged_user_data()==28 || logged_user_data()==29 ||  logged_user_data()==32 ){
			$data['title']="Add City";
			$data['page_name'] = "Add City";
			$data['action'] = "city/city/import_city";
			$data['city_name'] =$this->city->get_last_city();			$data['state_id'] =$this->city->get_last_city_state();
			
			$this->load->get_view('city/import_city',$data);    
		}
         else{
             redirect('user');
         }
	       
    }
	
	public function import_city(){
/* 		$data['title']="Add City";
		$data['page_name'] = "Add City";
		$data['action'] = "city/city/import_city";
		$this->load->library('form_validation'); */
		/* if (empty($_FILES['file']['name']))
		{
			$this->form_validation->set_rules('file', 'File', 'required');
		}
		if($this->form_validation->run() == FALSE){
			$this->load->get_view('city/import_city',$data);    
		
		}	
		else
		{ */
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
				<h4><i class="icon fa fa-check"></i> Success!</h4>
			   City are imported successfully.</div>'); 
				redirect('city/city');
			}else{
				set_flash('<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-ban"></i> Alert!</h4>
				Empty File !!
				</div>');
				redirect('city/city');
			}
		} else {
			set_flash('<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="icon fa fa-ban"></i> Alert!</h4>
			Sorry file not allowed. Try again !!
			</div>');
			redirect('city/city');
		}
		
		/* } */	
    }
	
	public function add_navigation(){
		if(logged_user_data()==28 || logged_user_data()==29 ||  logged_user_data()==32 ){
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
		if(logged_user_data()==28 || logged_user_data()==29 ||  logged_user_data()==32 ){
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

    
}