<?php
ini_set("soap.wsdl_cache_enabled","1");
//define('USERPWD', 'navlive:Le24');
define('USERPWD', 'pharma0\erpuser:pass@123');


class NTLMSoapClient extends SoapClient {  
    
    public function __construct($wsdl, $options = array()) {
        
         parent::__construct($wsdl, $options);     
       
    } 

    function __doRequest($request, $location, $action, $version,$one_way = 0) {
        $headers = array( 
            'Method: POST', 
            'Connection: Keep-Alive', 
            'User-Agent: PHP-SOAP-CURL', 
            'Content-Type: text/xml; charset=utf-8', 
            'SOAPAction: "'.$action.'"', 
        );
        
        $request = str_replace(':ns1', '', $request);
        $request = str_replace('ns1:', '', $request);

	//	echo $request;
//        $fh = fopen('100393193.xml', 'w+');
//        fwrite($fh, $request);

        $this->__last_request_headers = $headers;
        
	    $ch = curl_init($location); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
            curl_setopt($ch, CURLOPT_POST, true ); 
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request); 
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1); 
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM); 
            curl_setopt($ch, CURLOPT_USERPWD, USERPWD);        
            $response = trim(curl_exec($ch));
           // print_r($response); die;
	return $response;
    } 

    function __getLastRequestHeaders() { 
        return implode("\n", $this->__last_request_headers)."\n"; 
    } 
}


?>
