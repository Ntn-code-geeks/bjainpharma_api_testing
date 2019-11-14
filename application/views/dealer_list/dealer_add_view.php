<?php



/* 

 * Niraj Kumar

 * dated: 04/10/2017

 * 

 */

 

// $city_data=json_decode($cityname);

 $state_data=json_decode($statename);

 

   $dealer_data = json_decode($dealer_list);



 

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>







<div class="content-wrapper">



    <section class="content" style="min-height: auto;padding-bottom:0px">

<?= get_flash();?>

      <!-- SELECT2 EXAMPLE -->

      <div class="box box-default">

        <div class="box-header with-border">

          <h3 class="box-title">Add</h3>



          <div class="box-tools pull-right">

            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

            <!--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>-->

          </div>

        </div>

        <!-- /.box-header -->

        <div class="box-body">

            

            <?php 

            echo form_open_multipart($action);

//            xss_clean();?>

            <div class="row">

                

            <div class="col-md-6">

                <div class="form-group" id="dealer_state">

             

                <label>Dealer State * </label>

                 

              <select name="dealer_state" id="dealer_state"  class="form-control select3" style="width: 100%;">

                  <option value="">--State--</option>

                <?php 

                foreach($state_data as $k_st => $val_st){

                ?>   

                  <option value="<?=$val_st->state_id?>" <?php if(isset($_POST['dealer_state'])){echo set_select('dealer_state',  $val_st->state_id);} ?>  ><?=$val_st->state_name;?></option>

                <?php } ?>

                  

                </select>

            <span class="control-label" for="inputError" style="color: red"><?php echo form_error('dealer_state'); ?></span>



              </div>

                

              <div class="form-group" >

             

                <label>Dealer Name *:</label>

               <input class="form-control"  name="dealer_name" type="text" value="<?php if(isset($_POST['dealer_name'])){echo htmlspecialchars($_POST['dealer_name']);} ?>">

               <span class="help-block" for="inputError" style="color: red"><?php echo form_error('dealer_name'); ?></span>



              </div>

               

                    

                </div>

                

                

            <div class="col-md-6">

                <!--School city List-->

                <div class="form-group">

             

                <label>Dealer City * </label>

                 

                <select name="dealer_city" id="dealer_city"  class="form-control select4" style="width: 100%;">

                  

                   <?php if(isset($_POST['dealer_city'])) {?> <option value="<?=$_POST['dealer_city']?>" <?php  if(isset($_POST['dealer_city'])){echo set_select('dealer_city');} ?>  ><?=$_POST['dealer_city']?></option>

                   <?php } ?>

                    <!--<option value="">--School City--</option>-->

                <?php 

//                foreach($city_data as $k_c => $val_c){

                ?>   

                  <!--<option value="<?=$val_c->city_id?>" <?php // if(isset($_POST['dealer_city'])){echo set_select('dealer_city',  $val_c->city_id);} ?>  ><?= $val_c->city_name;?></option>-->

                <?php // } ?>

                  

                </select>

            <span class="control-label" for="inputError" style="color: red"><?php echo form_error('dealer_city'); ?></span>



              </div>

                <!--/ dealer city list-->

                

                  <div class="form-group">

                <label>Email address *</label>

                <input class="form-control" name="dealer_email" placeholder="Enter email ..." type="email" value="<?php  if(isset($_POST['dealer_email'])){ echo htmlspecialchars($_POST['dealer_email']); } ?>">               

                  <span class="control-label" for="inputError" style="color: red"><?php echo form_error('dealer_email'); ?></span>

                </div>

              

            </div>

                <div class="col-md-6">
               <div class="form-group">
                  <label>City Pincode *</label>
                    <input class="form-control" name="city_pin" placeholder="Enter Pincode ..." type="text" value="">               
                    <span class="control-label" for="inputError" style="color: red"><?php echo form_error('city_pin'); ?></span>
                </div>
              </div>              

            <!-- /.col -->

            <div class="col-md-6">

              <div class="form-group">

                 <label>Contact Number *</label>

                  <input class="form-control" name="dealer_num" placeholder="Enter Phone number..." type="text" value="<?php if(isset($_POST['dealer_num'])){echo htmlspecialchars($_POST['dealer_num']);} ?>">

             

                <span class="help-block" for="inputError" style="color: red"><?php echo form_error('dealer_num'); ?></span>



              </div>

                

               <div class="form-group">

                  <label>Dealer Address</label>

                  <textarea class="form-control" rows="3" name="d_address" placeholder="Dealer Address ..."></textarea>

                </div>

                

              <!-- /.form-group -->

             

              <!-- /.form-group -->

            </div>

            <!-- /.col -->

        

            <!--Strength and Fee-->

            <div class="col-md-6">

            <div class="form-group">

                 <label>Alternate Contact Number</label>

                  <input class="form-control" name="dealer_alt_num" placeholder="Enter Alternate Phone number..." type="text" value="<?php if(isset($_POST['dealer_alt_num'])){echo htmlspecialchars($_POST['dealer_alt_num']);} ?>">

             

                <!--<span class="help-block" for="inputError" style="color: red"><?php //echo form_error('dealer_num'); ?></span>-->



              </div> 

                

               <!--<div class="col-md-6">-->
              <?php if(is_admin()){ ?>
                <div class="form-group">
                  <label>Dealer Navigon ID</label>
                  <input class="form-control" name="doc_navigon" placeholder="Enter Navigon id ..." type="text" value="">               
                </div>
                <div class="form-group">
                  <label>Dealer SP Code*</label>
                  <input class="form-control" name="sp_code" placeholder="Enter SP Code..." type="text" value="">    
                   <span class="help-block" for="inputError" style="color: red"><?php echo form_error('sp_code'); ?></span>           
                  </div>
              <?php }else{ ?>
                <input class="form-control" name="doc_navigon" type="hidden" value="">    
              <?php } ?>
           <!--</div>-->

                

            </div>



            

            <div class="col-md-6">

                 <div class="form-group">

                  <label>About the Dealer</label>

                  <textarea class="form-control" rows="3" name="about_d" placeholder="About the Dealer ..."></textarea>

                </div>

                

            </div>

            

            <div class="col-md-12">

                 <!--<div class="form-group">-->

                    <div class="box-footer">

                <!--<button type="submit" class="btn btn-default">Cancel</button>-->

                <button type="submit" class="btn btn-info pull-right">Submit</button>

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

    <!-- /.dealer content -->

    



    

  </div>



<script type="text/javascript">

$(function(){

//    $('.select4').select2();

    var $eventSelect= $('.select2').select2();



   $eventSelect.on("change", function (e) {   

       

        var dealerid = $(this).val();  

 

   if(dealerid=='none'){

 

   $("#dealer_name").css("display", "block");

//   $("#dealer_city").css("display", "block");

   $('#box_dealer').css('display','block');

       

    }

    else{

        $("#dealer_name").css("display", "none");

//   $("#dealer_city").css("display", "none");

   $('#box_dealer').css('display','none');

    }

    

    });

   

   var $eventSelect3= $('.select3').select2();

   var $eventSelect4 =$('.select4').select2();

     $eventSelect3.on("change",function(e){

         var stateid = $(this).val();  

         

         if(stateid){

        $.ajax({

           type:"POST",

           url:"<?= base_url();?>dealer/dealer/dealer_city/",

           data : 'id='+stateid,

           success:function(res){ 



            if(res){



            $("#dealer_city").html(res);



            }

//            else{

//               $("#dealer_state").empty();

//            }

           }

             

        });

    }



        

    });

   

  

    

    

})







</script>