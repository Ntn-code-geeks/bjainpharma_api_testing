<?php

/* 
 * Niraj Kumar
 * date : 05-03-2018
 * show list of users
 */
  //$user_info = json_decode($user_data);
//  pr($user_info); die;

?>

<link href="<?= base_url()?>design/css/div_table/one.css" rel="stylesheet" type="text/css"/>
<link href="<?= base_url()?>design/css/div_table/custom_table.css" rel="stylesheet" type="text/css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="<?= base_url()?>design/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style>
@media
	only screen and (max-width: 760px),
	(min-device-width: 768px) and (max-device-width: 1024px)  {
		/*
		Label the data
		*/
		td:nth-of-type(1):before { content: "Transit Date"; }
		td:nth-of-type(2):before { content: "Source City"; }
		td:nth-of-type(3):before { content: "Destination City"; }
		td:nth-of-type(4):before { content: "Transit Start"; }
		td:nth-of-type(5):before { content: "Transit End"; }
		td:nth-of-type(6):before { content: "Remark"; }
		td:nth-of-type(7):before { content: "Action"; }
	}
	
</style>
<div class="content-wrapper">
   
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
   <?php echo get_flash(); ?>
          <div class="box">
                  <!-- /.box-header -->
            <div class="box-body">
                <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Transit Date</th>
                  <th>Source City</th>
                  <th>Destination City </th>
                  <th>Transit Start </th>
                  <th>Transit End </th>
                  <th>Remark </th>
				  <th>Action</th>
                  
                </tr>
                </thead>
                <tbody>
                
                <?php if(!empty($transit_list)){foreach($transit_list as $transit){ ?>
				<tr>
					<td><?= date('d-m-Y',strtotime($transit['transit_date']))?></td>
                    <td><?=get_city_name($transit['source'])?></td>
                    <td><?=get_city_name($transit['destination'])?></td>
                    <td><?=date('h:i A', strtotime($transit['transit_time_start']));?></td>
                    <td><?=date('h:i A', strtotime($transit['transit_time_end']));?></td>
                    <td><?=substr($transit['remark'], 0, 20)."...";?></td>
					<?php if($transit['transit_status']==0){?>
					<td><a href="<?php echo base_url()."transit/transit/edit_transit_data/". urisafeencode($transit['transit_id']);?>"><button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
					</td>
					<?php }else{?>
					<td><a href="<?php echo base_url()."transit/transit/edit_other_transit/". urisafeencode($transit['transit_id']);?>"><button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
					</td>
					<?php }?>
                </tr>
                    <?php }  } ?>
                
                </tbody>
              </table>
			</div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  



<script>
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