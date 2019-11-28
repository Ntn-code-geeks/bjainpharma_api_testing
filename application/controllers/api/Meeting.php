<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/*

 */



class Meeting extends REST_Controller {
    function __construct() {
    // Construct the parent class
        parent::__construct();
        $this->load->model('api/meeting_api_model','meet');
    
    }
     
    function meeting_master_get()
    {
        # initialize variables
	$msg = '';
       	if ($msg == '') 
        {
	        $data = $this->meet->get_meeting_list();
		if ($data!=FALSE) 
		{ 
	            $result = array(
	                'Data' => $data,
			// 'Status' => true,
	                'Message' => 'Successfully',
	                'Code' => 200
	            );
	        }
	        else 
	        {
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'No Product',
	                'Code' => 404
	            );
	        }
        }
        else 
        {
            $result = array(
                'Data' => new stdClass(),
                'Status' => false,
                'Message' => $msg,
                'Code' => 404
            );
        }
        $this->response($result);
    }
    
    function meeting_list_get()
    {
        # initialize variables
	$msg = '';
	$userid  = $this->get('userid');
        if(!(isset($userid)&& !empty($userid)))
        {
        	$msg='User Id is required.';
        }
       	if ($msg == '') 
        {
	        $data = $this->meet->get_meeting_details($userid);
		if ($data!=FALSE) 
		{ 
	            $result = array(
	                'Data' => $data,
			// 'Status' => true,
	                'Message' => 'Successfully',
	                'Code' => 200
	            );
	        }
	        else 
	        {
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'No Meeting',
	                'Code' => 404
	            );
	        }
        }
        else 
        {
            $result = array(
                'Data' => new stdClass(),
                'Status' => false,
                'Message' => $msg,
                'Code' => 404
            );
        }
        $this->response($result);
    }
  
    function add_meeting_post()
    {
        # initialize variables
	$msg = '';
	$meeting_data=json_decode($this->input->raw_input_stream);
        if (!isset($meeting_data->meeting_type) || empty($meeting_data->meeting_type))
        {
	   $msg = 'Please enter meeting type';
	}
	elseif(!isset ($meeting_data->meeting_date) || empty($meeting_data->meeting_date))
	{
		$msg = 'Please Enter Meeting date.';
	}
	elseif(!check_leave($meeting_data->meeting_date,$meeting_data->user_id))
	{
		$msg = 'You have taken leave  or holiday on that day please change date!!';
	}
	elseif(!isset ($meeting_data->meeting_place) || empty($meeting_data->meeting_place))
	{
	   $msg = 'Please Enter Meeting Place';
	}

	elseif(!isset ($meeting_data->user_id) || empty($meeting_data->user_id))
	{
	   $msg = 'Please Enter User Id';
	}
	//die;
       	if ($msg == '') 
        {
	        $data = $this->meet->save_meeting($meeting_data);
		if ($data!=FALSE) 
		{ 
	            $result = array(
	                'Data' => $data,
			// 'Status' => true,
	                'Message' => 'Meeting save successfully',
	                'Code' => 200
	            );
	        }
	        else 
	        {
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'Error in Save Meeting info.',
	                'Code' => 404
	            );
	        }
        }
        else 
        {
            $result = array(
                'Data' => new stdClass(),
                'Status' => false,
                'Message' => $msg,
                'Code' => 404
            );
        }
        $this->response($result);
    }
    
    function sync_meeting_post()
    {
        # initialize variables
	
	$meeting=json_decode($this->input->raw_input_stream);
	foreach($meeting->data as $meeting_data)
	{
	        if (!isset($meeting_data->meeting_type) || empty($meeting_data->meeting_type))
	        {
		   $msg = 'Please enter meeting type';
		}

		elseif(!isset ($meeting_data->meeting_place) || empty($meeting_data->meeting_place))
		{
		   $msg = 'Please Enter Meeting Place';
		}
		elseif(!isset ($meeting_data->meeting_date) || empty($meeting_data->meeting_date))
		{
			$msg = 'Please Enter Meeting date.';
		}
		elseif(!check_leave($meeting_data->meeting_date,$meeting_data->user_id))
		{
			$msg = 'You have taken leave  or holiday on that day please change date!!';
		}
		elseif(!isset ($meeting_data->user_id) || empty($meeting_data->user_id))
		{
		   $msg = 'Please Enter User Id';
		}
		//die;

	       	if ($msg == '') 
	        {
		        $data = $this->meet->save_meeting($meeting_data);
	        }
        }
        $result = array(
	        'Data' => $data,
		// 'Status' => true,
	        'Message' => 'Meeting save successfully',
	        'Code' => 200
	    );
        $this->response($result);
    }
    
    function add_leave_post()
    {
        # initialize variables
	$msg = '';
	$leave_data=json_decode($this->input->raw_input_stream);
        if (!isset($leave_data->from_date) || empty($leave_data->from_date))
        {
	   $msg = 'Please enter from date';
	}
	elseif(!check_inteaction($leave_data->from_date,$leave_data->from_date,$leave_data->user_id))
	{
		$msg = 'You filled interaction on this day';
	}
	elseif(!isset ($leave_data->to_date) || empty($leave_data->to_date))
	{
	   $msg = 'Please enter to date';
	}
	elseif(!isset ($leave_data->user_id) || empty($leave_data->user_id))
	{
	   $msg = 'Please Enter User Id';
	}
	//die;
       	if ($msg == '') 
        {
	        $data = $this->meet->save_leave($leave_data);
		if ($data!=FALSE) 
		{ 
	            $result = array(
	                'Data' => $data,
			// 'Status' => true,
	                'Message' => 'Leave save successfully',
	                'Code' => 200
	            );
	        }
	        else 
	        {
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'Error in save leave info.',
	                'Code' => 404
	            );
	        }
        }
        else 
        {
            $result = array(
                'Data' => new stdClass(),
                'Status' => false,
                'Message' => $msg,
                'Code' => 404
            );
        }
        $this->response($result);
    }
    
    function sync_leave_post()
    {
        # initialize variables
	
	$leave=json_decode($this->input->raw_input_stream);
	foreach($leave->data as $leave_data)
	{
	        if (!isset($leave_data->from_date) || empty($leave_data->from_date))
	        {
		   $msg = 'Please enter from date';
		}
		elseif(!check_inteaction($leave_data->from_date,$leave_data->from_date,$leave_data->user_id))
		{
			$msg = 'You filled interaction on this day';
		}
		elseif(!isset ($leave_data->to_date) || empty($leave_data->to_date))
		{
		   $msg = 'Please enter to date';
		}
		elseif(!isset ($leave_data->user_id) || empty($leave_data->user_id))
		{
		   $msg = 'Please Enter User Id';
		}

	       	if ($msg == '') 
	        {
		        $data = $this->meet->save_leave($leave_data);
	        }
        }
        $result = array(
	        'Data' => $data,
		// 'Status' => true,
	        'Message' => 'Leave save successfully',
	        'Code' => 200
	    );
        $this->response($result);
    }
    
    function monthly_assign_tasks_post()
    {
        # initialize variables
	$msg = '';
	$tour_data=json_decode($this->input->raw_input_stream);
        if (!isset($tour_data->month) || empty($tour_data->month))
        {
	   $msg = 'Please enter month';
	}
	elseif(!isset($tour_data->year) || empty($tour_data->year))
	{
		$msg = 'Please enter year';
	}
	elseif(!isset ($tour_data->user_id) || empty($tour_data->user_id))
	{
		$msg = 'Please Enter User Id';
	}
       	if ($msg == '') 
        {
        	$year=$tour_data->year;
        	$month=$tour_data->month;
        	$userid=$tour_data->user_id;
        	$lastday = date("t", strtotime($month));
        	$start_date =$year.'-'.$month.'-01';
		$end_date = $year.'-'.$month.'-'.$lastday;
	        $data['holiiday'] = get_holiday_data($userid,$start_date,$end_date);
   	        $data['assign_task']  = get_assign_task_by($userid,$start_date,$end_date);
	        $data['follow_data']  = get_followup_data($userid,$start_date,$end_date);
		if ($data!=FALSE) 
		{ 
	            $result = array(
	                'Data' => $data,
			// 'Status' => true,
	                'Message' => 'Successfully',
	                'Code' => 200
	            );
	        }
	        else 
	        {
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'No Leave',
	                'Code' => 404
	            );
	        }
        }
        else 
        {
            $result = array(
                'Data' => new stdClass(),
                'Status' => false,
                'Message' => $msg,
                'Code' => 404
            );
        }
        $this->response($result);
    }

	function leave_list_get()
	{
		# initialize variables
		$msg = '';
		$userid  = $this->get('userid');
		if(!(isset($userid)&& !empty($userid)))
		{
			$msg='User Id is required.';
		}
		if ($msg == '')
		{
			$data = $this->meet->get_leave_list($userid);
			if ($data!=FALSE)
			{
				$result = array(
					'Data' => $data,
					// 'Status' => true,
					'Message' => 'Successfully',
					'Code' => 200
				);
			}
			else
			{
				$result = array(
					'Data' => new stdClass(),
					'Status' => false,
					'Message' => 'No Leave',
					'Code' => 404
				);
			}
		}
		else
		{
			$result = array(
				'Data' => new stdClass(),
				'Status' => false,
				'Message' => $msg,
				'Code' => 404
			);
		}
		$this->response($result);
	}
    
    function monthly_tp_post()
    {
        # initialize variables

		$post= array_map('trim', $this->input->post());
		$msg ='';
		$item=array();
		if (!isset($post['month'])) {
			$msg = 'Please enter month';
		}
		elseif(!isset ($post['year'])){
			$msg = 'Please enter year';
		}
		elseif(!isset ($post['user_id'])){
			$msg = 'Please Enter User Id';
		}



       	if ($msg == '') 
        {
        	$year=$post['year'];
        	$month=$post['month'];
        	$userid=$post['user_id'];
        	$lastday = date("t", strtotime($month));
        	$start_date =$year.'-'.$month.'-01';
			$end_date = $year.'-'.$month.'-'.$lastday;
	        $data['holiday'] = get_holiday_data($userid,$start_date,$end_date);
   	        $data['assign_task']  = get_assign_task_by($userid,$start_date,$end_date);
	        $data['follow_data']  = get_followup_data($userid,$start_date,$end_date);
	        $data['leave_data']  = get_leaves_inmonth($userid,$start_date,$end_date);

		if ($data!=FALSE)
		{ 
	            $result = array(
	                'Data' => $data,
			// 'Status' => true,
	                'Message' => 'Successfully',
	                'Code' => 200
	            );
	        }
	        else 
	        {
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'No Leave',
	                'Code' => 404
	            );
	        }
        }
        else 
        {
            $result = array(
                'Data' => new stdClass(),
                'Status' => false,
                'Message' => $msg,
                'Code' => 404
            );
        }
        $this->response($result);
    }

    function tp_list_monthly_post(){
		$post= array_map('trim', $this->input->post());
		$msg ='';
		$item=array();
		if (!isset($post['user_id'])) {
			$msg = 'Please enter User ID';
		}
		else if(!isset ($post['year_month'])){
			$msg = 'Please enter Year-Month';
		}
		if ($msg == '')
		{
			$year_month=$post['year_month'];
			$userid=$post['user_id'];
			$data['Monthly_TP']  = get_tour_info($userid,$year_month);
//			pr($data['Monthly_TP']); die;
			if ($data!=FALSE)
			{
				$result = array(
					'Data' => $data,
					// 'Status' => true,
					'Message' => 'Successfully',
					'Code' => 200
				);
			}
			else
			{
				$result = array(
					'Data' => new stdClass(),
					'Status' => false,
					'Message' => 'No Data Found For this Parameters.',
					'Code' => 404
				);
			}
		}
		else
		{
			$result = array(
				'Data' => new stdClass(),
				'Status' => false,
				'Message' => $msg,
				'Code' => 404
			);
		}
		$this->response($result);

	}

	function add_tp_post()
	{
		# initialize variables
		$msg = '';
		$tp_data=json_decode($this->input->raw_input_stream);
		if($msg == ''){
			$data = $this->meet->save_tour_plan($tp_data);
			if($data!=FALSE){
				$result = array(
					'Data' => $data,
					// 'Status' => true,
					'Message' => 'Tour Plan successfully',
					'Code' => 200
				);
			}
			else{
				$result = array(
					'Data' => new stdClass(),
					'Status' => false,
					'Message' => 'Error in Save Tour Plan.',
					'Code' => 404
				);
			}
		}
		else{
			$result = array(
				'Data' => new stdClass(),
				'Status' => false,
				'Message' => $msg,
				'Code' => 404
			);
		}
		$this->response($result);
	}

	function single_tour_plan_post(){
		# initialize variables
		$post= array_map('trim', $this->input->post());
		$msg ='';
		$data=array();
		if (!isset($post['date'])) {    /*Date : DD-MM-YYYY*/
			$msg = 'Please enter Tour Date';
		}
		elseif(!isset ($post['city'])){
			$msg = 'Please enter Tour City';
		}
		elseif(!isset ($post['remarks'])){
			$msg = 'Please Enter Remarks';
		}
		elseif(!isset ($post['assignby'])){
			$msg = 'Please Enter Assigned By';
		}
		elseif(!isset ($post['assignto'])){
			$msg = 'Please Enter Assigned To';
		}

		/*In this case Assigned to & Assigned by  Have same userID because the person who's TP was opened was self assigning him or Updating TP. */

		if($msg == ''){
			$data['date']=$post['date'];
			$data['dest_city']=$post['city'];
			$data['remarks']=$post['remarks'];
			$data['assignby']=$post['assignby'];
			$data['assignto']=$post['assignto'];
			$data = $this->meet->add_single_tour_plan($data);
			if($data!=FALSE){
				$result = array(
					'Data' => $data,
					// 'Status' => true,
					'Message' => 'Tour Plan Saved successfully',
					'Code' => 200
				);
			}
			else{
				$result = array(
					'Data' => new stdClass(),
					'Status' => false,
					'Message' => 'Error in Save Tour Plan.',
					'Code' => 404
				);
			}
		}
		else{
			$result = array(
				'Data' => new stdClass(),
				'Status' => false,
				'Message' => $msg,
				'Code' => 404
			);
		}
		$this->response($result);
	}

	function month_dates_get(){
		$start_date =date('Y-m-d',strtotime('first day of +1 month'));
		$end_date = date('Y-m-d',strtotime('last day of +1 month'));
		$tdate=array();
		while (strtotime($start_date) <= strtotime($end_date)){
			if(date('D',strtotime($start_date))!='Sun'){
				$tdate[]= date ("Y-m-d", strtotime($start_date));
			}else{
				$tdate[]= date ("Y-m-d", strtotime($start_date)).'-'.date('D',strtotime($start_date));
			}
			$start_date = date ("Y-m-d", strtotime("+1 day", strtotime($start_date)));
		}

		if (!empty($tdate)){
			$result = array(
				'Data' => $tdate,
				// 'Status' => true,
				'Message' => 'Successfully',
				'Code' => 200
			);
		}
		else
		{
			$result = array(
				'Data' => new stdClass(),
				'Status' => false,
				'Message' => 'No Dates Found',
				'Code' => 404
			);
		}
		$this->response($result);
	}

	function assign_tp_post(){
		# initialize variables
		$post= array_map('trim', $this->input->post());
		$msg ='';
		$data=array();
		if (!isset($post['date'])) {    /*Date : DD-MM-YYYY*/
			$msg = 'Please enter Tour Date';
		}
		elseif(!isset ($post['city'])){
			$msg = 'Please enter Tour City';
		}
		elseif(!isset ($post['remarks'])){
			$msg = 'Please Enter Remarks';
		}
		elseif(!isset ($post['assignby'])){
			$msg = 'Please Enter Assigned By - UserID';
		}
		elseif(!isset ($post['assignto'])){
			$msg = 'Please Enter Assigned To - UserID';
		}

		/*In this case Assigned to & Assigned by  Has to be different userID because the person assigning him was his managers. */

		if($msg == ''){
			$data['date']=$post['date'];
			$data['dest_city']=$post['city'];
			$data['remarks']=$post['remarks'];
			$data['assignby']=$post['assignby'];
			$data['assignto']=$post['assignto'];
			$data = $this->meet->add_single_tour_plan($data);
			if($data!=FALSE){
				$result = array(
					'Data' => $data,
					// 'Status' => true,
					'Message' => 'Tour Plan Assigned successfully',
					'Code' => 200
				);
			}
			else{
				$result = array(
					'Data' => new stdClass(),
					'Status' => false,
					'Message' => 'Error in Save Tour Plan.',
					'Code' => 404
				);
			}
		}
		else{
			$result = array(
				'Data' => new stdClass(),
				'Status' => false,
				'Message' => $msg,
				'Code' => 404
			);
		}
		$this->response($result);
	}

	function planned_city_post(){
		# initialize variables
		$post= array_map('trim', $this->input->post());
		$msg ='';
		$data=array();
		if (!isset($post['doi'])) {    /*Date : DD-MM-YYYY*/
			$msg = 'Please enter Date of Interaction';
		}
		elseif(!isset ($post['user_id'])){
			$msg = 'Please enter UserID';
		}

		if($msg == ''){
			$data['doi']=$post['doi'];   /* date format: yyyy-mm-dd */
			$data['user_id']=$post['user_id'];
			$data = $this->meet->planned_city($data);
			if($data!=FALSE){
				$result = array(
					'Data' => $data,
					// 'Status' => true,
					'Message' => 'This Date was Planned for above City ID',
					'Code' => 200
				);
			}
			else{
				$result = array(
					'Data' => new stdClass(),
					'Status' => false,
					'Message' => 'No Tour Plan Found for this date.',
					'Code' => 404
				);
			}
		}
		else{
			$result = array(
				'Data' => new stdClass(),
				'Status' => false,
				'Message' => $msg,
				'Code' => 404
			);
		}
		$this->response($result);
	}

}

