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
          <h3 class="box-title">Add Product </h3>

        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php echo form_open_multipart($action);?>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Select Parent Category* : </label>
						<select name="category_id" id="category_id"  class="form-control select2" style="width: 100%;">
						  <option value="">--Select Category --</option>
							<?php foreach($category_list as $category){ ?>   
								<option value="<?=$category['category_id']?>" ><?=$category['category_name']?></option>
							<?php }  ?>
						</select>
						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('category_id'); ?></span>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Product Name* :</label>
						  <input class="form-control pull-right" name="pro_name" value="<?php echo set_value('pro_name') ?>" id="pro_name" type="text">
						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('pro_name'); ?></span>
					</div>
				</div>

			</div>
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Select Potency* : </label>
						<select name="potency_id" id="potency_id"  class="form-control select2" style="width: 100%;">
						  <option value="">--Select Potency --</option>
							<?php foreach($potency_list as $potency){ ?>   
								<option <?php echo set_select('potency_id', $potency['potency_id']); ?> value="<?=$potency['potency_id']?>" ><?=$potency['potency_value']?></option>
							<?php }  ?>
						</select>
						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('potency_id'); ?></span>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Select Packsize* : </label>
						<select name="packsize_id" id="packsize_id"  class="form-control select2" style="width: 100%;">
						  <option value="">--Select Potency --</option>
							<?php foreach($packsize_list as $packsize){ ?>   
								<option  <?php echo set_select('packsize_id', $packsize['packsize_id']); ?>  value="<?=$packsize['packsize_id']?>" ><?=$packsize['packsize_value']?></option>
							<?php }  ?>
						</select>
						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('packsize_id'); ?></span>
					</div>
				</div>

			</div>

			<div class="row">
				<div class="col-md-6">
				   <div class="form-group">
					<label>Select Status&nbsp; : &nbsp;&nbsp;</label>
					<input  type="radio" class="form-check-input" checked name="status" id="status" value="1">
					&nbsp; Enable &nbsp;
					<input type="radio" <?php echo set_checkbox('status',0); ?> class="form-check-input ts" name="status" id="status" value="0">
					&nbsp; Disable &nbsp;
					
				  </div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Price* :</label>
						<input class="form-control" value="<?php echo set_value('price') ?>" name="price" id="price" placeholder="Price in INR" type="number">
						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('price'); ?></span>
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


