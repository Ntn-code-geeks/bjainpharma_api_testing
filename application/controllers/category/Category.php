<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Niraj Kuamr
 * Dated: 12/03/2018
 * 
 * This Controller is for Add Category
 */

class Category extends Parent_admin_controller {

   function __construct() 
    {
        parent::__construct();
            $loggedData=logged_user_data();
            
            if(empty($loggedData)){
                redirect('user'); 
            }
        $this->load->model('category/category_model','category');
    }
    
    public function index(){    
		$data['title'] = "Category List";
        $data['page_name'] = "Category List";
		$data['category_list']=array();
		$categoryList= $this->category->get_category();
		if($categoryList!=FALSE)
		{
			$data['category_list'] =$this->category->get_category(); 
		}
        $this->load->get_view('category/category_list_view',$data);
    }

    public function add_category(){
		$data['category_list']=array();
		$data['title'] = "Create Category";
        $data['page_name'] = "Create Category";
		$categoryList= $this->category->get_category();
		if($categoryList!=FALSE)
		{
			$data['category_list'] =$this->category->get_category(); 
		}
		$data['action'] = "category/category/save_category"; 
//      pr(json_decode($data['ap_list'])); die;
        $this->load->get_view('category/add_category_view',$data);
    }
	
	public function save_category(){
		$post_data = $this->input->post();
		$this->load->library('form_validation');
        $this->form_validation->set_rules('cat_name', 'Category name', "required");
		if($this->form_validation->run() == TRUE){
			$success= $this->category->save_category($post_data);
			if($success)
			{
				set_flash('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Success!</h4>Category Successfully Added. </div>'); 
				redirect('category/category/index');
			}
			else
			{
				set_flash('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>Category Can Not Successfully Added.</div>');
				redirect('category/category/add_category');
			}
		}
		else{
			$this->add_category();
		}
    }
	
		
	public function edit_category($id=''){
		$data['city_list']=array();
        $categoryid= urisafedecode($id);
		$data['category_list']=array();
		$categoryList= $this->category->get_category();
		if($categoryList!=FALSE)
		{
			$data['category_list'] =$this->category->get_category(); 
		}
		$data['title'] = "Edit Category";
        $data['page_name'] = "Edit Category";
		$data['action'] = "category/category/update_category";
		$data['category_data']=array();
		$categoryData=$this->category->get_category_data($categoryid);
		if($categoryData!=FALSE)
		{
			$data['category_data'] =$categoryData; 
		}
		$this->load->get_view('category/edit_category_view',$data);
    }
	
	public function update_category(){
		$post_data = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cat_name', 'Category name', "required");
		if($this->form_validation->run() == TRUE){
			$success=$this->category->update_category($post_data);
			if($success==1){  // on sucess
			
				set_flash('<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-check"></i> Success!</h4>
				Category Successfully Updated. </div>'); 
				redirect('category/category/index');
			   
		   }
		   else{ // on fail
			   set_flash('<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-ban"></i> Alert!</h4>
				Category Not Successfully Updated.</div>');
				redirect('category/category/edit_category/'.urisafeencode($post_data['category_id']));
		   }

		}
		else{
			$this->edit_category(urisafeencode($post_data['category_id']));
		}
    }

}

?>