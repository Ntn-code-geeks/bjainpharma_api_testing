<?php



/* 

 * Niraj Kumar

 * Dated: 11-nov-2017

 * 

 * model for data analysis for customer,team 

 */



class Data_analysis_model extends CI_Model {



  

    public function top_sales_cust($data=''){

//        $desig_id=logged_user_desig();

//       $log_userid = logged_user_data();

//        

//        $cities_are = logged_user_cities();

//         $city_id=explode(',', $cities_are);

//        

//           $boss_are = logged_user_boss();

//          $boss_id=explode(',', $boss_are);

//        

//           $doc_are = logged_user_doc();

//          $doc_id=explode(',', $doc_are);

        

        if($data!=''){

        $start = date('Y-m-d', strtotime($data));

        }

        else{

            $start = date('Y-m-d', strtotime('-7 days'));

        }

        

        

        $end = date('Y-m-d')." 23:59:59";

        

        $arr = "d.dealer_id,SUM(pid.meeting_sale) as sale,d.dealer_name as customername";
        $this->db->select($arr);
        $this->db->from("pharma_interaction_dealer pid");
        $this->db->join("dealer d" , "d.dealer_id=pid.d_id");
        $this->db->where('pid.create_date >=', $start);
        $this->db->where('pid.create_date <=', $end);
        $this->db->where("pid.meeting_sale !="," ");

        /*if(logged_user_data()!=28 && logged_user_data()!=29 &&  logged_user_data()!=32 )
        {
            $this->db->where("d.sp_code in (".all_user_sp_code().")");
        }*/

        if(!is_admin())
        {
            $spc=$this->session->userdata('sp_code');
            $sp=0;
            if($spc!='')
            {
                $sp=str_replace(',','|',$this->session->userdata('sp_code'));
            }
            $this->db->where('CONCAT(",", `d`.`sp_code`, ",") REGEXP ",('.$sp.'),"');
        }
        $this->db->group_by("pid.d_id");
        $this->db->limit(6, 0);
        $this->db->order_by("SUM(pid.meeting_sale)","DESC");
        $query = $this->db->get();

       //echo $this->db->last_query(); die;

         if($this->db->affected_rows()){
            return json_encode($query->result_array());
        }

        else{

            

            return FALSE;

        }

    }

    

    // top payment customers 

    public function top_payment_cust($data=''){

        

         if($data!=''){

        $start = date('Y-m-d', strtotime($data));

        }

        else{

            $start = date('Y-m-d', strtotime('-7 days'));

        }

        

        $end = date('Y-m-d')." 23:59:59";

        

        $arr = "d.dealer_id,SUM(pid.meeting_payment) as payment,d.dealer_name as customername";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_dealer pid");

        $this->db->join("dealer d" , "d.dealer_id=pid.d_id");



        $this->db->where('pid.create_date >=', $start);

        $this->db->where('pid.create_date <=', $end);

        if(!is_admin())
        {
            $spc=$this->session->userdata('sp_code');
            $sp=0;
            if($spc!='')
            {
                $sp=str_replace(',','|',$this->session->userdata('sp_code'));
            }
            $this->db->where('CONCAT(",", `d`.`sp_code`, ",") REGEXP ",('.$sp.'),"');
        }

        $this->db->where("pid.meeting_payment !="," ");

        

        

        $this->db->group_by("pid.d_id");

        

          $this->db->limit(6, 0);

        

        $this->db->order_by("SUM(pid.meeting_payment)","DESC");

        

        

        $query = $this->db->get();

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows()){

            

            return json_encode($query->result_array());

        }

        else{

            

            return FALSE;

        }

        

    }

    

    

    // top secondary sale customer (doctor or pharmacy)

    public function top_secondary_cust($data=''){
//all_user_sp_code();
        

        if($data!=''){

        $start = date('Y-m-d', strtotime($data));

        }

        else{

            $start = date('Y-m-d', strtotime('-7 days'));

        }

         $end = date('Y-m-d')." 23:59:59";

        

        $arr = "dl.doctor_id as docid,SUM(pid.meeting_sale) as sale,dl.doc_name as customername";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_doctor pid");

        $this->db->join("doctor_list dl" , "dl.doctor_id=pid.doc_id");

        if(!is_admin())
        {
            $sp=$this->session->userdata('sp_code');
            if($sp!=''){
                $this->db->where("`dl`.`sp_code` in (".$sp.")");
            }
            else
            {
                $sp=0;
                $this->db->where("`dl`.`sp_code` in (".$sp.")");
            }
            
        }

        $this->db->where('pid.create_date >=', $start);

        $this->db->where('pid.create_date <=', $end);

        

        $this->db->where("pid.meeting_sale !="," ");

        

        

        $this->db->group_by("pid.doc_id");

          $this->db->limit(6, 0);

        $this->db->order_by("SUM(`pid`.`meeting_sale`)","DESC");

        

        $query = $this->db->get();

        

         $doc_sale_info = $query->result_array();  // for doctor sale list

//        pr($doc_sale_info);
//echo all_user_sp_code();
   // echo $this->db->last_query(); die;

         if($this->db->affected_rows() || 1==1){

            

           // for pharmacy sale list  

        $arr = "pl.pharma_id as pharma_id,SUM(pip.meeting_sale) as sale,pl.company_name as customername";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_pharmacy pip");

       $this->db->join("pharmacy_list pl" , "pl.pharma_id=pip.pharma_id");

        if(!is_admin())
        {
            $sp=$this->session->userdata('sp_code');
            
            if($sp!=''){
               $this->db->where("sp_code in (".$sp.")");
            }
            else
            {
                $sp=0;
                $this->db->where("sp_code in (".$sp.")");
            }
        }
        $this->db->where('pip.create_date >=', $start);

        $this->db->where('pip.create_date <=', $end);

        

        $this->db->where("pip.meeting_sale !="," ");

        

        

        $this->db->group_by("pip.pharma_id");

          $this->db->limit(6, 0);

        $this->db->order_by("SUM(pip.meeting_sale)","DESC");

        

        $query = $this->db->get();

        

        $pharma_sale_info = $query->result_array();  // for pharmacy sale list 

//           echo "pharma"."<br>";

//        pr($pharma_sale_info);

           

        $res = array_merge($doc_sale_info, $pharma_sale_info); 

        

       $result = msort($res, array('sale'));   // $res is an array,   Second is key name which is being sort by value

         

//       pr($result); die;

        

            return json_encode($result);

        }

        else{

            

            return FALSE;

        }

        

        

        

    }

 

    

    // top interaction customer (doctor or pharmacy or dealer)

    

    public function top_interaction_cust($data=''){

        

    

          if($data!=''){

        $start = date('Y-m-d', strtotime($data));

        }

        else{

            $start = date('Y-m-d', strtotime('-7 days'));

        }

         

         $end = date('Y-m-d')." 23:59:59";

        

        // for Doctor interaction list 

        $arr = "dl.doctor_id,count(pid.doc_id) as interaction,dl.doc_name as customername";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_doctor pid");

        $this->db->join("doctor_list dl" , "dl.doctor_id=pid.doc_id");

        if(!is_admin())
        {
            $sp=$this->session->userdata('sp_code');
            if($sp!=''){
               $this->db->where("sp_code in (".$sp.")");
            }
            else
            {
                $sp=0;
                $this->db->where("sp_code in (".$sp.")");
            }
        }

        $this->db->where('pid.create_date >=', $start);

        $this->db->where('pid.create_date <=', $end);
       

        $this->db->group_by("pid.doc_id");

          $this->db->limit(6, 0);

        $this->db->order_by("count(`pid`.`doc_id`)","DESC");

        

        $query = $this->db->get();

        

         $doc_interaction_info = $query->result_array();    // for Doctor interaction list 

//        pr($doc_sale_info);

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows() || 1==1){

            

             // for Sub Dealer interaction list 

        $arr = "pl.pharma_id,count(pip.pharma_id) as interaction,pl.company_name as customername";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_pharmacy pip");

       $this->db->join("pharmacy_list pl" , "pl.pharma_id=pip.pharma_id");

        if(!is_admin())
        {
            $sp=$this->session->userdata('sp_code');
            if($sp!=''){
               $this->db->where("sp_code in (".$sp.")");
            }
            else
            {
                $sp=0;
                $this->db->where("sp_code in (".$sp.")");
            }
        }

        $this->db->where('pip.create_date >=', $start);

        $this->db->where('pip.create_date <=', $end);

        

               

        

        $this->db->group_by("pip.pharma_id");

          $this->db->limit(6, 0);

        $this->db->order_by("count(pip.pharma_id)","DESC");

        

        $query = $this->db->get();

         

        $pharma_interaction_info = $query->result_array();  // for Sub Dealer interaction list 

//           echo "pharma"."<br>";

//        pr($pharma_sale_info);

             

           

        $res = array_merge($doc_interaction_info, $pharma_interaction_info);  // merge doctor and pharmacy interaction

   

         //$result if for show sorted value of interaction of doctor , pharmacy and Dealer

       

       $result = msort($res, array('interaction'));   // $res is an array,   Second is key name which is being sort by value

       

      

          

        // for dealer interaction list 

        $arr = "d.gd_id,d.dealer_id,count(pid.d_id) as interaction,d.dealer_name as customername";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_dealer pid");

        $this->db->join("dealer d" , "d.dealer_id=pid.d_id");



        $this->db->where('pid.create_date >=', $start);

        $this->db->where('pid.create_date <=', $end);

        
        if(!is_admin())
        {
            $spc=$this->session->userdata('sp_code');
            $sp=0;
            if($spc!='')
            {
                $sp=str_replace(',','|',$this->session->userdata('sp_code'));
            }
            $this->db->where('CONCAT(",", `d`.`sp_code`, ",") REGEXP ",('.$sp.'),"');
        }
        

        $this->db->group_by("pid.d_id");

          $this->db->limit(6, 0);

        $this->db->order_by("count(pid.d_id)","DESC");

        

        $query = $this->db->get();

         

        $dealer_interaction_info = $query->result_array();  // for Dealer interaction list 

       

       

         $res_d = array_merge($result, $dealer_interaction_info);  // merge doctor and pharmacy interaction

   

         

         //$result if for show sorted value of interaction of doctor , pharmacy and Dealer

       

        $result_d = msort($res_d, array('interaction'));   // $res is an array,   Second is key name which is being sort by value

        // $result_d is a sorted value of all the reord of doctor/dealer and pharmacy interaction

       

//          pr($result_d); die;

        

            return json_encode($result_d);

        }

        else{

            

            return FALSE;

        }

        

        

        

    }

    

    //top most met customer

     public function top_most_met_cust($data=''){

        

       

          if($data!=''){

        $start = date('Y-m-d', strtotime($data));

        }

        else{

            $start = date('Y-m-d', strtotime('-7 days'));

        }

         

         $end = date('Y-m-d')." 23:59:59";

        

        // for Doctor Meet list 

        $arr = "dl.doctor_id,count(pid.meet_or_not_meet) as meet,dl.doc_name as customername";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_doctor pid");

        $this->db->join("doctor_list dl" , "dl.doctor_id=pid.doc_id");

                if(!is_admin())
        {
            $sp=$this->session->userdata('sp_code');
            if($sp!=''){
               $this->db->where("sp_code in (".$sp.")");
            }
            else
            {
                $sp=0;
                $this->db->where("sp_code in (".$sp.")");
            }
        }

        $this->db->where('pid.create_date >=', $start);

        $this->db->where('pid.create_date <=', $end);

        $this->db->where('pid.meet_or_not_meet',1);

        

        $this->db->group_by("pid.doc_id");

          $this->db->limit(6, 0);

        $this->db->order_by("count(`pid`.`doc_id`)","DESC");

        

        $query = $this->db->get();

        

         $doc_met_info = $query->result_array();    // for Doctor Meet list 

//        pr($doc_met_info);

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows() || 1==1){

            

             // for Sub Dealer Meet list 

        $arr = "pl.pharma_id,count(pip.meet_or_not_meet) as meet,pl.company_name as customername";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_pharmacy pip");

       $this->db->join("pharmacy_list pl" , "pl.pharma_id=pip.pharma_id");

        if(!is_admin())
        {
            $sp=$this->session->userdata('sp_code');
            if($sp!=''){
               $this->db->where("sp_code in (".$sp.")");
            }
            else
            {
                $sp=0;
                $this->db->where("sp_code in (".$sp.")");
            }
        }

        $this->db->where('pip.create_date >=', $start);

        $this->db->where('pip.create_date <=', $end);

        $this->db->where('pip.meet_or_not_meet',1);

               

        

        $this->db->group_by("pip.pharma_id");

          $this->db->limit(6, 0);

        $this->db->order_by("count(pip.pharma_id)","DESC");

        

        $query = $this->db->get();

         

        $pharma_met_info = $query->result_array();  // for Sub Dealer Meet list 

//           echo "pharma"."<br>";

//        pr($pharma_met_info);

             

           

        $res = array_merge($doc_met_info, $pharma_met_info);  // merge doctor and pharmacy meet

   

         //$result if for show sorted value of meet of doctor , pharmacy and Dealer

       

       $result = msort($res, array('meet'));   // $res is an array,   Second is key name which is being sort by value

       

      

          

        // for dealer Meet list 

        $arr = "d.gd_id,d.dealer_id,count(pid.meet_or_not_meet) as meet,d.dealer_name as customername";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_dealer pid");

        $this->db->join("dealer d" , "d.dealer_id=pid.d_id");



        $this->db->where('pid.create_date >=', $start);

        $this->db->where('pid.create_date <=', $end);

        $this->db->where('pid.meet_or_not_meet',1);
                if(!is_admin())
        {
            $spc=$this->session->userdata('sp_code');
            $sp=0;
            if($spc!='')
            {
                $sp=str_replace(',','|',$this->session->userdata('sp_code'));
            }
            $this->db->where('CONCAT(",", `d`.`sp_code`, ",") REGEXP ",('.$sp.'),"');
        }
        

        $this->db->group_by("pid.d_id");

          $this->db->limit(6, 0);

        $this->db->order_by("count(pid.d_id)","DESC");

        

        $query = $this->db->get();

         

        $dealer_met_info = $query->result_array();  // for Dealer Meet list 

       

       

         $res_d = array_merge($result, $dealer_met_info);  // merge doctor and pharmacy meet

   

         

         //$result if for show sorted value of meet of doctor , pharmacy and Dealer

       

        $result_d = msort($res_d, array('meet'));   // $res is an array,   Second is key name which is being sort by value

        // $result_d is a sorted value of all the reord of doctor/dealer and pharmacy meet

       

//          pr($result_d); die;

        

            return json_encode($result_d);

        }

        else{

            

            return FALSE;

        }

        

        

        

    }

    

    // top most not met customer

     public function top_never_met_cust($data=''){
        if($data!=''){
        $start = date('Y-m-d', strtotime($data));
        }
        else{
            $start = date('Y-m-d', strtotime('-7 days'));
        }
        $end = date('Y-m-d')." 23:59:59";
               // for Doctor never Meet list 

        $arr = "dl.doctor_id,count(pid.meet_or_not_meet) as nevermeet,dl.doc_name as customername";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_doctor pid");

        $this->db->join("doctor_list dl" , "dl.doctor_id=pid.doc_id");

                if(!is_admin())
        {
            $sp=$this->session->userdata('sp_code');
            if($sp!=''){
               $this->db->where("sp_code in (".$sp.")");
            }
            else
            {
                $sp=0;
                $this->db->where("sp_code in (".$sp.")");
            }
        }

        $this->db->where('pid.create_date >=', $start);

        $this->db->where('pid.create_date <=', $end);

        $this->db->where('pid.meet_or_not_meet',0);

        

        $this->db->group_by("pid.doc_id");

          $this->db->limit(6, 0);

        $this->db->order_by("count(`pid`.`doc_id`)","DESC");

        

        $query1 = $this->db->get();

        

         $doc_met_info = $query1->result_array();    // for Doctor never Meet list 

//        pr($doc_met_info);

//         echo $this->db->last_query(); die;

//         if($this->db->affected_rows()){

            

             // for Sub Dealer never Meet list 

        $arr = "pl.pharma_id,count(pip.meet_or_not_meet) as nevermeet,pl.company_name as customername";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_pharmacy pip");

       $this->db->join("pharmacy_list pl" , "pl.pharma_id=pip.pharma_id");

        if(!is_admin())
        {
            $sp=$this->session->userdata('sp_code');
                        if($sp!=''){
               $this->db->where("sp_code in (".$sp.")");
            }
            else
            {
                $sp=0;
                $this->db->where("sp_code in (".$sp.")");
            }
        }

        $this->db->where('pip.create_date >=', $start);

        $this->db->where('pip.create_date <=', $end);

        $this->db->where('pip.meet_or_not_meet',0);

               

        

        $this->db->group_by("pip.pharma_id");

          $this->db->limit(6, 0);

        $this->db->order_by("count(pip.pharma_id)","DESC");

        

        $query2 = $this->db->get();

         

        $pharma_met_info = $query2->result_array();  // for Sub Dealer never Meet list 

//           echo "pharma"."<br>";

//        pr($pharma_met_info);

             

           

        $res = array_merge($doc_met_info, $pharma_met_info);  // merge doctor and pharmacy meet

   

         //$result if for show sorted value of meet of doctor , pharmacy and Dealer

       

       $result = msort($res, array('nevermeet'));   // $res is an array,   Second is key name which is being sort by value

       

      

          

        // for dealer Meet list 

        $arr = "d.gd_id,d.dealer_id,count(pid.meet_or_not_meet) as nevermeet,d.dealer_name as customername";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_dealer pid");

        $this->db->join("dealer d" , "d.dealer_id=pid.d_id");



        $this->db->where('pid.create_date >=', $start);

        $this->db->where('pid.create_date <=', $end);

        $this->db->where('pid.meet_or_not_meet',0);

                if(!is_admin())
        {
            $spc=$this->session->userdata('sp_code');
            $sp=0;
            if($spc!='')
            {
                $sp=str_replace(',','|',$this->session->userdata('sp_code'));
            }
            $this->db->where('CONCAT(",", `d`.`sp_code`, ",") REGEXP ",('.$sp.'),"');
        }

        $this->db->group_by("pid.d_id");

          $this->db->limit(6, 0);

        $this->db->order_by("count(pid.d_id)","DESC");

        

        $query3 = $this->db->get();

         

        $dealer_met_info = $query3->result_array();  // for Dealer never Meet list 

       

       

         $res_d = array_merge($result, $dealer_met_info);  // merge doctor and pharmacy never  meet

   

         

         //$result if for show sorted value of never meet of doctor , pharmacy and Dealer

       

        $result_d = msort($res_d, array('nevermeet'));   // $res is an array,   Second is key name which is being sort by value

        // $result_d is a sorted value of all the reord of doctor/dealer and pharmacy meet

       

//          pr($result_d); die;

//         if($query1->affected_rows() >0 || $query2->affected_rows() || $query3->affected_rows()){
           return json_encode($result_d);

            

//            }
//        else{
//            
//            return FALSE;
//        }
    }

    

}