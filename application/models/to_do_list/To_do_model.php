<?php



/* 

 * Niraj Kumar

 * for show to do list of user

 */

class To_do_model extends CI_Model {

    

    

    // to do for Doctor

    public function get_to_do_doctor($current_date=''){

//        echo $current_date; die;

        $arr =" si.id,si.doc_id,cl.doc_name,si.remark,si.follow_up_action as fup";

        $this->db->select($arr);

        $this->db->from('pharma_interaction_doctor si');

        $this->db->join('doctor_list cl','cl.doctor_id=si.doc_id','left outer');

//        $this->db->join('school s','s.school_id=si.s_id','left outer');

        $this->db->where('si.crm_user_id', logged_user_data());

       

        if(!empty($current_date)){

         $this->db->where('si.status', 1);

         $this->db->where('si.follow_up_action <=',$current_date);

        }

        else{

            $this->db->where('si.status', 0);

        }

//        $this->db->group_by('si.follow_up_action');

//        $this->db->having('si.follow_up_action');

         $this->db->order_by('si.follow_up_action','ASC');

        

        $query= $this->db->get();

//        echo $this->db->last_query(); die;      

        if($this->db->affected_rows()){

            

            return json_encode($query->result_array());

        }

        else{

            

            return FALSE;

        }

     

    }

    

    // to do for dealer

     public function get_to_do_dealer($current_date=''){

//        echo $current_date; die;

        $arr =" pid.id,pid.d_id ,d.dealer_name as d_name,pid.remark,pid.follow_up_action as fup";

        $this->db->select($arr);

        $this->db->from('pharma_interaction_dealer pid');

        $this->db->join('dealer d','d.dealer_id=pid.d_id','left outer');

//        $this->db->join('school s','s.school_id=si.s_id','left outer');

        $this->db->where('pid.crm_user_id', logged_user_data());

       

        if(!empty($current_date)){

         $this->db->where('pid.status', 1);

         $this->db->where('pid.follow_up_action <=',$current_date);

        }

        else{

            $this->db->where('pid.status', 0);

        }

//        $this->db->group_by('si.follow_up_action');

//        $this->db->having('si.follow_up_action');

         $this->db->order_by('pid.follow_up_action','ASC');

        

        $query= $this->db->get();

//        echo $this->db->last_query(); die;      

        if($this->db->affected_rows()){

            

            return json_encode($query->result_array());

        }

        else{

            

            return FALSE;

        }

     

    }

    

    

    

    // interaction followup date updation

    

    public function interaction_update($data){

        

//        pr($data); die;

        if(!empty($data)){

           if(isset($data['doc_id'])){

               foreach ($data['doc_id'] as $k=>$val){

        $interaction_data = 

                array(  

                    'status'=>0,

                    'crm_user_id' =>logged_user_data(),

                    'last_update' => savedate(),

                    

                );

            

            

            $this->db->where('id',$val);

           $this->db->update('pharma_interaction_doctor',$interaction_data);

               }

           

           }

           elseif (isset($data['d_id'])) {

           

                foreach ($data['d_id'] as $k_d=>$val_d){

        $interaction_data = 

                array(  

                    'status'=>0,

                    'crm_user_id' =>logged_user_data(),

                    'last_update' => savedate(),

                    

                );

            

            

            $this->db->where('id',$val_d);

           $this->db->update('pharma_interaction_dealer',$interaction_data);

               }

       }

//   echo $this->db->last_query(); die;      

                    if ($this->db->trans_status() === TRUE)

                           {

                              return true;



                           }

                           else{



                               return false;



                           }   

        

        }

    }

    

    

}

