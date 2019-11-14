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

          <h3 class="box-title">Add Holiday</h3>



        </div>

        <!-- /.box-header -->

        <div class="box-body">

       <?php echo form_open_multipart($action);?>
        <div class="row">

        <div class="col-md-6">

           <div class="form-group">

          <label>Employee * </label>

          

          <select multiple name="user[]" id="user" class="form-control select5" style="width: 100%;">

            <option value=""  >--Select Employee-- </option>

            <?php foreach($user_list as $user){   ?>   

              <option value="<?php echo $user['id'];?>" <?php if(isset($_POST['user'])){echo set_select('user', $user['id']);} ?> ><?php echo $user['name'];?></option>

            <?php   } ?>

          </select>

          <span class="control-label" for="inputError" style="color: red"><?php echo form_error('user[]'); ?></span>

          </div>

        </div>

      </div>
			<div class="row">

				<div class="col-md-6">

					<div class="form-group">

						<label>Select Date* </label>

						<div class="input-group date">

						  <div class="input-group-addon">

							<i class="fa fa-calendar"></i>

						  </div>
							<input name="start_date" class="form-control pull-right" id="reservation2" type="text" value="<?php echo date('d/m/Y').' - '. date('d/m/Y'); ?>">


						</div>

						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('start_date'); ?></span>

					</div>

				</div>


			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Remark</label>
						<textarea class="form-control" rows="3" name="remark" id="remark" placeholder="Remark..."><?php echo set_value('remark') ?></textarea>
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
         <?php echo form_close();  ?>
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


<script type="text/javascript">
$(function(){
  $('.select6').select2();
  var $eventSelect3= $('.select5').select2();
})
</script>