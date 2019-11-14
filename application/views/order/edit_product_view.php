<?php



/* 

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */





?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>





<div class="content-wrapper">



    <!-- Main content -->

    <section class="content">

    <?php echo get_flash(); ?>

      <!-- Contact Add -->

      <div class="box box-default">

        <div class="box-header with-border">

          <h3 class="box-title">Edit Product </h3>



        </div>

        <!-- /.box-header -->

        <div class="box-body">

            <?php echo form_open_multipart($action);?>

			<div class="row">

				<div class="col-md-12">

					<div class="form-group">

						<label>Category : </label><br>

						<input type="hidden" name ="order_id" value="<?= $order_id ?>">

						<input type="hidden" name ="person_id" value="<?= $person_id ?>">

						<input type="hidden" name ="interaction_order_id" value="<?= $interaction_order_id ?>">

							<?php foreach($category_list as $category){ ?>

								<div class="col-md-3">

								<input class="cat_list" <?php echo in_array($category['category_id'], $order_category)?'Checked':'';?> catid="<?= $category['category_id'] ?>" type="checkbox" name="category_list[]" value="<?= $category['category_id'] ?>">&nbsp;&nbsp;<?= $category['category_name'] ?>

								</div>

							<?php }  ?><br>

							

					</div>

					<span class="control-label" for="inputError" style="color: red"><?php echo form_error('category_list[]'); ?>

				</div>

			</div>

			<br><br>

			<div class="row">

				<div class="col-md-12">

					<div class="form-group">

						<label>Product List : </label><br>

						<div class="product_data" id="product_data" style="height: 200px;overflow-y: auto;margin: 10px;">

							<?php foreach($order_category as $category){ $productlist =get_category_product($category);?>
								<div id="cat_box_<?php echo $category?>" class="cat_box_<?php echo $category?>">
								<?php foreach($productlist as $product){ ?>

								<div class="col-md-4">
									<input <?php echo in_array($product['product_id'], $order_product)?'Checked':'';?> class="product_list" type="checkbox" name="product_list_<?php echo $category?>[]" value='<?php echo $product['product_id'] ?>'>&nbsp;&nbsp;<?php echo $product['product_name'].'('.$product['packsize_value'].')' ?></div>
								

								<?php } ?>
								</div>
							<?php }?>

						</div>

					</div>

				</div>

			</div>

	

		</div>

		<div class="row">

            <div class="col-md-12">

                <!--<div class="form-group">-->

                <div class="box-footer">

					<button type="submit" class="btn btn-info pull-right">Add</button>

                </div>

            </div>

        </div>

          <!-- /.row -->

          

          <?php

          echo form_close(); 

          ?>

        </div>

        <!-- /.box-body -->

        

      </div>

      <!-- /.box -->



    </section>

    <!-- /.content -->

  </div>

<script src="<?php echo base_url();?>design/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script type='text/javascript'>
  $(document).on('click','.cat_list',function(){
	  var catId=$(this).val();
	  if($(this).is(':checked')){
		if(document.getElementById('cat_box_'+catId))
		{
			$('.cat_box_'+catId).css('display','block');
		}
		else
		{
			$.ajax({
			   type:"POST",
			   url:"<?= base_url();?>order/interaction_order/get_product_list/",
			   data : 'id='+catId,
			   success:function(res){ 
					if(res){
						var data = $.parseJSON(res);
						$.each(data, function(index, value) {
							$("#product_data").append('<div id="cat_box_'+catId+'" class="cat_box_'+catId+'"><div class="col-md-4"><input class="product_list" type="checkbox" name="product_list_'+catId+'[]" value='+value.product_id+'>&nbsp;&nbsp;'+value.product_name+'('+value.packsize_value+')'+'</div></div>');
						});
					}

				}
			});
		}
	  }
	  else
	  {
		$('.cat_box_'+catId).css('display','none');
	  }
  });
   
</script>




