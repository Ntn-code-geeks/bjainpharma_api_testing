<?php


/*
 * Developer: Niraj Sharma
 * Email: niraj@bjain.com
 * 
 * Dated: 28-08-2018
 * 
 */

class Doctor_api_model extends CI_Model {

    public function get_doctor_list($dataArr)
    {
    	$doc_list = array();
    	$sp=explode(',',$dataArr['sp_code']);
    	foreach($sp as $spcd)
    	{
	 	$arr = "doc.sp_code,doc.doctor_id as id,doc.d_id as dealers_id,doc.doc_name as d_name,doc.doc_email as d_email,doc.doc_phone as d_ph,doc.blocked,doc.city_id as city_id,doc.state_id as state_id,doc_gender as gender,doc_married_status as married,doc_spouse_name as sp_name,IF(doc_spouse_email is not NULL, doc_spouse_email, '') as sp_email,doctor_status_id as doc_status,doc_about as about,doc_address as address,city_pincode as city_pin,IF(doc_dob is not NULL, doc_dob, '') as dob,c.city_name";
	        $this->db->select($arr);
	        $this->db->from("doctor_list doc");
	        $this->db->join("city c","c.city_id=doc.city_id");
	        $this->db->where('doc.sp_code',$spcd);
	        $this->db->where('doc.city_id',$dataArr['city_id']);
	        $query= $this->db->get();
//	        echo $this->db->last_query(); die;
	        if($this->db->affected_rows())
	        {
	            foreach($query->result_array() as $docdata )
    		    {
	            	$doc_list[]=$docdata ;
	            }
	        }
        }
        if(empty($doc_list))
        {
        	return False;
        }
        else
        {
        	return $doc_list;
        }
    }
    
    public function add_doctor($data)
    {
    	if(isset($data->dob) && !empty($data->dob))
    	{
            $dob = date('Y-m-d', strtotime($data->dob));
        }
        else
        {
            $dob=NULL;
        }
        $dealers_id=implode(',',$data->dealer_id);
	$doctor_data = array(
                    'doc_name'=>$data->doctor_name,
                    'doc_email'=>$data->doctor_email,
                    'doc_phone'=>$data->doctor_num,
                    'doc_address'=>$data->address,
                    'doc_gender'=>$data->gender,                                       
                    'city_pincode'=>$data->city_pin,
                    'doc_married_status'=>$data->married,
                    'doc_spouse_name'=>$data->sp_name,
                    'doc_spouse_email'=>$data->sp_email,
                    'state_id'=>$data->doctor_state,
                    'city_id'=>$data->doctor_city,
                    'sp_code'=>api_user_sp_code($data->user_id),
                    'doc_dob'=>$dob,               
                    'd_id'=>$dealers_id,
                    'doc_about'=>$data->about,
                    'crm_user_id'=> $data->user_id,
                    'last_update'=>savedate(),
                    'doc_status'=>1,   
                    'doc_navigate_id'=>'',
                    'doctor_status_id'=>$data->doc_status,
                );
        $this->db->insert('doctor_list',$doctor_data); 
	$ap_id=$this->db->insert_id();
        $newid = "doc_".$ap_id;
        $doctor_data= array('doctor_id'=>$newid,'last_update'=>savedate());
        $this->db->where('id',$ap_id);
        $this->db->update('doctor_list',$doctor_data);
        return ($this->db->affected_rows() != 1) ? false : true; 
    }
    
    public function edit_doctor($data)
    {
    	if(isset($data->dob) && !empty($data->dob))
    	{
            $dob = date('Y-m-d', strtotime($data->dob));
        }
        else
        {
            $dob=NULL;
        }
       	$dealers_id=implode(',',$data->dealer_id);
	$doctor_data= array(
                    'doc_email'=>$data->doctor_email,
                    'doc_phone'=>$data->doctor_num,
                    'doc_address'=>$data->address,
                    'doc_gender'=>$data->gender,                                       
                    'city_pincode'=>$data->city_pin,
                    'doc_married_status'=>$data->married,
                    'doc_spouse_name'=>$data->sp_name,
                    'doc_spouse_email'=>$data->sp_email,
                    'state_id'=>$data->doctor_state,
                    'city_id'=>$data->doctor_city,
                    'sp_code'=>api_user_sp_code($data->user_id),
                    'doc_dob'=>$dob,               
                    'd_id'=>$dealers_id,
                    'doc_about'=>$data->about,
                    'crm_user_id'=> $data->user_id,
                    'last_update'=>savedate(),
                    'doc_status'=>1,   
                    'doc_navigate_id'=>'',
                    'doctor_status_id'=>$data->doc_status,
                );
        $this->db->where('doctor_id',$data->doc_id);
        $this->db->update('doctor_list',$doctor_data);
     	return ($this->db->affected_rows() != 1) ? false : true;  
    }
    
    public function sync_add_doctor($data,$dealer_ids)
    {
    	if(isset($data->dob) && !empty($data->dob))
    	{
            $dob = date('Y-m-d', strtotime($data->dob));
        }
        else
        {
            $dob=NULL;
        }
	$doctor_data = array(
                    'doc_name'=>$data->d_name,
                    'doc_email'=>$data->d_email,
                    'doc_phone'=>$data->d_ph,
                    'doc_address'=>$data->address,
                    'doc_gender'=>$data->gender,                                       
                    'city_pincode'=>$data->city_pin,
                    'doc_married_status'=>$data->married,
                    'doc_spouse_name'=>$data->sp_name,
                    'doc_spouse_email'=>$data->sp_email,
                    'state_id'=>$data->state_id,
                    'city_id'=>$data->city_id,
                    'sp_code'=>api_user_sp_code($data->user_id),
                    'doc_dob'=>$dob,               
                    'd_id'=>$dealer_ids,
                    'doc_about'=>$data->about,
                    'crm_user_id'=> $data->user_id,
                    'cromp'=> $data->cromp,
                    'last_update'=>savedate(),
                    'doc_status'=>1,   
                    'doc_navigate_id'=>'',
                    'doctor_status_id'=>$data->doc_status,
                );
        $this->db->insert('doctor_list',$doctor_data); 
	$ap_id=$this->db->insert_id();
        $newid = "doc_".$ap_id;
        $doctor_data= array('doctor_id'=>$newid,'last_update'=>savedate());
        $this->db->where('id',$ap_id);
        $this->db->update('doctor_list',$doctor_data);
        return ($this->db->affected_rows() != 1) ? false : true; 
    }
    
    public function sync_edit_doctor($data,$dealer_ids)
    {
    	if(isset($data->dob) && !empty($data->dob))
    	{
            $dob = date('Y-m-d', strtotime($data->dob));
        }
        else
        {
            $dob=NULL;
        }
	$doctor_data= array(
                    'doc_email'=>$data->d_email,
                    'doc_phone'=>$data->d_ph,
                    'doc_address'=>$data->address,
                    'doc_gender'=>$data->gender,                                       
                    'city_pincode'=>$data->city_pin,
                    'doc_married_status'=>$data->married,
                    'doc_spouse_name'=>$data->sp_name,
                    'doc_spouse_email'=>$data->sp_email,
                    'state_id'=>$data->state_id,
                    'city_id'=>$data->city_id,
                    'sp_code'=>api_user_sp_code($data->user_id),
                    'doc_dob'=>$dob,               
                    'd_id'=>$dealer_ids,
                    'doc_about'=>$data->about,
                    'crm_user_id'=> $data->user_id,
                    'last_update'=>savedate(),
                    'doc_status'=>1,   
                    'doc_navigate_id'=>'',
                    'doctor_status_id'=>$data->doc_status,
                );
        $this->db->where('doctor_id',$data->id);
        $this->db->update('doctor_list',$doctor_data);
     	return ($this->db->affected_rows() != 1) ? false : true;  
    }
       
}

