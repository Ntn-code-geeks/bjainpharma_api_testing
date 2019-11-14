<?php

defined('BASEPATH') OR exit('No direct script access allowed');



/* 

 * Niraj Kumar

 * Dated: 23/10/2017

 * 

 * This Controller is for Set user permissions  

 * 

 */



class User_permission extends Parent_admin_controller {



   function __construct() 

    {

        parent::__construct();

            $loggedData=logged_user_data();

            

            if(empty($loggedData)){

                redirect('user'); 

            }

                 $this->load->model('dealer/Dealer_model','dealer');



            $this->load->model('permission/permission_model','permission');

    }

    

    public function index(){    

         if(is_admin()){

        $data['title'] = "User List";

         $data['page_name'] = "User Permission";



         $data['user_data'] =$this->permission->user_list();



//         pr(json_decode($data['user_data'])); die;

         

        $this->load->get_view('permission/user_permission_details_view',$data);

         }

         else{

               redirect('user'); 

         }

    }



     public function add_user($id=''){

         if(is_admin()){

         $data['title'] = "User";

          $data['page_name'] = "Add User";

         if($id!=''){

          $data['action'] = "admin_control/user_permission/save_users/$id"; 

           $data['user_data'] =$this->permission->user_list($id);

           $userinfo= json_decode($data['user_data']);

//           pr($userinfo); die;

           $user_city_id = $userinfo[0]->city_id;

            $desig_id = $userinfo[0]->desig_id;

           $cityList=get_all_city();

  

             $data['doc_data'] = json_encode($this->permission->doctor_list($user_city_id));

             $data['pharma_data'] = json_encode($this->permission->pharmacy_list($user_city_id));

              $cityid = explode(',',$user_city_id );

             $data['boss_data'] = json_encode($this->permission->boss_list($desig_id,$cityid,$id));

           

         }

         else{

             $data['action'] = "admin_control/user_permission/save_users";

             if(isset($_POST['user_doctors'])){

                $user_city_id = implode(',', $_POST['user_city']);

             $data['doc_data'] = json_encode($this->permission->doctor_list($user_city_id));

            

             }

              if(isset($_POST['user_pharmacy'])){

                   $user_city_id = implode(',', $_POST['user_city']);

              $data['pharma_data'] = json_encode($this->permission->pharmacy_list($user_city_id));

              

              

              }

              

                if(isset($_POST['boss'])){

                    

                $data['boss_data'] = json_encode($this->permission->boss_list($_POST['user_designation'],$_POST['user_city']));

                }

              

         }

        

        $data['cityname'] = json_encode($this->dealer->cities());

        $data['design_list'] =$this->permission->designation_list($id);

        

        

        

//          pr($data['d_data']); die;

        $this->load->get_view('permission/user_permission_add_view',$data);

        

         }

         else{

              redirect('user'); 

         }

        

    }

    

    public function save_users($id=''){

//        $post_data = $this->input->post();

//        pr($post_data); die;
      $post_data = $this->input->post();

        $this->load->library('form_validation');

      if( isset($post_data['hq_city']) && $post_data['hq_city']=='')
      {
        $this->form_validation->set_rules('hq_city', 'Headquarter City', "required");
      }
      
        $this->form_validation->set_rules('emp_code', 'Employee code', "required");
        

        $this->form_validation->set_rules('city_pin', 'City Pincode', "required");
        

        $this->form_validation->set_rules('user_name', 'Name', "required");

        

        $this->form_validation->set_rules('user_email', 'Email Id', "required");
        $this->form_validation->set_rules('sp_code', 'Sp Code', "required");
        

        //$this->form_validation->set_rules('user_city[]', 'City', "required");

        $this->form_validation->set_rules('user_designation', 'Designation', "required");

        if(empty($id)){

        $this->form_validation->set_rules('user_pass', 'Password', "required");

        }



         if($this->form_validation->run() == TRUE){

               if($id!=''){  // for update

                       $u_id= urisafedecode($id);
                        $post_data = $this->input->post();
                        $success = $this->permission->create_users($post_data,$u_id);

            

               }        

               else{ // for insert

                        $post_data = $this->input->post();

                        $success = $this->permission->create_users($post_data);

                   

               }

            if($success=1){  // on sucess

           

            set_flash('<div class="alert alert-success alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-check"></i> Success!</h4>

              User Saved Successfully.

              </div>'); 

           

            $this->index();

           

       }

       else{ // on unsuccess

           set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

                User Does not Save.

              </div>');

           $this->index();

//            redirect($_SERVER['HTTP_REFERER']);

       }

             

         }

        else{  // for false validation

              

               if($id!=''){  // go to edit if id have

                

                   $this->add_user($id);

             }else{



              $this->add_user();

             }

             

        }

    }

    

    

    // de-actived user master

    public function del_user($id=''){

        

        if($id!=''){

             $sm_id = urisafedecode($id);

             $success = $this->permission->del_usermaster($sm_id);

             

              if($success=1){  // on sucess

           

            set_flash('<div class="alert alert-success alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-check"></i> Success!</h4>

              User De-Activated !!

              </div>'); 

           

            redirect($_SERVER['HTTP_REFERER']);

           

       }

       else{ // on unsuccess

           set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

               User Does not De-Activated...

              </div>');

            redirect($_SERVER['HTTP_REFERER']);

       }

            

        }

        

    }

    

    

    

      // active user master

    public function active_user($id=''){

        

        if($id!=''){

             $sm_id = urisafedecode($id);

             $success = $this->permission->active_usermaster($sm_id);

             

              if($success=1){  // on sucess

           

            set_flash('<div class="alert alert-success alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-check"></i> Success!</h4>

              User Activated !!

              </div>'); 

           

            redirect($_SERVER['HTTP_REFERER']);

           

       }

       else{ // on unsuccess

           set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

                User Does not Activated...

              </div>');

            redirect($_SERVER['HTTP_REFERER']);

       }

            

        }

        

    }

    

    // get doctor list of user city

    public function doctor_info(){

        

         $d_id = $this->input->post();

//       pr($d_id); die;

          $data['doc_data'] = $this->permission->doctor_list($d_id['id']);

       

//          pr($data['doc_data']); die;

       

//          $result=array();

           if(!empty($data['doc_data'])){         

          echo '<option value="">-Select Doctor-</option>';

          foreach($data['doc_data'] as $k=>$value){

             echo '<option value="'.$value['id'].'">'.$value['doc_name'].'('.$value['city_name'].')</option>'; 

                           

          }

           }

           else{

                echo 'No Doctor in this City';

           }



        

    }

    

       // get pharmacy list of user city

    public function pharmacy_info(){

        

         $d_id = $this->input->post();

       

          $data['pharma_data'] = $this->permission->pharmacy_list($d_id['id']);

       

//          pr($data['doc_data']); die;

       

//          $result=array();

             if(!empty( $data['pharma_data'])){       

          echo '<option value="">-Select Sub Dealer-</option>';

          foreach($data['pharma_data'] as $k=>$value){

             echo '<option value="'.$value['id'].'">'.$value['com_name'].'('.$value['city_name'].')</option>'; 

                           

          }

             }

             else{

                 echo 'No Dealer in this City';

             }



        

    }

    

    

    // get the deatils of the user boss

    public function boss_info(){

        

          $ids = $this->input->post();

//       pr($ids); die;

          $data['boss_data'] = $this->permission->boss_list($ids['desigid'],$ids['cityid']);

       

//          pr($data['doc_data']); die;

       

//          $result=array();

             if(!empty( $data['boss_data'])){       

          echo '<option value="">-Select Boss-</option>';

          foreach($data['boss_data'] as $k=>$value){

             echo '<option value="'.$value['id'].'">'.$value['name'].'('.$value['designation_name'].')</option>'; 

                           

          }

             }

             else{

                 echo '<option value="">-Select Boss-</option>';

                 echo '<option value="29">Nishant(NSM)</option>'; 

             }

    }

    

    

  

  

    

}



?>