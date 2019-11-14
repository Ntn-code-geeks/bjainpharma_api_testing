<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//
if(isset($user_data)){
    
    $user_info = json_decode($user_data);
    $pharma_data = json_decode($pharma_data);
    
    $doc_data = json_decode($doc_data);
    $boss_info  = json_decode($boss_data);
          
    $have_boss=explode(',',$user_info[0]->bossid);
    $have_pharma=explode(',',$user_info[0]->pharma_id);
    $have_doctor=explode(',',$user_info[0]->doctor_id);
//  pr($have_doctor); die;  
}

if(isset($_POST['user_doctors'])){
$pharma_data = json_decode($pharma_data);
}
 if(isset($_POST['user_doctors'])){
$doc_data = json_decode($doc_data);
 }
 if(isset($_POST['boss'])){
     $boss_info  = json_decode($boss_data);
 }
//pr($doc_data); die;
 $citylist  = json_decode($cityname);
//pr($citylist); die;
       $designation  =  json_decode($design_list);
//pr($designation); die;
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<div class="content-wrapper">
     <!-- Main content -->
    <section class="content">

      <!-- Contact Add -->
      <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"><?php if(isset($user_data)){echo "Edit";} else{echo "Add";}?></h3>
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
                <label>User Name</label>
                <input class="form-control" name="user_name" placeholder="Enter User Name ..." type="text" value="<?php if(isset($_POST['user_name'])){echo $_POST['user_name'];} elseif(isset($user_info)){echo $user_info[0]->name;} ?>">  
                <span class="control-label" for="inputError" style="color: red"><?php echo form_error('user_name'); ?></span>
                </div>  
              </div>  
              <div class="col-md-6">  
                <div class="form-group">   
                <label>Email Id</label>
                <input class="form-control" name="user_email" placeholder="Enter User Email ..." type="text" value="<?php if(isset($_POST['user_email'])){echo $_POST['user_email'];}else if(isset($user_info)){echo $user_info[0]->email;} ?>">  
                <span class="control-label" for="inputError" style="color: red"><?php echo form_error('user_email'); ?></span>
                </div>
                
              </div>
            </div>
                
            <div class="row">   
            <div class="col-md-6">
                
                <div class="form-group">   
                <label>Contact Number</label>
                <input class="form-control" name="user_ph" placeholder="Enter User Phone Number ..." type="text" value="<?php if(isset($_POST['user_ph'])){echo $_POST['user_ph'];}else if(isset($user_info)){echo $user_info[0]->phone;} ?>">  
                <span class="control-label" for="inputError" style="color: red"><?php echo form_error('user_ph'); ?></span>
                </div>  
                <input name="user_city[]" id="user_city" value='0' type="hidden">

             <?php /*?>   <div class="form-group">   
                <label>Assign Cities</label>
                
                <select name="user_city[]" id="user_city" multiple="multiple" class="form-control select4" style="width: 100%;">
                
                    <?php 
                    if(!isset($user_info)){
                      ?>
                     <option value="">--City--</option>
                    <?php
                    }
                    ?>
                    
                   
                <?php 
                 if(isset($user_info)){
              $user_cities = explode(',',$user_info[0]->city_id);
                 }
                 else{
                    $user_cities=array(); 
                 }
                
                foreach($citylist as $k_c => $val_c){
                    
                  //echo $user_cities;
                 
                    if(in_array($val_c->city_id,$user_cities)){
                        
                        ?>
                     <option value="<?=$val_c->city_id?>" selected=""  ><?=$val_c->city_name.'('.$val_c->state_name.')';?></option>
       
              <?php          
                    }   else{
                ?>   
                  <option value="<?=$val_c->city_id?>" <?php if(isset($_POST['user_city'])){echo set_select('user_city',  $val_c->city_id);} ?>  ><?=$val_c->city_name.'('.$val_c->state_name.')';?></option>
                <?php }   
                
                }    ?>
                  
                 
                </select>
                
                </div><?php */?>
                
            </div>   
            </div>   
                
           <div class="row">   
                <div class="col-md-6">
                
                <div class="form-group">   
                <label>Address</label>
               <textarea class="form-control" rows="4" name="user_address" placeholder="User Address ..."><?php if(isset($_POST['user_address'])){echo $_POST['user_address'];}else if(isset($user_info)){echo $user_info[0]->address;} ?></textarea>
                
                </div>  
                </div>  
                <div class="col-md-6">
                <div class="form-group">   
                <label>Doctor List</label>
                
                <select name="user_doctors[]" id="user_doctors" multiple="multiple" class="form-control select7" style="width: 100%;">
                
                  <?php if(isset($_POST['user_doctors'])){   // for false validation remains selected values and list
                       foreach($doc_data as $k_doc => $val_doc){
                      ?>  
                    
                    <option value="<?=$val_doc->id?>" <?php if(in_array($val_doc->id, $_POST['user_doctors'])){ echo "selected" ; }?> <?php if(isset($_POST['user_doctors'])){echo set_select('user_doctors',  $val_doc->id);} ?> ><?php echo $val_doc->doc_name.'('.$val_doc->city_name.')';?>

                     </option>
                     
                  <?php     } } ?>
                     
                     
                <?php  if( isset($doc_data) && !empty($have_doctor) ){ ?>    
                <option value="">--Select Doctors--</option>
                <?php 
                foreach($doc_data as $k_doc => $val_doc){
                ?>   
                  <option value="<?=$val_doc->id?>" <?php if(in_array($val_doc->id, $have_doctor)){ echo "selected" ; }?> <?php if(isset($_POST['user_doctors'])){echo set_select('user_doctors',  $val_doc->id);} ?>  ><?=$val_doc->doc_name;?></option>
                <?php } } ?>
                 
                </select>
                
                </div>
                
                 </div> 
            </div> 
            <div class="row">       
              <div class="col-md-6">
                <div class="form-group">
                  <label>Headquarter City* </label>
                  <select name="hq_city"   class="form-control select2" style="width: 100%;">
                    <option value="">-- Select City --</option>
                    <?php foreach(get_all_city() as $user){ ?>   
                       <option <?php if(isset($user_info)){ echo $user_info[0]->hq_city==$user['city_id']?'Selected':'';}?> value="<?=$user['city_id']?>"><?=$user['city_name'];?></option>
                    <?php  } ?>
                  </select>
                 <span class="control-label" for="inputError" style="color: red"><?php echo form_error('hq_city'); ?></span>
                </div>
              </div>
               <div class="col-md-6">
               <div class="form-group">
                  <label>Headquarter Pincode *</label>
                    <input class="form-control" name="city_pin" placeholder="Enter Pincode ..." type="text" value="<?php if(isset($_POST['city_pin'])){echo $_POST['city_pin'];} elseif(isset($user_info)){echo $user_info[0]->hq_city_pincode;} ?>">               
                    <span class="control-label" for="inputError" style="color: red"><?php echo form_error('city_pin'); ?></span>
                </div>
              </div>
              </div>

               <div class="row">   
                <div class="col-md-6">
                    <div class="form-group">   
                <label>Designation</label>
                
                <select name="user_designation" id="user_designation"  class="form-control select5" style="width: 100%;">
                
                    
                <option value="">--Select Designation--</option>
                <?php 
                foreach($designation as $k_d => $val_d){
                   
                   
                        ?>
                <option value="<?=$val_d->id?>" <?php  if(isset($user_info)){ if($val_d->id == $user_info[0]->desig_id ){ echo "selected";}} ?> ><?=$val_d->d_name;?></option>
        <?php   
                  } ?>
                 
                </select>
                
                </div>
                </div>
                  <div class="col-md-6">  
                <div class="form-group">   
                <label>User Password *</label>
                <input class="form-control" name="user_pass" placeholder="Enter User Password ..." type="text" value="<?php if(isset($_POST['user_pass'])){echo $_POST['user_pass'];} ?>">  
                <span class="control-label" for="inputError" style="color: red"><?php echo form_error('user_pass'); ?></span>
                </div>  
                    
                </div>
                </div>
                
                
                <div class="row">   
                <div class="col-md-6">
                    
                <div class="form-group">   
                <label>Retail Sub Dealer List</label>
                
                <select name="user_pharmacy[]" id="user_pharmacy" multiple="multiple"  class="form-control select8" style="width: 100%;">
                 
                  <?php if(isset($_POST['user_pharmacy'])){   // for false validation remains selected values and list
                       foreach($pharma_data as $k_p => $val_p){
                      ?>  
                    
                    <option value="<?=$val_p->id?>" <?php if(in_array($val_p->id, $_POST['user_pharmacy'])){ echo "selected" ; }?> <?php if(isset($_POST['user_pharmacy'])){echo set_select('user_pharmacy',  $val_p->id);} ?> ><?php echo $val_p->com_name.'('.$val_p->city_name.')';?>

                     </option>
                     
                  <?php } } ?>   
                    
                    
                <?php if(isset($pharma_data) && !empty($have_pharma)){?>    
                <option value="">--Select Dealer--</option>
                <?php 
                foreach($pharma_data as $k_p => $val_p){
                ?>   
                <option value="<?=$val_p->id?>" <?php if(in_array($val_p->id, $have_pharma)){ echo "selected" ; }?> <?php if(isset($_POST['user_pharmacy'])){echo set_select('user_pharmacy',  $val_p->id);} ?>   ><?=$val_p->com_name;?></option>
                <?php } } ?>
                 
                </select>
                
                </div>
                </div>
                       
                
                <div class="col-md-6">
                    
                <div class="form-group">   
                <label>Boss List</label>
                
                <select name="boss[]" id="user_boss" multiple="multiple" class="form-control select2" style="width: 100%;">
               
                   <?php if(isset($_POST['boss'])){   // for false validation remains selected values and list
                       foreach($boss_info as $k_d => $val_d){
                      ?>  
                    
                    <option value="<?=$val_d->id?>" <?php if(in_array($val_d->id, $_POST['boss'])){ echo "selected" ; }?> <?php if(isset($_POST['boss'])){echo set_select('boss',  $val_d->id);} ?> ><?php echo $val_d->name.'('.$val_d->designation_name.')';?>

                     </option>
                     
                  <?php } } ?>   
                    
                    
                     <?php if(isset($boss_info) && !empty($have_boss)){?>    
                <option value="">--Select Boss--</option>
                <?php 
                foreach($boss_info as $k_d => $val_d){
                ?>   
                <option value="<?=$val_d->id?>" <?php if(in_array($val_d->id, $have_boss)){ echo "selected" ; }?> <?php if(isset($_POST['boss'])){echo set_select('boss',  $val_d->id);} ?>   ><?=$val_d->name.'('.$val_d->designation_name.')';?></option>
                <?php } } ?>
                 
                    
                </select>
                
                </div>
                    
                </div>
                </div>
                 <div class="row"> 
				<div class="col-md-6">
                <div class="form-group">   
                <label>Employee code</label>
                <input class="form-control" name="emp_code" placeholder="Enter Employee Code ..." type="text" value="<?php if(isset($_POST['emp_code'])){echo $_POST['emp_code'];}else if(isset($user_info)){echo $user_info[0]->emp_code;} ?>">  
                <span class="control-label" for="inputError" style="color: red"><?php echo form_error('emp_code'); ?></span>
                </div> 
                </div> 
               	<div class="col-md-6">
                <div class="form-group">   
                <label>Sales Persone code *</label>
                <input class="form-control" name="sp_code" placeholder="Enter Sales Persone code ..." type="text" value="<?php if(isset($_POST['sp_code'])){echo $_POST['sp_code'];}else if(isset($user_info)){echo $user_info[0]->sp_code;} ?>">  
                <span class="control-label" for="inputError" style="color: red"><?php echo form_error('sp_code'); ?></span>
                </div> 
                </div> 
                </div> 
                </div> 
                <div class="row"> 
            <div class="col-md-12">
               <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">Submit</button>
            </div>
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
    
    $('.select2').select2();    // for boss list  
$('.select8').select2();
   
 

  var $eventSelect4 =  $('.select4').select2();   // user city
  
  var $eventSelect7 = $('.select7').select2();
  
     $eventSelect4.on("change",function(e){
         
        var cityid = $(this).val();  
      // alert(cityid);
         if(cityid){
        $.ajax({
           type:"POST",
           url:"<?= base_url();?>admin_control/user_permission/doctor_info/",
           data : 'id='+cityid,
           success:function(res){ 

            if(res){

            $("#user_doctors").html(res);

            }
//            else{
//               $("#dealer_state").empty();
//            }
           }
             
        });
        
        
         $.ajax({
           type:"POST",
           url:"<?= base_url();?>admin_control/user_permission/pharmacy_info/",
           data : 'id='+cityid,
           success:function(res){ 

            if(res){

            $("#user_pharmacy").html(res);

            }
//            else{
//               $("#dealer_state").empty();
//            }
           }
             
        });
        
        
    }

    });

var $eventSelect5 = $('.select5').select2();    // for designation selction
 $eventSelect5.on("change",function(e){   // function to show boss of the user accrdoing to there city and designation
         
        var cityid = $('#user_city').val();  
        
        var desig_id = $(this).val(); 
      
         if((desig_id!="") && (cityid!="")){
            
        $.ajax({
           type:"POST",
           url:"<?= base_url();?>admin_control/user_permission/boss_info/",
           data: { 'desigid': desig_id, 'cityid': cityid },
            //data : 'desigid='+desig_id+'cityid'+cityid,,
           success:function(res){ 

            if(res){

            $("#user_boss").html(res);

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
<script type='text/javascript'>
    $(function(){
    $('.select12').select2();
    });
</script>