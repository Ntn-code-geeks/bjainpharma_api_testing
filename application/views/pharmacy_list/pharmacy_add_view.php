<?php





/* 


 * To change this license header, choose License Headers in Project Properties.


 * To change this template file, choose Tools | Templates


 * and open the template in the editor.


 */


 $dealer_data = json_decode($dealer_list);


  $state_data=json_decode($statename);


// $desig_data=json_decode($desig_list);





?>





<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>











<div class="content-wrapper">


     <!-- Main content -->


    <section class="content">





      <!-- Contact Add -->


      <div class="box box-default">


        <div class="box-header with-border">


          <h3 class="box-title">Add</h3>


            <?= get_flash();?>





        </div>


        <!-- /.box-header -->


        <div class="box-body">


            


            <?php 


            echo form_open_multipart($action);


//            xss_clean();?>


            <div class="row">


            <div class="col-md-6">


                


                <div class="form-group">


                    


                <label>Company Name</label>


                <input class="form-control" name="com_name" placeholder="Enter Company Name ..." type="text" value="<?php  if(isset($_POST['com_name'])){ echo htmlspecialchars($_POST['com_name']); } ?>">               


                <span class="control-label" for="inputError" style="color: red"><?php echo form_error('com_name'); ?></span>


                </div>


                


                


              <div class="form-group" id="school_state">


             


                <label>Company State * </label>


                 


              <select name="com_state" id="com_state"  class="form-control select3" style="width: 100%;">


                  <option value="">--State--</option>


                <?php 


                foreach($state_data as $k_st => $val_st){


                ?>   


                  <option value="<?=$val_st->state_id?>" <?php if(isset($_POST['com_state'])){echo set_select('com_state',  $val_st->state_id);} ?>  ><?=$val_st->state_name;?></option>


                <?php } ?>


                  


                </select>


            <span class="control-label" for="inputError" style="color: red"><?php echo form_error('com_state'); ?></span>





              </div>


             


             


              


                


            </div>


                


                <div class="col-md-6">


                   


                <div class="form-group">


                <label>Dealer Name</label>


                <select name="dealer_id[]" multiple="multiple"  class="form-control select2" style="width: 100%;">


                  <!--<option value="">--Dealer List--</option>-->


                <?php 


                foreach($dealer_data as $k_s => $val_s){


                if($val_s->status==1){ 


                    ?>   


                  <option value="<?=$val_s->dealer_id?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_s->dealer_id);} ?> ><?=$val_s->dealer_name.','.$val_s->city_name;?></option>


                <?php } } ?>


              <!--<option value="none" id="none" >NONE</option>-->





                </select>


                <span class="control-label" for="inputError" style="color: red"><?php echo form_error('dealer_id'); ?></span>


              </div> 


                


               


                    


                    


                <div class="form-group">


             


                <label>Company City * </label>


                 


                <select name="com_city" id="com_city"  class="form-control select4" style="width: 100%;">


                  <!--<option value="">--School City--</option>-->


                <?php 


//                foreach($city_data as $k_c => $val_c){


                ?>   


                  <!--<option value="<?=$val_c->city_id?>" <?php // if(isset($_POST['school_city'])){echo set_select('school_city',  $val_c->city_id);} ?>  ><?= $val_c->city_name;?></option>-->


                <?php // } ?>


                  


                </select>


            <span class="control-label" for="inputError" style="color: red"><?php echo form_error('com_city'); ?></span>





              </div> 


                    


                    


                    


                    


                </div>


                


            <!-- /.col -->


            <div class="col-md-6">


                


                 <div class="form-group">


                <label>Company Email</label>


                <input class="form-control" name="com_email" placeholder="Enter email ..." type="email" value="<?php  if(isset($_POST['com_email'])){ echo htmlspecialchars($_POST['com_email']); } ?>">               


                  <span class="control-label" for="inputError" style="color: red"><?php echo form_error('com_email'); ?></span>


                </div>


                <div class="form-group">


                    


                <label>Owner Name</label>


                <input class="form-control" name="owner_name" placeholder="Enter Owner Name ..." type="text" value="<?php  if(isset($_POST['owner_name'])){ echo htmlspecialchars($_POST['owner_name']); } ?>">               


                <span class="control-label" for="inputError" style="color: red"><?php echo form_error('owner_name'); ?></span>


                </div>


                


              


              <!-- /.form-group -->


            </div>


            <!-- /.col -->


           <!--owner information-->


            <div class="col-md-6">


                


                <div class="form-group">


                 <label>Company Contact Number</label>


                  <input class="form-control" name="com_number" placeholder="Enter Phone number..." type="text" value="<?php if(isset($_POST['com_number'])){echo htmlspecialchars($_POST['com_number']);} ?>">


             


                <span class="help-block" for="inputError" style="color: red"><?php echo form_error('com_number'); ?></span>





              </div>


                


                <div class="form-group">


                <label>Owner DOB:</label>





                <div class="input-group date">


                  <div class="input-group-addon">


                    <i class="fa fa-calendar"></i>


                  </div>


                  <input class="form-control pull-right" name="dob" id="datepicker" type="text">


                </div>


                <!-- /.input group -->


              </div>


                


                


                


            </div>


           


           


            <div class="col-md-6">


                


                <div class="form-group">


                    


                <label>Owner Email</label>


                 <input class="form-control" name="owner_email" placeholder="Enter Owner email ..." type="email" value="<?php  if(isset($_POST['owner_email'])){ echo htmlspecialchars($_POST['owner_email']); } ?>">               


                 <span class="control-label" for="inputError" style="color: red"><?php echo form_error('owner_email'); ?></span>


                


                </div>


                


                <div class="form-group">


                 <label>Owner Contact Number</label>


                  <input class="form-control" name="owner_number" placeholder="Enter Owner Phone number..." type="text" value="<?php if(isset($_POST['owner_number'])){echo htmlspecialchars($_POST['owner_number']);} ?>">


             


                <span class="help-block" for="inputError" style="color: red"><?php echo form_error('owner_number'); ?></span>





              </div>


                
<?php if(is_admin() ){ ?>

                 <div class="form-group">


                  <label>Sub Dealer Navigon ID</label>


           <input class="form-control" name="doc_navigon" placeholder="Enter Navigon id ..." type="text" value="">               


             


                </div>
                
             <div class="form-group">
                  <label>SP code*</label>
                  <input class="form-control" required name="sp_code" placeholder="Enter User sp code ..." type="text" value="">             
                </div>

 <?php }else{ ?>
              <input class="form-control"  name="doc_navigon" type="hidden" value=""> 
               <input class="form-control"  name="sp_code" type="hidden" value="<?php echo user_sp_code();?>"> 
               

          <?php } ?>

                


            </div>


           


         


                   


            <!--Address start-->


            <div class="col-md-6">


               


                <div class="form-group">


                  <label>Company Address</label>


                  <textarea class="form-control" rows="7" name="com_address" placeholder="Enter Company Address ..."></textarea>


                </div>


                


                


                


            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>City Pincode *</label>
                    <input class="form-control" name="city_pin" placeholder="Enter Pincode ..." type="text" value="">               
                    <span class="control-label" for="inputError" style="color: red"><?php echo form_error('city_pin'); ?></span>
                </div>
              </div>


            <!--Address end-->


            


           


            


            


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


    <!-- /.content -->


  </div>








<script type="text/javascript">


$(function(){


    


   $('.select2').select2(); 


    


});


$('#m_yes').click(function(){


    


   $("#sp_name").css("display", "block");


   $("#sp_email").css("display", "block");


   


    


});





$('#m_no').click(function(){


    


   $("#sp_name").css("display", "none");


   $("#sp_email").css("display", "none"); 


    


});


//$(function(){


//        $( "#datepicker2" ).datepicker({


//            dateFormat : 'mm/dd/yy',


//            changeMonth : true,


//            changeYear : true,


//            yearRange: '-100y:c+nn',


//            maxDate: '-1d'


//        });


//    });


</script>





<script type="text/javascript">


$(function(){


//    $('.select4').select2();


    var $eventSelect= $('.select2').select2();





   $eventSelect.on("change", function (e) {   


       


        var schoolid = $(this).val();  


 


   if(schoolid=='none'){


 


   $("#school_name").css("display", "block");


//   $("#school_city").css("display", "block");


   $('#box_school').css('display','block');


       


    }


    else{


        $("#school_name").css("display", "none");


//   $("#school_city").css("display", "none");


   $('#box_school').css('display','none');


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





            $("#com_city").html(res);





            }





           }


             


        });


    }


        


    });


   





})











</script>