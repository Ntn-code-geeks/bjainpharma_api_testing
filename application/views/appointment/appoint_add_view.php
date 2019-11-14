<?php



/* 

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */



$doctor_list = json_decode($doctor_list);

$dealer_data  = json_decode($dealer_list);



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

            

            <?php 

            echo form_open_multipart($action);

//            xss_clean();?>

            <div class="row">

            <div class="col-md-6">



               <div class="form-group">

                <label>Doctor/Sub Dealer/Dealer Name</label>

                <select name="person_id"   class="form-control select2" style="width: 100%;">

                  <option value="">--Person Name List--</option>

                <?php 

                foreach($doctor_list as $k_con => $val_con){

                   

                ?>   

                   <option value="<?=$val_con->doc_id?>" <?php if(isset($_POST['person_id'])){echo set_select('person_id',  $val_con->doc_id);} ?> ><?=$val_con->doc_name.'(Doctor)';?></option>

                     

                    <?php  } ?>

               <?php 

                foreach($dealer_data as $k_d =>$val_d){

                   

                ?>   

                   <option value="<?=$val_d->dealer_id?>" <?php if(isset($_POST['person_id'])){echo set_select('person_id',  $val_d->dealer_id);} ?> ><?=$val_d->dealer_name.'(Dealer)';?></option>

                     

                    <?php  } ?>

                   

                      <?php 

                foreach($pharma_list as $k_s => $val_s){

                    

                ?>   

                  <option value="<?=$val_s['id']?>" <?php if(isset($_POST['person_id'])){echo set_select('person_id',  $val_s['id']);} ?>><?=$val_s['com_name'].', (Sub Dealer)';?></option>

                  <?php }  ?>



                </select>

                <span class="control-label" for="inputError" style="color: red"><?php echo form_error('contact_id'); ?></span>

              </div>

              <div class="bootstrap-timepicker">

                <div class="form-group">

                  <label>Reason to meet</label>

                  <textarea class="form-control" rows="3" name="reason" placeholder="Reason to meet ..."></textarea>

                </div>

              </div>

                

            </div>

        

           <div class="col-md-6">

               

               <div class="form-group">

                <label>DOA:</label>



                <div class="input-group date">

                  <div class="input-group-addon">

                    <i class="fa fa-calendar"></i>

                  </div>

                  <input class="form-control pull-right" name="doa" id="datepicker" type="text">

                 <span class="control-label" for="inputError" style="color: red"><?php echo form_error('doa'); ?></span>



                

                </div>

                <!-- /.input group -->

              </div>

               

               <div class="bootstrap-timepicker">

                <div class="form-group">

                  <label>Start Time:</label>



                  <div class="input-group">

                    <input type="text" name="ap_time" class="form-control timepicker">



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

                    <input type="text" name="ap_time_end" class="form-control timepicker">



                    <div class="input-group-addon">

                      <i class="fa fa-clock-o"></i>

                    </div>

                  </div>

                  <!-- /.input group -->

                </div>

                <!-- /.form group -->

              </div>

               

                    

                </div>

                

                

               

           

            

            

            <div class="col-md-12">

                <!--<div class="form-group">-->

                    <div class="box-footer">

                <!--<button type="submit" class="btn btn-default">Cancel</button>-->

                <button type="submit" class="btn btn-info pull-right">ADD</button>

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



<script type='text/javascript'>

    $(function(){



    $('.select2').select2();

     

    });

    

</script>

