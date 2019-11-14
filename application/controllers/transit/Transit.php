<?php

defined('BASEPATH') OR exit('No direct script access allowed');



/* 

 * Niraj Kumar

 * Dated: 07/10/2017

 * 

 * This Controller is for Appointment List

 */



class Transit extends Parent_admin_controller {



   function __construct() 

    {

        parent::__construct();

            $loggedData=logged_user_data();

            

            if(empty($loggedData)){

                redirect('user'); 

            }

        $this->load->model('tour_plan/tour_plan_model','tour');

        $this->load->model('transit/transit_model','transit');

    }

    

    public function index(){    

		$data['title'] = "Transit List";

        $data['page_name'] = "Transit List";

		$data['transit_list']=array();

		$transitList=$this->transit->get_transit_list();

		if($transitList!=FALSE)

		{

			$data['transit_list'] =$this->transit->get_transit_list(); 

		}

        $this->load->get_view('transit/transit_plan_list',$data);	

    }



     public function add_transit(){

        $data['city_list']=array();

		$data['tour_list']='';

		$data['title'] = "Add Transit Plan";

        $data['page_name'] = "Add Transit Plan";

		$cityList= $this->tour->get_city();

		if($cityList!=FALSE)

		{

			$data['city_list'] = $this->tour->get_city(); 

		}

		$data['action'] = "transit/transit/save_transit_plan"; 

        $this->load->get_view('transit/add_transit',$data);

    }



	public function save_transit_plan(){

        $post_data = $this->input->post();

		$ticketAttachment='';

		$billAttachment='';

		$this->load->library('form_validation');

        $this->form_validation->set_rules('source_city', 'Source City', "required");

        $this->form_validation->set_rules('dest_city', 'Destination City', "required");

		$this->form_validation->set_rules('transit_date', 'Transit Date', "required");

		if($this->form_validation->run() == TRUE){

			$mimes = array('jpg','jpeg','png');

			//if(in_array($_FILES['file']['type'],$mimes)||in_array($_FILES['filebill']['type'],$mimes)){

				$check = $this->tour->check_city_path($post_data);

				if($check)

				{

					if (!empty($_FILES['file']['name'])) {

						$filename='file';

						$this->upload_bill_attachment($filename,'transit/transit/add_transit');

						$ticketAttachment=$_FILES['file']['name'];

					}

					if (!empty($_FILES['filebill']['name'])&& $post_data['stay']==1) {

						$filename='filebill';

						$this->upload_bill_attachment($filename,'transit/transit/add_transit');

						$billAttachment=$_FILES['filebill']['name'];

					}

					$success=$this->transit->save_transit($post_data,$ticketAttachment,$billAttachment);

					if($success==1){  // on sucess

					

					

						set_flash('<div class="alert alert-success alert-dismissible">

						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

						<h4><i class="icon fa fa-check"></i> Success!</h4>

						Transit Successfully Added. </div>'); 

						redirect('transit/transit/index');

					   

				   }

				   else{ // on unsuccess

					   set_flash('<div class="alert alert-danger alert-dismissible">

						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

						<h4><i class="icon fa fa-ban"></i> Alert!</h4>

						Transit Not Successfully Added.</div>');

						redirect('transit/transit/save_transit_plan');

				   }

				}

				else{

					set_flash('<div class="alert alert-danger alert-dismissible">

					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

					<h4><i class="icon fa fa-ban"></i> Alert!</h4>You choose wrong path, please contact to admin.</div>');

					redirect('transit/transit/add_transit');

				}

			/* } else {

				set_flash('<div class="alert alert-danger alert-dismissible">

				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

				<h4><i class="icon fa fa-ban"></i> Alert!</h4>

				Sorry file not allowed. Try again !!

				</div>');

				redirect('transit/transit/add_transit');

			} */

		}

		else{

			$this->add_transit();

		}

    }

	

	public function edit_transit_data($id=''){

		$data['city_list']=array();

        $transitid= urisafedecode($id);

		$cityList= $this->tour->get_city();

		if($cityList!=FALSE)

		{

			$data['city_list'] = $this->tour->get_city(); 

		}

		$data['title'] = "Edit Transit Plan";

        $data['page_name'] = "Edit Transit Plan";

		$data['action'] = "transit/transit/update_transit_data"; 

		$data['transit_data']=array();

		$transitList=$this->transit->get_transit_data($transitid);

		if($transitList!=FALSE)

		{

			$data['transit_data'] =$transitList; 

		}

		$this->load->get_view('transit/edit_transit',$data);

    }

	

	public function update_transit_data(){

        $post_data = $this->input->post();

		$ticketAttachment=$post_data['ticattch'];

		$billAttachment=$post_data['billattch'];

		$this->load->library('form_validation');

        $this->form_validation->set_rules('source_city', 'Source City', "required");

        $this->form_validation->set_rules('dest_city', 'Destination City', "required");

        $this->form_validation->set_rules('transit_date', 'Transit Date', "required");

		if($this->form_validation->run() == TRUE){

			$check = $this->tour->check_city_path($post_data);

			if($check)

			{

				$path= 'transit/transit/edit_transit_data/'.urisafeencode($post_data['transit_id']);

				if (!empty($_FILES['file']['name'])) {

					$filename='file';

					$this->upload_bill_attachment($filename,$path);

					$ticketAttachment=$_FILES['file']['name'];

				}

				if (!empty($_FILES['filebill']['name'])&& $post_data['stay']==1) {

					$filename='filebill';

					$this->upload_bill_attachment($filename,$path);

					$billAttachment=$_FILES['filebill']['name'];

				}

				if($post_data['stay']==0){

					$billAttachment='';

				}

				$success=$this->transit->update_transit($post_data,$ticketAttachment,$billAttachment);

				if($success==1){  // on sucess

				

					set_flash('<div class="alert alert-success alert-dismissible">

					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

					<h4><i class="icon fa fa-check"></i> Success!</h4>

					Transit Successfully Updated. </div>'); 

					redirect('transit/transit/index');

				   

			   }

			   else{ // on unsuccess

				   set_flash('<div class="alert alert-danger alert-dismissible">

					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

					<h4><i class="icon fa fa-ban"></i> Alert!</h4>

					Transit Not Successfully Updated.</div>');

					redirect('transit/transit/edit_transit_data/'.urisafeencode($post_data['transit_id']));

			   }

			}

			else{

				set_flash('<div class="alert alert-danger alert-dismissible">

				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

				<h4><i class="icon fa fa-ban"></i> Alert!</h4>You choose wrong path, please contact to admin.</div>');

				redirect('transit/transit/edit_transit_data/'.urisafeencode($post_data['transit_id']));

			}

		}

		else{

			$this->edit_transit_data(urisafeencode($post_data['transit_id']));

		}

    }

	

	public function add_other_transit(){

        $data['city_list']=array();

		$data['tour_list']='';

		$data['title'] = "Add Other Transit Plan";

        $data['page_name'] = "Add Other Transit Plan";

		$cityList= get_all_city();

		if($cityList!=FALSE)

		{

			$data['city_list'] = get_all_city(); 

		}

		$data['action'] = "transit/transit/save_other_transit_plan"; 

        $this->load->get_view('transit/add_other_transit',$data);

    }

	

	public function save_other_transit_plan(){

		$ticketAttachment='';

		$billAttachment='';

        $post_data = $this->input->post();

		$this->load->library('form_validation');

        $this->form_validation->set_rules('source_city', 'Source City', "required");

        $this->form_validation->set_rules('dest_city', 'Destination City', "required");

        $this->form_validation->set_rules('transit_date', 'Transit Date', "required");

		if($this->form_validation->run() == TRUE){

			if (!empty($_FILES['file']['name'])) {

				$filename='file';

				$this->upload_bill_attachment($filename,'transit/transit/save_transit_plan');

				$ticketAttachment=$_FILES['file']['name'];

			}

			if (!empty($_FILES['filebill']['name'])&& $post_data['stay']==1) {

				$filename='filebill';

				$this->upload_bill_attachment($filename,'transit/transit/save_transit_plan');

				$billAttachment=$_FILES['filebill']['name'];

			}

			$success=$this->transit->save_other_transit($post_data,$ticketAttachment,$billAttachment);

			if($success==1){  // on sucess

			

				set_flash('<div class="alert alert-success alert-dismissible">

				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

				<h4><i class="icon fa fa-check"></i> Success!</h4>

				Transit Successfully Added. </div>'); 

				redirect('transit/transit/index');

			   

		   }

		   else{ // on unsuccess

			   set_flash('<div class="alert alert-danger alert-dismissible">

				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

				<h4><i class="icon fa fa-ban"></i> Alert!</h4>

				Transit Not Successfully Added.</div>');

				redirect('transit/transit/save_transit_plan');

		   }

		}

		else{

			$this->add_other_transit();

		}

    }

	

	public function edit_other_transit($id=''){

		$data['city_list']=array();

        $transitid= urisafedecode($id);

		$cityList= get_all_city();

		if($cityList!=FALSE)

		{

			$data['city_list'] =get_all_city();

		}

		$data['title'] = "Edit Other Transit Plan";

        $data['page_name'] = "Edit Other Transit Plan";

		$data['action'] = "transit/transit/update_other_transit_data"; 

		$data['transit_data']=array();

		$transitList=$this->transit->get_transit_data($transitid);

		if($transitList!=FALSE)

		{

			$data['transit_data'] =$transitList; 

		}

		$this->load->get_view('transit/edit_other_transit',$data);

    }

	

	public function update_other_transit_data(){

        $post_data = $this->input->post();

		$ticketAttachment=$post_data['ticattch'];

		$billAttachment=$post_data['billattch'];

		$this->load->library('form_validation');

        $this->form_validation->set_rules('source_city', 'Source City', "required");

        $this->form_validation->set_rules('dest_city', 'Destination City', "required");

        $this->form_validation->set_rules('transit_date', 'Transit Date', "required");

		if($this->form_validation->run() == TRUE){

			$path= 'transit/transit/edit_other_transit/'.urisafeencode($post_data['transit_id']);

			if (!empty($_FILES['file']['name'])) {

				$filename='file';

				$this->upload_bill_attachment($filename,$path);

				$ticketAttachment=$_FILES['file']['name'];

			}

			if (!empty($_FILES['filebill']['name'])&& $post_data['stay']==1) {

				$filename='filebill';

				$this->upload_bill_attachment($filename,$path);

				$billAttachment=$_FILES['filebill']['name'];

			}

			if($post_data['stay']==0){

				$billAttachment='';

			}

			$success=$this->transit->update_other_transit($post_data,$ticketAttachment,$billAttachment);

			if($success==1){  // on sucess

			

				set_flash('<div class="alert alert-success alert-dismissible">

				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

				<h4><i class="icon fa fa-check"></i> Success!</h4>

				Transit Successfully Updated. </div>'); 

				redirect('transit/transit/index');

			   

		   }

		   else{ // on unsuccess

			   set_flash('<div class="alert alert-danger alert-dismissible">

				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

				<h4><i class="icon fa fa-ban"></i> Alert!</h4>

				Transit Not Successfully Updated.</div>');

				redirect('transit/transit/edit_other_transit/'.urisafeencode($post_data['transit_id']));

		   }

		}

		else{

			$this->edit_other_transit(urisafeencode($post_data['transit_id']));

		}

    }

	

	public function upload_bill_attachment($filename,$path){

		

		$upload_path='./assets/proof/';

		$mimes = array('image/jpg','image/jpeg','image/png');

		if(in_array($_FILES[$filename]['type'],$mimes)){

				$new_name = urisafeencode(logged_user_data()).'_'.time().'_'.$_FILES[$filename]['name'];

				$config['file_name'] = $new_name;

				$config['upload_path']  = $upload_path ;

				$config['allowed_types']= 'jpg|png|jpeg';

				$this->load->library('upload', $config);

				if ($this->upload->do_upload($filename)) {

				$data['img']	 = $this->upload->data();

				$data = $this->upload->data();  

				$config['image_library'] = 'gd2';  

				$config['source_image'] = './assets/proof/'.$data["file_name"];  

				$config['create_thumb'] = FALSE;  

				$config['maintain_ratio'] = TRUE;  

				$config['quality'] = '60%';  

				$config['width'] = 200;  

				$config['height'] = 200;  

				$config['new_image'] = './assets/proof/'.$data["file_name"];  

				$this->load->library('image_lib', $config);  

				$this->image_lib->resize();

				}

				else

				{

					set_flash('<div class="alert alert-danger alert-dismissible">

					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

					<h4><i class="icon fa fa-ban"></i> Alert!</h4>

					Sorry Bill can not be uploaded . Try again !!

					</div>');

					redirect($path);

					

				}

			}

			else

			{

				set_flash('<div class="alert alert-danger alert-dismissible">

				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

				<h4><i class="icon fa fa-ban"></i> Alert!</h4>

				Sorry file not allowed. Try again !!

				</div>');

				redirect($path);

			}

	}



}



?>