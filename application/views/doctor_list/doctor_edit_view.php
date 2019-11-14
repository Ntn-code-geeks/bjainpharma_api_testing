<?php





/* 


 * To change this license header, choose License Headers in Project Properties.


 * To change this template file, choose Tools | Templates


 * and open the template in the editor.


 */


$edit_doctor=json_decode($edit_doctor_list);
$dealer_data = json_decode($dealer_list);
$doc_status = json_decode($doc_status_info);
if(isset($edit_doctor->d_id) && !empty($edit_doctor->d_id)){
  $dealers_are = explode(',',$edit_doctor->d_id);
}


 else{


     $dealers_are=array();


 }


   $state_data=json_decode($statename);





 


// pr($edit_doctor); die;


// pr($doctor_data); die;


?>





<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>











<div class="content-wrapper">


<!-- Main content -->


    <section class="content">





      <!-- SELECT2 EXAMPLE -->


      <div class="box box-default">


        <div class="box-header with-border">


          <h3 class="box-title">Edit</h3>


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


            ?>


            <div class="row">


            <div class="col-md-6">


                


                <div class="form-group">


                <label>Name</label>


                <input readonly class="form-control" name="doctor_name" placeholder="Enter Name ..." type="text" value="<?php  echo $edit_doctor->d_name;?>">               


                  <span class="control-label" for="inputError" style="color: red"><?php echo form_error('doctor_name'); ?></span>


                </div>

             <div class="form-group">


                <label>Dealer/Sub Dealer Name</label>


                <select name="dealer_id[]" multiple="multiple"  class="form-control select2" style="width: 100%;">


                  <option value="">--Dealer List--</option>


                <?php 


                foreach($dealer_data as $k_s => $val_s){
                     if(in_array($val_s->dealer_id,$dealers_are)){
                ?>   


                  <option value="<?=$val_s->dealer_id?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_s->dealer_id);} ?> selected="" ><?=$val_s->dealer_name.','.$val_s->city_name;?></option>


                <?php }else{  if($val_s->status==1){ ?>


                <option value="<?=$val_s->dealer_id?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_s->dealer_id);} ?> ><?=$val_s->dealer_name.','.$val_s->city_name;?></option>


                <?php } } } ?>


                


                  <?php 


                foreach($pharma_list as $k_p => $val_p){


                  if(in_array($val_p['id'],$dealers_are)){


                    


                ?>   


                  <option value="<?=$val_p['id']?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_p['id']);} ?> selected="" ><?=$val_p['com_name'].',(Sub Dealer)';?></option>


                <?php } else{  if($val_s->status==1){?>  


                


                  <option value="<?=$val_p['id']?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_p['id']);} ?> ><?=$val_p['com_name'].',(Sub Dealer)';?></option>


                <?php } } } ?>


              <!--<option value="none" id="none" >NONE</option>-->





                </select>


                <span class="control-label" for="inputError" style="color: red"><?php echo form_error('dealer_id'); ?></span>


              </div> 


              


                


            </div>


                <div class="col-md-6">


                    


                        <div class="form-group" id="school_state">





                            <label>Doctor State * </label>





                          <select name="doctor_state" id="dealer_state"  class="form-control select3" style="width: 100%;">


                              <option value="">--State--</option>


                            <?php 


                            foreach($state_data as $k_st => $val_st){


                                if($val_st->state_id==$edit_doctor->state_id){


                                    ?>


                              <option value="<?=$val_st->state_id?>" selected="" <?php if(isset($_POST['doctor_state'])){echo set_select('doctor_state',  $val_st->state_id);} ?>  ><?=$val_st->state_name;?></option>


 


                              <?php


                                    


                                } else{


                            ?>   


                              <option value="<?=$val_st->state_id?>" <?php if(isset($_POST['doctor_state'])){echo set_select('doctor_state',  $val_st->state_id);} ?>  ><?=$val_st->state_name;?></option>


                            <?php }  } ?>





                            </select>


                           <span class="control-label" for="inputError" style="color: red"><?php echo form_error('doctor_state'); ?></span>





                        </div>


                    


                    


                    


                <div class="form-group">


             


                        <label>Doctor City * </label>





                        <select name="doctor_city" id="dealer_city"  class="form-control select4" style="width: 100%;">


                         <option value="<?=$edit_doctor->city_id?>"><?=$edit_doctor->city_name?></option>


                        <?php 


        //                foreach($city_data as $k_c => $val_c){


                        ?>   


                          <!--<option value="<?=$val_c->city_id?>" <?php // if(isset($_POST['school_city'])){echo set_select('school_city',  $val_c->city_id);} ?>  ><?= $val_c->city_name;?></option>-->


                        <?php // } ?>





                        </select>


                    <span class="control-label" for="inputError" style="color: red"><?php echo form_error('doctor_city'); ?></span>





                 </div> 


                    


                    


                    


                </div> 


                


                


            <!-- /.col -->


            <div class="col-md-6">


                


                 <div class="form-group">
                <label>Email Address</label>
                <input class="form-control" name="doctor_email" placeholder="Enter email ..." type="email" value="<?=$edit_doctor->d_email;?>">               
                  <span class="control-label" for="inputError" style="color: red"><?php echo form_error('doctor_email'); ?></span>
                </div>



                


              <div class="form-group">


             


                <label>Doctor Status </label>


                 


              <select name="doc_status" id="doc_status"  class="form-control select5" style="width: 100%;">


                  <option value="">--Doctor Status--</option>


                <?php 


                foreach($doc_status as $k_doc_s => $val_doc_s){


                ?>   


                  <option value="<?=$val_doc_s->status_id?>" <?php if($edit_doctor->doc_status_id==$val_doc_s->status_id){ echo "selected";} ?> <?php if(isset($_POST['doc_status'])){echo set_select('doc_status',  $val_doc_s->status_id);} ?>  ><?=$val_doc_s->doc_status_name;?></option>


                <?php } ?>


                  


                </select>


            <span class="control-label" for="inputError" style="color: red"><?php echo form_error('doc_status'); ?></span>





              </div>


             


            


              <!-- /.form-group -->


            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>City Pincode *</label>
                    <input class="form-control" name="city_pin" placeholder="Enter Pincode ..." type="text" value="<?=$edit_doctor->city_pincode;?>">               
                    <span class="control-label" for="inputError" style="color: red"><?php echo form_error('city_pin'); ?></span>
                </div>
              </div>

            <!-- /.col -->


           <!--Gender and merried status-->


            <div class="col-md-6">


                


                 <div class="form-group">


                 <label>Contact Number</label>


                  <input class="form-control" name="doctor_num" placeholder="Enter Phone number..." type="text" value="<?=$edit_doctor->d_ph;?>">


             


                <span class="help-block" for="inputError" style="color: red"><?php echo form_error('doctor_num'); ?></span>





              </div>


                


                <div class="form-group">


                     <label>Gender</label>


                  


                  <div class="radio">


                      


                    <label>


                      <input name="gender" id="male" value="1"  <?php


                   if($edit_doctor->gender==1){


                   echo "checked=''"; }?> type="radio">


                      Male


                    </label>


                  


                  </div>


                  <div class="radio">


                    <label>


                      <input name="gender" id="female" value="0" <?php


                   if($edit_doctor->gender==0){


                   echo "checked=''"; } ?> type="radio">


                      Female


                    </label>


                  </div>


                  


                </div>


                


              


            </div>


           


           


           <div class="col-md-6">


               


               <div class="form-group">


                <label>DOB:</label>





                <div class="input-group date">


                  <div class="input-group-addon">


                    <i class="fa fa-calendar"></i>


                  </div>


                  <input class="form-control pull-right" name="dob" value="<?=$edit_doctor->dob;?>" id="datepicker" type="text">


                </div>


                <!-- /.input group -->


              </div>


               


                   <!--merried status-->


                 <div class="form-group">


                     <label>Married status</label>


                  <div class="radio">


                    <label>


                      <input name="married" id="m_yes" value="1" <?php


                   if($edit_doctor->married_status==1){


                   echo "checked=''"; }?>  type="radio">


                      Yes


                    </label>


                  </div>


                  <div class="radio">


                    <label>


                      <input name="married" id="m_no" value="0" <?php


                   if($edit_doctor->married_status==0){


                   echo "checked=''"; }?>  type="radio">


                      No


                    </label>


                  </div>


                  


                </div>


               


               


               


           </div>


           


           <!--For married person-->


           <div class="col-md-6" id="sp_name" style="<?php if($edit_doctor->married_status==1){echo "display: block";}else{echo "display: none";}?>">


              <div class="form-group">


                <label>Spouse Name</label>


                <input class="form-control" name="sp_name" placeholder="Enter email ..." type="text" value="<?=$edit_doctor->spouse_name;?>">               


                  <!--<span class="control-label" for="inputError" style="color: red"><?php echo form_error('doctor_name'); ?></span>-->


                </div>


               


                              


           </div>


           <div class="col-md-6"  id="sp_email" style="<?php if($edit_doctor->married_status==1){echo "display: block";}else{echo "display: none";}?>">


                <div class="form-group">


                <label>Spouse Email Id</label>


                <input class="form-control" name="sp_email" placeholder="Enter email ..." type="email" value="<?=$edit_doctor->spouse_email;?>">               


                  <!--<span class="control-label" for="inputError" style="color: red"><?php echo form_error('doctor_email'); ?></span>-->


                </div>


               


           </div>


           


           <div class="col-md-6">


               <div class="form-group">


                  <label>About</label>


                  <textarea class="form-control" rows="2" name="about" placeholder="About the Person ..."><?=$edit_doctor->about;?></textarea>


                </div>

    
           </div>

            <div class="col-md-6">
                   <?php if(is_admin()){ ?>
               <div class="form-group">
                  <label>Doctor Navigon ID</label>
                     <input class="form-control" name="doc_navigon" placeholder="Enter Navigon id ..." type="text" value="<?php echo $edit_doctor->doc_navigon;?>">               
                </div>
                <div class="form-group">
                  <label>SP code*</label>
                  <input class="form-control" required name="sp_code" placeholder="Enter User sp code ..." type="text" value="<?php echo $edit_doctor->sp_code;?>">             
                </div>
                 <?php }else{ ?>
                  <input class="form-control"  name="doc_navigon" placeholder="Enter Navigon id ..." type="hidden" value="<?php echo $edit_doctor->doc_navigon;?>"> 
                   <?php if($edit_doctor->sp_code!=''){ ?>
                   <input class="form-control"  name="sp_code" type="hidden" value="<?php echo $edit_doctor->sp_code;?>">
                   <?php }else{ ?>
                     <input class="form-control"  name="sp_code" type="hidden" value="<?php echo user_sp_code();?>">
                   <?php }?>
               <?php } ?>
             </div>

           


           


            <!--Address start-->


            <div class="col-md-12">


                


                <div class="form-group">


                  <label>Address</label>


                  <textarea class="form-control" rows="3" name="address" placeholder="Enter Address ..." ><?=$edit_doctor->address;?></textarea>


                </div>


                


                


                


                


            </div>


            <!--Address end-->


       


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





</script>


<script type="text/javascript">


$(function(){


   


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


   


    $('.select5').select2();


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


//               $("#school_state").empty();


//            }


           }


             


        });


    }


//    else{


//        $("#school_state").empty();


//        $("#school_city").empty();


//    }


        


    });


   


    


    


    


    


    


    


    


})
</script>