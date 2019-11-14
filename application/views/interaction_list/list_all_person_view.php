<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

   $doc_info = json_decode($doctor_data);
   $d_info = json_decode($dealer_data);
   $pharma_info = json_decode($pharma_data);
   
   
//pr($sales_report); die;
?>
<!-- jQuery 3 -->
<script src="<?php echo base_url();?>design/bower_components/jquery/dist/jquery.min.js"></script>
<!--<script src="<?php echo base_url();?>design/js/auto_suggestion/jquery-1.8.0.min.js"></script>-->
<link href="<?= base_url()?>design/css/div_table/one.css" rel="stylesheet" type="text/css"/>
<link href="<?= base_url()?>design/css/div_table/custom_table.css" rel="stylesheet" type="text/css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="<?= base_url()?>design/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<style type="text/css">
@media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px)  {
		/* Label the data */
		#example2 td:nth-of-type(1):before { content: "Name"; }
		#example2 td:nth-of-type(2):before { content: "Email"; }
		#example2 td:nth-of-type(3):before { content: "Phone Number"; }
		#example2 td:nth-of-type(4):before { content: "City"; }
		#example2 td:nth-of-type(5):before { content: "Action"; }
}
@media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px)  {
		/* Label the data */
		#example3 td:nth-of-type(1):before { content: "Name"; }
		#example3 td:nth-of-type(2):before { content: "Email"; }
		#example3 td:nth-of-type(3):before { content: "Phone Number"; }
		#example3 td:nth-of-type(4):before { content: "City"; }
		#example3 td:nth-of-type(5):before { content: "Action"; }
}

@media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px)  {
		/* Label the data */
		#example4 td:nth-of-type(1):before { content: "Dealer Name"; }
		#example4 td:nth-of-type(2):before { content: "Dealer Email"; }
		#example4 td:nth-of-type(3):before { content: "Phone Number"; }
		#example4 td:nth-of-type(4):before { content: "City"; }
		#example4 td:nth-of-type(5):before { content: "Action"; }
}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        List of Doctor, Sub Dealer & Dealer
        <!--<small>Booklings</small>-->
      </h1>
     <?php echo get_flash(); ?>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->

      <!-- /.row -->
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<li style="width: 32%;" class="active"><a href="#doctor" data-toggle="tab" aria-expanded="true">Doctor</a></li>
				<li style="width: 33%;" class=""><a href="#pharmacy" data-toggle="tab" aria-expanded="false">Sub Dealer</a></li>
				<li style="width: 33%;" class=""><a href="#dealer" data-toggle="tab" aria-expanded="false">Dealer</a></li>
			<!-- <li class=""><a href="#year" data-toggle="tab" aria-expanded="false">This Year</a></li>-->
			</ul>
			<div class="tab-content">
				<div class="row tab-pane active" id="doctor">
					<div class="box-body">
						<table id="example2" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th> Name</th>
								<th> Email</th>
								<th>Phone Number </th>
								<th>City </th>
								<th>Action</th>
							</tr>
						</thead>

						<tbody>
							<?php  if(!empty($doc_info)){  foreach($doc_info as $k_c=>$val_c){  if(check_user_sp($val_c->sp_code)){    ?>
							<tr>
								<td> <?=$val_c->d_name;?></td>
								<td> <?=$val_c->d_email;?></td>
								<td> <?=$val_c->d_ph;?></td>
								<td> <?=get_city_name($val_c->city_id);?></td>
								<td> 
									<a href="<?php echo base_url()."doctors/doctor/edit_doctor/". urisafeencode($val_c->id);?>"><button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
									| <a href="<?php echo base_url()."doctors/doctor/view_doctor_for_interaction/". urisafeencode($val_c->id);?>"><button type="button" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
									 <a href="<?php echo base_url()."doctors/doctor/doctor_interaction_sales/". urisafeencode($val_c->id).'/'.urisafeencode($date_interact).'/'.urisafeencode(1).'/'.urisafeencode($interaction_city);?>"><button type="button" class="btn btn-info">Interaction</button></a>
									
										
									<!--  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_info_doctor<?=$val_c->id ?>">
									</button>-->
									<!-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_info_appointment<?=$val_c->id ?>">
									Appointment
									</button> -->

								 <?php

								if(is_admin() ){?>                 

									<?php if($val_c->status==1){ ?>   | <a href="<?php echo base_url()."doctors/doctor/inactive_doctor/".urisafeencode($val_c->id);?>" onclick="return confirm('Are you sure want to In-Active this Doctor.')" class=""><button type="button" class="btn btn-success">Active</button></a><?php } ?>

								   <?php if($val_c->status==0){ ?>   | <a href="<?php echo base_url()."doctors/doctor/active_doctor/".urisafeencode($val_c->id);?>" onclick="return confirm('Are you sure want to Active this Doctor.')" class=""><button type="button" class="btn btn-warning">In-Active</button></a><?php } ?>

									 <?php if($val_c->blocked==1){ ?>   | <a href="<?php echo base_url()."doctors/doctor/remain_doctor/".urisafeencode($val_c->id);?>" onclick="return confirm('Are you sure want to Remain this Doctor.')" class=""><button type="button" class="btn btn-danger">Blocked</button></a><?php } ?>

								   <?php if($val_c->blocked==0){ ?>   | <a href="<?php echo base_url()."doctors/doctor/blocked_doctor/".urisafeencode($val_c->id);?>" onclick="return confirm('Are you sure want to Suspend this Doctor.')" class=""><button type="button" class="btn btn-success">UnBlocked</button></a><?php } ?>
								<?php } ?>
								</td>

							 </tr>

				   
							<?php } }} ?>
						</tbody>
					 </table>
					</div>
				</div>
				<!--For the Sub Dealer-->
				<div class="row tab-pane" id="pharmacy">
					           <div class="box-body">
				<table id="example3" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th> Name</th>
							<th> Email</th>
							<th>Phone Number </th>
							<th>City </th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($pharma_info)){ foreach($pharma_info as $k_c=>$val_c){  if(check_user_sp($val_c->sp_code)){?>
							  <tr>
									<td> <?=$val_c->com_name;?></td>
									<td><?=$val_c->com_email;?></td>
									<td><?=$val_c->com_ph;?></td>
									<td><?=get_city_name($val_c->city_id);?></td>
									<td>
										<a href="<?php echo base_url()."pharmacy/pharmacy/edit_pharmacy/". urisafeencode($val_c->id);?>"><button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
										| <a href="<?php echo base_url()."pharmacy/pharmacy/view_pharmacy_for_interaction/". urisafeencode($val_c->id);?>"><button type="button" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
										<a href="<?php echo base_url()."pharmacy/pharmacy/pharma_interaction_sales/". urisafeencode($val_c->id).'/'.urisafeencode($date_interact).'/'.urisafeencode(1).'/'.urisafeencode($interaction_city);?>"><button type="button" class="btn btn-info">Interaction</button></a>
										
									   <!--  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_info_appointment<?=$val_c->id ?>">
										 Appointment </button> -->

									<?php  if(is_admin() ){ ?>
											 <?php if($val_c->status==1){ ?>   | <a href="<?php echo base_url()."pharmacy/pharmacy/inactive_pharmacy/".urisafeencode($val_c->id);?>" onclick="return confirm('Are you sure want to In-Active this pharmacy.')" class=""><button type="button" class="btn btn-success">Active</button></a><?php } ?>
										   <?php if($val_c->status==0){ ?>   | <a href="<?php echo base_url()."pharmacy/pharmacy/active_pharmacy/".urisafeencode($val_c->id);?>" onclick="return confirm('Are you sure want to Active this pharmacy.')" class=""><button type="button" class="btn btn-warning">In-Active</button></a><?php } ?>
											 <?php if($val_c->blocked==1){ ?>   | <a href="<?php echo base_url()."pharmacy/pharmacy/remain_pharmacy/".urisafeencode($val_c->id);?>" onclick="return confirm('Are you sure want to Remain this pharmacy.')" class=""><button type="button" class="btn btn-danger">Blocked</button></a><?php } ?>
										   <?php if($val_c->blocked==0){ ?>   | <a href="<?php echo base_url()."pharmacy/pharmacy/blocked_pharmacy/".urisafeencode($val_c->id);?>" onclick="return confirm('Are you sure want to Suspend this pharmacy.')" class=""><button type="button" class="btn btn-success">UnBlocked</button></a><?php } ?>
									<?php } // for admin access ?>
								</td>
							</tr>

						<?php }}} ?>
					</tbody>
				 </table>

            </div>
				</div>
				<!-- Dealer List-->
				<div class="row tab-pane" id="dealer">
					  <div class="box-body">
                <table id="example4" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Dealer Name</th>
							<th>Dealer Email</th>
							<th>Phone Number </th>
							<th>City </th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
  					<?php  if(!empty($d_info)){ foreach($d_info as $k_d=>$val_d){ if(check_user_sp_dealer($val_d->sp_code)){?>
					<tr>
						<td> <?=$val_d->d_name;?></td>
						<td><?=$val_d->d_email;?></td>
						<td><?=$val_d->d_ph;?></td>
						<td><?=get_city_name($val_d->city_id);?></td>
						<td>
							<?php if(empty($val_d->gd_id)){?><a href="<?php echo base_url()."dealer/dealer/edit_dealer/". urisafeencode($val_d->id);?>"><button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a> 
							| <a href="<?php echo base_url()."dealer/dealer/view_dealer_for_doctor/". urisafeencode($val_d->id);?>"><button type="button" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
		  					<a href="<?php echo base_url()."dealer/dealer/dealer_interaction_sales/". urisafeencode($val_d->id).'/'.urisafeencode($date_interact).'/'.urisafeencode(1).'/'.urisafeencode($interaction_city);?>"><button type="button" class="btn btn-info">Interaction</button></a>
							  <?php  if(is_admin()){ ?>
												 
							   <?php if($val_d->status==1){ ?>   | <a href="<?php echo base_url()."dealer/dealer/inactive_dealer/".urisafeencode($val_d->id);?>" onclick="return confirm('Are you sure want to In-Active this dealer.')" class=""><button type="button" class="btn btn-success">Active</button></a><?php } ?>
							   <?php if($val_d->status==0){ ?>   | <a href="<?php echo base_url()."dealer/dealer/active_dealer/".urisafeencode($val_d->id);?>" onclick="return confirm('Are you sure want to Active this dealer.')" class=""><button type="button" class="btn btn-warning">In-Active</button></a><?php } ?>
								 <?php if($val_d->blocked==1){ ?>   | <a href="<?php echo base_url()."dealer/dealer/remain_dealer/".urisafeencode($val_d->id);?>" onclick="return confirm('Are you sure want to Remain this dealer.')" class=""><button type="button" class="btn btn-danger">Blocked</button></a><?php } ?>
							   <?php if($val_d->blocked==0){ ?>   | <a href="<?php echo base_url()."dealer/dealer/blocked_dealer/".urisafeencode($val_d->id);?>" onclick="return confirm('Are you sure want to Suspend this dealer.')" class=""><button type="button" class="btn btn-success">UnBlocked</button></a><?php } ?>
							<?php }}  ?>
						</td>
					</tr>
					
				<?php }}} ?>
				</tbody>
				 </table>
            <!-- /.box-body -->
            </div>
				</div>
			</div>
			<div class="control-sidebar-bg"></div>

		</div>
   </section>
  </div> 
  
<script type="text/javascript">
  $(function () {
    $('#example2').DataTable({
      'responsive'  : true,
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true,
    })
  })

</script>
<script type="text/javascript">
  $(function () {
    $('#example3').DataTable({
      'responsive'  : true,
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true,
    })
  })

</script>
<script type="text/javascript">
  $(function () {
    $('#example4').DataTable({
      'responsive'  : true,
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true,
    })
  })

</script>