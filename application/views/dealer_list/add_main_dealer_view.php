<?php



/* 

 *@author:Niraj Kumar

 * dated: 27/10/2017

 * 

 */

 



 $state_data=json_decode($statename);

 

   $dealer_data = json_decode($dealer_list);

// if(isset($_POST['group_dealer_city'])) {

//     

//     

// }

   

 

?>





<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>



<div class="content-wrapper">



<section class="content" style="min-height: auto;">



      <!-- SELECT2 EXAMPLE -->

      <div class="box box-default">

        <div class="box-header with-border">

          <h3 class="box-title">Add C & F</h3>

          <?= get_flash();?>

        </div>

        <!-- /.box-header -->

        <div class="box-body">

            

            <?php 

            echo form_open_multipart($action_group);

               ?>

            <div class="row">

                

            <div class="col-md-6">

                <div class="form-group" id="group_dealer_state">

             

                <label>C & F State</label>

                 

                <select name="group_dealer_state" id="group_dealer_state"  class="form-control select5" style="width: 100%;">

                  <option value="">--State--</option>

                <?php 

                foreach($state_data as $k_st => $val_st){

                ?>   

                  <option value="<?=$val_st->state_id?>" <?php if(isset($_POST['group_dealer_state'])){echo set_select('group_dealer_state',  $val_st->state_id);} ?>  ><?=$val_st->state_name;?></option>

                <?php } ?>

                  

                </select>

             <span class="control-label" for="inputError" style="color: red"><?php echo form_error('group_dealer_state'); ?></span>



              </div>

                    

                    

                 <div class="form-group" id="group_dealer_name">

             

                <label>C & F Name :</label>

               <input class="form-control"  name="group_dealer_name" type="text" value="<?php if(isset($_POST['group_dealer_name'])){echo htmlspecialchars($_POST['group_dealer_name']);} ?>">

               <span class="help-block" for="inputError" style="color: red"><?php echo form_error('group_dealer_name'); ?></span>



              </div> 

                    

           

                    

                </div>

                

                

            <div class="col-md-6">

                <!--School city List-->

                <div class="form-group">

             

                <label>C & F City</label>

                 

                <select name="group_dealer_city" id="group_dealer_city"  class="form-control select7" style="width: 100%;">

                 

                   <?php if(isset($_POST['group_dealer_city'])) {

                       

                        foreach($cityname as $k_c => $val_c){

                         if($val_c['city_id']== $_POST['group_dealer_city']){

                       ?> 

                    

                    <option value="<?=$val_c['city_id']?>" <?php  if(isset($_POST['group_dealer_city'])){echo set_select('group_dealer_city');} ?>  ><?=$val_c['city_name']?></option>

                  

                   <?php }  } } ?>

                    

                    <!--<option value="">--School City--</option>-->

                <?php 

//                foreach($city_data as $k_c => $val_c){

                ?>   

                  <!--<option value="<?=$val_c->city_id?>" <?php // if(isset($_POST['dealer_city'])){echo set_select('dealer_city',  $val_c->city_id);} ?>  ><?= $val_c->city_name;?></option>-->

                <?php // } ?>

                  

                </select>

              <span class="control-label" for="inputError" style="color: red"><?php echo form_error('group_dealer_city'); ?></span>



              </div>

                <!--/ dealer city list-->

                

                  <div class="form-group">

                <label>C & F Email </label>

                <input class="form-control" name="group_dealer_email" placeholder="Enter email ..." type="email" value="<?php  if(isset($_POST['group_dealer_email'])){ echo htmlspecialchars($_POST['group_dealer_email']); } ?>">               

                  <span class="control-label" for="inputError" style="color: red"><?php echo form_error('group_dealer_email'); ?></span>

                </div>

                

             

              

                

            </div>

                

                

            <div class="col-md-6">

               <div class="form-group">

                <label>Dealer List</label>

                <select name="group_dealer_id[]"  multiple="multiple" id='group_dealer_id' class="form-control select6" style="width: 100%;">

                  <!--<option id="none" value="none">NONE</option>-->

                <?php 

                foreach($dealer_data as $k_s => $val_s){

                ?>   

                  <option value="<?=$val_s->dealer_id?>" <?php if(isset($_POST['group_dealer_id'])){echo set_select('group_dealer_id',  $val_s->dealer_id);} ?> ><?=$val_s->dealer_name.','.$val_s->city_name;?></option>

                <?php } ?>

                 

                </select>

                <span class="control-label" for="inputError" style="color: red"><?php echo form_error('group_dealer_id'); ?></span>

               </div>   

             

                    

               <div class="form-group">

                  <label>C & F Address</label>

                  <textarea class="form-control" rows="3" name="d_address" placeholder="C & F Address ..."></textarea>

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

                 <label>C & F Contact Number</label>

                  <input class="form-control" name="group_dealer_num" placeholder="Enter Phone number..." type="text" value="<?php if(isset($_POST['group_dealer_num'])){echo htmlspecialchars($_POST['group_dealer_num']);} ?>">

             

                <span class="help-block" for="inputError" style="color: red"><?php echo form_error('group_dealer_num'); ?></span>



              </div>

               <div class="form-group">

                  <label>About the C & F</label>

                  <textarea class="form-control" rows="3" name="group_about_d" placeholder="About the C & F ..."></textarea>

                </div>

                

                

              <!-- /.form-group -->

            </div>

            

            <div class="col-md-6">

               <div class="form-group">

                  <label>Doctor Navigon ID</label>

 <input class="form-control" name="doc_navigon" placeholder="Enter Navigon id ..." type="text" value="">               

             

                </div>

           </div>

            <!-- /.col -->

          

            

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

    

</div>



<script type="text/javascript">

$(function(){

    

    $('.select6').select2();



   

   var $eventSelect3= $('.select5').select2();

   var $eventSelect4 =$('.select7').select2();

     $eventSelect3.on("change",function(e){

         var stateid = $(this).val();  

         

         if(stateid){

        $.ajax({

           type:"POST",

           url:"<?= base_url();?>dealer/dealer/dealer_city/",

           data : 'id='+stateid,

           success:function(res){ 



            if(res){



            $("#group_dealer_city").html(res);



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