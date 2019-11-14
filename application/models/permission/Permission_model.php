<?php



/* 

 * Niraj Kumar

 * Dated: 23-oct-2017

 * 

 * model for set User Permission 

 */



class Permission_model extends CI_Model {



    // show list of user 

    public function user_list($id=''){

        

        $arr = "pu.user_status as status,pu.hq_city as hq_city,pu.hq_city_pincode as  hq_city_pincode,pu.emp_code,pu.sp_code,pu.id,pu.name,pu.email_id as email,pu.user_phone as phone,pu.user_address as address,pu.user_city_id as city_id,pu.user_designation_id as desig_id,ud.designation_name,(SELECT GROUP_CONCAT(`pharma_id` separator ', ') as pharma_id FROM `user_pharmacy_relation` `upr` WHERE `pu`.`id`=`upr`.`user_id`) as pharma_id,(SELECT GROUP_CONCAT(`doc_id` separator ', ') as doctor_id FROM `user_doctor_relation` `udoc` WHERE `pu`.`id`=`udoc`.`user_id`) as doctor_id,(SELECT GROUP_CONCAT(`boss_id` separator ', ') as bossid FROM `user_bossuser_relation` `ubr` WHERE `pu`.`id`=`ubr`.`user_id`) as bossid ";

        $this->db->select($arr);

        $this->db->from("pharma_users pu");

        $this->db->join("user_designation ud","pu.user_designation_id=ud.id");

        

        if($id!=''){

            $userid = urisafedecode($id);

            $this->db->where("pu.id",$userid);

        }

//        $this->db->join("user_dealer_relation udr","pu.id=udr.user_id");

//        $this->db->join("dealer deal","deal.dealer_id=udr.dealer_id");



        $query = $this->db->get();

//         echo $this->db->last_query(); die;

        if($this->db->affected_rows()){

            

            return json_encode($query->result_array());

        }

        else{

            

            return FALSE;

        } 

    }













    // for add and edit the users data

    public function create_users($data,$user_id=''){



//      pr($data); die;

             $city_id = implode(',', $data['user_city']);

//         echo $city_id; die;

         if($user_id !=''){   // for update user details

             

             if(!empty($data['user_pass'])){  // if password is changed

             $user_data = 

                array(

                    'name'=>$data['user_name'],

                    'email_id'=> $data['user_email'],

                    'user_phone'=>$data['user_ph'],
                   
                    'hq_city'=>$data['hq_city'],
                    'hq_city_pincode'=>$data['city_pin'],
                  
                    'user_city_id'=>$city_id,

                    'user_address'=>$data['user_address'],

                    'user_designation_id'=>$data['user_designation'],

                    'emp_code'=>$data['emp_code'],
                        'sp_code'=>trim($data['sp_code'],","),
                    'password'=>md5($data['user_pass']),

                    'create_date'=>savedate(),

                    'crm_user_id'=> logged_user_data(),

                    'last_update'=>savedate(),

                    'user_status'=>1,

                                     

                );

             }

             else{  // if password is not changed

                  $user_data = 

                array(

                    'name'=>$data['user_name'],

                    'email_id'=> $data['user_email'],

                    'user_phone'=>$data['user_ph'],
                    'hq_city'=>$data['hq_city'],
                    'hq_city_pincode'=>$data['city_pin'],
                    'user_city_id'=>$city_id,

                    'user_address'=>$data['user_address'],

                    'user_designation_id'=>$data['user_designation'],

                   'emp_code'=>$data['emp_code'],
                   'sp_code'=>trim($data['sp_code'],","),
                    'create_date'=>savedate(),

                    'crm_user_id'=> logged_user_data(),

                    'last_update'=>savedate(),

                    'user_status'=>1,

                                     

                );

             }

             

             

           $this->db->where('id',$user_id);

           $this->db->update('pharma_users',$user_data);

         

           

            $u_id = $user_id;

          

           if(!empty($data['user_pharmacy']) || !empty($data['user_doctors']) || !empty($data['boss']) ){

            

                $del_dealer = del_deal_doc_rel_row($u_id, 'user_pharmacy_relation') ;

                $del_doc=del_deal_doc_rel_row($u_id, 'user_doctor_relation') ;

                $del_boss=del_deal_doc_rel_row($u_id, 'user_bossuser_relation') ;

//               echo $del_dealer; die;

           if(!empty($data['user_pharmacy']) || $del_dealer==1){   // add dealers list for the user   

               foreach ($data['user_pharmacy'] as $k => $val){

               $users_dealer_link = array(

                   'user_id'=>$u_id,

                   'pharma_id'=>$val,

                   'last_update'=> savedate(),

                   'crm_user_id' => logged_user_data(),

               );

             $status =$this->db->insert('user_pharmacy_relation',$users_dealer_link);  

               } 

             if (!empty($data['user_doctors']) || $del_doc==1) {   // add doctor list for the user

            foreach ($data['user_doctors'] as $k => $val){ 

               $users_doc_link = array(

                   'user_id'=>$u_id,

                   'doc_id'=>$val,

                   'last_update'=> savedate(),

                   'crm_user_id' => logged_user_data(),

               );

             $status =$this->db->insert('user_doctor_relation',$users_doc_link);   

           }

       }

       

       if (!empty($data['boss']) || $del_boss==1) {   // add boss for the user

            foreach ($data['boss'] as $k => $val){ 

              $users_boss_link = array(

                   'user_id'=>$u_id,

                   'boss_id'=>$val,

                   'last_update'=> savedate(),

                   'crm_user_id' => logged_user_data(),

               );

             $status =$this->db->insert('user_bossuser_relation',$users_boss_link);   

           }

       }

             

           

           }

           elseif (!empty($data['user_doctors']) || $del_doc==1) {   // add doctor list for the user

            foreach ($data['user_doctors'] as $k => $val){ 

               $users_doc_link = array(

                   'user_id'=>$u_id,

                   'doc_id'=>$val,

                   'last_update'=> savedate(),

                   'crm_user_id' => logged_user_data(),

               );

             $status =$this->db->insert('user_doctor_relation',$users_doc_link);   

           }

           

             

       if (!empty($data['boss']) || $del_boss==1) {   // add boss for the user

            foreach ($data['boss'] as $k => $val){ 

              $users_boss_link = array(

                   'user_id'=>$u_id,

                   'boss_id'=>$val,

                   'last_update'=> savedate(),

                   'crm_user_id' => logged_user_data(),

               );

             $status =$this->db->insert('user_bossuser_relation',$users_boss_link);   

           }

       }

            

       }

       elseif (!empty($data['boss']) || $del_boss==1) {   // add boss for the user

            foreach ($data['boss'] as $k => $val){ 

              $users_boss_link = array(

                   'user_id'=>$u_id,

                   'boss_id'=>$val,

                   'last_update'=> savedate(),

                   'crm_user_id' => logged_user_data(),

               );

             $status =$this->db->insert('user_bossuser_relation',$users_boss_link);   

           }

       }

            

           

           

           }

           

           

                    if ($this->db->affected_rows() === TRUE && $status==1)

                           {

                              return true;



                           }

                           else{



                               return false;



                           }   



        }else{  // for create user

            

            

            

           $user_data = 

                array(

                    'name'=>$data['user_name'],

                    'email_id'=> trim($data['user_email']),

                    'user_phone'=>$data['user_ph'],

                    'emp_code'=>trim($data['emp_code']),
                        'sp_code'=>trim($data['sp_code'],","),
                    'hq_city'=>$data['hq_city'],
                    'hq_city_pincode'=>$data['city_pin'],

                    'user_city_id'=>$city_id,

                    'user_address'=>$data['user_address'],

                    'user_designation_id'=>$data['user_designation'],

                    'password'=>md5($data['user_pass']),

                    'create_date'=>savedate(),

                    'crm_user_id'=> logged_user_data(),

                    'last_update'=>savedate(),

                    'user_status'=>1,

                                     

                );        

          $this->db->insert('pharma_users',$user_data); 

          

           $u_id = $this->db->insert_id();

          

           if(!empty($data['user_pharmacy']) || !empty($data['user_doctors']) || !empty($data['boss'])){

             

 // below if condition is for the user who have dealer,doctor and boss too or either one or two             

           if(!empty($data['user_pharmacy'])){   // add dealers list for the user 

               

               foreach ($data['user_pharmacy'] as $k => $val){

               $users_dealer_link = array(

                   'user_id'=>$u_id,

                   'pharma_id'=>$val,

                   'last_update'=> savedate(),

                   'crm_user_id' => logged_user_data(),

               );

             $status =$this->db->insert('user_pharmacy_relation',$users_dealer_link);   

           }

           

           if (!empty($data['user_doctors'])) {   // add doctor list for the user this is when we have both dealer and doctor

            foreach ($data['user_doctors'] as $k => $val){ 

               $users_doc_link = array(

                   'user_id'=>$u_id,

                   'doc_id'=>$val,

                   'last_update'=> savedate(),

                   'crm_user_id' => logged_user_data(),

               );

             $status =$this->db->insert('user_doctor_relation',$users_doc_link);   

           }

       }

       

           if (!empty($data['boss'])) {   // add boss list for the user

            foreach ($data['boss'] as $k => $val){ 

               $users_boss_link = array(

                   'user_id'=>$u_id,

                   'boss_id'=>$val,

                   'last_update'=> savedate(),

                   'crm_user_id' => logged_user_data(),

               );

             $status =$this->db->insert('user_bossuser_relation',$users_boss_link);   

           }

       }

           

           

           }

           

// below if condition is for the user who have doctor and boss too or either one             

           elseif (!empty($data['user_doctors'])) {   // add doctor list for the user

//               pr($data['user_doctors']); die;

            foreach ($data['user_doctors'] as $k => $val){ 

               $users_doc_link = array(

                   'user_id'=>$u_id,

                   'doc_id'=>$val,

                   'last_update'=> savedate(),

                   'crm_user_id' => logged_user_data(),

               );

             $status =$this->db->insert('user_doctor_relation',$users_doc_link);   

           }

             if (!empty($data['boss'])) {   // add boss list for the user

            foreach ($data['boss'] as $k => $val){ 

               $users_boss_link = array(

                   'user_id'=>$u_id,

                   'boss_id'=>$val,

                   'last_update'=> savedate(),

                   'crm_user_id' => logged_user_data(),

               );

             $status =$this->db->insert('user_bossuser_relation',$users_boss_link);   

             }

             

            }

           

       }

 

// below if condition is for the user who have only boss          

       elseif (!empty($data['boss'])) {   // add boss list for the user

            foreach ($data['boss'] as $k => $val){ 

               $users_boss_link = array(

                   'user_id'=>$u_id,

                   'boss_id'=>$val,

                   'last_update'=> savedate(),

                   'crm_user_id' => logged_user_data(),

               );

             $status =$this->db->insert('user_bossuser_relation',$users_boss_link);   

             }

             

            }

           

           

           }

            

            return ($this->db->affected_rows() != 1 && $status!= 1) ? false : true; 

        }

 

    }

    

   

    // for show list of designation data

    public function designation_list($id=''){

        

        $arr = "id,designation_name as d_name";

        $this->db->select($arr);

        $this->db->from("user_designation");



        $query = $this->db->get();

//         echo $this->db->last_query(); die;

        if($this->db->affected_rows()){

            

            return json_encode($query->result_array());

        }

        else{

            

            return FALSE;

        }

    }

    

    

    // show list of doctors which have user city same

    public function doctor_list($id){

        

        $cityid = explode(',',$id );

        

//        pr($cityid); die;

        

        $arr = "doc.doctor_id as id,doc.doc_name,c.city_name";

        $this->db->select($arr);

        $this->db->from("doctor_list doc");

        $this->db->join("city c","c.city_id=doc.city_id");

        

        if(!empty($id)){

            foreach($cityid as $value){

           $this->db->or_where("doc.city_id",$value);  

            }

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

  public function pharmacy_list_user($id='')
  { 
    if($id!='')
    {
      $arr = "sp_code";
      $this->db->select($arr);
      $this->db->from("pharma_users");
      $this->db->where("id",$id);
      $query = $this->db->get();
      //echo $this->db->last_query();
      if($this->db->affected_rows())
      {
          $sp= $query->row()->sp_code;
          if($sp=='')
          {
            $sp= 0;  
          }
      }
      else
      {
        $sp= 0;
      }
    }
    else
    {
        
      $sp=$this->session->userdata('sp_code');
    }

    $arr = "pl.pharma_id as id,pl.company_name as com_name,c.city_name,pl.pharmacy_status as status,pl.blocked";
    $this->db->select($arr);
    $this->db->from("pharmacy_list pl");
    $this->db->join("city c","c.city_id=pl.city_id");
    $this->db->where("`pl`.`sp_code` in (".$sp.")");
    $query = $this->db->get();
   // echo $this->db->last_query(); die;
    if($this->db->affected_rows())
    {
      return $query->result_array();
    }
    else{
      return FALSE;
    }
  }

  public function doctor_list_user($id=''){ 
    if($id!='')
    {
      $arr = "sp_code";
      $this->db->select($arr);
      $this->db->from("pharma_users");
      $this->db->where("id","31");
      $query = $this->db->get();
      if($this->db->affected_rows())
      {
        $sp= $query->row()->sp_code;
          if($sp=='')
          {
            $sp= 0;  
          }

      }
      else
      {
        $sp= 0;
      }
    }
    else
    {
      $sp=$this->session->userdata('sp_code');
    }
    $arr = "id";
    $this->db->select($arr);
    $this->db->from("doctor_list pl");
    $this->db->where("`pl`.`sp_code` in (".$sp.")");
    $query = $this->db->get();
    //echo $this->db->last_query(); die;
    if($this->db->affected_rows())
    {
      return $query->result_array();
    }
    else{
      return FALSE;
    }
  }

    // show list of Sub Dealer which have user city same

    public function pharmacy_list($id){
      $cityid = explode(',',$id );
      $arr = "pl.pharma_id as id,pl.company_name as com_name,c.city_name,pl.pharmacy_status as status,pl.blocked";
      $this->db->select($arr);
      $this->db->from("pharmacy_list pl");
      $this->db->join("city c","c.city_id=pl.city_id");
      if(1==2 && !is_admin()){
        if(!empty($id)){
          foreach($cityid as $value){
           $this->db->or_where("pl.city_id",$value);  
          }
        }
        $this->db->or_where("pl.crm_user_id", logged_user_data());    // for show  logged user data pharmacy list too
      }
      $query = $this->db->get();
      //echo $this->db->last_query(); die;
      if($this->db->affected_rows())
      {
        return $query->result_array();
      }
      else{
        return FALSE;
      }
    }

    // show list of Boss which have user city same and have high designation

     public function boss_list($desig_id,$cid,$id=''){



        $arr = "pu.id,pu.name,ud.designation_name";
        $this->db->select($arr);
        $this->db->from("pharma_users pu");
        $this->db->join("user_designation ud","pu.user_designation_id=ud.id");
        if(!empty($cid)){
            $where='( ';
            $k=0;    
            foreach($cid as $value){
                $where  .= " FIND_IN_SET('$value',pu.user_city_id) !=0 ";
                if(count($cid)>($k+1)){
                  $where  .=" OR ";
                }
                $k++;
            }

             $where  .= " ) ";

             $this->db->where($where);

//           $this->db->or_where("FIND_IN_SET('$value',pu.user_city_id) !=", 0); 

            

        }

        if(!empty($desig_id)){

           $this->db->where("pu.user_designation_id <=",$desig_id);  

           

           

        }

        if($id!=''){

            $userid = urisafedecode($id);

            $this->db->where("pu.id != ",$userid);

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


    // for de-active the user(this function only change the status of user master for de-active)
    public function del_usermaster($sm_id){
      $sample_data= array(
        'crm_user_id'=> logged_user_data(),
        'last_update'=>savedate(),
        'user_status'=>0, 
      );
      $this->db->where('id',$sm_id);
      $this->db->update('pharma_users',$sample_data);
      if ($this->db->trans_status() === TRUE)
      {
        return true;
      }
      else{
      return false;
      }   
    }

    // for active the user(this function only change the status of user master for active)

    public function active_usermaster($sm_id){

        

        $sample_data= array(

             'crm_user_id'=> logged_user_data(),

                    'last_update'=>savedate(),

                    'user_status'=>1, 

        );
           $this->db->where('id',$sm_id);
           $this->db->update('pharma_users',$sample_data);
           if ($this->db->trans_status() === TRUE)
          {
              return true;
          }
          else{
            return false;
          }   
}

    

    /*

     * @Developer: Niraj Kumar
     * Dated: 03-nov-2017
     * Email: niraj@bjain.com
     * 
     * Functon is for choose a team member names if he mets with
     * doctor,pharmacy,dealer with Team.
     * 
    */

    

    

  //team members names
  // show child and boss users

  public function user_team(){
    $boss=logged_user_boss();
    $boss_id = explode(',',$boss);
    $child = logged_user_child();
    $child_id = explode(',', $child);
    // pr($boss_id); die;
    $arr="pu.id as userid,pu.name as username";
    $this->db->select($arr);
    $this->db->from('pharma_users pu ');
    if(!empty($boss)){
      foreach($boss_id as $kb=>$valb){
        $this->db->or_where('pu.id',$valb);
      }
    }
    if(!empty($child)){
      foreach($child_id as $kc=>$valc){
        $this->db->or_where('pu.id',$valc);
      }
    }
    $query = $this->db->get();
    // echo $this->db->last_query(); die;
    if($this->db->affected_rows()){
      return json_encode($query->result_array());
    }
    else{
      return FALSE;
    }
  }

}