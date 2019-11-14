<?php
/*
* Niraj Kumar
* Dated: 30-oct-2017
*
* Show Report Details
*
*/

  $user_list = json_decode($users);
 

 // $pharmacy_list =json_decode($pharma_list);
//pr($dealer_list); die;

?>
<!--<link href="<?= base_url()?>design/css/div_table/one.css" rel="stylesheet" type="text/css"/>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<div class="content-wrapper">
  
  <!-- Main content -->
  <section class="content">
    <?php echo get_flash(); ?>
    
    
          <div class="box box-success">
            <!--<div class="box box-primary">-->
            
            <div class="box-header">
              <h3 class="box-title"> Expense Chart </h3>
            </div>
            <?php
            echo form_open($action);
            ?>
            <div class="box-body">
              <div class="row">
               <div class="col-md-6">
              <!-- Date range -->
              <div class="form-group">
                <label>Report Date range:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input name="report_date" class="form-control pull-right" id="reservation" type="text" value="<?php echo date('d/m/Y').' - '. date('d/m/Y'); ?>">
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->
              <!-- Date and time range -->
              <?php if(!is_admin()){ if(!logged_user_child()){ ?>
                <input name="user_id" id="user_id"  value="<?=logged_user_data() ?>" type="hidden">
                <?php }else{ ?>
                  <div class="form-group">
                    <label>Users *:</label>
                    <select name="user_id" id="user_id"  class="form-control select3" style="width: 100%;">
                      <option value="">--Please Choose User--</option>
                     <!--  <option value="0">ALL User</option> -->
                      <option value="<?=logged_user_data() ?>" ><?php echo get_user_name(logged_user_data());?></option>
                      <?php $user_list=explode(',',logged_user_child());
                      foreach($user_list as $k => $val){ ?>
                      <option value="<?=$val ?>" ><?php echo get_user_name($val);?></option>
                      <?php } ?>
                      
                    </select>
                    <span class="control-label" for="inputError" style="color: red"><?php echo form_error('user_id'); ?></span>
                    <!-- /.input group -->
                  </div>
                <?php } ?>
              <?php }else{ ?>
               <div class="form-group">
                <label>Users *:</label>
                <!--<div class="input-group">-->
                <select name="user_id" id="user_id"  class="form-control select3" style="width: 100%;">
                  <option value="">--Please Choose User--</option>
                 <!--  <option value="0">ALL User</option> -->
                  <?php
                  if($user_id==''){
                  foreach($user_list as $k => $val){
                  ?>
                  <option value="<?=$val->userid ?>" <?php if(isset($_POST['user_id'])){echo set_select('user_id',  $val->userid);} ?>  ><?=$val->username;?></option>
                  <?php } }?>
                 
                </select>
                <span class="control-label" for="inputError" style="color: red"><?php echo form_error('user_id'); ?></span>
                <!-- /.input group -->
              </div>
               <?php } ?>
              <!-- Date and time range -->
              <div class="form-group">
                <!--                <label></label>-->
                <div class="input-group">
                  <button type="submit" name="send" value="1" class="btn btn-default">
                  View
                  </button>
                  <button type="submit" name="send" value="2" class="btn btn-default">
                  Full View
                  </button>
                </div>
              </div>
              <!-- /.form group -->
            </div>
            <!-- /.box-body -->
            <?php echo form_close(); ?>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col (left) -->
      </div>
      
    <!--            </div>
    /.box
  </div>
  /.col
</div>-->
<!-- /.row -->
</section>
<!-- /.content -->
</div>
<script type="text/javascript">
$(function(){

  $('.select3').select2();

  $('.select4').select2({selectOnClose: true}).on("select2:select", function(e) {
    var dealerId= $(this).val();
    if(dealerId)
    {
      $('.select5').prop('disabled', true);
    }
    else
    {
      $('.select5').prop('disabled', false);
    }
  });
  $('.select5').select2({selectOnClose: true}).on("select2:select", function(e) {
      var pharmaId= $(this).val();
      if(pharmaId)
      {
        $('.select4').prop('disabled', true);
      }
      else
      {
        $('.select4').prop('disabled', false);
      }
    
  });
});
</script>

