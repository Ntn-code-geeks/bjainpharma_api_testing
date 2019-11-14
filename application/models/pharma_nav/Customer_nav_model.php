<?php



/* 
 * Developer: Shailesh Saraswat
 * Email: sss.shailesh@gmail.com
 * Dated: 24-SEP-2018
 * 
 * Customer navigon connectivity
 */

class Customer_nav_model extends CI_Model {

    /* end of code for add/update dealer data*/
    public function add_update_dealer($data){
        
        $nav_customers = json_decode($data);
//      $total_customer = count($nav_customers);
        $num=0;
        //pr($nav_customers); die;
        if(!empty($nav_customers)){
        foreach ($nav_customers as $key => $value) {

             $state_id = $this->check_state($value->state_short);
            
             if(!empty($state_id)){
                 $city_id = $this->check_city($value->city_name,$state_id);
             }else{
                 $city_id ='';
             }
             
             $is_cust = $this->check_have_customer($value->dealer_code);
             if(empty($is_cust)){
             $phone = $this->check_duplicate_phone($value->Phone_No);
             }else{
                  $phone = $this->check_duplicate_phone($value->Phone_No,$is_cust);
             }
         // echo 'State:'.$state_id.'<br>';
          //  echo 'City : '.$city_id.'<br>';
           // echo $key.'->Cust code'.$is_cust.'<br>'; 
             if(!empty($state_id) && !empty($city_id) && !empty($value->city_pincode) && $phone===TRUE){
             if(empty($is_cust)){
                 
                          $dealer_data = 
                                array(
                                    'dealer_name'=>$value->name,
                                    'dealer_id'=>$value->dealer_code,
//                                    'nav_dealer_id'=>$value->dealer_code,
                                    'city_id'=>$city_id,
                                    'state_id'=>$state_id,
                                    'd_email'=>$value->email,
                                    'd_phone'=>$value->Phone_No,
                                    'd_address'=>$value->Address,
                                    'city_pincode'=>$value->city_pincode,
                                    'sp_code'=>$value->sp_code,
                                    
                                    'status'=>1,
                                    'added_date'=> savedate(),
                                    'last_update'=> savedate(),
                                    'crm_user_id' =>logged_user_data(),
                                    
                                );
                       $this->db->insert('dealer',$dealer_data);    
                       if($this->db->affected_rows()){
                           ++$num;
                       }
                    // echo $this->db->last_query().'<br>';
                       
             }elseif(!empty($is_cust)){  // update dealer
                        $dealer_data = 
                                array(
                                    'dealer_name'=>$value->name,
                                  
                                    'city_id'=>$city_id,
                                    'state_id'=>$state_id,
                                    'd_email'=>$value->email,
                                    'd_phone'=>$value->Phone_No,
                                    'd_address'=>$value->Address,
                                    'city_pincode'=>$value->city_pincode,
                                    'sp_code'=>$value->sp_code,
                                    
                                    'status'=>1,
                                    'crm_user_id' =>logged_user_data(),
                                     'last_update'=> savedate(),
                                    
                                );
                           $this->db->where('dealer_id',$is_cust);
                           $this->db->update('dealer',$dealer_data);
                           
                            if($this->db->affected_rows()){
                                    ++$num;
                                } 
                         // echo $this->db->last_query().'<br>';
             }
             
             }
        } // end of loop
        }
       
        if($num>0){
            return TRUE;
        }else{
             return FALSE;
        }
        
        
       
    }
    
    
    // check that customer are in the dealer or not
    private function check_have_customer($cust_code){
        
        $arr = 'dealer_id';
        $this->db->select($arr);
        $this->db->from('dealer');
        $this->db->where('dealer_id',$cust_code);
        $this->db->where('status',1);
        
        $query = $this->db->get();
        if($this->db->affected_rows()){
            return $query->row()->dealer_id;
            
        }else{
            
            return FALSE;
        }
        
        
        
    }
    
    // check that other customer not have same phone number
    private function check_duplicate_phone($phone_num,$is_cust=''){
        
        if(empty($is_cust)){
                $arr = 'dealer_id';
                $this->db->select($arr);
                $this->db->from('dealer');
                $this->db->where('d_phone',$phone_num);

                $query = $this->db->get();
                if($this->db->affected_rows()){
                    return FALSE;

                }else{

                    return TRUE;
                }
        
        }else{
                $arr = 'dealer_id';
                $this->db->select($arr);
                $this->db->from('dealer');
                $this->db->where('d_phone',$phone_num);
//                $this->db->where('nav_dealer_id',$is_cust);

                $query = $this->db->get();
                if($this->db->affected_rows()){
                    return TRUE;

                }else{

                    return FALSE;
                }
        }
        
        
    }

    
    // get state code
    private function check_state($state_short){
        
        switch ($state_short) {
            case 'DL':                    
                return 6;
                break;
            case 'AP':
                return 1;

                break;
            
            case 'AR':
                    return 2;

                break;
            case 'BR':
                return 4; 

                break;
            case 'CG':
                return 5;   

                break;
            
            case 'DD':
                    return 34;

                break;
            case 'DN':
                   return 33;   

                break;
            case 'GA':
                  return 29;   

                break;
            case 'GJ':
                  return 7; 

                break;
            case 'HP':
                   return 9; 

                break;
            case 'HR':
                  return 8; 

                break;
            case 'JH':
                    return 11;

                break;
            case 'JK':
                   return 10; 

                break;
            case 'KA':
                    return 12;

                break;
            case 'KL':
                   return 13; 

                break;
            case 'LD':
                   return 32;  

                break;
            case 'MH':
                   return 15;  

                break;
            case 'ML':
                   return 17; 

                break;
            case 'MN':
                  return 16;  

                break;
            case 'MP':
                   return 14; 

                break;
            case 'MZ':
                   return 18;  

                break;
            case 'NL':
                   return 19; 

                break;
            case 'OR':
                    return 20; 

                break;
            case 'OD':
                    return 20;

                break;
            case 'PB':
                    return 21;

                break;
            case 'PY':
                  return 31; 

                break;
            case 'RJ':
                   return 22; 

                break;
            case 'SK':
                   return 23;   

                break;
            case 'TN':
                  return 24;   

                break;
            case 'TS':
                   return 30;  

                break;
            case 'TR':
                  return 25;  

                break;
            case 'UP':
                   return 26; 

                break;
            case 'UK':
                   return 27;   

                break;
            case 'WB':
                   return 28;  

                break;
            case 'AS':
                return 3;

                break;
            default :
                return FALSE;
                 break;
           
        }
        
    }
    
    // get city code of the state
    private function check_city($city_name='',$stateid=''){
        
          $arr = "city_id";
          $this->db->select($arr);
          $this->db->from('city');
          
          $this->db->where('city_name',$city_name);
          $this->db->where('state_id',$stateid);
          $this->db->where('status',1);
           $query = $this->db->get();
                if($this->db->affected_rows()){
                    return $query->row()->city_id;

                }else{

                    return FALSE;
                }
          
          
          
        
    }
    
    
    
    
    


}