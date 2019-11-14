<?php

defined('BASEPATH') OR exit('No direct script access allowed');



/* 

 * Niraj Kumar

 * Dated: 18/10/2017

 * 

 * This Controller is for Samples List -> add,edit,del

 */



class Sample_master extends Parent_admin_controller {



   function __construct() 

    {

        parent::__construct();

            $loggedData=logged_user_data();

            

            if(empty($loggedData)){

                redirect('user'); 

            }

            

            $this->load->model('sample_master/sample_master_model','sample');

    }

    

    public function index(){

          if(is_admin()){

        $data['title'] = "Samples List";

         $data['page_name'] = "Sample Master";



         $data['sample_data'] =$this->sample->sample_list();



//         pr($data['sample_data']); die;

         

        $this->load->get_view('sample_master/sample_master_details_view',$data);

        

          }

    }



     public function add_sample($id=''){

         

         $data['title'] = "Sample Master";

          $data['page_name'] = "Add Sample";

         if($id!=''){

          $data['action'] = "admin_control/sample_master/save_samples/$id"; 

           $data['sample_edit'] =$this->sample->sample_list($id);

         }

         else{

             $data['action'] = "admin_control/sample_master/save_samples";

         }

         

       

//          pr(json_decode($data['sample_edit'])); die;

        $this->load->get_view('sample_master/sample_master_add_view',$data);

        

    }

    

    public function save_samples($id=''){

        

        $this->load->library('form_validation');



        $this->form_validation->set_rules('product_name', 'Prodcut Name', "required");



         if($this->form_validation->run() == TRUE){

               if($id!=''){  // for update

                        $sm_id= urisafedecode($id);

                        $post_data = $this->input->post();

                        $success = $this->sample->add_samplemaster($post_data,$sm_id);

            

               }        

               else{ // for insert

                        $post_data = $this->input->post();

                        $success = $this->sample->add_samplemaster($post_data);

                   

               }

            if($success=1){  // on sucess

           

            set_flash('<div class="alert alert-success alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-check"></i> Success!</h4>

              Samples Saved Successfully.

              </div>'); 

            $this->index();

//            redirect($_SERVER['HTTP_REFERER']);

           

       }

       else{ // on unsuccess

           set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

                Samples Does not Save.

              </div>');

           $this->index();

//            redirect($_SERVER['HTTP_REFERER']);

       }

             

         }

        else{  // for false validation

              

               if($id!=''){  // go to edit if id have

                

                   $this->add_sample($id);

             }else{



              $this->add_sample();

             }

             

        }

    }

    

    

    // del sample master

    public function del_sample($id=''){

        

        if($id!=''){

             $sm_id = urisafedecode($id);

             $success = $this->sample->del_samplemaster($sm_id);

             

              if($success=1){  // on sucess

           

            set_flash('<div class="alert alert-success alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-check"></i> Success!</h4>

              Samples Deleted !!

              </div>'); 

           

            redirect($_SERVER['HTTP_REFERER']);

           

       }

       else{ // on unsuccess

           set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

               Samples Does not Delete...

              </div>');

            redirect($_SERVER['HTTP_REFERER']);

       }

            

        }

        

    }

  

  

    

}



?>