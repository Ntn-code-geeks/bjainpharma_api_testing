<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Niraj Kumar
 * Dated: 25/10/2017
 * 
 * This Controller is for Sub Dealer Master
 */

class Pharmacy extends Parent_admin_controller {
    
    function __construct() 
    {
        parent::__construct();
        $loggedData=logged_user_data();
            
            if(empty($loggedData)){
                redirect('user'); 
            }
//         $this->load->model('doctor/Doctor_model','doctor');
			$this->load->model('pharmacy/pharmacy_model','pharmacy');
			$this->load->model('dealer/Dealer_model','dealer');
			 $this->load->model('doctor/Doctor_model','doctor');
			$this->load->model('permission/permission_model','permission'); 
			$this->load->model('users/User_model','user');
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
        $data['meeting_sample'] = $this->pharmacy->meeting_sample_master();
          
         $data['users_team'] = $this->permission->user_team(); // show child and boss users  
        
        
        $data['action'] = 'global_search/pharma_search';  
        $data['title'] = "Retail Sub Dealer Info";
        $data['page_name']="Retail Sub Dealer Details";
   		if($city!='')
		{
		$datablank='';
		$page='';
		$per_page='';
		$data['pharma_data'] = $this->pharmacy->pharmacymaster_info($per_page, $page,$datablank,$city1);
		}
		else
		{
			$page='';
			$per_page='';
			$data['pharma_data'] = $this->pharmacy->pharmacymaster_info($per_page, $page);
		}
       $this->load->get_view('pharmacy_list/pharmacy_details_view',$data);  
        
    }
    
	public function pharma_interaction_sales($pharmaid='',$date='',$path='',$city=''){
		 
		$data['date_interact']='';
		$data['order_amount']='';
		$data['path_info']=0;
		$doi=urisafedecode($date);
		$data['city']='';
		$pharmaid=urisafedecode($pharmaid);
		if($doi!='')
		{
			$data['date_interact']=urisafedecode($date);
		}
		if($city!='')
		{
			$data['city']=urisafedecode($city);
		}
		$data['old_data']='';
		if($this->doctor->get_log__doctor_data($pharmaid))
		{
			$data['old_data']= $this->doctor->get_log__doctor_data($pharmaid); 
		}
		if($data['old_data'])
		{
			$data['order_amount']=$this->doctor->get_orderamount($pharmaid);
		}
		if($path!='')
		{
			$data['path_info']=1;
		}
        
        $data['doc_rel_pharma']=$this->pharmacy->get_pharmacy_doc($pharmaid);
         
        $data['pharma_list']= $this->permission->pharmacy_list(logged_user_cities()); 
		//echo logged_user_cities();
        //pr(sizeof($data['pharma_list'])); die;
        $data['edit_pharmacy_list']= $this->pharmacy->edit_pharmacy($pharmaid);
		
		
		$data['dealer_list']= $this->dealer->dealer_list(); 
        $data['meeting_sample'] = $this->pharmacy->meeting_sample_master();
          
         $data['users_team'] = $this->permission->user_team();
		
        $data['title'] = "Retail Sub Dealer Info";
        $data['page_name']="Retail Sub Dealer Details";
		//$data['doctor_data'] = $this->doctor->doctormaster_info($config["per_page"], $page);
		$data['action'] = 'dealer/dealer/dealer_interaction"';  
		$this->load->get_view('pharmacy_list/pharmacy_interaction_sales_view',$data);        
        
    }
    
    
     // first level inferior view pharmacy
    public function child1(){$data['date_interact']='';
        $data['action'] = 'global_search/pharma_search';  
        $childs_pharma = $this->pharmacy->childs_pharmacy_data(logged_user_data());
        $data['users_team'] = $this->permission->user_team(); // show child and boss users  
        $childs = json_decode($childs_pharma);
//         pr($childs); die;
        if(!empty($childs->childuserid)){
         
          $data['dealer_list']= $this->dealer->dealer_list(); 
        $data['meeting_sample'] = $this->pharmacy->meeting_sample_master();
        
         $total_record = $this->pharmacy->total_child_data($childs->childuserid,$childs->childpharmaid);
        
        $data['title'] = "Retail Sub Dealer Info";
        $data['page_name']="Retail Sub Dealer Details of Inferior One";
                         $this->load->library("pagination");  
                         
                         $config = array();
        $config["base_url"] = base_url() . "pharmacy/pharmacy/child1";
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
                           
        $data['pharma_data'] = $this->pharmacy->childs_pharmacy($config["per_page"],$page,$childs->childuserid,$childs->childpharmaid);
//        }
        
         $data["links"] = $this->pagination->create_links();
        
        
         $this->load->get_view('pharmacy_list/pharmacy_details_view',$data);  
        }
        
    }
    
      // second level inferior view pharmacy
    public function child2(){$data['date_interact']='';
		$data['action'] = 'global_search/pharma_search';  
         $data['users_team'] = $this->permission->user_team(); // show child and boss users  
        $childs_pharma = $this->pharmacy->childs_pharmacy_data(logged_user_data());
        
        $childs = json_decode($childs_pharma);
//         pr($childs); die;
        if(!empty($childs->childuserid2)){
         
        $data['dealer_list']= $this->dealer->dealer_list(); 
        $data['meeting_sample'] = $this->pharmacy->meeting_sample_master();
        
        $total_record = $this->pharmacy->total_child_data($childs->childuserid2,$childs->childpharmaid2);
        
        $data['title'] = "Retail Sub Dealer Info";
        $data['page_name']="Retail Sub Dealer Details of Inferior Two";
        $this->load->library("pagination");  
                         
        $config = array();
        $config["base_url"] = base_url() . "pharmacy/pharmacy/child2";
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
                           
        $data['pharma_data'] = $this->pharmacy->childs_pharmacy($config["per_page"],$page,$childs->childuserid2,$childs->childpharmaid2);
//        }
        
         $data["links"] = $this->pagination->create_links();
        
        
         $this->load->get_view('pharmacy_list/pharmacy_details_view',$data);  
        }
        
    }
    
     // third level inferior view pharmacy
    public function child3(){$data['date_interact']='';
		$data['action'] = 'global_search/pharma_search';  
         $data['users_team'] = $this->permission->user_team(); // show child and boss users  
        $childs_pharma = $this->pharmacy->childs_pharmacy_data(logged_user_data());
        
        $childs = json_decode($childs_pharma);
//         pr($childs); die;
        if(!empty($childs->childuserid3)){
         
          $data['dealer_list']= $this->dealer->dealer_list(); 
        $data['meeting_sample'] = $this->pharmacy->meeting_sample_master();
        
         $total_record = $this->pharmacy->total_child_data($childs->childuserid3,$childs->childpharmaid3);
        
        $data['title'] = "Retail Sub Dealer Info";
        $data['page_name']="Retail Sub Dealer Details of Inferior Three";
                         $this->load->library("pagination");  
                         
        $config = array();
        $config["base_url"] = base_url() . "pharmacy/pharmacy/child3";
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
		// if(!empty($childs->childuserid)){
                           
        $data['pharma_data'] = $this->pharmacy->childs_pharmacy($config["per_page"],$page,$childs->childuserid3,$childs->childpharmaid3);
		// }
        
         $data["links"] = $this->pagination->create_links();
        
        
         $this->load->get_view('pharmacy_list/pharmacy_details_view',$data);  
        }
        
    }
    
    
      // four level inferior view pharmacy
    public function child4(){$data['date_interact']='';
		$data['action'] = 'global_search/pharma_search';  
         $data['users_team'] = $this->permission->user_team(); // show child and boss users  
        $childs_pharma = $this->pharmacy->childs_pharmacy_data(logged_user_data());
        
        $childs = json_decode($childs_pharma);
//         pr($childs); die;
        if(!empty($childs->childuserid4)){
         
        $data['dealer_list']= $this->dealer->dealer_list(); 
        $data['meeting_sample'] = $this->pharmacy->meeting_sample_master();
        
        $total_record = $this->pharmacy->total_child_data($childs->childuserid4,$childs->childpharmaid4);
        
        $data['title'] = "Retail Sub Dealer Info";
        $data['page_name']="Retail Sub Dealer Details of Inferior Four";
                         $this->load->library("pagination");  
                         
        $config = array();
        $config["base_url"] = base_url() . "pharmacy/pharmacy/child4";
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
                           
        $data['pharma_data'] = $this->pharmacy->childs_pharmacy($config["per_page"],$page,$childs->childuserid4,$childs->childpharmaid4);
//        }
        
         $data["links"] = $this->pagination->create_links();
        
        
         $this->load->get_view('pharmacy_list/pharmacy_details_view',$data);  
        }
        
    }
	
	// Five level inferior view pharmacy
    public function child5(){$data['date_interact']='';
		$data['action'] = 'global_search/pharma_search';  
        $data['users_team'] = $this->permission->user_team(); // show child and boss users  
        $childs_pharma = $this->pharmacy->childs_pharmacy_data(logged_user_data());
        
        $childs = json_decode($childs_pharma);
//         pr($childs); die;
        if(!empty($childs->childuserid5)){
         
          $data['dealer_list']= $this->dealer->dealer_list(); 
        $data['meeting_sample'] = $this->pharmacy->meeting_sample_master();
        
         $total_record = $this->pharmacy->total_child_data($childs->childuserid5,$childs->childpharmaid5);
        
        $data['title'] = "Retail Sub Dealer Info";
        $data['page_name']="Retail Sub Dealer Details of Inferior Five";
        $this->load->library("pagination");  
                         
                         $config = array();
        $config["base_url"] = base_url() . "pharmacy/pharmacy/child5";
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

		// if(!empty($childs->childuserid)){
                           
        $data['pharma_data'] = $this->pharmacy->childs_pharmacy($config["per_page"],$page,$childs->childuserid5,$childs->childpharmaid5);
//        }
        
         $data["links"] = $this->pagination->create_links();
        
        
         $this->load->get_view('pharmacy_list/pharmacy_details_view',$data);  
        }
        
    }
    
    
    
    public function add_list(){
		$data['title']="Add Retail Sub Dealer";
		$data['page_name'] = "Retail Sub Dealer Master";
		$data['action'] = "pharmacy/pharmacy/save_pharmacy";
		$data['dealer_list']= $this->dealer->add_edit_dealer_list();   
		$data['statename'] = $this->dealer->state_list();
		// $data['desig_list'] = $this->doctor->designation_list();
		$this->load->get_view('pharmacy_list/pharmacy_add_view',$data);
    }
    
    public function save_pharmacy($id=''){
        
      $post_data = $this->input->post();
           pr(json_encode($post_data)); die;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('city_pin', 'Code Pincode', 'required');
            $this->form_validation->set_rules('com_state', 'Company State', 'required');
            $this->form_validation->set_rules('com_city', 'Company City', 'required');
       
//           $this->form_validation->set_rules('doctor_num', 'Phone', 'required');
        if(empty($id)){
        $this->form_validation->set_rules('com_number', 'Phone', 'required|is_unique[pharmacy_list.company_phone]');
       }
       else{
        $this->form_validation->set_rules('com_number', 'Phone', 'required');
       
       }
        $this->form_validation->set_rules('com_name', 'Company Name', "required");
        
//         if(isset($post_data['dealer_id'])){
        $this->form_validation->set_rules('dealer_id[]', 'Dealer Name', "required");
//         }
      
         if($this->form_validation->run() == TRUE){

              if($id!=''){  // for update
              $pm_id= urisafedecode($id);
              $post_data = $this->input->post();
//            pr($post_data); die;
        
       $success = $this->pharmacy->add_pharmacymaster($post_data,$pm_id);
            
               }        
               else{ // for insert
                    $post_data = $this->input->post();
                   //        pr($post_data); die;
       $success = $this->pharmacy->add_pharmacymaster($post_data);
                   
               }
            if($success=1){  // on sucess
           
            set_flash('<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
               Retail Sub Dealer Information Save Successfully.
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
                   $this->edit_pharmacy($id);
             }else{
//                 redirect($_SERVER['HTTP_REFERER']);
              $this->add_list();
             }
             
        }
        
    }
    
    public function edit_pharmacy($id=''){
        if($id!=''){
			$data['title']="Edit Sub Dealer";
			$data['page_name'] = "Retail Sub Dealer Master";
			$cm_id= urisafedecode($id);
			// pr($cm_id); die;
			$data['action'] = "pharmacy/pharmacy/save_pharmacy/$id";
			$data['statename'] = $this->dealer->state_list();
			$data['edit_pharmacy_list']= $this->pharmacy->edit_pharmacy($cm_id);
			$data['dealer_list']= $this->dealer->add_edit_dealer_list();    
			$data['meeting_sample'] = $this->pharmacy->meeting_sample_master();
			$this->load->get_view('pharmacy_list/pharmacy_edit_view',$data);
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
    
    
    // pharmacy view for interaction
    
    public function view_pharmacy_for_interaction($id=''){
        
        if($id!=''){
             $data['title'] = "View Sub Dealer Interaction";
             $data['page_name'] = "View Sub Dealer Interaction";
             
              $pharma_id  = urisafedecode($id);
             
               $data['dealer_list']= $this->dealer->dealer_list(); 
              
               $data['edit_pharmacy_list']= $this->pharmacy->edit_pharmacy($pharma_id);
                $data['meeting_sample'] = $this->pharmacy->meeting_sample_master();
                
                
                   $data['users_team'] = $this->permission->user_team(); // show child and boss users  
              
                
            $data['interaction_info_pharmacy'] = $this->pharmacy->pharmacy_interaction_view($pharma_id); 
                
//              pr(json_decode($data['dealer_list'])); die;
             
             
             $this->load->get_view('pharmacy_list/pharmacy_interaction_view',$data);
        
                   }
        
    }
    
    
     /*
     * @author: Niraj Kumar
     * Dated:01-nov-2017
     * 
     * Active,inactive,suspended,remain
     * 
     */
    
     // inactive to active pharmacy
    public function inactive_pharmacy($id=''){
        
        if($id!=''){
	             $sm_id = urisafedecode($id);
	             $success = $this->pharmacy->inactive_pharmacymaster($sm_id);
	             
	            if($success=1){  // on sucess
	           
				set_flash('<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-check"></i> Success!</h4>
				Sub Dealer In-Activated !!
				</div>'); 
	            redirect($_SERVER['HTTP_REFERER']);
	           
	       }
	       else{ // on unsuccess
	           set_flash('<div class="alert alert-danger alert-dismissible">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
	                Sub Dealer Does not In-Activated...
	              </div>');
	            redirect($_SERVER['HTTP_REFERER']);
	       }
        }  
    }
    
    
     // active to inactive pharmacy
    public function active_pharmacy($id=''){
        
        if($id!=''){
             $sm_id = urisafedecode($id);
             $success = $this->pharmacy->active_pharmacymaster($sm_id);
             
              if($success=1){  // on sucess
           
            set_flash('<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
              Sub Dealer Activated !!
              </div>'); 
          
            redirect($_SERVER['HTTP_REFERER']);
           
       }
       else{ // on unsuccess
           set_flash('<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Sub Dealer Does not Activated...
              </div>');
            redirect($_SERVER['HTTP_REFERER']);
       }
            
        }  
    }
    
   
   
    
     // Remain to blocked pharmacy
    public function blocked_pharmacy($id=''){
        
        if($id!=''){
			 $sm_id = urisafedecode($id);
			 $success = $this->pharmacy->blocked_pharmacymaster($sm_id);
			 
			  if($success=1){  // on sucess

			    set_flash('<div class="alert alert-success alert-dismissible">
			        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			        <h4><i class="icon fa fa-check"></i> Success!</h4>
			      Sub Dealer Blocked !!
			      </div>'); 
			   
			    redirect($_SERVER['HTTP_REFERER']);
			   
			}
			else{ // on unsuccess
			   set_flash('<div class="alert alert-danger alert-dismissible">
			        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
			        Sub Dealer Does not Blocked...
			      </div>');
			    redirect($_SERVER['HTTP_REFERER']);
			}
        }  
    }
   
    
     // Blocked to Remain pharmacy
    public function remain_pharmacy($id=''){
        
        if($id!=''){
             $sm_id = urisafedecode($id);
             $success = $this->pharmacy->remain_pharmacymaster($sm_id);
             
              if($success=1){  // on sucess
           
            set_flash('<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
              Sub Dealer UnBlocked !!
              </div>'); 
           
            redirect($_SERVER['HTTP_REFERER']);
           
       }
       else{ // on unsuccess
           set_flash('<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Sub Dealer Does not UnBlocked...
              </div>');
            redirect($_SERVER['HTTP_REFERER']);
       }
            
        }  
    }
    
    
    
     // choose dealer for the Sub Dealer
    public function add_dealer_pharma(){
        
        $request = $this->input->post();
//        pr($request); die;
        $success = $this->pharmacy->update_dealer_of_pharma($request);
     
        if($success=1){  // on sucess
           
           echo "Added Sucessfully";           
           
       }
       else{ // on unsuccess
           echo "Not added. Please add dealer/pharmacy using Edit Feature of doctor";  
           
       }
        
    }
    
    // refressh dealer list
    
    public function pharmacy_dealer_list($pharma_id){
        
           $data['edit_pharmacy_list']= json_decode($this->pharmacy->edit_pharmacy($pharma_id));

//           pr($data['edit_pharmacy_list']);
           
              $data['dealer_list']= json_decode($this->dealer->add_edit_dealer_list());  
//         pr($data['dealer_list']); die;
         
           $data['pharma_list']= $this->permission->pharmacy_list(logged_user_cities()); 
                foreach($data['dealer_list'] as $k_s => $val_s){
                    
                    /*for dealers id who belogs to this doctor*/
                                if(!empty(( $data['edit_pharmacy_list']->dealers_id))){   
                                    $dealers_are = explode(',',  $data['edit_pharmacy_list']->dealers_id);
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
                                if(!empty(( $data['edit_pharmacy_list']->dealers_id))){   
                                    $dealers_are = explode(',',  $data['edit_pharmacy_list']->dealers_id);
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
     
	public function import_pharmacy(){
		if(is_admin()){
			$data['user_list']='';
			if($this->user->getUserList()){
				$data['user_list']= $this->user->getUserList(); 
			}
			else{
				$data['user_list']= ''; 
			}
			$data['title']="Import Sub Dealer";
			$data['page_name'] = "Import Sub Dealer";
			$data['action'] = "pharmacy/pharmacy/save_bulk_pharmacy";
			$this->load->get_view('pharmacy_list/pharmacy_import_view',$data);
		}
		else{
			redirect('user');
		}
		
    }
	
	public function save_bulk_pharmacy(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('user', 'User', 'required');
		if($this->form_validation->run() == FALSE){
			return $this->import_pharmacy();    
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
						if($importdata[4] != ''){
							$id=$this->pharmacy->pharmacy_last_id()+1;
							$pharma_id='pharma_'.$id;
							$data = array(
							  'pharma_id' =>$pharma_id,
							  'company_name' => $importdata[0],
							  'company_address' => $importdata[1],
							  'city_id' => $importdata[2],
							  'state_id' => $importdata[3],
							  'company_phone' => $importdata[4],
							  'company_email' => $importdata[5],
							  'crm_user_id' => $this->input->post('user'),
							  'last_update' => savedate(),
							  'pharmacy_status' =>1,
							  'blocked' =>0,
							);
							$insert = $this->pharmacy->pharmacy_import_save($data);
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
					Sub Dealer are imported successfully.'.$count.' Duplicate Mobile Found. </div>');
					redirect('pharmacy/pharmacy/import_pharmacy');
				}else{
					set_flash('<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-ban"></i> Alert!</h4>
					Empty File !!
					</div>');
					redirect('pharmacy/pharmacy/import_pharmacy');
				}
			} else {
				set_flash('<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-ban"></i> Alert!</h4>
				Sorry file not allowed. Try again !!
				</div>');
				redirect('pharmacy/pharmacy/import_pharmacy');
			}
		}
	
    }
    
    
    
}