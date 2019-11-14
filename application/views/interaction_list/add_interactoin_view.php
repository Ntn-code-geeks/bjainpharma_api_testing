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

          <h3 class="box-title">Add Interaction</h3>



        </div>

        <!-- /.box-header -->

        <div class="box-body">

            <?php echo form_open_multipart($action);?>

			<div class="row">

				<div class="col-md-6">

					<div class="form-group">

						<label>Select Interaction Date* </label>

						<div class="input-group date">

						  <div class="input-group-addon">

							<i class="fa fa-calendar"></i>

						  </div>

						 <input value="<?php echo set_value('doi')?>" readonly class="form-control" name="doi" id="doi" type="text">

						</div>

						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('doi'); ?></span>

					</div>

				</div>

				<div class="col-md-6">

					<div class="form-group">

						<label>Planed City</label>

						<input class="form-control" type="text" readonly name="planedcity" value="<?php echo set_value('planedcity')?>" id="planedcity" >

					</div>

				</div>



			</div>



			<div class="row">

				<div class="col-md-6">

					<div class="form-group">

						<label>Interaction City* : </label>

						<select name="interaction_city" id="interaction_city"  class="form-control select2" style="width: 100%;">

						  <option value="">--Select City--</option>

							<?php foreach($city_list as $city){ ?>   

								<option value="<?=$city['city_id']?>" ><?=$city['city_name'].'('.$city['state_name'].')'?></option>

							<?php }  ?>

						</select>

						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('interaction_city'); ?></span>

					</div>

				</div>

			<!--	<div class="col-md-6">

				   <div class="form-group">

					<label>Interaction With* &nbsp; : &nbsp;&nbsp;</label>

					<br>

					<input  type="radio" class="form-check-input" checked <?php echo set_checkbox('interact_with',1); ?> name="interact_with" id="interact_with" value="1">

					&nbsp; Doctor &nbsp;

					<input type="radio" <?php echo set_checkbox('interact_with',2); ?> class="form-check-input ts" name="interact_with" id="interact_with" value="2">

					&nbsp; Dealer &nbsp;

					<input type="radio" <?php echo set_checkbox('interact_with',3); ?> class="form-check-input ts" name="interact_with" id="interact_with" value="3">

					&nbsp; Sub Dealer &nbsp;

					<span class="control-label" for="inputError" style="color: red"><?php echo form_error('navigate_id'); ?></span>

				  </div>

				</div>

			</div>-->

		</div>

		<div class="row">

            <div class="col-md-12">

                <!--<div class="form-group">-->

                <div class="box-footer">

					<button type="submit" class="btn btn-info pull-right">Save</button>

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

     $('#doi').datepicker({

            //format:'dd-mm-yyyy',

            startDate: '-7d',

            endDate: '+0d' ,

            autoclose:true

       })  ; 

    $(function(){



    $('.select2').select2();

     

    });

	

   $("#doi").change(function(){

		var doi=$('#doi').val();

		$.ajax({

		   type:"POST",

		   url:"<?= base_url();?>tour_plan/tour_plan/get_tour_destination",

		   data : 'doi='+doi,

		   success:function(res){ 

				if(res){

					$('#planedcity').val(res);

				}



			}

		});

	});

</script>





