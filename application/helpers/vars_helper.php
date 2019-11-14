<?php



define('USR_SESSION_NAME', 'PicsUser');



function pharma_pagination($url,$total_record){

    $CI = &get_instance();

//    echo $url; die;

    $CI->load->library("pagination");  

                         

                         $config = array();

        $config["base_url"] = base_url().$url;

        $config["total_rows"] = $total_record;

        $config["per_page"] = 20;

        $config["uri_segment"] = 3;



        $config['full_tag_open'] = '<div class="pagination" style="margin:0px;"><ul class="pagination">';

			$config['full_tag_close'] = '</ul></div>';

			

			$config['first_link'] = '&laquo; First';

			$config['first_tag_open'] = '<li class="prev page">';

			$config['first_tag_close'] = '</li>';



			$config['last_link'] = 'Last &raquo;';

			$config['last_tag_open'] = '<li class="next page">';

			$config['last_tag_close'] = '</li>';



			$config['next_link'] = 'Next >>';

			$config['next_tag_open'] = '<li class="next page">';

			$config['next_tag_close'] = '</li>';



			$config['prev_link'] = '<< Previous';

			$config['prev_tag_open'] = '<li class="prev page">';

			$config['prev_tag_close'] = '</li>';



			$config['cur_tag_open'] = '<li class="active"><a href="">';

			$config['cur_tag_close'] = '</a></li>';



			$config['num_tag_open'] = '<li class="page">';

			$config['num_tag_close'] = '</li>';

        

        

        $CI->pagination->initialize($config);



    $page = ($CI->uri->segment(3))? encode($CI->uri->segment(3)) : 0;



     $data["links"] = $CI->pagination->create_links();

    

    $page_info = array('per_page'=>$config["per_page"],'page'=>$page,'links'=>$data["links"]);

    

    return $page_info;

}





//define('URL', base_url(''));

//define('AURL', base_url('assets/backend/') . '/');

//define('IMURL', base_url('assets/backend/images') . '/');

//define('REPORT_PDF', 'uploads/reports/');

//

//define('ADM_URL', base_url('admin') . '/');

//define('USR_URL', base_url('user') . '/');

//

//define('REQ_URI', $_SERVER['REQUEST_URI']);

//

//define('SITE_NAME', 'Food Safety');

//define('VERSION', '1.01');

//

//define('PAGE_SIZE', 30);

//define('ADMIN_EMAIL', 'admin@audit.foodsafetyhelpline.com');

//define('ADM_MOB', 8510074200);

//

//define('AUDIT_IMAGE', 'assets/uploads/audit_images/');

//define('AUDIT_SIGN', 'assets/uploads/audit_sign/');

//define('SIGNATURES', 'assets/uploads/signatures/');

//define('PROFILE_IMG_DIR', 'assets/uploads/users/profimg/');

//define('MANUAL_PDF', 'assets/uploads/manual_pdf/');

//define('SUBCAT_IMAGE', 'assets/uploads/subcat_image/');

?>