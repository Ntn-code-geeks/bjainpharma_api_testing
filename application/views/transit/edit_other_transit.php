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
          <h3 class="box-title">Edit Other Transit Plan</h3>

        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php echo form_open_multipart($action);?>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>SOURCE* : </label>
						<input type="hidden" name ="transit_id" value="<?php echo $transit_data[0]['transit_id']; ?>">
						<select name="source_city" id="source_city"  class="form-control select2" style="width: 100%;">
						  <option value="">--Select Source City --</option>
							<?php foreach($city_list as $city){ ?>   
								<option <?php echo ($city['city_id']==$transit_data[0]['source'])?'selected':'';?> value="<?=$city['city_id']?>" ><?=$city['city_name']?></option>
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
								<option <?php echo ($city['city_id']==$transit_data[0]['destination'])?'Selected':''; ?> value="<?=$city['city_id']?>" ><?=$city['city_name']?></option>
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
							<input readonly type="text" value="<?= date('h:i A', strtotime($transit_data[0]['transit_time_start']))?>" name="transit_st_time" id="transit_st_time" class="form-control timepicker">

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
						<input readonly type="text" value="<?= date('h:i A', strtotime($transit_data[0]['transit_time_end']))?>" name="transit_time_end" id="transit_time_end" class="form-control timepicker">

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
						  <input readonly class="form-control pull-right" name="transit_date" value="<?php echo date('m/d/Y',strtotime($transit_data[0]['transit_date'])) ?>" id="datepicker" type="text">
						</div>
						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('transit_date'); ?></span>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Remark</label>
						<textarea class="form-control" rows="3" name="remark" id="remark" placeholder="Remark ..."><?php echo $transit_data[0]['remark'] ?></textarea>
					</div>
				</div>
			</div>
						<div class="row">
				<div class="col-md-6">
				   <div class="form-group">
					<label>Select &nbsp; : &nbsp;&nbsp;</label>
					<input  type="radio" class="form-check-input"  <?php echo ($transit_data[0]['stay']==0)?'checked':''; ?> checked name="stay" id="stay" value="0">
					&nbsp; Not Stay &nbsp;
					<input type="radio" <?php echo set_checkbox('stay',1); ?> <?php echo ($transit_data[0]['stay']==1)?'checked':''; ?> class="form-check-input ts" name="stay" id="stay" value="1">
					&nbsp; Stay &nbsp;
					<span class="control-label" for="inputError" style="color: red"><?php echo form_error('navigate_id'); ?></span>
				  </div>
				</div>
			
			
				<div class="row bill_attach" style="display:none">
					<div class="col-md-6">
					   <div class="form-group">
						<label>Bill Attachemnt  *</label>
						<input type="file" name="filebill" value="<?= $transit_data[0]['bill_attachment'] ?>" id="filebill">
						<input type="hidden" name="billattch"  value="<?= $transit_data[0]['bill_attachment'] ?>"  id="billattch">
						<span class="control-label" for="" style="">File type allowed Png,jpeg,jpg only.</span>
						<?php if(!empty($transit_data[0]['bill_attachment'])){?>
						<img src="<?php echo site_url('assets/proof/'.$transit_data[0]['bill_attachment'])?>" class="img-responsive">
						<?php }?>
						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('filebill'); ?></span>
					  </div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
				   <div class="form-group">
					<label>Ticket Attachment  *</label>
					<input type="file" name="file"  value="<?= $transit_data[0]['ticket_attachment'] ?>"  id="file">
					<input type="hidden" name="ticattch"  value="<?= $transit_data[0]['ticket_attachment'] ?>"  id="ticattch">
					<span class="control-label" for="" style="">File type allowed Png,jpeg,jpg only.</span>
					<?php if(!empty($transit_data[0]['ticket_attachment'])){?>
						<img src="<?php echo site_url('assets/proof/'.$transit_data[0]['ticket_attachment'])?>" class="img-responsive">
					<?php }?>
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
