<?php



function set_flash($msg) {

    $ci = &get_instance();

    $ci->session->set_flashdata('tmp_flash', $msg);

}



function get_flash() {

    $ci = &get_instance();

    $msg = $ci->session->flashdata('tmp_flash');

    return $msg;

}



function encrypt_text($txt) {

    return hash_hmac('sha256', $txt, 'app[007]');

}



function isEmail($email) {

    if (filter_var($email, FILTER_VALIDATE_EMAIL))

        return true;

    else

        return false;

}



function delFile($file) {

    if (file_exists($file)) {

        unlink($file);

    }

}



function checkImageExt($filename) {

    $validExt = array('jpg', 'jpeg', 'png', 'gif');

    $ext = getExt($filename);

    if (in_array(strtolower($ext), $validExt))

        return true;

    else

        return false;

}



function getExt($file_name = '') {

    return substr($file_name, strrpos($file_name, '.') + 1, strlen($file_name) - (strrpos($file_name, '.') + 1));

}



function sendMail($to, $fromname, $fromemail, $subject, $message) {

    $CI = & get_instance();

    $CI->load->library('email');

    $mail = $CI->email;



    $config['charset'] = 'utf-8';

    $config['wordwrap'] = TRUE;

    $config['mailtype'] = 'html';

    $mail->initialize($config);



    $mail->from($fromemail, $fromname);

    $mail->to($to);

    $mail->reply_to('admin@audit.foodsafetyhelpline.com', 'FoodSafety');



    $mail->subject($subject);

    $mail->message($message);



    return $mail->send();

}



function error_msg($errors, $arg) {

    if (isset($errors[$arg]))

        echo $errors[$arg];

}



function set_error_class($errors, $class) {

    if (is_array($errors)) {

        echo "<script>";

        $ids = "";

        foreach ($errors as $k => $v) {

            if ($v)

                $ids.="#$k,";

        }

        if ($ids) {

            $ids = substr($ids, 0, -1);

            echo "jQuery('$ids').addClass('$class');";

        }

        echo "</script>";

    }

}



function array_trim($arr) {

    if (!$arr)

        return $arr;

    foreach ($arr as &$v) {

        if (!is_array($v))

            $v = trim($v);

    }

    return $arr;

}



function is_array_empty($arr) {

    if (is_array($arr)) {

        if (!$arr)

            return true;

        else {

            foreach ($arr as $v) {

                if (trim($v)) {

                    return false;

                }

            }

        }

    }

    return true;

}





/** Misc * */

function set_checked($val, $compare) {

    if ($val == $compare)

        echo 'checked="checked"';

}



function multi_arr_to_key_value($arr, $key, $val, $decodeKey = false) {

    $ar = array();

    if ($arr && is_array($arr)) {

        foreach ($arr as $d) {

            if ($d[$key]) {

                if ($decodeKey)

                    $d[$key] = encode($d[$key]);



                $ar[$d[$key]] = $d[$val];

            } else

                $ar[] = $d[$val];

        }

    }

    return $ar;

}



function pr($data) {

    echo '<pre>';

    print_r($data);

    echo '</pre>';

}



function short_string($string = '', $len = 0) {

    $string = strip_tags($string);

    $tmp = substr($string, 0, $len);

    if (strlen($string) <= $len) {

        return $string;

    }

    return $tmp . ((strlen($string) <= $len) ? '' : '...');

}



function get_ext($file_name = '') {

    return substr($file_name, strrpos($file_name, '.') + 1, strlen($file_name) - (strrpos($file_name, '.') + 1));

}



function append_filename($fn = '', $appendTxt = '') {

    $ext = getExt($fn);

    $n = str_replace("." . $ext, "", $fn);

    return $n . $appendTxt . "." . $ext;

}



function is_date_blank($date) {

    $date = trim($date);

    if (!$date || $date == "" || $date == "0000-00-00 00:00:00" || $date == "0000-00-00")

        return true;

}



function show_date($timestamp = false, $long = false, $sufix = false) {

    if ($timestamp) {

        if (!is_numeric($timestamp) && isDateBlank($timestamp))

            return;



        if (!is_numeric($timestamp))

            $timestamp = strtotime($timestamp);



        if ($sufix)

            $df = 'dS M Y';

        else

            $df = 'd M Y';



        if ($long)

            return date($df . ' - h:i A', $timestamp);

        else

            return date($df, $timestamp);

    }

}



function h($data) {

    return htmlspecialchars($data);

}



function addSlash($data) {

    if (is_array($data)) {

        $inf = array();

        foreach ($data as $field => $val) {

            if (!is_array($val))

                $inf[$field] = addslashes($val);

            else

                $inf[$field] = $val;

        }

    } else

        $inf = addslashes($data);



    return $inf;

}



function strip_slash($data) {

    if (is_array($data)) {

        $inf = array();

        foreach ($data as $field => $val) {

            if (!is_array($val))

                $inf[$field] = stripslashes($val);

            else

                $inf[$field] = $val;

        }

    } else

        $inf = stripslashes($data);



    return $inf;

}



function count_ar($arr) {

    if ($arr)

        return count($arr);

    else

        return 0;

}



function goto_page($url) {

    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

        echo '<script type="text/javascript">location.href="' . $url . '"</script>';

        exit();

    }



    if (headers_sent())

        echo '<script type="text/javascript">location.href="' . $url . '"</script>';

    else

        header('Location: ' . $url);



    exit();

}



function is_ajax() {

    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

}



function get_lat_long($address) {

    $address = str_replace(" ", "+", $address);

    $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=India";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    $response = curl_exec($ch);

    curl_close($ch);

    $response_a = json_decode($response);

//    pr($response_a); die;

    $lat = $response_a->results[0]->geometry->location->lat;

    $long = $response_a->results[0]->geometry->location->lng;



    return array("Lat" => $lat, "Long" => $long);

}



function js_array($array, $f) {

    $temp = array();

    foreach ($array as $value) {

        if ($f)

            $temp[] = '"' . addcslashes($value[$f], "\0..\37\"\\") . '"';

        else

            $temp[] = '"' . addcslashes($value, "\0..\37\"\\") . '"';

    }



    return '[' . implode(',', $temp) . ']';

}



function replace_for_url($arg, $repW = 0) {

    if (!$repW)

        $repW = '-';



    $arg = trim($arg);



    $arg = str_replace(' - ', '-', $arg);

    $arg = str_replace('- ', '-', $arg);

    $arg = str_replace(' -', '-', $arg);

    $arg = str_replace(' ? ', '', $arg);

    $arg = str_replace('? ', '', $arg);

    $arg = str_replace(' ?', '', $arg);

    $arg = str_replace('?', '', $arg);



    $arg = str_replace(' + ', $repW, $arg);

    $arg = str_replace('+ ', $repW, $arg);

    $arg = str_replace(' +', $repW, $arg);

    $arg = str_replace('+', $repW, $arg);



    $arg = str_replace(' & ', $repW, $arg);

    $arg = str_replace('& ', $repW, $arg);

    $arg = str_replace(' &', $repW, $arg);

    $arg = str_replace('&', $repW, $arg);



    $arg = str_replace(' : ', $repW, $arg);

    $arg = str_replace(': ', $repW, $arg);

    $arg = str_replace(' :', $repW, $arg);

    $arg = str_replace(':', $repW, $arg);



    $arg = str_replace('/', $repW, str_replace('\\', $repW, str_replace(' ', $repW, $arg)));



    return $arg;

}



function replace_sp_char($arg, $repW = 0) {

    if (!$repW)

        $repW = '-';

    $arg = preg_replace('/[^a-zA-Z0-9_\-]/', $repW, $arg);

    return $arg;

}



function encode_html($arg) {

    $arg = str_replace('<', '&lt;', $arg);

    return str_replace('>', '&gt;', $arg);

}



function encode_script($arg) {

    $arg = str_replace('<script>', '&lt;script&gt;', $arg);

    return str_replace('</script>', '&lt;/script&gt;', $arg);

}



function setCss($id, $class, $errMsg) {

    if ($errMsg) {

        echo '<script>jQuery("#' . $id . '").addClass("' . $class . '")</script>';

    }

}



function removeCss($id, $class) {

    echo '<script>jQuery("#' . $id . '").removeClass("' . $class . '")</script>';

}



function numbers_arr($from, $to, $leadzero = 0, $sufix = 0) {

    $ar = array();

    $sf = "";

    if ($sufix)

        $sf = $sufix;

    for ($i = $from; $i <= $to; $i++) {

        if ($leadzero && $i < 10)

            $n = "0" . $i;

        else

            $n = $i;

        $ar[$i] = $n . $sf;

    }

    return $ar;

}



function del_file($file) {

    if (file_exists($file)) {

        unlink($file);

    }

}



function rename_file_if_exist($path, $file) {

    $file = str_replace(' ', '-', $file);

    if (file_exists($path . $file)) {

        $file = append_file_name($file, '-' . time());

    }

    return $file;

}



function xml2array($xml) {

    $get = file_get_contents($xml);

    $array = simplexml_load_string($get);

    return $array;

}



function is_email($email) {

    if (filter_var($email, FILTER_VALIDATE_EMAIL))

        return true;

    else

        return false;

}



function time_stamp($T) {

    if (!$T)

        return '';



    if (!is_numeric($T) && isDateBlank($T))

        return '';



    if (!is_numeric($T))

        $T = strtotime($T);

    return date('Y-m-d H:i:s', $T);

}



/** Paging * */

function paging_links($data, $url, $activeClass = '', $sep = '') {

    if (!$data)

        return;



    $start = $data['start'];

    $total_pages = $data['total_pages'];

    $cur_page = $data['cur_page'];



    $pages = array();

    if ($total_pages > 1) {

        $qs = "";

        if ($_GET) {

            foreach ($_GET as $k => $v) {

                if (trim($v))

                    $qs.=$k . "=" . $v . "&";

            }

        }



        if (!empty($qs))

            $qs = '/?' . substr($qs, 0, -1);



        if (substr($url, -1, 1) == '/')

            $url = substr($url, 0, -1);



        for ($i = 1; $i <= $total_pages; $i++) {

            if ($cur_page == $i)

                $link = '<a href="' . $url . '/' . $i . $qs . '" class="' . $activeClass . '">' . $i . '</a>';

            else

                $link = '<a href="' . $url . '/' . $i . $qs . '">' . $i . '</a>';



            echo $link;



            if ($sep && $i < $total_pages)

                echo '' . $sep . '';

        }

    }

}



function paging_numbers($data, $url) {

    $start = $data['start'];

    $total_pages = $data['total_pages'];

    $cur_page = $data['cur_page'];

    $pages = array();

    if ($total_pages > 1) {

        $qs = "";

        if ($_GET) {

            foreach ($_GET as $k => $v) {

                if (trim($v))

                    $qs.=$k . "=" . $v . "&";

            }

        }



        if (!empty($qs))

            $qs = '/?' . substr($qs, 0, -1);



        for ($i = 1; $i <= $total_pages; $i++) {

            $pages[$i] = $url . '/' . $i . $qs;

        }

    }



    return $pages;

}



/** * */

function delete_files_from_folder($dir) {

    error_reporting(0);

    foreach (scandir($dir) as $file) {

        if ('.' === $file || '..' === $file)

            continue;

        if (is_dir("$dir/$file"))

            deleteFilesFromFolder("$dir/$file");

        else

            unlink("$dir/$file");

    }

    //rmdir($dir); //it will delete folders too.

}



function get_curl($url, $data = null) {

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_HEADER, 0);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_POST, true);





    //curl_setopt($ch, CURLOPT_PORT , 80); 

    //curl_setopt($ch, CURLOPT_SSLVERSION,3);

    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);



    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $output = curl_exec($ch);



    //$info = curl_getinfo($ch);

    curl_close($ch);



    return $output;

}



/** Arrays Functions * */

function arrayFilter($array, $index, $value) {

    $newarray = array();

    if (is_array($array) && count($array) > 0) {

        foreach (array_keys($array) as $key) {

            $temp[$key] = $array[$key][$index];



            if ($temp[$key] == $value) {

                $newarray[$key] = $array[$key];

            }

        }

    }

    return $newarray;

}



/** * */

function send_mail($to, $fromname, $fromemail, $subject, $message) {

    if ($_SERVER['HTTP_HOST'] == 'localhost') {

        tmpSendMail($to, $fromname, $fromemail, $subject, $message);

        return;

    }



    $fromemail = ADMIN_EMAIL;

    if (!$fromname)

        $fromname = "LinkBook";



    $CI = & get_instance();

    $CI->load->library('email');

    $mail = $CI->email;



    $config['charset'] = 'utf-8';

    $config['wordwrap'] = TRUE;

    $config['mailtype'] = 'html';

    $mail->initialize($config);



    $mail->from($fromemail, $fromname);

    $mail->to($to);

    $mail->reply_to('no-reply@pics.com', 'PICS');



    $mail->subject($subject);

    $mail->message($message);



    return $mail->send();

}



function tmp_send_mail($to, $fromname, $fromemail, $subject, $message) {

    if (!$fromemail)

        $fromemail = ADMIN_EMAIL;



    if (!$fromname)

        $fromname = "LinkBook";



    $data['to'] = $to;

    $data['fromname'] = $fromname;

    $data['fromemail'] = $fromemail;

    $data['subject'] = $subject;

    $data['message'] = $message;

    getCurl("http://wackybrain.co/work/sat/mail.php", $data);

    return;

}



function set_session($sname, $val) {

    $ci = &get_instance();

    $ci->session->set_userdata($sname,$val);    

}



function get_session($sname) {

    $ci = &get_instance();

    return $ci->session->userdata($sname);

   // pr($ci->session->userdata($sname));

   // die();

}



function unset_session($sname) {

    unset($_SESSION[$sname]);

}



function destroy_session($sname) {

    session_destroy();

}



/** * */

function replace_null($arr) {

    if (!is_array($arr))

        return $arr;



    foreach ($arr as $k => $v) {

        if (!$v && $v != 0)

            $arr[$k] = '';

    }



    return $arr;

}



function current_dt() {

    return date('Y-m-d H:i:s');

}



function check_image_ext($filename) {

    $validExt = array('jpg', 'jpeg', 'png', 'gif');

    $ext = getExt($filename);

    if (in_array(strtolower($ext), $validExt))

        return true;

    else

        return false;

}



/** Push Notification * */

function push_notification($deviceToken, $message) {

    error_reporting(0);

    $deviceToken = trim($deviceToken);

    if (!$deviceToken)

        return;



    //$passphrase = 'push';

    $passphrase = '';

    //echo $deviceToken.'<br>'.$message;

    $ctx = stream_context_create();

    stream_context_set_option($ctx, 'ssl', 'local_cert', 'pem/dev.pem');

    stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);



    $fp = stream_socket_client(

            'ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);



    $body['aps'] = array(

        'alert' => $message,

        'sound' => 'default'

    );



    // Encode the payload as JSON

    $payload = json_encode($body);



    // Build the binary notification

    $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;



    // Send it to the server

    $result = fwrite($fp, $msg, strlen($msg));

    //echo $deviceToken;

    if (!$result) {//echo 'fail'; die;

        fclose($fp);

        return 'Message not delivered' . PHP_EOL;

    } else {//echo 'success'; die;

        fclose($fp);

        return 'Message successfully delivered' . PHP_EOL;

    }



    //echo json_encode($result;);

    fclose($fp);

}

/**

 * 

 *  Function for written clean variable

 * @Created By:  Nitish Kaushal

 * @Created On:  20 Aug 2015

 * @Email:       nitish.kaushal@apptology.com

 */

function clean_var($var){

    $ci = &get_instance();

    return $ci->security->xss_clean($var);

}



/**

 * Function for get marital status

 * @Created By:  Nitish Kaushal

 * @Created On:  24 Aug 2015

 * @Email:       nitish.kaushal@apptology.com

 */

function get_marital_status($code){

    switch($code):

        case '0':

            return 'Single';

            break;

        case '1':

            return 'Married';

            break;

        case '2':

            return 'Divorced or Widowed';

            break;

        default:

            return 'Unknown';

            break;

    endswitch;

}

/**

 * Function for get parent child relation array for select

 * @Created By:  Nitish Kaushal

 * @Created On:  24 Aug 2015

 * @Email:       nitish.kaushal@apptology.com

 */

function tree_list_options($tbl_name,$field='',$parent_record){

    //  same as above

    $CI =& get_instance();

    //  $where_arr for selecting data

    $where_arr='';

    //  $field is empty then we dont need to select parent

    if($field!=''){

        //	set where array

        $where_arr["$field"]=$parent_record;

        // Add Where query

        $CI->db->where($where_arr);

    }

    /**

        *	get data from get_table_data

        *	file: helpers/common_helper

    **/

    $data=$CI->db->get($tbl_name)->result_array(); 

    $options=array();

    if(count($data)>0)

    {

        // if data has rows

        foreach($data as $key=>$row)

        {

            //	set options array

            $options[$row['id']]=$row['title'];

            if($field!=''){

                // if parent id not equals to 0

                if($CI->db->get_where($tbl_name,array($field=>$row['id']))->num_rows()){

                    //	recursive call

                    $sub_data=tree_list_options($tbl_name,$field,$row['id']);

                    foreach($sub_data as $sub_row=>$value){

                        //	set options array

                        $options[$sub_row]='--'.$value;

                    }

                }		

            }

        }

    }

    return $options;	

}

/**

 * Function for record count

 * @Created By:  Nitish Kaushal

 * @Created On:  25 Aug 2015

 * @Email:       nitish.kaushal@apptology.com

 */ 

function get_total_record($tbl_name,$whr_arr=array()){

    //  same as above

    $CI =& get_instance();

    if(!empty($whr_arr)){

        $CI->db->where($whr_arr);

    }

    return $CI->db->get($tbl_name)->num_rows();

}



/**

 * Function for validate date format

 * @CreatedBy: Nitish kaushal

 * @CreatedAt: 28 Aug 2015

 * Email: nitish.kaushal@apptology.com

 * @param1 date required

 */

function validate_date_format($date){

    // date format Y-m-d check

    if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date ))    {

        return 1;

    }

    // date format d-m-Y check

    elseif(preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$date )){

        return 1;

    }

    // else

    else{

        return 0;

    }    

}



function get_sidebar(){

    $ci=& get_instance();

    

    return  $ci->db->where('status',1)

            ->order_by('permissionOrder','asc')

            ->get('permissions')->result_array();    

}





function get_sidebar_name(){

    $ci=& get_instance();

    

    return  $ci->db->where('id',$_SESSION['PicsUser']['id'])

                   ->get('user')->row();    

}



function location_By_Lat_Long($lat, $long)

{

    if($lat==0 || $long==0 || $lat==NULL || $long==NULL)

        return 'NA';

    $geocode=file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$long.'&sensor=false');

    $output= json_decode($geocode);

   // return print_r($output);

    if($output->status!='OK')

        return 'NA';

    else     

        $location=$output->results[0]->formatted_address;

    if(!empty($location))

        return $location;

    else

        return 'NA';

}





function email_setting(){

//   $emailConfig1 = Array(
////        'useragent'=>'CodeIgniter',
////        'protocol'=>'smasfasftp',
////        'smtp_host'=>'localasfafhost',
////        'smtp_user'=>'info@bjaasfasfincorp.com',
////        'smtp_pass'=>'inhasfasf0u$e#$&6',
////        'charset'=>'utf-8',
////        'smtp_port'=>25, // use 3535 for server, 25 and localhost
////        'sendmail_path'=>'', ///usr/sbin/sendmail
////        'smtp_crypto'=>'none', //tls or ssl
////        'mailtype'=>'html',
////        'wordwrap'=>true,
////        'newline'=>'\r\n'
////    );
//    $emailConfig = Array(
//        'useragent'=>'CodsfsfseIgniter',
//        'protocol'=>'smasfastp',
//        'smtp_host'=>'smtpsasfasffsfsout.secureserver.net',
//        'smtp_user'=>'websfasasfasite@bjain.com',
//        'smtp_pass'=>'afroasfasfj@123', //'bjainindia1',
//        'charset'=>'utf-8',
//        'smtp_port'=>'80', // use 3535 for server, 25 and localhost
//        'sendmail_path'=>'/usr/sbin/sendmail',
//        'mailtype'=>'html',
//        'wordwrap'=>true,
//        'newline'=>'\r\n'
//    );

	$email_config = Array(
		'useragent'=>'CodeIgniter',
		'protocol'=>'SMTP',
		'smtp_host' => 'ssl://smtp.googlemail.com',
		'smtp_user'=>'info@bjain.com',
		'smtp_pass'=>'happy@365',
		'charset'=>'utf-8',
//        'smtp_port'=>25, // use 3535 for server, 25 and localhost
		'smtp_port'=>465, // use 3535 for server, 25 and localhost
		'sendmail_path'=>'', ///usr/sbin/sendmail
		'smtp_crypto'=>'none', //tls or ssl
		'mailtype'=>'html',
		'wordwrap'=>true,
		'newline'=>'\r\n'
	);
    return $email_config;

}



?>
