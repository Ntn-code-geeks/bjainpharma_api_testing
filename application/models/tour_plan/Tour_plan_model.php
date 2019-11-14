<?php



/* 

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */



class Tour_plan_model extends CI_Model {



    

    public function get_city(){

       /*  $arr = "user_city_id";

        $this->db->select($arr);

        $this->db->from("pharma_users");

        $this->db->where('id',logged_user_data());

        $query = $this->db->get();

        if($this->db->affected_rows()){

			$cityList=$query->row()->user_city_id;

			$arr = "city_id,city_name";

			$this->db->select($arr);

			$this->db->from("city");

			$this->db->where_in('city_id', explode(',',$cityList));

			$queryCity = $this->db->get();

			if($this->db->affected_rows()){

				return $queryCity->result_array();

			}

			else{

				return FALSE;

			}

        }

        else{

            return FALSE;

        } */

		

	

		$arr = "source_city ,dist_city";

		$this->db->distinct();

        $this->db->select($arr);

        $this->db->from("master_tour_data");

        $this->db->where('pharma_user_id',logged_user_data());

        $query = $this->db->get();

        if($this->db->affected_rows()){
	

			foreach($query->result_array() as $cityData)

			{

				$city[]=array('id'=>$cityData['source_city']);

				$city[]=array('id'=>$cityData['dist_city']);

			}

			return array_unique($city, SORT_REGULAR);

		}

        else{

            return FALSE;

        }

		

    }


	public function save_assign_tour_data($data){
		$users=implode(',', $data['user_id']);
		$tour_date = date('Y-m-d', strtotime($data['meeting_date']));
		$tour_data = array(
			'destination'=>$data['city_to'],
			'remark'=>$data['remark'],
			'user_ids'=>$users,
			'tour_date'=>$tour_date,
			'assign_by'=> logged_user_data(),
			'created_date'=>savedate(),                  
			'updated_date'=>savedate(),                  
			'status'=>1, 
		);
		$this->db->insert('assign_tour',$tour_data); 
		return ($this->db->affected_rows() == 1) ? true : false; 
    }
    

	public function add_tour($data){
		$tour_date = date('Y-m-d', strtotime($data['tour_date']));
		$tour_st_time = date('H:i:s', strtotime($data['tour_st_time']));
		$tour_time_end = date('H:i:s', strtotime($data['tour_time_end']));
		$cityData=$this->check_city_path($data);
		if($cityData)
		{
			$cityDistance=$cityData->distance;
			$cityFare=$cityData->fare;
		}
		else
		{
			$cityDistance=0;
			$cityFare=0;
		}
		$color="#f56954";
		$tour_data = array(
			'source'=>$data['source_city'],
			'destination'=>$data['dest_city'],
			'remark'=>$data['remark'],

			'dot'=>$tour_date,

			'tst'=>$tour_st_time,

			'tet'=>$tour_time_end,

			'crm_user_id'=> logged_user_data(),

			'total_fare'=> $cityFare,

			'total_distance'=> $cityDistance,

			'created_date'=>savedate(),                  

			'updated_date'=>savedate(),                  

			'status'=>1, 

			'color_id'=>$color,

		);
		$this->db->insert('user_stp',$tour_data); 
		return ($this->db->affected_rows() == 1) ? true : false; 
    }

    public function add_bulk_tour($data){

    	$datacount=0;
		foreach($data['tour_time_end'] as $key=>$value){
			if(date('D',strtotime($data['tour_date'][$key]))!='Sun')
			{
				$result=get_holiday_details( date('Y-m-d', strtotime($data['tour_date'][$key])));
				if($data['source_city'][$key]!='' && $data['dest_city'][$key]!='')
				{
					$tour_date = date('Y-m-d', strtotime($data['tour_date'][$key]));
					$tour_st_time = date('H:i:s', strtotime($data['tour_st_time'][$key]));
					$tour_time_end = date('H:i:s', strtotime($data['tour_time_end'][$key]));
					$cityData=$this->check_city_path_bulk($data['source_city'][$key],$data['dest_city'][$key]);
					if($cityData)
					{
						$cityDistance=$cityData->distance;
						$cityFare=$cityData->fare;
					}
					else
					{
						$cityDistance=0;
						$cityFare=0;
					}
					if($data['assign_by'][$key]!=0)
					{
						$color="#f56954";
					}
					else
					{
						$color="#efb30e";
					}
					
					$tour_data = array(
						'source'=>$data['source_city'][$key],
						'destination'=>$data['dest_city'][$key],
						'remark'=>$data['remark'][$key],
						'dot'=>$tour_date,
						'tst'=>$tour_st_time,
						'tet'=>$tour_time_end,
						'crm_user_id'=> logged_user_data(),
						'assign_by'=> $data['assign_by'][$key],
						'total_fare'=> $cityFare,
						'total_distance'=> $cityDistance,
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
					$tour_date = date('Y-m-d', strtotime($data['tour_date'][$key]));
					$tour_st_time = date('H:i:s', strtotime($data['tour_st_time'][$key]));
					$tour_time_end = date('H:i:s', strtotime($data['tour_time_end'][$key]));
					$cityDistance=0;
					$cityFare=0;
					$color="#167c2a";
					$tour_data = array(
						'source'=>$data['source_city'][$key],
						'destination'=>$data['dest_city'][$key],
						'remark'=>$data['remark'][$key],
						'dot'=>$tour_date,
						'tst'=>$tour_st_time,
						'tet'=>$tour_time_end,
						'crm_user_id'=> logged_user_data(),
						'assign_by'=> $data['assign_by'][$key],
						'total_fare'=> $cityFare,
						'total_distance'=> $cityDistance,
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
		return $datacount; 
    }
	

	public function save_tour_data($data){
		$tour_data = array(
			'source_city'=>$data['city_from'],
			'dist_city'=>$data['city_to'],
			'fare'=>$data['city_fare'],
			'distance'=>$data['city_distance'],
			'pharma_user_id'=>$data['user_id'],
			'remark'=>$data['remark'],
			'crm_user_id'=> logged_user_data(),
			'created_date'=>savedate(),                  
			'updated_date'=>savedate(),                  
			'status'=>1, 
		);
		$this->db->insert('master_tour_data',$tour_data); 
		return ($this->db->affected_rows() == 1) ? true : false; 
    }	

	

	public function save_tour_data_edit($data){
		$tour_data = array(
			'source_city'=>$data['city_from'],
			'dist_city'=>$data['city_to'],
			'fare'=>$data['city_fare'],
			'distance'=>$data['city_distance'],
			'pharma_user_id'=>$data['user_id'],
			'remark'=>$data['remark'],
			'crm_user_id'=> logged_user_data(),
			'updated_date'=>savedate(),                  
		);
		$this->db->where('tour_id',$data['tour_id']); 
		$this->db->update('master_tour_data',$tour_data); 
		return ($this->db->affected_rows() == 1) ? true : false; 
    }

	public function update_tour($data){
		$color="#f56954";
		if($data['visited'])
		{
			$color="#008d4c";
		}
		$tour_data = array(
			'updated_date'=>savedate(),                  
			'visited'=>$data['visited'], 
			'color_id'=>$color,
		);
		$this->db->where('id',$data['tour_id']);
		$this->db->update('user_stp',$tour_data);
		return ($this->db->affected_rows() == 1) ? true : false; 
    }

	public function tour_info(){
		$result = array();
		$arr = "*";
        $this->db->select($arr);
        $this->db->from("user_stp");
        $this->db->where('crm_user_id',logged_user_data());
        $query = $this->db->get();
        if($this->db->affected_rows()){
			$data=$query->result_array();
			foreach($data as $val){
				$title='';
				if($val['destination']==0)
				{
					$title='Holiday';
				}
				else
				{
					$title=$this->get_city_name($val['destination']);
				}
				if($val['assign_by']!=0)
				{
					$assign_by=get_user_name($val['assign_by']).' Sir';
				}
				else
				{
					$assign_by='';
				}
				$result[] = array(
					'title'=>$title,
					'start'=>$val['dot'].' '.$val['tst'],
					'end'=>$val['dot'].' '.$val['tet'],
					'backgroundColor'=>$val['color_id'],
					'description'=>$val['remark'],
					'time' =>date('h:i A', strtotime($val['tst'])),
					'endtime' =>date('h:i A', strtotime($val['tet'])),
					'visited'=>$val['visited'],
					'tour_id'=>$val['id'],
					'tour_now_date'=>date('d-m-Y',strtotime($val['dot'])),
					'assign_by'=>$assign_by,
					'source_city'=>$this->get_city_name($val['source']),
					'destination'=>$this->get_city_name($val['destination'])
				);	
			}
        }
        $arrtour = "*";
        $con='find_in_set('.logged_user_data().',user_ids)<>0';
        $this->db->select($arr);
        $this->db->from("assign_tour");
        $this->db->where($con);
        $query = $this->db->get();
       // echo $this->db->last_query();
       // die;
        if($this->db->affected_rows()){
			$data=$query->result_array();
			foreach($data as $val){
				$title='';
				$title=$this->get_city_name($val['destination']);
				$assign_by=get_user_name($val['assign_by']).' Sir';
				$result[] = array(
					'title'=>$title,
					'start'=>$val['tour_date'].' 00:00:00',
					'end'=>$val['tour_date'].' 23:59:59',
					'backgroundColor'=>'#f56954',
					'description'=>$val['remark'],
					'time' =>'',
					'endtime' =>'',
					'visited'=>'',
					'tour_id'=>'tour_date',
					'tour_now_date'=>date('d-m-Y',strtotime($val['tour_date'])),
					'assign_by'=>$assign_by,
					'source_city'=>'',
					'destination'=>$this->get_city_name($val['destination'])
				);	
			}
        }
        return json_encode($result); 
    }

	

	public function get_city_name($id){

		$arr = "city_name";

        $this->db->select($arr);

        $this->db->from("city");

        $this->db->where('city_id',$id);

        $query = $this->db->get();

        if($this->db->affected_rows()){

			return $query->row()->city_name;

		}

        else{

            return ' ';

        }

	}

	public function get_tour_list(){

		$arr = "*";

        $this->db->select($arr);

        $this->db->from("master_tour_data");

        $this->db->where('status',1);

        $query = $this->db->get();

        if($this->db->affected_rows()){

			return $query->result_array();

		}

        else{

            return FALSE;

        }

	}

	

	public function get_tour_data($id){

		$arr = "*";

        $this->db->select($arr);

        $this->db->from("master_tour_data");

        $this->db->where('tour_id',$id);

        $query = $this->db->get();

        if($this->db->affected_rows()){

			return $query->row();

		}

        else{

            return FALSE;

        }

	}

	public function check_city_path($data){
		//SELECT * FROM `master_tour_data` WHERE  (source_city=11 or dist_city=11) AND (source_city=46 or dist_city=46) AND pharma_user_id=28
		$con='(source_city='.$data['source_city'].' or dist_city='.$data['source_city'].') AND (source_city='.$data['dest_city'].' or dist_city='.$data['dest_city'].') AND status=1 AND pharma_user_id='.logged_user_data();
		$arr = "source_city ,dist_city, fare ,distance";
		$this->db->distinct();
        $this->db->select($arr);
        $this->db->from("master_tour_data");
        $this->db->where($con);
        $query = $this->db->get();
        if($this->db->affected_rows()){
			return $query->row();
		}
        else{
            return FALSE;
        }
	}

	public function check_city_path_bulk($source_city,$dest_city){

		//SELECT * FROM `master_tour_data` WHERE  (source_city=11 or dist_city=11) AND (source_city=46 or dist_city=46) AND pharma_user_id=28

		$con='(source_city='.$source_city.' or dist_city='.$source_city.') AND (source_city='.$dest_city.' or dist_city='.$dest_city.') AND status=1 AND pharma_user_id='.logged_user_data();

		$arr = "source_city ,dist_city, fare ,distance";

		$this->db->distinct();

        $this->db->select($arr);

        $this->db->from("master_tour_data");

        $this->db->where($con);

        $query = $this->db->get();

        if($this->db->affected_rows()){

			return $query->row();

		}

        else{

            return FALSE;

        }

	}

	

	public function get_user_tour($nextMonth){//it return only user data

		//SELECT DISTINCT crm_user_id FROM `user_stp` where month(dot)=02 

		//SELECT id FROM `pharma_users` WHERE id not in(28,29,30,31)

		//$con='status=1 and month(dot)='.$nextMonth;//uncomment this

		$con='month(dot)=02 and status=1';//comment this

		$arr = "crm_user_id";

		$this->db->distinct();

        $this->db->select($arr);

        $this->db->from("user_stp");

        $this->db->where($con);

        $query = $this->db->get();

        if($this->db->affected_rows()){

			$userList=$query->result_array();

			$user=array();

			foreach($userList as $key=>$val)

			{

				$user[$key]=$val['crm_user_id'];

			}

			array_push($user,29,28,32,23);//add more id for preventing mail

			$arr = "id,name,email_id";

			$this->db->select($arr);

			$this->db->from("pharma_users");

			$this->db->where('user_status', 1);

			$this->db->where_not_in('id', $user);

			$queryCity = $this->db->get();

			if($this->db->affected_rows()){

				return $queryCity->result_array();

			}

			else{

				return FALSE;

			}

			

		}

        else{

            return FALSE;

        }

		

	}

	

	public function getBoss($id='')// return user boss list
	{
		$results[]=array();
		$this->db->select('user_id,boss_id');
        $this->db->from('user_bossuser_relation');
        $this->db->where('user_id',$id);
		$query= $this->db->get();   
        if($query->num_rows() > 0)
        {
            $userData=$query->result_array();
			foreach($userData as $key => $value)
			{
				$this->db->select('id,name,	user_phone,email_id');
				$this->db->from('pharma_users');
				$this->db->where('id',$value['boss_id']);
				$this->db->where('user_status',1);
				$query1= $this->db->get(); 
				if($query1->num_rows() > 0){
					$userBoss=$query1->row();
					$results[$key]["id"] = $userBoss->id;  
					$results[$key]["name"] =$userBoss->name;  
					$results[$key]["email_id"] = $userBoss->email_id;  
				}				
			}
			return $results;
        }
        else
        {
            return FALSE;
        }
	}

	public function send_email_boss($name)// return user with his boss list
	{
		$sender='';
		$subject="TP Reminder Mail";
		$sms='Today last date of Tour Plan update in Bjain Corp Software but till the date Mr.'.$name. 'is not update our Tour Plan. They Received Reminder From our side for last 3 days and 2 Reminder but still he did not update our Tour Plan. ';
		$message='<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="'.base_url().'/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  <h3>Dear Sir,</h3> <p>Greeting Of the day!!</p><p>'.$sms.'</p><p>Please recommend to him to upload our tour plan in Bjain Software for Next month Working.</p><p><i>This is an auto generated email.</i></p><div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">Bjain reminder team</p></div></div></body></html>';
		$userList=$this->get_user_tour($nextMonth);
		if($userList)
		{
			foreach($userList as $user)
			{
				$boss=$this->getBoss($user['id']);
				if($boss)
				{
					foreach($boss as $bossdata)
					{
						/* $userList[]=array(
							"id" => $bossdata['id'],
							"name" =>$bossdata['name'],  
							"email_id" => $bossdata['email_id']  
						); */
						send_email($bossdata['email_id'], $sender,$subject, $message);
					}
				}
			}
		}
		else
		{
			return FALSE;
		}
	}

	public function send_email_admin($name)// return user with his boss list
	{
		$sender='';
		$subject="TP Reminder Mail For HO";
		$sms='This mail purpose to informing you Mr.'.$name.'are not updating our tour plan till now in Bjain corp. Software.';
		$message='<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="'.base_url().'/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  <h3>Dear Sir,</h3> <p>Greeting Of the day!!</p><p>'.$sms.'</p><p><i>This is an auto generated email.</i></p><div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">Bjain reminder team</p></div></div></body></html>';
		$this->db->select('id,name,	user_phone,email_id');
		$this->db->from('pharma_users');
		$this->db->where('id',28);
		$this->db->where('user_status',1);
		$query= $this->db->get(); 
		if($this->db->affected_rows())
		{
			$userBoss=$query->row();
			send_email($userBoss->email_id,$sender, $subject, $message);
		}	
	}	

	public function save_bulk_tourdata($data)
	{
		$this->db->insert('master_tour_data', $data);
		return TRUE;
	}

	public function get_tour_dest($data)
	{
		$doi = date('Y-m-d', strtotime($data['doi']));
		$this->db->select('destination');
		$this->db->from('user_stp');
		$this->db->where('dot',$doi);
		$this->db->where('crm_user_id',logged_user_data());
		$query= $this->db->get(); 
		if($query->num_rows() > 0){
			return get_city_name($query->row()->destination);
		}
		return false;
	}
}
?>