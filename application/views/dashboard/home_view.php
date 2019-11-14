<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

   /*For this week*/ 
   $sales_report = json_decode($sales);  //for see top sales customer
   
   $payment_report = json_decode($payment); //for see top payment customer
   
   $secondary_report = json_decode($secondary);  //for see top secondary sale customer
   
   $interaction_report = json_decode($interaction);  //for see top interaction customer (doctor/pharmacy/dealer)
   
   $most_meet_report = json_decode($most_meet); // for see most meet customer(doctor/pharmacy/dealer)
   
   $never_meet_report = json_decode($never_meet); // for see never meet customer(doctor/pharmacy/dealer)
    /*end for this week*/
   
    /*For this Month*/ 
   
   $sales_month_report = json_decode($sales_month);  //for see top sales customer
   
   $payment_month_report = json_decode($payment_month); //for see top payment customer
   
   $secondary_month_report = json_decode($secondary_month);  //for see top secondary sale customer
   
   $interaction_month_report = json_decode($interaction_month);  //for see top interaction customer (doctor/pharmacy/dealer)
   
   $most_meet_month_report = json_decode($most_meet_month); // for see most meet customer(doctor/pharmacy/dealer)
   
   $never_meet_month_report = json_decode($never_meet_month); // for see never meet customer(doctor/pharmacy/dealer)
    /*end for this Month*/
   
    /*For this Quarter*/ 
   $sales_quarter_report = json_decode($sales_quarter);  //for see top sales customer
   
   $payment_quarter_report = json_decode($payment_quarter); //for see top payment customer
   
   $secondary_quarter_report = json_decode($secondary_quarter);  //for see top secondary sale customer
   
   $interaction_quarter_report = json_decode($interaction_quarter);  //for see top interaction customer (doctor/pharmacy/dealer)
   
   $most_meet_quarter_report = json_decode($most_meet_quarter); // for see most meet customer(doctor/pharmacy/dealer)
   
   $never_meet_quarter_report = json_decode($never_meet_quarter); // for see never meet customer(doctor/pharmacy/dealer)
    /*end for this Quarter*/
   
   
    /*For this Year*/ 
   $sales_year_report = json_decode($sales_year);  //for see top sales customer
   
   $payment_year_report = json_decode($payment_year); //for see top payment customer
   
   $secondary_year_report = json_decode($secondary_year);  //for see top secondary sale customer
   
   $interaction_year_report = json_decode($interaction_year);  //for see top interaction customer (doctor/pharmacy/dealer)
   
   $most_meet_year_report = json_decode($most_meet_year); // for see most meet customer(doctor/pharmacy/dealer)
   
   $never_meet_year_report = json_decode($never_meet_year); // for see never meet customer(doctor/pharmacy/dealer)
    /*end for this Year*/
   
   
//pr($sales_report); die;
?>
<!-- jQuery 3 -->
<script src="<?php echo base_url();?>design/bower_components/jquery/dist/jquery.min.js"></script>
<!--<script src="<?php echo base_url();?>design/js/auto_suggestion/jquery-1.8.0.min.js"></script>-->
  <script type="text/javascript">
$(function(){
$(".search").keyup(function() 
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
    $("#result").html(html).show();
    }
    });
}return false;    
});

jQuery("#result").click(function(e){ 
 
	var $clicked = $(e.target);
	var $name = $clicked.find('.name').html();
       
	var decoded = $("<div/>").html($name).text();
//        alert(decoded);
	$('#searchid').val(decoded);
});
jQuery(document).click(function(e) { 
//      alert("hello");
	var $clicked = $(e.target);
	if (! $clicked.hasClass("search")){
	jQuery("#result").fadeOut(); 
	}
});
$('#searchid').click(function(){
     
	jQuery("#result").fadeIn();
});
});
</script>
<style type="text/css">
	#searchid
	{
		/*width:500px;*/
		/*border:solid 1px #000;*/
		padding:10px;
		font-size:14px;
	}
	#result
	{
		position:absolute;
		width:100%;
		padding:10px;
		display:none;
		margin-top:-1px;
		border-top:0px;
		overflow:hidden;
		border:1px #CCC solid;
		background-color: white;
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
		height:50px;
	}
	.show:hover
	{
		background:#4c66a4;
		color:#FFF;
		cursor:pointer;
	}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <!--<small>Booklings</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <?php echo get_flash(); ?>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">


          
      <div class="col-md-12 col-lg-12 col-lg-12 col-xs-12">
        <div class="box-tools" style="margin-top: 10px;margin-bottom: 10px;">
           
            <form method="GET" action="<?= base_url()?>global_search/search">
                   <div class="input-group input-group-sm">
                  
                             
                    <input name="table_search" id="searchid" class="form-control pull-right search" placeholder="Search" type="text" style='height: 34px'>
                   <!--<input type="text" class="search" id="searchid" placeholder="Search for people" />--> 
                       <div id="result"></div>
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default" style='height: 34px'><i class="fa fa-search"></i></button>
                  </div>
                </div>
                   
             </form>
          </div>
      </div>
           <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="<?= base_url();?>interaction/index/"><div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-handshake-o" aria-hidden="true"></i></span>

            <div class="info-box-content">
              <span class="info-box-text" style="padding: 20px">Interaction</span>
              <!--<span class="info-box-number">760</span>-->
            </div>
            <!-- /.info-box-content -->
          </div></a>
          <!-- /.info-box -->
        </div>  
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="<?= base_url();?>interaction/customer_list/">
            <div class="info-box">
              <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
              <div class="info-box-content">
                <span class="info-box-text" style="padding: 20px">Customer</span>
                <!--<span class="info-box-number">90<small>%</small></span>-->
              </div>
              <!-- /.info-box-content -->
            </div>
          </a>
          <!-- /.info-box -->
        </div>
          
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="<?= base_url();?>meeting/meeting/interact_with_ho"><div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-envelope" aria-hidden="true"></i></span>

            <div class="info-box-content">
              <span class="info-box-text" style="padding: 20px;white-space: normal!important">Interaction with HO</span>
              <!--<span class="info-box-number">41,410</span>-->
            </div>
            <!-- /.info-box-content -->
              </div></a>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
          
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="<?= base_url();?>tour_plan/tour_plan"><div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-bus" aria-hidden="true"></i></span>
            <div class="info-box-content">
              <span class="info-box-text" style="padding: 20px">Tour Plan</span>
              <!--<span class="info-box-number">41,410</span>-->
            </div>
            <!-- /.info-box-content -->
              </div></a>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->


        <!-- fix for small devices only -->
       <!--  <div class="clearfix visible-sm-block"></div>-->

     
        <!-- /.col -->
        
      </div>
      <!-- /.row -->


    <h2 class="page-header">Customer Analysis</h2>
      
      <div class="nav-tabs-custom">

      <ul class="nav nav-tabs">
              <li class="active"><a href="#week" data-toggle="tab" aria-expanded="true">Week</a></li>
              <li class=""><a href="#month" data-toggle="tab" aria-expanded="false">Month</a></li>
              <li class=""><a href="#quarter" data-toggle="tab" aria-expanded="false">This Quarter</a></li>
              <li class=""><a href="#year" data-toggle="tab" aria-expanded="false">This Year</a></li>
              
             
            </ul>
      <div class="tab-content">
      <div class="row tab-pane active" id="week">
           <?php if(!empty($sales_report)){ ?>
        <!--Top sales Customer-->
          <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-yellow">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Top Sales Customer</h4>
                  <img src="<?= base_url()?>design/img/analysis/total_sale.png" alt=""/>
                
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?=$sales_report[0]->customername;?></h3>
              <h5 class="widget-user-desc">1st Sales</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
               <?php $count=''; foreach ($sales_report as $k=>$val){
                   if($k<5){?>
                  <li><a href="#"><?=$val->customername?><span class="pull-right badge bg-green">Rs.<?=number_format($val->sale,2)?></span></a></li>
                   <?php } $count=$k; } ?>
                <!--<li><a href="#">Vimal <span class="pull-right badge bg-red">842</span></a></li>-->
              </ul>
                <?php if($count>4){ ?>
                <!--<div class="small-box bg-yellow" style="margin: 0px"><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a></div>-->
                <?php } ?>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
           <?php } ?>
        <!-- / Top sales Customer -->
        
        <?php if(!empty($payment_report)){ ?>
        <!--Top Payment Customer-->
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Top Payment Customer</h4>
                  
                  <img src="<?= base_url()?>design/img/analysis/payment.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?=$payment_report[0]->customername?></h3>
              <h5 class="widget-user-desc">1st Payment</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <?php $count = '';
                foreach ($payment_report as $k=>$val){
                  if($k<5){  
                ?>
                <li><a href="#"><?=$val->customername?><span class="pull-right badge bg-green">Rs.<?=number_format($val->payment,2)?></span></a></li>
                <?php }  $count=$k;  } ?>
               
              </ul>
                <?php if($count>4){ ?>
                <!--<div class="small-box bg-aqua" style="margin: 0px"><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a></div>-->
                <?php }?>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
        <!-- /.top payment customer -->
        
        <?php if(!empty($secondary_report)){ ?>
        <!--Top Secondary Customer-->
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-green active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Top Secondary Sale Customer</h4>
                  <img src="<?= base_url()?>design/img/analysis/secondary_sales.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?=$secondary_report[0]->customername?></h3>
              <h5 class="widget-user-desc">1st Sales</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <?php $count=''; foreach($secondary_report as $k=>$val){ if($k<5){ ?>
                <li><a href="#"><?=$val->customername?><span class="pull-right badge bg-green">Rs.<?=number_format($val->sale,2)?></span></a></li>
                <?php } $count = $k; } ?>
              </ul>
                 <?php if($count>4){ ?>
                <!--<div class="small-box bg-green" style="margin: 0px"><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a></div>-->
                 <?php } ?>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
        <!-- /.Top Secondary Customer -->
       
        <?php if(!empty($interaction_report)){ ?>
        <!--Top Interaction Customer-->
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-teal active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Top Interaction Customer</h4>
                  <img src="<?= base_url()?>design/img/analysis/interaction.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?=$interaction_report[0]->customername?></h3>
              <h5 class="widget-user-desc">1st Interaction</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
               
                  <?php $count=''; foreach($interaction_report as $k=>$val){ if($k<5){ ?>
                <li><a href="#"><?=$val->customername?><span class="pull-right badge bg-green"><?=$val->interaction?></span></a></li>
                  <?php } $count=$k; } ?>
                
              </ul>
                <?php if($count>4){ ?>
                <!--<div class="small-box bg-teal" style="margin: 0px"><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a></div>-->
                <?php } ?>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
           <!-- /. Top Interaction Customer-->
         
           <?php if(!empty($most_meet_report)){?>
        <!--Top Met customer-->
         <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-purple active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Most Met Customer</h4>
                  <img src="<?= base_url()?>design/img/analysis/met_customer.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?=$most_meet_report[0]->customername?></h3>
              <h5 class="widget-user-desc">1st Met</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
               <?php $count=''; foreach ($most_meet_report as $k=>$val){ if($k<5){?>
                <li><a href="#"><?=$val->customername?><span class="pull-right badge bg-green"><?=$val->meet?></span></a></li>
           <?php } $count=$k; } ?>
              </ul>
               <?php if($count>4){ ?>
                <!--<div class="small-box bg-purple" style="margin: 0px"><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a></div>-->
               <?php } ?>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
           <?php } ?>
         <!-- /. Top Met customer-->
        
        <?php if(!empty($never_meet_report)){ ?>
         <!--Never Met Customer-->
         <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-maroon active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Never Met Customer</h4>
                  <img src="<?= base_url()?>design/img/analysis/not_met_customer.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?=$never_meet_report[0]->customername?></h3>
              <h5 class="widget-user-desc">1st Sales</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
               <?php foreach ($never_meet_report as $key=>$val){ ?>
                <li><a href="#"><?=$val->customername?><span class="pull-right badge bg-green"><?=$val->nevermeet?></span></a></li>
                <?php }?>
              </ul>
                <!--<div class="small-box bg-maroon" style="margin: 0px"><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a></div>-->
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
        <!-- /. Never Met Customer-->
        
      </div>
      <!--For the Month-->
       <div class="row tab-pane" id="month">
           <?php if(!empty($sales_month_report)){ ?>
        <!--Top sales Customer-->
          <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-yellow">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Top Sales Customer</h4>
                  <img src="<?= base_url()?>design/img/analysis/total_sale.png" alt=""/>
                
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?=$sales_month_report[0]->customername;?></h3>
              <h5 class="widget-user-desc">1st Sales</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
               <?php $count=''; foreach ($sales_month_report as $k=>$val){ if($k<5){?>
                <li><a href="#"><?=$val->customername?><span class="pull-right badge bg-green">Rs.<?=number_format($val->sale,2)?></span></a></li>
           <?php } $count=$k; } ?>
                <!--<li><a href="#">Vimal <span class="pull-right badge bg-red">842</span></a></li>-->
              </ul>
                 <?php if($count>4){ ?>
                <!--<div class="small-box bg-yellow" style="margin: 0px"><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a></div>-->
                 <?php } ?>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
           <?php } ?>
        <!-- / Top sales Customer -->
        
        <?php if(!empty($payment_month_report)){ ?>
        <!--Top Payment Customer-->
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Top Payment Customer</h4>
                  
                  <img src="<?= base_url()?>design/img/analysis/payment.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?=$payment_month_report[0]->customername?></h3>
              <h5 class="widget-user-desc">1st Payment</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <?php $count='';
                foreach ($payment_month_report as $k=>$val){
                    if($k<5){
                ?>
                <li><a href="#"><?=$val->customername?><span class="pull-right badge bg-green">Rs.<?=number_format($val->payment,2)?></span></a></li>
        <?php } } ?>
               
              </ul>
                 <?php if($count>4){ ?>
                <!--<div class="small-box bg-aqua" style="margin: 0px"><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a></div>-->
                 <?php } ?>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
        <!-- /.top payment customer -->
        
        <?php if(!empty($secondary_month_report)){ ?>
        <!--Top Secondary Customer-->
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-green active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Top Secondary Sale Customer</h4>
                  <img src="<?= base_url()?>design/img/analysis/secondary_sales.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?=$secondary_month_report[0]->customername?></h3>
              <h5 class="widget-user-desc">1st Sales</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <?php $count=''; foreach($secondary_month_report as $k=>$val){ if($k<5){ ?>
                <li><a href="#"><?=$val->customername?><span class="pull-right badge bg-green">Rs.<?=number_format($val->sale,2)?></span></a></li>
                <?php } $count=$k; } ?>
              </ul>
                <?php if($count>4){ ?>
                <!--<div class="small-box bg-green" style="margin: 0px"><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a></div>-->
                <?php }?>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
        <!-- /.Top Secondary Customer -->
       
        <?php if(!empty($interaction_month_report)){ ?>
        <!--Top Interaction Customer-->
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-teal active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Top Interaction Customer</h4>
                  <img src="<?= base_url()?>design/img/analysis/interaction.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?=$interaction_month_report[0]->customername?></h3>
              <h5 class="widget-user-desc">1st Interaction</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
               
                  <?php $count=''; foreach($interaction_month_report as $k=>$val){ if($k<5){ ?>
                <li><a href="#"><?=$val->customername?><span class="pull-right badge bg-green"><?=$val->interaction?></span></a></li>
                  <?php } $count=$k; } ?>
                
              </ul>
                <?php if($count>4){ ?>
                <!--<div class="small-box bg-teal" style="margin: 0px"><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a></div>-->
                <?php } ?>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
           <!-- /. Top Interaction Customer-->
         
           <?php if(!empty($most_meet_month_report)){?>
        <!--Top Met customer-->
         <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-purple active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Most Met Customer</h4>
                  <img src="<?= base_url()?>design/img/analysis/met_customer.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?=$most_meet_month_report[0]->customername?></h3>
              <h5 class="widget-user-desc">1st Met</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
               <?php $count=''; foreach ($most_meet_month_report as $k=>$val){
                   if($k<5){?>
                <li><a href="#"><?=$val->customername?><span class="pull-right badge bg-green"><?=$val->meet?></span></a></li>
           <?php } $count=$k; }?>
              </ul>
                <?php if($count>4){ ?>
                <!--<div class="small-box bg-purple" style="margin: 0px"><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a></div>-->
                <?php } ?>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
           <?php } ?>
         <!-- /. Top Met customer-->
        
        <?php if(!empty($never_meet_month_report)){ ?>
         <!--Never Met Customer-->
         <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-maroon active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Never Met Customer</h4>
                  <img src="<?= base_url()?>design/img/analysis/not_met_customer.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?=$never_meet_month_report[0]->customername?></h3>
              <h5 class="widget-user-desc">1st Sales</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
               <?php $count=''; foreach ($never_meet_month_report as $key=>$val){
                   if($key<5){ ?>
                <li><a href="#"><?=$val->customername?><span class="pull-right badge bg-green"><?=$val->nevermeet?></span></a></li>
        <?php } $count=$key; } ?>
              </ul>
                <?php if($count>4){ ?>
                <!--<div class="small-box bg-maroon" style="margin: 0px"><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a></div>-->
                <?php } ?>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
        <!-- /. Never Met Customer-->
        
      </div>
      <!--./ For the Month-->
      
      <!--This quarter report-->
     <div class="row tab-pane" id="quarter">
           <?php if(!empty($sales_quarter_report)){ ?>
        <!--Top sales Customer-->
          <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-yellow">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Top Sales Customer</h4>
                  <img src="<?= base_url()?>design/img/analysis/total_sale.png" alt=""/>
                
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?=$sales_quarter_report[0]->customername;?></h3>
              <h5 class="widget-user-desc">1st Sales</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
               <?php $count=''; foreach ($sales_quarter_report as $k=>$val){
                 if($k<5){  ?>
                <li><a href="#"><?=$val->customername?><span class="pull-right badge bg-green">Rs.<?=number_format($val->sale,2)?></span></a></li>
               <?php } $count=$k; } ?>
                <!--<li><a href="#">Vimal <span class="pull-right badge bg-red">842</span></a></li>-->
              </ul>
                <?php if($count>4){ ?>
                <!--<div class="small-box bg-yellow" style="margin: 0px"><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a></div>-->
                <?php } ?>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
           <?php } ?>
        <!-- / Top sales Customer -->
        
        <?php if(!empty($payment_quarter_report)){ ?>
        <!--Top Payment Customer-->
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Top Payment Customer</h4>
                  
                  <img src="<?= base_url()?>design/img/analysis/payment.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?=$payment_quarter_report[0]->customername?></h3>
              <h5 class="widget-user-desc">1st Payment</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <?php $count='';
                foreach ($payment_quarter_report as $k=>$val){
               if($k<5){
                    ?>
                <li><a href="#"><?=$val->customername?><span class="pull-right badge bg-green">Rs.<?=number_format($val->payment,2)?></span></a></li>
               <?php } $count=$k; } ?>
               
              </ul>
                 <?php if($count>4){ ?>
                <!--<div class="small-box bg-aqua" style="margin: 0px"><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a></div>-->
                 <?php } ?>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
        <!-- /.top payment customer -->
        
        <?php if(!empty($secondary_quarter_report)){ ?>
        <!--Top Secondary Customer-->
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-green active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Top Secondary Sale Customer</h4>
                  <img src="<?= base_url()?>design/img/analysis/secondary_sales.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?=$secondary_quarter_report[0]->customername?></h3>
              <h5 class="widget-user-desc">1st Sales</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <?php $count=''; foreach($secondary_quarter_report as $k=>$val){ if($k<5){ ?>
                <li><a href="#"><?=$val->customername?><span class="pull-right badge bg-green">Rs.<?=number_format($val->sale,2)?></span></a></li>
                <?php } $count=$k; } ?>
              </ul>
                 <?php if($count>4){ ?>
                <!--<div class="small-box bg-green" style="margin: 0px"><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a></div>-->
                 <?php } ?>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
        <!-- /.Top Secondary Customer -->
       
        <?php if(!empty($interaction_quarter_report)){ ?>
        <!--Top Interaction Customer-->
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-teal active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Top Interaction Customer</h4>
                  <img src="<?= base_url()?>design/img/analysis/interaction.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?=$interaction_quarter_report[0]->customername?></h3>
              <h5 class="widget-user-desc">1st Interaction</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
               
                  <?php $count=''; foreach($interaction_quarter_report as $k=>$val){ if($k<5){ ?>
                <li><a href="#"><?=$val->customername?><span class="pull-right badge bg-green"><?=$val->interaction?></span></a></li>
                  <?php } $count=$k; } ?>
                
              </ul>
                 <?php if($count>4){ ?>
                <!--<div class="small-box bg-teal" style="margin: 0px"><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a></div>-->
                 <?php } ?>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
           <!-- /. Top Interaction Customer-->
         
           <?php if(!empty($most_meet_quarter_report)){?>
        <!--Top Met customer-->
         <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-purple active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Most Met Customer</h4>
                  <img src="<?= base_url()?>design/img/analysis/met_customer.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?=$most_meet_quarter_report[0]->customername?></h3>
              <h5 class="widget-user-desc">1st Met</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
               <?php $count=''; foreach ($most_meet_quarter_report as $k=>$val){ 
                   if($k<5){
                   ?>
                <li><a href="#"><?=$val->customername?><span class="pull-right badge bg-green"><?=$val->meet?></span></a></li>
           <?php } $count=$k; }?>
              </ul>
                <?php if($count>4){ ?>
                <!--<div class="small-box bg-purple" style="margin: 0px"><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a></div>-->
                <?php } ?>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
           <?php } ?>
         <!-- /. Top Met customer-->
        
        <?php if(!empty($never_meet_quarter_report)){ ?>
         <!--Never Met Customer-->
         <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-maroon active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Never Met Customer</h4>
                  <img src="<?= base_url()?>design/img/analysis/not_met_customer.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?=$never_meet_quarter_report[0]->customername?></h3>
              <h5 class="widget-user-desc">1st Sales</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
               <?php $count=''; foreach ($never_meet_quarter_report as $key=>$val){
                   if($key<5){
                   ?>
                <li><a href="#"><?=$val->customername?><span class="pull-right badge bg-green"><?=$val->nevermeet?></span></a></li>
               <?php } $count=$key; }?>
              </ul>
                <?php if($count>4){ ?>
                <!--<div class="small-box bg-maroon" style="margin: 0px"><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a></div>-->
                <?php } ?>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
        <!-- /. Never Met Customer-->
        
      </div>
      <!--/. End of this quarter report-->
      
     <div class="row tab-pane" id="year">
           <?php if(!empty($sales_year_report)){ ?>
        <!--Top sales Customer-->
          <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-yellow">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Top Sales Customer</h4>
                  <img src="<?= base_url()?>design/img/analysis/total_sale.png" alt=""/>
                
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?=$sales_year_report[0]->customername;?></h3>
              <h5 class="widget-user-desc">1st Sales</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
               <?php $count=''; foreach ($sales_year_report as $k=>$val){
                   if($k<5){
                   ?>
                <li><a href="#"><?=$val->customername?><span class="pull-right badge bg-green">Rs.<?=number_format($val->sale,2)?></span></a></li>
           <?php } $count=$k; }  ?>
                <!--<li><a href="#">Vimal <span class="pull-right badge bg-red">842</span></a></li>-->
              </ul>
                <?php if($count>4){ ?>
                <!--<div class="small-box bg-yellow" style="margin: 0px"><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a></div>-->
                <?php } ?>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
           <?php } ?>
        <!-- / Top sales Customer -->
        
        <?php if(!empty($payment_year_report)){ ?>
        <!--Top Payment Customer-->
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Top Payment Customer</h4>
                  
                  <img src="<?= base_url()?>design/img/analysis/payment.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?=$payment_year_report[0]->customername?></h3>
              <h5 class="widget-user-desc">1st Payment</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <?php $count='';
                foreach ($payment_year_report as $k=>$val){
                if($k<5){
                    ?>
                <li><a href="#"><?=$val->customername?><span class="pull-right badge bg-green">Rs.<?=number_format($val->payment,2)?></span></a></li>
               <?php } $count=$k; } ?>
               
              </ul>
                 <?php if($count>4){ ?>
                <!--<div class="small-box bg-aqua" style="margin: 0px"><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a></div>-->
                 <?php } ?>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
        <!-- /.top payment customer -->
        
        <?php if(!empty($secondary_year_report)){ ?>
        <!--Top Secondary Customer-->
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-green active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Top Secondary Sale Customer</h4>
                  <img src="<?= base_url()?>design/img/analysis/secondary_sales.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?=$secondary_year_report[0]->customername?></h3>
              <h5 class="widget-user-desc">1st Sales</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <?php $count=''; foreach($secondary_year_report as $k=>$val){ if($k<5){ ?>
                  <li><a href="#"><?=$val->customername?><span class="pull-right badge bg-green">Rs.<?=number_format($val->sale,2)?></span></a></li>
                <?php } $count=$k; } ?>
              </ul>
                 <?php if($count>4){ ?>
                <!--<div class="small-box bg-green" style="margin: 0px"><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a></div>-->
                 <?php } ?>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
        <!-- /.Top Secondary Customer -->
       
        <?php if(!empty($interaction_year_report)){ ?>
        <!--Top Interaction Customer-->
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-teal active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Top Interaction Customer</h4>
                  <img src="<?= base_url()?>design/img/analysis/interaction.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?=$interaction_year_report[0]->customername?></h3>
              <h5 class="widget-user-desc">1st Interaction</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
               
                  <?php $count=''; foreach($interaction_year_report as $k=>$val){ if($k<5){ ?>
                  <li><a href="#"><?=$val->customername?><span class="pull-right badge bg-green"><?=$val->interaction?></span></a></li>
                  <?php } $count=$k; } ?>
                
              </ul>
                <?php if($count>4){ ?>
                <!--<div class="small-box bg-teal" style="margin: 0px"><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a></div>-->
                <?php } ?> 
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
           <!-- /. Top Interaction Customer-->
         
           <?php if(!empty($most_meet_year_report)){?>
        <!--Top Met customer-->
         <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-purple active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Most Met Customer</h4>
                  <img src="<?= base_url()?>design/img/analysis/met_customer.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?=$most_meet_year_report[0]->customername?></h3>
              <h5 class="widget-user-desc">1st Met</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
               <?php $count=''; foreach ($most_meet_year_report as $k=>$val){
                   if($k<5){?>
                <li><a href="#"><?=$val->customername?><span class="pull-right badge bg-green"><?=$val->meet?></span></a></li>
               <?php } $count=$k;  } ?>
              </ul>
                 <?php if($count>4){ ?>
                <!--<div class="small-box bg-purple" style="margin: 0px"><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a></div>-->
                 <?php } ?>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
           <?php } ?>
         <!-- /. Top Met customer-->
        
        <?php if(!empty($never_meet_year_report)){ ?>
         <!--Never Met Customer-->
         <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-maroon active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Never Met Customer</h4>
                  <img src="<?= base_url()?>design/img/analysis/not_met_customer.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?=$never_meet_year_report[0]->customername?></h3>
              <h5 class="widget-user-desc">1st Sales</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
               <?php $count=''; foreach ($never_meet_year_report as $key=>$val){
                   if($key<5){
                   ?>
                <li><a href="#"><?=$val->customername?><span class="pull-right badge bg-green"><?=$val->nevermeet?></span></a></li>
        <?php } $count=$key; }  ?>
              </ul>
                <?php if($count>4){ ?>
                <!--<div class="small-box bg-maroon" style="margin: 0px"><a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a></div>-->
                <?php } ?>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
        <!-- /. Never Met Customer-->
        
      </div>
      </div>
      

  <div class="control-sidebar-bg"></div>

</div>
  