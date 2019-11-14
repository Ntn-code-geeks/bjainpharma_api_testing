<?php





/* 


 * Niraj Kumar


 * date : 23-10-2017


 * show list of users


 */





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


		td:nth-of-type(1):before { content: "Product Name"; }


		td:nth-of-type(2):before { content: "Product Name"; }

		td:nth-of-type(3):before { content: "Quantity"; }
		td:nth-of-type(4):before { content: "Discount"; }


		td:nth-of-type(5):before { content: "Net Value"; }


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


				<div class="row" >


					<div class="col-md-6" style="padding:10px;font-size: 20px;">


						<span>Order ID</span> &nbsp; : &nbsp;


						<span><?php if(!empty($order_interaction)) { echo  $order_interaction[0]['order_id'];}?></span>


					</div>


					<div class="col-md-6">


						<span style="padding:10px;font-size: 20px;">Payment Terms</span> &nbsp; : &nbsp;


						<span><?php if(!empty($order_interaction)) { echo $order_interaction[0]['payment_term'];}?></span>


					</div>





				</div>


					


					


                <table id="example2" class="table table-bordered table-striped">


					<thead>


					<tr>


					  <th>Product Name</th>


					  <th>MRP</th>

					  <th>Quantity</th>
					  <th>Discount</th>


					  <th>Net Value</th>


					  


					  


					</tr>


					</thead>


					<tbody>


					 <?php if(!empty($order_details)){ foreach($order_details as $product){  ?>


					 <tr>


						


						<td><?= get_product_name($product['product_id']).'('.get_packsize_name($product['product_id']).')'?></td>


						<td ><?= $product['actual_value']?> &#8377;</td>

						<td ><?= $product['quantity']?> </td>
						<td ><?= $product['discount']?> %</td>


						<td ><?= $product['net_amount']?> &#8377;</td>


					 </tr>


					<?php }  } ?>


					</tbody>

					<tfoot>
						<tr>
						  <td colspan="4" style="text-align:right">Total Amount</td>
						  <td class="total_amount"><?php if(!empty($order_interaction)) { echo $order_interaction[0]['order_amount'].'&#8377;';}?></td>
						</tr>
					</tfoot>



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


