<?php

function savedate(){
     date_default_timezone_set('Asia/Kolkata');
     return date('Y-m-d H:i:s');
}
function present_date(){

     date_default_timezone_set('Asia/Kolkata');

     return date('Y-m-d');

}
function nextmonth_last_date(){

     date_default_timezone_set('Asia/Kolkata');

     return date('Y-m-t',strtotime('+1month'));

}

function users_list_pharma(){
    
    $ci = &get_instance();
     
    $arr = "id as userid,name as username";
    $ci->db->select($arr);
    $ci->db->from('pharma_users');
    $ci->db->order_by("name", "asc");
//    $ci->db->where('id', $id);
   $query = $ci->db->get();
//   echo $ci->db->last_query(); die;
   if($ci->db->affected_rows()){
            
            return json_encode($query->result_array());
        }
        else{
            
            return FALSE;
        }
}


function logged_user_data() {  // for user id
    $ci = &get_instance();
    
   $sess_id =$ci->session->userdata('userId');
  
    if(!empty($sess_id)){
       return $sess_id; 
    }
    else{
        return false; 
    }

   
}

function is_admin() 
{  // for user id
  $ci = &get_instance();
  $admin =$ci->session->userdata('admin');
  return $admin;
}

function logged_user_desig() {  // for user designation
    $ci = &get_instance();
    
   $desig_id =$ci->session->userdata('userDesig');
   
    if(!empty($desig_id)){
       return $desig_id; 
    }
    else{
        return false; 
    }

   
}

function logged_user_pharmaare() {  // for Sub Dealer assign to the user
    $ci = &get_instance();
    
   $pharma_id =$ci->session->userdata('pharmaAre');
   
    if(!empty($pharma_id)){
       return $pharma_id; 
    }
    else{
        return false; 
    }
//    pr($data);
//    die();
   
}


function logged_user_cities() {  // for cities assign to the user
    $ci = &get_instance();
    
   $cities_id =$ci->session->userdata('userCity');
   
    if(!empty($cities_id)){
       return $cities_id; 
    }
    else{
        return false; 
    }
//    pr($data);
//    die();
   
}


function logged_user_boss() {  //boss of the user
    $ci = &get_instance();
    
   $boss_id =$ci->session->userdata('userBoss');
   
    if(!empty($boss_id)){
       return $boss_id; 
    }
    else{
        return false; 
    }
//    pr($data);
//    die();
   
}


function logged_user_child() {  //child of the user
    $ci = &get_instance();
    
   $child_id =$ci->session->userdata('userChild');
   
    if(!empty($child_id)){
       return $child_id; 
    }
    else{
        return false; 
    }
//    pr($data);
//    die();
   
}

function logged_user_doc() {  //doctor of the user
    $ci = &get_instance();
    
   $doc_id =$ci->session->userdata('doctorAre');
   
    if(!empty($doc_id)){
       return $doc_id; 
    }
    else{
        return false; 
    }
//    pr($data);
//    die();
   
}


function get_perms() {
    $data = get_session(USR_SESSION_NAME);
   
    return $data['perms'];
}

function is_logged() {
    if (defined('USER_ID') && USER_ID)
        return USER_ID;
}

function not_authorize() {
    $ci = &get_instance();
    $ci->load->view('layouts/not_auth');
}

function del_row ($id,$tablename){
   $ci = &get_instance();
   $ci->db->where('id', $id);
   $ci->db->delete($tablename); 
//   echo $ci->db->last_query(); die;
   if($ci->db->affected_rows()){
            
            return TRUE;
        }
        else{
            
            return FALSE;
        }
   
}

/*
 * Developer: Niraj Kumar
 * Dated:11-nov-2017
 * Email: sss.shailesh@gmail.com
 * 
 * msort is sort the multidimensional array on the basis of key value
 * 
 */
function msort($array, $key, $sort_flags = SORT_REGULAR) {
    if (is_array($array) && count($array) > 0) {
        if (!empty($key)) {
            $mapping = array();
            foreach ($array as $k => $v) {
//                 if($k<5){   // for show only top 5 values
                $sort_key = '';
                if (!is_array($key)) {
                    $sort_key = $v[$key];
                } else {
                    // @TODO This should be fixed, now it will be sorted as string
                    foreach ($key as $key_key) {
                        $sort_key .= $v[$key_key];
                    }
                    $sort_flags = SORT_NUMERIC;
                }
                $mapping[$k] = $sort_key;
               
                    
//                }
            }
//           pr($mapping); die;
            arsort($mapping, $sort_flags);
            $sorted = array();
             
            foreach ($mapping as $k => $v) {
//                  if($k<5){   // for show only top 5 values
                $sorted[] = $array[$k];
//                  }
            }
            return $sorted;
//             pr($sorted); die;
        }
    }
    return $array;
}

function del_contact_row ($id,$tablename){
   $ci = &get_instance();
   $ci->db->where('contact_id', $id);
   $ci->db->delete($tablename); 
   
   if($ci->db->affected_rows()){
            
            return TRUE;
        }
        else{
            
            return FALSE;
        }

    
}


function del_deal_doc_rel_row ($id,$tablename){  // delete dealer/doctor relation data
   $ci = &get_instance();
   $ci->db->where('user_id', $id);
   $ci->db->delete($tablename); 
   
   if($ci->db->affected_rows()){
            
            return TRUE;
        }
        else{
            
            return FALSE;
        }

    
}

/*
 * @author: Niraj Kumar
 * @email: sss.shailesh@gmail.com
 * Dated: 02-nov-2017
 */
function send_msg($message='' , $num1='',$num2=''){
//  $message = "hello test msg";
//  $num1 = 9718831223;
  
    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://control.m91.com/api/postsms.php",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "<MESSAGE> <AUTHKEY>104818AOPOZWRa59ffdgdfgdfgdrreterterdfsgdfgab4ba</AUTHKEY> <SENDER>nbjain</SENDER> <ROUTE>Template</ROUTE> <CAMPAIGN>XML API</CAMPAIGN> <COUNTRY>country code</COUNTRY> <SMS TEXT=\"$message\" > <ADDRESS TO=\"$num1\"></ADDRESS> </SMS> <SMS TEXT=\"$message\" > <ADDRESS TO=\"$num2\"></ADDRESS> </SMS> </MESSAGE>",
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_HTTPHEADER => array(
    "content-type: application/xml"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  //echo $response;
}
    
    
}



function send_email($recipient, $senderemail='', $subject, $message){
	
    $ci = &get_instance();
	
    $ci->load->library('email', email_setting());
    $ci->email->to($recipient, 'Interaction');
  //  $ci->email->to($recipient, 'pharma test');

//         $this->email->to('sss.shailesh@gmail.com', $data->c_ordernum);
        
//        if(!empty($ci->session->userdata['userEmail'])){
//          $ccmail = "ssshailesh23@gmail.com";
//        }
//        else{
//            $d_mail=$ci->user->dealer_mail($id);
//           // pr($d_mail); die;
//            $ccmail = $d_mail->email_id;
//        }
    //$ci->email->from('ssshailesh23@gmail.com','Name');
    //$ci->email->cc('pharma.reports@bjain.com');
    if($senderemail!='')
    {
      $ci->email->from($senderemail);
    }
       
//        $cc2mail = 'nitin@bjain.com';
//        $ci->email->cc("$ccmail,$cc2mail");
    $msg='Dear Partner,
                           Greetings,
                    

                    Many Thanks!
                   ---------------------------- 
                    B. Jain Publishers Pvt Ltd
                    D 157 Sector 63, Noida
                    201301, Uttar Pradesh 
                    Tel: +91-120-49 33 333';
        
    
	$ci->email->subject($subject); 

	$ci->email->message($message);
	$result=$ci->email->send();
	if($result){

	}
	else{


	}
}


// change status of doctor data
function status_doctor_interaction_data($id,$tablename,$data){

    $ci = &get_instance();
    $sample_data = 
                array(
                    'status'=>0,
                    'last_update'=> savedate()
                    
                );
   $ci->db->where('id', $id);
   $ci->db->update($tablename,$sample_data);
//   $ci->db->delete($tablename); 
  
   if($ci->db->affected_rows()){
    $interactionId=$id+1;
            $sample_data1 = 
                array(
                    'interaction_id'=>$interactionId,
                    'updated_date'=> savedate()
                );
           $ci->db->where('interaction_id', $id);
           $ci->db->where('interaction_person_id', $data['dealer_view_id']);
           $ci->db->update('interaction_order',$sample_data1);
           /*echo $ci->db->last_query();
           die;*/
           return TRUE;
        }
        else{
            
            return FALSE;
        }
    
}


// change status of the Sample of doctor before delete
function status_sample_data($id,$tablename){
  
    $ci = &get_instance();
    $sample_data = 
                array(
                    'status'=>0,
                    'last_update'=> savedate()
                    
                );
   $ci->db->where('pidoc_id', $id);
   $ci->db->update($tablename,$sample_data);
//   $ci->db->delete($tablename); 
   
   if($ci->db->affected_rows()){
            
            return TRUE;
        }
        else{
            
            return FALSE;
        }
}

// for delete the Sample data of doctor
function del_sample_types ($id,$tablename){
   $ci = &get_instance();
   $ci->db->where('pidoc_id', $id);
   $ci->db->where('status', 0);
   $ci->db->delete($tablename); 
   
   if($ci->db->affected_rows()){
            
            return TRUE;
        }
        else{
            
            return FALSE;
        }

    
}

// change status of the Sample of Sub Dealer before delete
function status_pharma_data($id,$tablename){
  
    $ci = &get_instance();
    $sample_data = 
                array(
                    'status'=>0,
                    'last_update'=> savedate()
                    
                );
   $ci->db->where('pipharma_id', $id);
   $ci->db->update($tablename,$sample_data);
//   $ci->db->delete($tablename); 
   
   if($ci->db->affected_rows()){
            
            return TRUE;
        }
        else{
            
            return FALSE;
        }
}


// change status of the Sample of Dealer before delete
function status_dealer_data($id,$tablename){
  
    $ci = &get_instance();
    $sample_data = 
                array(
                    'status'=>0,
                    'last_update'=> savedate()
                    
                );
   $ci->db->where('pidealer_id', $id);
   $ci->db->update($tablename,$sample_data);
//   $ci->db->delete($tablename); 
   
   if($ci->db->affected_rows()){
            
            return TRUE;
        }
        else{
            
            return FALSE;
        }
}
 	

// check server is connect or not
//function get_http_response_code() {
//    $ci = &get_instance();
////    $headers = $ci->conn_id;
////    pr($headers); die;
//     if ( !$ci->db->conn_id) // HERE LIES THE PROBLEM
//           return TRUE;
////    else{
////        return $ci->db->db_connect;
////    }
//}
	
	function get_all_city(){
		$ci = &get_instance();
		$arr="c.city_id,c.city_name,s.state_name";
		$ci->db->select($arr);
		$ci->db->from("city c");
    $ci->db->join('state s','c.state_id=s.state_id');
		$ci->db->where('c.status',1);
		$query = $ci->db->get();
		if($ci->db->affected_rows()){
			return $query->result_array();
		}
		else{
			return FALSE;
		}
	}

	function get_all_paharma_user(){
		$ci = &get_instance();
		$arr="id,name";
		$ci->db->select($arr);
		$ci->db->from("pharma_users");
		$ci->db->where('user_status ',1);
		$query = $ci->db->get();
		if($ci->db->affected_rows()){
			return $query->result_array();
		}
		else{
			return FALSE;
		}
	}


	function get_doctor_city($id){
		$ci = &get_instance();
		$arr = "city_id";
        $ci->db->select($arr);
        $ci->db->from("doctor_list");
        $ci->db->where('doctor_id',$id);
        $query = $ci->db->get();
        if($ci->db->affected_rows()){
			return $query->row()->city_id;
		}
        else{
            return ' ';
        }
	}
	
	function get_city_name($id){
		$ci = &get_instance();
		$arr = "city_name";
        $ci->db->select($arr);
        $ci->db->from("city");
        $ci->db->where('city_id',$id);
        $query = $ci->db->get();
        
        if($ci->db->affected_rows()){
			return $query->row()->city_name;
		}
        else{
            return ' ';
        }
	}
	
	function get_pharma_city($id){
		$ci = &get_instance();
		$arr = "city_id";
        $ci->db->select($arr);
        $ci->db->from("pharmacy_list");
        $ci->db->where('pharma_id',$id);
        $query = $ci->db->get();
        if($ci->db->affected_rows()){
			return $query->row()->city_id;
		}
        else{
            return ' ';
        }
	}
	
	function get_dealer_city($id){
		$ci = &get_instance();
		$arr = "city_id";
        $ci->db->select($arr);
        $ci->db->from("dealer");
        $ci->db->where('dealer_id',$id);
        $query = $ci->db->get();
        if($ci->db->affected_rows()){
			return $query->row()->city_id;
		}
        else{
            return ' ';
        }
	}
	
	function get_dealer_interaction_id($id){
		$ci = &get_instance();
		$arr = "id";
        $ci->db->select($arr);
        $ci->db->from("pharma_interaction_dealer");
        //$ci->db->where('d_id',$id);
        $ci->db->where('crm_user_id',logged_user_data());
        $ci->db->order_by('id','DESC');
        $query = $ci->db->get();
        if($ci->db->affected_rows()){
			//echo $ci->db->last_query();
			return  $query->row()->id;
			//die;
		}
        else{
            return ' ';
        }
	}
	
	function get_pharma_interaction_id($id){
		$ci = &get_instance();
		$arr = "id";
        $ci->db->select($arr);
        $ci->db->from("pharma_interaction_pharmacy");
       // $ci->db->where('pharma_id',$id);
        $ci->db->where('crm_user_id',logged_user_data());
        $ci->db->order_by('id','DESC');
        $query = $ci->db->get();
        if($ci->db->affected_rows()){
			return $query->row()->id;
		}
        else{
            return ' ';
        }
	}
	
	function get_doctor_interaction_id($id){
		$ci = &get_instance();
		$arr = "id";
        $ci->db->select($arr);
        $ci->db->from("pharma_interaction_doctor");
       // $ci->db->where('doc_id',$id);
        $ci->db->where('crm_user_id',logged_user_data());
        $ci->db->order_by('id','DESC');
        $query = $ci->db->get();
		//echo $ci->db->last_query();
        if($ci->db->affected_rows()){
			return $query->row()->id;
		}
        else{
            return ' ';
        }
	}
	
	function get_state_name($id){
		$ci = &get_instance();
		$arr = "state_name";
        $ci->db->select($arr);
        $ci->db->from("state");
        $ci->db->where('state_id',$id);
        $query = $ci->db->get();
        if($ci->db->affected_rows()){
			return $query->row()->state_name;
		}
        else{
            return ' ';
        }
	}

	function get_user_name($id){
		$ci = &get_instance();
		$arr = "name";
        $ci->db->select($arr);
        $ci->db->from("pharma_users");
        $ci->db->where('id',$id);
        $query = $ci->db->get();
        if($ci->db->affected_rows()){
			return $query->row()->name;
		}
        else{
            return ' ';
        }
	}
	
	function get_user_boss($id)// return user boss list
	{
		$ci = &get_instance();
		$results[]=array();
		$ci->db->select('user_id,boss_id');
        $ci->db->from('user_bossuser_relation');
        $ci->db->where('user_id',$id);
		$query= $ci->db->get();   
        if($query->num_rows() > 0){
            return $query->result_array();
		}
		else{
			return FALSE;
		}
	}
	
	function get_user_headquater($id){
		$ci = &get_instance();
		$arr = "headquarters_city";
        $ci->db->select($arr);
        $ci->db->from("pharma_users");
        $ci->db->where('id',$id);
        $query = $ci->db->get();
        if($ci->db->affected_rows()){
			//echo $ci->db->last_query();
			return  $query->row()->headquarters_city;
			//die;
		}
        else{
            return ' ';
        }
	}
	
	function check_user_boss($userid,$bossid)// check user boss relation
	{
		$ci = &get_instance();
		$results[]=array();
		$ci->db->select('user_id,boss_id');
        $ci->db->from('user_bossuser_relation');
        $ci->db->where('user_id',$userid);
        $ci->db->where('boss_id ',$bossid);
		$query= $ci->db->get();   
        if($query->num_rows() > 0){
            return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	function get_user_deatils($id){
		$ci = &get_instance();
		$arr = "name,email_id,user_phone,user_designation_id,hq_city as headquarters_city,hq_city_pincode,user_designation_id,emp_code";
        $ci->db->select($arr);
        $ci->db->from("pharma_users");
        $ci->db->where('id',$id);
        $query = $ci->db->get();
        if($ci->db->affected_rows()){
			return $query->row();
		}
        else{
            return ' ';
        }
	}
	
	/* Get Category Name */
	function get_category_name($id){
		$ci = &get_instance();
		$arr = "category_name";
        $ci->db->select($arr);
        $ci->db->from("pharma_category");
        $ci->db->where('category_id',$id);
        $query = $ci->db->get();
        if($ci->db->affected_rows()){
			return $query->row()->category_name;
		}
        else{
            return ' ';
        }
	}
	
	/* Get Potency Value */
	function get_potency_value($id){
		$ci = &get_instance();
		$arr = "potency_value";
        $ci->db->select($arr);
        $ci->db->from("pharma_potency");
        $ci->db->where('potency_id',$id);
        $query = $ci->db->get();
        if($ci->db->affected_rows()){
			return $query->row()->potency_value;
		}
        else{
            return ' ';
        }
	}
	
	/* Get Packsize Name */
	function get_packsize_value($id){
		$ci = &get_instance();
		$arr = "packsize_value";
        $ci->db->select($arr);
        $ci->db->from("pharma_packsize");
        $ci->db->where('packsize_id',$id);
        $query = $ci->db->get();
        if($ci->db->affected_rows()){
			return $query->row()->packsize_value;
		}
        else{
            return ' ';
        }
	}

  function get_user_email($id){
    $ci = &get_instance();
    $arr = "email_id";
        $ci->db->select($arr);
        $ci->db->from("pharma_users");
        $ci->db->where('id',$id);
        $ci->db->where('user_status',1);
        $query = $ci->db->get();
        if($ci->db->affected_rows()){
      return $query->row()->email_id;
    }
        else{
            return ' ';
        }
  }
	
	/* Get Doctor Name */
	function get_doctor_name($id){
		$ci = &get_instance();
		$arr = "doc_name";
        $ci->db->select($arr);
        $ci->db->from("doctor_list");
        $ci->db->where('doctor_id',$id);
        $query = $ci->db->get();
		/* echo $ci->db->last_query();
		die; */
        if($ci->db->affected_rows()){
			return $query->row()->doc_name;
		}
        else{
            return ' ';
        }
	}
	
	/* Get Sub Dealer Name */
	function get_pharmacy_name($id){
		$ci = &get_instance();
		$arr = "company_name";
        $ci->db->select($arr);
        $ci->db->from("pharmacy_list");
        $ci->db->where('pharma_id',$id);
        $query = $ci->db->get();
        if($ci->db->affected_rows()){
			return $query->row()->company_name;
		}
        else{
            return ' ';
        }
	}
	
	/* Get Packsize Name */
	function get_dealer_name($id){
		$ci = &get_instance();
		$arr = "dealer_name";
        $ci->db->select($arr);
        $ci->db->from("dealer");
        $ci->db->where('dealer_id',$id);
        $query = $ci->db->get();
        if($ci->db->affected_rows()){
			return $query->row()->dealer_name;
		}
        else{
            return ' ';
        }
	}
	
	/* Get Product Name */
	function get_product_name($id){
		$ci = &get_instance();
		$arr = "product_name";
        $ci->db->select($arr);
        $ci->db->from("pharma_product");
        $ci->db->where('product_id',$id);
        $query = $ci->db->get();
        if($ci->db->affected_rows()){
			return $query->row()->product_name;
		}
        else{
            return ' ';
        }
	}
	
	/* Get Product Amount */
	function get_product_amount($id){
		$ci = &get_instance();
		$arr = "product_price";
        $ci->db->select($arr);
        $ci->db->from("pharma_product");
        $ci->db->where('product_id',$id);
        $query = $ci->db->get();
        if($ci->db->affected_rows()){
			return $query->row()->product_price;
		}
        else{
            return ' ';
        }
	}
	
	/* Get Product Packsize */
	function get_packsize_name($id){
		$ci = &get_instance();
		$arr = "packsize.packsize_value as packsize_value";
        $ci->db->select($arr);
        $ci->db->from("pharma_product as product");       
		$ci->db->join("pharma_packsize as packsize",'product.product_packsize=packsize.packsize_id');
		$ci->db->where('product.product_id',$id);		
        $query = $ci->db->get();
        if($ci->db->affected_rows()){
			return $query->row()->packsize_value;
		}
        else{
            return ' ';
        }
	}
	
	 function get_category_product($catId){
		$ci = &get_instance();
		$productList=array();
		$arr = "product.product_id,product.product_name,product.product_category,product.product_potency,product.product_packsize,product.product_price,product.status,packsize.packsize_value";
        $ci->db->select($arr);
        $ci->db->from("pharma_product as product");       
        $ci->db->join("pharma_packsize as packsize",'product.product_packsize=packsize.packsize_id');
        $ci->db->where('product.product_category',$catId);        
        $ci->db->where('product.status',1);
        $query = $ci->db->get();
        if($ci->db->affected_rows()){
			$productList=$query->result_array();
		}
	
		return $productList;
    }
	
	function get_product_discount($orderId,$productId){
		$ci = &get_instance();
		$productList=array();
		$arr = "discount";
        $ci->db->select($arr);
        $ci->db->from("order_details");
		$ci->db->where('order_id',$orderId);
		$ci->db->where('product_id',$productId);
		//$ci->db->where('crm_user_id',logged_user_data());
        $query = $ci->db->get();
        if($ci->db->affected_rows()){
			return $query->row()->discount;
		}
		else{
            return 0;
        }
    }

    function get_product_quantity($orderId,$productId){
        $ci = &get_instance();
        $productList=array();
        $arr = "quantity";
        $ci->db->select($arr);
        $ci->db->from("order_details");
        $ci->db->where('order_id',$orderId);
        $ci->db->where('product_id',$productId);
       // $ci->db->where('crm_user_id',logged_user_data());
        $query = $ci->db->get();
        if($ci->db->affected_rows()){
            return $query->row()->quantity;
        }
        else{
            return 1;
        }
    }
	
	function get_product_net($orderId,$productId){
		$ci = &get_instance();
		$productList=array();
		$arr = "net_amount,actual_value";
        $ci->db->select($arr);
        $ci->db->from("order_details");
		$ci->db->where('order_id',$orderId);
		$ci->db->where('product_id',$productId);
		//$ci->db->where('crm_user_id',logged_user_data());
        $query = $ci->db->get();
        if($ci->db->affected_rows()){
			return $query->row()->net_amount;
		}
		else{
            return 0;
        }
    }
	
	function get_increment_id($table_name){
		$ci = &get_instance();
		$productList=array();
		$arr = "id";
        $ci->db->select($arr);
        $ci->db->from($table_name);
		$ci->db->order_by('id','desc');
		$query = $ci->db->get();
        if($ci->db->affected_rows()){
			return $query->row()->id;
		}
		else{
            return 0;
        }
    }
	
	function get_complete_order($oId,$pId){
		$ci = &get_instance();
		$productList=array();
		$arr = "status";
        $ci->db->select($arr);
        $ci->db->where('interaction_id',$oId); 
		$ci->db->where('interaction_person_id',$pId); 
		$ci->db->where('crm_user_id',logged_user_data()); 
		$ci->db->from('interaction_order');
		$query = $ci->db->get();
        if($ci->db->affected_rows()){
			return $query->row()->status;
		}
		else{
            return 2;
        }
    }
	
	function get_cancel_order($oId,$pId){
		$ci = &get_instance();
		$productList=array();
		$arr = "cancel_status";
        $ci->db->select($arr);
        $ci->db->where('interaction_id',$oId); 
		$ci->db->where('interaction_person_id',$pId); 
		$ci->db->where('crm_user_id',logged_user_data()); 
		$ci->db->from('interaction_order');
		$query = $ci->db->get();
        if($ci->db->affected_rows()){
			return $query->row()->cancel_status;
		}
		else{
            return 2;
        }
    }


    function get_interaction_userid($interaction_id, $table)
    {
      $ci = &get_instance();
      $productList=array();
      $arr = "crm_user_id";
      $ci->db->select($arr);
      $ci->db->where('id',$interaction_id); 
      $ci->db->from($table);
      $query = $ci->db->get();
      if($ci->db->affected_rows()){
        return $query->row()->crm_user_id;
      }
      else{
        return 0;
      }
    }

    function get_cat_potency($catId) {  // for Cataegory potency
      $ci = &get_instance();
      $table='pharma_product';
      $arr = "product_potency";
      $ci->db->select($arr);
      $ci->db->where('product_category',$catId); 
      $ci->db->from($table);
      $ci->db->distinct();
      $query = $ci->db->get();
     /* echo $ci->db->last_query();
      die;*/
      if($ci->db->affected_rows()){
        $result=$query->result_array();
        if(count($result)==1)
        {
          if($result[0]['product_potency']==0)
            {
              return false; 
            }
            else
            {
              return true; 
            }
        }
        else
        {
         return true; 
        }
      }
    }

  function get_holiday_details($date){
    $ci = &get_instance();
    $col='holiday_id,user_ids,assign_by,remark,,status,from_date,to_date';
    $con='find_in_set('.logged_user_data().',user_ids) and (from_date <="'.$date.'" and to_date>="'.$date.'")';
    $ci->db->select($col); 
    $ci->db->from('user_holiday'); 
    $ci->db->where($con);
    $query= $ci->db->get(); 
    if($ci->db->affected_rows()){
      return $query->row(); 
    } 
    else{
      return FALSE;
    }
  }

  function get_assign_task($date){
    $ci = &get_instance();
    $col='id,destination,tour_date,remark,,assign_by';
    $con='find_in_set('.logged_user_data().',user_ids) and (tour_date ="'.$date.'")';
    $ci->db->select($col); 
    $ci->db->from('assign_tour'); 
    $ci->db->where($con);
    $query= $ci->db->get(); 
    if($ci->db->affected_rows()){
      return $query->row(); 
    } 
    else{
      return FALSE;
    }
  }

  function get_tour_info($user_id,$year_month){
    $nextmonth = date($year_month, strtotime('+1 month'));
  	$ci = &get_instance();
    $col='id, destination, dot, remark, assign_by, is_approved';
    $ci->db->select($col); 
    $ci->db->from('user_stp'); 
    $ci->db->where('crm_user_id',$user_id);
    $ci->db->like('dot',$nextmonth);
    $query= $ci->db->get(); 
//echo $ci->db->last_query(); die;
    if($ci->db->affected_rows()){
    	return $query->result_array();
    }
    else{
      return FALSE;
    }
  }

   function get_followup($date){
    $remark='';
    $ci = &get_instance();
    $col='GROUP_CONCAT(remark) as remark';
    $con='follow_up_action ="'.$date.' 00:00:00"';
    $ci->db->select($col); 
    $ci->db->from('pharma_interaction_dealer'); 
    $ci->db->where($con);
    $query= $ci->db->get(); 
    if($ci->db->affected_rows()){
      if(!is_null($query->row()->remark ))
      {
        $remark= $query->row()->remark; 
      }
    
    }
    $ci = &get_instance();
    $col='GROUP_CONCAT(remark) as remark';
    $con='follow_up_action ="'.$date.' 00:00:00"';
    $ci->db->select($col); 
    $ci->db->from('pharma_interaction_doctor'); 
    $ci->db->where($con);
    $query= $ci->db->get(); 
    if($ci->db->affected_rows()){
      if(!is_null($query->row()->remark ))
      {
        $remark= $remark.','.$query->row()->remark; 
      }
    }
    $ci = &get_instance();
    $col='GROUP_CONCAT(remark) as remark';
    $con='follow_up_action ="'.$date.' 00:00:00"';
    $ci->db->select($col); 
    $ci->db->from('pharma_interaction_pharmacy'); 
    $ci->db->where($con);
    $query= $ci->db->get(); 
    if($ci->db->affected_rows()){
      if(!is_null($query->row()->remark ))
      {
       $remark= $remark.','.$query->row()->remark; 
      }
      
    } 
    return $remark;
  }

  function get_destination_interaction($table,$id,$con){
    $ci = &get_instance();
    $col='city_pincode';
    $ci->db->select($col); 
    $ci->db->from($table); 
    if($con==1)
    {
      $ci->db->where('doctor_id',$id);
    }
    elseif($con==2)
    {
      $ci->db->where('pharma_id',$id);
    }
    elseif($con==3)
    {
      $ci->db->where('dealer_id',$id);
    }
    $query= $ci->db->get(); 
    if($ci->db->affected_rows()){
      return $query->row()->city_pincode; 
    } 
    else{
      return FALSE;
    }
  }

  function get_destination_interaction_id($table,$id,$con){
    $ci = &get_instance();
    $col='city_id';
    $ci->db->select($col); 
    $ci->db->from($table); 
    if($con==1)
    {
      $ci->db->where('doctor_id',$id);
    }
    elseif($con==2)
    {
      $ci->db->where('pharma_id',$id);
    }
    elseif($con==3)
    {
      $ci->db->where('dealer_id',$id);
    }
    $query= $ci->db->get(); 
    if($ci->db->affected_rows()){
      return $query->row()->city_id; 
    } 
    else{
      return FALSE;
    }
  }

 function get_interaction_source(){
    $ci = &get_instance();
    $col='source_city_pin,up_down';
    $ci->db->select($col); 
    $ci->db->from('ta_da_report'); 
    $ci->db->where('user_id',logged_user_data()); 
    //$ci->db->where('up_down',1); 
    $ci->db->limit(1);
    $ci->db->order_by('id','DESC');
    $query= $ci->db->get(); 
    if($ci->db->affected_rows()){
      $up= $query->row()->up_down;
      if($up)
      {
        return  get_user_deatils(logged_user_data())->hq_city_pincode;
      }
      else
      {
        $table='intearction_replica';
        $col='interaction_with';
        $ci->db->select($col); 
        $ci->db->from($table); 
        $ci->db->where('crm_user_id',logged_user_data()); 
        $ci->db->limit(1,1);
        $ci->db->order_by('id','DESC');
        $query= $ci->db->get(); 
        if($ci->db->affected_rows()){
          $id= $query->row()->interaction_with; 
           $source=0;
          if(!is_numeric($id))
            {
                if(substr($id,0,3)=='doc'){
                    //doctor
                    $source=get_destination_interaction('doctor_list',$id,1);
                }
                else{
                   //pharma 
                    $source=get_destination_interaction('pharmacy_list',$id,2);
                }
            }
            else{
               //dealer 
                $source=get_destination_interaction('dealer',$id,3);
            }
            return $source;
        } 
        else{
          return get_user_deatils(logged_user_data())->hq_city_pincode;
        }
      }
    } 
    else{
      $table='intearction_replica';
      $col='interaction_with';
      $ci->db->select($col); 
      $ci->db->from($table); 
      $ci->db->where('crm_user_id',logged_user_data()); 
      $ci->db->limit(1,1);
      $ci->db->order_by('id','DESC');
      $query= $ci->db->get(); 
      if($ci->db->affected_rows()){
        $id= $query->row()->interaction_with; 
        $source=0;
        if(!is_numeric($id))
          {
              if(substr($id,0,3)=='doc'){
                  //doctor
                  $source=get_destination_interaction('doctor_list',$id,1);
              }
              else{
                 //pharma 
                  $source=get_destination_interaction('pharmacy_list',$id,2);
              }
          }
          else{
             //dealer 
              $source=get_destination_interaction('dealer',$id,3);
          }
          return $source;
      } 
      else{
        return get_user_deatils(logged_user_data())->hq_city_pincode;
      }
    }
  }

  function get_interaction_source_id(){

    $ci = &get_instance();
    $col='source_city,up_down';
    $ci->db->select($col); 
    $ci->db->from('ta_da_report'); 
    $ci->db->where('user_id',logged_user_data()); 
    //$ci->db->where('up_down',1); 
    $ci->db->limit(1);
    $ci->db->order_by('id','DESC');
    $query= $ci->db->get(); 
    if($ci->db->affected_rows()){
      $up= $query->row()->up_down;
      if($up)
      {
        return get_user_deatils(logged_user_data())->headquarters_city;
      }
      else
      {
        $table='intearction_replica';
        $ci = &get_instance();
        $col='interaction_with';
        $ci->db->select($col); 
        $ci->db->from($table); 
        $ci->db->where('crm_user_id',logged_user_data()); 
        $ci->db->limit(1,1);
        $ci->db->order_by('id','DESC');
        $query= $ci->db->get(); 
        if($ci->db->affected_rows()){
          $id= $query->row()->interaction_with; 
           $source=0;
          if(!is_numeric($id))
            {
                if(substr($id,0,3)=='doc'){
                    //doctor
                    $source=get_destination_interaction_id('doctor_list',$id,1);
                }
                else{
                   //pharma 
                    $source=get_destination_interaction_id('pharmacy_list',$id,2);
                }
            }
            else{
               //dealer 
                $source=get_destination_interaction_id('dealer',$id,3);
            }
            return $source;
        } 
        else{
          return get_user_deatils(logged_user_data())->headquarters_city;
        }
      }
    }
    else{
      $table='intearction_replica';
      $ci = &get_instance();
      $col='interaction_with';
      $ci->db->select($col); 
      $ci->db->from($table); 
      $ci->db->where('crm_user_id',logged_user_data()); 
      $ci->db->limit(1,1);
      $ci->db->order_by('id','DESC');
      $query= $ci->db->get(); 
      if($ci->db->affected_rows()){
        $id= $query->row()->interaction_with; 
         $source=0;
        if(!is_numeric($id))
          {
              if(substr($id,0,3)=='doc'){
                  //doctor
                  $source=get_destination_interaction_id('doctor_list',$id,1);
              }
              else{
                 //pharma 
                  $source=get_destination_interaction_id('pharmacy_list',$id,2);
              }
          }
          else{
             //dealer 
              $source=get_destination_interaction_id('dealer',$id,3);
          }
          return $source;
      } 
      else{
        return get_user_deatils(logged_user_data())->headquarters_city;
      }
    }
  }

function get_km_expanse($id){
  $ci = &get_instance();
  $col='price';
  $ci->db->select($col); 
  $ci->db->from('user_km_expanse'); 
  $ci->db->where('id',$id);
  $query= $ci->db->get(); 
  if($ci->db->affected_rows()){
    return  $query->row()->price; 
  } 
  else{
    return 0;
  }
}

function get_user_da($loc,$deg,$metro){
  $ci = &get_instance();
  if($metro)
  {
    $col='metro_class_city';
  }
  else
  {
    $col='ordinary_class_city'; 
  }
  
  $ci->db->select($col); 
  $ci->db->from('users_da'); 
  $ci->db->where('location_type',$loc);
  $ci->db->where('designation_id',$deg);
  $query= $ci->db->get(); 
  if($ci->db->affected_rows()){
    if($metro)
    {
      return  $query->row()->metro_class_city; 
    }
    else
    {
     return  $query->row()->ordinary_class_city; 
    }
  } 
  else{
    return 0;
  }
}

function is_city_metro($id){
  $ci = &get_instance();
  $col='is_metro';
  $ci->db->select($col); 
  $ci->db->from('city'); 
  $ci->db->where('city_id',$id);
  $ci->db->where('is_metro',1);
  $query= $ci->db->get(); 
  if($ci->db->affected_rows()){
    return  1; 
  } 
  else{
    return 0;
  }
}

function get_destination_before($userid,$start){
    $ci = &get_instance();
    $col='destination_city';
    $ci->db->select($col); 
    $ci->db->from('ta_da_report'); 
    $ci->db->where('user_id',$userid); 
    $ci->db->where('doi',date('Y-m-d', strtotime($start.'-1 day'))); 
    $query= $ci->db->get(); 
    if($ci->db->affected_rows()){
      $id= $query->row()->destination_city; 
      return $id;
    } 
    else{
      return get_user_deatils($userid)->headquarters_city;
    }
  }

function get_source_ct($userid,$doi){
    $ci = &get_instance();
    $col='source_city';
    $ci->db->select($col); 
    $ci->db->from('ta_da_report'); 
    $ci->db->where('user_id',$userid); 
    $ci->db->where('doi',date('Y-m-d', strtotime($doi.'-1 day'))); 
    $ci->db->where('up_down',1); 
    $query= $ci->db->get(); 
    if($ci->db->affected_rows()){
      $id= $query->row()->source_city; 
      return $id;
    } 
    else
    {
      $ci = &get_instance();
      $col='source_city';
      $ci->db->select($col); 
      $ci->db->from('ta_da_report'); 
      $ci->db->where('user_id',$userid); 
      $ci->db->where('doi',date('Y-m-d', strtotime($doi.'-1 day'))); 
      $ci->db->where('up_down',0); 
      $query= $ci->db->get(); 
      if($ci->db->affected_rows()){
        $id= $query->row()->source_city; 
        return $id;
      } 
      else{
        return get_user_deatils($userid)->headquarters_city;
      }
    }
  }

 /* function get_destination_before($userid,$start){
    $ci = &get_instance();
    $col='destination_city';
    $ci->db->select($col); 
    $ci->db->from('ta_da_report'); 
    $ci->db->where('crm_user_id',$userid); 
    $ci->db->where('doi',date('Y-m-d', strtotime($start.'-1 day'))); 
    $query= $ci->db->get(); 
    if($ci->db->affected_rows()){
      $id= $query->row()->destination_city; 
      return $source;
    } 
    else{
      return get_user_deatils($userid)->headquarters_city;
    }
  }*/


function get_distance_hq($userid,$meetid){
  $source_city=get_user_deatils($userid)->hq_city_pincode;
  $destination_city=0;
  if(!is_numeric($meetid))
  {
      if(substr($meetid,0,3)=='doc'){
          //doctor
          $destination_city=get_destination_interaction('doctor_list',$meetid,1);
      }
      else{
         //pharma 
          $destination_city=get_destination_interaction('pharmacy_list',$meetid,2);
      }
  }
  else{
     //dealer 
      $destination_city=get_destination_interaction('dealer',$meetid,3);
  }
  $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=".$source_city."&destinations=".$destination_city.'&key=AIzaSyBW4XD3HI9gZfK-J36dRizXrw6ynJ_ztJI';
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  $response = curl_exec($ch);
  curl_close($ch);

  $response_a = json_decode($response);
  $status = $response_a->status;
  //die;
  if ($status == 'OK' && $response_a->rows[0]->elements[0]->status == 'OK')
  {
     return $distance=explode(' ',$response_a->rows[0]->elements[0]->distance->text)[0];
  }
  else
  {
      return $distance=0;
  }
}

  function get_tp_interaction($userid,$source_city,$destination_city,$doi){
    $ci = &get_instance();
    $col='destination';
    $ci->db->select($col); 
    $ci->db->from('user_stp'); 
    $ci->db->where('crm_user_id',$userid); 
    $ci->db->where('source',$source_city); 
    $ci->db->where('tst>','18:00:00'); 
    $ci->db->where('destination',$destination_city); 
    $ci->db->where('dot',$doi); 
    $query= $ci->db->get(); 
    if($ci->db->affected_rows()){
      return TRUE;
    } 
    else{
      return FALSE;
    }
  }

  function get_dealer_pharma_name($id){
    $ci = &get_instance();
    $table='';
    $col='';
    if(is_numeric($id))
    {
      $col='dealer_name';
      $ci->db->select($col); 
      $ci->db->from('dealer'); 
      $ci->db->where('dealer_id',$id); 
      $query= $ci->db->get(); 
      if($ci->db->affected_rows()){
        return $query->row()->dealer_name;
      } 
      else{
        return '';
      }
    }
    else
    {
      $col='company_name';
      $ci->db->select($col); 
      $ci->db->from('pharmacy_list'); 
      $ci->db->where('pharma_id',$id); 
      $query= $ci->db->get(); 
      if($ci->db->affected_rows()){
        return $query->row()->company_name;
      } 
      else{
        return '';
      }
    }
  }

  function check_city_exist($data){
    $ci = &get_instance();
    $col='city_name';
    $ci->db->select($col); 
    $ci->db->from('city'); 
    $ci->db->like('city_name',$data['city_name']);
    $ci->db->where('state_id',$data['state']);
    $query= $ci->db->get(); 
    if($ci->db->affected_rows()){
      return  false; 
    } 
    else{
      return true;
    }
  }


function user_sp_code() {  // for user id
  $ci = &get_instance();
  $id =logged_user_data();
  $col='sp_code';
  $ci->db->select($col); 
  $ci->db->from('pharma_users'); 
  $ci->db->where('id',$id);
  $query= $ci->db->get(); 
  if($ci->db->affected_rows()){
    return  explode(',',$query->row()->sp_code)[0]; 
  } 
  else{
    return '';
  }
}

function check_user_sp($spcode) {  // for user id
  if($spcode=='')
  {
    $spcode=0;
    
  }
  $ci = &get_instance();
  $id =logged_user_data();
  $con='find_in_set('.$spcode.',sp_code) and (id ='.$id.')<>0';
  $col='id';
  $ci->db->select($col); 
  $ci->db->from('pharma_users'); 
  $ci->db->where($con);
  $query= $ci->db->get(); 
  if($ci->db->affected_rows()){
    return  True; 
  } 
  else{
    return False;
  }
}

function all_user_sp_code() {  // for user id
  $ci = &get_instance();
  $id =logged_user_data();
  $col='p.sp_code';
  $ci->db->select($col); 
  $ci->db->from('pharma_users p'); 
  $ci->db->where('p.id',$id);
  $query= $ci->db->get(); 
  if($ci->db->affected_rows())
  {
    $spcode=$query->row()->sp_code;

    return  $spcode;
    
  } 
  else
  {
    return '';
  }
}

function get_payment_term($interaction_id,$interaction_person_id)
{
   $ci = &get_instance();
  $arr = "payment_term";
  $ci->db->select($arr);
  $ci->db->from("interaction_order");
  $ci->db->where("interaction_person_id",$interaction_person_id);
  $ci->db->where('interaction_id',$interaction_id);
  $query = $ci->db->get();
  if($ci->db->affected_rows())
  {
    return $result=$query->row()->payment_term;
  }
  else
  {
    return '';
  }
}

function check_user_sp_dealer($spcode)
{  // for user id
  if($spcode!='')
  {
    $sp_code = explode(',',$spcode);
    foreach($sp_code as $scd)
    {
      $ci = &get_instance();
      $id =logged_user_data();
      $con='find_in_set('.$scd.',sp_code) and (id ='.$id.')<>0';
      $col='id';
      $ci->db->select($col); 
      $ci->db->from('pharma_users'); 
      $ci->db->where($con);
      $query= $ci->db->get(); 
      if($ci->db->affected_rows()){
        return  True; 
      } 
    }
    return False;
  }
  else
  {
    return False;
  }
}

function get_check_active_users($arr){
	$ci = &get_instance();
	$rest=array();
	foreach ($arr as $uid){
		$arr="id";
		$ci->db->select($arr);
		$ci->db->from("pharma_users");
		$ci->db->where('id',$uid);
		$ci->db->where('user_status ',1);
		$query = $ci->db->get();
		if($ci->db->affected_rows()){
			$rest[]= $query->row()->id;
		}else{
			$rest[] = NULL;
		}
	}
	return array_filter($rest);
}


?>
