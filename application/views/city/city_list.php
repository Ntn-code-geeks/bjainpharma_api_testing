<?php
/* 
 * Niraj Kumar
 * date : 09-06-2018
 * show list of city
 */
?>
<link href="<?= base_url()?>design/css/div_table/one.css" rel="stylesheet" type="text/css"/>
<link href="<?= base_url()?>design/css/div_table/custom_table.css" rel="stylesheet" type="text/css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="<?= base_url()?>design/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style>
  @media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px)  {
    td:nth-of-type(1):before { content: "City ID"; }
		td:nth-of-type(2):before { content: "City Name"; }
    td:nth-of-type(3):before { content: "State"; }
		td:nth-of-type(4):before { content: "Status"; }
		td:nth-of-type(5):before { content: "Action"; }
  }
</style>
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <?php echo get_flash(); ?>
          <div class="box">
            <div class="box-header">
              <a href="<?= base_url().$action;?>"> <h3 class="box-title"><button type="button" class="btn btn-block btn-success">Add New</button></h3></a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example2" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>City ID</th>
                      <th>City Name</th>
                      <th>State</th>
                      <th>Status</th>
                      <th>Action </th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php if(!empty($city_list)){foreach($city_list as $list){ ?>
            				<tr>
                      <td><?=$list['city_id']; ?></td>
                      <td><?=$list['city_name']; ?></td>
                      <td><?=$list['state_name']; ?></td>
                      <td><?=$list['status']==1?'Enable':'Disabled'; ?></td>
            					<td>
                        <a title="Edit City" href="<?php echo base_url()."city/city/edit_city/". urisafeencode($list['city_id']);?>"><button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                        <?php if($list['status']==1){?>
                          <a onclick="return confirm('Are you sure? You want to Disabled City.')" title="Disabled City" href="<?php echo base_url()."city/city/disabled_city/". urisafeencode($list['city_id']);?>"><button type="button" class="btn btn-danger"><i class="fa fa-remove" aria-hidden="true"></i></button></a>
                        <?php }else{?>
                          <a onclick="return confirm('Are you sure? You want to Enable City.')" title="Enable City" href="<?php echo base_url()."city/city/enable_city/". urisafeencode($list['city_id']);?>"><button type="button" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></button></a>
                        <?php }?>
                      </td>
                    </tr>
                  <?php } }?>
                 </tbody>
              </table>
			     </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
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