<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Niraj Kumar
 * Dated: 10/04/2017
 * 
 * This Controller is for Dealer Master
 */

class Dealer extends Parent_admin_controller {
    
     function __construct() 
    {
        parent::__construct();
        $loggedData=logged_user_data();
        if(empty($loggedData)){
            redirect('user'); 
        }
        $this->load->model('doctor/Doctor_model','doctor');
        $this->load->model('dealer/Dealer_model','dealer');
        $this->load->model('pharmacy/Pharmacy_model','pharmacy');
		    $this->load->model('users/User_model','user');
        $this->load->model('permission/permission_model','permission'); 
    }
      
    public function index(){
		$data['title'] = "Add Dealer";
		$data['page_name'] = "Dealer Master";
		$data['action'] = "dealer/dealer/add";
		$data['action_group'] = "dealer/dealer/add_group_dealer";
		$data['statename'] = $this->dealer->state_list();
		$data['dealer_list']= $this->dealer->dealer_list();
		$this->load->get_view('dealer_list/dealer_add_view',$data);
    }
    
    
    public function add_main_dealer(){
		$data['title'] = "Add C & F";
		$data['page_name'] = "C & F Master";
		//           $data['action'] = "dealer/dealer/add";
		$data['action_group'] = "dealer/dealer/add_group_dealer";
		$data['statename'] = $this->dealer->state_list();
		if(isset($_POST['group_dealer_city'])) {
			$data['cityname'] = $this->dealer->cities($_POST['group_dealer_state']);
		}
		$data['dealer_list']= $this->dealer->dealer_list();
		$this->load->get_view('dealer_list/add_main_dealer_view',$data);
    }
    
    
    
    public function add($id=''){
        /*pr(json_encode($this->input->post()));
        die;*/
        $this->load->library('form_validation');
//		$this->form_validation->set_error_delimiters('<div style="color:red">', '</div>');
       $this->form_validation->set_rules('city_pin', 'Code Pincode', 'required');
       
   if(empty($id)){
        $this->form_validation->set_rules('dealer_num', 'Phone', 'required|is_unique[dealer.d_phone]');
       }
       else{
        $this->form_validation->set_rules('dealer_num', 'Phone', 'required');
       
       }
         
       if($id!='')
       {
          if(is_admin()){
            $this->form_validation->set_rules('sp_code', 'SP Code', 'required');
          }
       }
       else
       {
        $spco=$this->input->post('sp_code');
         if(isset($spco))
         {
          $this->form_validation->set_rules('sp_code', 'SP Code', 'required');
         }
       }
        $this->form_validation->set_rules('dealer_name', 'Dealer Name', "required");
        $this->form_validation->set_rules('dealer_state', 'State', "required");
        $this->form_validation->set_rules('dealer_city', 'City', "required");
        $post_data = $this->input->post();
//         pr($post_data); die;
        
        if($this->form_validation->run() == TRUE){
            
        if($id!=''){  // for update
            
            
              $d_id= urisafedecode($id);
          // $post_data = $this->input->post();
//        pr($post_data); die;
       $success = $this->dealer->add_dealermaster($post_data,$d_id); 
            
          
        }
        else{   // for insert the dealer
       
       $success = $this->dealer->add_dealermaster($post_data);  
           
            
        }
       if($success=TRUE){  // on sucess
//           echo "$success"; die;
            set_flash('<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
               Dealer has been created Successfully.
              </div>'); 
           
           redirect('dealer/dealer/dealer_view');
           
       }
       else{ // on unsuccess
          
           set_flash('<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Dealer does not Save. Please try again with fillup all the required field !!
              </div>');
             redirect('dealer/dealer/dealer_view');
       }
        }
        else
        {  // for false validation
          if($id!='')
          {  // go to edit if id have
            $this->edit_dealer($id);
          }
          else
          {  // go to add if id does not have
            $this->index();
          }
        }
      }
    
   /*code for add Dealer with filter by state, city */  
    public function dealer_city(){
        
        $d_id = $this->input->post();
       
          $data['cityname'] = $this->dealer->cities($d_id['id']);
       
//          pr($data['cityname']); die;
       
//          $result=array();
          echo '<option value="">-Select City-</option>';
          foreach($data['cityname'] as $k=>$value){
             echo '<option value="'.$value['city_id'].'">'.$value['city_name'].'</option>'; 
                           
          }

    }
    


public function dealer_list_for_group(){
     $s_id = $this->input->post();
       $data['dealername'] = $this->dealer->filter_dealer_name($s_id['id']);
        $total= count($data['dealername']);
          foreach($data['dealername'] as $k=>$value){
             echo '<option value="'.$value['dealer_id'].'">'.$value['dealer_name'].'</option>'; 
//             if($total == $k+1){
//                 
//                echo  '<option id="none" value="none">Add School</option>';
//             }
                           
          }
    
}


 /* end code for add dealer with filter by state, city */

// show dealer data with search of dealer
  public function dealer_view($date='',$city=''){     
         
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

	  $data['users_team'] = $this->permission->user_team(); // show child and boss users

	  $data['meeting_sample'] = $this->doctor->meeting_sample_master();

//         pr($data['meeting_sample']);
        $data['title'] = "Dealer Details";
        $data['page_name'] = "Dealer Details";
        
        $data['statename'] = $this->dealer->state_list();
		
		if($city!='')
		{
			$datablank='';
			$page='';
			$per_page='';
			$data['dealer_data'] = $this->dealer->dealermaster_info($per_page, $page,$datablank,$city1);
		}
		else
		{
			$page='';
			$per_page='';
			$page = ($this->uri->segment(4))? encode($this->uri->segment(4)) : 0;
			$data['dealer_data'] = $this->dealer->dealermaster_info($per_page, $page);
		}
//	  pr(json_decode($data['dealer_data'])); die;
        $data['action'] = 'global_search/dealer_search';
        // $data["links"] = $this->pagination->create_links();
		    // pr($data); die;
       $this->load->get_view('dealer_list/dealer_details_view',$data);
        
    }
	
	
	public function dealer_interaction_sales($docid='',$date='',$path='',$city=''){
            
		$data['date_interact']='';
		$data['order_amount']='';
		$data['city']='';
		$doi=urisafedecode($date);
		$docid=urisafedecode($docid);
		$data['path_info']=0;
		if($doi!='')
		{
			$data['date_interact']=urisafedecode($date);
		}
		if($path!='')
		{
			$data['path_info']=1;
		}
		if($city!='')
		{
			$data['city']=urisafedecode($city);
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
		$data['meeting_sample'] = $this->doctor->meeting_sample_master();
		$data['title'] = "Dealer Details";
		$data['page_name'] = "Dealer Details";
		$data['statename'] = $this->dealer->state_list();
		$data['edit_dealer_list']= $this->dealer->edit_dealer($docid);
                
		/* pr(json_decode($data['edit_dealer_list']));
		die; */
		//$data['doctor_data'] = $this->doctor->doctormaster_info($config["per_page"], $page);
                
		$data['action'] = 'dealer/dealer/dealer_interatcion"';
		$this->load->get_view('dealer_list/dealer_interaction_sales_view',$data);        
        
    }
	
	
	
	
	
    
    // show Sub dealer data with search of Sub dealer
    public function main_dealer_view(){     
        // $data['action'] = 'global_search/dealer_search';
        $total_record = $this->dealer->main_dealer_totaldata();
        $data['meeting_sample'] = $this->doctor->meeting_sample_master();
        $data['title'] = "C & F Details";
        $data['page_name'] = "C & F Details";
        $data['statename'] = $this->dealer->state_list();
        $data['dealer_data'] = $this->dealer->main_dealermaster_info();
        $data['action'] = 'global_search/dealer_search';
        //$data["links"] = $this->pagination->create_links();
        
       $this->load->get_view('dealer_list/Main_dealer_details_view',$data);
        
    }
    
    public function edit_dealer($id='')
    {
      if($id!='')
      {
        $data['title'] = "Edit Dealer";
        $data['page_name'] = "Dealer Edit";
        $d_id= urisafedecode($id);
        $data['action'] = "dealer/dealer/add/$id";
        $data['edit_dealer_list']= $this->dealer->edit_dealer($d_id);
        $data['statename'] = $this->dealer->state_list();
        //$data['dealer_list']= $this->dealer->dealer_list();    
        $this->load->get_view('dealer_list/dealer_edit_view',$data);
      }
    }
    
    public function del_dealer($id=''){
        
         if($id!=''){
                        $sm_id= urisafedecode($id);
                       
                   $success = del_dealer_row($sm_id,'dealer');   
                        
             }
              if($success==1){
           
            set_flash('<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
               Delete Successfully.
              </div>'); 
           
           redirect('dealer/dealer_add/dealer_view');
           
       }
       else{
           set_flash('<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
               Does not Delete.
              </div>');
            redirect('dealer/dealer_add/dealer_view');
       }
        
        
    }
    
    public function search_dealer(){
        
        $request = $this->input->post();
        
        if (empty($request)){
           
            $req = $this->session->userdata('table_search');
        }
else 
{
    
    $this->session->set_userdata('table_search',$request['table_search']);
   $req=$request['table_search'];
    
}    
         
        $data['page_name'] = "Search Result";
        $total_record = $this->dealer->totaldata($req);
         $data['statename'] = $this->dealer->state_list();
                         $this->load->library("pagination");  
                         
                         $config = array();
        $config["base_url"] = base_url() . "dealer/dealer_add/search_dealer/$req";
        $config["total_rows"] = $total_record;
        $config["per_page"] = 20;
        $config["uri_segment"] = 5;
//       $choice = $config["total_rows"]/$config["per_page"];
//        $config["num_links"] = round($choice);
        
        
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

    $page = ($this->uri->segment(5))? encode($this->uri->segment(5)) : 0;

        $data['dealer_data'] = $this->dealer->dealermaster_info($config["per_page"], $page,$req);
        $data['action'] = 'dealer/dealer_add/search_dealer';
        $data["links"] = $this->pagination->create_links();
        
       $this->load->get_view('dealer_list/dealer_details_view',$data);
        
        
        
        
    }
    
    // view dealer details with list of doctor who belongs to that dealer
    public function view_dealer_for_doctor($id=''){
        
         if($id!=''){
             $data['title'] = "View Dealer's Doctor";
             $data['page_name'] = "Dealer View";
                        $dm_id= urisafedecode($id);
//                        echo $sm_id; die;
                  $data['action'] = "dealer/dealer/dealer_interaction";
              $data['edit_dealer_list']= $this->dealer->edit_dealer($dm_id);
              
              $dealer_id=json_decode($data['edit_dealer_list']);
              $d_id = $dealer_id->d_id;
              
              
             $data['group_name']= $this->dealer->find_group_for_dealer($d_id);
              
               $data['users_team'] = $this->permission->user_team(); // show child and boss users  
               
               
               $data['dealer_list']= $this->dealer->dealer_list();  
               $data['statename'] = $this->dealer->state_list();
               
                 $data['meeting_sample'] = $this->doctor->meeting_sample_master();
           $data['interaction_info_dealer'] = $this->dealer->interaction_data_dealer($d_id); 
//           
           $data['interaction_info_doctor'] = $this->dealer->interaction_data_doctor($d_id); 
           
          $data['interaction_info_pharmacy'] = $this->dealer->interaction_data_pharmacy($d_id); 
           
//              pr( $data['interaction_info_doctor']); die;
              $data['main_meeting_name'] =$this->dealer->main_meeting_name();
              
//            $data['appointment_of_dealer']= $this->dealer->appointment_of_dealer_list($d_id);  
            
              $data['doctor_of_dealer']= $this->dealer->doctor_of_dealer_list($d_id);
              
              $data['pharmacy_of_dealer']= $this->dealer->pharmacy_of_dealer_list($d_id);
              

                $this->load->get_view('dealer_list/dealer_doctor_view',$data);
        
                   }
        
        
    }
   
    public function add_group_dealer($id=''){
        
        
         $this->load->library('form_validation');
         $this->form_validation->set_rules('city_pin', 'Code Pincode', 'required');
          $this->form_validation->set_rules('group_dealer_state', 'State', 'required');
           $this->form_validation->set_rules('group_dealer_city', 'City', 'required');
       if(empty($id)){
//           echo "mm"; die;
            $this->form_validation->set_rules('group_dealer_num', 'Phone', 'required|is_unique[dealer.d_phone]');
            
//            $this->form_validation->set_rules('doc_navigon', 'Doctor Navigon ID', 'is_unique[dealer.doc_navigate_id]');
       }
       elseif(!empty ($id)){
            $this->form_validation->set_rules('group_dealer_num', 'Phone', 'required');
//            $this->form_validation->set_rules('doc_navigon', 'Doctor Navigon ID', 'required');
       }
    
        
        $this->form_validation->set_rules('group_dealer_name', 'Organization Name', "required");
        
       
         $post_data = $this->input->post();
         
         if(isset($post_data['group_dealer_id'])){
             $this->form_validation->set_rules('group_dealer_id[]', 'Dealer Name', "required");
         }
         
//        pr($post_data); die;
        if($this->form_validation->run() == TRUE){
            
        if($id!=''){  // for update
            
            
              $sm_id= urisafedecode($id);
              
                $nav_id = $post_data['doc_navigon'];
//              echo $post_data['doc_navigon']; die;
             
          // $post_data = $this->input->post();
//                pr($have_unquie); die;
       $success = $this->dealer->add_group_dealermaster($post_data,$sm_id); 
            
          
        }
        else{   // for insert the dealer

       $success = $this->dealer->add_group_dealermaster($post_data);  // for duplicate entry

        }
       if($success=TRUE ){  // on sucess
//           echo "$success"; die;
            set_flash('<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
              C & F info has been Saved Successfully.
              </div>'); 
            redirect('dealer/dealer/main_dealer_view');
//            redirect($_SERVER['HTTP_REFERER']);
           
       }
       else{ // on unsuccess
          
           set_flash('<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
               C & F info does not Saved Successfully. Please try again !!
              </div>');
            redirect('dealer/dealer/main_dealer_view');
//            redirect($_SERVER['HTTP_REFERER']);
       }
        }
        else{  // for false validation
             if($id!=''){  // go to edit if id have
                 $this->edit_group_dealer($id);
                 
             }
             else{  // go to add if id does not have
                 
                 
                 $this->add_main_dealer();
                 
             }
             
        }
        
        
        
    }
    
    
    public function edit_group_dealer($id=''){
      if($id!=''){
        $sm_id= urisafedecode($id);
        $data['title']="Edit C & F";
        $data['page_name'] = "C & F Edit";
        $data['action'] = "dealer/dealer/add_group_dealer/$id";
        $data['edit_dealer_list']= $this->dealer->edit_dealer($sm_id);
        $data['statename'] = $this->dealer->state_list();
        $data['dealer_list']= $this->dealer->dealer_list();    
        $this->load->get_view('dealer_list/dealer_edit_view',$data);
      }
    }

    public function calculate_ta_da($data){
      $result= $this->dealer->insert_ta_da($data);
    }
    
    public function view_group_dealer_for_doctor($id=''){
        if($id!=''){
            
            $data['title'] = "C & F View ";
             $data['page_name'] = "C & F View";
                        $sm_id= urisafedecode($id);
//                        echo $sm_id; die;
//                    $data['action'] = "dealer/dealer_add/add/$id";
              $data['edit_dealer_list']= $this->dealer->edit_dealer($sm_id);
          $data['action'] = "dealer/dealer/dealer_interaction";   
        $data['main_meeting_name'] =$this->dealer->main_meeting_name();
        
         $data['users_team'] = $this->permission->user_team(); // show child and boss users  
        
         $data['statename'] = $this->dealer->state_list();
         $data['dealer_list']= $this->dealer->dealer_list(); 
         
           $data['meeting_sample'] = $this->doctor->meeting_sample_master();

//            $data['group_name']= $this->dealer->find_group_for_dealer($sm_id);
            
            
             $dealers_list= json_decode( $data['edit_dealer_list']);
             
             $dealers_are = explode(',', $dealers_list->dealer_are);
               
                    $data['dealers']=$this->dealer->dealers_info_of_group($sm_id,$dealers_are);
//             pr($data['dealers']);die;
                $data['doctor_of_dealer']= $this->dealer->doctor_of_dealer_list($sm_id);    
          
                $this->load->get_view('dealer_list/dealer_doctor_view',$data);
        
                   }
        
    }
    
    // for dealer interaction information
    public function dealer_interaction(){
//					pr($this->input->post());
//					die;
		if($this->input->post('save')=='secondary_product'){
			$logdata=$this->input->post();
			if($this->dealer->logdata($logdata))
			{
				redirect('order/interaction_order/add_order/""/'.urisafeencode($logdata['dealer_view_id']));
			}
			else{
				set_flash('<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				 <h4><i class="icon fa fa-ban"></i> Alert!</h4>Something went wrong!!
			 	 </div>');
			  	redirect($_SERVER['HTTP_REFERER']);
			}
		}
		elseif($this->input->post('save')=='save_data'){
            $logdata=$this->input->post();
            if( (isset($logdata['stay'])) && (isset($logdata['up'])) ) {
                if ( ($logdata['stay'] == 0) && ($logdata['up'] == 0) ||
					 ($logdata['stay'] == 1) && ($logdata['up'] == 1) ||
					 ($logdata['stay'] == 1) && ($logdata['up'] == 0) ||
					 ($logdata['stay'] == 0) && ($logdata['up'] == 1)
				   )
                {

                    $dealerNumber = '';
                    $dealerEmail = '';
                    $docNumber = '';
                    $docEmail = '';
                    $pharmacyNumber = '';
                    $pharmacyEmail = '';
                    $sms = '';
                    $emailbody = '';
                    $orderData = '';
                    $total_cost = 0;
                    $emailorderdata = '';
                    $emailordt = '';
                    $message = '';
                    $subject = "Interaction Email.";
                    $emailMessage = 'Dear ,
					Greetings,
		
					Many Thanks!
				   ---------------------------- 
					BJAIN Pharmaceutical Pvt Ltd
					A 98 Sector 63, Noida
					201301, Uttar Pradesh 
					Tel: +91-120-49 33 333';
                    $interaction_data = $this->input->post();
                    //pr($interaction_data); die;
                    $senderemail = get_user_email(logged_user_data());

                    //$log_info=$this->dealer->get_log_path($interaction_data);
                    //$data=$this->dealer->get_dealer_data($interaction_data['dealer_id']);

                    if (isset($interaction_data['m_sale']))//only product
                    {
                        $sms = 'Thank you Dear Doctor for your support to B. Jain Pharma. I am happy to receive your order which is mentioned below.';
                        $orderDetails = $this->dealer->get_orderdeatils_user($interaction_data);

                        foreach ($orderDetails as $details) {

                            $orderData = $orderData .' ' .get_product_name($details['product_id']) . '(' .
								get_packsize_name($details['product_id']).',quantity=' . $details['quantity'].'.';

                            $total_cost = $total_cost + $details['net_amount'];

                            $emailordt = $emailordt . '<tr><td>' . get_product_name($details['product_id']) . '(' . get_packsize_name($details['product_id']) . ')</td><td>' . $details['quantity'] . '</td></tr>';

                        }
                        $emailorderdata = ' <h2>Your Order Details</h2> <table cellspacing="0" cellpadding="5" border="1" style="width:100%; border-color:#222;" ><thead><tr><th>Product</th><th>Qty.</th> </tr></thead> 
        <tbody>' . $emailordt . '</tbody></table> ';
                    }

                    if ((isset($interaction_data['telephonic'])) || (isset($interaction_data['meet_or_not'])) ) {
                        $interactionDate = $interaction_data['doi_doc'];
                        $result = $this->dealer->checkleave($interactionDate);
                        if (!$result) {
                            set_flash('<div class="alert alert-danger alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h4><i class="icon fa fa-ban"></i> Alert!</h4>
						You have taken leave  or holiday on that day please change date!!
						</div>');
                            redirect($_SERVER['HTTP_REFERER']);
                        }
                    }

                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('doi_doc', 'Date of Interaction', "required");

                    $this->form_validation->set_rules('dealer_view_id', '', "required");

                    if (isset($interaction_data['doc_id']) && !empty($interaction_data['m_sale'])) {

                        $this->form_validation->set_rules('dealer_id', 'Dealer or Sub Dealer', "required");
                    }
                    if (isset($interaction_data['pharma_id']) && !empty($interaction_data['m_sale'])) {

                        $this->form_validation->set_rules('dealer_id', 'Dealer or Sub Dealer', "required");
                    }

                    if ($this->form_validation->run() == TRUE) {

				if(($interaction_data['telephonic']=='0') || ($interaction_data['telephonic']=='1') ) {
	     			if((empty($interaction_data['m_sale'])) ){
					set_flash('<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-ban"></i> Alert!</h4>
					Add Secondary / Add Product is Mandatory after  - Order Received.
					</div>');
					redirect($_SERVER['HTTP_REFERER']);
					}
				}

				if (!empty($interaction_data['m_sale']) || !empty($interaction_data['m_payment']) || !empty
					($interaction_data['m_stock']) || !empty($interaction_data['m_sample']) || (isset
						($interaction_data['meet_or_not']) || !empty($interaction_data['meet_or_not'])) || (!empty($interaction_data['telephonic'])) ) {

//					(!empty($interaction_data['telephonic']) )
					$id = urisafeencode($interaction_data['dealer_view_id']);
					$success = $this->dealer->save_interaction($interaction_data);
					if ($success == 1) {
						$this->calculate_ta_da($interaction_data);
						if (isset($interaction_data['doc_name'])) {
							//for doctor side
							if (isset($interaction_data['dealer_id'])) {
								if (is_numeric($interaction_data['dealer_id'])) {
									//for dealer;
									$data = $this->dealer->get_dealer_data($interaction_data['dealer_id']);
									if ($data != FALSE) {
										$dealerNumber = $data->d_phone;
										$dealerEmail = $data->d_email;
									}
								} else {
									//for pharmacy;
									$data = $this->pharmacy->get_pharmacy_data($interaction_data['dealer_id']);
									if ($data != FALSE) {
										$dealerNumber = $data->company_phone;
										$dealerEmail = $data->company_email;
									}
								}
							}
							$docdata = $this->doctor->get_doctor_data($interaction_data['doc_id']);
							if ($docdata != FALSE) {
								$docNumber = $docdata->doc_phone;
								$docEmail = $docdata->doc_email;
							}
							//send_msg('1','8604111305','8604111305');
							//	send_msg($message,$docNumber,$dealerNumber);//send message to pharmacy/dealer and doctor
							try {
								//send_email('niraj@bjain.com', $subject, $message);
								if (isset($interaction_data['meet_or_not'])) {
									if ($interaction_data['meet_or_not'] == 1) {
										# code...

										$sms = 'Thank you Dear Doctor for your valuable time. We look forward to your kind support for B. Jain’s Product.';//but no sale or sample
										$emailbody = '<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{ margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="' . base_url() . '/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
			  <h3>Dear,</h3> <p>' . $sms . '</p><p><i>This is an auto generated email.</i></p>
			  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">' . get_user_name(logged_user_data()) . '<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
//                    echo $sms; die;
										send_msg($sms, $docNumber);
									}
									else {
										$sms = 'Doctor I visited your clinic today but was unable to meet you. May I request you for a suitable time for a meeting when I can see you.';
										$emailbody = '<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;} .content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
			  margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="' . base_url() . '/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
			  <h3>Dear,</h3> <p>' . $sms . '</p><p><i>This is an auto generated email.</i></p>
			  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">' . get_user_name(logged_user_data()) . '<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
										send_msg($sms, $docNumber);
									}
								} else // for sale
								{
									if (isset($interaction_data['m_sale']) && isset($interaction_data['m_sample'])) {
									$sms = 'Thank you Dear Doctor for your support to B. Jain Pharma. Please give your valuable feedback for provided samples. I am happy to receive your order which is mentioned below.';
										$sms1 = $sms;
										$sms = $sms . ' ' . $orderData;
										$emailbody = '<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
			 margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="' . base_url() . '/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
		  <h3>Dear,</h3> <p>' . $sms1 . '</p>' . $emailorderdata . '<p><i>This is an auto generated email.</i></p>
		  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">' . get_user_name(logged_user_data()) . '<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';


										$dealerSms = 'Dear Dealer/Sub Dealer, we have received an order from Dr.' . $interaction_data['doc_name'] . '  Kindly deliver at mentioned time and discount.The order details are mentioned below. ' . $orderData;

										$dealerSms1 = 'Dear Dealer/Sub Dealer, we have received an order from Dr.' . $interaction_data['doc_name'] . '  Kindly deliver at mentioned time and discount.The order details are mentioned below. ';

										$dealeremailbody = '<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
			 margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="' . base_url() . '/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
		  <h3>Dear,</h3> <p>' . $dealerSms1 . '</p>' . $emailorderdata . '<p><i>This is an auto generated email.</i></p>
		  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">' . get_user_name(logged_user_data()) . '<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
										/*Dealer message or email*/
										if ($interaction_data['dealer_mail'] == 1) {
											send_msg($dealerSms, $dealerNumber);
											//send_msg($dealerSms,'7838359383');
											if ($dealerEmail != '') {
												$success = send_email($dealerEmail, $senderemail, $subject, $dealeremailbody);//send message to pharmacy/dealer
												// $success =send_email('android@bjain.com', $senderemail, $subject, $dealeremailbody);
											}
										}
									}
									else if (isset($interaction_data['m_sample']))// only sample
									{
									$sms = 'Thank you Dear Doctor for your valuable time. Kindly give your feedback for samples.';
									$emailbody = '<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
	  margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="' . base_url() . '/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
	  <h3>Dear,</h3> <p>' . $sms . '</p><p><i>This is an auto generated email.</i></p>
	  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">' . get_user_name(logged_user_data()) . '<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
									} else if (isset($interaction_data['m_sale']))//only product
									{
										$sms = 'Thank you Dear Doctor for your support to B. Jain Pharma. I am happy to receive your order which is mentioned below.';
										$sms1 = $sms;
										$sms = $sms . ' ' . $orderData;
										$emailbody = '<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
			 margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="' . base_url() . '/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
		  <h3>Dear,</h3> <p>' . $sms1 . '</p>' . $emailorderdata . '<p><i>This is an auto generated email.</i></p>
		  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">' . get_user_name(logged_user_data()) . '<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';


							$dealerSms = 'Dear Dealer/Sub Dealer, we have received an order from Dr.' . $interaction_data['doc_name'] . '  Kindly deliver at mentioned time and discount.The order details are mentioned below. ' . $orderData;

							$dealerSms1 = 'Dear Dealer/Sub Dealer, we have received an order from Dr.' . $interaction_data['doc_name'] . '  Kindly deliver at mentioned time and discount.The order details are mentioned below. ';

										$dealeremailbody = '<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
			 margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="' . base_url() . '/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
		  <h3>Dear,</h3> <p>' . $dealerSms1 . '</p>' . $emailorderdata . '<p><i>This is an auto generated email.</i></p>
		  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">' . get_user_name(logged_user_data()) . '<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
										// send_msg($dealerSms,'7838359383');
										/*Dealer */
										if ($interaction_data['dealer_mail'] == 1) {
											send_msg($dealerSms, $dealerNumber);
											if ($dealerEmail != '') {
												$success = send_email($dealerEmail, $senderemail, $subject, $dealeremailbody);//send message to pharmacy/dealer
												//$success =send_email('android@bjain.com', $senderemail, $subject, $dealeremailbody);
											}
										}
									}


								}
								//send_msg($sms,'8604111305');
								send_msg($sms, $docNumber);
								if ($docEmail != '') {
									$success = send_email($docEmail, $senderemail, $subject, $emailbody);//send message to doctor	//send message to doctor
									//send_email('niraj@bjain.com', $senderemail, $subject, $emailbody);
								}
							}
							catch (Exception $e) {
								set_flash('<div class="alert alert-danger alert-dismissible">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h4><i class="icon fa fa-ban"></i> Alert!</h4>
							   Something went wrong.
							  </div>');
								redirect($_SERVER['HTTP_REFERER']);
							}

						}
						elseif (isset($interaction_data['pharma_id'])) {

							//for Pharma side
							if (isset($interaction_data['dealer_id'])) {
								/* $data=$this->dealer->get_dealer_data($interaction_data['dealer_id']);
										   $dealerNumber=$data->d_phone;
										   $dealerEmail=$data->d_email;
									   }*/
								if (is_numeric($interaction_data['dealer_id'])) {
									//for dealer;
									$data = $this->dealer->get_dealer_data($interaction_data['dealer_id']);
									if ($data != FALSE) {
										$dealerNumber = $data->d_phone;
										$dealerEmail = $data->d_email;
									}
								} else {
									//for pharmacy;
									$data = $this->pharmacy->get_pharmacy_data($interaction_data['dealer_id']);
									if ($data != FALSE) {
										$dealerNumber = $data->company_phone;
										$dealerEmail = $data->company_email;
									}
								}

							}

							$dataPharmacy = $this->pharmacy->get_pharmacy_data($interaction_data['pharma_id']);
							if ($dataPharmacy != FALSE) {
								$pharmacyNumber = $dataPharmacy->company_phone;
								$pharmacyEmail = $dataPharmacy->company_email;
							}


							//send_msg('5','8604111305','8604111305');
							if ($interaction_data['dealer_mail'] == 1) {
								send_msg($message, $dealerNumber, $pharmacyNumber); //send message to dealer & dealer
							}
							try {

								//send_email('niraj@bjain.com', $subject, $message);
								if (isset($interaction_data['meet_or_not'])) {
									if ($interaction_data['meet_or_not'] == 1) {
										# code...
										$sms = 'Thank you Dear Sub Dealer for your valuable time. We look forward to your kind support for B. Jain’s Product.';//but no sale or sample
										$emailbody = '<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{ margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="' . base_url() . '/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
		<h3>Dear,</h3> <p>' . $sms . '</p><p><i>This is an auto generated email.</i></p>
		<div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">' . get_user_name(logged_user_data()) . '<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
									} else {
										$sms = 'Sub Dealer I visited today but was unable to meet you. May I request you for a suitable time for a meeting when I can see you.';
										$emailbody = '<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{ margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="' . base_url() . '/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
		<h3>Dear,</h3> <p>' . $sms . '</p><p><i>This is an auto generated email.</i></p>
		<div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">' . get_user_name(logged_user_data()) . '<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
									}
								} else // for sale
								{
									if (isset($interaction_data['m_sale']) && isset($interaction_data['m_sample'])) {

										$sms = 'Thank you Dear Sub Dealer for your support to B. Jain Pharma. Please give your valuable feedback for provided samples. I am happy to receive your order which is mentioned below.';
										$sms1 = $sms;
										$sms = $sms . ' ' . $orderData;

										$emailbody = '<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
			 margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="' . base_url() . '/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
		  <h3>Dear,</h3> <p>' . $sms1 . '</p>' . $emailorderdata . '<p><i>This is an auto generated email.</i></p>
		  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">' . get_user_name(logged_user_data()) . '<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';

										$dealerSms = 'Dear Dealer/Sub Dealer, we have received an order .  Kindly deliver at mentioned time and discount.The order details are mentioned below. ' . $orderData;

										$dealerSms1 = 'Dear Dealer/Sub Dealer, we have received an order.  Kindly deliver at mentioned time and discount.The order details are mentioned below. ';

										$dealeremailbody = '<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
			 margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="' . base_url() . '/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
		  <h3>Dear,</h3> <p>' . $dealerSms1 . '</p>' . $emailorderdata . '<p><i>This is an auto generated email.</i></p>
		  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">' . get_user_name(logged_user_data()) . '<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
										//send_msg($dealerSms,'7838359383');
										if ($interaction_data['dealer_mail'] == 1) {
											send_msg($dealerSms, $dealerNumber);
											if ($dealerEmail != '') {
												$success = send_email($dealerEmail, $senderemail, $subject, $dealeremailbody);
												//$success =send_email('android@bjain.com', $senderemail, $subject, $dealeremailbody);//send message to pharmacy/dealer
											}
										}
									}
									else if (isset($interaction_data['m_sample']))// only sample
									{
										$sms = 'Thank you Dear Sub Dealer for your valuable time. Kindly give your feedback for samples.';
										$emailbody = '<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{ margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="' . base_url() . '/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
		<h3>Dear,</h3> <p>' . $sms . '</p><p><i>This is an auto generated email.</i></p>
		<div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">' . get_user_name(logged_user_data()) . '<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
									}
									else if (isset($interaction_data['m_sale']))//only product
									{
										$sms = 'Thank you Dear Sub Dealer for your support to B. Jain Pharma. I am happy to receive your order which is mentioned below.';
										$sms1 = $sms;
										$sms = $sms . ' ' . $orderData;

										$dealerSms = 'Dear Dealer/Sub Dealer, we have received an order.  Kindly deliver at mentioned time and discount.The order details are mentioned below. ' . $orderData;

										$dealerSms1 = 'Dear Dealer/Sub Dealer, we have received an order.  Kindly deliver at mentioned time and discount.The order details are mentioned below. ';

										$dealeremailbody = '<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
			 margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="' . base_url() . '/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
		  <h3>Dear,</h3> <p>' . $dealerSms1 . '</p>' . $emailorderdata . '<p><i>This is an auto generated email.</i></p>
		  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">' . get_user_name(logged_user_data()) . '<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';

										//send_msg($dealerSms,'7838359383');
										if ($interaction_data['dealer_mail'] == 1) {
											send_msg($dealerSms, $dealerNumber);
											if ($dealerEmail != '') {
												$success = send_email($dealerEmail, $senderemail, $subject, $dealeremailbody);//send message to pharmacy/dealer
												//  $success =send_email('android@bjain.com', $senderemail, $subject, $dealeremailbody);
											}
										}
									}
								}
								if ($interaction_data['dealer_mail'] == 1) {
									// send_msg($sms,'8604111305');
									send_msg($sms, $pharmacyNumber);
									if ($pharmacyEmail != '') {
										// send_email('niraj@bjain.com', $senderemail, $subject, $emailbody);
										$success = send_email($pharmacyEmail, $senderemail, $subject, $emailbody);//send message to doctor  //send message to doctor
									}
								}
							} catch (Exception $e) {
								set_flash('<div class="alert alert-danger alert-dismissible">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<h4><i class="icon fa fa-ban"></i> Alert!</h4>
						   Something went wrong.
						  </div>');
								redirect($_SERVER['HTTP_REFERER']);
							}
						}
						elseif (isset($interaction_data['d_id'])) {            //for Dealer side
							$data = $this->dealer->get_dealer_data($interaction_data['d_id']);
							if ($data != FALSE) {
								$dealerNumber = $data->d_phone;
								$dealerEmail = $data->d_email;
							}
							if (isset($interaction_data['meet_or_not'])) {
								if ($interaction_data['meet_or_not'] == 1) {
									# code...
									$sms = 'Thank you Dear Dealer for your valuable time. We look forward to your kind support for B. Jain’s Product.';//but no sale or sample
									$emailbody = '<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{ margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="' . base_url() . '/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
		<h3>Dear,</h3> <p>' . $sms . '</p><p><i>This is an auto generated email.</i></p>
		<div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">' . get_user_name(logged_user_data()) . '<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
								}
								else {
									$sms = 'Dealer I visited today but was unable to meet you. May I request you for a suitable time for a meeting when I can see you.';
									$emailbody = '<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{ margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="' . base_url() . '/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
		<h3>Dear,</h3> <p>' . $sms . '</p><p><i>This is an auto generated email.</i></p>
		<div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">' . get_user_name(logged_user_data()) . '<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
								}
							} else // for sale
							{
								if (isset($interaction_data['m_sale']) && isset($interaction_data['m_sample'])) {
									$sms = 'Thank you Dear Dealer for your support to B. Jain Pharma. Please give your valuable feedback for provided samples. I am happy to receive your order which is mentioned below.';
									$sms1 = $sms;
									$sms = $sms . ' ' . $orderData;
									$emailbody = '<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
			 margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="' . base_url() . '/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
		  <h3>Dear,</h3> <p>' . $sms . '</p>' . $emailorderdata . '<p><i>This is an auto generated email.</i></p>
		  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">' . get_user_name(logged_user_data()) . '<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
								}
								else if (isset($interaction_data['m_sample']))// only sample
								{
									$sms = 'Thank you Dear Dealer for your valuable time. Kindly give your feedback for samples.';
									$emailbody = '<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{ margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="' . base_url() . '/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
		<h3>Dear,</h3> <p>' . $sms . '</p><p><i>This is an auto generated email.</i></p>
		<div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">' . get_user_name(logged_user_data()) . '<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
								} else if (isset($interaction_data['m_sale']))//only product
								{
									$sms = 'Thank you Dear Dealer for your support to B. Jain Pharma. I am happy to receive your order which is mentioned below.';
									$sms1 = $sms;
									$sms = $sms . ' ' . $orderData;
									$emailbody = '<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
			 margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="' . base_url() . '/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
		  <h3>Dear,</h3> <p>' . $sms1 . '</p>' . $emailorderdata . '<p><i>This is an auto generated email.</i></p>
		  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">' . get_user_name(logged_user_data()) . '<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
								}
							}

							//send_msg($sms,'8604111305');

							try {
								if ($interaction_data['dealer_mail'] == 1) {
									send_msg($sms, $dealerNumber); //send message to dealer
									if ($dealerEmail != '') {
										send_email($dealerEmail, $senderemail, $subject, $emailbody);//send message to dealer
										//send_email('niraj@bjain.com', $senderemail, $subject, $emailbody);
									}
								}
							} catch (Exception $e) {
								set_flash('<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-ban"></i> Alert!</h4>
			   Something went wrong.
			  </div>');
								redirect($_SERVER['HTTP_REFERER']);
							}
						}

						if (isset($interaction_data['m_sale'])) {
							$userBoss = $this->user->getUserBoss(logged_user_data());
							$username = get_user_name(logged_user_data());
							$msname = '';
							if (isset($interaction_data['dealer_id'])) {
								if (is_numeric($interaction_data['dealer_id'])) {
									//for dealer;
									$data = $this->dealer->get_dealer_data($interaction_data['dealer_id']);
									if ($data != FALSE) {
										$msname = $data->dealer_name;

									}
								} else {
									//for pharmacy;
									$data = $this->pharmacy->get_pharmacy_data($interaction_data['dealer_id']);
									if ($data != FALSE) {
										$msname = $data->company_name;
									}
								}
							}

							$userbossms = '';
							$userbosemail = '';
							if (isset($interaction_data['doc_name'])) {
								$userbossms = 'Mr. ' . $username . ' Has placed an order from Dr.' . $interaction_data['doc_name'] . '. To M/S ' . $msname . ' the order details are as. ' . $orderData;
								$userbossms1 = 'Mr. ' . $username . ' Has placed an order from Dr.' . $interaction_data['doc_name'] . '. To M/S ' . $msname . ' the order details are as. ';
								$userbosemail = '<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
			 margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="' . base_url() . '/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
		  <h3>Dear,</h3> <p>' . $userbossms1 . '</p>' . $emailorderdata . '<p><i>This is an auto generated email.</i></p>
		  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">' . get_user_name(logged_user_data()) . '<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
							}
							else if (isset($interaction_data['com_name'])) {
								$userbossms = 'Mr.' . $username . ' Has placed an order from Sub Dealer  ' . $interaction_data['com_name'] . '. To M/S ' . $msname . ' the order details are as. ' . $orderData;
								$userbossms1 = 'Mr.' . $username . ' Has placed an order from Sub Dealer  ' . $interaction_data['com_name'] . '. To M/S ' . $msname . ' the order details are as. ';
								$userbosemail = '<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
			 margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="' . base_url() . '/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
		  <h3>Dear,</h3> <p>' . $userbossms1 . '</p>' . $emailorderdata . '<p><i>This is an auto generated email.</i></p>
		  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">' . get_user_name(logged_user_data()) . '<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
							}
							else if (isset($interaction_data['d_name'])) {

								$userbossms = 'Mr.' . $username . ' Has placed an order to Dealer ' . $interaction_data['d_name'] . '. The order details are as. ' . $orderData;
								$userbossms1 = 'Mr.' . $username . ' Has placed an order to Dealer ' . $interaction_data['d_name'] . '. The order details are as. ';
								$userbosemail = '<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
			 margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="' . base_url() . '/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
		  <h3>Dear,</h3> <p>' . $userbossms1 . '</p>' . $emailorderdata . '<p><i>This is an auto generated email.</i></p>
		  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">' . get_user_name(logged_user_data()) . '<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';

							}
							$userbosssms = '';
							if ($userBoss != False) {
								foreach ($userBoss as $boss) {
									if (!empty($boss['user_phone'])) {
										//send_msg('6','8604111305');//send message to all boss
										send_msg($userbossms, $boss['user_phone']);//send message to all boss
										// send_msg($userbossms,'9891747698');
										try {
											if ($boss['email_id'] != '') {
												//send_msg($message,$boss['user_phone'])
												//send_email('ios@bjain.com', $senderemail, $subject, $userbosemail);//ashis
												send_email($boss['email_id'], $senderemail, $subject, $userbosemail);//send message to dealer
											}
										} catch (Exception $e) {
											set_flash('<div class="alert alert-danger alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h4><i class="icon fa fa-ban"></i> Alert!</h4>
					   Something went wrong.
					  </div>');
											redirect($_SERVER['HTTP_REFERER']);
										}
									}
								}
							}

							send_email('pharma.reports@bjain.com', $senderemail, $subject, $userbosemail);//send only email to H.O.
						}
						if ($interaction_data['path_info'] == '' || $interaction_data['path_info'] == 0) {

						if (!is_numeric($interaction_data['dealer_view_id'])) {
							if (substr($interaction_data['dealer_view_id'], 0, 3) == 'doc') {
								set_flash('<div class="alert alert-success alert-dismissible">     
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>         
					<h4><i class="icon fa fa-check"></i> Success!</h4>      
					interaction are being saved for this  </div>');
								redirect('doctors/doctor/');
							}
							else {
								set_flash('<div class="alert alert-success alert-dismissible">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>  
								<h4><i class="icon fa fa-check"></i> Success!</h4>interaction are being saved for this
								</div>');
								redirect('pharmacy/pharmacy/');
							}
						} else {
							$gd_id = json_decode($this->dealer->edit_dealer($interaction_data['dealer_view_id']));
								if ($gd_id->gd_id == '') {
									set_flash('<div class="alert alert-success alert-dismissible">  
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> 
					<h4><i class="icon fa fa-check"></i> Success!</h4>     
					interaction are being saved for this </div>');
									redirect('dealer/dealer/dealer_view');
								}
								else {
									set_flash('<div class="alert alert-success alert-dismissible">  
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> 
					<h4><i class="icon fa fa-check"></i> Success!</h4>     
					interaction are being saved for this </div>');
									redirect('dealer/dealer/main_dealer_view');
								}
							}

						}
						else {
							set_flash('<div class="alert alert-success alert-dismissible">  
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> 
							<h4><i class="icon fa fa-check"></i> Success!</h4>     
							interaction are being saved for this </div>');
							redirect('interaction/add_direct_inteaction/' . urisafeencode($interaction_data['doi_doc']) . '/' . urisafeencode($interaction_data['city']));
						}
						}
					else {
					  set_flash('<div class="alert alert-danger alert-dismissible">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					  <h4><i class="icon fa fa-ban"></i> Alert!</h4>interaction are not saved please try latter..
					  </div>');
							redirect($_SERVER['HTTP_REFERER']);
						}

					}
					else {
						set_flash('<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="icon fa fa-ban"></i> Alert!</h4>
		   Please Select Any One Type of Meeting...
		  </div>');
						redirect($_SERVER['HTTP_REFERER']);
					}
                    }
                    else{
					if (isset($interaction_data['dealer_id']) && empty($interaction_data['dealer_id'])) {
						set_flash('<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-ban"></i> Alert!</h4>
			   Please Select Dealer/Sub Dealer for the sale.
			  </div>');
					}
					else if (empty($interaction_data['doi_doc'])) {
					  set_flash('<div class="alert alert-danger alert-dismissible">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					  <h4><i class="icon fa fa-ban"></i> Alert!</h4>Please Select Date Of <Interaction></Interaction>.</div>');
					}
					redirect($_SERVER['HTTP_REFERER']);
                    }

                }
           }
		    else{
                set_flash('<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
               Stay / Not Stay - Features Not Used..
              </div>');
                redirect($_SERVER['HTTP_REFERER']);
            }
		}
       
    }


    // inactive to active dealer
    public function inactive_dealer($id=''){
        
        if($id!=''){
             $sm_id = urisafedecode($id);
             $success = $this->dealer->inactive_dealermaster($sm_id);
             
              if($success=1){  // on sucess
           
            set_flash('<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
              Dealer Activated !!
              </div>'); 
           
            redirect($_SERVER['HTTP_REFERER']);
           
       }
       else{ // on unsuccess
           set_flash('<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Dealer Does not Activated...
              </div>');
            redirect($_SERVER['HTTP_REFERER']);
       }
            
        }  
    }
    
    
     // active to inactive dealer
    public function active_dealer($id=''){
        
        if($id!=''){
             $sm_id = urisafedecode($id);
             $success = $this->dealer->active_dealermaster($sm_id);
             
              if($success=1){  // on sucess
           
            set_flash('<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
              Dealer Activated !!
              </div>'); 
           
            redirect($_SERVER['HTTP_REFERER']);
           
       }
       else{ // on unsuccess
           set_flash('<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Dealer Does not Activated...
              </div>');
            redirect($_SERVER['HTTP_REFERER']);
       }
            
        }  
    }
    
    
     // Remain to blocked dealer
    public function blocked_dealer($id=''){
        
        if($id!=''){
             $sm_id = urisafedecode($id);
             $success = $this->dealer->blocked_dealermaster($sm_id);
             
              if($success=1){  // on sucess
           
            set_flash('<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
              Dealer Blocked !!
              </div>'); 
           
            redirect($_SERVER['HTTP_REFERER']);
           
       }
       else{ // on unsuccess
           set_flash('<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Dealer Does not Blocked...
              </div>');
            redirect($_SERVER['HTTP_REFERER']);
       }
            
        }  
    }
   
    
     // Blocked to Remain dealer
    public function remain_dealer($id=''){
        
        if($id!=''){
             $sm_id = urisafedecode($id);
             $success = $this->dealer->remain_dealermaster($sm_id);
             
              if($success=1){  // on sucess
           
            set_flash('<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
              Dealer UnBlocked !!
              </div>'); 
           
            redirect($_SERVER['HTTP_REFERER']);
           
       }
       else{ // on unsuccess
           set_flash('<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Dealer Does not UnBlocked...
              </div>');
            redirect($_SERVER['HTTP_REFERER']);
       }
            
        }  
    }
    
    
    // send email to the admin if duplicate record will entered for the same person on the same day.
    public function duplicate_interaction($data,$duplicate_data){
        
        
        
        $this->load->library('email', email_setting());
        
        $this->email->to('pharma.reports@bjain.com','Duplicate Interaction');
        
        if(!empty($this->session->userdata['userEmail'])){
          $from_mail =   $this->session->userdata['userEmail'];
        }
        
         $this->email->from($from_mail);
         
         
         $msg='Dear Admin,
                           Apologize,
                    I have entered duplicate record of '.$data->name.' .
                    Please Edit the entries.
                    
                
                    Regards!
                    '.$this->session->userdata['userName'].'
                   ---------------------------- 
                    B.Jain Publishers Pvt Ltd
                    D 157 Sector 63, Noida
                    201301, Uttar Pradesh 
                    Tel: +91-120-49 33 333';
        $this->email->subject('Duplicate Interaction of '.$data->name);
        
        
        $this->email->message($msg);
        
        if($this->email->send()){
            
            set_flash('<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
               You are Entered Duplicate record of '.$data->name.' . 
               An Email was Send Sucessfully to the Admin for the Entry.
              </div>'); 
             redirect($_SERVER['HTTP_REFERER']);
        }
        else{
            set_flash('<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
               Email was not send Successfully of Duplicate Entry.
              </div>'); 
             redirect($_SERVER['HTTP_REFERER']);
        }
        
        
    }
    
	public function import_dealer(){
		
		if(is_admin()){
			$data['user_list']='';
			if($this->user->getUserList()){
				$data['user_list']= $this->user->getUserList(); 
			}
			else{
				$data['user_list']= ''; 
			}
			$data['title']="Import Dealer";
			$data['page_name'] = "Import Dealer";
			$data['action'] = "dealer/dealer/save_bulk_dealer";
			$this->load->get_view('dealer_list/dealer_import_view',$data);
		}
		else{
		 redirect('user');
		}
    }
	
	public function save_bulk_dealer(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('user', 'User', 'required');
		if($this->form_validation->run() == FALSE){
			return $this->import_dealer();    
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
					   $data = array(
						  'dealer_name' => $importdata[0],
						  'd_address ' => $importdata[1],
						  'city_id' => $importdata[2],
						  'state_id' => $importdata[3],
						  'd_phone' => $importdata[4],
						  'd_email' => $importdata[5],
						  'crm_user_id' => $this->input->post('user'),
						  'last_update' =>savedate(),
						  'status' =>1,
						  'blocked' =>0,
						 );
						$insert = $this->dealer->dealer_import_save($data);
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
					Dealer are imported successfully.'.$count.' Duplicate Mobile Found. </div>');
					redirect('dealer/dealer/import_dealer');
				}else{
					set_flash('<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-ban"></i> Alert!</h4>
					Empty File !!
					</div>');
					redirect('dealer/dealer/import_dealer');
				}
			} else {
				set_flash('<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-ban"></i> Alert!</h4>
				Sorry file not allowed. Try again !!
				</div>');
				redirect('dealer/dealer/import_dealer');
			}
		}
    }
	
	/* send email when inteaction mismatch */
	public function interaction_mismatch(){
		$interaction_data = $this->dealer->interact_details();
	}


	public function update_dealers_row(){
		$input_data=$this->input->post();
		if(!empty($input_data)){
			$data=$input_data;
			$this->dealer->update_dealers_record($data);
		}
	}

}
