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
					<label>Select Pharma User*</label>
					<select name="user_id[]"  multiple class="form-control select2" style="width: 100%;">
					  <option value="">-- Person Name List --</option>
						<?php foreach($user_list as $user){ ?>   
						   <option value="<?=$user['id']?>"><?=$user['name'];?></option>
						<?php  } ?>
					</select>
					<span class="control-label" for="inputError" style="color: red"><?php echo form_error('user_id[]'); ?></span>
				  </div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>Date Of Meeting* </label>
						<div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input class="form-control pull-right" readonly name="meeting_date" value="<?php echo set_value('meeting_date') ?>" id="datepicker1" type="text">
						</div>
						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('meeting_date'); ?></span>
					</div>
				</div>

            </div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Destination City* </label>
						<select name="city_to"   class="form-control select2" style="width: 100%;">
						  <option value="">-- Select City --</option>
							<?php foreach($city_list as $user){ ?>   
							   <option value="<?=$user['city_id']?>"><?=$user['city_name'];?></option>
							<?php  } ?>
						</select>
						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('city_to'); ?></span>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Remark</label>
						<textarea class="form-control" rows="3" name="remark" id="remark" placeholder="Remark ..."><?php echo set_value('remark') ?></textarea>
					</div>
				</div>
			</div>
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

    $(function(){

    $('.select2').select2();
     
    });
    $('#datepicker1').datepicker({
        format:'dd-mm-yyyy',
        startDate: '0d',
       // endDate: '+0d' ,
        autoclose:true
    })  ; 
</script>

