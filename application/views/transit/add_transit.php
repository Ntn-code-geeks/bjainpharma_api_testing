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
          <h3 class="box-title">Add Transit Plan</h3>

        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php echo form_open_multipart($action);?>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>SOURCE* : </label>
						<select name="source_city" id="source_city"  class="form-control select2" style="width: 100%;">
						  <option value="">--Select Source City --</option>
							<?php foreach($city_list as $city){ ?>   
								<option <?php echo set_select('source_city', $city['id']); ?> value="<?=$city['id']?>" ><?=get_city_name($city['id'])?></option>
							<?php }  ?>
						</select>
						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('source_city'); ?></span>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>DESTINATION* : </label>
						<select name="dest_city" id="dest_city"  class="form-control select2" style="width: 100%;">
						  <option value="">--Select Destination City--</option>
							<?php foreach($city_list as $city){ ?>   
								<option  <?php echo set_select('dest_city', $city['id']); ?> value="<?=$city['id']?>" ><?=get_city_name($city['id'])?></option>
							<?php }  ?>
						</select>
						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('dest_city'); ?></span>
					</div>
					
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="bootstrap-timepicker">
						<div class="form-group">
						  <label>Start Time:</label>

						  <div class="input-group">
							<input type="text" readonly name="transit_st_time" id="transit_st_time" class="form-control timepicker">

							<div class="input-group-addon">
							  <i class="fa fa-clock-o"></i>
							</div>
						  </div>
						  <!-- /.input group -->
						</div>
						<!-- /.form group -->
					 </div>
				</div>
				 <div class="col-md-6">
					<div class="bootstrap-timepicker">
					<div class="form-group">
					  <label>End Time:</label>
					  <div class="input-group">
						<input type="text" readonly name="transit_time_end" id="transit_time_end" class="form-control timepicker">

						<div class="input-group-addon">
						  <i class="fa fa-clock-o"></i>
						</div>
					  </div>
					  <!-- /.input group -->
					</div>
					<!-- /.form group -->
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
						  <input readonly class="form-control pull-right" name="transit_date" value="<?php echo set_value('transit_date') ?>" id="datepicker" type="text">
						</div>
						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('transit_date'); ?></span>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Remark</label>
						<textarea class="form-control" rows="3" name="remark" id="remark" placeholder="Remark ..."><?php echo set_value('remark') ?></textarea>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
				   <div class="form-group">
					<label>Select &nbsp; : &nbsp;&nbsp;</label>
					<input  type="radio" class="form-check-input" checked name="stay" id="stay" value="0">
					&nbsp; Not Stay &nbsp;
					<input type="radio" <?php echo set_checkbox('stay',1); ?> class="form-check-input ts" name="stay" id="stay" value="1">
					&nbsp; Stay &nbsp;
					<span class="control-label" for="inputError" style="color: red"><?php echo form_error('navigate_id'); ?></span>
				  </div>
				</div>
			
			
				<div class="row bill_attach" style="display:none">
					<div class="col-md-6">
					   <div class="form-group">
						<label>Bill Attachemnt  *</label>
						<input type="file" name="filebill" value="<?php echo set_value('filebill') ?>" id="filebill">
						<span class="control-label" for="" style="">File type allowed Png,jpeg,jpg only.</span>
						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('filebill'); ?></span>
					  </div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
				   <div class="form-group">
					<label>Ticket Attachment  *</label>
					<input type="file" name="file"  value="<?php echo set_value('file') ?>"  id="file">
					<span class="control-label" for="" style="">File type allowed Png,jpeg,jpg only.</span>
					<span class="control-label" for="inputError" style="color: red"><?php echo form_error('file'); ?></span>
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

<script type='text/javascript'>
  $(document).on('click','#stay',function(){
	  var stayValue=$(this).val();
	  if(stayValue==1)
	  {
		$('.bill_attach').css('display','block');
	  }
	  else
	  {
		$('.bill_attach').css('display','none');  
	  }
  });
   
</script>
<script type='text/javascript'>
if($('.ts').is(':checked')){
	$('.bill_attach').css('display','block');
}
     
</script>
