<?php



/**
 * Developer: Shailesh Saraswat
 * Email: sss.shailesh@gmail.com
 * Dated: 16-AUG-2018
 * 
 * List of my customer of navigon 
 */


$mycustomers = json_decode($my_customer);

//pr($my_customer); die;

?>

<link href="<?= base_url()?>design/css/div_table/one.css" rel="stylesheet" type="text/css"/>
<link href="<?= base_url()?>design/css/div_table/custom_table.css" rel="stylesheet" type="text/css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="<?= base_url()?>design/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<style>
@media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px)  {
		/* Label the data */
		td:nth-of-type(1):before { content: "Customer Name"; }
		td:nth-of-type(2):before { content: "Net Balance"; }
		td:nth-of-type(3):before { content: "Net Overdue"; }
		td:nth-of-type(4):before { content: "Target In 2018-19"; }
		td:nth-of-type(5):before { content: "Ach. In 2018-19"; }
		
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


            <!-- /.box-header -->

            <div class="box-body">

                <table id="example2" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Customer Name</th>
							<th>Net Balance</th>
							<th>Net Overdue</th>
							<th>Target In 2018-19</th>
							<th>Ach. In 2018-19</th>
							
							<th>Action</th>
						</tr>
					</thead>

					<tbody>
						<?php  if(!empty($mycustomers)){ 
                                                    foreach($mycustomers as $k_c=>$val_c){      ?>
						<tr>
							<td><?=$val_c->name;?></td>
							<td><?=$val_c->balance;?></td>
							<td><?=$val_c->net_overdue;?></td>
							<td><?=$val_c->target_in;?></td>
							<td><?=$val_c->personal_ach;?></td>
							
							<td> 
						            <a href="#"><button type="button" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
	
							</td>

						 </tr>

			   
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