<?php





/* 


 * Niraj Kumar


 * date : 23-10-2017


 * show list of users


 */


  $user_info = json_decode($user_data);


//  pr($user_info); die;





?>





<link href="<?= base_url()?>design/css/div_table/one.css" rel="stylesheet" type="text/css"/>


<link href="<?= base_url()?>design/css/div_table/custom_table.css" rel="stylesheet" type="text/css"/>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<link rel="stylesheet" href="<?= base_url()?>design/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">


<style>


	@media	only screen and (max-width: 760px),


	(min-device-width: 768px) and (max-device-width: 1024px)  {


		/*


		Label the data


		*/


		td:nth-of-type(1):before { content: "User Name"; }


		td:nth-of-type(2):before { content: "Email"; }


		td:nth-of-type(3):before { content: "Designation"; }user_permission_details_view

        td:nth-of-type(4):before { content: "Employee Code"; }
        td:nth-of-type(5):before { content: "Sales Person Code"; }
		td:nth-of-type(6):before { content: "Action"; }


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


                <a href="<?= base_url();?>admin_control/user_permission/add_user"> <h3 class="box-title"><button type="button" class="btn btn-block btn-success">Add New</button></h3></a>


            </div>


            <!-- /.box-header -->


            <div class="box-body">


                <table id="example2" class="table table-bordered table-striped">


                <thead>


                <tr>


                  <th> User Name</th>


                  <th> Email</th>


                  <th>Designation</th>
                <th>Employee Code</th>
               <!-- <th>Sales Person Code</th>-->

                  <th>Action</th>


                  


                </tr>


                </thead>


                <tbody>


                


                <?php if(!empty($user_info)){foreach($user_info as $k_u=>$val_u){ ?>


				<tr>


                    <td><?=$val_u->name?></td>


                    <td><?=$val_u->email?></td>


                    <td><?=$val_u->designation_name?></td>
                    <td><?=$val_u->emp_code?></td>
                      <!-- <td><?=$val_u->sp_code?></td>-->


					<td>


					<a href="<?php echo base_url()."admin_control/user_permission/add_user/". urisafeencode($val_u->id);?>"><button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>


                        <?php if($val_u->status==1){ ?>        | <a href="<?php echo base_url()."admin_control/user_permission/del_user/".urisafeencode($val_u->id);?>" onclick="return confirm('Are you sure want to In-Active this record.')" class=""><button type="button" class="btn btn-success">Active</button></a><?php } ?>


                         <?php if($val_u->status==0){ ?>   | <a href="<?php echo base_url()."admin_control/user_permission/active_user/".urisafeencode($val_u->id);?>" onclick="return confirm('Are you sure want to Active this record.')" class=""><button type="button" class="btn btn-danger">In-Active</button></a><?php } ?>


                   </td>


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