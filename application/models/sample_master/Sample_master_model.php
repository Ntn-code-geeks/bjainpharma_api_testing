<?php



/* 

 * Niraj Kumar

 * Dated: 04-oct-2017

 * 

 * model for Sample Master 

 */



class Sample_master_model extends CI_Model {



    

    // for add and edit the sample data

    public function add_samplemaster($data,$sample_id=''){



      

         $sample_data = 

                array(

                    'sample_name'=>$data['product_name'],

                    'crm_user_id'=> logged_user_data(),

                    'last_update'=>savedate(),

                    'sample_status'=>1,                    

                );

         

         if($sample_id !=''){

            

            $this->db->where('id',$sample_id);

           $this->db->update('meeting_sample_master',$sample_data);

         

                    if ($this->db->trans_status() === TRUE)

                           {

                              return true;



                           }

                           else{



                               return false;



                           }   



        }else{

                  

          $this->db->insert('meeting_sample_master',$sample_data); 

            

            return ($this->db->affected_rows() != 1) ? false : true; 

        }

 

    }

    

   

    // for show list of sample data

    public function sample_list($id=''){

        

        $arr = "sm.id,sm.sample_name,pu.name as sampleaddedby";

        $this->db->select($arr);

        $this->db->from("meeting_sample_master sm");



        $this->db->join("pharma_users pu" , "pu.id=sm.crm_user_id");

        

        if(is_admin()){

        if($id!=''){

            $sm_id= urisafedecode($id);

            $this->db->where('sm.id',$sm_id);

        }

        $this->db->where('sm.sample_status',1);

//        $this->db->limit($limit, decode($start));

        }

        $query = $this->db->get();

//         echo $this->db->last_query(); die;

        if($this->db->affected_rows()){

            

            return json_encode($query->result_array());

        }

        else{

            

            return FALSE;

        }

    }

  

    

    // for delete the sample(this function only checnge the status of sample maste for delete)

    public function del_samplemaster($sm_id){

        

        $sample_data= array(

             'crm_user_id'=> logged_user_data(),

                    'last_update'=>savedate(),

                    'sample_status'=>0, 

        );

        

         $this->db->where('id',$sm_id);

           $this->db->update('meeting_sample_master',$sample_data);

           

            if ($this->db->trans_status() === TRUE)

                           {

                              return true;



                           }

                           else{



                               return false;



                           }   



        

    }

    

}