<?php



/* 

 * Niraj Kumar

 * Dated: 25-oct-2017

 * 

 * show all Retail pharmacy

 */



	$dealer_data = json_decode($dealer_list);   // for all active dealers 
	$pharma_info = json_decode($pharma_data);
	$ms = json_decode($meeting_sample);
	$team_list=json_decode($users_team);  // show child and boss users


?>

<link href="<?= base_url()?>design/css/div_table/one.css" rel="stylesheet" type="text/css"/>
<link href="<?= base_url()?>design/css/div_table/custom_table.css" rel="stylesheet" type="text/css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="<?= base_url()?>design/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<style>
	@media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px)  {
		/* Label the data */
		td:nth-of-type(1):before { content: "Name"; }
		td:nth-of-type(2):before { content: "Email"; }
		td:nth-of-type(3):before { content: "Phone Number"; }
		td:nth-of-type(4):before { content: "City"; }
		td:nth-of-type(5):before { content: "City Pincode"; }
		td:nth-of-type(6):before { content: "Action"; }
	}
</style>



<div class="content-wrapper modal-open">
    <!-- Main content -->

    <section class="content">

      <div class="row">

        <div class="col-xs-12">

		<?php echo get_flash(); ?>

          <div class="box">

            <div class="box-header">
                <a href="<?= base_url();?>pharmacy/pharmacy/add_list"> <h3 class="box-title"><button type="button" class="btn btn-block btn-success">Add New</button></h3></a>
            </div>

            <!-- /.box-header -->

            <div class="box-body">
				<table id="example2" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th> Name</th>
							<th> Email</th>
							<th>Phone Number </th>
							<th>City </th>
							<th>City Pincode</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($pharma_info)){ foreach($pharma_info as $k_c=>$val_c){ 
							if(is_admin()){       ?>
							  <tr>
									<td> <?=$val_c->com_name;?></td>
									<td><?=$val_c->com_email;?></td>
									<td><?=$val_c->com_ph;?></td>
									<td><?=get_city_name($val_c->city_id);?></td>
									<td><?=$val_c->city_pincode;?></td>
									<td>
										<a href="<?php echo base_url()."pharmacy/pharmacy/edit_pharmacy/". urisafeencode($val_c->id);?>"><button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
										| <a href="<?php echo base_url()."pharmacy/pharmacy/view_pharmacy_for_interaction/". urisafeencode($val_c->id);?>"><button type="button" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
										<?php if($date_interact==''){?>
											<a href="<?php echo base_url()."pharmacy/pharmacy/pharma_interaction_sales/".urisafeencode($val_c->id);?>">
											<button type="button" class="btn btn-info">Interaction</button></a>
										<?php }else{?>
											<a href="<?php echo base_url()."pharmacy/pharmacy/pharma_interaction_sales/". urisafeencode($val_c->id).'/'.urisafeencode($date_interact);?>"><button type="button" class="btn btn-info">Interaction</button></a>
										<?php }?>
									   <!--  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_info_appointment<?=$val_c->id ?>">
										 Appointment </button> -->
									
											 <?php if($val_c->status==1){ ?>   | <a href="<?php echo base_url()."pharmacy/pharmacy/inactive_pharmacy/".urisafeencode($val_c->id);?>" onclick="return confirm('Are you sure want to In-Active this pharmacy.')" class=""><button type="button" class="btn btn-success">Active</button></a><?php } ?>
										   <?php if($val_c->status==0){ ?>   | <a href="<?php echo base_url()."pharmacy/pharmacy/active_pharmacy/".urisafeencode($val_c->id);?>" onclick="return confirm('Are you sure want to Active this pharmacy.')" class=""><button type="button" class="btn btn-warning">In-Active</button></a><?php } ?>
											 <?php if($val_c->blocked==1){ ?>   | <a href="<?php echo base_url()."pharmacy/pharmacy/remain_pharmacy/".urisafeencode($val_c->id);?>" onclick="return confirm('Are you sure want to Remain this pharmacy.')" class=""><button type="button" class="btn btn-danger">Blocked</button></a><?php } ?>
										   <?php if($val_c->blocked==0){ ?>   | <a href="<?php echo base_url()."pharmacy/pharmacy/blocked_pharmacy/".urisafeencode($val_c->id);?>" onclick="return confirm('Are you sure want to Suspend this pharmacy.')" class=""><button type="button" class="btn btn-success">UnBlocked</button></a><?php } ?>
									
								</td>
							</tr>
							<?php }else{ if(check_user_sp($val_c->sp_code)){?>
								<tr>
									<td> <?=$val_c->com_name;?></td>
									<td><?=$val_c->com_email;?></td>
									<td><?=$val_c->com_ph;?></td>
									<td><?=get_city_name($val_c->city_id);?></td>
									<td><?=$val_c->city_pincode;?></td>
									<td>
										<a href="<?php echo base_url()."pharmacy/pharmacy/edit_pharmacy/". urisafeencode($val_c->id);?>"><button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
										| <a href="<?php echo base_url()."pharmacy/pharmacy/view_pharmacy_for_interaction/". urisafeencode($val_c->id);?>"><button type="button" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
										<?php if($date_interact==''){?>
											<a href="<?php echo base_url()."pharmacy/pharmacy/pharma_interaction_sales/".urisafeencode($val_c->id);?>">
											<button type="button" class="btn btn-info">Interaction</button></a>
										<?php }else{?>
											<a href="<?php echo base_url()."pharmacy/pharmacy/pharma_interaction_sales/". urisafeencode($val_c->id).'/'.urisafeencode($date_interact);?>"><button type="button" class="btn btn-info">Interaction</button></a>
										<?php }?>
										</td>
									</tr>

							<?php }} ?>

						<?php }} ?>
					</tbody>
				 </table>

            </div>

            <!-- /.box-body -->

            </div>

          <!-- /.box -->

        </div>

        <!-- /.col -->

      </div>

      <!-- /.row -->

    </section>

    <!-- /.content -->

  </div>

<script type="text/javascript">
  $(function () {
    $('#example2').DataTable({
      'responsive' : true,
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true,
    })
  })

</script>