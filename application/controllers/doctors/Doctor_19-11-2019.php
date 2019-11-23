<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Niraj Kumar
 * Dated: 04/10/2017
 * 
 * This Controller is for Doctor Master
 */

class Doctor extends Parent_admin_controller {
    
    function __construct() 
    {
        parent::__construct();
        $loggedData=logged_user_data();
            
            if(empty($loggedData)){
                redirect('user'); 
            }
         $this->load->model('doctor/Doctor_model','doctor');
         $this->load->model('dealer/Dealer_model','dealer');
         $this->load->model('users/User_model','user');
		 
        $this->load->model('permission/permission_model','permission'); 
		
        
         
    }
    
    public function index($date='',$city=''){
		$city1=urisafedecode($city);
		$data['date_interact']='';
		if(!is_numeric($date))
		{
			$date1= urisafedecode($date);
			if($date1!='')
			{
			  $data['date_interact']=$date1;
			}
		}
        $data['dealer_list']= $this->dealer->dealer_list(); 
//         pr($data['dealer_list']); die;
        
        $data['users_team'] = $this->permission->user_team(); // show child and boss users
         
        $data['pharma_list']= $this->permission->pharmacy_list(logged_user_cities()); 
		//echo logged_user_cities();
        //pr(sizeof($data['pharma_list'])); die;
        $data['meeting_sample'] = $this->doctor->meeting_sample_master();
        
                 
       // $total_record = $this->doctor->totaldata();
		
        $data['title'] = "Doctor Info";
        $data['page_name']="Doctor Details";

		if($city!='')
		{
			$datablank='';
			$page='';
			$per_page='';
			$data['doctor_data'] = $this->doctor->doctormaster_info($per_page, $page,$datablank,$city1);
		}
		else
		{
			$page='';
			$per_page='';
			$page = ($this->uri->segment(4))? encode($this->uri->segment(4)) : 0;
			$data['doctor_data'] = $this->doctor->doctormaster_info($per_page, $page);
		}
	

    //$data['doctor_data'] = $this->doctor->doctormaster_info($config["per_page"], $page);
       $data['action'] = 'global_search/doc_search';  
       
       $this->load->get_view('doctor_list/doctor_details_view',$data);        
        
    }
    
	
	
	
	 public function doctor_interaction_sales($docid='',$date='',$path='',$city=''){
		 
		$data['date_interact']='';
		$data['order_amount']='';
		$doi=urisafedecode($date);
		$data['city']='';
		$docid=urisafedecode($docid);
		$data['path_info']=0;
		if($doi!='')
		{
			$data['date_interact']=urisafedecode($date);
		}
		if($city!='')
		{
			$data['city']=urisafedecode($city);
		}
		if($path!='')
		{
			$data['path_info']=1;
		}
		$data['old_data']='';
        $data['dealer_list']= $this->dealer->dealer_list(); 
		if($this->doctor->get_log__doctor_data($docid))
		{
			$data['old_data']= $this->doctor->get_log__doctor_data($docid); 
		}
		if($data['old_data'])
		{
			$data['order_amount']=$this->doctor->get_orderamount($docid);
		}
   
        
        $data['users_team'] = $this->permission->user_team(); // show child and boss users
         
        $data['pharma_list']= $this->permission->pharmacy_list(logged_user_cities()); 
		//echo logged_user_cities();
        //pr(sizeof($data['pharma_list'])); die;
        $data['meeting_sample'] = $this->doctor->meeting_sample_master();
        $data['edit_doctor_list']= $this->doctor->edit_doctor($docid);
		/* pr(json_decode($data['edit_doctor_list']));
		die; */
       // $total_record = $this->doctor->totaldata();
		
        $data['title'] = "Doctor Info";
        $data['page_name']="Doctor Details";
		//$data['doctor_data'] = $this->doctor->doctormaster_info($config["per_page"], $page);
		$data['action'] = 'dealer/dealer/dealer_interaction"';  
		$this->load->get_view('doctor_list/doctor_interaction_sales_view',$data);        
        
    }
	
	
	 
	
    // first level inferior view doctors
    public function child1(){$data['date_interact']='';
         $data['users_team'] = $this->permission->user_team(); // show child and boss users
        $childs_doctor = $this->doctor->childs_doctor_data(logged_user_data());
          $data['action'] = 'global_search/doc_search';  
        $childs = json_decode($childs_doctor);
//         pr($childs); die;
        if(!empty($childs->childuserid)){
         
         $data['dealer_list']= $this->dealer->dealer_list(); 
         $data['pharma_list']= $this->permission->pharmacy_list(logged_user_cities()); 
         $data['meeting_sample'] = $this->doctor->meeting_sample_master();
        
         $total_record = $this->doctor->total_child_data($childs->childuserid,$childs->childdocid);
        
         $data['title'] = "Doctor Info";
        $data['page_name']="Doctor Details of Inferior One";
                         $this->load->library("pagination");  
                         
                         $config = array();
        $config["base_url"] = base_url() . "doctors/doctor/child1";
        $config["total_rows"] = $total_record;
        $config["per_page"] = 20;
        $config["uri_segment"] = 4;

        $config['full_tag_open'] = '<div class="pagination" style="margin:0px;"><ul class="pagination">';
			$config['full_tag_close'] = '</ul></div>';
			
			$config['first_link'] = '&laquo; First';
			$config['first_tag_open'] = '<li class="prev page">';
			$config['first_tag_close'] = '</li>';

			$config['last_link'] = 'Last &raquo;';
			$config['last_tag_open'] = '<li class="next page">';
			$config['last_tag_close'] = '</li>';

			$config['next_link'] = 'Next >>';
			$config['next_tag_open'] = '<li class="next page">';
			$config['next_tag_close'] = '</li>';

			$config['prev_link'] = '<< Previous';
			$config['prev_tag_open'] = '<li class="prev page">';
			$config['prev_tag_close'] = '</li>';

			$config['cur_tag_open'] = '<li class="active"><a href="">';
			$config['cur_tag_close'] = '</a></li>';

			$config['num_tag_open'] = '<li class="page">';
			$config['num_tag_close'] = '</li>';
        
        
        $this->pagination->initialize($config);

    $page = ($this->uri->segment(4))? encode($this->uri->segment(4)) : 0;

//         if(!empty($childs->childuserid)){
                           
        $data['doctor_data'] = $this->doctor->childs_doctor($config["per_page"],$page,$childs->childuserid,$childs->childdocid);
//        }
        
         $data["links"] = $this->pagination->create_links();
        
        
          $this->load->get_view('doctor_list/doctor_details_view',$data);
        }
        
    }
    
    // second level inferior view doctors
    public function child2(){$data['date_interact']='';
         $data['users_team'] = $this->permission->user_team(); // show child and boss users
        $childs_doctor = $this->doctor->childs_doctor_data(logged_user_data());
          $data['action'] = 'global_search/doc_search';  
        $childs = json_decode($childs_doctor);
//         pr($childs); die;
        if(!empty($childs->childuserid2)){
         
         $data['dealer_list']= $this->dealer->dealer_list(); 
          $data['pharma_list']= $this->permission->pharmacy_list(logged_user_cities()); 
         $data['meeting_sample'] = $this->doctor->meeting_sample_master();
        
         $total_record = $this->doctor->total_child_data($childs->childuserid2,$childs->childdocid2);
        
         $data['title'] = "Doctor Info";
        $data['page_name']="Doctor Details of Inferior Two";
                         $this->load->library("pagination");  
                         
                         $config = array();
        $config["base_url"] = base_url() . "doctors/doctor/child2";
        $config["total_rows"] = $total_record;
        $config["per_page"] = 20;
        $config["uri_segment"] = 4;

        $config['full_tag_open'] = '<div class="pagination" style="margin:0px;"><ul class="pagination">';
			$config['full_tag_close'] = '</ul></div>';
			
			$config['first_link'] = '&laquo; First';
			$config['first_tag_open'] = '<li class="prev page">';
			$config['first_tag_close'] = '</li>';

			$config['last_link'] = 'Last &raquo;';
			$config['last_tag_open'] = '<li class="next page">';
			$config['last_tag_close'] = '</li>';

			$config['next_link'] = 'Next >>';
			$config['next_tag_open'] = '<li class="next page">';
			$config['next_tag_close'] = '</li>';

			$config['prev_link'] = '<< Previous';
			$config['prev_tag_open'] = '<li class="prev page">';
			$config['prev_tag_close'] = '</li>';

			$config['cur_tag_open'] = '<li class="active"><a href="">';
			$config['cur_tag_close'] = '</a></li>';

			$config['num_tag_open'] = '<li class="page">';
			$config['num_tag_close'] = '</li>';
        
        
        $this->pagination->initialize($config);

    $page = ($this->uri->segment(4))? encode($this->uri->segment(4)) : 0;

//         if(!empty($childs->childuserid)){
                           
        $data['doctor_data'] = $this->doctor->childs_doctor($config["per_page"],$page,$childs->childuserid2,$childs->childdocid2);
//        }
        
         $data["links"] = $this->pagination->create_links();
        
        
          $this->load->get_view('doctor_list/doctor_details_view',$data);
        }
        
    }
    
    
    
     // three level inferior view doctors
    public function child3(){$data['date_interact']='';
		  $data['action'] = 'global_search/doc_search';  
         $data['users_team'] = $this->permission->user_team(); // show child and boss users
        $childs_doctor = $this->doctor->childs_doctor_data(logged_user_data());
        
        $childs = json_decode($childs_doctor);
//         pr($childs); die;
        if(!empty($childs->childuserid3)){
         
         $data['dealer_list']= $this->dealer->dealer_list(); 
          $data['pharma_list']= $this->permission->pharmacy_list(logged_user_cities()); 
         $data['meeting_sample'] = $this->doctor->meeting_sample_master();
        
         $total_record = $this->doctor->total_child_data($childs->childuserid3,$childs->childdocid3);
        
         $data['title'] = "Doctor Info";
        $data['page_name']="Doctor Details of Inferior Three";
                         $this->load->library("pagination");  
                         
                         $config = array();
        $config["base_url"] = base_url() . "doctors/doctor/child3";
        $config["total_rows"] = $total_record;
        $config["per_page"] = 20;
        $config["uri_segment"] = 4;

        $config['full_tag_open'] = '<div class="pagination" style="margin:0px;"><ul class="pagination">';
			$config['full_tag_close'] = '</ul></div>';
			
			$config['first_link'] = '&laquo; First';
			$config['first_tag_open'] = '<li class="prev page">';
			$config['first_tag_close'] = '</li>';

			$config['last_link'] = 'Last &raquo;';
			$config['last_tag_open'] = '<li class="next page">';
			$config['last_tag_close'] = '</li>';

			$config['next_link'] = 'Next >>';
			$config['next_tag_open'] = '<li class="next page">';
			$config['next_tag_close'] = '</li>';

			$config['prev_link'] = '<< Previous';
			$config['prev_tag_open'] = '<li class="prev page">';
			$config['prev_tag_close'] = '</li>';

			$config['cur_tag_open'] = '<li class="active"><a href="">';
			$config['cur_tag_close'] = '</a></li>';

			$config['num_tag_open'] = '<li class="page">';
			$config['num_tag_close'] = '</li>';
        
        
        $this->pagination->initialize($config);

    $page = ($this->uri->segment(4))? encode($this->uri->segment(4)) : 0;

//         if(!empty($childs->childuserid)){
                           
        $data['doctor_data'] = $this->doctor->childs_doctor($config["per_page"],$page,$childs->childuserid3,$childs->childdocid3);
//        }
        
         $data["links"] = $this->pagination->create_links();
        
        
          $this->load->get_view('doctor_list/doctor_details_view',$data);
        }
        
    }
    
      // four level inferior view doctors
    public function child4(){$data['date_interact']='';
		  $data['action'] = 'global_search/doc_search';  
         $data['users_team'] = $this->permission->user_team(); // show child and boss users
        $childs_doctor = $this->doctor->childs_doctor_data(logged_user_data());
        
        $childs = json_decode($childs_doctor);
//         pr($childs); die;
        if(!empty($childs->childuserid4)){
         
         $data['dealer_list']= $this->dealer->dealer_list(); 
          $data['pharma_list']= $this->permission->pharmacy_list(logged_user_cities()); 
         $data['meeting_sample'] = $this->doctor->meeting_sample_master();
        
         $total_record = $this->doctor->total_child_data($childs->childuserid4,$childs->childdocid4);
        
         $data['title'] = "Doctor Info";
        $data['page_name']="Doctor Details of Inferior Four";
                         $this->load->library("pagination");  
                         
                         $config = array();
        $config["base_url"] = base_url() . "doctors/doctor/child4";
        $config["total_rows"] = $total_record;
        $config["per_page"] = 20;
        $config["uri_segment"] = 4;

        $config['full_tag_open'] = '<div class="pagination" style="margin:0px;"><ul class="pagination">';
			$config['full_tag_close'] = '</ul></div>';
			
			$config['first_link'] = '&laquo; First';
			$config['first_tag_open'] = '<li class="prev page">';
			$config['first_tag_close'] = '</li>';

			$config['last_link'] = 'Last &raquo;';
			$config['last_tag_open'] = '<li class="next page">';
			$config['last_tag_close'] = '</li>';

			$config['next_link'] = 'Next >>';
			$config['next_tag_open'] = '<li class="next page">';
			$config['next_tag_close'] = '</li>';

			$config['prev_link'] = '<< Previous';
			$config['prev_tag_open'] = '<li class="prev page">';
			$config['prev_tag_close'] = '</li>';

			$config['cur_tag_open'] = '<li class="active"><a href="">';
			$config['cur_tag_close'] = '</a></li>';

			$config['num_tag_open'] = '<li class="page">';
			$config['num_tag_close'] = '</li>';
        
        
        $this->pagination->initialize($config);

    $page = ($this->uri->segment(4))? encode($this->uri->segment(4)) : 0;

//         if(!empty($childs->childuserid)){
                           
        $data['doctor_data'] = $this->doctor->childs_doctor($config["per_page"],$page,$childs->childuserid4,$childs->childdocid4);
//        }
        
         $data["links"] = $this->pagination->create_links();
        
        
          $this->load->get_view('doctor_list/doctor_details_view',$data);
        }
        
    }

     // five level inferior view doctors
    public function child5(){$data['date_interact']='';
		  $data['action'] = 'global_search/doc_search';  
         $data['users_team'] = $this->permission->user_team(); // show child and boss users
        $childs_doctor = $this->doctor->childs_doctor_data(logged_user_data());
        
        $childs = json_decode($childs_doctor);
//         pr($childs); die;
        if(!empty($childs->childuserid5)){
         
         $data['dealer_list']= $this->dealer->dealer_list(); 
          $data['pharma_list']= $this->permission->pharmacy_list(logged_user_cities()); 
         $data['meeting_sample'] = $this->doctor->meeting_sample_master();
        
         $total_record = $this->doctor->total_child_data($childs->childuserid5,$childs->childdocid5);
        
         $data['title'] = "Doctor Info";
        $data['page_name']="Doctor Details of Inferior Five";
                         $this->load->library("pagination");  
                         
                         $config = array();
        $config["base_url"] = base_url() . "doctors/doctor/child5";
        $config["total_rows"] = $total_record;
        $config["per_page"] = 20;
        $config["uri_segment"] = 4;

        $config['full_tag_open'] = '<div class="pagination" style="margin:0px;"><ul class="pagination">';
			$config['full_tag_close'] = '</ul></div>';
			
			$config['first_link'] = '&laquo; First';
			$config['first_tag_open'] = '<li class="prev page">';
			$config['first_tag_close'] = '</li>';

			$config['last_link'] = 'Last &raquo;';
			$config['last_tag_open'] = '<li class="next page">';
			$config['last_tag_close'] = '</li>';

			$config['next_link'] = 'Next >>';
			$config['next_tag_open'] = '<li class="next page">';
			$config['next_tag_close'] = '</li>';

			$config['prev_link'] = '<< Previous';
			$config['prev_tag_open'] = '<li class="prev page">';
			$config['prev_tag_close'] = '</li>';

			$config['cur_tag_open'] = '<li class="active"><a href="">';
			$config['cur_tag_close'] = '</a></li>';

			$config['num_tag_open'] = '<li class="page">';
			$config['num_tag_close'] = '</li>';
        
        
        $this->pagination->initialize($config);

    $page = ($this->uri->segment(4))? encode($this->uri->segment(4)) : 0;

//         if(!empty($childs->childuserid)){
                           
        $data['doctor_data'] = $this->doctor->childs_doctor($config["per_page"],$page,$childs->childuserid5,$childs->childdocid5);
//        }
        
         $data["links"] = $this->pagination->create_links();
        
        
          $this->load->get_view('doctor_list/doctor_details_view',$data);
        }
        
    }


    public function add_list(){
        
        $data['title']="Add Doctor";
         $data['page_name'] = "Doctor Master";
          $data['action'] = "doctors/doctor/save_doctor";
           $data['dealer_list']= $this->dealer->add_edit_dealer_list();
            $data['pharma_list']= $this->permission->pharmacy_list(logged_user_cities()); 
            $data['statename'] = $this->dealer->state_list();
            
            $data['doc_status_info']=$this->doctor->doc_status(); // status of the doctor (Prescribe/dispense)
            
//           $data['desig_list'] = $this->doctor->designation_list();
           $this->load->get_view('doctor_list/doctor_add_view',$data);
        
        
        
    }
    
    public function save_doctor($id=''){
        /*pr(json_encode($this->input->post()));
        die;*/
          $this->load->library('form_validation');

         $this->form_validation->set_rules('city_pin', 'Code Pincode', 'required');
         $this->form_validation->set_rules('doctor_state', 'Doctor State', 'required');
         $this->form_validation->set_rules('doctor_city', 'Doctor City', 'required');
//           $this->form_validation->set_rules('doctor_num', 'Phone', 'required');
         if(empty($id)){
        $this->form_validation->set_rules('doctor_num', 'Phone', 'required|is_unique[doctor_list.doc_phone]');
       }
       elseif(!empty($id)){
        $this->form_validation->set_rules('doctor_num', 'Phone', 'required');
       
       }
       
        $this->form_validation->set_rules('doctor_name', 'Name', "required");
        
//         if(isset($post_data['dealer_id'])){
        $this->form_validation->set_rules('dealer_id[]', 'Dealer Name', "required");
//         }
        
         if($this->form_validation->run() == TRUE){
               if($id!=''){  // for update
              $sm_id= urisafedecode($id);
           $post_data = $this->input->post();
//            pr($post_data); die;
        
       $success = $this->doctor->add_doctormaster($post_data,$sm_id);
            
               }        
               else{ // for insert
                    $post_data = $this->input->post();
//        pr($post_data); die;
       $success = $this->doctor->add_doctormaster($post_data);
                   
               }
            if($success=1){  // on sucess
           
            set_flash('<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
               Doctor Information Save Successfully.
              </div>'); 
           $this->index();
//          redirect($_SERVER['HTTP_REFERER']);
           
       }
       else{ // on unsuccess
           set_flash('<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
               Doctor information does not Save. Plaese Try again !!
              </div>');
             $this->index();
//          redirect($_SERVER['HTTP_REFERER']);
       }
             
         }
          else{  // for false validation
              
               if($id!=''){  // go to edit if id have
//                redirect($_SERVER['HTTP_REFERER']);
                   $this->edit_doctor($id);
             }else{
//                 redirect($_SERVER['HTTP_REFERER']);
              $this->add_list();
             }
             
        }
        
    }
    
    public function edit_doctor($id=''){
        
         if($id!=''){
             $data['title']="Edit Doctor";
              $data['page_name'] = "Doctor Master";
                        $cm_id= urisafedecode($id);
//                        pr($cm_id); die;
                    $data['action'] = "doctors/doctor/save_doctor/$id";
                      $data['statename'] = $this->dealer->state_list();
              $data['edit_doctor_list']= $this->doctor->edit_doctor($cm_id);
//              pr(json_decode( $data['edit_doctor_list'])); die;
                $data['dealer_list']= $this->dealer->add_edit_dealer_list();
                
                   $data['doc_status_info']=$this->doctor->doc_status(); // status of the doctor (Prescribe/dispense)
                
               $data['pharma_list']= $this->permission->pharmacy_list(logged_user_cities()); 
              $data['meeting_sample'] = $this->doctor->meeting_sample_master();
                $this->load->get_view('doctor_list/doctor_edit_view',$data);
        
                   }
    }
    
    public function del_doctor($id=''){
        
        if($id!=''){
                        $cm_id= urisafedecode($id);
                       
                   $success = del_doctor_row($cm_id,'srm_doctor_list');   
                        
             }
              if($success==1){
           
            set_flash('<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
               Delete Successfully.
              </div>'); 
           
           redirect('doctor/doctor');
           
       }
       else{
           set_flash('<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
               Does not Delete.
              </div>');
            redirect('doctor/doctor');
       }
    }
    
    
    // view interaction with doctor
    public function view_doctor_for_interaction($id=''){
        
          if($id!=''){
             $data['title'] = "View Doctor Interaction";
             $data['page_name'] = "View Doctor Interaction";
             
              $doc_id  = urisafedecode($id);
             
               $data['dealer_list']= $this->dealer->dealer_list(); 
               $data['pharma_list']= $this->permission->pharmacy_list(logged_user_cities()); 
               
                $data['users_team'] = $this->permission->user_team(); // show child and boss users
               
                 $data['edit_doctor_list']= $this->doctor->edit_doctor($doc_id);
                 $data['meeting_sample'] = $this->doctor->meeting_sample_master();
              
                
            $data['interaction_info_doctor'] = $this->doctor->doctor_interaction_view($doc_id); 
                
//              pr(json_decode($data['interaction_info_doctor'])); die;
             
             
             $this->load->get_view('doctor_list/doctor_interaction_view',$data);
        
                   }
    }
      
   
    
     /*
     * @author: Niraj Kumar
     * Dated:01-nov-2017
     * 
     * Active,inactive,suspended,remain
     * 
     */
    
     // inactive to active doctor
    public function inactive_doctor($id=''){
        
        if($id!=''){
             $sm_id = urisafedecode($id);
             $success = $this->doctor->inactive_doctormaster($sm_id);
             
              if($success=1){  // on sucess
           
            set_flash('<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
              Doctor In-Activated !!
              </div>'); 
           
            redirect($_SERVER['HTTP_REFERER']);
           
       }
       else{ // on unsuccess
           set_flash('<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Doctor Does not In-Activat...
              </div>');
            redirect($_SERVER['HTTP_REFERER']);
       }
            
        }  
    }
    
    
     // active to inactive doctor
    public function active_doctor($id=''){
        
        if($id!=''){
             $sm_id = urisafedecode($id);
             $success = $this->doctor->active_doctormaster($sm_id);
             
              if($success=1){  // on sucess
           
            set_flash('<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
              Doctor Activated !!
              </div>'); 
           
            redirect($_SERVER['HTTP_REFERER']);
           
       }
       else{ // on unsuccess
           set_flash('<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Doctor Does not Activated...
              </div>');
            redirect($_SERVER['HTTP_REFERER']);
       }
            
        }  
    }
    
   
   
    
     // Remain to blocked doctor
    public function blocked_doctor($id=''){
        
        if($id!=''){
             $sm_id = urisafedecode($id);
             $success = $this->doctor->blocked_doctormaster($sm_id);
             
              if($success=1){  // on sucess
           
            set_flash('<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
              Doctor Blocked !!
              </div>'); 
           
            redirect($_SERVER['HTTP_REFERER']);
           
       }
       else{ // on unsuccess
           set_flash('<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Doctor Does not Blocked...
              </div>');
            redirect($_SERVER['HTTP_REFERER']);
       }
            
        }  
    }
   
    
     // Blocked to Remain doctor
    public function remain_doctor($id=''){
        
        if($id!=''){
             $sm_id = urisafedecode($id);
             $success = $this->doctor->remain_doctormaster($sm_id);
             
              if($success=1){  // on sucess
           
            set_flash('<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
              Doctor UnBlocked !!
              </div>'); 
           
            redirect($_SERVER['HTTP_REFERER']);
           
       }
       else{ // on unsuccess
           set_flash('<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Doctor Does not UnBlocked...
              </div>');
            redirect($_SERVER['HTTP_REFERER']);
       }
            
        }  
    }
    
    
    // choose dealer/pharmacy for the doctor
    public function add_dealer_pharma(){
        
        $request = $this->input->post();

        $success = $this->doctor->update_dealer_pharma($request);
     
        if($success=1){  // on sucess
           
           echo "Added Sucessfully";           
           
       }
       else{ // on unsuccess
           echo "Not added. Please add dealer/pharmacy using Edit Feature of doctor";  
           
       }
        
    }
    
    // refressh dealer list
    
    public function dealer_pharma_list($doc_id){
      
         
          $data['edit_doctor_list']= json_decode($this->doctor->edit_doctor($doc_id));
//        pr( $data['edit_doctor_list']);
//          echo "<br>";
          $data['dealer_list']= json_decode($this->dealer->dealer_list()); 
//         pr($data['dealer_list']); die;
         
         $data['pharma_list']= $this->permission->pharmacy_list(logged_user_cities()); 
         
          
                foreach($data['dealer_list'] as $k_s => $val_s){
                    
                    /*for dealers id who belogs to this doctor*/
                                if(!empty(( $data['edit_doctor_list']->dealers_id))){   
                                    $dealers_are = explode(',',  $data['edit_doctor_list']->dealers_id);
                                }
                                else{
                                    $dealers_are=array();
                                } 
                               
                    /*end of dealers id who belogs to this doctor */

                     if(in_array($val_s->dealer_id,$dealers_are)){
                    if($val_s->blocked==0){
                 
              echo "<option value='".$val_s->dealer_id."' >".$val_s->dealer_name.','.$val_s->city_name."</option>";
                
              
              
                    } } } 
                
                foreach($data['pharma_list'] as $k_pl => $val_pl){
                    
                    /*for dealers id who belogs to this doctor*/
                                if(!empty(( $data['edit_doctor_list']->dealers_id))){   
                                    $dealers_are = explode(',',  $data['edit_doctor_list']->dealers_id);
                                }
                                else{
                                    $dealers_are=array();
                                }  
                    /*end of dealers id who belogs to this doctor */

                     if(in_array($val_pl['id'],$dealers_are)){
                     if($val_pl['blocked']==0){
              
              echo "<option value='".$val_pl['id']."'>".$val_pl['com_name']."(Sub Dealer)</option>";
                 } } } 
                  
                  
        
    }
	
	public function import_doctor(){
		if(is_admin()){
			$data['user_list']='';
			if($this->user->getUserList()){
				$data['user_list']= $this->user->getUserList(); 
			}
			$data['title']="Import Doctor";
			$data['page_name'] = "Import Doctor";
			$data['action'] = "doctors/doctor/save_bulk_doctor";
			$this->load->get_view('doctor_list/doctor_import_view',$data);
		}
		 else{
			 redirect('user');
		 }

    }
	
	public function save_bulk_doctor(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('user', 'User', 'required');
		if($this->form_validation->run() == FALSE){
			return $this->import_doctor();    
		
		}
		else{
			$mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
			if(in_array($_FILES['file']['type'],$mimes)){
				$filename=$_FILES["file"]["tmp_name"];
				if($_FILES["file"]["size"] > 0)
				{
					$file = fopen($filename, "r");
					$row=1;
					$count=0;
					while (($importdata = fgetcsv($file, 1000000, ",")) !== FALSE)
					{
					   if($row == 1){ $row++; continue; }
					   if($importdata[5] != ''){
					   $id=$this->doctor->doc_last_id()+1;
					   $doctor_id='doc_'.$id;
					   $data = array(
						  'doctor_id' =>$doctor_id,
						  'doc_name' => $importdata[0],
						  'doc_email' => $importdata[6],
						  'doc_phone' => $importdata[5],
						  'doc_address' => $importdata[2],
						  'city_id' => $importdata[3],
						  'state_id' => $importdata[4],
						  'doc_gender' => $importdata[1],
						  'crm_user_id' => $this->input->post('user'),
						  'last_update' => savedate(),
						  'doc_status' =>1,
						  'blocked' =>0,
						 );
						$insert = $this->doctor->doc_import_save($data);
						if(!$insert)
						{
							$count=$count+1;
						}
					   }
					}                    
					fclose($file);
					set_flash('<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-check"></i> Success!</h4>
					Doctor are imported successfully.'.$count.' Duplicate Mobile Found. </div>'); 
					redirect('doctors/doctor/import_doctor');
				}else{
					set_flash('<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-ban"></i> Alert!</h4>
					Empty File !!
					</div>');
					redirect('doctors/doctor/import_doctor');
				}
			} else {
				set_flash('<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-ban"></i> Alert!</h4>
				Sorry file not allowed. Try again !!
				</div>');
				redirect('doctors/doctor/import_doctor');
			}
		}
	
    }
}