<?php





/* 


 * Niraj Kumar


 * view for edit hte dealer and group of dealer


 */





$edit_dealer=json_decode($edit_dealer_list);





if(!empty($edit_dealer->gd_id)){


   $dealer_are = explode(',',$edit_dealer->dealer_are);


    $dealer_data = json_decode($dealer_list);


}





     $state_data=json_decode($statename);











// pr($edit_dealer); die;


// pr($dealer_data); die;


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


                


                <?php //  / if(empty($edit_dealer->gd_id)){ // for dealer inforamtion ?>


                <div class="col-md-6">


                    <div class="form-group" id="group_dealer_state">


             


                <label>Dealer State</label>


                 


         <select name="dealer_state" id="group_dealer_state"  class="form-control select5" style="width: 100%;">


                  <option value="">--State--</option>


                <?php 


                foreach($state_data as $k_st => $val_st){


                    if($val_st->state_id==$edit_dealer->state_id){


                ?>   


                  <option value="<?=$val_st->state_id?>" selected="" ><?=$val_st->state_name;?></option>





                    <?php } else{?>


                  <option value="<?=$val_st->state_id?>" <?php if(isset($_POST['dealer_state'])){echo set_select('dealer_state',  $val_st->state_id);} ?>  ><?=$val_st->state_name;?></option>


                <?php } }  ?>


                  


                </select>


            <span class="control-label" for="inputError" style="color: red"><?php echo form_error('dealer_state'); ?></span>





                   </div>


                </div>


                


                <div class="col-md-6">


                     <!--Dealer city List-->


                <div class="form-group">


             


                <label>Dealer City</label>


                 


         <select name="dealer_city" id="group_dealer_city"  class="form-control select7" style="width: 100%;">


                  <option value="<?=$edit_dealer->city_id?>"><?=$edit_dealer->city_name?></option>


                <?php 


//                foreach($city_data as $k_c => $val_c){


                ?>   


                  <!--<option value="<?=$val_c->city_id?>" <?php // if(isset($_POST['dealer_city'])){echo set_select('dealer_city',  $val_c->city_id);} ?>  ><?= $val_c->city_name;?></option>-->


                <?php // } ?>


                  


                </select>


            <span class="control-label" for="inputError" style="color: red"><?php echo form_error('group_dealer_city'); ?></span>





              </div>


                <!--/ dealer city list-->


                    


                </div>


                <?php // }?>


                


                


                


                


                


            <div class="col-md-6">


                


                <div class="form-group">


                <label>Email address</label>


                <?php


                if(empty($edit_dealer->gd_id)){ // for Dealer


                ?>


                  <input class="form-control" name="dealer_email" placeholder="Enter email ..." type="email" value="<?=$edit_dealer->d_email?>">


               <span class="help-block" for="inputError" style="color: red"><?php echo form_error('dealer_email'); ?></span>


                <?php }else{ ?>


               <input class="form-control" name="group_dealer_email" placeholder="Enter email ..." type="email" value="<?=$edit_dealer->d_email?>">


              


               <span class="help-block" for="inputError" style="color: red"><?php echo form_error('group_dealer_email'); ?></span>


 


             <?php } ?>


                </div>


                


             


             


               <div class="form-group">


                


                 <?php


                if(empty($edit_dealer->gd_id)){ // for dealer


                ?>


                   <label>Dealer Name</label>


                 <input class="form-control" name="dealer_id" placeholder="Enter Dealer name..." type="hidden" value="<?=$edit_dealer->d_id?>">





                <input class="form-control" readonly name="dealer_name" placeholder="Enter Dealer name..." type="text" value="<?=$edit_dealer->dealer_name?>">


                 <span class="help-block" for="inputError" style="color: red"><?php echo form_error('dealer_name'); ?></span>





                    <?php }else{ ?>


                 <label>C & F Name</label>


                 <input class="form-control" name="group_dealer_id" placeholder="Enter Dealer name..." type="hidden" value="<?=$edit_dealer->d_id?>">





                <input class="form-control" name="group_dealer_name" placeholder="Enter Dealer name..." type="text" value="<?=$edit_dealer->dealer_name?>">


                 <span class="help-block" for="inputError" style="color: red"><?php echo form_error('group_dealer_name'); ?></span>





                    <?php }?>


              


              </div>


              


                


            </div>


            <!-- /.col -->


            <div class="col-md-6">
              <div class="form-group">
                <label>Contact Number</label>
                <?php if(empty($edit_dealer->gd_id)){?>
                <input class="form-control" name="dealer_num" placeholder="Enter Phone number..." type="text" value="<?=$edit_dealer->d_ph;?>">
                <span class="help-block" for="inputError" style="color: red"><?php echo form_error('dealer_num'); ?></span>
                <?php }else{ ?>
                  <input class="form-control" name="group_dealer_num" placeholder="Enter Phone number..." type="text" value="<?=$edit_dealer->d_ph;?>">
                  <span class="help-block" for="inputError" style="color: red"><?php echo form_error('group_dealer_num'); ?></span>
                <?php } ?>
              <!--<span class="help-block" for="inputError" style="color: red"><?php echo form_error('dealer_num'); ?></span>-->
              </div>
           <!-- /.form-group -->
          <!-- /.form-group -->
        </div>


            <!-- /.col -->


            <div class="col-md-6">


              <?php if(!empty($edit_dealer->gd_id)){ ?>


                <div class="form-group">


                 <label>Dealer List of C & F</label>


                 <select name="group_dealer_id[]" multiple="multiple" class="form-control select2" style="width: 100%;">


                 <?php 


                foreach($dealer_data as $k_s => $val_s){


                if(in_array($val_s->dealer_id,$dealer_are)){


                    ?>   


                    <option  value="<?=$val_s->dealer_id?>" selected=""><?=$val_s->dealer_name.','.$val_s->city_name;?></option>


                <?php }else { ?>


                     <option  value="<?=$val_s->dealer_id?>"><?=$val_s->dealer_name.','.$val_s->city_name;?></option>


               


                    


                <?php } } ?>


                </select>


                <span class="help-block" for="inputError" style="color: red"><?php echo form_error('dealer_num'); ?></span>





              </div>


              <?php } ?>


            


              


              <!-- /.form-group -->


            </div>


            


            <div class="col-md-6">


                <div class="form-group">


                 <label>Alternate Contact Number</label>


                  <input class="form-control" name="dealer_alt_num" placeholder="Enter Alternate Phone number..." type="text" value="<?=$edit_dealer->alt_phone ?>">


             


                <!--<span class="help-block" for="inputError" style="color: red"><?php //echo form_error('dealer_num'); ?></span>-->





              </div>


                
<?php if(is_admin()){ ?>
                <div class="form-group">
                 <label>Dealer Navigon ID</label>
                 <input class="form-control" name="doc_navigon" placeholder="Enter Navigon id ..." type="text" value="<?php echo $edit_dealer->doc_navigon;?>">               
                 <span class="help-block" for="inputError" style="color: red"><?php echo form_error('doc_navigon'); ?></span>
                </div>
                <div class="form-group">
                  <label>Dealer SP Code*</label>
                  <input class="form-control" name="sp_code" placeholder="Enter SP Code..." type="text" value="<?php echo $edit_dealer->sp_code;?>">    
                  <span class="help-block" for="inputError" style="color: red"><?php echo form_error('sp_code'); ?></span>           
                </div>
                <?php }else{ ?>
                    <input class="form-control" name="doc_navigon" type="hidden" value="<?php echo $edit_dealer->doc_navigon;?>">
                    <input class="form-control" name="sp_code" type="hidden" value="<?php echo $edit_dealer->sp_code;?>">
                 <?php } ?>


                


            </div>


            


            


        


            <div class="col-md-6">


                


                 <div class="form-group">


                  <label>About the Dealer</label>


                  


                   <?php


                if(empty($edit_dealer->gd_id)){


                ?>


                 


                  


                  <textarea class="form-control" rows="4" name="about_d" placeholder="About the Dealer ..."><?=$edit_dealer->d_about?></textarea>


                


                <?php } else{?>


                       <textarea class="form-control" rows="4" name="group_about_d" placeholder="About the Dealer ..."><?=$edit_dealer->d_about?></textarea>


                <?php }?>


                 </div>


                


               


                


            </div>


            <div class="col-md-6">


                 <div class="form-group">


                  <label>Dealer Address</label>


                  <textarea class="form-control" rows="3" name="d_address" placeholder="Dealer Address ..."><?=$edit_dealer->d_address?></textarea>


                </div>

            </div>
<div class="col-md-6">
               <div class="form-group">
                  <label>City Pincode *</label>
                    <input class="form-control" name="city_pin" placeholder="Enter Pincode ..." type="text" value="<?=$edit_dealer->city_pincode;?>">               
                    <span class="control-label" for="inputError" style="color: red"><?php echo form_error('city_pin'); ?></span>
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





<script type='text/javascript'>


    $(function(){





    $('.select2').select2();


     


    });


    


</script>





 <?php   if(empty($edit_dealer->gs_id)){ ?>


<script type="text/javascript">


$(function(){





   var $eventSelect3= $('.select5').select2();


   var $eventSelect4 =$('.select7').select2();


     $eventSelect3.on("change",function(e){


         var stateid = $(this).val();  


         


         if(stateid){


        $.ajax({


           type:"POST",


           url:"<?= base_url();?>dealer/dealer_add/dealer_city/",


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


//    else{


//        $("#dealer_state").empty();


//        $("#dealer_city").empty();


//    }


        


    });


 


    


})





</script>


 <?php } ?>