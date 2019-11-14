<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Niraj Kumar
 * Dated: 07/10/2017
 * 
 * This Controller is for Appointment List
*/
class Appoint extends Parent_admin_controller {
  function __construct() 
  {
    parent::__construct();
    $loggedData=logged_user_data();
    if(empty($loggedData)){
     redirect('user'); 
    }

//        $this->load->model('contact/Contact_model','contact');

//        $this->load->model('dealer/School_model','dealer');

          $this->load->model('permission/permission_model','permission'); 

         $this->load->model('appointment/appointment_model','appoint');

         $this->load->model('dealer/dealer_model','dealer');

          $this->load->model('doctor/doctor_model','doctor');

          $this->load->model('pharmacy/pharmacy_model','pharmacy');

    }

    

    public function index(){    
        $data['title'] = "Appointment List";
        $data['page_name'] = "Appointment";
//      $data['main_meeting_name'] =$this->dealer->main_meeting_name();
        $data['ap_list'] = $this->appoint->ap_info(); 
//      pr(json_decode($data['ap_list'])); die;
        $this->load->get_view('appointment/appoint_details_view',$data);
    }



     public function add_appointment(){

         

         $data['title'] = "Appointment";

          $data['page_name'] = "Add Appointment";

            $data['action'] = "appointment/appoint/save_appointment"; 

            

            $data['doctor_list'] = $this->appoint->get_doctor();

           $data['pharma_list']= $this->permission->pharmacy_list(logged_user_cities()); 

            

           $data['dealer_list'] = $this->dealer->dealer_list();

            

            

           

        $this->load->get_view('appointment/appoint_add_view',$data);

        

    }

    

    public function save_appointment($id=''){

        

//      pr($this->input->post()); die;

         $this->load->library('form_validation');



//        $this->form_validation->set_rules('contact_num', 'Phone', 'required|regex_match[/^[0-9]{10}$/]');

        $this->form_validation->set_rules('doa', 'Date of Appointment', "required");

         

//        if($id==''){

//        $this->form_validation->set_rules('dealer_id', 'Name', "required");

//        }

         if($this->form_validation->run() == TRUE){

               if($id!=''){  // for update

              $ap_id= urisafedecode($id);

           $post_data = $this->input->post();

//        pr($post_data); die;

       $success = $this->appoint->add_appointment($post_data,$ap_id);

            

               }        

               else{ // for insert

                    $post_data = $this->input->post();

//          pr($post_data); die;

       $success = $this->appoint->add_appointment($post_data);

                   

               }

            if($success=1){  // on sucess

           

            set_flash('<div class="alert alert-success alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-check"></i> Success!</h4>

              Appointment  Save Successfully.

              </div>'); 

           

            redirect($_SERVER['HTTP_REFERER']);

           

       }

       else{ // on unsuccess

           set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

               Appointment Does not Save.

              </div>');

            redirect($_SERVER['HTTP_REFERER']);

       }

             

         }

          else{  // for false validation

              

               if($id!=''){  // go to edit if id have

                

                   $this->edit_appointment($id);

             }else{



              $this->add_appointment();

             }

             

        }

    }

    

    

    public function edit_appointment($id=''){

        

         if($id!=''){

              $data['title'] = "Edit Appointment";

         $data['page_name'] = "Edit Appointment";

                        $ap_id= urisafedecode($id);

                    $data['action'] = "appointment/appoint/save_appointment/$id";

                    

                    

              $data['edit_appointment_list']= $this->appoint->edit_appointment($ap_id);

//              pr($data['edit_appointment_list']); die;

//                $data['dealer_list']= $this->contact->srm_dealer_list();    

          

                $this->load->get_view('appointment/appoint_edit_view',$data);

        

                   }

    }

    

    

    // add interaction data of appointment

    public function add_appointment_interaction($id=''){

        

        if($id!=''){

            $data['title'] = "Add Interaction";

         $data['page_name'] = "Add Interaction";

            $ap_id= urisafedecode($id);

//            echo $ap_id; die;

            $data['edit_dealer_list']= $this->dealer->edit_dealer($ap_id);
            $data['edit_doctor_list']= $this->appoint->edit_appointment($ap_id);
            $data['edit_pharmacy_list']= $this->pharmacy->edit_pharmacy($ap_id);

//           pr(json_decode($data['edit_pharmacy_list'])); die;

             if(!empty($data['edit_dealer_list'])){
                $data['action'] = "dealer/dealer/dealer_interaction";
//              echo "dealer"; die;
                $this->load->get_view('appointment/add_interaction_view',$data);
             }
             else if(!empty ($data['edit_doctor_list'])){
                 $data['action'] = "dealer/dealer/dealer_interaction";
                 $data['dealer_list']= $this->dealer->dealer_list(); 
                 $data['meeting_sample'] = $this->doctor->meeting_sample_master();
                 $this->load->get_view('appointment/add_interaction_doctor_view',$data);
             }

             else if(!empty ($data['edit_pharmacy_list'])){
              $data['action'] = "dealer/dealer/dealer_interaction";
              $data['dealer_list']= $this->dealer->dealer_list(); 
              $data['meeting_sample'] = $this->doctor->meeting_sample_master();
              $this->load->get_view('appointment/add_interaction_pharmacy_view',$data);
            }
            $data['action'] = "dealer/dealer_add/dealer_interaction";
            // $data['main_meeting_name'] =$this->dealer->main_meeting_name();
//            pr(json_decode($data['edit_appointment_list'])) ;

//             pr(json_decode($data['main_meeting_name'])) ;

////   die;             

//            $this->load->get_view('appointment/add_interaction_view',$data);

        }

        

        

    }

  

    

}



?>