<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 $state_name = json_decode($statename);

  $d_info = json_decode($dealer_data);
  
  $ms = json_decode($meeting_sample);
  
  $team_list=json_decode($users_team);  // show child and boss users
  
// pr($d_info); die;
?>

<!--  DataTables 
 <link rel="stylesheet" href="<?= base_url()?>design/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
 -->
<link href="<?= base_url()?>design/css/div_table/one.css" rel="stylesheet" type="text/css"/>
<link href="<?= base_url()?>design/css/div_table/custom_table.css" rel="stylesheet" type="text/css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="<?= base_url()?>design/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<style>
@media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px)  {
		/* Label the data */
		td:nth-of-type(1):before { content: "Dealer Name"; }
		td:nth-of-type(2):before { content: "Dealer Email"; }
		td:nth-of-type(3):before { content: "Phone Number"; }
		td:nth-of-type(4):before { content: "City"; }
		td:nth-of-type(5):before { content: "City Pincode"; }
		td:nth-of-type(6):before { content: "Action"; }
}

</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
        <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
		<?php echo get_flash(); ?>
          <div class="box">
              <?php  if(is_admin()){       ?>
            <div class="box-header">
                 <a href="<?= base_url();?>pharma_nav/customer/nav_cust_connect"> 
                    <h3 class="box-title"><button type="button" class="btn btn-block btn-success">Sync Dealer</button></h3>
                </a> 

                <!--end Search-->
            </div>
              <?php }       ?>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example2" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Dealer Name</th>
							<th>Dealer Email</th>
							<th>Phone Number </th>
							<th>City </th>
							<th>City Pincode</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
  					<?php  if(!empty($d_info)){ foreach($d_info as $k_d=>$val_d){
  						if(is_admin()){       ?>
					<tr>
						<td> <?=$val_d->d_name;?></td>
						<td><?=$val_d->d_email;?></td>
						<td><?=$val_d->d_ph;?></td>
						<td><?=get_city_name($val_d->city_id);?></td>
						<td><?=$val_d->city_pincode;?></td>
						<td>
							<?php if(empty($val_d->gd_id)){?>
								<!-- <a href="<?php echo base_url()."dealer/dealer/edit_dealer/". urisafeencode($val_d->id);?>">
									<button type="button" class="btn btn-info">
										<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
									</button>
								</a> | -->
							 <a href="<?php echo base_url()."dealer/dealer/view_dealer_for_doctor/". urisafeencode($val_d->id);?>"><button type="button" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
		  
								<?php if($date_interact==''){?>
									<a href="<?php echo base_url()."dealer/dealer/dealer_interaction_sales/".urisafeencode($val_d->id);?>">
										<button type="button" class="btn btn-info">Interaction</button>
									</a>
								<?php }else{?>
									<a href="<?php echo base_url()."dealer/dealer/dealer_interaction_sales/". urisafeencode($val_d->id).'/'.urisafeencode($date_interact);?>"><button type="button" class="btn btn-info">Interaction</button></a>
								<?php }?>
											 
							   <?php if($val_d->status==1){ ?>   | <a href="<?php echo base_url()."dealer/dealer/inactive_dealer/".urisafeencode($val_d->id);?>" onclick="return confirm('Are you sure want to In-Active this dealer.')" class=""><button type="button" class="btn btn-success">Active</button></a><?php } ?>
							   <?php if($val_d->status==0){ ?>   | <a href="<?php echo base_url()."dealer/dealer/active_dealer/".urisafeencode($val_d->id);?>" onclick="return confirm('Are you sure want to Active this dealer.')" class=""><button type="button" class="btn btn-warning">In-Active</button></a><?php } ?>
								 <?php if($val_d->blocked==1){ ?>   | <a href="<?php echo base_url()."dealer/dealer/remain_dealer/".urisafeencode($val_d->id);?>" onclick="return confirm('Are you sure want to Remain this dealer.')" class=""><button type="button" class="btn btn-danger">Blocked</button></a><?php } ?>
							   <?php if($val_d->blocked==0){ ?>   | <a href="<?php echo base_url()."dealer/dealer/blocked_dealer/".urisafeencode($val_d->id);?>" onclick="return confirm('Are you sure want to Suspend this dealer.')" class=""><button type="button" class="btn btn-success">UnBlocked</button></a><?php } ?>
							<?php }  ?>
									   
						</td>
						
					</tr>
					<?php }else{ if(check_user_sp_dealer($val_d->sp_code)){?>
					<tr>
						<td> <?=$val_d->d_name;?></td>
						<td><?=$val_d->d_email;?></td>
						<td><?=$val_d->d_ph;?></td>
						<td><?=get_city_name($val_d->city_id);?></td>
						<td><?=$val_d->city_pincode;?></td>
						<td>
							<?php if(empty($val_d->gd_id)){?>
								<!-- <a href="<?php echo base_url()."dealer/dealer/edit_dealer/". urisafeencode($val_d->id);?>"><button type="button" class="btn btn-info">
								<i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a> | -->

							 <a href="<?php echo base_url()."dealer/dealer/view_dealer_for_doctor/". urisafeencode($val_d->id);?>"><button type="button" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
								<?php if($date_interact==''){?>
									<a href="<?php echo base_url()."dealer/dealer/dealer_interaction_sales/".urisafeencode($val_d->id);?>">
									<button type="button" class="btn btn-info">Interaction</button>
									</a>
								<?php }else{?>
									<a href="<?php echo base_url()."dealer/dealer/dealer_interaction_sales/". urisafeencode($val_d->id).'/'.urisafeencode($date_interact);?>"><button type="button" class="btn btn-info">Interaction</button></a>
								<?php }?>
							<?php }  ?>
						</td>
					</tr>
 					<?php }} ?>
				<?php }} ?>
				</tbody>
				 </table>
            <!-- /.box-body -->
            </div>
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


