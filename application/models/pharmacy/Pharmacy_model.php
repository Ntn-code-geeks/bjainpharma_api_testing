<?php



/* 

 * Niraj Kumar

 * Dated: 25-oct-2017

 * 

 * model for pharmacy details 

 */



class Pharmacy_model extends CI_Model {



    // update dealers pof the pharmacy

public function update_dealer_of_pharma($data=''){

//        pr($data); die;

        $pharma_dealers = 

                array(
                                

                    'd_id'=>$data['dealers'],

                   

                    'crm_user_id'=> logged_user_data(),

                    'last_update'=>savedate(),

                    

                );

        

        $this->db->where('pharma_id',$data['pharma_id']);

                         $this->db->update('pharmacy_list',$pharma_dealers);

//         echo $this->db->last_query(); die;

         return ($this->db->affected_rows() != 1) ? false : true; 

        

    }

    

    

    public function add_pharmacymaster($data,$p_id=''){

      

//        pr($data);

//       

//        die;

        if(!empty($data['dob'])){

            $dob = date('Y-m-d', strtotime($data['dob']));

             }

        else{

                $dob=NULL;

            }

        

        if(isset($data['dealer_id']) && !empty($data['dealer_id'])){

            $dealers_id=implode(',',$data['dealer_id']);

        }
        $pharmacy_data = 

                array(

                    'company_name'=>$data['com_name'],

                    'company_email'=>$data['com_email'],

                    'company_phone'=>$data['com_number'],
                    'city_pincode'=>$data['city_pin'],
                    'company_address'=>$data['com_address'],                                       

                    'state_id'=>$data['com_state'],

                    'city_id'=>$data['com_city'],

                    

                    'owner_name'=>$data['owner_name'],

                    'owner_email'=>$data['owner_email'],

                    'owner_phone'=>$data['owner_number'],
                    'sp_code'=>$data['sp_code'],

                    'owner_dob'=>$dob,                 

                    'd_id'=>$dealers_id,

                   

                    'crm_user_id'=> logged_user_data(),

                    'last_update'=>savedate(),

                    'pharmacy_status'=>1,   

                     'doc_navigate_id'=>$data['doc_navigon'],

                );

         

         if($p_id !=''){

            

            $this->db->where('pharma_id',$p_id);

           $this->db->update('pharmacy_list',$pharmacy_data);

         

                    if ($this->db->trans_status() === TRUE)

                           {

                              return true;



                           }

                           else{



                               return false;



                           }   



        }else{

         

        

          $this->db->insert('pharmacy_list',$pharmacy_data); 

               

          $ap_id=$this->db->insert_id();

          $newid = "pharma_".$ap_id;

          

          $pharmacy_data = 

                array(

                    'pharma_id'=>$newid,

                    'company_name'=>$data['com_name'],

                    'company_email'=>$data['com_email'],

                    'company_phone'=>$data['com_number'],

                    'company_address'=>$data['com_address'],                                       

                    'state_id'=>$data['com_state'],

                    'city_id'=>$data['com_city'],

                    
                    'sp_code'=>$data['sp_code'],
                    'owner_name'=>$data['owner_name'],

                    'owner_email'=>$data['owner_email'],

                    'owner_phone'=>$data['owner_number'],

                    'owner_dob'=>$dob,                 

                    'd_id'=>$dealers_id,

                   

                    'crm_user_id'=> logged_user_data(),

                    'last_update'=>savedate(),

                    'pharmacy_status'=>1, 

                    'doc_navigate_id'=>$data['doc_navigon'],

                    

                );

         

//          pr($doctor_data); die;

           $this->db->where('id',$ap_id);

           $this->db->update('pharmacy_list',$pharmacy_data);

          

          

            return ($this->db->affected_rows() != 1) ? false : true; 

        }

 

    }

    

    public function totaldata($city_search=''){

        

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

        

         $boss_are = logged_user_boss();

          $boss_id=explode(',', $boss_are);

          

          

          $pharma_are = logged_user_pharmaare();

          $pharma_id=explode(',', $pharma_are);

        

        

         $arr = "pharma.pharma_id as id";

        $this->db->select($arr);

        $this->db->from("pharmacy_list pharma");

       $this->db->join("city c" , "c.city_id=pharma.city_id");

        $this->db->join("state st" , "st.state_id=pharma.state_id");

        if($city_search!='')

		{



			if(is_admin()){ 

				$this->db->where('pharma.city_id',$city_search);

			}

		}

           if(!is_admin()){  // this condition is not for admin user

        

         $where_b ='( '; 

//         $this->db->or_where('pharma.crm_user_id', logged_user_data());

          $where_b .=" pharma.crm_user_id = ".logged_user_data(). " AND ( ";

         if(!empty($boss_are)){

             $k=0;    

            foreach($boss_id as $value){

//          $this->db->or_where('pharma.city_id',$value);

                 if($k > 0 && count($boss_id)!=$k){

                   $where_b .= " OR ";

               }

                

                $where_b  .= " pharma.crm_user_id  != $value ";

               

                $k++;

            }

            

           

           }

         $where_b .=' ) ) ';

        if($city_search=='')

		{

			$this->db->or_where($where_b); 

		}

        

        if(!empty($cities_are)){

             $where='( '; 

                $k=0;    

            foreach($city_id as $value){

//          $this->db->or_where('pharma.city_id',$value);

                $where  .= " pharma.city_id = $value ";

                 $k++;

               if($k > 0 && count($city_id)!=$k){

                   $where .= " OR ";

               }

               

            }

             $where .=' )';

             $this->db->or_where($where);  // changes from where to or beacuase other city pharmacy added by user is not shown

        }

        

        

         if(!empty($pharma_are)){

             $where='( '; 

                $k=0;    

            foreach($pharma_id as $value){

//          $this->db->or_where('pharma.city_id',$value);

                $where  .= " pharma.pharma_id = '$value'";

                 $k++;

                

               if($k > 0 && count($pharma_id)!=$k){

                   $where .= " OR ";

               }

               

            }

             $where .=' )';

             $this->db->or_where($where);

        }



        }

        

        

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

 

    public function pharmacymaster_info($limit='',$start='',$data='',$city_search=''){

         

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

        

         $boss_are = logged_user_boss();

          $boss_id=explode(',', $boss_are);

          

          

          $pharma_are = logged_user_pharmaare();

          $pharma_id=explode(',', $pharma_are);

//         echo $pharma_are; die;

        

         $arr = "pharma.sp_code,pharma.pharma_id as id,pharma.d_id as dealers_id,pharma.company_name as com_name,pharma.company_email as com_email,pharma.company_phone as com_ph,pharma.pharmacy_status as status,pharma.blocked,pharma.city_pincode as city_pincode,pharma.city_id as city_id";
        $this->db->select($arr);
        $this->db->from("pharmacy_list pharma");
//        $this->db->join("srm_school_master sm" , "cl.s_id=sm.id");

//        $this->db->join("dealer d" , "d.dealer_id=doc.d_id");

       // $this->db->join("city c" , "c.city_id=pharma.city_id");

      //  $this->db->join("state st" , "st.state_id=pharma.state_id");



        if(!empty($data)){



         $this->db->like('pharma.company_name',$data);

         $this->db->or_like('c.city_name',$data);

         $this->db->or_like('st.state_name',$data);

         

        }

             if($city_search!='')

		{



			if(is_admin()){ 

				$this->db->where('pharma.city_id',$city_search);

			}

		}

        

        if(!is_admin()){  // this condition is not for admin user

        

         $where_b ='( '; 

//         $this->db->or_where('pharma.crm_user_id', logged_user_data());

          $where_b .=" pharma.crm_user_id = ".logged_user_data();

         if(!empty($boss_are)){
             $where_b .=" AND ( ";
             $k=0;    

            foreach($boss_id as $value){

//          $this->db->or_where('pharma.city_id',$value);

                 if($k > 0 && count($boss_id)!=$k){

                   $where_b .= " OR ";

               }

                $where_b  .= " pharma.crm_user_id  != $value ";

               

                $k++;

            }

            

           
             $where_b .=' ) ';
           }

         $where_b .='  ) ';

        if($city_search=='')

		{

			//$this->db->or_where($where_b); 

		}

        if(!empty($cities_are) && !empty($city_search)){

             $where='( '; 

                $k=0;    

            foreach($city_id as $value){

//          $this->db->or_where('pharma.city_id',$value);

                $where  .= " pharma.city_id = $value ";

                 $k++;

               if($k > 0 && count($city_id)!=$k){

                   $where .= " OR ";

               }

               

            }

             $where .=' )';

             $this->db->or_where($where);  // changes from where to or beacuase other city pharmacy added by user is not shown

        }

        

        

         if(!empty($pharma_are)){

             $where='( '; 

                $k=0;    

            foreach($pharma_id as $value){

//          $this->db->or_where('pharma.city_id',$value);

                $where  .= " pharma.pharma_id = '$value'";

                 $k++;

                

               if($k > 0 && count($pharma_id)!=$k){

                   $where .= " OR ";

               }

               

            }

             $where .=' )';

             $this->db->or_where($where);

        }



        }

        

        

         //$this->db->limit($limit, decode($start));

        

        

        $query = $this->db->get();

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows()){

            

            return json_encode($query->result_array());

        }

        else{

            

            return FALSE;

        }

    }

    

    public function edit_pharmacy($cm_id){

        

        $arr = "pharma.sp_code,pharma.doc_navigate_id as navigonid,pharma.city_pincode as city_pincode,pharma.pharma_id as id,pharma.d_id as dealers_id,pharma.company_name as com_name,pharma.company_email as com_email,pharma.company_phone as com_ph,pharma.company_address as address,pharma.owner_dob as dob,pharma.owner_name,pharma.owner_phone,pharma.owner_email,pharma.state_id,pharma.city_id,c.city_name,st.state_name";

        $this->db->select($arr);

        $this->db->from("pharmacy_list pharma");

//        $this->db->join("srm_school_master sm" , "cl.s_id=sm.id");

//        $this->db->join("school s" , "s.school_id=cl.s_id");

         $this->db->join("city c" , "c.city_id=pharma.city_id");

        $this->db->join("state st" , "st.state_id=pharma.state_id");

        $this->db->where("pharma.pharma_id",$cm_id);

        

        

          $query = $this->db->get();

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows()){

            

            return json_encode($query->row());

        }

        else{

            

            return FALSE;

        }

    }

    

    

    

    public function meeting_sample_master(){

        $arr="id,sample_name";

        $this->db->select($arr);

        $this->db->from('meeting_sample_master');

        $query= $this->db->get();

        

        if($this->db->affected_rows()){

            

            return json_encode($query->result_array());

        }

        else{

            

            return FALSE;

        }

        

    }

    

 // pharmacy id of logged user's child user 

    public function childs_pharmacy_data($loggeduser_id){

        

        $arr=" GROUP_CONCAT(ubr.user_id SEPARATOR ',') as childuserid, 

GROUP_CONCAT(ubr2.user_id SEPARATOR ',') as childuserid2, GROUP_CONCAT(ubr3.user_id SEPARATOR ',') as childuserid3 ,GROUP_CONCAT(ubr4.user_id SEPARATOR ',') as childuserid4,GROUP_CONCAT(ubr5.user_id SEPARATOR ',') as childuserid5, GROUP_CONCAT(upr.pharma_id SEPARATOR ',') as childpharmaid,GROUP_CONCAT(upr2.pharma_id SEPARATOR ',') as childpharmaid2, GROUP_CONCAT(upr3.pharma_id SEPARATOR ',') as childpharmaid3,GROUP_CONCAT(upr4.pharma_id SEPARATOR ',') as childpharmaid4,GROUP_CONCAT(upr5.pharma_id SEPARATOR ',') as childpharmaid5

 ";

       

        $this->db->select($arr);

        $this->db->from('user_bossuser_relation ubr ');

        $this->db->join('user_bossuser_relation ubr2 ','ubr.user_id=ubr2.boss_id','left');

        $this->db->join("user_bossuser_relation ubr3" , "ubr2.user_id=ubr3.boss_id",'left');

        $this->db->join("user_bossuser_relation ubr4" , "ubr3.user_id=ubr4.boss_id",'left');

        $this->db->join("user_bossuser_relation ubr5" , "ubr4.user_id=ubr5.boss_id",'left');

        

        $this->db->join("user_pharmacy_relation upr" , "upr.user_id=ubr.user_id",'left');

        $this->db->join("user_pharmacy_relation upr2" , "upr2.user_id=ubr2.user_id",'left');

        $this->db->join("user_pharmacy_relation upr3" , "upr3.user_id=ubr3.user_id",'left');

        $this->db->join("user_pharmacy_relation upr4" , "upr4.user_id=ubr4.user_id",'left');

        $this->db->join("user_pharmacy_relation upr5" , "upr5.user_id=ubr5.user_id",'left');

  

        $this->db->where('ubr.boss_id',$loggeduser_id);

        

        

        

        $query= $this->db->get();

//        echo $this->db->last_query(); die;

        if($this->db->affected_rows()){

            

            return json_encode($query->row());

        }

        else{

            

            return FALSE;

        }

            

        

    }

    

    

     // pharmacy data of childs user

    public function childs_pharmacy($limit,$start,$childuserid,$childpharmaid){

        

        $user_id = array_unique(explode(',', $childuserid),SORT_NATURAL);

        

        $pharma_id = array_unique(explode(',', $childpharmaid),SORT_NATURAL);

        

        

           $arr = "pharma.pharma_id as id,pharma.sp_code,pharma.d_id as dealers_id,pharma.company_name as com_name,pharma.company_email as com_email,pharma.company_phone as com_ph,pharma.pharmacy_status as status,pharma.blocked,pharma.city_pincode as city_pincode,pharma.city_id as city_id";

        $this->db->select($arr);

        $this->db->from("pharmacy_list pharma");


/*
        $this->db->join("city c" , "c.city_id=pharma.city_id");

        $this->db->join("state st" , "st.state_id=pharma.state_id");
*/


        if(isset($pharma_id)){

            foreach($pharma_id as $k_ph=>$val_ph){

            $this->db->or_where('pharma.pharma_id',trim($val_ph));

            }

        }

        

        if(isset($user_id)){

            foreach($user_id as $k_u=>$val_u){

            $this->db->or_where('pharma.crm_user_id',$val_u);

            }

        }

        

          $this->db->limit($limit, decode($start));

        



        $query = $this->db->get();

//      echo $this->db->last_query()."<br><br>"; 

         if($this->db->affected_rows()){

            

            return json_encode($query->result_array());

        }

        else{

            

            return FALSE;

        }

        

        

        

    }

    

    

    

     // total child record

    public function total_child_data($childuserid,$childpharmaid){

       

        

        $user_id = array_unique(explode(',', $childuserid),SORT_NATURAL);

        

        $pharma_id = array_unique(explode(',', $childpharmaid),SORT_NATURAL);

        

        

         $arr = "pharma.pharma_id as id";

        $this->db->select($arr);

        $this->db->from("pharmacy_list pharma");

   

//

//        $this->db->join("city c" , "c.city_id=doc.city_id");

//        $this->db->join("state st" , "st.state_id=doc.state_id");

//      

        if(isset($pharma_id)){

            foreach($pharma_id as $k_ph=>$val_ph){

            $this->db->or_where('pharma.pharma_id',trim($val_ph));

            }

        }

        

        if(isset($user_id)){

            foreach($user_id as $k_u=>$val_u){

            $this->db->or_where('pharma.crm_user_id',$val_u);

            }

        }

   

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

    

    

    

    // pharmacy interaction view

    public function pharmacy_interaction_view($id=''){

        

        if($id!=''){

        $arr = "d.dealer_name as deal_name,pip.id,pu.name as interactionBy,pip.meeting_sale , pip.meet_or_not_meet, pip.remark, pip.follow_up_action, pip.create_date as date_of_interaction ";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_pharmacy pip");

         $this->db->join("dealer d","d.dealer_id=pip.dealer_id","left");

//       

//        $this->db->join("pharmacy_interaction_sample_relation pi_sample","pi_sample.pipharma_id=pip.id","left");

//        $this->db->join("meeting_sample_master msm","msm.id=pi_sample.sample_id","left");

//        

        $this->db->join("pharma_users pu","pu.id=pip.crm_user_id","left");

        

        

        $this->db->where("pip.pharma_id",$id);

        

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

    

    

    //

    

    

     // inactive pharmacy

    public function inactive_pharmacymaster($id=''){

        

         $pharmacy_data= array(

             'crm_user_id'=> logged_user_data(),

             'last_update'=>savedate(),

             'pharmacy_status'=>0, 

        );

        

         $this->db->where('pharma_id',$id);

           $this->db->update('pharmacy_list',$pharmacy_data);

           

            if ($this->db->trans_status() === TRUE)

                           {

                              return true;



                           }

                           else{



                               return false;



                           }  

        

    }

    

    

     // active dealer

    public function active_pharmacymaster($id=''){

        

         $pharmacy_data= array(

             'crm_user_id'=> logged_user_data(),

             'last_update'=>savedate(),

             'pharmacy_status'=>1, 

        );

        

        $this->db->where('pharma_id',$id);

        $this->db->update('pharmacy_list',$pharmacy_data);

          

            if ($this->db->trans_status() === TRUE)

                           {

                              return true;



                           }

                           else{



                               return false;



                           }  

        

    }

    

    

      // Blocked pharmacy

    public function blocked_pharmacymaster($id=''){

        

         $pharmacy_data= array(

             'crm_user_id'=> logged_user_data(),

             'last_update'=>savedate(),

             'blocked'=>1, 

        );

        

          $this->db->where('pharma_id',$id);

        $this->db->update('pharmacy_list',$pharmacy_data);

         

            if ($this->db->trans_status() === TRUE)

                           {

                              return true;



                           }

                           else{



                               return false;



                           }  

        

    }

   

    

    

       // Remain pharmacy

    public function remain_pharmacymaster($id=''){

        

         $pharmacy_data= array(

             'crm_user_id'=> logged_user_data(),

             'last_update'=>savedate(),

             'blocked'=>0, 

        );

        

          $this->db->where('pharma_id',$id);

        $this->db->update('pharmacy_list',$pharmacy_data);

        

            if ($this->db->trans_status() === TRUE)

                           {

                              return true;



                           }

                           else{



                               return false;



                           }  

        

    }



    public function pharmacy_last_id(){

        $this->db->select_max('id');

		$query = $this->db->get('pharmacy_list');

		$row = $query->row_array();

		return $row['id'];

    }

	

	public function pharmacy_import_save($data){

		$this->db->select('*');

		$this->db->from('pharmacy_list');

		$this->db->where('company_phone',$data['company_phone']);

		$query = $this->db->get();

		if ($query->num_rows() == 0) {

		   $this->db->insert('pharmacy_list', $data);

			return TRUE;

		}

		else

		{

			return False;

		}

    }  

	

	public function get_pharmacy_data($id=''){

		$this->db->select('company_phone,company_email,company_name');

		$this->db->from('pharmacy_list');

		$this->db->where('pharma_id',$id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {

			return  $query->row();

		}

		else{

			return False;

		}

    }

    public function get_pharmacy_doc($id=''){
        $where="FIND_IN_SET('".$id."', d_id)";
        $this->db->select('doc_name,doctor_id');
        $this->db->from('doctor_list');
        $this->db->where($where);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return  $query->result_array();
        }
        else{
            return '';
        }
    }
}