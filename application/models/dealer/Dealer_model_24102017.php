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
   
        $arr ="d.dealer_id,d.dealer_name,c.city_name";
        $this->db->select($arr);
        $this->db->from('dealer d');
        $this->db->where('d.gd_id IS NULL',null,true);
        $this->db->join("city c" , "c.city_id=d.city_id");
     
        
        $query= $this->db->get();
        
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
                    
                    'd_about'=>$data['about_d'],
                    'd_address'=>$data['d_address'],
                    'city_id'=>$data['dealer_city'],
                    'state_id'=>$data['dealer_state'],
                    'status'=>1,
                    'added_date'=> savedate(),
                    'crm_user_id' =>logged_user_data(),
                    
                );
            
            
            $this->db->where('dealer_id',$d_id);
           $this->db->update('dealer',$dealer_data);
//            echo $this->db->last_query(); die;      
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
                    
                );
        
           $this->db->insert('dealer',$dealer_data); 
            
            return ($this->db->affected_rows() != 1) ? false : true; 
        }
         
    }
    
    // for show data of dealers
    public function dealermaster_info($limit,$start,$data=''){
        
        $arr = "d.dealer_id as id,d.d_email as d_email,d.d_phone as d_ph,d.dealer_name as d_name,c.city_name as d_city,d.dealer_are,d.gd_id";
        $this->db->select($arr);
        $this->db->from("dealer d");
//      $this->db->join("dealer s" , "s.dealer_id=sm.s_id");
        $this->db->join("city c" , "c.city_id=d.city_id");
        $this->db->join("state st" , "st.state_id=d.state_id");
      
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
        
        $this->db->limit($limit, decode($start));
        
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
    
     public function sub_dealer_totaldata($data=''){
        
//        pr($data);die;
      
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
         
         $this->db->like('d.dealer_name',$data);
         $this->db->or_like('d.d_email',$data);
         $this->db->or_like('d.d_phone',$data);
         $this->db->or_like('c.city_name',$data);
         $this->db->or_like('st.state_name',$data);
//          $this->db->or_like('cl.c_name',$data);
     }
//        }
     $this->db->where('d.gd_id IS NULL',null,true);
        
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
     public function main_dealermaster_info($limit,$start,$data=''){
        
        $arr = "d.dealer_id as id,d.d_email as d_email,d.d_phone as d_ph,d.dealer_name as d_name,c.city_name as d_city,d.dealer_are,d.gd_id";
        $this->db->select($arr);
        $this->db->from("dealer d");
//      $this->db->join("dealer s" , "s.dealer_id=sm.s_id");
        $this->db->join("city c" , "c.city_id=d.city_id");
        $this->db->join("state st" , "st.state_id=d.state_id");
      
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
        
        $this->db->limit($limit, decode($start));
        
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
        
//        pr($data);die;
      
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
        
          $arr = "d.dealer_id as d_id,d.d_alt_phone as alt_phone,d.d_address,d.dealer_name,d.d_email as d_email,d.d_phone as d_ph,d.d_about,d.dealer_are,d.gd_id,d.state_id,d.city_id,c.city_name";
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
                    'state_id'=>$data['dealer_state'],
                    'city_id'=>$data['dealer_city'],
                    'd_about'=>$data['group_about_d'],
                    'dealer_are'=>$group_dealer_id,
                    'gd_id' =>'gorg_100',
                    'd_address'=>$data['d_address'],
                    'status'=>1,
                    'added_date'=> savedate(),
                    'crm_user_id' =>logged_user_data(),
                    
                );
             }
             else{
               
//                 echo "else"; die;
                 $dealer_data = 
                array(
                    'dealer_name'=>$data['group_dealer_name'],
                    'd_email'=>$data['group_dealer_email'],
                    'd_phone'=>$data['group_dealer_num'],
                    'state_id'=>$data['dealer_state'],
                    'city_id'=>$data['dealer_city'],
                    'd_about'=>$data['group_about_d'],
                    
                    'd_address'=>$data['d_address'],
                    'status'=>1,
                    'added_date'=> savedate(),
                    'crm_user_id' =>logged_user_data(),
                    
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
    
    // save ineraction data
    public function save_interaction($data){
//        pr($data); die;
        
        if(isset($data['meet_or_not'])){
            $meet_or_not = $data['meet_or_not'];
        }
        else{
            $meet_or_not=NULL;
        }
        
        if(isset($data['doc_id'])){   // for Doctor interaction
            
            if(!empty($data['m_sample'])){  // for multipile sample data
                  
                 $interaction_info = array(
                            'doc_id'=>$data['doc_id'],
                            'dealer_id'=>$data['dealer_id'],
                            'meeting_sale'=>$data['m_sale'],
                        
                           'meet_or_not_meet'=>$meet_or_not,
                          
                           'remark'=>$data['remark'],
                           
                            'follow_up_action'=>date('Y-m-d', strtotime($data['fup_a'])),
                            'status'=>1,
                            'crm_user_id'=> logged_user_data(),
                            'create_date'=> savedate(),
                                );
             
                  $this->db->insert('pharma_interaction_doctor',$interaction_info);
                
                  $pi_doc = $this->db->insert_id();
                  
                  if(isset($pi_doc)){
                     foreach($data['m_sample'] as $kms=>$val_ms){
                         $sample_doc_interraction_rel = array(
                             'pidoc_id'=>$pi_doc,
                             'sample_id'=>$val_ms,
                             'crm_user_id'=> logged_user_data(),
                             'last_update'=> savedate(),
                         );
                         
                      $status= $this->db->insert('doctor_interaction_sample_relation',$sample_doc_interraction_rel);
                       
                       
                     } 
                  }
              
          if ($this->db->trans_status() === TRUE && $status == 1)
                           {
                        
                  return true;                           

                           }
                           else{

                               return false;

                           } 
                 
                 
                 
            }
            else{
        $interaction_info = array(
                            'doc_id'=>$data['doc_id'],
                            'dealer_id'=>$data['dealer_id'],
                            'meeting_sale'=>$data['m_sale'],
                          
                          
                           'meet_or_not_meet'=>$meet_or_not,
                           
                           'remark'=>$data['remark'],
                           
                            'follow_up_action'=>date('Y-m-d', strtotime($data['fup_a'])),
                            'status'=>1,
                            'crm_user_id'=> logged_user_data(),
                            'create_date'=> savedate(),
                                );
        
         $this->db->insert('pharma_interaction_doctor',$interaction_info);
                
          if ($this->db->trans_status() === TRUE)
                           {
                        
                  return true;                           

                           }
                           else{

                               return false;

                           } 
        
            }
       
        }
        else if(isset($data['d_id'])){   // for dealer interaction
            
            
            
            $interaction_info = array(
                            'd_id'=>$data['d_id'],
                           'meeting_sale'=>$data['m_sale'],
                           'meeting_payment'=>$data['m_payment'],
                           'meeting_stock'=>$data['m_stock'],
                           'meet_or_not_meet'=>$meet_or_not,
                           
                           'remark'=>$data['remark'],
                           
                            'follow_up_action'=>date('Y-m-d', strtotime($data['fup_a'])),
                            'status'=>1,
                            'crm_user_id'=> logged_user_data(),
                            'create_date'=> savedate(),
                                );
           
        $this->db->insert('pharma_interaction_dealer',$interaction_info);
        
          if ($this->db->trans_status() === TRUE)
                           {
                        
                  return true;                           

                           }
                           else{

                               return false;

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
         
         $res_dealer=$query->row();
         
        if(!empty($res_dealer->gd_id)){
            
            $dealers_are = explode(',', $res_dealer->dealer_are);
//            pr($dealers_are); die;
            $arr = "d.dealer_name,mmt.meeting_name as mmt_name,si.remark,si.additional_remark,si.follow_up_action,u.name as username";
                $this->db->select($arr);
                $this->db->from('pharma_interaction si');
                $this->db->join('dealer d','d.dealer_id=si.d_id');
                $this->db->join('pharma_users u','u.id=si.crm_user_id');
                $this->db->join('main_meeting_type mmt','mmt.id=si.mm_type_id');
               
                $this->db->where_in('si.d_id',$dealers_are);
                 $this->db->or_where('si.d_id',$id);
                 $this->db->order_by('si.create_date','DESC');
                $query = $this->db->get();
         
              $res_dealer_interaction=$query->result_array();
           
            
        }
        else{
             $arr = "d.dealer_name,mmt.meeting_name as mmt_name,si.remark,si.additional_remark,si.follow_up_action,u.name as username";
                $this->db->select($arr);
                $this->db->from('pharma_interaction si');
                $this->db->join('dealer d','d.dealer_id=si.d_id');
                $this->db->join('pharma_users u','u.id=si.crm_user_id');
                $this->db->join('main_meeting_type mmt','mmt.id=si.mm_type_id');
             
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
            $arr = "cl.doc_name as d_name,mmt.meeting_name as mmt_name,si.remark,si.additional_remark,si.follow_up_action,u.name as username";
                $this->db->select($arr);
                $this->db->from('pharma_interaction si');
                $this->db->join('doctor_list cl','cl.doctor_id=si.doc_id');
                
//               $this->db->join('dealer d');
                $this->db->join('pharma_users u','u.id=si.crm_user_id');
                $this->db->join('main_meeting_type mmt','mmt.id=si.mm_type_id');
               
                $this->db->where("FIND_IN_SET('$id',cl.d_id) !=", 0);
//                $this->db->where('cl.doctor_id',$id);
                $this->db->order_by('si.create_date','DESC');
                
//        echo $this->db->last_query(); die;
         $query = $this->db->get();
//          echo $this->db->last_query(); die;
      
           if($this->db->affected_rows()){
            
            return json_encode($query->result_array());
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
    
    
    
   
    
    
}
