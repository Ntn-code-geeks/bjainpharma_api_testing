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
			<a class="sample-file-link btn btn-info pull-right" href="<?php echo site_url('assets/sample file/Dealer Import.csv')?>" download>Download Sample File</a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          
            <?php 
            echo form_open_multipart($action);
//            xss_clean();?>
 
			<div class="row">
				<div class="col-md-6">
				   <div class="form-group">
					<label>Employee * </label>
					
					<select name="user" id="user" class="form-control select5" style="width: 100%;">
						<option value=""  >--Select Employee-- </option>
						<?php 
					
						foreach($user_list as $user){
						
							 if($user['id']!=23 && $user['id']!=96){
						?>   
						  <option value="<?php echo $user['id'];?>" <?php if(isset($_POST['user'])){echo set_select('user', $user['id']);} ?> ><?php echo $user['name'];?></option>
						<?php }  } ?>
					</select>
					<span class="control-label" for="inputError" style="color: red"><?php echo form_error('user'); ?></span>
				  </div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
				   <div class="form-group">
					<label>Import Dealer *</label>
					<input type="file" id="file" name="file" required class="form-control-file"  aria-describedby="fileHelp">
					<span class="control-label" for="" style="">File type allowed CSV only.</span>
					<span class="control-label" for="inputError" style="color: red"><?php echo form_error('file'); ?></span>
				  </div>
				</div>
				<div class="col-md-12">
					<div class="box-footer">
						<button type="submit" class="btn btn-info pull-right">Import</button>
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
<script type="text/javascript">
$(function(){
  
    $('.select6').select2();
   var $eventSelect3= $('.select5').select2();
 
})

</script>