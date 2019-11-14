<?php



/**

 * Functions class for load child users doctor and pharmacy data

 * @author : Niraj Kumar

 * 

 * Dated: 26-oct-2017

 */

class Common_functions_lib {

    

    # child user doctor list

    public function inferior_user_doc_list(){

            

        $CI = & get_instance();

        

        $CI->load->model('doctor/Doctor_model','doctor');     

        

        $childs_doctor = $CI->doctor->childs_doctor_data(logged_user_data());

        

        $childs = json_decode($childs_doctor);

        return $childs;



    }

    

    

     # child user pharmacy list

    public function inferior_user_pharma_list(){

            

        $CI = & get_instance();

        

        $CI->load->model('pharmacy/pharmacy_model','pharmacy');     

        

        $childs_pharma = $CI->pharmacy->childs_pharmacy_data(logged_user_data());

        

        $childs = json_decode($childs_pharma);

        return $childs;



    }

 



}

