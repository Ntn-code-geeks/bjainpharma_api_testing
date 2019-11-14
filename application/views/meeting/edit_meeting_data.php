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
          <h3 class="box-title">Edit Meeting Plan</h3>

        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php echo form_open_multipart($action);?>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Type Of Meeting* : </label>
						<input type="hidden" name ="meeting_id" value="<?php echo $meeting_data[0]['meeting_id']; ?>">
						<select name="meeting_type" id="meeting_type"  class="form-control select2" style="width: 100%;">
							<option value="">-- Select Meeting Type --</option>
							<?php foreach($meeting_master as $meeting){ ?>
								<option <?php echo ($meeting['meeting_id']==$meeting_data[0]['meeting_type'])?'Selected':''; ?> value="<?=$meeting['meeting_id']?>"><?=$meeting['meeting_value']?></option>
							<?php } ?>
						</select>
						
						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('meeting_type'); ?></span>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Place Of Meeting*  : </label>
						<select name="meeting_city" id="meeting_city"  class="form-control select2" style="width: 100%;">
						  <option value="">-- Select Meeting City --</option>
							<?php foreach($city_list as $city){ ?>   
								<option <?php echo ($city['city_id']==$meeting_data[0]['meeting_place'])?'Selected':''; ?> value="<?=$city['city_id']?>" ><?=$city['city_name'].'('.$city['state_name'].')'?></option>
							<?php }  ?>
						</select>
						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('meeting_city'); ?></span>
					</div>
					
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Transit Date* </label>
						<div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input class="form-control pull-right" readonly name="meeting_date" value="<?php echo date('m/d/Y',strtotime($meeting_data[0]['meeting_date'])) ?>" id="datepicker" type="text">
						</div>
						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('meeting_date'); ?></span>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Remark</label>
						<textarea class="form-control" rows="3" name="remark" id="remark" placeholder="Remark ..."><?php echo $meeting_data[0]['remark'] ?></textarea>
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
  $('#datepickerend').datepicker({
              autoclose: true
    }) ;
    $(function(){

    $('.select2').select2();
     
    });
   
</script>
