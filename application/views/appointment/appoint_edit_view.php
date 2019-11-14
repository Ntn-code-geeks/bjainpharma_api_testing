<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$edit_appoint = json_decode($edit_appointment_list);
//pr($edit_appoint); die;
?>


<div class="content-wrapper">
    
    <!-- Main content -->
    <section class="content">
     <?php echo get_flash(); ?>

      <!-- Contact Add -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Edit</h3>

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
                <label>Person Name</label>
                <p class="form-control"><?=$edit_appoint->c_name;?></p>

               </div>
                
                <div class="form-group">
                <label>DOA:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                 <input class="form-control pull-right" name="doa" id="datepicker" type="text" value="<?=date('m/d/Y',strtotime($edit_appoint->doa));?>">
                 <span class="control-label" for="inputError" style="color: red"><?php echo form_error('doa'); ?></span>

                
                </div>
                <!-- /.input group -->
              </div>
              
                
            </div>
        
           <div class="col-md-6">
               
               
               
               <div class="bootstrap-timepicker">
                <div class="form-group">
                  <label>Start Time:</label>

                  <div class="input-group">
                    <input type="text" name="ap_time" class="form-control timepicker" value="<?=date("g:i:s A",strtotime($edit_appoint->toa));?>">

                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->
              </div>
               <div class="bootstrap-timepicker">
                <div class="form-group">
                  <label>End Time:</label>

                  <div class="input-group">
                    <input type="text" name="ap_time_end" class="form-control timepicker" value="<?=date("g:i:s A",strtotime($edit_appoint->toa_end));?>">

                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->
              </div>
               
               
               
           </div>
                              
                <!--appointment status-->
                <div class="col-md-6">
                <div class="form-group">
                     <label>Appointment Status</label>
                  <div class="radio">
                    <label>
                      <input name="as" class="minimal" id="completed" value="1" checked="" type="radio">
                      Completed
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input name="as" class="minimal" id="not_completed" value="0" type="radio">
                      Not Completed
                    </label>
                  </div>
                  
                </div>             
                    
                    
                </div>
                
                <div class="col-md-6">
                    <div class="bootstrap-timepicker">
                <div class="form-group">
                  <label>Reason to meet</label>
                  <textarea class="form-control" rows="3" name="reason" placeholder="Reason to meet ..."><?=$edit_appoint->reason_to_meet?></textarea>
                </div>
                    </div>
                    
                </div>
             
            <div class="col-md-12">
                <!--<div class="form-group">-->
                    <div class="box-footer">
                <!--<button type="submit" class="btn btn-default">Cancel</button>-->
                <button type="submit" class="btn btn-info pull-right">Update</button>
              <!--</div>-->
              <!--</div>-->
                    
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

