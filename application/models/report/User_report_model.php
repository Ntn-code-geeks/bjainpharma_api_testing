<?php



/* 

 * Niraj Kumar

 * Dated: 06/03/2018

 * 

 * model for user report Travel Attandace Sheet

 */



class User_report_model extends CI_Model {



  

    public function get_travel_report($userid='',$start='',$end=''){

        $transit=array();

        $meeting=array();

        $arr = "tr.crm_user_id as user_name,tr.ticket_attachment as ticket_attachment,tr.bill_attachment as bill_attachment,tr.stay as stay,tr.source as source_city,tr.destination as destination_city,tr.transit_date as transit_date,tr.total_fare as fare,tr.total_fare as fare,tr.total_distance as total_distance,tr.transit_date as date";

        $this->db->select($arr);

        $this->db->from("user_transit tr");

      

		//$this->db->where('doc.doc_status',1);

        //if($userid > 0){

            $this->db->where('tr.crm_user_id',$userid);

       // }

        $this->db->where('tr.transit_date >=', $start);

        $this->db->where('tr.transit_date <=', $end);

        //$this->db->group_by('pid.doc_id'); 

		//$this->db->order_by("tr.transit_date", "asc");

        $query = $this->db->get();

		//  echo $this->db->last_query(); die;

        if($this->db->affected_rows()){

			$transit=$query->result_array();

	    }

		

		////Geting Meeting Data////

		

		$arr = "meet.crm_user_id as user_name,meet.meeting_type as meeting_type,meet.meeting_date as meeting_date,meet.meeting_place as meeting_place,meet.meeting_date as date";

        $this->db->select($arr);

        $this->db->from("user_meeting meet");

      

		//$this->db->where('doc.doc_status',1);

        //if($userid > 0){

            $this->db->where('meet.crm_user_id',$userid);

       // }

        $this->db->where('meet.meeting_date >=', $start);

        $this->db->where('meet.meeting_date <=', $end);

        //$this->db->group_by('pid.doc_id'); 

		//$this->db->order_by("meet.meeting_date", "asc");

        $queryMeeting = $this->db->get();

		//echo $this->db->last_query(); die;

        if($this->db->affected_rows()){

			$meeting=$queryMeeting->result_array();

        }

		$result=array_merge($transit,$meeting) ;

		/* pr($result);

		die; */

		/* $result=array('transit_info'=>$transit,'meeting_info'=>$meeting); 

		return $result; */

		//asort($result);

		$date = array();

		foreach ($result as $key => $row)

		{

			$date[$key] = $row['date'];

		}

		array_multisort($date, SORT_ASC, $result);

		return $result;

    }

	

	public function get_attendance_report($userid='',$start='',$end=''){
		$leave=array();
		$MonthSun=array();
		$holiday=array();
		$leaveDate=array();
		$inteactionDate=array();
		//$sundayDate1=array();
		$sundayDate=array();
		$range = [];
		$leaveNotApply=array();
		$workingday= array();//total working day
		$orgday= array();//working day after forget leave delete
		$docInteraction=array();
        $pharmaIntearction=array();
        $dealerIntearction=array();
        $meeting=array();
        //$transit=array();
        $arr = "doc.crm_user_id as user_name,doc.create_date as inteaction_date,doc.create_date as date";
		$this->db->distinct();
        $this->db->select($arr);
        $this->db->from("pharma_interaction_doctor doc");
		//$this->db->where('doc.doc_status',1);
        //if($userid > 0){
        $this->db->where('doc.crm_user_id',$userid);
       // }
        $this->db->where('doc.create_date >=', $start);
        $this->db->where('doc.create_date <=', $end);
        $query = $this->db->get();
        if($this->db->affected_rows()){
			$docInteraction=$query->result_array();
	    }

		/* Geting Pharma Interaction */
		$arr = "pharma.crm_user_id as user_name,pharma.create_date as inteaction_date,pharma.create_date  as date";
        $this->db->select($arr);
        $this->db->from("pharma_interaction_pharmacy pharma");
        $this->db->where('pharma.crm_user_id',$userid);
        $this->db->where('pharma.create_date  >=', $start);
	    $this->db->where('pharma.create_date  <=', $end);
        $queryIntearction = $this->db->get();
        if($this->db->affected_rows()){
			$pharmaIntearction=$queryIntearction->result_array();
        }
		
		/* Geting Dealer Interaction */
		$arr = "dealer.crm_user_id as user_name,dealer.create_date as inteaction_date,dealer.create_date  as date";
        $this->db->select($arr);
        $this->db->from("pharma_interaction_dealer dealer");
        $this->db->where('dealer.crm_user_id',$userid);
        $this->db->where('dealer.create_date  >=', $start);
        $this->db->where('dealer.create_date  <=', $end);
        $queryDealer = $this->db->get();
        if($this->db->affected_rows()){
			$dealerIntearction=$queryDealer->result_array();
        }

		/* Geting Transit Information  */
		/*$arr = "transit.crm_user_id as user_name,transit.transit_date as transit_date,transit.transit_date as date";
        $this->db->select($arr);
        $this->db->from("user_transit transit");
        $this->db->where('transit.crm_user_id',$userid);
        $this->db->where('transit.transit_date  >=', $start);
        $this->db->where('transit.transit_date  <=', $end);
		//$this->db->where('transit.transit_time_start  >=', '09:00:00');
        //$this->db->where('transit.transit_time_start  <=', '18:00:00');
        $queryTransit = $this->db->get();
        if($this->db->affected_rows()){
			$transit=$queryTransit->result_array();
        }*/

		/* Geting Meeting Information  */
		$arr = "meeting.crm_user_id as user_name,meeting.meeting_date as meeting_date,meeting.meeting_date as date";
        $this->db->select($arr);
        $this->db->from("user_meeting meeting");
        $this->db->where('meeting.crm_user_id',$userid);
        $this->db->where('meeting.meeting_date  >=', $start);
        $this->db->where('meeting.meeting_date  <=', $end);
        $queryMeeting = $this->db->get();
        if($this->db->affected_rows()){
			$meeting=$queryMeeting->result_array();
        }
		$resultData=array_merge($docInteraction,$pharmaIntearction,$dealerIntearction,$meeting) ;
		foreach($resultData as $dateData){
			$inteactionDate[]= substr($dateData['date'],0,10);
		}

		/* Geting Leave Information  */
		$arr = "leave.user_id as user_name,leave.from_date as from_date,leave.to_date as to_date,leave.from_date as date";
        $this->db->select($arr);
        $this->db->from("user_leave leave");
        $this->db->where('leave.leave_status',1);
	    $this->db->where('leave.user_id',$userid);
        $this->db->where('leave.from_date  >=', $start);
        $this->db->where('leave.to_date  <=', $end);
        $queryLeave = $this->db->get();
		//echo $this->db->last_query(); die;
        if($this->db->affected_rows()){
			$leave=$queryLeave->result_array();
        }
		foreach($leave as $lv)
		{
			$dayCount=(strtotime($lv['to_date'])-strtotime($lv['from_date']))/ 86400;
			$startDate=$lv['from_date'];
			$endXt1= date('Y-m-d', strtotime($lv['to_date'] . ' +1 day'));
			$endDate1= substr($endXt1, 0, 10);
			$begin1 = new DateTime($startDate);
			$end11 = new DateTime($endDate1);
			$interval1= new DateInterval('P1D'); // 1 Day
			$dateRange1 = new DatePeriod($begin1, $interval1, $end11);
			foreach ($dateRange1 as $date) {
				$leaveDate[] = $date->format('Y-m-d');
			}
		}

		/* All Date between Date Range */
		$startDate= substr($start, 0, 10);
		$endXt= date('Y-m-d H:i:s', strtotime($end . ' +1 day'));
		$endDate= substr($endXt, 0, 10);
		$begin = new DateTime($startDate);
		$end1 = new DateTime($endDate);
		$interval = new DateInterval('P1D'); // 1 Day
		$dateRange = new DatePeriod($begin, $interval, $end1);
		foreach ($dateRange as $date) {
			$range[] = $date->format('Y-m-d');
			$day = date('D', strtotime($date->format('Y-m-d')));
			if($day=='Sun')
			{
				$sundayDate[]=$date->format('Y-m-d');
				$MonthSun[]=array('date' =>$date->format('Y-m-d'),'day'=>'Sunday');
			}
		}

		$leaveSunday=array_merge($leaveDate,$sundayDate);
		$working=  array_diff($range, $leaveSunday);
		$interaction=array_unique($inteactionDate);
		$leaveNotApply=array_diff($working, $interaction);
		foreach($interaction as $wd)
		{
			$workingday[]=array('date' =>$wd,'day'=>'Working');
		} 
		foreach($leaveNotApply as $lv)
		{
			$leave[]=array('user_name' =>$userid,'from_date'=>$lv,'to_date'=>$lv,'date'=>$lv);
		}
		$result=array_merge($leave,$MonthSun,$workingday);
		$dateCom = array();
		foreach ($result as $key => $row)
		{
			$dateCom[$key] = $row['date'];
		} 
		array_multisort($dateCom, SORT_ASC, $result);
		return $result;
    }

    public function get_attendance_sheet_all($start='',$end=''){
    	$userids=array();
    	$result=array();
    	$arr = "id";
        $this->db->select($arr);
        $this->db->from("pharma_users user");
        $this->db->where('user_status',1);
        $this->db->order_by('name','ASC');
        $query_user = $this->db->get();
        if($this->db->affected_rows()){
			$userids=$query_user->result_array();
        }
        foreach($userids as $user)
        {
        	if($user['id']!=28 && $user['id']!=29 &&  $user['id']!=32 ){
        		$userid=$user['id'];
        		$leave=array();
				$MonthSun=array();
				$holiday=array();
				$leaveDate=array();
				$holidayDate=array();
				$inteactionDate=array();
				//$sundayDate1=array();
				$sundayDate=array();
				$range = [];
				$leaveNotApply=array();
				$workingday= array();//total working day
				$orgday= array();//working day after forget leave delete
				$docInteraction=array();
		        $pharmaIntearction=array();
		        $dealerIntearction=array();
		        $meeting=array();
		        //$transit=array();
		        $arr = "doc.crm_user_id as user_name,doc.create_date as inteaction_date,doc.create_date as date";
				$this->db->distinct();
		        $this->db->select($arr);
		        $this->db->from("pharma_interaction_doctor doc");
		        $this->db->where('doc.crm_user_id',$userid);
		        $this->db->where('doc.create_date >=', $start);
		        $this->db->where('doc.create_date <=', $end);
		        $query = $this->db->get();
		        if($this->db->affected_rows()){
					$docInteraction=$query->result_array();
			    }

				/* Geting Pharma Interaction */
				$arr = "pharma.crm_user_id as user_name,pharma.create_date as inteaction_date,pharma.create_date  as date";
		        $this->db->select($arr);
		        $this->db->from("pharma_interaction_pharmacy pharma");
		        $this->db->where('pharma.crm_user_id',$userid);
		        $this->db->where('pharma.create_date  >=', $start);
			    $this->db->where('pharma.create_date  <=', $end);
		        $queryIntearction = $this->db->get();
		        if($this->db->affected_rows()){
					$pharmaIntearction=$queryIntearction->result_array();
		        }
				
				/* Geting Dealer Interaction */
				$arr = "dealer.crm_user_id as user_name,dealer.create_date as inteaction_date,dealer.create_date  as date";
		        $this->db->select($arr);
		        $this->db->from("pharma_interaction_dealer dealer");
		        $this->db->where('dealer.crm_user_id',$userid);
		        $this->db->where('dealer.create_date  >=', $start);
		        $this->db->where('dealer.create_date  <=', $end);
		        $queryDealer = $this->db->get();
		        if($this->db->affected_rows()){
					$dealerIntearction=$queryDealer->result_array();
		        }

				/* Geting Meeting Information  */
				$arr = "meeting.crm_user_id as user_name,meeting.meeting_date as meeting_date,meeting.meeting_date as date";
		        $this->db->select($arr);
		        $this->db->from("user_meeting meeting");
		        $this->db->where('meeting.crm_user_id',$userid);
		        $this->db->where('meeting.meeting_date  >=', $start);
		        $this->db->where('meeting.meeting_date  <=', $end);
		        $queryMeeting = $this->db->get();
		        if($this->db->affected_rows()){
					$meeting=$queryMeeting->result_array();
		        }
				$resultData=array_merge($docInteraction,$pharmaIntearction,$dealerIntearction,$meeting) ;
				foreach($resultData as $dateData){
					$inteactionDate[]= substr($dateData['date'],0,10);
				}

				/* Geting Leave Information  */
				$arr = "leave.user_id as user_name,leave.from_date as from_date,leave.to_date as to_date,leave.from_date as date";
		        $this->db->select($arr);
		        $this->db->from("user_leave leave");
		        $this->db->where('leave.leave_status',1);
			    $this->db->where('leave.user_id',$userid);
		        $this->db->where('leave.from_date  >=', $start);
		        $this->db->where('leave.to_date  <=', $end);
		        $queryLeave = $this->db->get();
				//echo $this->db->last_query(); die;
		        if($this->db->affected_rows()){
					$leave=$queryLeave->result_array();
		        }
				foreach($leave as $lv)
				{
					$dayCount=(strtotime($lv['to_date'])-strtotime($lv['from_date']))/ 86400;
					$startDate=$lv['from_date'];
					$endXt1= date('Y-m-d', strtotime($lv['to_date'] . ' +1 day'));
					$endDate1= substr($endXt1, 0, 10);
					$begin1 = new DateTime($startDate);
					$end11 = new DateTime($endDate1);
					$interval1= new DateInterval('P1D'); // 1 Day
					$dateRange1 = new DatePeriod($begin1, $interval1, $end11);
					foreach ($dateRange1 as $date) {
						$leaveDate[] = $date->format('Y-m-d');
					}
				}




				/* Geting Leave Information  */
				$arr = "holiday_id,from_date,to_date";
				$con='find_in_set('.$userid.',user_ids)<>0';
		        $this->db->select($arr);
		        $this->db->from("user_holiday");
		        $this->db->where('status',1);
			    $this->db->where($con);
		        $this->db->where('from_date  >=', $start);
		        $this->db->where('to_date  <=', $end);
		        $queryholiday = $this->db->get();
				//echo $this->db->last_query(); die;
		        if($this->db->affected_rows()){
					$holiday=$queryholiday->result_array();
		        }
				foreach($holiday as $lv)
				{
					$dayCount=(strtotime($lv['to_date'])-strtotime($lv['from_date']))/ 86400;
					$startDate=$lv['from_date'];
					$endXt1= date('Y-m-d', strtotime($lv['to_date'] . ' +1 day'));
					$endDate1= substr($endXt1, 0, 10);
					$begin1 = new DateTime($startDate);
					$end11 = new DateTime($endDate1);
					$interval1= new DateInterval('P1D'); // 1 Day
					$dateRange1 = new DatePeriod($begin1, $interval1, $end11);
					foreach ($dateRange1 as $date) {
						$holidayDate[] = $date->format('Y-m-d');
					}
				}




				/* All Date between Date Range */
				$startDate= substr($start, 0, 10);
				$endXt= date('Y-m-d H:i:s', strtotime($end . ' +1 day'));
				$endDate= substr($endXt, 0, 10);
				$begin = new DateTime($startDate);
				$end1 = new DateTime($endDate);
				$interval = new DateInterval('P1D'); // 1 Day
				$dateRange = new DatePeriod($begin, $interval, $end1);
				foreach ($dateRange as $date) {
					$range[] = $date->format('Y-m-d');
					$day = date('D', strtotime($date->format('Y-m-d')));
					if($day=='Sun')
					{
						$sundayDate[]=$date->format('Y-m-d');
						$MonthSun[]=array('date' =>$date->format('Y-m-d'),'day'=>'Sunday');
					}
				}

				$leaveSunday=array_unique(array_merge($leaveDate,$sundayDate));
				$working=  array_diff($range, $leaveSunday);
				$interaction=array_unique($inteactionDate);
				$leaveNotApply=array_diff($working, $interaction);
				$leave_dy=count(array_diff($leaveNotApply, $holidayDate))+count($leaveSunday)-count($sundayDate);
				/*echo 'Total day '.count($range).'<br>';
				echo 'Working day '.count($interaction).'<br>';
				echo 'Sunday '.count($sundayDate).'<br>';
				echo 'Leave day '.$leave_dy.'<br>';
				echo 'Holiday day '.count($holidayDate).'<br>';*/
				$result[]=array('user_emp'=>get_user_deatils($userid)->emp_code,
					'user_name'=>get_user_name($userid),
					'tot_day'=>count($range),
					'working_day'=>count($interaction),
					'sunday'=>count($sundayDate),
					'leave_day'=>$leave_dy,
					'holiday'=>count($holidayDate)
				);
        	}
        }
        return $result;
	
    }

    public function get_tp_report($userid='',$start='',$end=''){
		/* Geting Pharma Interaction */
		$arr = "stp.source,stp.destination,stp.dot,stp.remark,stp.assign_by";
        $this->db->select($arr);
        $this->db->from("user_stp stp");
        $this->db->where('stp.crm_user_id',$userid);
        $this->db->where('stp.dot  >=', $start);
	    $this->db->where('stp.dot  <=', $end);
        $queryIntearction = $this->db->get();
        if($this->db->affected_rows()){
			return $queryIntearction->result_array();
        }
        else
        {
        	return '';
        }
    }
	
	public function check_leave_holiday($idate,$userid){
        $this->db->select('from_date,to_date');
        $this->db->from('user_leave');
        $this->db->where('user_id',$userid);
        $this->db->where('leave_status',1);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            $dateData=$query->result_array();
            foreach($dateData as $dates)
            {
                $this->db->select('leave_id');
                $this->db->from('user_leave');
                $this->db->where("'".date('Y-m-d',strtotime($idate))."' >= '".$dates['from_date']."' AND '".date('Y-m-d',strtotime($idate))."'<='".$dates['to_date']."'");
                $this->db->where('user_id',$userid);
                $this->db->where('leave_status',1);
                $query1 = $this->db->get();
                //echo $this->db->last_query().'<br>';
                if ($query1->num_rows() > 0) {
                   return 1;
                }
            }
          
            $con='find_in_set('.$userid.',user_ids)<>0';
            $this->db->select('from_date,to_date');
            $this->db->from('user_holiday');
            $this->db->where($con);
            // $this->db->where('leave_status',1);
            $query = $this->db->get();
            //echo $this->db->last_query();die;
            if ($query->num_rows() > 0) {
                $dateData=$query->result_array();
                foreach($dateData as $dates)
                {
                    $this->db->select('holiday_id');
                    $this->db->from('user_holiday');
                    $this->db->where("'".date('Y-m-d',strtotime($idate))."' >= '".$dates['from_date']."' AND '".date('Y-m-d',strtotime($idate))."'<='".$dates['to_date']."'");
                    $this->db->where($con);
                  //  $this->db->where('leave_status',1);
                    $query1 = $this->db->get();
                    if ($query1->num_rows() > 0) {
                        return 2;
                    }
                }
                return 1;
            }
            
            else{
                return 1;
            }
            return 1;
        }
        else{
            $con='find_in_set('.$userid.',user_ids)<>0';
            $this->db->select('from_date,to_date');
            $this->db->from('user_holiday');
            $this->db->where($con);
            // $this->db->where('leave_status',1);
            $query = $this->db->get();
            //echo $this->db->last_query();die;
            if ($query->num_rows() > 0) {
                $dateData=$query->result_array();
                foreach($dateData as $dates)
                {
                    $this->db->select('holiday_id');
                    $this->db->from('user_holiday');
                    $this->db->where("'".date('Y-m-d',strtotime($idate))."' >= '".$dates['from_date']."' AND '".date('Y-m-d',strtotime($idate))."'<='".$dates['to_date']."'");
                    $this->db->where($con);
                  //  $this->db->where('leave_status',1);
                    $query1 = $this->db->get();
                    if ($query1->num_rows() > 0) {
                        return 2;
                    }
                }
                return 1;
            }
            else{
                return 1;
            }
            return 1;
        }

    }
	public function get_create_tansitdata($userid='',$start='',$end=''){

		//echo $start;

		/* echo get_user_headquater($userid);

		die; */

		$start_date = new DateTime($start);

		$start_date->modify('-1 day');

		

		$arr = "city_id,interact_date,stay,crm_user_id,interaction_id";

        $this->db->select($arr);

        $this->db->from("user_tour_log");

        $this->db->where('crm_user_id',$userid);

        $this->db->where('interact_date  >=', $start_date->format('Y-m-d'));

        $this->db->where('interact_date  <=', $end);

        $this->db->order_by('interact_date','ASC');

        $query = $this->db->get();

        if($this->db->affected_rows()){

			$tourLog=$query->result_array();

			//pr($tourLog);

			$scount=1;

			$daAmount=0;

			$taAmount=0;

			$fareAmount=0;

			$distance=0;

			$sourceCity=get_user_headquater($userid);

			$dateTour='';

			foreach($tourLog as $log)

			{

				if($log['interact_date']!=$dateTour && $log['interact_date']!=$start_date->format('Y-m-d'))

				{

					$daAmount++;

					$taAmount++;

					$dateTour=$log['interact_date'];

			

				}

				if($log['interact_date']==$start_date->format('Y-m-d') && $scount==1)

				{

					$sourceCity=$log['city_id'];

					$scount++;

				}

				if($log['city_id']==$sourceCity)

				{

					$fareAmount=0;

					$distance=0;

				}

				else

				{

					//get data from master_tour_data

					$result=$this->get_city_data($sourceCity,$log['city_id'],$log['crm_user_id']);

					if($result)

					{

						$distance=$result->distance;

						$fareAmount=$result->fare;

					}

					else{

						$fareAmount=0;

						$distance=0;

					}

					

				}

				if($log['interact_date']!=$start_date->format('Y-m-d'))

				{

					echo $distance.'<br>';

					echo $fareAmount.'<br>';

					

					$tour_data = array(

						'source_city'=>$sourceCity,

						'destination_city'=>$log['city_id'],

						'transit_date'=>$log['interact_date'],

						'da'=>$daAmount,

						'amount'=>$taAmount,

						'distance'=>$distance,

						'fare'=>$fareAmount,

						'crm_user_id'=>$log['crm_user_id'],

						'stay'=>$log['stay'],

						'status'=>1, 

					);

					$this->db->insert('user_ta_da_calculate',$tour_data); 

				}

				$sourceCity=$log['city_id']; 

			}

			die;

        }

	}

	

	public function get_city_data($source_city,$distination_city,$userId){

		$con='(source_city='.$source_city.' or dist_city='.$source_city.') AND (source_city='.$distination_city.' or dist_city='.$distination_city.') AND status=1 AND pharma_user_id='.$userId;

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

  

}