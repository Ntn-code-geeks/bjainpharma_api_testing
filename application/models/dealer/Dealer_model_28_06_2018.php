<?php



/* 

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */

class Dealer_model extends CI_Model {

    

    

    

    public function dealer_list_all(){  // used to show list of dealer for dealer organization

        

         $arr ="d.dealer_id,d.dealer_name,c.city_name";

        $this->db->select($arr);

        $this->db->from('dealer d');

      

        $this->db->join("city c" , "c.city_id=d.city_id");

     

        

        $query= $this->db->get();

        

        if($this->db->affected_rows()){

            

            return json_encode($query->result_array());

        }

        else{

            

            return FALSE;

        }

        

    }



    public function dealer_list(){  // used to show list of dealer in doctor section

         $cities_are = logged_user_cities();

         $city_id=explode(',', $cities_are);

        

        $arr ="d.dealer_id,d.dealer_name,c.city_name,d.status,d.blocked";

        $this->db->select($arr);

        $this->db->from('dealer d');

      

        $this->db->join("city c" , "c.city_id=d.city_id");

        

        $this->db->where('d.status',1);

        $this->db->where('d.blocked',0);

        

         if(!is_admin()){

             

        $this->db->where('d.crm_user_id', logged_user_data());

      

     

        

         

           if(!empty($cities_are)){

             

                $k=0; 

                $where=' ( ';

            foreach($city_id as $value){

//          $this->db->or_where('d.city_id',$value);

              $where  .= " d.city_id = $value ";

                 $k++;

               if($k > 0 && count($city_id)!=$k){

                   $where .= " OR ";

               }

            }

            $where  .= " ) ";

           }

           

        $this->db->or_where($where);  // for Showing dealer list in Pharmacy & Doctor for adding dealer

          }

        

        $query= $this->db->get();   

//        echo $this->db->last_query(); die; 

        if($this->db->affected_rows()){

            

            return json_encode($query->result_array());

        }

        else{

            

            return FALSE;

        }

   

        

    }

    

    /*

     * @author: Niraj Kumar

     * Dated:03-nov-2017

     * 

     * for Dealer list for interaction

     */

    public function add_edit_dealer_list(){

      

         $cities_are = logged_user_cities();

         $city_id=explode(',', $cities_are);

        

        $arr ="d.dealer_id,d.dealer_name,c.city_name,d.status,d.blocked";

        $this->db->select($arr);

        $this->db->from('dealer d');

      

        $this->db->join("city c" , "c.city_id=d.city_id");

        

        

         if(!is_admin()){

             

        

         $this->db->where('d.crm_user_id', logged_user_data());

//        $this->db->where('d.status',1);

//        $this->db->where('d.blocked',0);

     

           if(!empty($cities_are)){

             

                $k=0; 

                $where=' ( ';

            foreach($city_id as $value){

//          $this->db->or_where('d.city_id',$value);

              $where  .= " d.city_id = $value ";

                 $k++;

               if($k > 0 && count($city_id)!=$k){

                   $where .= " OR ";

               }

            }

            $where  .= " ) ";

           }

           

        $this->db->or_where($where);  // for Showing dealer list in Pharmacy & Doctor for adding dealer

         }

        

        $query= $this->db->get();   

//        echo $this->db->last_query(); die; 

        if($this->db->affected_rows()){

            

            return json_encode($query->result_array());

        }

        else{

            

            return FALSE;

        }

        

        

    }





    /*code for add Dealer with filter by state,city*/

    public function cities($id=''){

        $arr ="city_name,city_id";

        $this->db->select($arr);

        $this->db->from('city c');

        if($id!=''){

             $this->db->where('c.state_id',$id);

        }

        

       

      

        $query= $this->db->get();

        

        if($this->db->affected_rows()){

            

            return $query->result_array();

        }

        else{

            

            return FALSE;

        }

   

        

    }

    
    public function insert_ta_da($data){
        //SELECT * FROM `pharma_interaction_doctor` WHERE create_date='2018-05-22' and crm_user_id=92 order by last_update DESC
       $previous=date('Y-m-d', strtotime('-1 day', strtotime($data['doi_doc'])));
       $interaction_day=date('D', strtotime($data['doi_doc']));
       $user_id=logged_user_data();
       $designation_id=get_user_deatils($user_id)->user_designation_id;
       $location_type=0;
       $internet_charge=10;
       $distance=1;
       $source_city=get_interaction_source();//one date before from interaction
       $source_city_id=get_interaction_source_id();//one date before from interaction
       $destination_city=0;
       $destination_city_id=0;
       $ta=0;
       $da=0;
       $rs_per_km=0;//get using distance
       $meet_id=$data['dealer_view_id'];
       if(!is_numeric($data['dealer_view_id']))
       {
            if(substr($data['dealer_view_id'],0,3)=='doc'){
                //doctor
                $destination_city=get_destination_interaction('doctor_list',$data['dealer_view_id'],1);
                $destination_city_id=get_destination_interaction_id('doctor_list',$data['dealer_view_id'],1);
            }
            else{
               //pharma 
                $destination_city=get_destination_interaction('pharmacy_list',$data['dealer_view_id'],2);
                $destination_city_id=get_destination_interaction_id('pharmacy_list',$data['dealer_view_id'],2);
            }
        }
        else{
           //dealer 
            $destination_city=get_destination_interaction('dealer',$data['dealer_view_id'],3);
            $destination_city_id=get_destination_interaction_id('dealer',$data['dealer_view_id'],3);
        }
        if($data['up'] && $destination_city==$source_city && $destination_city!=get_user_deatils(logged_user_data())->headquarters_city)
        {
            /*echo get_user_deatils(logged_user_data())->hq_city_pincode;
            echo $source_city;
            die;*/
            $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=".$source_city."&destinations=".get_user_deatils(logged_user_data())->hq_city_pincode."&key=AIzaSyCR0sPg9k9PZJ7mBOSJiHxsUkPY96MJCtg";
        }
        else
        {

            $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=".$source_city."&destinations=".$destination_city."&key=AIzaSyCR0sPg9k9PZJ7mBOSJiHxsUkPY96MJCtg";
        }
       /* echo $url;
        die;*/
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response);
        $status = $response_a->status;
        //die;
        if ($status == 'OK' && $response_a->rows[0]->elements[0]->status == 'OK')
        {
           $distance=explode(' ',$response_a->rows[0]->elements[0]->distance->text)[0];
        }
        else
        {
            $distance=1;
        }
        if($distance>=0 && $distance<=100)
        {
            if($designation_id==5 || $designation_id==6)
            {
                $rs_per_km=get_km_expanse(5);
            }
            else
            {
                $rs_per_km=get_km_expanse(1);
            }
        }
        elseif($distance>=101 && $distance<=300)
        {
            if($designation_id==5 || $designation_id==6)
            {
                $rs_per_km=get_km_expanse(6);
            }
            else
            {
                $rs_per_km=get_km_expanse(2);
            }
        }
        elseif($distance>=301 && $distance<=500)
        {
            if($designation_id==5 || $designation_id==6)
            {
                $rs_per_km=get_km_expanse(7);
            }
            else
            {
                $rs_per_km=get_km_expanse(3);
            }
        }
        else
        {
            $rs_per_km=get_km_expanse(4);
        }
        if( $rs_per_km==0)
        {
            $ta=0;
        }
        else
        {
            if($data['up'])
            {
                if($destination_city==$source_city && $destination_city!=get_user_deatils(logged_user_data())->headquarters_city)
                {
                    $ta=$rs_per_km*$distance;
                }
                else
                {
                    $ta=$rs_per_km*$distance*2;
                }
            }
            else
            {
                $ta=$rs_per_km*$distance;
            }
        }
        if($data['up'])
        {
            if($destination_city==$source_city && $destination_city!=get_user_deatils(logged_user_data())->headquarters_city)
            {
                $distance=$distance;
            }
            else
            {
                $distance=$distance*2;
            }
            
        }
        $tour_date = date('Y-m-d', strtotime($data['doi_doc']));
        $tour_data = array(
            'user_id'=>$user_id,
            'designation_id'=>$designation_id,
            'internet_charge'=>10,
            'distance'=>$distance,
            'source_city'=>$source_city_id,
            'destination_city'=>$destination_city_id,
            'source_city_pin'=>$source_city,
            'destination_city_pin'=>$destination_city,
            'rs_per_km'=>$rs_per_km,
            'is_stay'=>$data['stay'],
            'up_down'=>$data['up'],
            'ta'=>$ta,
            'meet_id'=>$meet_id,
            'doi'=>$tour_date,
            'created_date'=>savedate(),
            'updated_date'=>savedate(),
            'status'=>1, 
        );
        $this->db->insert('ta_da_report',$tour_data); 
    }
    

    public function state_list(){
         $arr ="state_name,state_id";
        $this->db->select($arr);
        $this->db->from('state s');
        $query= $this->db->get();
        if($this->db->affected_rows()){
          return json_encode($query->result_array());
        }
        else{
          return FALSE;
        }
    }

    public function filter_dealer_name($id){
        $arr ="s.dealer_id,s.dealer_name";
        $this->db->select($arr);
        $this->db->from('dealer s');
        $this->db->where("s.city_id" ,$id);
        $query= $this->db->get();
        if($this->db->affected_rows()){
            return $query->result_array();
        }
        else{
            return FALSE;
        }
    }

    

    /* end of code for add dealer data*/



    public function add_dealermaster($data,$d_id='',$dealer_name=''){
        if($d_id !=''){   // for update
            if(empty($dealer_name)){
                $dealer_name=$data['dealer_name'];
            }
//          pr($data); echo $d_id; die;
//             echo "update"; die;
           $dealer_data = 
                array(
                    'dealer_name'=>$dealer_name,
                    'd_email'=>$data['dealer_email'],
                    'd_phone'=>$data['dealer_num'],
                    'd_alt_phone'=>$data['dealer_alt_num'],
                    'city_pincode'=>$data['city_pin'],
                    'd_about'=>$data['about_d'],
                    'd_address'=>$data['d_address'],
                    'city_id'=>$data['dealer_city'],
                    'state_id'=>$data['dealer_state'],
                    'status'=>1,
                    'added_date'=> savedate(),
                    'crm_user_id' =>logged_user_data(),
                    'doc_navigate_id'=>$data['doc_navigon'],
                );
           $this->db->where('dealer_id',$d_id);
           $this->db->update('dealer',$dealer_data);
//         echo $this->db->last_query(); die;      
            if ($this->db->affected_rows() === TRUE)
            {
              return true;
            }
            else{
              return false;
            }   
        }
        else{ // for insert dealer data
            $dealer_data = 
                array(
                    'dealer_name'=>$data['dealer_name'],
                    'city_id'=>$data['dealer_city'],
                    'state_id'=>$data['dealer_state'],
                    'd_email'=>$data['dealer_email'],
                    'd_phone'=>$data['dealer_num'],
                    'd_alt_phone'=>$data['dealer_alt_num'],
                    'd_about'=>$data['about_d'],
                    'd_address'=>$data['d_address'],
                    'status'=>1,
                    'added_date'=> savedate(),
                    'crm_user_id' =>logged_user_data(),
                    'doc_navigate_id'=>$data['doc_navigon'],
                );
            $this->db->insert('dealer',$dealer_data); 
            return ($this->db->affected_rows() != 1) ? false : true; 
        }
    }

    

    // for show data of dealers

    public function dealermaster_info($limit='',$start='',$data='',$city_search=''){

        $cities_are = logged_user_cities();

        $city_id=array();

        if($city_search=='')

        {

            $city_id=explode(',', $cities_are);

        }

        else

        {

            $city_id[]=$city_search;

        }

        

       $desig_id=logged_user_desig();

       $log_userid = logged_user_data();

       

        $arr = "d.dealer_id as id,d.d_email as d_email,d.d_phone as d_ph,d.dealer_name as d_name,d.dealer_are,d.gd_id,d.status,d.blocked,d.city_pincode as city_pincode,,d.city_id as city_id";

        $this->db->select($arr);

        $this->db->from("dealer d");

//      $this->db->join("dealer s" , "s.dealer_id=sm.s_id");

        //$this->db->join("city c" , "c.city_id=d.city_id");

        //$this->db->join("state st" , "st.state_id=d.state_id");

        $this->db->join('pharma_users pu','pu.id=d.crm_user_id');

         if(!empty($data)){



         $this->db->like('d.dealer_name',$data);

         $this->db->or_like('d.d_email',$data);

         $this->db->or_like('d.d_phone',$data);

         $this->db->or_like('c.city_name',$data);

         $this->db->or_like('st.state_name',$data);

        

         $this->db->group_by('`d`.`dealer_id`');

//     }

        }

      

         $this->db->where('d.gd_id IS NULL',null,true);

         if($city_search!='')

        {



            if(is_admin()){ 

                $this->db->where('d.city_id',$city_search);

            }

        }

         

           if(!is_admin()){  // this condition is not for admin user

         

          

            if($city_search=='')

            {

                $where='( ';

                $where  .= "  pu.user_designation_id >= $desig_id ";

                

                 $where  .= " AND d.crm_user_id = $log_userid ";

            }else{

                $where='( 1=2 ';

            }

              if(!empty($cities_are)){

             

                $k=0;    

            foreach($city_id as $value){

            

                $where  .= " OR d.city_id = $value ";

               

                $k++;

            }

        // $this->db->or_where("FIND_IN_SET('','') !=", 0); 

         }    

               

                 

                 

             $where  .= " ) ";

         

         $this->db->where($where);

           }

        

       // $this->db->limit($limit, decode($start));

        

        $this->db->order_by("d.dealer_name","ASC");

        

        $query = $this->db->get();

    //echo $this->db->last_query(); die;

        

         if($this->db->affected_rows()){

            

            return json_encode($query->result_array());

        }

        else{

            

            return FALSE;

        }

        

    }

    

     public function sub_dealer_totaldata($data='',$city_search=''){

        $cities_are = logged_user_cities();

        $city_id=array();

        if($city_search=='')

        {

            $city_id=explode(',', $cities_are);

        }

        else

        {

            $city_id[]=$city_search;

        }

       $desig_id=logged_user_desig();

       $log_userid = logged_user_data();

       

        $arr = "d.dealer_id as id,d.d_email as d_email,d.d_phone as d_ph,d.dealer_name as d_name,c.city_name as d_city,d.dealer_are,d.gd_id,d.status,d.blocked";

        $this->db->select($arr);

        $this->db->from("dealer d");

//      $this->db->join("dealer s" , "s.dealer_id=sm.s_id");

        $this->db->join("city c" , "c.city_id=d.city_id");

        $this->db->join("state st" , "st.state_id=d.state_id");

      $this->db->join('pharma_users pu','pu.id=d.crm_user_id');

         if(!empty($data)){



         $this->db->like('d.dealer_name',$data);

         $this->db->or_like('d.d_email',$data);

         $this->db->or_like('d.d_phone',$data);

         $this->db->or_like('c.city_name',$data);

         $this->db->or_like('st.state_name',$data);

        

         $this->db->group_by('`d`.`dealer_id`');

//     }

        }

      

         $this->db->where('d.gd_id IS NULL',null,true);

          if($city_search!='')

            {



                if(is_admin()){ 

                    $this->db->where('d.city_id',$city_search);

                }

            }

           if(!is_admin()){  // this condition is not for admin user

         

          if($city_search=='')

            {

                $where='( ';

                $where  .= "  pu.user_designation_id >= $desig_id ";

                

                 $where  .= " AND d.crm_user_id = $log_userid ";

            }else{

                $where='( 1=2 ';

            }

            

              if(!empty($cities_are)){

             

                $k=0;    

            foreach($city_id as $value){

         

                $where  .= " OR d.city_id = $value ";

               

                $k++;

            }

        // $this->db->or_where("FIND_IN_SET('','') !=", 0); 

         }    

               

                 

                 

             $where  .= " ) ";

         

         $this->db->where($where);

           }

        

        //$this->db->limit($limit, decode($start));

        

        $this->db->order_by("d.dealer_name","ASC");

        

        $query = $this->db->get();

// echo $this->db->last_query(); //die;

        

         if($this->db->affected_rows()){

            //pr($city_id);

            return  $query->num_rows();

            //die;

        }

        else{

            

            return FALSE;

        }

        

    }

     public function main_dealermaster_info($limit='',$start='',$data=''){

        

         $cities_are = logged_user_cities();

//       echo $cities_are; die;

        $city_id=explode(',', $cities_are);

         

         $desig_id=logged_user_desig();

       $log_userid = logged_user_data();

        

        $arr = "d.dealer_id as id,d.d_email as d_email,d.d_phone as d_ph,d.dealer_name as d_name,c.city_name as d_city,d.dealer_are,d.gd_id,d.status,d.blocked";

        $this->db->select($arr);

        $this->db->from("dealer d");

//      $this->db->join("dealer s" , "s.dealer_id=sm.s_id");

        $this->db->join("city c" , "c.city_id=d.city_id");

        $this->db->join("state st" , "st.state_id=d.state_id");

       $this->db->join('pharma_users pu','pu.id=d.crm_user_id');

         if(!empty($data)){

              $this->db->join("srm_contact_list cl","cl.s_id=s.dealer_id","LEFT OUTER");

//     if(!empty($data['dealer_state'])){   

//     $this->db->where('s.state_id',$data['dealer_state']);

//     }

//     if(!empty($data['dealer_city'])){   

//     $this->db->where('s.city_id',$data['dealer_city']);

//     }

//     if(!empty($data['table_search'])){

         

         $this->db->like('s.dealer_name',$data);

         $this->db->or_like('s.s_email',$data);

         $this->db->or_like('s.s_phone',$data);

         $this->db->or_like('c.city_name',$data);

         $this->db->or_like('st.state_name',$data);

         $this->db->or_like('cl.c_name',$data);

         $this->db->group_by('`s`.`dealer_id`');

//     }

        }

      

         $this->db->where('d.gd_id IS NOT NULL',null,false);

        

         

           if(logged_user_data()!=28 && logged_user_data()!=29 &&  logged_user_data()!=32){  // this condition is not for admin user

         

          $where='( ';

           

          $where  .= "  pu.user_designation_id >= $desig_id ";

                

                 $where  .= " AND d.crm_user_id = $log_userid ";       

          

          

              if(!empty($cities_are)){

             

                $k=0;    

            foreach($city_id as $value){

         

                $where  .= " OR d.city_id = $value ";

               

                $k++;

            }

        // $this->db->or_where("FIND_IN_SET('','') !=", 0); 

         }    

               

                 

                 

             $where  .= " ) ";

         

         $this->db->where($where);

           }

         

         

       // $this->db->limit($limit, decode($start));

        

        $this->db->order_by("d.dealer_name","ASC");

        

        $query = $this->db->get();

//         echo $this->db->last_query(); die;

        

         if($this->db->affected_rows()){

            

            return json_encode($query->result_array());

        }

        else{

            

            return FALSE;

        }

        

    }

      public function main_dealer_totaldata($data=''){
      //  pr($data);die;
        $arr = "d.dealer_id as id";
        $this->db->select($arr);
        $this->db->from("dealer d");
        $this->db->join("city c" , "c.city_id=d.city_id");
        $this->db->join("state st" , "st.state_id=d.state_id");

//        $this->db->join("srm_contact_list cl","cl.s_id=sm.dealer_id","LEFT OUTER");

        if(!empty($data)){

//     if(!empty($data['dealer_state'])){   

//     $this->db->where('sm.state_id',$data['dealer_state']);

//     }

//     if(!empty($data['dealer_city'])){   

//     $this->db->where('sm.city_id',$data['dealer_city']);

//     }

//     if(!empty($data['table_search'])){

         

         $this->db->like('d.dealer_name',$data['table_search']);

         $this->db->or_like('d.d_email',$data['table_search']);

         $this->db->or_like('d.d_phone',$data['table_search']);

         $this->db->or_like('c.city_name',$data['table_search']);

         $this->db->or_like('st.state_name',$data['table_search']);

//          $this->db->or_like('cl.c_name',$data);

     }

//        }

       $this->db->where('d.gd_id IS NOT NULL',null,false);

        

        $query = $this->db->get();

//         echo $this->db->last_query(); die;

        if ($query->num_rows() > 0) {



          $data=$query->num_rows();

 

            return $data;

        }

        else

            {

               return false;

         }

        

    }

   

    // edit dealer data info

    public function edit_dealer($d_id){

        

          $arr = "d.doc_navigate_id as doc_navigon,d.city_pincode as city_pincode,d.city_pincode as city_pincode,d.dealer_id as d_id,d.d_alt_phone as alt_phone,d.d_address,d.dealer_name,d.d_email as d_email,d.d_phone as d_ph,d.d_about,d.dealer_are,d.gd_id,d.state_id,d.city_id,c.city_name";

        $this->db->select($arr);

        $this->db->from("dealer d");

        $this->db->join("city c" , "d.city_id=c.city_id");

        $this->db->where("d.dealer_id",$d_id);

        

        

          $query = $this->db->get();

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows()){

            

            return json_encode($query->row());

        }

        else{

            

            return FALSE;

        }

        

    }

    

    // check dealer is already in my master list

    public function check_dealer($s_id){

        

        $this->db->select('*');

        $this->db->from('dealer sm');

        $this->db->where('sm.dealer_id',$s_id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {



            return $query->result_array();

        }

        else

            {

               return FALSE;

         }

        

    }

    

    

    // contacts of dealer

    public function doctor_of_dealer_list($id=''){

        

        if($id!=''){

//             $sm_id= urisafedecode($id);

             $arr = "doc.doctor_id as id,doc.d_id as dealers_id,doc.doc_name as d_name,doc.doc_email as d_email,doc.doc_phone as d_ph,doc.doc_gender,doc.doc_dob,doc.doc_married_status as married_status,doc.doc_spouse_name as spouse_name,doc.doc_spouse_email as spouse_email,doc.doc_address as d_address,doc.doc_about as d_about";

        $this->db->select($arr);

        $this->db->from("doctor_list doc");  

      

        $this->db->where("FIND_IN_SET('$id',doc.d_id) !=", 0);

        

        

        $query = $this->db->get();

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows()){

            

            return json_encode($query->result_array());

        }

        else{

            

            return FALSE;

        }

        }

        

        

    }

    

     // contacts of dealer with pharmacy

    public function pharmacy_of_dealer_list($id=''){

        

        if($id!=''){

//             $sm_id= urisafedecode($id);

        $arr = "pharma.pharma_id as id,pharma.d_id as dealers_id,pharma.company_name as com_name,pharma.company_email as com_email,pharma.company_phone as com_ph";

        $this->db->select($arr);

        $this->db->from("pharmacy_list pharma");  

      

        $this->db->where("FIND_IN_SET('$id',pharma.d_id) !=", 0);

       

        

        $query = $this->db->get();

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows()){

            

            return json_encode($query->result_array());

        }

        else{

            

            return FALSE;

        }

        }

        

        

    }

    

    

    // show appointment of dealer

    public function appointment_of_dealer_list($id=''){

        

         if($id!=''){

//             $sm_id= urisafedecode($id);

        $arr = "ap.doa,ap.toa,ap.toa_end,ap.reason_to_meet";

        $this->db->select($arr);

        $this->db->from("srm_appointment ap");  

//        $this->db->join("dealer s" , "s.dealer_id=ap.c_id");

//        $this->db->join("srm_contact_list cl","cl.contact_id=ap.c_id");

//        $this->db->join("dealer s","cl.s_id=s.dealer_id");

        $this->db->where('ap.c_id',$id);

        $this->db->where('ap.status',1);

        

        

        $query = $this->db->get();

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows()){

            

            return json_encode($query->result_array());

        }

        else{

            

            return FALSE;

        }

        

        }

        

        

        

    }









    // add organization data who have multipile dealers

    public function add_group_dealermaster($data,$dm_id=''){

//       pr($data); die;

        if($dm_id !=''){

            if(isset($data['group_dealer_id'])){

              $group_dealer_id=implode(',',$data['group_dealer_id']);

            }

             if(isset($group_dealer_id)){

                

                 $dealer_data = 

                array(

                    'dealer_name'=>$data['group_dealer_name'],

                    'd_email'=>$data['group_dealer_email'],

                    'd_phone'=>$data['group_dealer_num'],
                    'city_pincode'=>$data['city_pin'],
                    'state_id'=>$data['dealer_state'],

                    'city_id'=>$data['dealer_city'],

                    'd_about'=>$data['group_about_d'],

                    'dealer_are'=>$group_dealer_id,

                    'gd_id' =>'gorg_100',

                    'd_address'=>$data['d_address'],

                    'status'=>1,

                    'added_date'=> savedate(),

                    'crm_user_id' =>logged_user_data(),

                     'doc_navigate_id'=>$data['doc_navigon'],

                );

             }

             else{

               

                //  echo "else"; die;

                 $dealer_data = 

                array(

                    'dealer_name'=>$data['group_dealer_name'],

                    'd_email'=>$data['group_dealer_email'],

                    'd_phone'=>$data['group_dealer_num'],
                    'city_pincode'=>$data['city_pin'],
                    'state_id'=>$data['dealer_state'],

                    'city_id'=>$data['dealer_city'],

                    'd_about'=>$data['group_about_d'],

                    

                    'd_address'=>$data['d_address'],

                    'status'=>1,

                    'added_date'=> savedate(),

                    'crm_user_id' =>logged_user_data(),

                    'doc_navigate_id'=>$data['doc_navigon'],

                    

                );

             }

           

            $this->db->where('dealer_id',$dm_id);

            $this->db->update('dealer',$dealer_data);

            //   echo $this->db->last_query(); die;      

                    if ($this->db->trans_status() === TRUE)

                           {

                              return true;



                           }

                           else{



                               return false;



                           }   



        }

        else{

            

            $group_dealer_id=implode(',',$data['group_dealer_id']);

            

            $group_dealer_data = 

                array(

                    'dealer_name'=>$data['group_dealer_name'],
                    'city_pincode'=>$data['city_pin'],
                    'd_email'=>$data['group_dealer_email'],

                    'd_phone'=>$data['group_dealer_num'],

                    'state_id'=>$data['group_dealer_state'],

                    'city_id'=>$data['group_dealer_city'],

                    'd_about'=>$data['group_about_d'],

                    'dealer_are'=>$group_dealer_id,

                    'gd_id' =>'gorg_100',

                    'd_address'=>$data['d_address'],

                    'status'=>1,

                    'added_date'=> savedate(),

                    'crm_user_id' =>logged_user_data(),

                     'doc_navigate_id'=>$data['doc_navigon'],

                    

                );

        

           $this->db->insert('dealer',$group_dealer_data); 

            

            return ($this->db->affected_rows() != 1) ? false : true; 

        }

        

       

        

        

        

    }

    

    

    public function dealers_info_of_group($s_id='',$dealers_are){

        

       

         if($s_id!=''){

//             $sm_id= urisafedecode($id);

             $arr = "d.dealer_id as d_id,d.dealer_name,d.dealer_id as id,d.d_email as email,d.d_phone as d_ph,d.dealer_name as d_name,c.city_name,d.state_id,d.city_id,d.gd_id,d.d_address,d.d_alt_phone as alt_phone,d.d_about";

        $this->db->select($arr);

        $this->db->from("dealer d");  

         $this->db->join("city c" , "d.city_id=c.city_id");

           $this->db->join("state st" , "st.state_id=d.state_id");

        $this->db->where_in('d.dealer_id',$dealers_are);

        

        

        

        

        $query = $this->db->get();

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows()){

            

            return json_encode($query->result_array());

        }

        else{

            

            return FALSE;

        }

        }

        

        

    }

    

    // function for meeting type name and there sub meeting name

    public function meeting_type_name($mm_id=''){

        

         $ar_mmid = explode(',', $mm_id);

         

//         pr($ar_mmid); die;

        

        

        $arr = "sub_m.id as subm_id,sub_m.sub_meeting_name as subm_name,mm.meeting_name as m_name,sub_m.main_meeting_id as m_id";

        $this->db->select($arr);

        $this->db->from('srm_sub_meeting_name sub_m');

        $this->db->join('srm_main_meeting_type mm','mm.id=sub_m.main_meeting_id');

        foreach ($ar_mmid as $k_mm=>$val_mm){

            

        $this->db->or_where('sub_m.main_meeting_id',$val_mm);

       

        }

         $query = $this->db->get();

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows()){

            

            return $query->result_array();

        }

        else{

            

            return FALSE;

        }

        

    }

    

    // meeting value msg

    public function meeting_value_msg($mm_id=''){

        

         $ar_mmid = explode(',', $mm_id);

         

//         pr($ar_mmid); die;

        

        

        $arr = " mm.additonal_remark_msg as additional_value";

        $this->db->select($arr);

        $this->db->from('srm_main_meeting_type mm');

//        $this->db->join('srm_main_meeting_type mm','mm.id=sub_m.main_meeting_id');

        foreach ($ar_mmid as $k_mm=>$val_mm){

            

        $this->db->or_where('mm.id',$val_mm);

       

        }

         $query = $this->db->get();

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows()){

            

            return $query->result_array();

        }

        else{

            

            return FALSE;

        }

    }





    public function main_meeting_name(){

        

        $arr = "id,meeting_name as main_m_name";

        $this->db->select($arr);

        $this->db->from('main_meeting_type');

       

        

         $query = $this->db->get();

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows()){

            

            return json_encode($query->result_array());

        }

        else{

            

            return FALSE;

        }

        

    }

    

     public function logdata($data){

         

        $this->db->where('crm_user_id',logged_user_data());

        $this->db->where('person_id',$data['dealer_view_id']);

        $this->db->delete('log_interaction_data');



        $col='order_id';

        $this->db->select($col); 

        $this->db->from('interaction_order'); 

        $this->db->where('interaction_id',0); 

        $this->db->where('crm_user_id',logged_user_data()); 

        $this->db->where('interaction_person_id',$data['dealer_view_id']); 

        $query= $this->db->get(); 

        if($this->db->affected_rows()){

            $id= $query->row()->order_id; 

            $this->db->where('order_id', $id);

            $this->db->delete('order_details');

            $this->db->where('interaction_id',0); 

            $this->db->where('crm_user_id',logged_user_data()); 

            $this->db->where('interaction_person_id',$data['dealer_view_id']); 

            $this->db->delete('interaction_order');

        }   

        



        $telephonic=0;

        $team_member='';

        $m_sample='';

        if(isset($data['telephonic']))

        {

            $telephonic=$data['telephonic'];

        }

        if(isset($data['team_member']))

        {

            $team_member=implode($data['team_member'],',');

        }

        if(isset($data['m_sample']))

        {

            $m_sample=implode($data['m_sample'],',');

        }



        $log_data = array(

            'person_id'=>$data['dealer_view_id'],

            'followup_date'=>$data['fup_a'],

            'interaction_date'=>$data['doi_doc'],

            'stay'=>$data['stay'],

            'telephonic'=>$telephonic,

            'joint_working '=>$team_member,

            'path_info '=>$data['path_info'],

            'city_code '=>$data['city'],

            'sample '=>$m_sample,

            'remark'=>$data['remark'],

            'crm_user_id'=> logged_user_data(),

        );

        $this->db->insert('log_interaction_data',$log_data); 

        return ($this->db->affected_rows() == 1) ? true : false; 

     }

     

     public function get_log_path($data){

         $col='path_info, interaction_date,city_code';

         $this->db->select($col); 

         $this->db->from('log_interaction_data');

         $this->db->where('crm_user_id',logged_user_data());

         $this->db->where('person_id',$data['dealer_view_id']);

         $query= $this->db->get(); 

        if($this->db->affected_rows()){

            return $query->row(); 

        }

        else

        {

            return 0;

        }

     }

    

    // save ineraction data

    public function save_interaction($data){

        /*pr($data);

        die;*/

        $duplicate_product=0;

        

        if(isset($data['meet_or_not'])){

            $meet_or_not = $data['meet_or_not'];

        }

        else{

            $meet_or_not=NULL;      

        }

        if(isset($data['doc_id'])){   // for Doctor interaction

           

            if(!empty($data['m_sample'])){  // for multipile sample data



               if(!empty($data['m_sale'])){

                $interaction_info = array(

                            'doc_id'=>$data['doc_id'],

                            'dealer_id'=>isset($data['dealer_id'])?$data['dealer_id']:NULL,

                            'meeting_sale'=>$data['m_sale'],

                           'meet_or_not_meet'=>$meet_or_not,

                          

                           'remark'=>$data['remark'],

                           

                            'follow_up_action'=>$data['fup_a']!='' ? date('Y-m-d', strtotime($data['fup_a'])): NULL,

                            'status'=>1,

                            'crm_user_id'=> logged_user_data(),

                            'create_date'=> $data['doi_doc']!='' ? date('Y-m-d', strtotime($data['doi_doc'])):savedate(),

                            'last_update' => savedate(),    

                      );

               }

               else{

                   $interaction_info = array(

                            'doc_id'=>$data['doc_id'],

                                                  

                            'meet_or_not_meet'=>$meet_or_not,

                          

                            'remark'=>$data['remark'],

                           

                            'follow_up_action'=>$data['fup_a']!='' ? date('Y-m-d', strtotime($data['fup_a'])): NULL,

                            'status'=>1,

                            'crm_user_id'=> logged_user_data(),

                            'create_date'=> $data['doi_doc']!='' ? date('Y-m-d', strtotime($data['doi_doc'])):savedate(),

                            'last_update' => savedate(),    

                      ); 

               }

             

                 $insert = $this->db->insert('pharma_interaction_doctor',$interaction_info);

                
                 

//                 echo $this->db->last_query(); die;

                 

//                echo $insert; die;

                    $pi_doc = $this->db->insert_id();
                    $replica_data = array(
                       'interaction_with'=>$data['dealer_view_id'],
                       'crm_user_id'=> logged_user_data(),
                    ); 
                    $insert = $this->db->insert('intearction_replica',$replica_data);
                   if(isset($pi_doc)){

            

                        $order_data = array(

                            'interaction_id'=> $pi_doc,

                            'interaction_with_id'=>isset($data['dealer_id'])?$data['dealer_id']:NULL,

                            'updated_date'=>savedate(),                  

                        );

                        $this->db->set($order_data);

                        $this->db->where('interaction_id',0); 

                        $this->db->where('interaction_person_id',$data['doc_id']); 

                        $this->db->where('crm_user_id',logged_user_data()); 

                        $this->db->update('interaction_order'); 

                        $this->db->where('crm_user_id',logged_user_data());

                        $this->db->where('person_id',$data['doc_id']);

                        $this->db->delete('log_interaction_data');

                    }

                  if(isset($pi_doc)){

                     foreach($data['m_sample'] as $kms=>$val_ms){

                         $sample_doc_interraction_rel = array(

                             'pidoc_id'=>$pi_doc,

                             'sample_id'=>$val_ms,

                             'crm_user_id'=> logged_user_data(),

                             'last_update'=> savedate(),

                         );

                         

                      $status = $this->db->insert('doctor_interaction_sample_relation',$sample_doc_interraction_rel);

                       

                       

                     } 

                  }

                  

                  if(isset($pi_doc) && isset($data['team_member'])){

                     foreach($data['team_member'] as $k_tm=>$val_tm){

                         $team_doc_interraction_rel = array(

                             'pidoc_id'=>$pi_doc,

                             'team_id'=>$val_tm,

                             'crm_user_id'=> logged_user_data(),

                             'last_update'=> savedate(),

                             'doc_id'=>$data['doc_id'],

                             'interaction_date'=>  date('Y-m-d', strtotime($data['doi_doc'])),

                         );

                         

                       $team_status = $this->db->insert('doctor_interaction_with_team',$team_doc_interraction_rel);

                       

                       

                     } 

                  }

                  

                  

             if(!empty($data['m_sample']) && isset($data['team_member'])){ 

          if ($insert == TRUE && $status == 1 && $team_status==1)

                           {

//                        echo $insert."<br>"; echo "smaple".$status."<br>"; die;

                  return true;                           



                           }

                           else{



                               return false;



                           } 

             }

             elseif(!empty($data['m_sample']) && !isset($data['team_member'])){

                 

                  if ($insert== TRUE && $status == 1)

                           {

//                        echo $insert."<br>"; echo "smaple".$status."<br>"; die; 

                  return true;                           



                           }

                           else{



                               return false;



                           } 

                 

             }

                 

                 

            }

            else{  

                

                

         if(!empty($data['m_sale'])){       

        $interaction_info = array(

                            'doc_id'=>$data['doc_id'],

                            'dealer_id'=>isset($data['dealer_id'])?$data['dealer_id']:NULL,

                            'meeting_sale'=>$data['m_sale'],

                            'telephonic' => isset($data['telephonic'])? $data['telephonic']:NULL,

                          

                           'meet_or_not_meet'=>$meet_or_not,

                           

                           'remark'=>$data['remark'],

                           

                            'follow_up_action'=>$data['fup_a']!='' ? date('Y-m-d', strtotime($data['fup_a'])):NULL,

                            'status'=>1,

                            'crm_user_id'=> logged_user_data(),

                            'create_date'=> $data['doi_doc']!='' ? date('Y-m-d', strtotime($data['doi_doc'])):savedate(),

                            'last_update' => savedate(),

            );

         }

         else{

             $interaction_info = array(

                            'doc_id'=>$data['doc_id'],

                           'telephonic' => isset($data['telephonic'])? $data['telephonic']:NULL,

                           'meet_or_not_meet'=>$meet_or_not,

                           

                           'remark'=>$data['remark'],

                           

                            'follow_up_action'=>$data['fup_a']!='' ? date('Y-m-d', strtotime($data['fup_a'])):NULL,

                            'status'=>1,

                            'crm_user_id'=> logged_user_data(),

                            'create_date'=> $data['doi_doc']!='' ? date('Y-m-d', strtotime($data['doi_doc'])):savedate(),

                            'last_update' => savedate(),

                 );

         }

        

        $insert =  $this->db->insert('pharma_interaction_doctor',$interaction_info);

//           echo $this->db->last_query(); die;

           $pi_doc = $this->db->insert_id();   
           $replica_data = array(
                       'interaction_with'=>$data['dealer_view_id'],
                       'crm_user_id'=> logged_user_data(),
                    ); 
                    $insert = $this->db->insert('intearction_replica',$replica_data);
           

           if(isset($pi_doc)){

            

                    $order_data = array(

                        'interaction_id'=> $pi_doc,

                        'interaction_with_id'=>isset($data['dealer_id'])?$data['dealer_id']:NULL,

                        'updated_date'=>savedate(),                  

                    );

                    $this->db->set($order_data);

                    $this->db->where('interaction_id',0); 

                    $this->db->where('interaction_person_id',$data['dealer_view_id']); 

                    $this->db->where('crm_user_id',logged_user_data()); 

                    $this->db->update('interaction_order'); 

                    $this->db->where('crm_user_id',logged_user_data());

            $this->db->where('person_id',$data['dealer_view_id']);

            $this->db->delete('log_interaction_data');

                }

           if(isset($pi_doc) && isset($data['team_member'])){

                     foreach($data['team_member'] as $k_tm=>$val_tm){

                         $team_doc_interraction_rel = array(

                             'pidoc_id'=>$pi_doc,

                             'team_id'=>$val_tm,

                             'crm_user_id'=> logged_user_data(),

                             'last_update'=> savedate(),

                             'doc_id'=>$data['doc_id'],

                             'interaction_date'=>  date('Y-m-d', strtotime($data['doi_doc'])),

                         );

                         

                       $team_status = $this->db->insert('doctor_interaction_with_team',$team_doc_interraction_rel);

                       

                       

                     } 

                  }

         

            if(isset($data['team_member'])){      

          if ($insert == TRUE && $team_status==1)

                           {

                        

                  return true;                           



                           }

                           else{



                               return false;



                           } 

                   }

                   else{

                     

                       if ($insert == TRUE)

                           {

                        

                  return true;                           



                           }

                           else{



                               return false;



                           } 

                       

                   }

                   

                   

                   

            }

       

        }

        else if(isset($data['d_id'])){   // for dealer interaction

            

             if(!empty($data['m_sample'])){  // for multipile sample data

            $interaction_info = array(

                'd_id'=>$data['d_id'],

                'meeting_sale'=>isset($data['m_sale'])? $data['m_sale']:NULL,
                'meeting_payment'=>$data['m_payment'],

                'meeting_stock'=>$data['m_stock'],

                'meet_or_not_meet'=>$meet_or_not,

                'remark'=>$data['remark'],

                'follow_up_action'=>$data['fup_a']!='' ? date('Y-m-d', strtotime($data['fup_a'])):NULL,

                'status'=>1,

                'crm_user_id'=> logged_user_data(),

                'create_date'=> $data['doi_doc']!='' ? date('Y-m-d', strtotime($data['doi_doc'])):savedate(),

                'last_update' => savedate(),

            );

           

       $insert = $this->db->insert('pharma_interaction_dealer',$interaction_info);



        $pi_dealer = $this->db->insert_id();    

        $replica_data = array(
                       'interaction_with'=>$data['dealer_view_id'],
                       'crm_user_id'=> logged_user_data(),
                    ); 
                    $insert = $this->db->insert('intearction_replica',$replica_data);

        if(isset($pi_dealer)){

                $order_data = array(
                    'interaction_id'=> $pi_dealer,
                    //'interaction_with_id'=> $data['dealer_id'],
                    'updated_date'=>savedate(),                  
                );
                $this->db->set($order_data);
                $this->db->where('interaction_id',0); 
                $this->db->where('interaction_person_id',$data['dealer_view_id']); 
                $this->db->where('crm_user_id',logged_user_data()); 
                $this->db->update('interaction_order'); 
                $this->db->where('crm_user_id',logged_user_data());
                $this->db->where('person_id',$data['dealer_view_id']);
                $this->db->delete('log_interaction_data');

            }

                  if(isset($pi_dealer)){

                     foreach($data['m_sample'] as $kms=>$val_ms){

                         $sample_dealer_interaction_rel = array(

                             'pidealer_id'=>$pi_dealer,

                             'sample_id'=>$val_ms,

                             'crm_user_id'=> logged_user_data(),

                             'last_update'=> savedate(),

                            

                         );

                         

                      $status= $this->db->insert('dealer_interaction_sample_relation',$sample_dealer_interaction_rel);

                       

                       

                     } 

                  }

        

                  

                  

           if(isset($pi_dealer) && isset($data['team_member'])){

                     foreach($data['team_member'] as $k_tm=>$val_tm){

                         $team_dealer_interraction_rel = array(

                             'pidealer_id'=>$pi_dealer,

                             'team_id'=>$val_tm,

                             'crm_user_id'=> logged_user_data(),

                             'last_update'=> savedate(),

                             'dealer_id'=>$data['d_id'],

                             'interaction_date'=>  date('Y-m-d', strtotime($data['doi_doc'])),

                         );

                         

                       $team_status = $this->db->insert('dealer_interaction_with_team',$team_dealer_interraction_rel);

                       

                       

                     } 

                  }

                  

                  

             if(!empty($data['m_sample']) && isset($data['team_member'])){ 

                    if ($insert == TRUE && $status == 1 && $team_status==1)

                   {

                       return true;                           

                   }

                   else{



                       return false;



                   } 

                }

             elseif(!empty($data['m_sample']) && !isset($data['team_member'])){

                 

                  if ( $insert == TRUE && $status == 1)

                           {

                        

                  return true;                           



                           }

                           else{



                               return false;



                           } 

                 

             }

                           

             }

             else{  // for non sample data

                 

                 $interaction_info = array(

                            'd_id'=>$data['d_id'],

                      'telephonic' => isset($data['telephonic'])? $data['telephonic']:NULL,

                           'meeting_sale'=>isset($data['m_sale'])? $data['m_sale']:NULL,
                           'meeting_payment'=>$data['m_payment'],

                           'meeting_stock'=>$data['m_stock'],

                           'meet_or_not_meet'=>$meet_or_not,

                           

                           'remark'=>$data['remark'],

                           

                            'follow_up_action'=>$data['fup_a']!='' ? date('Y-m-d', strtotime($data['fup_a'])):NULL,

                            'status'=>1,

                            'crm_user_id'=> logged_user_data(),

                            'create_date'=> $data['doi_doc']!='' ? date('Y-m-d', strtotime($data['doi_doc'])):savedate(),

                            'last_update' => savedate(),

                     );

           

        $insert = $this->db->insert('pharma_interaction_dealer',$interaction_info);

        

          $pi_doc = $this->db->insert_id();  
                    $replica_data = array(
                       'interaction_with'=>$data['dealer_view_id'],
                       'crm_user_id'=> logged_user_data(),
                    ); 
                    $insert = $this->db->insert('intearction_replica',$replica_data);
          if(isset($pi_doc)){

                $order_data = array(

                    'interaction_id'=> $pi_doc,

                    'updated_date'=>savedate(),                  

                );

                $this->db->set($order_data);

                $this->db->where('interaction_id',0); 

                $this->db->where('interaction_person_id',$data['dealer_view_id']); 

                $this->db->where('crm_user_id',logged_user_data()); 

                $this->db->update('interaction_order'); 

                $this->db->where('crm_user_id',logged_user_data());

                $this->db->where('person_id',$data['dealer_view_id']);

                $this->db->delete('log_interaction_data');

            }

          

           if(isset($pi_doc) && isset($data['team_member'])){

                     foreach($data['team_member'] as $k_tm=>$val_tm){

                         $team_dealer_interraction_rel = array(

                             'pidealer_id'=>$pi_doc,

                             'team_id'=>$val_tm,

                             'crm_user_id'=> logged_user_data(),

                             'last_update'=> savedate(),

                             'dealer_id'=>$data['d_id'],

                             'interaction_date'=>  date('Y-m-d', strtotime($data['doi_doc'])),

                         );

                         

                       $team_status = $this->db->insert('dealer_interaction_with_team',$team_dealer_interraction_rel);

                       

                       

                     } 

                  }

         

            if(isset($data['team_member'])){      

          if ($insert == TRUE && $team_status==1)

                           {

                        

                  return true;                           



                           }

                           else{



                               return false;



                           } 

                   }

                   else{

                     

                       if ($insert == TRUE)

                           {

                        

                  return true;                           



                           }

                           else{



                               return false;



                           } 

                       

                   }

                 

                 

             }

                           

                           

        }

        

        elseif(isset($data['pharma_id'])){   // for pharmacy interaction

            $dup_count=0;

            $dup_product='';

            if(isset($data['rel_doc_id']))

            {

                $duplicate_product=$this->check_duplicate_value($data);

                $dup_count=$duplicate_product['dp_count'];

                $dup_product=$duplicate_product['dp_value'];

            }

          

            if(!empty($data['m_sample'])){  // for multipile sample data

                  

                if(!empty($data['m_sale'])){ 

                $interaction_info = array(

                            'pharma_id'=>$data['pharma_id'],

                            'dealer_id'=>isset($data['dealer_id'])?$data['dealer_id']:NULL,

                            'doctor_id'=>isset($data['rel_doc_id'])?$data['rel_doc_id']:NULL,

                            'duplicate_secondary'=>$dup_count,

                            'duplicate_product'=>$dup_product,

                            'meeting_sale'=>$data['m_sale'],

                        

                           'meet_or_not_meet'=>$meet_or_not,

                          

                           'remark'=>$data['remark'],

                           

                            'follow_up_action'=>$data['fup_a']!='' ? date('Y-m-d', strtotime($data['fup_a'])):NULL,

                            'status'=>1,

                            'crm_user_id'=> logged_user_data(),

                            'create_date'=> $data['doi_doc']!='' ? date('Y-m-d', strtotime($data['doi_doc'])):savedate(),

                            'last_update' => savedate(),

                     );

                }

                else{

                   $interaction_info = array(

                            'pharma_id'=>$data['pharma_id'],

                              'doctor_id'=>isset($data['rel_doc_id'])?$data['rel_doc_id']:NULL,

                            'duplicate_secondary'=>$dup_count,

                            'duplicate_product'=>$dup_product,                    

                           'meet_or_not_meet'=>$meet_or_not,

                          

                           'remark'=>$data['remark'],

                           

                            'follow_up_action'=>$data['fup_a']!='' ? date('Y-m-d', strtotime($data['fup_a'])):NULL,

                            'status'=>1,

                            'crm_user_id'=> logged_user_data(),

                            'create_date'=> $data['doi_doc']!='' ? date('Y-m-d', strtotime($data['doi_doc'])):savedate(),

                            'last_update' => savedate(),

                     ); 

                }

             

                 $insert = $this->db->insert('pharma_interaction_pharmacy',$interaction_info);

                $replica_data = array(
                       'interaction_with'=>$data['dealer_view_id'],
                       'crm_user_id'=> logged_user_data(),
                    ); 
                    $insert = $this->db->insert('intearction_replica',$replica_data);

                  $pi_doc = $this->db->insert_id();

                    if(isset($pi_doc)){

            

                        $order_data = array(

                            'interaction_id'=> $pi_doc,

                            'interaction_with_id'=>isset($data['dealer_id'])?$data['dealer_id']:NULL,

                            'updated_date'=>savedate(),                  

                        );

                        $this->db->set($order_data);

                        $this->db->where('interaction_id',0); 

                        $this->db->where('interaction_person_id',$data['dealer_view_id']); 

                        $this->db->where('crm_user_id',logged_user_data()); 

                        $this->db->update('interaction_order'); 

                        $this->db->where('crm_user_id',logged_user_data());

                        $this->db->where('person_id',$data['dealer_view_id']);

                        $this->db->delete('log_interaction_data');




                        if(isset($data['rel_doc_id']))
                        {

                            $order_data = array(

                                'duplicate_status'=> 1,

                                'updated_date'=>savedate(),                  

                            );

                            $this->db->set($order_data);

                            $this->db->where('crm_user_id',logged_user_data());

                            $this->db->where('duplicate_status',0);

                            $this->db->where('interaction_with_id',$data['dealer_view_id']); 

                            $this->db->where('interaction_person_id',$data['rel_doc_id']); 

                            $this->db->update('interaction_order'); 
                        }

                    }

                  if(isset($pi_doc)){

                     foreach($data['m_sample'] as $kms=>$val_ms){

                         $sample_doc_interraction_rel = array(

                             'pipharma_id'=>$pi_doc,

                             'sample_id'=>$val_ms,

                             'crm_user_id'=> logged_user_data(),

                             'last_update'=> savedate(),

                         );

                         

                      $status= $this->db->insert('pharmacy_interaction_sample_relation',$sample_doc_interraction_rel);

                       

                       

                     } 

                  }

                  

                   if(isset($pi_doc) && isset($data['team_member'])){

                     foreach($data['team_member'] as $k_tm=>$val_tm){

                         $team_interraction_rel = array(

                             'pipharma_id'=>$pi_doc,

                             'team_id'=>$val_tm,

                             'crm_user_id'=> logged_user_data(),

                             'last_update'=> savedate(),

                             'pharma_id'=>$data['pharma_id'],

                             'interaction_date'=>  date('Y-m-d', strtotime($data['doi_doc'])),

                         );

                         

                       $team_status = $this->db->insert('pharmacy_interaction_with_team',$team_interraction_rel);

                       

                       

                     } 

                  }

                  

               

             if(!empty($data['m_sample']) && isset($data['team_member'])){ 

          if ($insert == TRUE && $status == 1 && $team_status==1)

                           {

                        

                  return true;                           



                           }

                           else{



                               return false;



                           } 

             }

             elseif(!empty($data['m_sample']) && !isset($data['team_member'])){

                 

                  if ($insert == TRUE && $status == 1)

                           {

                        

                  return true;                           



                           }

                           else{



                               return false;



                           } 

                 

             }

                 

                 

                 

            }

            else{

                if(!empty($data['m_sale'])){

        $interaction_info = array(

                            'pharma_id'=>$data['pharma_id'],

                            'dealer_id'=>isset($data['dealer_id'])?$data['dealer_id']:NULL,

                            'meeting_sale'=>$data['m_sale'],

                           'telephonic' => isset($data['telephonic'])? $data['telephonic']:NULL,

                          'doctor_id'=>isset($data['rel_doc_id'])?$data['rel_doc_id']:NULL,

                            'duplicate_secondary'=>$dup_count,

                            'duplicate_product'=>$dup_product,

                           'meet_or_not_meet'=>$meet_or_not,

                           

                           'remark'=>$data['remark'],

                           

                            'follow_up_action'=>$data['fup_a']!='' ? date('Y-m-d', strtotime($data['fup_a'])):NULL,

                            'status'=>1,

                            'crm_user_id'=> logged_user_data(),

                            'create_date'=> $data['doi_doc']!='' ? date('Y-m-d', strtotime($data['doi_doc'])):savedate(),

                            'last_update' => savedate(),

            

                );

                }

                else{

                    $interaction_info = array(

                            'pharma_id'=>$data['pharma_id'],

                             'telephonic' => isset($data['telephonic'])? $data['telephonic']:NULL,                        

                           'meet_or_not_meet'=>$meet_or_not,

                           'doctor_id'=>isset($data['rel_doc_id'])?$data['rel_doc_id']:NULL,

                           'duplicate_secondary'=>$dup_count,

                            'duplicate_product'=>$dup_product,

                           'remark'=>$data['remark'],

                           

                            'follow_up_action'=>$data['fup_a']!='' ? date('Y-m-d', strtotime($data['fup_a'])):NULL,

                            'status'=>1,

                            'crm_user_id'=> logged_user_data(),

                            'create_date'=> $data['doi_doc']!='' ? date('Y-m-d', strtotime($data['doi_doc'])):savedate(),

                            'last_update' => savedate(),

            

                ); 

                    

            }

        

        $insert = $this->db->insert('pharma_interaction_pharmacy',$interaction_info);

           

         $pi_doc = $this->db->insert_id();  

         $replica_data = array(
                       'interaction_with'=>$data['dealer_view_id'],
                       'crm_user_id'=> logged_user_data(),
                    ); 
                    $insert = $this->db->insert('intearction_replica',$replica_data);

         if(isset($pi_doc)){

            

                $order_data = array(

                    'interaction_id'=> $pi_doc,

                    'interaction_with_id'=>isset($data['dealer_id'])?$data['dealer_id']:NULL,

                    'updated_date'=>savedate(),                  

                );

                $this->db->set($order_data);

                $this->db->where('interaction_id',0); 

                $this->db->where('interaction_person_id',$data['pharma_id']); 

                $this->db->where('crm_user_id',logged_user_data()); 

                $this->db->update('interaction_order'); 

                

                $this->db->where('crm_user_id',logged_user_data());

                $this->db->where('person_id',$data['pharma_id']);

                $this->db->delete('log_interaction_data');


                if(isset($data['rel_doc_id']))
                {
                    $order_data = array(

                    'duplicate_status'=> 1,

                    'updated_date'=>savedate(),                  

                    );

                    $this->db->set($order_data);

                    $this->db->where('crm_user_id',logged_user_data());

                    $this->db->where('duplicate_status',0);

                    $this->db->where('interaction_with_id',$data['dealer_view_id']); 

                    $this->db->where('interaction_person_id',$data['rel_doc_id']); 

                    $this->db->update('interaction_order'); 
                }
        

            }

            if(isset($pi_doc) && isset($data['team_member'])){

                     foreach($data['team_member'] as $k_tm=>$val_tm){

                         $team_interraction_rel = array(

                             'pipharma_id'=>$pi_doc,

                             'team_id'=>$val_tm,

                             'crm_user_id'=> logged_user_data(),

                             'last_update'=> savedate(),

                             'pharma_id'=>$data['pharma_id'],

                             'interaction_date'=>  date('Y-m-d', strtotime($data['doi_doc'])),

                         );

                         

                       $team_status = $this->db->insert('pharmacy_interaction_with_team',$team_interraction_rel);

                       

                       

                     } 

                  }

         

          if(isset($data['team_member'])){      

          if ($insert == TRUE && $team_status==1)

                           {

                        

                  return true;                           



                           }

                           else{



                               return false;



                           } 

                   }

                   else{

                     

                       if ($insert == TRUE)

                           {

                        

                  return true;                           



                           }

                           else{



                               return false;



                           } 

                       

                   }

                   

            }

       

        }

    

            

        

    }

    

    

    // show interaction of dealer data and there group dealer

    public function interaction_data_dealer($id=''){

        if($id!=''){

            

             $arr = "d.dealer_name,d.gd_id,d.dealer_are";

        $this->db->select($arr);

        $this->db->from('dealer d');

        $this->db->where('d.dealer_id',$id);

      

         $query = $this->db->get();

//            echo $this->db->last_query(); die;

         $res_dealer=$query->row();

//         pr($res_dealer); die;

        if(!empty($res_dealer->gd_id)){   // for C & F (main dealer) interaction

            

            $dealers_are = explode(',', $res_dealer->dealer_are);

//            pr($dealers_are); die;

            $arr = "si.create_date as date_of_interaction,d.dealer_name,mmt.meeting_name as mmt_name,si.remark,si.follow_up_action,u.name as username";

                $this->db->select($arr);

                $this->db->from('pharma_interaction_pharmacy si');

                $this->db->join('dealer d','d.dealer_id=si.dealer_id');

                $this->db->join('pharma_users u','u.id=si.crm_user_id');

                $this->db->join('main_meeting_type mmt','mmt.id=si.mm_type_id');

               

                $this->db->where_in('si.dealer_id',$dealers_are);

                 $this->db->or_where('si.d_id',$id);

                 $this->db->order_by('si.create_date','DESC');

                $query = $this->db->get();

         

              $res_dealer_interaction=$query->result_array();

           

            

        }

        else{  // for sub dealer (dealer)

              $arr = "si.create_date as date_of_interaction,d.dealer_name,si.meeting_sale,si.meeting_payment,si.meeting_stock,si.meet_or_not_meet,si.remark,si.follow_up_action,u.name as username";

                $this->db->select($arr);

                $this->db->from('pharma_interaction_dealer si');

                $this->db->join('dealer d','d.dealer_id=si.d_id');

                $this->db->join('pharma_users u','u.id=si.crm_user_id');

//                $this->db->join('main_meeting_type mmt','mmt.id=si.mm_type_id');

             

                $this->db->where('si.d_id',$id);

                 $this->db->order_by('si.create_date','DESC');

                $query = $this->db->get();

         

              $res_dealer_interaction=$query->result_array();

            

        }

//        echo $this->db->last_query(); die;

//         pr($res_dealer_interaction); die;

//         echo $this->db->last_query(); die;

                if(!empty($res_dealer_interaction)){



                   return json_encode($res_dealer_interaction);

               }

               else{



                   return FALSE;

               }

            

        }

        

        

    }

    

    

    // for interaction between doctor

    

    public function interaction_data_doctor($id=''){

//        echo $id; die;

        if($id!=''){

           $arr = "pid.id,dl.doc_name as interactionwith,pu.name as interactionBy,pid.meeting_sale,pid.meet_or_not_meet,pid.remark,pid.follow_up_action, pid.create_date as date_of_interaction ";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_doctor pid");

        $this->db->join("doctor_list dl","dl.doctor_id=pid.doc_id");

//        $this->db->join("doctor_interaction_sample_relation doc_sample","doc_sample.pidoc_id=pid.id","left");

//        $this->db->join("meeting_sample_master msm","msm.id=doc_sample.sample_id","left");

//        

        $this->db->join("pharma_users pu","pu.id=pid.crm_user_id","left");

        

        

        $this->db->where("pid.dealer_id",$id);

        

        $query = $this->db->get();

//     echo $this->db->last_query(); die;

      

        if($this->db->affected_rows()){

            

            $doc_info=$query->result_array();

//                 pr($doc_info);

//                 $doc_samples_info = array();

             foreach($doc_info as $k=>$val){    

             $arr = " GROUP_CONCAT(`msm`.`sample_name` SEPARATOR ',') AS samples ";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_doctor pid");

        $this->db->join("doctor_interaction_sample_relation doc_sample","doc_sample.pidoc_id=pid.id");

        $this->db->join("meeting_sample_master msm","msm.id=doc_sample.sample_id");

        

        

        $this->db->where("pid.id",$val['id']);

          $query = $this->db->get();

          $doc_info[$k]['samples'] = $query->row();

             }

            

            

            return json_encode($doc_info);

        }

        else{

            

            return FALSE;

        }

            

        }

        

    }

    

    

      // for interaction between pharmacy

    

    public function interaction_data_pharmacy($id=''){

//        echo $id; die;

        if($id!=''){

          $arr = "pip.id,pl.company_name as interactionwith,pu.name as interactionBy,pip.meeting_sale , pip.meet_or_not_meet, pip.remark, pip.follow_up_action, pip.create_date as date_of_interaction ";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_pharmacy pip");

         $this->db->join("pharmacy_list pl","pl.pharma_id=pip.pharma_id");

//        $this->db->join("pharmacy_interaction_sample_relation pi_sample","pi_sample.pipharma_id=pip.id","left");

//        $this->db->join("meeting_sample_master msm","msm.id=pi_sample.sample_id","left");

        

        $this->db->join("pharma_users pu","pu.id=pip.crm_user_id","left");

        

        

        $this->db->where("pip.dealer_id",$id);

        

        $query = $this->db->get();

//     echo $this->db->last_query(); die;

      

        if($this->db->affected_rows()){

            

            $pharma_info=$query->result_array();

//                 pr($doc_info);

//                 $doc_samples_info = array();

             foreach($pharma_info as $k=>$val){    

             $arr = " GROUP_CONCAT(`msm`.`sample_name` SEPARATOR ',') AS sample_name ";

        $this->db->select($arr);

       $this->db->from("pharma_interaction_pharmacy pip");

       $this->db->join("pharmacy_interaction_sample_relation pi_sample","pi_sample.pipharma_id=pip.id");

        $this->db->join("meeting_sample_master msm","msm.id=pi_sample.sample_id");

        

        $this->db->where("pip.id",$val['id']);

          $query = $this->db->get();

          $pharma_info[$k]['sample_name'] = $query->row();

             }

            

            

            return json_encode($pharma_info);

        }

        else{

            

            return FALSE;

        }

            

        }

        

    } 

    

    

    // find group of this dealer

    public function find_group_for_dealer($id=''){

        

        if($id!=''){

            

            $arr = "d.dealer_id as id,d.d_alt_phone as alt_phone,d.d_address,d.dealer_name as d_name,d.d_email as email,d.d_phone as d_ph,d.d_about,d.dealer_are,d.gd_id,d.state_id,d.city_id,c.city_name";

        $this->db->select($arr);

        $this->db->from('dealer d');

         $this->db->join("city c" , "d.city_id=c.city_id");

        $this->db->where("FIND_IN_SET('$id',d.dealer_are) !=", 0);

       

        

         $query = $this->db->get();

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows()){

            

            return json_encode($query->result_array());

        }

        else{

            

            return FALSE;

        }

            

            

        }

        

        

        

    }

    

    

    // inactive dealer

    public function inactive_dealermaster($id=''){

        

         $dealer_data= array(

             'crm_user_id'=> logged_user_data(),

             'last_update'=>savedate(),

             'status'=>0, 

        );

        

         $this->db->where('dealer_id',$id);

           $this->db->update('dealer',$dealer_data);

           

            if ($this->db->trans_status() === TRUE)

                           {

                              return true;



                           }

                           else{



                               return false;



                           }  

        

    }

    

    

     // active dealer

    public function active_dealermaster($id=''){

        

         $dealer_data= array(

             'crm_user_id'=> logged_user_data(),

             'last_update'=>savedate(),

             'status'=>1, 

        );

        

         $this->db->where('dealer_id',$id);

           $this->db->update('dealer',$dealer_data);

           

            if ($this->db->trans_status() === TRUE)

                           {

                              return true;



                           }

                           else{



                               return false;



                           }  

        

    }

    

    

      // Blocked dealer

    public function blocked_dealermaster($id=''){

        

         $dealer_data= array(

             'crm_user_id'=> logged_user_data(),

             'last_update'=>savedate(),

             'blocked'=>1, 

        );

        

         $this->db->where('dealer_id',$id);

           $this->db->update('dealer',$dealer_data);

           

            if ($this->db->trans_status() === TRUE)

                           {

                              return true;



                           }

                           else{



                               return false;



                           }  

        

    }

   

    

    

       // Remain dealer

    public function remain_dealermaster($id=''){

        

         $dealer_data= array(

             'crm_user_id'=> logged_user_data(),

             'last_update'=>savedate(),

             'blocked'=>0, 

        );

        

         $this->db->where('dealer_id',$id);

           $this->db->update('dealer',$dealer_data);

           

            if ($this->db->trans_status() === TRUE)

                           {

                              return true;



                           }

                           else{



                               return false;



                           }  

        

    }

    

    

    

    // check the interaction day of dealer,pharma,doctor

    public function check_day_interaction($id='',$data=''){

        

                   $interact_id=urisafedecode($id);

        

 

        if(isset($data['d_id'])){   // check for dealer interaction more then one in a same day.

        $arr = "pid.d_id,d.dealer_name as name";

        $this->db->select($arr);

        $this->db->from('pharma_interaction_dealer pid');

        $this->db->join('dealer d','d.dealer_id=pid.d_id');

        $this->db->where('pid.d_id',$interact_id);

        $this->db->where('pid.crm_user_id', logged_user_data());

        $this->db->where('pid.create_date', date('Y-m-d', strtotime($data['doi_doc'])));

               

         $query_dealer = $this->db->get();

       

         

        if($this->db->affected_rows()){

            

            return $query_dealer->row();

        }

        else{

            

            return FALSE;

        }

        

        

        

        }

        

       if(isset($data['doc_id'])){   // check for Doctor interaction more then one in a same day.

        $arr = "pi_doc.doc_id,dl.doc_name as name";

        $this->db->select($arr);

        $this->db->from('pharma_interaction_doctor pi_doc');

        $this->db->join('doctor_list dl','dl.doctor_id=pi_doc.doc_id');

        $this->db->where('pi_doc.doc_id',$interact_id);

        $this->db->where('pi_doc.crm_user_id', logged_user_data());

        $this->db->where('pi_doc.create_date', date('Y-m-d', strtotime($data['doi_doc'])));

               

         $query_doctor = $this->db->get();

       

         

        if($this->db->affected_rows()){

            

            return $query_doctor->row();

        }

        else{

            

            return FALSE;

        }

        

        

        

        } 

        

        

        

        if(isset($data['pharma_id'])){   // check for Pharmacy interaction more then one in a same day.

        $arr = "pip.pharma_id,pl.company_name as name";

        $this->db->select($arr);

        $this->db->from('pharma_interaction_pharmacy pip');

         $this->db->join('pharmacy_list pl','pl.pharma_id=pip.pharma_id');

        $this->db->where('pip.pharma_id',$interact_id);

        $this->db->where('pip.crm_user_id', logged_user_data());

        $this->db->where('pip.create_date', date('Y-m-d', strtotime($data['doi_doc'])));

               

         $query_pharma = $this->db->get();

       

         

        if($this->db->affected_rows()){

            

            return $query_pharma->row();

        }

        else{

            

            return FALSE;

        }

        

        

        } 

        

         

         

        

    }

    

    

    // update doctor interaction by admin

    public function update_doc_interaction($data,$doc_id){

   

        $userId=get_interaction_userid($doc_id, 'pharma_interaction_doctor');

        status_sample_data($doc_id, 'doctor_interaction_with_team');

            

         status_sample_data($doc_id, 'doctor_interaction_sample_relation');

         

         status_doctor_interaction_data($doc_id, 'pharma_interaction_doctor',$data);

         

        if(isset($data['meet_or_not'])){

            $meet_or_not = $data['meet_or_not'];

        }

        else{

            $meet_or_not=NULL;      

        }

  

        

         if(!empty($data['m_sample'])){  // for multipile sample data



               if(!empty($data['m_sale'])){

                    $interaction_info = array(

                        'doc_id'=>$data['doc_id'],

                        'dealer_id'=>isset($data['dealer_id'])?$data['dealer_id']:NULL,

                        'meeting_sale'=>$data['m_sale'],



                        'meet_or_not_meet'=>$meet_or_not,



                        'remark'=>$data['remark'],



                        'follow_up_action'=>$data['fup_a']!='' ? date('Y-m-d', strtotime($data['fup_a'])): NULL,

                        'status'=>1,

                        'crm_user_id'=> $userId,

                        'create_date'=> $data['doi_doc']!='' ? date('Y-m-d', strtotime($data['doi_doc'])):savedate(),

                        'last_update' => savedate(),    

                    );

               }

               else{

                   $interaction_info = array(

                            'doc_id'=>$data['doc_id'],

                                                   

                           'meet_or_not_meet'=>$meet_or_not,

                          

                           'remark'=>$data['remark'],

                           

                            'follow_up_action'=>$data['fup_a']!='' ? date('Y-m-d', strtotime($data['fup_a'])): NULL,

                            'status'=>1,

                            'crm_user_id'=>$userId,

                            'create_date'=> $data['doi_doc']!='' ? date('Y-m-d', strtotime($data['doi_doc'])):savedate(),

                            'last_update' => savedate(),    

                      ); 

               }

             

                 $insert = $this->db->insert('pharma_interaction_doctor',$interaction_info);

                 

//                 echo $this->db->last_query(); die;

                 

//                echo $insert; die;

                  $pi_doc = $this->db->insert_id();

                  

                  if(isset($pi_doc)){

                     foreach($data['m_sample'] as $kms=>$val_ms){

                         $sample_doc_interraction_rel = array(

                             'pidoc_id'=>$pi_doc,

                             'sample_id'=>$val_ms,

                             'crm_user_id'=> $userId,

                             'last_update'=> savedate(),

                         );

                         

                      $status = $this->db->insert('doctor_interaction_sample_relation',$sample_doc_interraction_rel);

                       

                       

                     } 

                  }

                  

                  if(isset($pi_doc) && isset($data['team_member'])){

                     foreach($data['team_member'] as $k_tm=>$val_tm){

                         $team_doc_interraction_rel = array(

                             'pidoc_id'=>$pi_doc,

                             'team_id'=>$val_tm,

                             'crm_user_id'=> $userId,

                             'last_update'=> savedate(),

                              'doc_id'=>$data['doc_id'],

                             'interaction_date'=>  date('Y-m-d', strtotime($data['doi_doc'])),

                         );

                         

                       $team_status = $this->db->insert('doctor_interaction_with_team',$team_doc_interraction_rel);

                       

                       

                     } 

                  }

                  

                  

             if(!empty($data['m_sample']) && isset($data['team_member'])){ 

          if ($insert == TRUE && $status == 1 && $team_status==1)

                           {

//                        echo $insert."<br>"; echo "smaple".$status."<br>"; die;

                  return true;                           



                           }

                           else{



                               return false;



                           } 

             }

             elseif(!empty($data['m_sample']) && !isset($data['team_member'])){

                 

                  if ($insert== TRUE && $status == 1)

                           {

//                        echo $insert."<br>"; echo "smaple".$status."<br>"; die; 

                  return true;                           



                           }

                           else{



                               return false;



                           } 

                 

             }

                 

                 

            }

             else{  

                

                

         if(!empty($data['m_sale'])){       

        $interaction_info = array(

                            'doc_id'=>$data['doc_id'],

                            'dealer_id'=>isset($data['dealer_id'])?$data['dealer_id']:NULL,

                            'meeting_sale'=>$data['m_sale'],

                          

                          

                           'meet_or_not_meet'=>$meet_or_not,

                           

                           'remark'=>$data['remark'],

                           

                            'follow_up_action'=>$data['fup_a']!='' ? date('Y-m-d', strtotime($data['fup_a'])):NULL,

                            'status'=>1,

                            'crm_user_id'=> $userId,

                            'create_date'=> $data['doi_doc']!='' ? date('Y-m-d', strtotime($data['doi_doc'])):savedate(),

                            'last_update' => savedate(),

            );

         }











         else{

             $interaction_info = array(

                            'doc_id'=>$data['doc_id'],

                           

                           'meet_or_not_meet'=>$meet_or_not,

                           

                           'remark'=>$data['remark'],

                           

                            'follow_up_action'=>$data['fup_a']!='' ? date('Y-m-d', strtotime($data['fup_a'])):NULL,

                            'status'=>1,

                            'crm_user_id'=> $userId,

                            'create_date'=> $data['doi_doc']!='' ? date('Y-m-d', strtotime($data['doi_doc'])):savedate(),

                            'last_update' => savedate(),

            );

         }

        

        $insert =  $this->db->insert('pharma_interaction_doctor',$interaction_info);

//           echo $this->db->last_query(); die;

           $pi_doc = $this->db->insert_id();   

           if(isset($pi_doc) && isset($data['team_member'])){

                     foreach($data['team_member'] as $k_tm=>$val_tm){

                         $team_doc_interraction_rel = array(

                             'pidoc_id'=>$pi_doc,

                             'team_id'=>$val_tm,

                             'crm_user_id'=> $userId,

                             'last_update'=> savedate(),

                              'doc_id'=>$data['doc_id'],

                             'interaction_date'=>  date('Y-m-d', strtotime($data['doi_doc'])),

                         );

                         

                       $team_status = $this->db->insert('doctor_interaction_with_team',$team_doc_interraction_rel);

                       

                       

                     } 

                  }

         

            if(isset($data['team_member'])){      

          if ($insert == TRUE && $team_status==1)

                           {

                        

                  return true;                           



                           }

                           else{



                               return false;



                           } 

                   }

                   else{

                     

                       if ($insert == TRUE)

                           {

                        

                  return true;                           



                           }

                           else{



                               return false;



                           } 

                       

                   }

                   

                   

                   

            }

    

    }

    

    // update pharmacy interaction by admin

    public function update_pharma_interaction($data,$ph_id){

   // echo $ph_id;  

     // pr($data); die; 

        $userId=get_interaction_userid($doc_id, 'pharma_interaction_pharmacy'); 

        status_pharma_data($ph_id, 'pharmacy_interaction_with_team');

            

         status_pharma_data($ph_id, 'pharmacy_interaction_sample_relation');

         

         status_doctor_interaction_data($ph_id, 'pharma_interaction_pharmacy',$data);

        

          if(isset($data['meet_or_not'])){

            $meet_or_not = $data['meet_or_not'];

        }

        else{

            $meet_or_not=NULL;      

        }

         

        

        if(!empty($data['m_sample'])){  // for multipile sample data

                  

                if(!empty($data['m_sale'])){ 

                $interaction_info = array(

                            'pharma_id'=>$data['pharma_id'],

                            'dealer_id'=>isset($data['dealer_id'])?$data['dealer_id']:NULL,

                            'meeting_sale'=>$data['m_sale'],

                        

                           'meet_or_not_meet'=>$meet_or_not,

                          

                           'remark'=>$data['remark'],

                           

                            'follow_up_action'=>$data['fup_a']!='' ? date('Y-m-d', strtotime($data['fup_a'])):NULL,

                            'status'=>1,

                            'crm_user_id'=>  $userId,

                            'create_date'=> $data['doi_doc']!='' ? date('Y-m-d', strtotime($data['doi_doc'])):savedate(),

                            'last_update' => savedate(),

                     );

                }

                else{

                   $interaction_info = array(

                            'pharma_id'=>$data['pharma_id'],

                                                   

                           'meet_or_not_meet'=>$meet_or_not,

                          

                           'remark'=>$data['remark'],

                           

                            'follow_up_action'=>$data['fup_a']!='' ? date('Y-m-d', strtotime($data['fup_a'])):NULL,

                            'status'=>1,

                            'crm_user_id'=>  $userId,

                            'create_date'=> $data['doi_doc']!='' ? date('Y-m-d', strtotime($data['doi_doc'])):savedate(),

                            'last_update' => savedate(),

                     ); 

                }

             

                 $insert = $this->db->insert('pharma_interaction_pharmacy',$interaction_info);

                

                  $pi_doc = $this->db->insert_id();

                  

                  if(isset($pi_doc)){

                     foreach($data['m_sample'] as $kms=>$val_ms){

                         $sample_doc_interraction_rel = array(

                             'pipharma_id'=>$pi_doc,

                             'sample_id'=>$val_ms,

                            'crm_user_id'=> $userId,

                             'last_update'=> savedate(),

                         );

                         

                      $status= $this->db->insert('pharmacy_interaction_sample_relation',$sample_doc_interraction_rel);

                       

                       

                     } 

                  }

                  

                   if(isset($pi_doc) && isset($data['team_member'])){

                     foreach($data['team_member'] as $k_tm=>$val_tm){

                         $team_interraction_rel = array(

                             'pipharma_id'=>$pi_doc,

                             'team_id'=>$val_tm,

                             'crm_user_id'=>  $userId,

                             'last_update'=> savedate(),

                                'pharma_id'=>$data['pharma_id'],

                                'interaction_date'=>  date('Y-m-d', strtotime($data['doi_doc'])),

                         );

                         

                       $team_status = $this->db->insert('pharmacy_interaction_with_team',$team_interraction_rel);

                       

                       

                     } 

                  }

                  

               

             if(!empty($data['m_sample']) && isset($data['team_member'])){ 

          if ($insert == TRUE && $status == 1 && $team_status==1)

                           {

                        

                  return true;                           



                           }

                           else{



                               return false;



                           } 

             }

             elseif(!empty($data['m_sample']) && !isset($data['team_member'])){

                 

                  if ($insert == TRUE && $status == 1)

                           {

                        

                  return true;                           



                           }

                           else{



                               return false;



                           } 

                 

             }

                 

                 

                 

            }

            else{

                if(!empty($data['m_sale'])){

        $interaction_info = array(

                            'pharma_id'=>$data['pharma_id'],

                            'dealer_id'=>isset($data['dealer_id'])?$data['dealer_id']:NULL,

                            'meeting_sale'=>$data['m_sale'],

                          

                          

                           'meet_or_not_meet'=>$meet_or_not,

                           

                           'remark'=>$data['remark'],

                           

                            'follow_up_action'=>$data['fup_a']!='' ? date('Y-m-d', strtotime($data['fup_a'])):NULL,

                            'status'=>1,

                            'crm_user_id'=>  $userId,

                            'create_date'=> $data['doi_doc']!='' ? date('Y-m-d', strtotime($data['doi_doc'])):savedate(),

                            'last_update' => savedate(),

            

                );

                }

                else{

                    $interaction_info = array(

                            'pharma_id'=>$data['pharma_id'],

                                                    

                           'meet_or_not_meet'=>$meet_or_not,

                           

                           'remark'=>$data['remark'],

                           

                            'follow_up_action'=>$data['fup_a']!='' ? date('Y-m-d', strtotime($data['fup_a'])):NULL,

                            'status'=>1,

                           'crm_user_id'=>  $userId,

                            'create_date'=> $data['doi_doc']!='' ? date('Y-m-d', strtotime($data['doi_doc'])):savedate(),

                            'last_update' => savedate(),

            

                ); 

                    

            }

        

        $insert = $this->db->insert('pharma_interaction_pharmacy',$interaction_info);

                

         $pi_doc = $this->db->insert_id();  

            if(isset($pi_doc) && isset($data['team_member'])){

                     foreach($data['team_member'] as $k_tm=>$val_tm){

                         $team_interraction_rel = array(

                             'pipharma_id'=>$pi_doc,

                             'team_id'=>$val_tm,

                             'crm_user_id'=>  $userId,

                             'last_update'=> savedate(),

                             'pharma_id'=>$data['pharma_id'],

                                'interaction_date'=>  date('Y-m-d', strtotime($data['doi_doc'])),

                         );

                         

                       $team_status = $this->db->insert('pharmacy_interaction_with_team',$team_interraction_rel);

                       

                       

                     } 

                  }

         

          if(isset($data['team_member'])){      

          if ($insert == TRUE && $team_status==1)

                           {

                        

                  return true;                           



                           }

                           else{



                               return false;



                           } 

                   }

                   else{

                     

                       if ($insert == TRUE)

                           {

                        

                  return true;                           



                           }

                           else{



                               return false;



                           } 

                       

                   }

                   

            } 

    }

    

    

    // update Dealer interaction by admin

    public function update_dealer_interaction($data,$d_id){

        

//        pr($d_id);

//        pr($data); die;

         $userId=get_interaction_userid($doc_id, 'pharma_interaction_dealer'); 

         status_dealer_data($d_id, 'dealer_interaction_with_team');

            

         status_dealer_data($d_id, 'dealer_interaction_sample_relation');

         

         status_doctor_interaction_data($d_id, 'pharma_interaction_dealer',$data);

        

        

         if(isset($data['meet_or_not'])){

            $meet_or_not = $data['meet_or_not'];

        }

        else{

            $meet_or_not=NULL;      

        }

        

         if(!empty($data['m_sample'])){  // for multipile sample data

            $interaction_info = array(

                            'd_id'=>$data['d_id'],

                           'meeting_sale'=>$data['m_sale'],

                           'meeting_payment'=>$data['m_payment'],

                           'meeting_stock'=>$data['m_stock'],

                           'meet_or_not_meet'=>$meet_or_not,

                           

                           'remark'=>$data['remark'],

                           

                            'follow_up_action'=>$data['fup_a']!='' ? date('Y-m-d', strtotime($data['fup_a'])):NULL,

                            'status'=>1,

                            'crm_user_id'=> $userId,

                            'create_date'=> $data['doi_doc']!='' ? date('Y-m-d', strtotime($data['doi_doc'])):savedate(),

                            'last_update' => savedate(),

                );

           

       $insert = $this->db->insert('pharma_interaction_dealer',$interaction_info);

        

        

        $pi_dealer = $this->db->insert_id();

                  

                  if(isset($pi_dealer)){

                     foreach($data['m_sample'] as $kms=>$val_ms){

                         $sample_dealer_interaction_rel = array(

                             'pidealer_id'=>$pi_dealer,

                             'sample_id'=>$val_ms,

                             'crm_user_id'=> $userId,

                             'last_update'=> savedate(),

                            

                         );

                         

                      $status= $this->db->insert('dealer_interaction_sample_relation',$sample_dealer_interaction_rel);

                       

                       

                     } 

                  }

        

                  

                  

           if(isset($pi_dealer) && isset($data['team_member'])){

                     foreach($data['team_member'] as $k_tm=>$val_tm){

                         $team_dealer_interraction_rel = array(

                             'pidealer_id'=>$pi_dealer,

                             'team_id'=>$val_tm,

                              'crm_user_id'=> $userId,

                             'last_update'=> savedate(),

                             'dealer_id'=>$data['d_id'],

                             'interaction_date'=>  date('Y-m-d', strtotime($data['doi_doc'])),

                         );

                         

                       $team_status = $this->db->insert('dealer_interaction_with_team',$team_dealer_interraction_rel);

                       

                       

                     } 

                  }

                  

                  

             if(!empty($data['m_sample']) && isset($data['team_member'])){ 

          if ($insert == TRUE && $status == 1 && $team_status==1)

                           {

                        

                  return true;                           



                           }

                           else{



                               return false;



                           } 

             }

             elseif(!empty($data['m_sample']) && !isset($data['team_member'])){

                 

                  if ( $insert == TRUE && $status == 1)

                           {

                        

                  return true;                           



                           }

                           else{



                               return false;



                           } 

                 

             }

                           

             }

             else{  // for non sample data

                 

                 $interaction_info = array(

                            'd_id'=>$data['d_id'],

                           'meeting_sale'=>$data['m_sale'],

                           'meeting_payment'=>$data['m_payment'],

                           'meeting_stock'=>$data['m_stock'],

                           'meet_or_not_meet'=>$meet_or_not,

                           

                           'remark'=>$data['remark'],

                           

                            'follow_up_action'=>$data['fup_a']!='' ? date('Y-m-d', strtotime($data['fup_a'])):NULL,

                            'status'=>1,

                            'crm_user_id'=> $userId,

                            'create_date'=> $data['doi_doc']!='' ? date('Y-m-d', strtotime($data['doi_doc'])):savedate(),

                            'last_update' => savedate(),

                     );

           

        $insert = $this->db->insert('pharma_interaction_dealer',$interaction_info);

        

          $pi_doc = $this->db->insert_id();   

           if(isset($pi_doc) && isset($data['team_member'])){

                     foreach($data['team_member'] as $k_tm=>$val_tm){

                         $team_dealer_interraction_rel = array(

                             'pidealer_id'=>$pi_doc,

                             'team_id'=>$val_tm,

                             'crm_user_id'=> $userId,

                             'last_update'=> savedate(),

                             'dealer_id'=>$data['d_id'],

                             'interaction_date'=>  date('Y-m-d', strtotime($data['doi_doc'])),

                         );

                         

                       $team_status = $this->db->insert('dealer_interaction_with_team',$team_dealer_interraction_rel);

                       

                       

                     } 

                  }

         

            if(isset($data['team_member'])){      

          if ($insert == TRUE && $team_status==1)

                           {

                        

                  return true;                           



                           }

                           else{



                               return false;



                           } 

                   }

                   else{

                     

                       if ($insert == TRUE)

                           {

                                return true;                           

                           }

                           else{

                               return false;

                           } 

                   }

             }

    }

    

    public function dealer_last_id(){

        $this->db->select_max('id');

        $query = $this->db->get('dealer');

        $row = $query->row_array();

        return $row['id'];

    }

    

    public function dealer_import_save($data){

        $this->db->select('*');

        $this->db->from('dealer');

        $this->db->where('d_phone',$data['d_phone']);

        $query = $this->db->get();

        if ($query->num_rows() == 0) {

           $this->db->insert('dealer', $data);

            return TRUE;

        }

        else

        {

            return False;

        }

    }



    public function get_dealer_data($id=''){

        $this->db->select('d_phone,d_email,dealer_name');

        $this->db->from('dealer');

        $this->db->where('dealer_id',$id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            return  $query->row();

        }

        else

        {

            return False;

        }

    }   

    

    /*Send message to admin when interaction mismatch*/

    public function interact_details(){

        $date1=substr(savedate(),0,10);

        //echo $date;

        //die;

        $dateObj = new DateTime($date1);

        $dateObj->modify("-7 day");

        $date= $dateObj->format("Y-m-d");

    

        /* Pharmacy Interaction With Team */

        $this->db->select('team_id,crm_user_id,pharma_id,interaction_date');

        $this->db->distinct();

        $this->db->from('pharmacy_interaction_with_team');

        $this->db->where('date(last_update)>=',$date);

        //$this->db->where('interaction_date',$date);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $pharma_interaction=$query->result_array();

            foreach($pharma_interaction as $interaction)

            {

                if(check_user_boss($interaction['crm_user_id'],$interaction['team_id']))

                {

                    $this->db->select('team_id,crm_user_id,pharma_id,interaction_date');

                    $this->db->from('pharmacy_interaction_with_team');

                    $this->db->where('interaction_date',$interaction['interaction_date']);

                    $this->db->where('pharma_id',$interaction['pharma_id']);

                    $this->db->where('team_id',$interaction['crm_user_id']);

                    $this->db->where('crm_user_id',$interaction['team_id']);

                    $query = $this->db->get();

                    if($query->num_rows()==0){

                        $subject="Reminder Mail";

                        $Emailmessage='Dear ,

                        Greetings,



                        Many Thanks!

                       ---------------------------- 

                        B. Jain Pharmaceutical Pvt Ltd

                        A 98 Sector 63, Noida

                        201301, Uttar Pradesh 

                        Tel: +91-120-49 33 333';

                        echo $adminEmail=get_user_deatils(28)->email_id;

                        //$success =send_email($adminEmail, $subject, $message);

                    }

                }

            }

        }

        

        /* Dealer Interaction With Team */

        $this->db->select('team_id,crm_user_id,dealer_id,interaction_date');

        $this->db->distinct();

        $this->db->from('dealer_interaction_with_team');

        $this->db->where('interaction_date',$date);

        //$this->db->where('date(last_update)>=',$date);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $pharma_interaction=$query->result_array();

            foreach($pharma_interaction as $interaction)

            {

                if(check_user_boss($interaction['crm_user_id'],$interaction['team_id']))

                {

                    $this->db->select('team_id,crm_user_id,dealer_id,interaction_date');

                    $this->db->from('dealer_interaction_with_team');

                    $this->db->where('interaction_date',$interaction['interaction_date']);

                    $this->db->where('dealer_id ',$interaction['dealer_id']);

                    $this->db->where('team_id',$interaction['crm_user_id']);

                    $this->db->where('crm_user_id',$interaction['team_id']);

                    $query = $this->db->get();

                    if($query->num_rows()==0){

                        $subject="Reminder Mail";

                        $Emailmessage='Dear ,

                        Greetings,



                        Many Thanks!

                       ---------------------------- 

                        B. Jain Pharmaceutical Pvt Ltd

                        A 98 Sector 63, Noida

                        201301, Uttar Pradesh 

                        Tel: +91-120-49 33 333';

                        echo $adminEmail=get_user_deatils(28)->email_id;//admin email

                        //$success =send_email($adminEmail, $subject, $message);

                    }

                }

            }

        }

        

        /* Doctor Interaction With Team */

        $this->db->select('team_id,crm_user_id,doc_id,interaction_date');

        $this->db->distinct();

        $this->db->from('doctor_interaction_with_team');

        $this->db->where('interaction_date',$date);

        //$this->db->where('date(last_update)>=',$date);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $pharma_interaction=$query->result_array();

            foreach($pharma_interaction as $interaction)

            {

                if(check_user_boss($interaction['crm_user_id'],$interaction['team_id']))

                {

                    $this->db->select('team_id,crm_user_id,doc_id,interaction_date');

                    $this->db->from('doctor_interaction_with_team');

                    $this->db->where('interaction_date',$interaction['interaction_date']);

                    $this->db->where('doc_id ',$interaction['doc_id']);

                    $this->db->where('team_id',$interaction['crm_user_id']);

                    $this->db->where('crm_user_id',$interaction['team_id']);

                    $query = $this->db->get();

                    if($query->num_rows()==0){

                        $subject="Reminder Mail";

                        $Emailmessage='Dear ,

                        Greetings,



                        Many Thanks!

                       ---------------------------- 

                        B. Jain Pharmaceutical Pvt Ltd

                        A 98 Sector 63, Noida

                        201301, Uttar Pradesh 

                        Tel: +91-120-49 33 333';

                        echo $adminEmail=get_user_deatils(28)->email_id;//admin email

                        //$success =send_email($adminEmail, $subject, $message);

                    }

                }

            }

        }

        die;

    }

    

    public function checkleave($idate){
        $this->db->select('from_date,to_date');
        $this->db->from('user_leave');
        $this->db->where('user_id',logged_user_data());
        $this->db->where('leave_status',1);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            $dateData=$query->result_array();
            foreach($dateData as $dates)
            {
                $this->db->select('leave_id');
                $this->db->from('user_leave');
                $this->db->where("'".date('Y-m-d',strtotime($idate))."' >= '".$dates['from_date']."' AND '".date('Y-m-d',strtotime($idate))."'<='".$dates['to_date']."'");
                $this->db->where('user_id',logged_user_data());
                $this->db->where('leave_status',1);
                $query1 = $this->db->get();
                if ($query1->num_rows() > 0) {
                    return FALSE;
                }
            }
            $con='find_in_set('.logged_user_data().',user_ids)<>0';
            $this->db->select('from_date,to_date');
            $this->db->from('user_holiday');
            $this->db->where($con);
            // $this->db->where('leave_status',1);
            $query = $this->db->get();
            //echo $this->db->last_query();die;
            if ($query->num_rows() > 0) {
                $dateData=$query->result_array();
                foreach($dateData as $dates)
                {
                    $this->db->select('holiday_id');
                    $this->db->from('user_holiday');
                    $this->db->where("'".date('Y-m-d',strtotime($idate))."' >= '".$dates['from_date']."' AND '".date('Y-m-d',strtotime($idate))."'<='".$dates['to_date']."'");
                    $this->db->where($con);
                  //  $this->db->where('leave_status',1);
                    $query1 = $this->db->get();
                    if ($query1->num_rows() > 0) {
                        return FALSE;
                    }
                }
                return TRUE;
            }
            else{
                return TRUE;
            }
            return TRUE;
        }
        else{
            $con='find_in_set('.logged_user_data().',user_ids)<>0';
            $this->db->select('from_date,to_date');
            $this->db->from('user_holiday');
            $this->db->where($con);
            // $this->db->where('leave_status',1);
            $query = $this->db->get();
            //echo $this->db->last_query();die;
            if ($query->num_rows() > 0) {
                $dateData=$query->result_array();
                foreach($dateData as $dates)
                {
                    $this->db->select('holiday_id');
                    $this->db->from('user_holiday');
                    $this->db->where("'".date('Y-m-d',strtotime($idate))."' >= '".$dates['from_date']."' AND '".date('Y-m-d',strtotime($idate))."'<='".$dates['to_date']."'");
                    $this->db->where($con);
                  //  $this->db->where('leave_status',1);
                    $query1 = $this->db->get();
                    if ($query1->num_rows() > 0) {
                        return FALSE;
                    }
                }
                return TRUE;
            }
            else{
                return TRUE;
            }
            return TRUE;
        }

    }

    

    public function insert_tour_log($stay,$cityid,$interactionId,$doi){

        $interact_date = date('Y-m-d', strtotime($doi));

        $tour_data = array(

            'stay'=>$stay,

            'city_id'=>$cityid,

            'interact_date'=>$interact_date,

            'interaction_id'=>$interactionId,

            'crm_user_id'=> logged_user_data(),

            'created_date'=>savedate(),                  

            'updated_date'=>savedate(),                  

            'status'=>1, 

        );

        $this->db->insert('user_tour_log',$tour_data); 

        return ($this->db->affected_rows() == 1) ? true : false; 

    }



    public function get_orderdeatils_user($data)
    {
        $this->db->select('id');
        $this->db->where('interaction_id',0); 
        if(isset($data['doc_id']))
        {
            $this->db->where('interaction_person_id',$data['doc_id']); 
        }
        else if(isset($data['d_id']))
        {
            $this->db->where('interaction_person_id',$data['d_id']); 
        }
        else if(isset($data['pharma_id']))
        {
            $this->db->where('interaction_person_id',$data['pharma_id']); 
        } 

        $this->db->where('crm_user_id',logged_user_data()); 

        $this->db->from('interaction_order'); 

        $query1 = $this->db->get();

        if($this->db->affected_rows())

        {

            $orderId=$query1->row()->id;

            $arr = "id,product_id,actual_value,discount,net_amount,quantity";

            $this->db->select($arr);

            $this->db->from("order_details");

            $this->db->where("order_id",$orderId);

            $query = $this->db->get();

            if($this->db->affected_rows()){

                return $result=$query->result_array();

            }

            else{

                return false;

            }

        }

        return false;

    }



   public function check_duplicate_value($data)
   {
        $pharmacy_product=array();

        $order_all_product=array();

        $total_count=0;

        $duplicate_count=0;

        $duplicate_value='';

        $col='id';

        $this->db->select($col); 

        $this->db->from('interaction_order');

        $this->db->where('interaction_id',0); 

        $this->db->where('interaction_person_id',$data['dealer_view_id']); 

        $this->db->where('crm_user_id',logged_user_data()); 

        $query= $this->db->get(); 

        if($this->db->affected_rows()){

            $interaction_order_id= $query->row()->id; 

            $arr = "id,product_id,actual_value,discount,net_amount,quantity";

            $this->db->select($arr);

            $this->db->from("order_details");

            $this->db->where("order_id",$interaction_order_id);

           // $this->db->where("crm_user_id",logged_user_data());

            $query = $this->db->get();

            if($this->db->affected_rows()){

                //return $result=$query->result_array();

               $pharmacy_product=$query->result_array();

            }
        }  

       // pr($pharmacy_product);



        $col='id';

        $this->db->select($col); 

        $this->db->from('interaction_order');

        $this->db->where('crm_user_id',logged_user_data());

        $this->db->where('duplicate_status',0);

        $this->db->where('interaction_with_id',$data['dealer_view_id']); 

        $this->db->where('interaction_person_id',$data['rel_doc_id']); 

        $query= $this->db->get(); 

        //echo $this->db->last_query();

       // die;

        if($this->db->affected_rows()){

            //echo $query->row()->id; 

            $interact_ids=$query->result_array();

            foreach($interact_ids as $interact_id)

            {

                $arr = "id,product_id,actual_value,discount,net_amount,quantity";

                $this->db->select($arr);

                $this->db->from("order_details");

                $this->db->where("order_id",$interact_id['id']);

                $query = $this->db->get();

                if($this->db->affected_rows()){

                    //return $result=$query->result_array();

                    $order_all_product=array_merge($order_all_product,$query->result_array());

                   // $order_all_product[]=$query->result_array();



                }

            }

        } 

        foreach($pharmacy_product as $pharma_product)

        {

            foreach($order_all_product as $order_product)

            {

                if($order_product['product_id']==$pharma_product['product_id'])

                {

                   $total_count=$total_count+$order_product['quantity']+$pharma_product['quantity'];

                   $duplicate_count=$duplicate_count+$pharma_product['quantity'];

                   if($duplicate_value=='')
                   {
                        $duplicate_value=$duplicate_value.$pharma_product['product_id'];
                   }

                   else
                   {
                        $duplicate_value=$duplicate_value.','.$pharma_product['product_id'];
                   }

                }

            }

        }
        $real_duplicate=$total_count-$duplicate_count;

        $duplicateData=array('dp_count'=>$real_duplicate,'dp_value'=>$duplicate_value);

        return $duplicateData;

        

   } 

    

}