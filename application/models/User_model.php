<?php



/* 

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */

class User_model extends CI_Model {

   

    

    public function check_user($mail){

        

        $arr ="pu.admin, pu.sp_code,pu.switchStatus,pu.id,pu.email_id,pu.password,pu.name,pu.user_city_id as city_id,pu.user_designation_id as desig_id,(SELECT GROUP_CONCAT(`pharma_id` separator ', ') as pharma_id FROM `user_pharmacy_relation` `upr` WHERE `pu`.`id`=`upr`.`user_id`) as pharma_id,(SELECT GROUP_CONCAT(ubr.`boss_id` separator ', ') as boss_id FROM `user_bossuser_relation` `ubr` WHERE `pu`.`id`=`ubr`.`user_id`) as boss_ids ,(SELECT GROUP_CONCAT(udr.`doc_id` separator ', ') as doctor_id FROM `user_doctor_relation` `udr` WHERE `pu`.`id`=`udr`.`user_id`) as doctor_id ,"

                . "(SELECT GROUP_CONCAT(ubr.`user_id` separator ', ') as boss_id FROM `user_bossuser_relation` `ubr` WHERE `pu`.`id`=`ubr`.`boss_id`) as child_ids ";

        $this->db->select($arr);

        $this->db->from('pharma_users pu');

        $this->db->where('pu.email_id',$mail);

        $this->db->where('pu.user_status',1);

        

        

        $query= $this->db->get();

//        echo $this->db->last_query(); die;

        if($this->db->affected_rows()){

            

            return $query->row();

        }

        else{

            

            return FALSE;

        }

        

       

        

        

    }

    

    

    // users list

    public function users_report(){

        

        $arr ="pu.id as userid,pu.name as username";

        $this->db->select($arr);

        $this->db->from('pharma_users pu');

        $this->db->where('pu.user_status',1);

        

        $query= $this->db->get();

//        echo $this->db->last_query(); die;

        if($this->db->affected_rows()){

            

           return json_encode($query->result_array());

        }

        else{

            

            return FALSE;

        }

        

       

        

        

    }

    

    

    // switch the users accounts

    public function user_switch($uid){

		

        

        $arr ="pu.admin,pu.sp_code,pu.id,pu.email_id,pu.password,pu.name,pu.user_city_id as city_id,pu.user_designation_id as desig_id,(SELECT GROUP_CONCAT(`pharma_id` separator ', ') as pharma_id FROM `user_pharmacy_relation` `upr` WHERE `pu`.`id`=`upr`.`user_id`) as pharma_id,(SELECT GROUP_CONCAT(ubr.`boss_id` separator ', ') as boss_id FROM `user_bossuser_relation` `ubr` WHERE `pu`.`id`=`ubr`.`user_id`) as boss_ids ,(SELECT GROUP_CONCAT(udr.`doc_id` separator ', ') as doctor_id FROM `user_doctor_relation` `udr` WHERE `pu`.`id`=`udr`.`user_id`) as doctor_id ,"

                . "(SELECT GROUP_CONCAT(ubr.`user_id` separator ', ') as boss_id FROM `user_bossuser_relation` `ubr` WHERE `pu`.`id`=`ubr`.`boss_id`) as child_ids ";

        $this->db->select($arr);

        $this->db->from('pharma_users pu');

        $this->db->where('pu.id',$uid);

        

        $query= $this->db->get();

			if ( $this->db->affected_rows() ){

				$resultSet = $query->row();

				

                                $newdata = array(

					'userName'=>$resultSet->name,

						'userId'=>$resultSet->id,

						'userEmail'=>$resultSet->email_id,

                                                'userCity'=>$resultSet->city_id,

                                                'userDesig'=>$resultSet->desig_id,

                                                'pharmaAre'=>$resultSet->pharma_id,

                                                'doctorAre'=>$resultSet->doctor_id,

                                                'userBoss' => $resultSet->boss_ids,

                                                'userChild'=>$resultSet->child_ids,
                                                 'sp_code'=>$resultSet->sp_code,
                                                 'admin'=>$resultSet->admin,

				);

				$this->session->set_userdata($newdata);

				$status = true;

                return $status;

			}

		

	}

    public function change_user_password($data)
    {
       $pass_data = array(
                'password'=>md5($data['password']),
                'last_update'=> savedate(),
                'crm_user_id' =>logged_user_data(),
            );
        $this->db->where('id',$data['user_id']);
        $this->db->update('pharma_users',$pass_data);
        //echo $this->db->last_query(); die;      
        if ($this->db->affected_rows())
        {
          return true;
        }
        else
        {
          return false;
        }   
    } 
}

