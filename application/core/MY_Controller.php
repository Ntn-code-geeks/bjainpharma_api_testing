<?php

class MY_Controller extends CI_Controller {

//    function __construct() {
//        parent::__construct();
//        $userDtl = get_session(USR_SESSION_NAME);
//        define('USER_ID', $userDtl['id']);
//       
//    }
//
//    function is_logged() {
//        if ($rs = get_session(USR_SESSION_NAME)) {
//            return $rs;
//        } else
//            return false;
//    }
//
//    function logged_data() {
//        $data = get_session(USR_SESSION_NAME);
//        return $data;
//    }
//
//    function redirect_logged() {
//        if ($dtl = $this->is_logged()) {
//            redirect('user/check_login');
//        }
//    }
//
//    function redirect_not_logged() {
//        if (!$this->is_logged())
//            redirect('user');
//    }

}

class Parent_admin_controller extends MY_Controller {
    function __construct() {
      
        parent::__construct();
//        if ($this->uri->rsegments[2] != 'login') {
//            $this->redirect_not_logged();
//            if (defined('USER_TYPE') && USER_TYPE != 'A' AND USER_TYPE != 'S')
//                show_404();
//        }
    }

}
