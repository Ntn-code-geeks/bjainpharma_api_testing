<?php



/* 

 * Developer: Niraj Kumar

 * Dated: 20-nov-2017

 * Email: sss.shailesh@gmail.com

 * 

 * for show Dealer interaction 

 * 

 */



//    $doc_int = $doctor_interaction;

//    pr($doc_int); die;

    $dealer_int = $dealer_interaction;
  $secondary_sum=0; 
//      pr($dealer_int); die;

//    $pharma_int = $pharma_interaction;

    

    

?>

<link href="<?= base_url()?>design/css/div_table/one.css" rel="stylesheet" type="text/css"/>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<link href="<?= base_url()?>design/css/div_table/custom_table.css" rel="stylesheet" type="text/css"/>

<link rel="stylesheet" href="<?= base_url()?>design/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<style>



@media



	only screen and (max-width: 760px),



	(min-device-width: 768px) and (max-device-width: 1024px)  {

	

		/*



		Label the data



		*/



		td:nth-of-type(1):before { content: "Date"; }

		td:nth-of-type(2):before { content: "Interaction With"; }

		td:nth-of-type(3):before { content: " Interaction By"; }

		td:nth-of-type(4):before { content: "City"; }

		td:nth-of-type(5):before { content: "Met/Not Met"; }

		td:nth-of-type(6):before { content: "Primary Sale"; }

		td:nth-of-type(7):before { content: "Payment"; }

		td:nth-of-type(8):before { content: "Stock"; }

		td:nth-of-type(9):before { content: "Remark"; }

		td:nth-of-type(10):before { content: "Action"; }



	}



	



</style>

<div class="content-wrapper">



   <section class="content">

<div class="row">

        <div class="col-md-12">

            <div class="box box-default">

                

         <div class="box-header with-border">

<!--             <a href="<?= base_url();?>interaction/interaction/interaction_oncall_view"> 

                    <h3 class="box-title"><button type="button" class="btn btn-block btn-success">Show On Call Interaction</button></h3>

                </a>-->

<!--          <div class="box-tools pull-right">

            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>

            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>

          </div>-->

        </div>

            <!-- /.box-header -->

            <div class="box-body">

                        

					<table id="example2" class="table table-bordered table-striped">

					 <thead>

						<tr>

						  <th>Date</th>

						  <th>Interaction With</th>

						  <th>Interaction By</th>

						  <th>City</th>

						  <th>Met/Not Met</th>

						  <th>Primary Sale</th>

						  <th>Payment</th>

						  <th>Stock</th>

						  <th>Remark</th>

						  <th>Action</th>



						</tr>



					</thead>

					<tbody>



                <?php

                 if(!empty($dealer_int)){

                  foreach($dealer_int['dealer_info'] as $k_d=>$val_d){

                  ?>

                                <tr>

									<td>

										<?= date('Y/m/d',strtotime($val_d['date'])); ?>

									</td>

                                    <td>

										<?=$val_d['customer'];?>

									</td>

                                    <td>

										<?=$val_d['user'];?>

									</td>

                                    <td>

                                         <?=$val_d['city'];?>

									</td>

                                    <td>

                                    <?php

                                    

                                     if($val_d['metnotmet']==TRUE ){

                                       echo "Met";

                                     }

                                     else if($val_d['metnotmet']==FALSE && $val_d['metnotmet']!=NULL ){

                                         

                                         echo "Not Met" ;

                                     }

                                  ?>

                                  </td>

                                    <td>

                                    <?=$val_d['sale'];?>
                                     <?php $secondary_sum=$secondary_sum+$val_d['sale']?>
                                    <?php if(!empty($val_d['sale'])){?>
                                    <br><a href="<?php echo base_url()."order/interaction_order/view_order/". urisafeencode($val_d['id']).'/'. urisafeencode($val_d['d_id']);?>"  target="_blank">View Product</a>
                                    <?php }?>
                                  </td>

                                    <td>

                                    <?=$val_d['payment'];?>

                                  </td>

                                    <td>

                                    <?=$val_d['stock'];?>

                                  </td>

                                    <td>

                                    <?=$val_d['remark'];?>

                                  </td>

                                    <td>

                                      <?php

        if(is_admin()){

        ?>   

                                        

          <a href="<?php echo base_url()."interaction/edit_dealer_interaction/". urisafeencode($val_d['id'] );?>"><button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>

               

        <?php } ?>

                                   </td>

                                   </tr>

                                   

                    <?php  } } ?>

                 

    

</tbody>
<?php if($secondary_sum!=0){?>
<tfooter><tr><td rowspan="5" colspan="5" style=""><strong>Grand Total</strong></td><td rowspan="" colspan="" style=""><strong><?=$secondary_sum?></strong></td></tr></tfooter>
<?php }?>

</table>

                

                

                

              

            </div>

            <!-- /.box-body -->

          </div>

          <!-- /.box -->

        </div>

        <!-- /.col -->



     </div>



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