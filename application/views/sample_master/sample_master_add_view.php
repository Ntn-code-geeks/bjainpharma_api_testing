<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($sample_edit)){
    
    $sample_info = json_decode($sample_edit);
//  pr($sample_info); die;  
}
?>
<div class="content-wrapper">
     <!-- Main content -->
    <section class="content">

      <!-- Contact Add -->
      <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"><?php if(isset($sample_info)){echo "Edit";} else{echo "Add";}?></h3>
            <?= get_flash();?>
<!--          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>-->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            
            <?php 
            echo form_open_multipart($action);
//            xss_clean();?>
            <div class="row">
            <div class="col-md-6">
                
                <div class="form-group">   
                <label>Product Name</label>
                <?php
                
                         if(!empty($sample_info)){
                                 foreach($sample_info as $k_sm=>$val_sm){
                ?>
                <input class="form-control" name="product_name" placeholder="Enter Product Name ..." type="text" value="<?php echo $val_sm->sample_name; ?>">               
                         <?php }}
                         else{
                         ?> 
                 <input class="form-control" name="product_name" placeholder="Enter Product Name ..." type="text" value="">  
                         <?php } ?>
                <span class="control-label" for="inputError" style="color: red"><?php echo form_error('product_name'); ?></span>
                </div>  
                
            </div>
                
                
            <div class="col-md-12">
               
                    <div class="box-footer">
              
                <button type="submit" class="btn btn-info pull-right">Submit</button>
          
                    
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
