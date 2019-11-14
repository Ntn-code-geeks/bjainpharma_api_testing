<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LoginHandler {
    
    public function check_other_login(){
        $ci = &get_instance();
        
        if($ci->session->userdata('userId')!=NULL){
        if($ci->session->userdata('SiteUrl_id')!= base_url()){
            $ci->session->unset_userdata('userId');
            $ci->session->unset_userdata('userEmail');
            // echo "not wqual"; die;
            redirect(base_url());
        }
       
        }
    }
    
    
}