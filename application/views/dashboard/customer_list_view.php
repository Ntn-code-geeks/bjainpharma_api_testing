<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
<!--   <section class="content-header">
  <h1>
  Dashboard
  </h1>
  <ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Dashboard</li>
  </ol>
  </section> -->
  <!-- Main content -->
  <section class="content">
  <!-- Info boxes -->
  <div class="row">
    <!-- <div class="col-md-12 col-lg-12 col-lg-12 col-xs-12">
      <div class="box-tools" style="margin-top: 10px;margin-bottom: 10px;">
        <form method="GET" action="<?= base_url()?>global_search/search">
          <div class="input-group input-group-sm">
            <input name="table_search" id="searchid" class="form-control pull-right search" placeholder="Search" type="text" style='height: 34px'>
            <div id="result"></div>
            <div class="input-group-btn">
              <button type="submit" class="btn btn-default" style='height: 34px'><i class="fa fa-search"></i></button>
            </div>
          </div>
        </form>
      </div>
    </div> -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <a href="<?= base_url();?>dealer/dealer/dealer_view">
        <div class="info-box">
          <span class="info-box-icon bg-green"><i class="fa fa-users" aria-hidden="true"></i></span>
          <div class="info-box-content">
            <span class="info-box-text" style="padding: 20px">Dealer</span>
            <!--<span class="info-box-number">760</span>-->
          </div>
        <!-- /.info-box-content -->
        </div>
      </a>
      <!-- /.info-box -->
    </div>  
    <div class="col-md-3 col-sm-6 col-xs-12">
      <a href="<?= base_url();?>pharmacy/pharmacy">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-medkit"></i></span>
        <div class="info-box-content">
          <span class="info-box-text" style="padding: 20px">Sub Dealer</span>
        <!--<span class="info-box-number">90<small>%</small></span>-->
        </div>
        <!-- /.info-box-content -->
      </div>
      </a>
      <!-- /.info-box -->
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <a href="<?= base_url();?>doctors/doctor">
        <div class="info-box">
          <span class="info-box-icon bg-red"><i class="fa fa-envelope" aria-hidden="true"></i></span>
          <div class="info-box-content">
            <span class="info-box-text" style="padding: 20px;">Doctor</span>
          <!--<span class="info-box-number">41,410</span>-->
          </div>
        <!-- /.info-box-content -->
        </div>
      </a>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <!-- /.col -->
    <!-- fix for small devices only -->
    <!--  <div class="clearfix visible-sm-block"></div>-->
    <!-- /.col -->
  </div>
  <!-- /.row -->
</div>
 