<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<script src="<?php echo base_url();?>design/bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
$(".search_sidebar").keyup(function() 
{ 
//    alert('demo');
var searchid = $(this).val();
var dataString = 'search='+ searchid;

if(searchid!='')
{
    $.ajax({
    type: "POST",
    url: "<?= base_url()?>global_search/search_suggestion",
    data: dataString,
    cache: false,
    success: function(html)
    {   
    $("#result_sidebar").html(html).show();
    }
    });
}return false;    
});

jQuery("#result_sidebar").click(function(e){ 
 
	var $clicked = $(e.target);
	var $name = $clicked.find('.name').html();
       
	var decoded = $("<div/>").html($name).text();
//        alert(decoded);
	$('#searchid_sidebar').val(decoded);
});
jQuery(document).click(function(e) { 
//      alert("hello");
	var $clicked = $(e.target);
	if (! $clicked.hasClass("search")){
	jQuery("#result_sidebar").fadeOut(); 
	}
});
$('#searchid_sidebar').click(function(){
     
	jQuery("#result_sidebar").fadeIn();
});
});
</script>
<style type="text/css">
	#searchid_sidebar
	{
		/*width:500px;*/
		/*border:solid 1px #000;*/
		padding:10px;
		font-size:14px;

                /*color: #fff;*/
	}
	#result_sidebar
	{
		/*position:absolute;*/
		width:100%;
		padding:10px;
		display:none;
		margin-top:-1px;
		border-top:0px;
		overflow:hidden;
		border:1px #CCC solid;
		color: #fff;
    background-color: #374850;
    z-index: 999;
    margin-top: 32px;
    max-height: 300px;
    overflow-y: auto;
	}
	.show
	{
		padding:10px; 
		border-bottom:1px #999 dashed;
		font-size:15px; 
		height: auto !important;
    word-break: break-all;
	}
	.show:hover
	{
		background:#4c66a4;
		color:#FFF;
		cursor:pointer;
	}
</style>

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
 
      <!-- search form -->
    
      <form method="GET" action="<?= base_url()?>global_search/search" class="sidebar-form">
        <div class="input-group">
          <!--<input type="text" id="searchid_sidebar" name="table_search" class="form-control search_sidebar" placeholder="Search...">-->
          
            <input name="table_search" id="searchid_sidebar" class="form-control pull-right search_sidebar" placeholder="Search" type="text" style='height: 34px'>
            <div id="result_sidebar"></div>
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                  <i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li>
            <a href="<?= base_url();?>user/dashboard">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <!--<i class="fa fa-angle-left pull-right"></i>-->
            </span>
          </a>
<!--          <ul class="treeview-menu">
            <li><a href="<?= base_url();?>user/dashboard"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
            <li class="active"><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
          </ul>-->
        </li>
        
        
        
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>C & F List</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        <ul class="treeview-menu">
     
            <li><a href="<?= base_url();?>dealer/dealer/add_main_dealer"><i class="fa fa-circle-o"></i>Add </a></li>
            <li><a href="<?= base_url();?>dealer/dealer/main_dealer_view"><i class="fa fa-circle-o"></i>View</a></li>
          
        </ul>
        </li>
        
        
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Dealer List</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        <ul class="treeview-menu">
        <li><a href="<?= base_url();?>dealer/dealer"><i class="fa fa-circle-o"></i>Add</a></li>
            <!--<li><a href="<?= base_url();?>school/school_add/edit_school"><i class="fa fa-circle-o"></i> Edit</a></li>-->
            <li><a href="<?= base_url();?>dealer/dealer/dealer_view"><i class="fa fa-circle-o"></i>View</a></li>
<!--            <li><a href="<?= base_url();?>dealer/dealer/add_main_dealer"><i class="fa fa-circle-o"></i>Add Main Dealer</a></li>
            <li><a href="<?= base_url();?>dealer/dealer/main_dealer_view"><i class="fa fa-circle-o"></i>Main Dealer View</a></li>-->
          </ul>
        </li>
    
        
        
        <li class="treeview">
          <a href="#">
            <i class="fa fa-medkit" aria-hidden="true"></i>
            <span>Pharmacy List</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
           <ul class="treeview-menu">
            <li><a href="<?= base_url();?>pharmacy/pharmacy/add_list"><i class="fa fa-circle-o"></i> Add</a></li>
            <!--<li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Edit</a></li>-->
            <li><a href="<?= base_url();?>pharmacy/pharmacy"><i class="fa fa-circle-o"></i> View</a></li>
           <?php
            $childs = $this->common_functions_lib->inferior_user_pharma_list();
//            pr($childs); die;
             if(!empty($childs->childuserid)){
        $child1 ='';
        }
        if(!empty($childs->childuserid2)){
        $child2 ='';
        }
        
        if(!empty($childs->childuserid3)){
        $child3 ='' ;
        }
        
        if(!empty($childs->childuserid4)){
        $child4 ='';
        }
         if(!empty($childs->childuserid5)){
        $child5 ='' ;
        }
            
            if(isset($child1) || isset($child2) || isset($child3) || isset($child4) || isset($child5) ){
            ?>
         <li class="treeview">
              <a href="#"><i class="fa fa-medkit"></i> Inferior Employee Pharmacy
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
              
                <?php if (isset($child1)){?>
                <li><a href="<?= base_url();?>pharmacy/pharmacy/child1"><i class="fa fa-circle-o"></i> Level One </a></li>
                <?php } ?>
                  
                <?php if (isset($child2)){?>  
                <li><a href="<?= base_url();?>pharmacy/pharmacy/child2"><i class="fa fa-circle-o"></i> Level Two </a></li>
                <?php } ?>
                <?php if (isset($child3)){?> 
                <li><a href="<?= base_url();?>pharmacy/pharmacy/child3"><i class="fa fa-circle-o"></i> Level Three </a></li>
                 <?php } ?>
                <?php if (isset($child4)){?> 
                <li><a href="<?= base_url();?>pharmacy/pharmacy/child4"><i class="fa fa-circle-o"></i> Level Four</a></li>
                 <?php } ?>
                <?php if (isset($child5)){?> 
                <li><a href="<?= base_url();?>pharmacy/pharmacy/child5"><i class="fa fa-circle-o"></i> Level Five</a></li>
                 <?php } ?>
              
              </ul>
            </li>
              <?php } ?>
           
           
           </ul>
        </li>
        
        <li class="treeview">
          <a href="#">
            <i class="fa fa-user-md"></i>
            <span>Doctor List</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
           <ul class="treeview-menu">
            <li><a href="<?= base_url();?>doctors/doctor/add_list"><i class="fa fa-circle-o"></i> Add</a></li>
            
            <li><a href="<?= base_url();?>doctors/doctor"><i class="fa fa-circle-o"></i> View</a></li>
          
            
            <?php
            $childs = $this->common_functions_lib->inferior_user_doc_list();
//            pr($childs); die;
             if(!empty($childs->childuserid)){
        $child1 ='';
        }
        if(!empty($childs->childuserid2)){
        $child2 ='';
        }
        
        if(!empty($childs->childuserid3)){
        $child3 ='' ;
        }
        
        if(!empty($childs->childuserid4)){
        $child4 ='';
        }
         if(!empty($childs->childuserid5)){
        $child5 ='' ;
        }
            
            if(isset($child1) || isset($child2) || isset($child3) || isset($child4) || isset($child5) ){
            ?>
         <li class="treeview">
              <a href="#"><i class="fa fa-user-md"></i> Inferior Employee Doctor
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
              
                <?php if (isset($child1)){?>
                <li><a href="<?= base_url();?>doctors/doctor/child1"><i class="fa fa-circle-o"></i> Level One </a></li>
                <?php } ?>
                  
                <?php if (isset($child2)){?>  
                <li><a href="<?= base_url();?>doctors/doctor/child2"><i class="fa fa-circle-o"></i> Level Two </a></li>
                <?php } ?>
                <?php if (isset($child3)){?> 
                <li><a href="<?= base_url();?>doctors/doctor/child3"><i class="fa fa-circle-o"></i> Level Three </a></li>
                 <?php } ?>
                <?php if (isset($child4)){?> 
                <li><a href="<?= base_url();?>doctors/doctor/child4"><i class="fa fa-circle-o"></i> Level Four</a></li>
                 <?php } ?>
                <?php if (isset($child5)){?> 
                <li><a href="<?= base_url();?>doctors/doctor/child5"><i class="fa fa-circle-o"></i> Level Five</a></li>
                 <?php } ?>
              
              </ul>
            </li>
              <?php } ?>

           </ul>
        </li>
        
        
        
        
       <?php /*?><li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i> 
            <span>Appointment</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?= base_url();?>appointment/appoint/add_appointment"><i class="fa fa-circle-o"></i> Add</a></li>
            <!--<li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Edit</a></li>-->
            <li><a href="<?= base_url();?>appointment/appoint"><i class="fa fa-circle-o"></i> View</a></li>
            <!--<li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>-->
          </ul>
        </li><?php */?>

        <!-- <li>
          <a href="<?= base_url();?>to_do_list/to_do">
            <i class="fa fa-tasks"></i>
            <span>To Do List</span>
            <span class="pull-right-container">
              <small class="fa fa-angle-left pull-right"></small>
            </span>
          </a>

        </li> -->
		
		<li>
          <a href="<?= base_url();?>tour_plan/tour_plan">
            <i class="fa fa-bus"></i>
            <span>Tour Plan</span>
            <span class="pull-right-container">
              <!--<small class="fa fa-angle-left pull-right"></small>-->
            </span>
          </a>

        </li>
		
		<li>
          <a href="<?= base_url();?>leave/user_leave/user_leave_list">
            <i class="fa fa-calendar"></i>
            <span>Apply Leave</span>
            <span class="pull-right-container">
              <!--<small class="fa fa-angle-left pull-right"></small>-->
            </span>
          </a>

        </li>
		<li>          <a href="<?= base_url();?>interaction/index/">      
     <i class="fa fa-handshake-o"></i>            <span>Add Interaction</span>            <span class="pull-right-container">              <!--<small class="fa fa-angle-left pull-right"></small>-->            </span>          </a>        </li>
		<li>
          <a href="<?= base_url();?>meeting/meeting/index">
            <i class="fa fa-users"></i>
            <span>Add Meetings</span>
            <span class="pull-right-container">
              <!--<small class="fa fa-angle-left pull-right"></small>-->
            </span>
          </a>
        </li>
        
        <li>
          <a href="<?= base_url();?>secondary_supply/secondary_supply">
            <i class="fa fa-tasks"></i>
            <span>Secondary Supply</span>
            <span class="pull-right-container">
              <!--<small class="fa fa-angle-left pull-right"></small>-->
            </span>
          </a>

        </li> 		
      <!--	<li class="treeview">    
            <a href="#">       
               <i class="fa fa-shopping-cart"></i>   
                <span>Order</span>  
                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i>   </span>         
             </a>    
              <ul class="treeview-menu">	
                <li><a href="<?= base_url();?>order/interaction_order/">
                  <i class="fa fa-circle-o"></i> Order List</a></li>	
                <li><a href="<?= base_url();?>order/interaction_order/complete_order_list"><i class="fa fa-circle-o"></i>Complete Order List</a></li>	
                <li><a href="<?= base_url();?>order/interaction_order/cancel_order_list"><i class="fa fa-circle-o"></i>Cancel Order List</a></li> 
              </ul>      
          </li> -->
		
		<!--<li class="treeview">
          <a href="#">
            <i class="fa fa-bus"></i>
            <span>Transit</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        <ul class="treeview-menu">
			<li><a href="<?= base_url();?>transit/transit"><i class="fa fa-circle-o"></i>Transit List</a></li>
			<li><a href="<?= base_url();?>transit/transit/add_transit"><i class="fa fa-circle-o"></i>Add Transit</a></li>
			<li><a href="<?= base_url();?>transit/transit/add_other_transit"><i class="fa fa-circle-o"></i>Other Transit</a></li>
        </ul>
        </li>-->
        
        <li class="treeview">
			<a href="#">
				<i class="fa fa-handshake-o"></i>
				<span>Interaction List</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-left pull-right"></i>
				</span>
			</a>
			<ul class="treeview-menu">
				<li><a href="<?= base_url();?>interaction/doctor_interaction"><i class="fa fa-circle-o"></i>Doctor</a></li>
				<li><a href="<?= base_url();?>interaction/pharmacy_interaction"><i class="fa fa-circle-o"></i>Pharmacy</a></li>
				<li><a href="<?= base_url();?>interaction/dealer_interaction"><i class="fa fa-circle-o"></i>Dealer</a></li>
				<!-- <li><a href="<?= base_url();?>dealer/dealer/add_main_dealer"><i class="fa fa-circle-o"></i>Add Main Dealer</a></li>
				<li><a href="<?= base_url();?>dealer/dealer/main_dealer_view"><i class="fa fa-circle-o"></i>Main Dealer View</a></li>-->
			</ul>
        </li>
    <?php
      if(logged_user_data()!=28 && logged_user_data()!=29 &&  logged_user_data()!=32){
    ?>
		  <li>
        <a href="<?= base_url();?>admin_control/report/index/<?= urisafeencode(logged_user_data());?>">
        <i class="fa fa-line-chart"></i>
        <span>Get Report</span>
        <span class="pull-right-container">
        <!--<small class="fa fa-angle-left pull-right"></small>-->
        </span>
        </a>
      </li> 	
		
		<?php } ?>
        <?php
        if(logged_user_data()==28 || logged_user_data()==29 ||  logged_user_data()==32 ){
        ?>
        
        <li class="header">Admin Panel Control</li>
        <li><a href="<?= base_url();?>admin_control/user_permission"><i class="fa fa-circle-o text-red"></i><span>Users Permission</span></a></li>
        <li><a href="<?= base_url();?>admin_control/sample_master"><i class="fa fa-circle-o text-yellow"></i><span>Sample Master</span></a></li>
        <li><a href="<?= base_url();?>admin_control/report"><i class="fa fa-circle-o text-green"></i><span>Users Report</span></a></li>
		<li><a href="<?= base_url();?>city/city"><i class="fa fa-circle-o text-pink"></i><span>Import City</span></a></li>     
		<li><a href="<?= base_url();?>doctors/doctor/import_doctor"><i class="fa fa-circle-o text-blue"></i><span>Import Doctor</span></a></li>
		<li><a href="<?= base_url();?>pharmacy/pharmacy/import_pharmacy"><i class="fa fa-circle-o text-gray"></i><span>Import Pharmacy</span></a></li>
		<li><a href="<?= base_url();?>dealer/dealer/import_dealer"><i class="fa fa-circle-o text-red"></i><span>Import Dealer</span></a></li>
		<li><a href="<?= base_url();?>tour_plan/tour_plan/tour_data_list"><i class="fa fa-circle-o text-yellow"></i><span>Standard Tour Plan</span></a></li>
	 <li><a href="<?= base_url();?>admin_control/report/get_tada_report"><i class="fa fa-circle-o text-green"></i><span>TA DA Report</span></a></li>
		<li><a href="<?= base_url();?>reports/reports/attendance_report"><i class="fa fa-circle-o text-blue"></i><span>Attendance Report</span></a></li>
    <li><a href="<?= base_url();?>reports/reports/tp_reports"><i class="fa fa-circle-o text-blue"></i><span>TP</span></a></li>
    <li><a href="<?= base_url();?>reports/reports/attendance_report_all"><i class="fa fa-circle-o text-blue"></i><span>Attendance Sheet</span></a></li>
    <li><a href="<?= base_url();?>holiday/holiday/"><i class="fa fa-circle-o text-blue"></i><span>Add Holiday</span></a></li>
		<li><a href="<?= base_url();?>city/city/add_navigation"><i class="fa fa-circle-o text-yellow"></i><span>Set Navigation ID</span></a></li>
		<li><a href="<?= base_url();?>category/category/"><i class="fa fa-circle-o text-red"></i><span>Category</span></a></li>
		<li><a href="<?= base_url();?>product/product/"><i class="fa fa-circle-o text-red"></i><span>Product</span></a></li>
        <?php } ?>
 <!--<li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span></span></a></li>-->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>