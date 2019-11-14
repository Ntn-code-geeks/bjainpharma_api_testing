<?php

/* 
 * @author: Niraj Kumar
 * 
 * Show details of C & F
 */
 $state_name = json_decode($statename);

 $d_info = json_decode($dealer_data);
$ms = json_decode($meeting_sample);
 
 
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
		td:nth-of-type(1):before { content: "C & F Name"; }
		td:nth-of-type(2):before { content: "C & F Email"; }
		td:nth-of-type(3):before { content: "Phone Number"; }
		td:nth-of-type(4):before { content: "City"; }
		td:nth-of-type(5):before { content: "Action"; }
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
            <div class="box-header">
                <a href="<?= base_url();?>dealer/dealer/add_main_dealer"> 
                    <h3 class="box-title"><button type="button" class="btn btn-block btn-success">Add New</button></h3>
                </a>
            </div>
              
            <!-- /.box-header -->
            <div class="box-body">
               <table id="example2" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>C & F Name</th>
							<th>C & F Email</th>
							<th>Phone Number </th>
							<th>City </th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php if(!empty($d_info)){ foreach($d_info as $k_d=>$val_d){ ?>
						<tr>
							<td><?=$val_d->d_name;?></td>
							<td><?=$val_d->d_email;?></td>
						    <td><?=$val_d->d_ph;?></td>
							<td><?=$val_d->d_city;?></td>
							<td> 
								<a href="<?php echo base_url()."/dealer/dealer/edit_group_dealer/". urisafeencode($val_d->id);?>"><button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a> 
								| <a href="<?php echo base_url()."/dealer/dealer/view_group_dealer_for_doctor/". urisafeencode($val_d->id);?>"><button type="button" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
								<a href="<?php echo base_url()."dealer/dealer/dealer_interaction_sales/".urisafeencode($val_d->id);?>">
								<button type="button" class="btn btn-info">Interaction</button>
								</a>
								<?php if(is_admin()){ ?>
								   <?php if($val_d->status==1){ ?>   | <a href="<?php echo base_url()."dealer/dealer/inactive_dealer/".urisafeencode($val_d->id);?>" onclick="return confirm('Are you sure want to In-Active this dealer.')" class=""><button type="button" class="btn btn-success">Active</button></a><?php } ?>
								   <?php if($val_d->status==0){ ?>   | <a href="<?php echo base_url()."dealer/dealer/active_dealer/".urisafeencode($val_d->id);?>" onclick="return confirm('Are you sure want to Active this dealer.')" class=""><button type="button" class="btn btn-warning">In-Active</button></a><?php } ?>
									 <?php if($val_d->blocked==1){ ?>   | <a href="<?php echo base_url()."dealer/dealer/remain_dealer/".urisafeencode($val_d->id);?>" onclick="return confirm('Are you sure want to Remain this dealer.')" class=""><button type="button" class="btn btn-danger">Blocked</button></a><?php } ?>
								   <?php if($val_d->blocked==0){ ?>   | <a href="<?php echo base_url()."dealer/dealer/blocked_dealer/".urisafeencode($val_d->id);?>" onclick="return confirm('Are you sure want to Suspend this dealer.')" class=""><button type="button" class="btn btn-success">UnBlocked</button></a><?php } ?>
									
							<?php } ?>
							</td>
						
						</tr>
					
					<?php }} ?>
					</tbody>
				 </table>
    
              <!-- /.box-body -->
            </div></div>
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