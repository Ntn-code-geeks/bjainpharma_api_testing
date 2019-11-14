<?php

defined('BASEPATH') OR exit('No direct script access allowed');



/* 

 * Niraj Kumar

 * Dated: 04/10/2017

 * Project Name: Bjain Pharma Dashboard

 * 

 * 

 * This Controller is for User Login/Logout feature

 */



class User extends Parent_admin_controller {

    

     function __construct() 

    {

        parent::__construct();

         

        $this->load->model('User_model','user');

        $this->load->model('doctor/Doctor_model','doctor');
        $this->load->model('pharma_nav/customer_nav_model','cust_nav');
        

        $this->load->model('data_analysis_model','analysis');

        

    }

  

    public function index(){

        

        $loggedData=logged_user_data();

            

            if($loggedData==TRUE && $this->session->userdata('SiteUrl_id')== base_url()){

//                echo "mee"; die;

                redirect('user/dashboard');

            }

            else{

//                echo "i call"; die;

        $data['title'] = "Bjain Pharma ";

        $data['action'] = "user/check_login";

        

        $this->load->get_view('login_view',$data);

            }

    }

    

    public function check_login(){

        

        $log_data = $this->input->post();

        

        



        if(!empty($log_data)){

         $password = md5($log_data['password']);

          $email = $log_data['email'];

          $user_info =  $this->user->check_user($email);

        }
        if(!empty($user_info)){
         

            $stored_pass= $user_info->password;

            

                if ($password===$stored_pass)

                    {



                           $sesUser = array(

                                                'userName'=>$user_info->name,

												'userId'=>$user_info->id,

												'userEmail'=>$user_info->email_id,

                                                'userCity'=>$user_info->city_id,

                                                'userDesig'=>$user_info->desig_id,

                                                'pharmaAre'=>$user_info->pharma_id,

                                                'doctorAre'=>$user_info->doctor_id,

                                                'userBoss' => $user_info->boss_ids,

                                                'userChild'=>$user_info->child_ids,

												'switchStatus'=>$user_info->switchStatus,
												'admin'=>$user_info->admin,
												'sp_code'=>$user_info->sp_code,

                                                'SiteUrl_id'=> base_url(),

						

					   );
			$this->session->set_userdata($sesUser);
			
		    // $this->nav_cust_connect(); 
			
            redirect($this->dashboard());    

                    }

                    else

                    {

                       $msg = "<div class='alert alert-danger alert-dismissible'>

                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>

                <h4><i class='icon fa fa-ban'></i> Alert!</h4>

                Invalid Username and Password!

                 </div>";

                set_flash($msg);

                $this->index();    

                    }   

            

            

            }

            else{

                $msg = "<div class='alert alert-danger alert-dismissible'>

                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>

                <h4><i class='icon fa fa-ban'></i> Alert!</h4>

                Invalid Username and Password!

                 </div>";

                set_flash($msg);

                $this->index();

            }

            

    }

    

    

    public function dashboard(){
         $loggedData=logged_user_data();
            if($loggedData==TRUE && $this->session->userdata('SiteUrl_id')== base_url()){
//           echo   $this->session->userdata('siteurl');    die;
              $data['title'] = "Dashboard";  
             /*model call for this week*/ 
              $data['sales'] = $this->analysis->top_sales_cust();  // show top 5 sales dealer
              $data['payment'] = $this->analysis->top_payment_cust();  // show top 5 payment dealer
              $data['secondary'] = $this->analysis->top_secondary_cust();  // show top 5 secondary of doctor/pharmacy
              $data['interaction'] = $this->analysis->top_interaction_cust(); // show top 5 interaction customer (doctor/pharmacy/dealer)
              $data['most_meet'] = $this->analysis->top_most_met_cust(); // show top 5 meet customer (doctor/pharmacy/dealer)
              $data['never_meet'] = $this->analysis->top_never_met_cust(); // show top 5 never meet customer (doctor/pharmacy/dealer)
//              pr(json_decode($data['sales']));

//              echo "<br>";

              /*end model for this week*/

              

              /*model call for this Month*/ 

              $data['sales_month'] = $this->analysis->top_sales_cust('-1 month');  // show top 5 sales dealer

               

              $data['payment_month'] = $this->analysis->top_payment_cust('-1 month');  // show top 5 payment dealer

              

              $data['secondary_month'] = $this->analysis->top_secondary_cust('-1 month');  // show top 5 secondary of doctor/pharmacy

              

              $data['interaction_month'] = $this->analysis->top_interaction_cust('-1 month'); // show top 5 interaction customer (doctor/pharmacy/dealer)

              

              $data['most_meet_month'] = $this->analysis->top_most_met_cust('-1 month'); // show top 5 meet customer (doctor/pharmacy/dealer)

              

              $data['never_meet_month'] = $this->analysis->top_never_met_cust('-1 month'); // show top 5 never meet customer (doctor/pharmacy/dealer)

//              pr(json_decode($data['sales_month'])); die;

              /*end model for this Month*/

              

              /*model call for this Quarter*/ 

              $data['sales_quarter'] = $this->analysis->top_sales_cust('-3 month');  // show top 5 sales dealer

               

              $data['payment_quarter'] = $this->analysis->top_payment_cust('-3 month');  // show top 5 payment dealer

              

              $data['secondary_quarter'] = $this->analysis->top_secondary_cust('-3 month');  // show top 5 secondary of doctor/pharmacy

              

              $data['interaction_quarter'] = $this->analysis->top_interaction_cust('-3 month'); // show top 5 interaction customer (doctor/pharmacy/dealer)

              

              $data['most_meet_quarter'] = $this->analysis->top_most_met_cust('-3 month'); // show top 5 meet customer (doctor/pharmacy/dealer)

              

              $data['never_meet_quarter'] = $this->analysis->top_never_met_cust('-3 month'); // show top 5 never meet customer (doctor/pharmacy/dealer)

              /*end model for this Quarter*/

              

              

              /*model call for this Year*/ 

              $data['sales_year'] = $this->analysis->top_sales_cust('-1 year');  // show top 5 sales dealer

               

              $data['payment_year'] = $this->analysis->top_payment_cust('-1 year');  // show top 5 payment dealer

              

              $data['secondary_year'] = $this->analysis->top_secondary_cust('-1 year');  // show top 5 secondary of doctor/pharmacy

              

              $data['interaction_year'] = $this->analysis->top_interaction_cust('-1 year'); // show top 5 interaction customer (doctor/pharmacy/dealer)

              

              $data['most_meet_year'] = $this->analysis->top_most_met_cust('-1 year'); // show top 5 meet customer (doctor/pharmacy/dealer)

              

              $data['never_meet_year'] = $this->analysis->top_never_met_cust('-1 year'); // show top 5 never meet customer (doctor/pharmacy/dealer)

              /*end model for this Year*/

              

              

              

        $this->load->get_view('dashboard/home_view',$data);

            }

            else{

//                echo "not"; die;

                $this->index();

            }

        

    }

    

    // used for switch the users account

    public function switch_account(){

        $userId = $this->input->post('userId') ? $this->input->post('userId') : 0;

//                 echo $userId; die;   

		$status = false;



		if($userId > 0){



			$status = $this->user->user_switch($userId);



		}

               

		echo $status; die;

    }



    



    public function logout(){

        

        

       $this->session->unset_userdata('userId');

       $this->session->unset_userdata('userEmail');

       

       $this->index();

    }
    
    public function email_regarding_tour(){
    	$this->load->model('tour_plan/tour_plan_model','tour');
		$lastday = date('t',strtotime('today'));//last day of month
		$time=strtotime(savedate());
		$message='';
		$sms='';
		$subject="STP Reminder Mail";
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
							$sms='Upload your Tour Plan on Bjain crop Software on urgent basis';
							$message='<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="'.base_url().'/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  <h3>Dear,</h3> <p>'.$sms.'</p><p><i>This is an auto generated email.</i></p><div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">'.get_user_name(28).'<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
							//echo $userData['email_id'].'<------>'.$userData['name'];
							$success =send_email($userData['email_id'], 'pharma.reports@bjain.com',$subject, $message);
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
							//echo $userData['email_id'].'<------>'.$userData['name'];
							$sms='Upload your Tour Plan on Bjain Corp Software on Today Positively';
							$message='<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="'.base_url().'/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  <h3>Dear,</h3> <p>'.$sms.'</p><p><i>This is an auto generated email.</i></p><div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">'.get_user_name(28).'<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
							$success =send_email($userData['email_id'],'pharma.reports@bjain.com', $subject, $message);
							$result = $this->tour->send_email_boss($userData['name']);//will send email to boss only
							$result = $this->tour->send_email_admin($userData['name']);//will send email to admin
						}
						catch(Exception $e)
						{
							//var_dump($e->getMessage());
						}
					}
				}
			}
		}
	}
	
	public function interaction_mismatch(){
    $this->load->model('dealer/Dealer_model','dealer');
    $interaction_data = $this->dealer->interact_details();
  }

  public function change_password()
  {
    $loggedData=logged_user_data();
    if($loggedData==TRUE && $this->session->userdata('SiteUrl_id')== base_url())
    {
      $data=$this->input->post();
      $success =  $this->user->change_user_password($data);
      if($success)
      {
        set_flash('<div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>Password changed successfully.</div>'); 
        redirect($_SERVER['HTTP_REFERER']);
      }
      else
      {
        set_flash('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>Some Issue in password change.Please Try Again.
          </div>');
        redirect($_SERVER['HTTP_REFERER']);
      }
    }
    else
    {
      $data['title'] = "Bjain Pharma ";
      $data['action'] = "user/check_login";
      $this->load->get_view('login_view',$data);
    }
  }
  
   /*
     * Developer: Shailesh Saraswat
     * Email: sss.shailesh@gmail.com
     * Dated: 24-SEP-2018
     * 
     * For auto update the information of customer into the navigon
     */
    
    public function nav_cust_connect(){
        
         $spcode = $this->session->userdata('sp_code');
        
        // if(!empty($spcode)){
         $mycustomer_API   = "https://www.bjaincorp.com/bjainpharma/nav_con/my_customer.php?spcode=".$spcode;
        // }else{
            // $mycustomer_API   = "https://www.bjaincorp.com/bjainpharma/nav_con/my_customer.php?spcode=";
        // }
       // echo $mycustomer_API;
         $my_customers = file_get_contents($mycustomer_API);
       // pr($my_customers); die;
       
                $sucess =  $this->cust_nav->add_update_dealer($my_customers);
         
                if($sucess==1){
                    // echo 'true';
                    return TRUE;
                }else{
                    // echo 'false';
                  return FALSE;
                }
                
    }
  
  
  
  
}

