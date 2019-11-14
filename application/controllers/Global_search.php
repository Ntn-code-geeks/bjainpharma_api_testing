<?php

defined('BASEPATH') OR exit('No direct script access allowed');



/* 

 * Niraj Kumar

 * Dated: 28/09/2017

 * 

 * 

 * This Controller is for Searching the data in easy way

 */



class Global_search extends Parent_admin_controller {

    

    function __construct() 

    {

        parent::__construct();



        $loggedData=logged_user_data();

            

            if(empty($loggedData)){

                redirect('user'); 

            }

        $this->load->model('doctor/doctor_model','doctor');

        $this->load->model('dealer/dealer_model','dealer');

        $this->load->model('search_model','search');

        $this->load->model('permission/permission_model','permission'); 

    }

    

    public function search(){

         $data['title'] = "Search";

       

         $request = $this->input->get();

//         pr($request); die;

        if (empty($request)){

          

            $req = $this->session->userdata('table_search');

        }

else 

{

  if(!empty($request['table_search'])){

      $this->session->set_userdata('table_search',$request['table_search']);

      $req=$request['table_search'];

  }  

    else{

        redirect('user/dashboard');

    }

    

}    

 $data['page_name']="Search Result for : $req";

 

   $data['statename'] = $this->dealer->state_list();

   $data['meeting_sample'] = $this->doctor->meeting_sample_master();

   $data['dealer_list']= $this->dealer->dealer_list(); 

   $data['pharma_list']= $this->permission->pharmacy_list(logged_user_cities()); 



        $data['dealer_data'] = $this->search->search_dealermaster_info($req);

         $data['users_team'] = $this->permission->user_team(); // show child and boss users

        $data['doctor_data'] = $this->search->search_doctormaster_info($req);

        

        $data['pharma_data'] = $this->search->search_pharmacymaster_info($req);

        $data['request'] = $req;

        

//        pr( $data['doctor_data']); die;

        

        $data['action'] = 'global_search/search';



       $this->load->get_view('dealer_doctor_search_view',$data);

        

        

        

    }

    

	

	

	

	    public function doc_search(){

         $data['title'] = "Doctor Search";

       

         $request = $this->input->get();

//         pr($request); die;

        if (empty($request)){

          

            $req = $this->session->userdata('table_search');

        }

		else 

		{

		  if(!empty($request['table_search'])){

			  $this->session->set_userdata('table_search',$request['table_search']);

			  $req=$request['table_search'];

		  }  

			else{

				redirect('user/dashboard');

			}

			

		}    

		$data['page_name']="Search Result for : $req";

	 

	   $data['statename'] = $this->dealer->state_list();

	   $data['meeting_sample'] = $this->doctor->meeting_sample_master();

	   $data['dealer_list']= $this->dealer->dealer_list(); 

	   $data['pharma_list']= $this->permission->pharmacy_list(logged_user_cities()); 



		$data['dealer_data'] = '';

		$data['users_team'] = ''; // show child and boss users

		$data['doctor_data'] =$this->search->search_doctor_info($req);



		$data['pharma_data'] = '';//$this->search->search_pharmacy_info($req);

		$data['request'] = $req;



		//        pr( $data['doctor_data']); die;



		$data['action'] = 'global_search/doc_search';



		$this->load->get_view('dealer_doctor_search_view',$data);

  

    }

	

	

	public function pharma_search(){

         $data['title'] = "Sub Dealer Search";

       

         $request = $this->input->get();

//         pr($request); die;

        if (empty($request)){

          

            $req = $this->session->userdata('table_search');

        }

		else 

		{

		  if(!empty($request['table_search'])){

			  $this->session->set_userdata('table_search',$request['table_search']);

			  $req=$request['table_search'];

		  }  

			else{

				redirect('user/dashboard');

			}

			

		}    

		$data['page_name']="Search Result for : $req";

	 

	   $data['statename'] = $this->dealer->state_list();

	   $data['meeting_sample'] = $this->doctor->meeting_sample_master();

	   $data['dealer_list']= $this->dealer->dealer_list(); 

	   $data['pharma_list']= $this->permission->pharmacy_list(logged_user_cities()); 



		$data['dealer_data'] = '';

		$data['users_team'] = ''; // show child and boss users

		$data['doctor_data'] = '';//$this->search->search_doctor_info($req);



		$data['pharma_data'] =$this->search->search_pharmacy_info($req);

		$data['request'] = $req;



		//        pr( $data['doctor_data']); die;



		$data['action'] = 'global_search/pharma_search';



		$this->load->get_view('dealer_doctor_search_view',$data);

  

    }

	

	

	

    public function search_suggestion(){

          $request = $this->input->post();

          

           if (empty($request)){

           

            $req = $this->session->userdata('search');

          }

            else 

            {



                $this->session->set_userdata('search',$request['search']);

               $req=$request['search'];



            }    

		$data['dealer_data'] = json_decode($this->search->search_dealermaster_info($req));

        $data['doctor_data'] = json_decode($this->search->search_doctormaster_info($req));

        $data['cities'] = json_decode($this->search->search_city_info($req));

        $data['pharma_data'] = json_decode($this->search->search_pharmacymaster_info($req));



        if(!empty($data['dealer_data'])){

        foreach ($data['dealer_data'] as $k_d=>$val_d){

        echo  '<div class="show" align="left">';

        echo  '<span class="name">'.$val_d->d_name.'</span>&nbsp;<br/>'.$val_d->d_email.'';

//       echo  '<span class="name">'.$val_d->d_city.'</span>';

        echo '</div>';

        }

        }

        else if(!empty($data['doctor_data'])){

          

        foreach ($data['doctor_data'] as $k_doc=>$val_doc){

        echo  '<div class="show" align="left">';

        echo  '<span class="name">'.$val_doc->d_name.'</span>&nbsp;<br/>'.$val_doc->d_email.'';

//        echo  '<span class="name">'.$val_doc->c_city.'</span>';

        echo '</div>';

        }

            

            

        }

        

        if(!empty($data['cities'])){

          

        foreach ($data['cities'] as $k_c=>$val_c){

        echo  '<div class="show" align="left">';

        echo  '<span class="name">'.$val_c->cityname.'</span>&nbsp';

//        echo  '<span class="name">'.$val_doc->c_city.'</span>';

        echo '</div>';

        }

           

            

        }

        if(!empty($data['pharma_data'])){

          

        foreach ($data['pharma_data'] as $k_p=>$val_p){

        echo  '<div class="show" align="left">';

        echo  '<span class="name">'.$val_p->com_name.'</span>&nbsp';

//        echo  '<span class="name">'.$val_doc->c_city.'</span>';

        echo '</div>';

        }

            

            

        }

        

        

        if(!empty($data['doctor_data'])){

          

        foreach ($data['doctor_data'] as $k_doc=>$val_doc){

        echo  '<div class="show" align="left">';

        echo  '<span class="name">'.$val_doc->d_name.'</span>&nbsp;<br/>'.$val_doc->d_email.'';

//        echo  '<span class="name">'.$val_doc->c_city.'</span>';

        echo '</div>';

        }

            

            

        }

        

        if(empty($data['doctor_data']) && empty($data['dealer_data']) ){

            

             echo  '<div class="show" align="left">';

        echo  '<span class="name">No Result Found</span><br/>';

        echo '</div>'; 

            

        }

        

        

    }

	

	

	

	    public function search_suggestion_doctor(){

          $request = $this->input->post();

          

           if (empty($request)){

           

            $req = $this->session->userdata('search');

          }

            else 

            {



                $this->session->set_userdata('search',$request['search']);

               $req=$request['search'];



            }    

        $data['doctor_data'] = json_decode($this->search->search_doctormaster_info($req));

        $data['cities'] = json_decode($this->search->search_city_info($req));

  

        

        if(!empty($data['cities'])){

          

        foreach ($data['cities'] as $k_c=>$val_c){

        echo  '<div class="show" align="left"  >';

        echo  '<span class="name">'.$val_c->cityname.'</span>&nbsp';

//        echo  '<span class="name">'.$val_doc->c_city.'</span>';

        echo '</div>';

        }

		}

        

        

        if(!empty($data['doctor_data'])){

          

        foreach ($data['doctor_data'] as $k_doc=>$val_doc){

        echo  '<div class="show" align="left" style="height:auto ;word-wrap: break-word;">';

        echo  '<span class="name">'.$val_doc->d_name.'</span><br/>'.$val_doc->d_email.'<br/>City:'.$val_doc->c_city;

//        echo  '<span class="name">'.$val_doc->c_city.'</span>';

        echo '</div>';

        }

            

            

        }

        

        if(empty($data['doctor_data'])&& empty($data['cities'])){

            

             echo  '<div class="show" align="left">';

        echo  '<span class="name">No Result Found</span><br/>';

        echo '</div>'; 

            

        }

        

        

    }

	

	

	 public function search_suggestion_pharma(){

          $request = $this->input->post();

          

           if (empty($request)){

           

            $req = $this->session->userdata('search');

          }

            else 

            {



                $this->session->set_userdata('search',$request['search']);

               $req=$request['search'];



            }    

        $data['cities'] = json_decode($this->search->search_city_info($req));

        $data['pharma_data'] = json_decode($this->search->search_pharmacymaster_info($req));

        

        if(!empty($data['cities'])){

          

        foreach ($data['cities'] as $k_c=>$val_c){

        echo  '<div class="show" align="left" >';

        echo  '<span class="name">'.$val_c->cityname.'</span>&nbsp';

//        echo  '<span class="name">'.$val_doc->c_city.'</span>';

        echo '</div>';

        }

           

            

        }

        if(!empty($data['pharma_data'])){

          

        foreach ($data['pharma_data'] as $k_p=>$val_p){

        echo  '<div class="show" style="height:auto ;word-wrap: break-word;">';

        echo  '<span class="name">'.$val_p->com_name.'</span><br/>City : '.$val_p->c_city;

//        echo  '<span class="name">'.$val_doc->c_city.'</span>';

        echo '</div>';

        }

            

            

        }



        

        if(empty($data['pharma_data']) && empty($data['cities']) ){

            

             echo  '<div class="show" align="left">';

        echo  '<span class="name">No Result Found</span><br/>';

        echo '</div>'; 

            

        }

        

        

    }

	

	   public function search_suggestion_dealer(){

          $request = $this->input->post();

          

           if (empty($request)){

           

            $req = $this->session->userdata('search');

          }

            else 

            {



                $this->session->set_userdata('search',$request['search']);

               $req=$request['search'];



            }    

       $data['dealer_data'] = json_decode($this->search->search_dealermaster_info($req));

     

        $data['cities'] = json_decode($this->search->search_city_info($req));

      



        if(!empty($data['dealer_data'])){

        foreach ($data['dealer_data'] as $k_d=>$val_d){

        echo  '<div class="show" align="left" style="height:auto ;word-wrap: break-word;">';

        echo  '<span class="name">'.$val_d->d_name.'</span><br/>'.$val_d->d_email.'<br/>City:'.$val_d->d_city;

//       echo  '<span class="name">'.$val_d->d_city.'</span>';

        echo '</div>';

        }

        }

       

        

        if(!empty($data['cities'])){

          

        foreach ($data['cities'] as $k_c=>$val_c){

        echo  '<div class="show" align="left">';

        echo  '<span class="name">'.$val_c->cityname.'</span>&nbsp';

//        echo  '<span class="name">'.$val_doc->c_city.'</span>';

        echo '</div>';

        }

           

            

        }



        

        if(empty($data['cities']) && empty($data['dealer_data']) ){

            

             echo  '<div class="show" align="left">';

        echo  '<span class="name">No Result Found</span><br/>';

        echo '</div>'; 

            

        }

        

        

    }

	

	 public function dealer_search(){

         $data['title'] = "Dealer Search";

       

         $request = $this->input->get();

//         pr($request); die;

        if (empty($request)){

          

            $req = $this->session->userdata('table_search');

        }

		else 

		{

		  if(!empty($request['table_search'])){

			  $this->session->set_userdata('table_search',$request['table_search']);

			  $req=$request['table_search'];

		  }  

			else{

				redirect('user/dashboard');

			}

			

		}    

		 $data['page_name']="Search Result for : $req";

 

	   $data['statename'] = $this->dealer->state_list();

	   $data['meeting_sample'] = $this->doctor->meeting_sample_master();

	   $data['dealer_list']= $this->dealer->dealer_list(); 

	   $data['pharma_list']= $this->permission->pharmacy_list(logged_user_cities()); 



        $data['dealer_data'] = $this->search->search_dealer_info($req);

         $data['users_team'] = ''; // show child and boss users

        $data['doctor_data'] = '';

        

        $data['pharma_data'] = '';

        $data['request'] = $req;

        

//        pr( $data['doctor_data']); die;

        

        $data['action'] = 'global_search/dealer_search';



		$this->load->get_view('dealer_doctor_search_view',$data);

        

        

        

    }

    

    

}



?>