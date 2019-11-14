<?php


/*
 * Developer: Niraj Sharma
 * Email: niraj@bjain.com
 * 
 * Dated: 28-08-2018
 * 
 */

class Pharma_api_model extends CI_Model {

    public function get_pharma_list($dataArr)
    {
    	$pharma_list=array();
    	$sp=explode(',',$dataArr['sp_code']);
    	foreach($sp as $spcd)
    	{
	 	$arr = "pharma.sp_code,pharma.pharma_id as id,pharma.d_id as dealers_id,pharma.company_name as com_name,pharma.company_email as com_email,pharma.company_phone as com_ph,pharma.pharmacy_status as status,pharma.blocked,pharma.city_pincode as city_pincode,pharma.city_id as city_id,owner_name,owner_email,owner_phone,IF(owner_dob is not NULL, owner_dob, '') as owner_dob,company_address,pharma.state_id,c.city_name";
	        $this->db->select($arr);
	        $this->db->from("pharmacy_list pharma");
	        $this->db->join("city c","c.city_id=pharma.city_id");
	        $this->db->where('pharma.sp_code',$spcd);
	        $this->db->where('pharma.city_id',$dataArr['city_id']);
	        $query= $this->db->get();
	        //echo $this->db->last_query(); die;
	        if($this->db->affected_rows())
	        {
	            foreach($query->result_array() as $phdata)
    		    {
	            	$pharma_list[]=$phdata ;
	            }
	        }
        }
        if(empty($pharma_list))
        {
        	return False;
        }
        else
        {
        	return $pharma_list;
        }
    }
    
    public function add_pharma($data)
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
	$pharmacy_data = array(
                    'company_name'=>$data->com_name,
                    'company_email'=>$data->com_email,
                    'company_phone'=>$data->com_number,
                    'city_pincode'=>$data->city_pin,
                    'company_address'=>$data->com_address,                                       
                    'state_id'=>$data->com_state,
                    'city_id'=>$data->com_city,
                    'owner_name'=>$data->owner_name,
                    'owner_email'=>$data->owner_email,
                    'owner_phone'=>$data->owner_number,
                    'sp_code'=>api_user_sp_code($data->user_id),
                    'owner_dob'=>$dob,                 
                    'd_id'=>$dealers_id,
                    'crm_user_id'=> $data->user_id,
                    'last_update'=>savedate(),
                    'pharmacy_status'=>1,   
                    'doc_navigate_id'=>'',
                );
        $this->db->insert('pharmacy_list',$pharmacy_data); 
	$ap_id=$this->db->insert_id();
        $newid = "pharma_".$ap_id;
        $pharmacy_data = array('pharma_id'=>$newid,'last_update'=>savedate());
        $this->db->where('id',$ap_id);
        $this->db->update('pharmacy_list',$pharmacy_data);
        return ($this->db->affected_rows() != 1) ? false : true; 
    }
    
    public function edit_pharma($data)
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
	$pharmacy_data = array(
                    'company_name'=>$data->com_name,
                    'company_email'=>$data->com_email,
                    'company_phone'=>$data->com_number,
                    'city_pincode'=>$data->city_pin,
                    'company_address'=>$data->com_address,                                       
                    'state_id'=>$data->com_state,
                    'city_id'=>$data->com_city,
                    'owner_name'=>$data->owner_name,
                    'owner_email'=>$data->owner_email,
                    'owner_phone'=>$data->owner_number,
                    'owner_dob'=>$dob,                 
                    'd_id'=>$dealers_id,
                    'crm_user_id'=> $data->user_id,
                    'last_update'=>savedate(),
                    'pharmacy_status'=>1,   
                );
        $this->db->where('pharma_id',$data->pharma_id);
        $this->db->update('pharmacy_list',$pharmacy_data);
     	return ($this->db->affected_rows() != 1) ? false : true;  
    }
    
    public function sync_add_pharma($data)
    {
    	if(isset($data->owner_dob) && !empty($data->owner_dob))
    	{
            $dob = date('Y-m-d', strtotime($data->owner_dob));
        }
        else
        {
            $dob=NULL;
        }
        $dealers_id=$data->dealers_id;
	$pharmacy_data = array(
                    'company_name'=>$data->com_name,
                    'company_email'=>$data->com_email,
                    'company_phone'=>$data->com_ph,
                    'city_pincode'=>$data->city_pincode,
                    'company_address'=>$data->company_address,                                       
                    'state_id'=>$data->state_id,
                    'city_id'=>$data->city_id,
                    'owner_name'=>$data->owner_name,
                    'owner_email'=>$data->owner_email,
                    'owner_phone'=>$data->owner_phone,
                    'sp_code'=>api_user_sp_code($data->user_id),
                    'owner_dob'=>$dob,                 
                    'd_id'=>$dealers_id,
                    'crm_user_id'=> $data->user_id,
                    'last_update'=>savedate(),
                    'pharmacy_status'=>1,   
                    'doc_navigate_id'=>'',
                    'cromp'=>$data->cromp
                );
        $this->db->insert('pharmacy_list',$pharmacy_data); 
	$ap_id=$this->db->insert_id();
        $newid = "pharma_".$ap_id;
        $pharmacy_data = array('pharma_id'=>$newid,'last_update'=>savedate());
        $this->db->where('id',$ap_id);
        $this->db->update('pharmacy_list',$pharmacy_data);
        return ($this->db->affected_rows() != 1) ? false : true; 
    }
    
    public function sync_edit_pharma($data)
    {

    	if(isset($data->owner_dob) && !empty($data->owner_dob))
    	{
            $dob = date('Y-m-d', strtotime($data->owner_dob));
        }
        else
        {
            $dob=NULL;
        }
        $dealers_id=$data->dealers_id;
	$pharmacy_data = array(
                   // 'company_name'=>$data->com_name,
                    'company_email'=>$data->com_email,
                    'company_phone'=>$data->com_ph,
                    'city_pincode'=>$data->city_pincode,
                    'company_address'=>$data->company_address,                                       
                    'state_id'=>$data->state_id,
                    'city_id'=>$data->city_id,
                    'owner_name'=>$data->owner_name,
                    'owner_email'=>$data->owner_email,
                    'owner_phone'=>$data->owner_phone,
                    'owner_dob'=>$dob,                 
                    'd_id'=>$dealers_id,
                    'crm_user_id'=> $data->user_id,
                    'last_update'=>savedate(),
                    'pharmacy_status'=>1,   
                    
                );
        $this->db->where('pharma_id',$data->id);
        $this->db->update('pharmacy_list',$pharmacy_data);
     	return ($this->db->affected_rows() != 1) ? false : true;  
    }
       
}

