<?php

/* 
 * Developer:shailesh saraswat
 * Email:sss.shailesh@gmail.com
 * Dated: 16-Aug-2018
 * 
 * For fetch my customer list of a user
 */
//function brandlog($order){ 

 include("php_nav_lib/Navision.php");
 include("php_nav_lib/ntlm.php");

if(isset($_GET['spcode'])){
    
  $spcode = $_GET['spcode'];

 stream_wrapper_unregister('http');
 // we register the new HTTP wrapper
 stream_wrapper_register('http', 'NTLMStream') or die("Failed to register protocol");
// $page = new NTLMSoapClient('http://192.168.1.81:7047/DynamicsNAV/WS/Codeunit/WebshopRequestManagement');
// $page = new NTLMSoapClient('http://110.172.147.196:9048/bjainlive/WS/B.%20Jain%20Pharma-2017/Page/MyCustomer');
 
 $baseURL = 'http://110.172.147.196:9048/bjainlive/WS/';
$CompanyName = 'B. Jain Pharma-2017';
$pageURL = $baseURL.rawurlencode($CompanyName).'/Page/MyCustomer';
//  echo "<br>URL of Customer page: $pageURL<br><br>"; 


try{
  
 $service = new NTLMSoapClient($pageURL);
//print_r($service); die;
 $params = array('filter' =>array( 
  array('Field'=>'Salesperson_Code','Criteria'=>$spcode) ) ,'setSize'=>0);
 $result = $service->ReadMultiple($params);
   
 //$resultSet = $result->ReadMultiple_Result->MyCustomer;
 $customer= $result->ReadMultiple_Result->MyCustomer;
//print_r(($customer));
//echo $customer;
$customer_data =array();
 if(is_array($customer)){
     foreach($customer as $k=>$rec){
         $customer_data[$k]['name'] = $rec->Name;
         $customer_data[$k]['balance'] = $rec->Balance_LCY;
     }
     print_r(json_encode($customer_data));
 }else{
      echo $customer_data;
 }
 
}
catch (Exception $e) {
    
 echo "<hr><b>ERROR: SoapException:</b> [".$e."]<hr>";
 echo "<pre>".htmlentities(print_r($service->__getLastRequest(),1))."</pre>";
 
}
 stream_wrapper_restore('http');
}else{
    return FALSE;
}

 ?>
