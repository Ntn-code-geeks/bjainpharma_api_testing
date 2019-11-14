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

          <h3 class="box-title">Add</h3>



        </div>

        <!-- /.box-header -->

        <div class="box-body">

            <?php echo form_open_multipart($action);?>

            <div class="row">

				<div class="col-md-6">

				   <div class="form-group">

				   <input type="hidden" id="tour_id" value="<?=$tour_data->tour_id;?>" name="tour_id"/>

					<label>Select Pharma User*</label>

					<select name="user_id"   class="form-control select2" style="width: 100%;">

					  <option value="">-- Person Name List --</option>

						<?php foreach($user_list as $user){ ?>   

						   <option <?php echo ($user['id']==$tour_data->pharma_user_id)?'selected':'';?> value="<?=$user['id']?>"><?=$user['name'];?></option>

						<?php  } ?>

					</select>

					<span class="control-label" for="inputError" style="color: red"><?php echo form_error('user_id'); ?></span>

				  </div>

				</div>

				<div class="col-md-6">

					<div class="form-group">

						<label>Fare In INR*</label>

						<input class="form-control" type="number"  value="<?php echo $tour_data->fare; ?>" name="city_fare" placeholder="Enter Fare In INR ..." type="text" value="">               

						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('city_fare'); ?></span>

					</div>

				</div>

            </div>

			<div class="row">

				<div class="col-md-6">

					<div class="form-group">

						<label>Source City* </label>

						<select name="city_from"   class="form-control select2" style="width: 100%;">

						  <option value="">-- Select City --</option>

							<?php foreach($city_list as $user){ ?>   

							   <option <?php echo ($user['city_id']==$tour_data->source_city)?'selected':'';?> value="<?=$user['city_id']?>"><?=$user['city_name'];?></option>

							<?php  } ?>

						</select>

						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('city_from'); ?></span>

					</div>

				</div>

				<div class="col-md-6">

					<div class="form-group">

						<label>Destination City* </label>

						<select name="city_to"   class="form-control select2" style="width: 100%;">

						  <option value="">-- Select City --</option>

							<?php foreach($city_list as $user){ ?>   

							   <option <?php echo ($user['city_id']==$tour_data->dist_city)?'selected':'';?> value="<?=$user['city_id']?>"><?=$user['city_name'];?></option>

							<?php  } ?>

						</select>

						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('city_to'); ?></span>

					</div>

				</div>

			</div>

			<div class="row">

				<div class="col-md-6">

					<div class="form-group">

						<label>Distance In KM*</label>

						<input class="form-control" value="<?php echo $tour_data->distance;  ?>" type="text" name="city_distance" placeholder="Enter Distance in KM ..." type="text" value="">               

						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('city_distance'); ?></span>

					</div>

				</div>

				<div class="col-md-6">

					<div class="form-group">

						<label>Remark</label>

						<textarea class="form-control" rows="3" name="remark" id="remark" placeholder="Remark ..."><?php echo $tour_data->remark;  ?></textarea>

					</div>

				</div>



			</div>

		</div>

		<div class="row">

            <div class="col-md-12">

                <!--<div class="form-group">-->

                <div class="box-footer">

					<button type="submit" class="btn btn-info pull-right">Edit</button>

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



<script type='text/javascript'>

    $(function(){



    $('.select2').select2();

     

    });

    

</script>

