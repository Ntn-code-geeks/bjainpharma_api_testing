<?php



/* 

 * Niraj Kumar

 * Dated: 30-oct-2017

 * 

 * model for user report card records 

 */



class Report_model extends CI_Model {


    public function sale_report_doctor($userid='',$start='',$end=''){
       

        $arr = "pid.doc_id, count(DISTINCT(pid.create_date)) total_visits,doc.doc_name as customer,c.city_name as city,pu.name as user,GROUP_CONCAT(msm.sample_name SEPARATOR ',')as sample";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_doctor pid");

        $this->db->join("doctor_list doc" , "doc.doctor_id=pid.doc_id");
   
        $this->db->join("pharma_users pu" , "pu.id=pid.crm_user_id");

        $this->db->join("doctor_interaction_sample_relation  disr" , "disr.pidoc_id=pid.id","Left");

        $this->db->join("meeting_sample_master  msm" , "msm.id=disr.sample_id","Left");

//       

        $this->db->join("city c" , "c.city_id=doc.city_id");

        $this->db->join("state st" , "st.state_id=doc.state_id");

        

//        $this->db->where('doc.doc_status',1);

        if($userid > 0){

            $this->db->where('pid.crm_user_id',$userid);

        }


        $this->db->where('pid.create_date >=', $start);

        $this->db->where('pid.create_date <=', $end);

        
        $this->db->group_by('pid.doc_id'); 

        

        $query = $this->db->get();

        

        $doc_sample_info = $query->result_array();

        

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows()){

            $doc_interaction = array();

             foreach ($doc_sample_info as $k=>$val){

                 

                 $arr = "`pid`.`doc_id`,count(DISTINCT(pid.create_date)) total_visits,SUM(pid.meeting_sale) as secondary_sale,(SELECT COUNT(pid.meet_or_not_meet) FROM `pharma_interaction_doctor` `pid` WHERE `pid`.`doc_id`='".$val['doc_id']."' AND pid.meet_or_not_meet=1 ) as met,(SELECT COUNT(pid.meet_or_not_meet) FROM `pharma_interaction_doctor` `pid` WHERE `pid`.`doc_id`= '".$val['doc_id']."' AND pid.meet_or_not_meet=0 ) as notmet ";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_doctor pid");

        

        $this->db->where('pid.doc_id',$val['doc_id']);

        

        $this->db->where('pid.crm_user_id',$userid);

        $this->db->where('pid.create_date >=', $start);

        $this->db->where('pid.create_date <=', $end);

        

        $this->db->group_by('pid.doc_id'); 

        

        $this->db->having('total_visits >=1 ');

        

        $query = $this->db->get();

//               echo $this->db->last_query(); die;

        $doc_interaction[] = $query->row_array();

                 

   }

             

           $result = array('doc_info'=>$doc_sample_info,'doc_interaction'=>$doc_interaction);  

//             pr($result); die;

             

            return $result;

        }

        else{

            

            return FALSE;

        }

    }

    

    

    // sale report for dealer

    public function sale_report_dealer($userid='',$start='',$end=''){

        

        $arr = "dl.gd_id as is_cf,`pi`.`d_id`, GROUP_CONCAT(msm.sample_name SEPARATOR ',')as sample, `dl`.`dealer_name` as `customer`, `c`.`city_name` as `city`, `pu`.`name` as `user`

,SUM(pi.meeting_sale) as sale,SUM(pi.meeting_payment)Payment";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_dealer pi");

        $this->db->join("dealer dl" , "dl.dealer_id=pi.d_id");

        

         $this->db->join("pharma_users pu" , "pu.id=pi.crm_user_id");

         $this->db->join("dealer_interaction_sample_relation  disr" , "disr.pidealer_id=pi.id","Left");

         $this->db->join("meeting_sample_master  msm" , "msm.id=disr.sample_id","Left");

//       

        $this->db->join("city c" , "c.city_id=dl.city_id");

        $this->db->join("state st" , "st.state_id=dl.state_id");

        

        $this->db->where('pi.crm_user_id',$userid);

        $this->db->where('pi.create_date >=', $start);

        $this->db->where('pi.create_date <=', $end);

//        $this->db->where('dl.doc_status',1);

        

        $this->db->group_by('pi.d_id'); 

        

        $query = $this->db->get();

        

        $dealer_sample_info = $query->result_array();

        

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows()){

            $dealer_interaction = array();

             foreach ($dealer_sample_info as $k=>$val){

                 

        $arr = "`pi`.`d_id`,count(DISTINCT(pi.create_date)) total_visits,(SELECT COUNT(pi.meet_or_not_meet) FROM `pharma_interaction_dealer` `pi` WHERE `pi`.`d_id`='".$val['d_id']."' AND pi.meet_or_not_meet=1 ) as met,(SELECT COUNT(pi.meet_or_not_meet) FROM `pharma_interaction_dealer` `pi` WHERE `pi`.`d_id`= '".$val['d_id']."' AND pi.meet_or_not_meet=0 ) as notmet ,(SELECT pi.meeting_stock FROM `pharma_interaction_dealer` `pi` WHERE `pi`.`d_id`= '".$val['d_id']."' AND pi.meeting_stock !='' order by pi.create_date desc limit 1 ) as stock,

(SELECT pi.create_date FROM `pharma_interaction_dealer` `pi` WHERE `pi`.`d_id`= '".$val['d_id']."' AND pi.meeting_stock !='' order by pi.create_date desc limit 1 ) as stock_date,(SELECT SUM(pid.meeting_sale) as duplicate_secondary FROM pharma_interaction_doctor pid  WHERE  `pid`.`dealer_id`='".$val['d_id']."') as duplicate_secondary";

        

        $this->db->select($arr);

        

        $this->db->from("pharma_interaction_dealer pi");

        

        $this->db->where('pi.d_id',$val['d_id']);

        

        $this->db->where('pi.crm_user_id',$userid);

        $this->db->where('pi.create_date >=', $start);

        $this->db->where('pi.create_date <=', $end);

        

        $this->db->group_by('pi.d_id'); 

        

        $this->db->having('total_visits >=1 ');

        

        $query = $this->db->get();

//               echo $this->db->last_query(); die;

        $dealer_interaction[] = $query->row_array();

                 

             }

             

           $result = array('dealer_info'=>$dealer_sample_info,'dealer_interaction'=>$dealer_interaction);  

//             pr($result); die;

             

            return $result;

        }

        else{

            

            return FALSE;

        } 

        

    }

    

    

     // sale report for Pharmacy

    public function sale_report_pharmacy($userid='',$start='',$end=''){

        

        $arr = "`pip`.`pharma_id`,`pl`.`company_name` as `customer`, `c`.`city_name` as `city`, `pu`.`name` as `user`

,GROUP_CONCAT(msm.sample_name SEPARATOR ',')as sample";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_pharmacy pip");

         $this->db->join("pharmacy_list pl","pl.pharma_id=pip.pharma_id");

       

         $this->db->join("pharma_users pu" , "pu.id=pip.crm_user_id");

         $this->db->join("pharmacy_interaction_sample_relation  pisr" , "pisr.pipharma_id=pip.id","Left");

         $this->db->join("meeting_sample_master  msm" , "msm.id=pisr.sample_id","Left");

//       

        $this->db->join("city c" , "c.city_id=pl.city_id");

        $this->db->join("state st" , "st.state_id=pl.state_id");

        

        $this->db->where('pip.crm_user_id',$userid);

        $this->db->where('pip.create_date >=', $start);

        $this->db->where('pip.create_date <=', $end);

//        $this->db->where('dl.doc_status',1);

        

        $this->db->group_by('pip.pharma_id'); 

        

        $query = $this->db->get();

        

        $pharmacy_sample_info = $query->result_array();

        

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows()){

            $pharmacy_interaction = array();

             foreach ($pharmacy_sample_info as $k=>$val){

                 

      /*  $arr = "`pip`.`pharma_id`,count(DISTINCT(pip.create_date)) total_visits,SUM(pip.meeting_sale) as secondary_sale,(SELECT COUNT(pip.meet_or_not_meet) FROM `pharma_interaction_pharmacy` `pip` WHERE `pip`.`pharma_id`='".$val['pharma_id']."' AND pip.meet_or_not_meet=1 ) as met,(SELECT COUNT(pip.meet_or_not_meet) FROM `pharma_interaction_pharmacy` `pip` WHERE `pip`.`pharma_id`= '".$val['pharma_id']."' AND pip.meet_or_not_meet=0 ) as notmet ,

(SELECT SUM(pid.meeting_sale) as duplicate_secondary FROM pharma_interaction_doctor pid WHERE `pid`.`dealer_id`='".$val['pharma_id']."') as duplicate_secondary";*/

        $arr = "`pip`.`pharma_id`,count(DISTINCT(pip.create_date)) total_visits,SUM(pip.meeting_sale) as secondary_sale,(SELECT COUNT(pip.meet_or_not_meet) FROM `pharma_interaction_pharmacy` `pip` WHERE `pip`.`pharma_id`='".$val['pharma_id']."' AND pip.meet_or_not_meet=1 ) as met,(SELECT COUNT(pip.meet_or_not_meet) FROM `pharma_interaction_pharmacy` `pip` WHERE `pip`.`pharma_id`= '".$val['pharma_id']."' AND pip.meet_or_not_meet=0 ) as notmet ,SUM(pip.duplicate_secondary) as duplicate_secondary,GROUP_CONCAT(pip.duplicate_product) as duplicate_product,GROUP_CONCAT(pip.doctor_id) as  dup_doctor_id";

        $this->db->select($arr);

        

        $this->db->from("pharma_interaction_pharmacy pip");

        

        $this->db->where('pip.pharma_id',$val['pharma_id']);

        

        $this->db->where('pip.crm_user_id',$userid);

        $this->db->where('pip.create_date >=', $start);

        $this->db->where('pip.create_date <=', $end);

        

        $this->db->group_by('pip.pharma_id'); 

        

        $this->db->having('total_visits >=1 ');

        

        $query = $this->db->get();

//               echo $this->db->last_query(); die;

        $pharmacy_interaction[] = $query->row_array();

                 

             }

             

           $result = array('pharmacy_info'=>$pharmacy_sample_info,'pharmacy_interaction'=>$pharmacy_interaction);  

          //pr($result); die;

             

            return $result;

        }

        else{

            

            return FALSE;

        } 

        

    }

    

    

    

    

    /*

     * @author: Niraj Kumar

     * Dated: 31-Oct-2017

     * 

     * Travel Report

     * 

     */

    

    public function total_doctor_interaction($userid='',$start='',$end=''){

        

        $arr = "pid.id,pid.remark,pid.orignal_sale as order_supply,pid.date_of_supply,`pid`.`meeting_sale` as `secondary_sale`, `pid`.`meet_or_not_meet` as `metnotmet`,pid.create_date as date,pid.doc_id,doc.doc_name as customer,c.city_name as city,pu.name as user,msm.sample_name as sample";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_doctor pid");

        $this->db->join("doctor_list doc" , "doc.doctor_id=pid.doc_id");

        

         $this->db->join("pharma_users pu" , "pu.id=pid.crm_user_id","Left");

         $this->db->join("doctor_interaction_sample_relation  disr" , "disr.pidoc_id=pid.id","Left");

         $this->db->join("meeting_sample_master  msm" , "msm.id=disr.sample_id","Left");

         

         

         $this->db->join("doctor_interaction_with_team  team" , "team.pidoc_id=pid.id","Left");

         $this->db->join("pharma_users pus" , "pus.id=team.team_id","Left");

//       

        $this->db->join("city c" , "c.city_id=doc.city_id");

        $this->db->join("state st" , "st.state_id=doc.state_id");

        

       $this->db->where('pid.status',1);

         

        if($userid > 0){

        //$this->db->where('team.team_id',$userid);
      //  (`team`.`team_id` = '92' OR `pid`.`crm_user_id` = '92')

        $this->db->where('(team.team_id='.$userid.' OR pid.crm_user_id='.$userid.') ');
        //$this->db->or_where('pid.crm_user_id',$userid);

        }

        $this->db->where('pid.create_date >=', $start);

        $this->db->where('pid.create_date <=', $end);
        

        

        $this->db->group_by('pid.id');

        $this->db->order_by('pid.doc_id','ASC'); 

        

        $query = $this->db->get();
      
         if($this->db->affected_rows()){

             

     $doc_travel_info = $query->num_rows();

//  pr($doc_travel_info); die;

            return $doc_travel_info;

        }

        else{

            

            return FALSE;

        } 

        

    }

    

    public  function total_dealer_interaction($userid='',$start='',$end=''){

        

        

        $arr = "pi.id,pi.remark,dl.gd_id as is_cf,pi.create_date as date,`pi`.`d_id`, `dl`.`dealer_name` as `customer`, `c`.`city_name` as `city`, `pu`.`name` as `user`,pi.meeting_sale as sale,pi.meeting_payment as payment,pi.meeting_stock as stock,pi.meet_or_not_meet as metnotmet ";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_dealer pi");

        $this->db->join("dealer dl" , "dl.dealer_id=pi.d_id");

        

        $this->db->join("pharma_users pu" , "pu.id=pi.crm_user_id","left");

         

        $this->db->join("dealer_interaction_with_team  team" , "team.pidealer_id=pi.id","left");

        $this->db->join("pharma_users pus" , "pus.id=team.team_id","left");

         

//         $this->db->join("doctor_interaction_sample_relation  disr" , "disr.pidoc_id=pid.id","Left");

//         $this->db->join("meeting_sample_master  msm" , "msm.id=disr.sample_id","Left");

//       

        $this->db->join("city c" , "c.city_id=dl.city_id");

        $this->db->join("state st" , "st.state_id=dl.state_id");

        

        $this->db->where('pi.status',1);

        if($userid > 0){

         

         

          $this->db->where('team.team_id',$userid);

          

           $this->db->or_where('pi.crm_user_id',$userid);

         

        }

         $this->db->where('pi.create_date >=', $start);

         $this->db->where('pi.create_date <=', $end);



        $this->db->group_by('pi.id');

         $this->db->order_by('dl.dealer_name','ASC'); 

         

        $query = $this->db->get();

        

        

        

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows()){

//         

           $dealer_travel_info = $query->num_rows();



           return $dealer_travel_info;

        }

        else{

            

            return FALSE;

        } 

        

    }



    

    public function total_pharmacy_interaction($userid='',$start='',$end=''){

        $arr = "pip.id, pip.remark,pip.orignal_sale as order_supply,pip.date_of_supply,`pip`.`pharma_id`, `pl`.`company_name` as `customer`, `c`.`city_name` as `city`, `pu`.`name` as `user`, msm.sample_name as sample ,`pip`.`meeting_sale` as `secondary_sale`, `pip`.`meet_or_not_meet` as `metnotmet`,pip.create_date as date ";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_pharmacy pip");

         $this->db->join("pharmacy_list pl","pl.pharma_id=pip.pharma_id");

       

         $this->db->join("pharma_users pu" , "pu.id=pip.crm_user_id","Left");

         $this->db->join("pharmacy_interaction_sample_relation  pisr" , "pisr.pipharma_id=pip.id","Left");

         $this->db->join("meeting_sample_master  msm" , "msm.id=pisr.sample_id","Left");

//       

         $this->db->join("pharmacy_interaction_with_team  team" , "team.pipharma_id=pip.id","Left");

         $this->db->join("pharma_users pus" , "pus.id=team.team_id","Left");

//     

         

        $this->db->join("city c" , "c.city_id=pl.city_id");

        $this->db->join("state st" , "st.state_id=pl.state_id");

        

        $this->db->where('pip.status',1);

        if($userid > 0){

         $this->db->where('team.team_id',$userid);

         $this->db->or_where('pip.crm_user_id',$userid);

        }

         $this->db->where('pip.create_date >=', $start);

         $this->db->where('pip.create_date <=', $end);

        

         $this->db->group_by('pip.id');

        

         $query = $this->db->get();

        

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows()){

             

            $pharmacy_travel_info = $query->num_rows();



            return $pharmacy_travel_info;

             

            return $result;

        }

        else{

            

            return FALSE;

        } 

        

    }



    public function travel_report_doctor($userid='',$start='',$end='',$page_limit='',$page_start=''){
        $arr = "pid.telephonic as oncall,pid.id,pid.remark,pid.orignal_sale as order_supply,pid.date_of_supply,`pid`.`meeting_sale` as `secondary_sale`, `pid`.`meet_or_not_meet` as `metnotmet`,pid.create_date as date,pid.doc_id,doc.doc_name as customer,c.city_name as city,pu.name as user,pid.dealer_id";
        $this->db->select($arr);
        $this->db->from("pharma_interaction_doctor pid");
        $this->db->join("doctor_list doc" , "doc.doctor_id=pid.doc_id");
        $this->db->join("pharma_users pu" , "pu.id=pid.crm_user_id","Left");
        // $this->db->join("doctor_interaction_sample_relation  disr" , "disr.pidoc_id=pid.id","Left");
        // $this->db->join("meeting_sample_master  msm" , "msm.id=disr.sample_id","Left");
        $this->db->join("doctor_interaction_with_team  team" , "team.pidoc_id=pid.id","Left");
        $this->db->join("pharma_users pus" , "pus.id=team.team_id","Left");
        $this->db->join("city c" , "c.city_id=doc.city_id");
        $this->db->join("state st" , "st.state_id=doc.state_id");
        $this->db->where('pid.status',1);
        if($userid > 0){
            //$this->db->where('team.team_id',$userid);
            //(`team`.`team_id` = '92' OR `pid`.`crm_user_id` = '92')
            $this->db->where('(team.team_id='.$userid.' OR pid.crm_user_id='.$userid.') ');
            //$this->db->or_where('pid.crm_user_id',$userid);
        }
        $this->db->where('pid.create_date >=', $start);
        $this->db->where('pid.create_date <=', $end);
        /* if($page_limit!=''){
         $this->db->limit($page_limit, decode($page_start));
        } */
        $this->db->group_by('pid.id');
        $this->db->order_by('pid.doc_id','ASC'); 
        $query = $this->db->get();
        $doc_travel_info = $query->result_array();
       
        

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows()){

             

//             pr($doc_travel_info); die;

              $team_interaction = array();

             foreach ($doc_travel_info as $k=>$val){

              

                 $arr = "GROUP_CONCAT(msm.sample_name SEPARATOR ',') as `sample`";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_doctor pid");

          $this->db->join("doctor_interaction_sample_relation  disr" , "disr.pidoc_id=pid.id","Left");

         $this->db->join("meeting_sample_master  msm" , "msm.id=disr.sample_id","Left");

        

        

        $this->db->where('disr.pidoc_id',$val['id']);

        

        $this->db->group_by('pid.doc_id'); 

        

       

        $query = $this->db->get();

//               echo $this->db->last_query(); die;

        $doc_travel_info[$k]['sample'] = $query->row_array();

                 

                 

                 

        $arr = "pid.doc_id,GROUP_CONCAT(`pus`.`name` SEPARATOR ',') as `team_user`,team.team_id,team.crm_user_id,pid.crm_user_id as userid";

        

        $this->db->select($arr);

        

        $this->db->from("pharma_interaction_doctor pid");

        

        $this->db->join("doctor_interaction_with_team  team" , "team.pidoc_id=pid.id");

        $this->db->join("pharma_users pus" , "pus.id=team.team_id");

        

        $this->db->where('team.pidoc_id',$val['id']);

        

//        if($userid > 0){

//        $this->db->where('team.team_id',$userid);

//         }

        

        $this->db->where('pid.create_date >=', $start);

        $this->db->where('pid.create_date <=', $end);

        

        $this->db->group_by('team.pidoc_id'); 

        

//        $this->db->having('total_visits >=1 ');

        

        $query = $this->db->get();

//               echo $this->db->last_query(); die;

        $team_interaction[] = $query->row_array();

                 

             }

//             pr($team_interaction); die;

             

             

           $result = array('doc_info'=>$doc_travel_info,'team_info'=>$team_interaction);  

//             pr($result); die;

             

            return $result;

        }

        else{

            

            return FALSE;

        } 

        

    }

    

    

    

    

     // Travel report for dealer

    public function travel_report_dealer($userid='',$start='',$end='',$page_limit='',$page_start=''){

        

        $arr = "pi.telephonic as oncall,pi.id,pi.remark,dl.gd_id as is_cf,pi.create_date as date,`pi`.`d_id`, `dl`.`dealer_name` as `customer`, `c`.`city_name` as `city`, `pu`.`name` as `user`,pi.meeting_sale as sale,pi.meeting_payment as payment,pi.meeting_stock as stock,pi.meet_or_not_meet as metnotmet ";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_dealer pi");

        $this->db->join("dealer dl" , "dl.dealer_id=pi.d_id");

        

        $this->db->join("pharma_users pu" , "pu.id=pi.crm_user_id","left");

         

        $this->db->join("dealer_interaction_with_team  team" , "team.pidealer_id=pi.id","left");

        $this->db->join("pharma_users pus" , "pus.id=team.team_id","left");

         

//         $this->db->join("doctor_interaction_sample_relation  disr" , "disr.pidoc_id=pid.id","Left");

//         $this->db->join("meeting_sample_master  msm" , "msm.id=disr.sample_id","Left");



        

        $this->db->join("city c" , "c.city_id=dl.city_id");

        $this->db->join("state st" , "st.state_id=dl.state_id");

        

        $this->db->where('pi.status',1);

        if($userid > 0){
            $this->db->where('(team.team_id='.$userid.' OR pi.crm_user_id='.$userid.') ');
        }

         $this->db->where('pi.create_date >=', $start);

         $this->db->where('pi.create_date <=', $end);



         /* if($page_limit!=''){

         $this->db->limit($page_limit, decode($page_start));

        } */

         

        $this->db->group_by('pi.id');

         $this->db->order_by('dl.dealer_name','ASC'); 

         

        $query = $this->db->get();

        

        $dealer_travel_info = $query->result_array();

        

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows()){

//             pr($dealer_travel_info); die;   

              $team_interaction = array();

             foreach ($dealer_travel_info as $k=>$val){

                 

        $arr = "GROUP_CONCAT(msm.sample_name SEPARATOR ',') as `sample`";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_dealer pi");

          $this->db->join("dealer_interaction_sample_relation  disr" , "disr.pidealer_id=pi.id","Left");

         $this->db->join("meeting_sample_master  msm" , "msm.id=disr.sample_id","Left");

        

        

        $this->db->where('disr.pidealer_id',$val['id']);

        

        $this->db->group_by('pi.id'); 

        

       

        $query = $this->db->get();

//               echo $this->db->last_query(); die;

        $dealer_travel_info[$k]['sample'] = $query->row_array();

                 

                 

                 

                 

        $arr = "pi.d_id,GROUP_CONCAT(`pus`.`name` SEPARATOR ',') as `team_user`";

        

        $this->db->select($arr);

        

        $this->db->from("pharma_interaction_dealer pi");

        

        $this->db->join("dealer_interaction_with_team  team" , "team.pidealer_id=pi.id");

        $this->db->join("pharma_users pus" , "pus.id=team.team_id");

        

        $this->db->where('team.pidealer_id',$val['id']);

        

//        if($userid > 0){

//        $this->db->where('team.team_id',$userid);

//         }

        

         $this->db->where('pi.create_date >=', $start);

         $this->db->where('pi.create_date <=', $end);

        

        $this->db->group_by('team.pidealer_id'); 

        

//        $this->db->having('total_visits >=1 ');

        

        $query = $this->db->get();

//               echo $this->db->last_query(); die;

        $team_interaction[] = $query->row_array();

                 

             }

             

//            pr($team_interaction);  die;

             

             

           $result = array('dealer_info'=>$dealer_travel_info,'team_info'=>$team_interaction);  

//             pr($result); die;

             

            return $result;

        }

        else{

            

            return FALSE;

        } 

        

    }  

    // Travel report for Pharmacy

    public function travel_report_pharmacy($userid='',$start='',$end='',$page_limit='',$page_start=''){

        $arr = "pip.telephonic as oncall,pip.id, pip.remark,pip.orignal_sale as order_supply,pip.date_of_supply,`pip`.`pharma_id`, `pl`.`company_name` as `customer`, `c`.`city_name` as `city`, `pu`.`name` as `user`,`pip`.`meeting_sale` as `secondary_sale`, `pip`.`meet_or_not_meet` as `metnotmet`,pip.create_date as date,pip.dealer_id ";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_pharmacy pip");
        $this->db->join("pharmacy_list pl","pl.pharma_id=pip.pharma_id");
        $this->db->join("pharma_users pu" , "pu.id=pip.crm_user_id","Left");
        //$this->db->join("pharmacy_interaction_sample_relation  pisr" , "pisr.pipharma_id=pip.id","Left");
        //$this->db->join("meeting_sample_master  msm" , "msm.id=pisr.sample_id","Left");
        $this->db->join("pharmacy_interaction_with_team  team" , "team.pipharma_id=pip.id","Left");
        $this->db->join("pharma_users pus" , "pus.id=team.team_id","Left");
        $this->db->join("city c" , "c.city_id=pl.city_id");
        $this->db->join("state st" , "st.state_id=pl.state_id");
        $this->db->where('pip.status',1);
        if($userid > 0){
            $this->db->where('(team.team_id='.$userid.' OR pip.crm_user_id='.$userid.') ');
        }
        $this->db->where('pip.create_date >=', $start);
        $this->db->where('pip.create_date <=', $end);
        /*  if($page_limit!=''){
        $this->db->limit($page_limit, decode($page_start));
        } */
        $this->db->group_by('pip.id');

        

         $query = $this->db->get();

        

        $pharmacy_travel_info = $query->result_array();

        

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows()){

            

             

               $team_interaction = array();

             foreach ($pharmacy_travel_info as $k=>$val){

                 

                  $arr = "GROUP_CONCAT(msm.sample_name SEPARATOR ',') as `sample`";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_pharmacy pip");

          $this->db->join("pharmacy_interaction_sample_relation  pisr" , "pisr.pipharma_id=pip.id","Left");

         $this->db->join("meeting_sample_master  msm" , "msm.id=pisr.sample_id","Left");

        

        

        $this->db->where('pisr.pipharma_id',$val['id']);

        

        $this->db->group_by('pip.id'); 

        

       

        $query = $this->db->get();

//               echo $this->db->last_query(); die;

        $pharmacy_travel_info[$k]['sample'] = $query->row_array();

              

                 

                 

                 

        $arr = "pip.pharma_id,GROUP_CONCAT(`pus`.`name` SEPARATOR ',') as `team_user`";

        

        $this->db->select($arr);

        

        $this->db->from("pharma_interaction_pharmacy pip");

        

         $this->db->join("pharmacy_interaction_with_team  team" , "team.pipharma_id=pip.id");

         $this->db->join("pharma_users pus" , "pus.id=team.team_id");

        

        $this->db->where('team.pipharma_id',$val['id']);

        

//        if($userid > 0){

//        $this->db->where('team.team_id',$userid);

//         }

        

         $this->db->where('pip.create_date >=', $start);

         $this->db->where('pip.create_date <=', $end);

        

        $this->db->group_by('team.pipharma_id'); 

        

//        $this->db->having('total_visits >=1 ');

        

        $query = $this->db->get();

//               echo $this->db->last_query(); die;

        $team_interaction[] = $query->row_array();

                 

             }

             

             

           $result = array('pharmacy_info'=>$pharmacy_travel_info,'team_info'=>$team_interaction);  

//             pr($result); die;

             

            return $result;

        }

        else{

            

            return FALSE;

        } 
    }


/*

* @author: Niraj Kumar

* Dated: 31-Oct-2017

* 

* Relationship Reports

* 

*/


    public function relationship_report_pharmacy($pharma_id='',$start='',$end=''){
        //$pharma_name = "pharmacy1";
        $arr = " `pip`.`pharma_id`, `pl`.`company_name` as `customer`, `c`.`city_name` as `city`, `pu`.`name` as `user`,  `pip`.`meeting_sale` as `secondary_sale`, `pip`.`create_date` as `date`,`pip`.`crm_user_id` as `user_id`";
        $this->db->select($arr);
        $this->db->from("pharma_interaction_pharmacy pip");
        $this->db->join("pharmacy_list pl","pl.pharma_id=pip.pharma_id");
        $this->db->join("pharma_users pu" , "pu.id=pip.crm_user_id");
        //$this->db->join("pharmacy_interaction_sample_relation  pisr" , "pisr.pipharma_id=pip.id","Left");
        //$this->db->join("meeting_sample_master  msm" , "msm.id=pisr.sample_id","Left");
        //       
        $this->db->join("city c" , "c.city_id=pl.city_id");
        $this->db->join("state st" , "st.state_id=pl.state_id");
        $this->db->where('pip.pharma_id',$pharma_id);
        $this->db->where('pip.create_date >=', $start);
        $this->db->where('pip.create_date <=', $end);
        //$this->db->where('dl.doc_status',1);
        //$this->db->group_by('pip.pharma_id'); 
        $query = $this->db->get();
        $pharmacy_rr_info = $query->result_array();
       // echo '<br>'.$this->db->last_query();
        /*if($this->db->affected_rows()){*/
            $pharma_doc_relationship = array();
            $arr = "`pid`.`doc_id`, `doc`.`doc_name` as `customer`, `c`.`city_name` as `city`, `pu`.`name` as `user` ,pid.meeting_sale as secondary_sale, pid.create_date as date ,`pid`.`crm_user_id` as `user_id`";
            $this->db->select($arr);
            $this->db->from("pharma_interaction_doctor pid");
            $this->db->join("doctor_list doc" , "doc.doctor_id=pid.doc_id");
            $this->db->join("pharma_users pu" , "pu.id=pid.crm_user_id");
            $this->db->join("pharmacy_list pl","pl.pharma_id=pid.dealer_id");
            $this->db->join("city c" , "c.city_id=doc.city_id");
            $this->db->join("state st" , "st.state_id=doc.state_id");
            $this->db->where('doc.doc_status',1);
            $this->db->where('pid.dealer_id',$pharma_id);
            $this->db->where('pid.create_date >=', $start);
            $this->db->where('pid.create_date <=', $end);
            //$this->db->group_by('pid.doc_id'); 
            $query = $this->db->get();
            //echo '<br>'.$this->db->last_query(); die;
            $pharma_doc_relationship = $query->result_array();
            $result = array('pharmacy_info'=>$pharmacy_rr_info,'pharma_doc_relation'=>$pharma_doc_relationship);  
            //pr($result); die;
            return $result;
        /*}
        else{
            return FALSE;
        }*/ 
    }

    

    

     public function relationship_report_dealer($dealer_id='',$start='',$end=''){

         

//         $dealer_id = "1";

        

        $arr = " dl.gd_id as is_cf,`pi`.`d_id`, `dl`.`dealer_name` as `customer`, `c`.`city_name` as `city`, `pu`.`name` as `user`, `pi`.`meeting_sale` as `sale`, `pi`.`create_date` as `date` ,pi.meeting_payment as payment, pi.meeting_stock as stock,`pi`.`crm_user_id` as `user_id` ";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_dealer pi");

        $this->db->join("dealer dl","dl.dealer_id=pi.d_id");

       

         $this->db->join("pharma_users pu" , "pu.id=pi.crm_user_id");

//         $this->db->join("pharmacy_interaction_sample_relation  pisr" , "pisr.pipharma_id=pip.id","Left");

//         $this->db->join("meeting_sample_master  msm" , "msm.id=pisr.sample_id","Left");

//       

        $this->db->join("city c" , "c.city_id=dl.city_id");

        $this->db->join("state st" , "st.state_id=dl.state_id");

        

          $this->db->where('pi.d_id',$dealer_id);

        

        $this->db->where('pi.create_date >=', $start);

        $this->db->where('pi.create_date <=', $end);

//         $this->db->where('dates >=',$start_date);

//            $this->db->where('dates <=',$end_date);

//        $this->db->group_by('pip.pharma_id'); 

        

        $query = $this->db->get();

        

        $dealer_rr_info = $query->result_array();

        

//        echo $this->db->last_query(); die;

//         if($this->db->affected_rows()){

            

                $dealer_doc_relationship = array();

             

          $arr = "`pid`.`doc_id`, `doc`.`doc_name` as `customer`, `c`.`city_name` as `city`, `pu`.`name` as `user` ,pid.meeting_sale as secondary_sale, pid.create_date as date,`pid`.`crm_user_id` as `user_id` ";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_doctor pid");

        $this->db->join("doctor_list doc" , "doc.doctor_id=pid.doc_id");

        $this->db->join("dealer dl","dl.dealer_id=pid.dealer_id");

        

        $this->db->join("pharma_users pu" , "pu.id=pid.crm_user_id");

                

        $this->db->join("city c" , "c.city_id=doc.city_id");

        $this->db->join("state st" , "st.state_id=doc.state_id");

        

        $this->db->where('doc.doc_status',1);

        $this->db->where('dl.dealer_id',$dealer_id);

        

          $this->db->where('pid.create_date >=',$start );

        $this->db->where('pid.create_date <=', $end);

        

        

        $query = $this->db->get();

//               echo $this->db->last_query(); die;

        $dealer_doc_relationship = $query->result_array();

              

        

        $dealer_pharma_relationship = array();

             

          $arr = "`pip`.`pharma_id`, `pl`.`company_name` as `customer`, `c`.`city_name` as `city`, `pu`.`name` as `user` ,pip.meeting_sale as secondary_sale, pip.create_date as date ,`pip`.`crm_user_id` as `user_id`";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_pharmacy pip");

        $this->db->join("pharmacy_list pl" , "pl.pharma_id=pip.pharma_id");

        $this->db->join("dealer dl","dl.dealer_id=pip.dealer_id");

        

        $this->db->join("pharma_users pu" , "pu.id=pip.crm_user_id");

                

        $this->db->join("city c" , "c.city_id=pl.city_id");

        $this->db->join("state st" , "st.state_id=pl.state_id");

        

//        $this->db->where('doc.doc_status',1);

        $this->db->where('dl.dealer_id',$dealer_id);

        $this->db->where('pip.create_date >=', $start);

        $this->db->where('pip.create_date <=', $end);

        

        $query = $this->db->get();

//               echo $this->db->last_query(); die;

        $dealer_pharma_relationship = $query->result_array();

        

            

         if(!empty($dealer_rr_info) || !empty($dealer_doc_relationship) || !empty($dealer_pharma_relationship) ){    

             

           $result = array('dealer_info'=>$dealer_rr_info,'dealer_doc_relation'=>$dealer_doc_relationship,'dealer_pharma_relation'=>$dealer_pharma_relationship);  

//             pr($result); die;

             

            return $result;

        }

        else{

            

            return FALSE;

        } 

        

    }

    

    

    

    // list of dealer

    public function dealer_list(){  // used to show list of dealer in doctor section

//         $cities_are = logged_user_cities();

//         $city_id=explode(',', $cities_are);
        
        

        $arr ="d.dealer_id,d.dealer_name,c.city_name";

        $this->db->select($arr);

        $this->db->from('dealer d');

      

        $this->db->join("city c" , "c.city_id=d.city_id");

        

        $this->db->where('d.status',1);

     

        

        $query= $this->db->get();

//        echo $this->db->last_query(); die; 

        if($this->db->affected_rows()){

            

            return json_encode($query->result_array());

        }

        else{

            

            return FALSE;

        }

   

        

    }

    

    

    //

     public function pharmacy_list(){

        

         $arr = "pharma_id as id,company_name as com_name";

        $this->db->select($arr);

        $this->db->from("pharmacy_list");

         $this->db->where("pharmacy_status",1);     

        $query = $this->db->get();

//         echo $this->db->last_query(); die;

        if($this->db->affected_rows()){

            

            return json_encode($query->result_array());

        }

        else{

            

            return FALSE;

        }

        

    }

    

    

    

    // edit doc interaction info

    public function edit_doc_interaction($id=''){

        

       $arr = "pid.follow_up_action as fup_a,pid.dealer_id,pid.id,pid.remark,pid.orignal_sale as order_supply,pid.date_of_supply,`pid`.`meeting_sale` as `secondary_sale`, `pid`.`meet_or_not_meet` as `metnotmet`,pid.create_date as date,pid.doc_id,doc.doc_name as customer,c.city_name as city,pu.name as user";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_doctor pid");

        $this->db->join("doctor_list doc" , "doc.doctor_id=pid.doc_id");

        

         $this->db->join("pharma_users pu" , "pu.id=pid.crm_user_id","Left");

//         $this->db->join("doctor_interaction_sample_relation  disr" , "disr.pidoc_id=pid.id","Left");

//         $this->db->join("meeting_sample_master  msm" , "msm.id=disr.sample_id","Left");

         

         

         $this->db->join("doctor_interaction_with_team  team" , "team.pidoc_id=pid.id","Left");

         $this->db->join("pharma_users pus" , "pus.id=team.team_id","Left");

//       

        $this->db->join("city c" , "c.city_id=doc.city_id");

        $this->db->join("state st" , "st.state_id=doc.state_id");

        

        $this->db->where('pid.id',$id);

         $this->db->group_by('pid.doc_id'); 

       

        $query = $this->db->get();

        

        $doc_travel_info = $query->result_array();

        

        

     

                 

         $arr = "GROUP_CONCAT(msm.sample_name SEPARATOR ',') as `sample`,GROUP_CONCAT(msm.id SEPARATOR ',') as `sample_id`";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_doctor pid");

          $this->db->join("doctor_interaction_sample_relation  disr" , "disr.pidoc_id=pid.id","Left");

         $this->db->join("meeting_sample_master  msm" , "msm.id=disr.sample_id","Left");

        

        

        $this->db->where('pid.id',$id);

        

        $this->db->group_by('pid.doc_id'); 

        

       

        $query = $this->db->get();

//               echo $this->db->last_query(); die;

        $doc_travel_info[0]['sample'] = $query->row_array();

                 

         

        

       

        

        

        

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows()){

             

//             pr($doc_travel_info); die;

              $team_interaction = array();

             foreach ($doc_travel_info as $k=>$val){

                 

        $arr = "pid.doc_id,GROUP_CONCAT(`pus`.`name` SEPARATOR ',') as `team_user`,team.team_id,team.crm_user_id,pid.crm_user_id as userid";

        

        $this->db->select($arr);

        

        $this->db->from("pharma_interaction_doctor pid");

        

        $this->db->join("doctor_interaction_with_team  team" , "team.pidoc_id=pid.id");

        $this->db->join("pharma_users pus" , "pus.id=team.team_id");

        

        $this->db->where('team.pidoc_id',$val['id']);

    

        $this->db->group_by('team.pidoc_id'); 

        

//        $this->db->having('total_visits >=1 ');

        

        $query = $this->db->get();

//               echo $this->db->last_query(); die;

        $team_interaction[] = $query->row_array();

                 

             }

//             pr($team_interaction); die;

             

             

           $result = array('doc_info'=>$doc_travel_info,'team_info'=>$team_interaction);  

//             pr($result); die;

             

            return $result;

        }

        else{

            

            return FALSE;

        }  

        

        

    }

    

    

    // edit pharmacy interaction info

    public function edit_pharma_interaction($id=''){

        

       $arr = "pip.follow_up_action as fup_a,pip.dealer_id,pip.id, pip.remark,pip.orignal_sale as order_supply,pip.date_of_supply,`pip`.`pharma_id`, `pl`.`company_name` as `customer`, `c`.`city_name` as `city`, `pu`.`name` as `user`, `pip`.`meeting_sale` as `secondary_sale`, `pip`.`meet_or_not_meet` as `metnotmet`,pip.create_date as date ";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_pharmacy pip");

         $this->db->join("pharmacy_list pl","pl.pharma_id=pip.pharma_id");

       

         $this->db->join("pharma_users pu" , "pu.id=pip.crm_user_id","Left");

//         $this->db->join("pharmacy_interaction_sample_relation  pisr" , "pisr.pipharma_id=pip.id","Left");

//         $this->db->join("meeting_sample_master  msm" , "msm.id=pisr.sample_id","Left");

//       

         $this->db->join("pharmacy_interaction_with_team  team" , "team.pipharma_id=pip.id","Left");

         $this->db->join("pharma_users pus" , "pus.id=team.team_id","Left");

//     

         

        $this->db->join("city c" , "c.city_id=pl.city_id");

        $this->db->join("state st" , "st.state_id=pl.state_id");

        

        $this->db->where('pip.id',$id);

         $this->db->group_by('pip.id');

        

         $query = $this->db->get();

        

        $pharmacy_travel_info = $query->result_array();

        

        

         $arr = "GROUP_CONCAT(msm.sample_name SEPARATOR ',') as `sample`,GROUP_CONCAT(msm.id SEPARATOR ',') as `sample_id`";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_pharmacy pip");

          $this->db->join("pharmacy_interaction_sample_relation  pisr" , "pisr.pipharma_id=pip.id","Left");

         $this->db->join("meeting_sample_master  msm" , "msm.id=pisr.sample_id","Left");

        

        

        $this->db->where('pip.id',$id);

        

        $this->db->group_by('pip.id'); 

        

       

        $query = $this->db->get();

//               echo $this->db->last_query(); die;

        $pharmacy_travel_info[0]['sample'] = $query->row_array();

                 

         

        

        

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows()){

            

             

               $team_interaction = array();

             foreach ($pharmacy_travel_info as $k=>$val){

                 

        $arr = "pip.pharma_id,GROUP_CONCAT(`pus`.`name` SEPARATOR ',') as `team_user`";

        

        $this->db->select($arr);

        

        $this->db->from("pharma_interaction_pharmacy pip");

        

         $this->db->join("pharmacy_interaction_with_team  team" , "team.pipharma_id=pip.id");

         $this->db->join("pharma_users pus" , "pus.id=team.team_id");

        

        $this->db->where('team.pipharma_id',$val['id']);

        

        $this->db->group_by('team.pipharma_id'); 

        

        

        $query = $this->db->get();

//               echo $this->db->last_query(); die;

        $team_interaction[] = $query->row_array();

                 

             }

             

             

           $result = array('pharmacy_info'=>$pharmacy_travel_info,'team_info'=>$team_interaction);  

//             pr($result); die;

             

            return $result;

        }

        else{

            

            return FALSE;

        }  

        

    }

    

    

    // edit Dealer Interaction info

    public function edit_dealer_interaction($id=''){

        

         $arr = "pi.follow_up_action as fup_a,pi.id,pi.remark,dl.gd_id as is_cf,pi.create_date as date,`pi`.`d_id`, `dl`.`dealer_name` as `customer`, `c`.`city_name` as `city`, `pu`.`name` as `user`,pi.meeting_sale as sale,pi.meeting_payment as payment,pi.meeting_stock as stock,pi.meet_or_not_meet as metnotmet ";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_dealer pi");

        $this->db->join("dealer dl" , "dl.dealer_id=pi.d_id");

        

        $this->db->join("pharma_users pu" , "pu.id=pi.crm_user_id","left");

         

        $this->db->join("dealer_interaction_with_team  team" , "team.pidealer_id=pi.id","left");

        $this->db->join("pharma_users pus" , "pus.id=team.team_id","left");

         

//         $this->db->join("doctor_interaction_sample_relation  disr" , "disr.pidoc_id=pid.id","Left");

//         $this->db->join("meeting_sample_master  msm" , "msm.id=disr.sample_id","Left");

//       

        $this->db->join("city c" , "c.city_id=dl.city_id");

        $this->db->join("state st" , "st.state_id=dl.state_id");

        

         $this->db->where('pi.id',$id);

         

        $this->db->group_by('pi.id');

         

        $query = $this->db->get();

        

        $dealer_travel_info = $query->result_array();

        

        

                

         $arr = "GROUP_CONCAT(msm.sample_name SEPARATOR ',') as `sample`,GROUP_CONCAT(msm.id SEPARATOR ',') as `sample_id`";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_dealer pi");

          $this->db->join("dealer_interaction_sample_relation  disr" , "disr.pidealer_id=pi.id","Left");

         $this->db->join("meeting_sample_master  msm" , "msm.id=disr.sample_id","Left");

        

        

        $this->db->where('pi.id',$id);

        

        $this->db->group_by('pi.id'); 

        

       

        $query = $this->db->get();

//               echo $this->db->last_query(); die;

        $dealer_travel_info[0]['sample'] = $query->row_array();

                 

         

        

        

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows()){

//             pr($dealer_travel_info); die;   

              $team_interaction = array();

             foreach ($dealer_travel_info as $k=>$val){

                 

        $arr = "pi.d_id,GROUP_CONCAT(`pus`.`name` SEPARATOR ',') as `team_user`";

        

        $this->db->select($arr);

        

        $this->db->from("pharma_interaction_dealer pi");

        

        $this->db->join("dealer_interaction_with_team  team" , "team.pidealer_id=pi.id");

        $this->db->join("pharma_users pus" , "pus.id=team.team_id");

        

        $this->db->where('team.pidealer_id',$val['id']);



        $this->db->group_by('team.pidealer_id'); 

        

//        $this->db->having('total_visits >=1 ');

        

        $query = $this->db->get();

//               echo $this->db->last_query(); die;

        $team_interaction[] = $query->row_array();

                 

             }

             

//            pr($team_interaction);  die;

             

             

           $result = array('dealer_info'=>$dealer_travel_info,'team_info'=>$team_interaction);  

//             pr($result); die;

             

            return $result;

        }

        else{

            

            return FALSE;

        } 

        

    }

	

	

	/* Total Doctor */

	

	public function all_user_doctor($userId){

		$desig_id='';

		$cities_are='';

		$boss_are='';

		$doc_are='';

		$userData='';

		$arr ="pu.switchStatus,pu.id,pu.email_id,pu.password,pu.name,pu.user_city_id as city_id,pu.user_designation_id as desig_id,(SELECT GROUP_CONCAT(`pharma_id` separator ', ') as pharma_id FROM `user_pharmacy_relation` `upr` WHERE `pu`.`id`=`upr`.`user_id`) as pharma_id,(SELECT GROUP_CONCAT(ubr.`boss_id` separator ', ') as boss_id FROM `user_bossuser_relation` `ubr` WHERE `pu`.`id`=`ubr`.`user_id`) as boss_ids ,(SELECT GROUP_CONCAT(udr.`doc_id` separator ', ') as doctor_id FROM `user_doctor_relation` `udr` WHERE `pu`.`id`=`udr`.`user_id`) as doctor_id ,"

                . "(SELECT GROUP_CONCAT(ubr.`user_id` separator ', ') as boss_id FROM `user_bossuser_relation` `ubr` WHERE `pu`.`id`=`ubr`.`boss_id`) as child_ids ";

        $this->db->select($arr);

        $this->db->from('pharma_users pu');

        $this->db->where('pu.id',$userId);

        $this->db->where('pu.user_status',1);

		$query= $this->db->get();

        if($this->db->affected_rows()){

            

            $userData=$query->row();

			

        }

		

         $desig_id=$userData->desig_id;

        

        $cities_are = $userData->city_id;

        $city_id=explode(',', $cities_are);

        

         $boss_are =$userData->boss_ids;

         $boss_id=explode(',', $boss_are);

        

        $doc_are = $userData->doctor_id;

          $doc_id=explode(',', $doc_are);

          

          

         $arr = "doc.doctor_id as id,doc.d_id as dealers_id,doc.doc_name as d_name,doc.doc_email as d_email,doc.doc_phone as d_ph,c.city_name as c_city,doc.doc_status as status,doc.blocked";

        $this->db->select($arr);

        $this->db->from("doctor_list doc");

//        $this->db->join("srm_school_master sm" , "cl.s_id=sm.id");

//        $this->db->join("dealer d" , "d.dealer_id=doc.d_id");

        $this->db->join("city c" , "c.city_id=doc.city_id");

        $this->db->join("state st" , "st.state_id=doc.state_id");

        

        $where_b ='( '; 

//         $this->db->or_where('pharma.crm_user_id', logged_user_data());

          $where_b .=" doc.crm_user_id = ".logged_user_data() ;

         if(!empty($boss_are))
         {
             $where_b .=" AND ( " ;
             $k=0;    

            foreach($boss_id as $value){

//          $this->db->or_where('pharma.city_id',$value);

                

                 if($k > 0 && count($boss_id)!=$k){

                   $where_b .= " OR ";

               }

                $where_b  .= " doc.crm_user_id  != $value ";
                $k++;

            }

            $where_b .=' )  ';

           }

         $where_b .=' ) ';

             $this->db->or_where($where_b); 

        

        if(!empty($cities_are)){

             $where='( '; 

                $k=0;    

            foreach($city_id as $value){

//          $this->db->or_where('pharma.city_id',$value);

                $where  .= " doc.city_id = $value ";

                 $k++;

               if($k > 0 && count($city_id)!=$k){

                   $where .= " OR ";

               }

               

            }

             $where .=' )';

             $this->db->or_where($where); // changes from where to or beacuase other city doctor added by user is not shown

        }

        

        

          if(!empty($doc_are)){

             $where='( '; 

                $k=0;    

            foreach($doc_id as $value){

//          $this->db->or_where('pharma.city_id',$value);

                $where  .= " doc.doctor_id = '$value'";

                 $k++;

                

               if($k > 0 && count($doc_id)!=$k){

                   $where .= " OR ";

               }

               

            }

             $where .=' )';

             $this->db->or_where($where);

        }

        

        $query = $this->db->get();

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows()){

            

             return count($query->result_array());

        }

        else{

            

          return 0;

        }

    }

	

	public function all_user_pharma($userId){

		$desig_id='';

		$cityid='';

		$boss_are='';

		$doc_are='';

		$userData='';

		$arr ="pu.switchStatus,pu.id,pu.email_id,pu.password,pu.name,pu.user_city_id as city_id,pu.user_designation_id as desig_id,(SELECT GROUP_CONCAT(`pharma_id` separator ', ') as pharma_id FROM `user_pharmacy_relation` `upr` WHERE `pu`.`id`=`upr`.`user_id`) as pharma_id,(SELECT GROUP_CONCAT(ubr.`boss_id` separator ', ') as boss_id FROM `user_bossuser_relation` `ubr` WHERE `pu`.`id`=`ubr`.`user_id`) as boss_ids ,(SELECT GROUP_CONCAT(udr.`doc_id` separator ', ') as doctor_id FROM `user_doctor_relation` `udr` WHERE `pu`.`id`=`udr`.`user_id`) as doctor_id ,"

                . "(SELECT GROUP_CONCAT(ubr.`user_id` separator ', ') as boss_id FROM `user_bossuser_relation` `ubr` WHERE `pu`.`id`=`ubr`.`boss_id`) as child_ids ";

        $this->db->select($arr);

        $this->db->from('pharma_users pu');

        $this->db->where('pu.id',$userId);

        $this->db->where('pu.user_status',1);

		$query= $this->db->get();

        if($this->db->affected_rows()){

            

            $userData=$query->row();

			

        }

		

		

         $cityid = explode(',',$userData->city_id );

        

         $arr = "pl.pharma_id as id,pl.company_name as com_name,c.city_name,pl.pharmacy_status as status,pl.blocked";

        $this->db->select($arr);

        $this->db->from("pharmacy_list pl");

         $this->db->join("city c","c.city_id=pl.city_id");

         if(!empty($userData->city_id)){

            foreach($cityid as $value){

           $this->db->or_where("pl.city_id",$value);  

            }

        }

        $this->db->or_where("pl.crm_user_id", $userId);    // for show  logged user data pharmacy list too



        

        $query = $this->db->get();

//         echo $this->db->last_query(); die;

        if($this->db->affected_rows()){

            

            return count($query->result_array());

			

        }

        else{

            

            return 0;

			

        }

	}

    public function get_tada_report($userid='',$start='',$end=''){
        $result=array();
        /* Geting Leave Information  */
        $arr = "report.user_id as user_name,report.doi as doi,report.source_city as source_city,report.destination_city as destination_city,report.ta as ta,report.designation_id as designation_id,report.internet_charge as internet_charge,report.distance as distance,report.meet_id as meet_id,report.is_stay as is_stay,report.up_down as up_down,report.created_date as created_date";
        $this->db->select($arr);
        $this->db->from("ta_da_report report");
        $this->db->where('report.user_id',$userid);
        $this->db->where('report.doi>=', $start);
        $this->db->where('report.doi<=', $end);
        $this->db->group_by('report.doi');
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        if($this->db->affected_rows()){
            $result=$query->result_array();
        }
        return $result;
    }

    

}