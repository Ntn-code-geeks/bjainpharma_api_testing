<?php



/* 

 * Niraj Kuamr

 * Dated: 20-02-2018

 * 

 * model for doctor details 

 */



class City_model extends CI_Model {
	public function insertCity($data)
	{
		$this->db->insert('city', $data);
		return TRUE;
	}

	public function update_navigation($data)
	{
		/* pr($data); die; */
		if($data['visited']==1)//doctor
		{
			$arr = "id";
			$this->db->select($arr);
			$this->db->from("doctor_list");
			$this->db->order_by("id",'asc');
			$query = $this->db->get();
			if($this->db->affected_rows()){
				$docIds=$query->result_array();
				foreach($docIds as $id)
				{

					//echo $id['id'].'----'.$data['navigate_id']++; 

					$updateData = array(

					   'doc_navigate_id'=>$data['navigate_id']

					);

					$this->db->where('id', $id['id']);

					$this->db->update('doctor_list', $updateData);

					$data['navigate_id']++; 

				}

				return TRUE;;

			}

			else{

				return FALSE;

			}

		}

		elseif($data['visited']==2)//Dealer

		{

			$arr = "dealer_id";

			$this->db->select($arr);

			$this->db->from("dealer");

			$this->db->order_by("dealer_id",'asc');

			$query = $this->db->get();

			if($this->db->affected_rows()){

				$docIds=$query->result_array();

			

				foreach($docIds as $id)

				{

					$updateData = array(

					   'doc_navigate_id'=>$data['navigate_id']

					);

					$this->db->where('dealer_id', $id['dealer_id']);

					$this->db->update('dealer', $updateData);

					$data['navigate_id']++; 

				}

				return TRUE;;

			}

			else{

				return FALSE;

			}

		}

		elseif($data['visited']==3)//Pharamacy

		{	$arr = "id";

			$this->db->select($arr);

			$this->db->from("pharmacy_list");

			$this->db->order_by("id",'asc');

			$query = $this->db->get();

			if($this->db->affected_rows()){

				$docIds=$query->result_array();

			

				foreach($docIds as $id)

				{

					$updateData = array(

					   'doc_navigate_id'=>$data['navigate_id']

					);

					$this->db->where('id', $id['id']);

					$this->db->update('pharmacy_list', $updateData);

					$data['navigate_id']++; 

				}

				return TRUE;;

			}

			else{

				return FALSE;

			}

		}

	}

	

	public function get_last_city()

	{

		$col='city_id,city_name';

		$this->db->select($col);

		$this->db->from('city');

		$this->db->order_by('city_id','desc');

		$query= $this->db->get(); 

		if($this->db->affected_rows()){

			return $query->row()->city_name;

		}	

		else{

			return '';

		}

	}

	

	public function get_last_city_state()

	{

		$col='city_id,state_id';

		$this->db->select($col);

		$this->db->from('city');

		$this->db->order_by('city_id','desc');

		$query= $this->db->get(); 

		if($this->db->affected_rows()){

			return $query->row()->state_id;

		}	

		else{

			return '';

		}

	}

	public function get_city_list(){
        $col='city.city_id,city.city_name,state.state_name,city.status';
        $this->db->select($col); 
        $this->db->from('city'); 
        $this->db->join("state","city.state_id=state.state_id");
        //$this->db->where('city.status',1);
        $query= $this->db->get(); 
        if($this->db->affected_rows()){
            return $query->result_array(); 
        }   
        else{
            return FALSE;
        }
    }

    public function get_state_list(){
        $col='state_id,state_name,status';
        $this->db->select($col); 
        $this->db->from('state'); 
        $this->db->where('status',1);
        $this->db->order_by('state_name','asc');
        $query= $this->db->get(); 
        if($this->db->affected_rows()){
            return json_encode($query->result_array()); 
        }   
        else{
            return FALSE;
        }
    }

    public function save_city($data){
        $city_data = array(
            'city_name'=>$data['city_name'],
            'state_id'=>$data['state'],
            'is_metro'=>$data['metro'],
            'added_date'=>savedate(),                  
            'status'=>1, 
        );
        $this->db->insert('city',$city_data); 
        return ($this->db->affected_rows() == 1) ? true : false; 
    }

    public function get_city_data($id){
        $col='city_id,city_name,is_metro,state_id';
        $this->db->select($col); 
        $this->db->from('city'); 
        $this->db->where('city_id',$id); 
        $query= $this->db->get(); 
        if($this->db->affected_rows()){
            return $query->row(); 
        }   
        else{
            return FALSE;
        }
    }

    public function edit_city_data($data){

        $city_data = array(
            'city_name'=>$data['city_name'],
            'state_id'=>$data['state'],
            'is_metro'=>$data['metro'],
            'added_date'=>savedate(),                  
            'status'=>1,                 
        );
        $this->db->set($city_data);
        $this->db->where('city_id',$data['city_id']); 
        $this->db->update('city'); 
        return ($this->db->affected_rows() == 1) ? true : false; 
    }

    public function update_city_pincode($data){
        $city_data = array(
            'city_pincode'=>$data['city_pincode'],
            'last_update'=>savedate(),                  
        );
        $this->db->set($city_data);
        $this->db->where('city_id',$data['city_code']); 
        $this->db->update('doctor_list'); 

        $city_data_pharma = array(
            'city_pincode'=>$data['city_pincode'],
            'last_update'=>savedate(),                  
        );
        $this->db->set($city_data_pharma);
        $this->db->where('city_id',$data['city_code']); 
        $this->db->update('pharmacy_list'); 

        $city_data_dealer = array(
            'city_pincode'=>$data['city_pincode'],
            'last_update'=>savedate(),                  
        );
        $this->db->set($city_data_dealer);
        $this->db->where('city_id',$data['city_code']); 
        $this->db->update('dealer'); 


        $city_data_user = array(
            'hq_city_pincode'=>$data['city_pincode'],
            'last_update'=>savedate(),                  
        );
        $this->db->set($city_data_user);
        $this->db->where('hq_city',$data['city_code']); 
        $this->db->update('pharma_users'); 

        return true; 
    }

    public function disabled_city($id){
		$city_data = array(
			'status'=>0,
		);
		$this->db->set($city_data);
		$this->db->where('city_id',$id); 
		$this->db->update('city'); 
		if($this->db->affected_rows()){
			return TRUE; 
		}	
		else{
            return FALSE;
        }
    }

    public function enable_city($id){
		$city_data = array(
			'status'=>1,
		);
		$this->db->set($city_data);
		$this->db->where('city_id',$id); 
		$this->db->update('city'); 
		if($this->db->affected_rows()){
			return TRUE; 
		}	
		else{
            return FALSE;
        }
    }
}