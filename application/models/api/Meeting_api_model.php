<?php



class Meeting_api_model extends CI_Model {
   
    public function get_meeting_list()
    {
     	$arr = "meeting_id,meeting_value";
	$this->db->select($arr);
	$this->db->from("user_meeting_master");
	$query= $this->db->get();
	if($this->db->affected_rows())
        {
            	return $query->result_array();
        }
        else
        {
        	return false;
        }
    }
    
    public function save_meeting($data)
    {
    	if(!isset ($data->meeting_id) || empty($data->meeting_id))
	{
		$meeting_date = date('Y-m-d', strtotime($data->meeting_date));
		$meeting_data = array(
			'meeting_place'=>$data->meeting_place,
			'meeting_type'=>$data->meeting_type,
			'remark'=>$data->remark,
			'meeting_date'=>$meeting_date,
			'crm_user_id'=> $data->user_id,
			'created_date'=>savedate(),                  
			'updated_date'=>savedate(),                  
			'status'=>1, 
		);
		$this->db->insert('user_meeting',$meeting_data); 
		return ($this->db->affected_rows() == 1) ? true : false; 
	}
	else
	{
		$meeting_date = date('Y-m-d', strtotime($data->meeting_date));
		$meeting_data = array(
			'meeting_place'=>$data->meeting_place,
			'meeting_type'=>$data->meeting_type,
			'remark'=>$data->remark,
			'meeting_date'=>$meeting_date,
			'updated_date'=>savedate(),                  
		);
		$this->db->set($meeting_data);
		$this->db->where('meeting_id',$data->meeting_id); 
		$this->db->update('user_meeting'); 
		return ($this->db->affected_rows() == 1) ? true : false; 
	}

    }
    
    public function get_meeting_details($userid)
    {
     	$arr = "um.meeting_id,meeting_type,umm.meeting_value,meeting_date,remark,c.city_name,um.meeting_place";
	$this->db->select($arr);
	$this->db->from("user_meeting um");
	$this->db->join("city c","c.city_id=um.meeting_place");
	$this->db->join("user_meeting_master umm","umm.meeting_id=um.meeting_type");
	$this->db->where('um.crm_user_id',$userid);
	$query= $this->db->get();
	if($this->db->affected_rows())
        {
            	return $query->result_array();
        }
        else
        {
        	return false;
        }
    }
    
    public function save_leave($data)
    {
    	if(!isset ($data->leave_id) || empty($data->leave_id))
	{
		$from_date = date('Y-m-d', strtotime($data->from_date));
		$to_date = date('Y-m-d', strtotime($data->to_date));
		$leave_data = array
			(
				'from_date'=>$from_date,
				'to_date'=>$to_date,
				'remark'=>$data->remark,
				'user_id'=> $data->user_id,
				'created_date'=>savedate(),                  
				'updated_date'=>savedate(),                  
				'status'=>1, 
				'leave_status'=>1,
			);
		$this->db->insert('user_leave',$leave_data);
		return ($this->db->affected_rows() == 1) ? true : false; 
	}
	else
	{
		$from_date = date('Y-m-d', strtotime($data->from_date));
		$to_date = date('Y-m-d', strtotime($data->to_date));
		$leave_data = array(
			'from_date'=>$from_date,
			'to_date'=>$to_date,
			'remark'=>$data->remark,
			'updated_date'=>savedate(),                  
		);
		$this->db->set($leave_data);
		$this->db->where('leave_id',$data->leave_id); 
		$this->db->update('user_leave'); 
		return ($this->db->affected_rows() == 1) ? true : false; 
	}

    }

    public function get_leave_list($userid)
    {
     	$arr = "leave_id,user_id,from_date,to_date,remark,leave_status,status";
	$this->db->select($arr);
	$this->db->from("user_leave");
	$this->db->where('user_id',$userid);
	$query= $this->db->get();
	if($this->db->affected_rows())
        {
            	return $query->result_array();
        }
        else
        {
        	return false;
        }
    }
    
    public function save_tour_plan($data)
    {
    	//pr($data); die;
        $datacount=0;
		foreach($data->tourdata as $key=>$value){
			if(date('D',strtotime($value->tour_date))!='Sun'){
				$result=get_holiday_details_data( $value->user_id,date('Y-m-d', strtotime($value->tour_date)));

				$leave=get_leaves_deatils($value->user_id,date('Y-m-d', strtotime($value->tour_date)));

				if(isset($value->source_city) && isset($value->dest_city) && $value->source_city!='' && $value->dest_city!='')
				{

					$tour_date = date('Y-m-d', strtotime($value->tour_date));

					if(isset($value->assign_by) && $value->assign_by!=0){
						$color="#f56954";
					}else{
						$color="#efb30e";
					}
					
					$tour_data = array(
						'source'=>$value->source_city,
						'destination'=>$value->dest_city,
						'remark'=>$value->remark,
						'dot'=>$tour_date,
						'crm_user_id'=> $value->user_id,
						'assign_by'=> isset($value->assign_by)?$value->assign_by:0,
						'created_date'=>savedate(),
						'updated_date'=>savedate(),                  
						'status'=>1, 
						'color_id'=>$color,
					);
					$this->db->insert('user_stp',$tour_data);
					$datacount++; 
				}
				elseif($result)
				{
					$tour_date = date('Y-m-d', strtotime($value->tour_date));
					$color="#167c2a";
					$tour_data = array(
						'source'=>$value->source_city,
						'destination'=>$value->dest_city,
						'remark'=>$value->remark,
						'dot'=>$tour_date,
						'crm_user_id'=> $value->user_id,
						'assign_by'=> isset($value->assign_by)?$value->assign_by:0,
						'created_date'=>savedate(),
						'updated_date'=>savedate(),                  
						'status'=>1, 
						'color_id'=>$color,
					);
					$this->db->insert('user_stp',$tour_data);
					$datacount++; 
				}

				else if($leave){
					$tour_date = date('Y-m-d', strtotime($value->tour_date));
					$color="#167c2a";
					$tour_data = array(
						'destination'=>$value->dest_city,
						'remark'=>$value->remark,
						'dot'=>$tour_date,
						'crm_user_id'=> logged_user_data(),
						'assign_by'=> $value->assign_by,
						'created_date'=>savedate(),
						'updated_date'=>savedate(),
						'status'=>1,
						'color_id'=>$color,
					);
					$this->db->insert('user_stp',$tour_data);
					$datacount++;
				}
			}

		}
		return true;
    
    }

    public function add_single_tour_plan($data){
		$tour_date=$data['date'];
		$dest_city=$data['dest_city'];
		$remarks=$data['remarks'];
		$assignby=$data['assignby'];
		$assignto=$data['assignto'];

		if(date('D',strtotime($tour_date))!='Sun'){
			$result=get_holiday_details_data($assignto,date('Y-m-d', strtotime($tour_date)));

			$leave=get_leaves_deatils($assignto,date('Y-m-d', strtotime($tour_date)));

			if($result=='' && $leave=='')
			{
				$tour_date = date('Y-m-d', strtotime($tour_date));
				if(isset($assignby) && $assignby!=0){
					$color="#f56954";
				}else{
					$color="#efb30e";
				}
				$tour_data = array(
					'destination'=>$dest_city,
					'remark'=>$remarks,
					'dot'=>$tour_date,
					'crm_user_id'=> $assignto,
					'assign_by'=> isset($assignby)?$assignby:0,
					'created_date'=>savedate(),
					'updated_date'=>savedate(),
					'status'=>1,
					'color_id'=>$color,
				);
				$this->db->insert('user_stp',$tour_data);
			}
			else if($result)
			{
				$tour_date = date('Y-m-d', strtotime($tour_date));
				$color="#167c2a";
				$tour_data = array(
					'destination'=>$dest_city,
					'remark'=>$remarks,
					'dot'=>$tour_date,
					'crm_user_id'=> $assignto,
					'assign_by'=> isset($assignby)?$assignby:0,
					'created_date'=>savedate(),
					'updated_date'=>savedate(),
					'status'=>1,
					'color_id'=>$color,
				);
				$this->db->insert('user_stp',$tour_data);
			}

			else if($leave){
				$tour_date = date('Y-m-d', strtotime($tour_date));
				$color="#f50505";
				$tour_data = array(
					'destination'=>$dest_city,
					'remark'=>$remarks,
					'dot'=>$tour_date,
					'crm_user_id'=> $assignto,
					'assign_by'=> isset($assignby)?$assignby:0,
					'created_date'=>savedate(),
					'updated_date'=>savedate(),
					'status'=>1,
					'color_id'=>$color,
				);
				$this->db->insert('user_stp',$tour_data);
			}
		}
		return true;

	}

	public function planned_city($data){
    	$col='id, destination, dot, remark, assign_by, is_approved';
		$this->db->select($col);
		$this->db->from('user_stp');
		$this->db->where('crm_user_id',$data['user_id']);
		$this->db->where('dot',$data['doi']);
		$query= $this->db->get();
//echo $ci->db->last_query(); die;
		if($this->db->affected_rows()){
			$city_name=get_city_name($query->row()->destination);
			$dataArr=array(
				'city_id' => $query->row()->destination,
				'city_name' => $city_name
			);
			return $dataArr;
		}
		else{
			return FALSE;
		}

	}

       
}

