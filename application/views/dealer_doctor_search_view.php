<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 $state_name = json_decode($statename);

  $d_info = json_decode($dealer_data);
   $team_list=json_decode($users_team);  // show child and boss users

  $doc_info = json_decode($doctor_data);
          
   $pharmacy_info = json_decode($pharma_data);
   
    $ms = json_decode($meeting_sample);
 $dealer_data = json_decode($dealer_list);   // for all active dealers 

// pr($pharmacy_info); die;
?>

<!--  DataTables 
 <link rel="stylesheet" href="<?= base_url()?>design/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
 -->
 <link href="<?= base_url()?>design/css/div_table/one.css" rel="stylesheet" type="text/css"/>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

 
<div class="content-wrapper modal-open">
    <!-- Content Header (Page header) -->
        <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
   <?php echo get_flash(); ?>
          <div class="box">
            <div class="box-header">
<!--                <a href="<?= base_url();?>dealer/dealer"> 
                    <h3 class="box-title"><button type="button" class="btn btn-block btn-success">Add New</button></h3>
                </a>-->
                
               <!--Search for school-->
               <div class="box-tools" style="top:10px;width: 200px;">
                <?php 
                echo form_open($action,array('method'=>'get'));?>
                   <div class="input-group input-group-sm">

                    <input name="table_search" value="<?= $request?>" class="form-control pull-right" placeholder="Search" type="text" style='height: 34px'>

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default" style='height: 34px'><i class="fa fa-search"></i></button>
                  </div>
                   </div>
                   
                   <?php echo form_close(); ?>
              </div>
                <!--end Search-->
            </div>
           
              <?php if(!empty($d_info)){ ?>
            <!-- /.box-header -->
            <div class="box-body">
                <label>Dealer</label>
                <!--<div class="table-responsive">-->
                   <div class="table">
    
                            <div class="rowdivline header blue">
                              <div class="cell">
                               Dealer Name
                              </div>
                              <div class="cell">
                                Dealer Email
                              </div>
                              <div class="cell">
                                Phone Number
                              </div>
                              <div class="cell">
                                City
                              </div>
                                <div class="cell">
                                Action
                              </div>
                            </div>
              <?php
                 
                  foreach($d_info as $k_d=>$val_d){
                  ?>
                                    <div class="rowdivline">
                                      <div class="cell">
                                        <?=$val_d->d_name;?>
                                      </div>
                                      <div class="cell">
                                      <?=$val_d->d_email;?>
                                      </div>
                                      <div class="cell">
                                        <?=$val_d->d_ph;?>
                                      </div>
                                      <div class="cell">
                                        <?=$val_d->d_city;?>
                                      </div>
                                        <div class="cell">
                                            <?php //if(empty($val_d->gd_id)){?><a href="<?php echo base_url()."/dealer/dealer/edit_dealer/". urisafeencode($val_d->id);?>"><button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a> 
                                            | <a href="<?php echo base_url()."/dealer/dealer/view_dealer_for_doctor/". urisafeencode($val_d->id);?>"><button type="button" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                                            <!--| <a href="<?php echo base_url()."/dealer/dealer/del_dealer/".urisafeencode($val_d->id);?>" onclick="return confirm('Are you sure want to delete this record.')" class=""><button type="button" class="btn btn-info"><i class="fa fa-trash-o" aria-hidden="true"></i></button></a>-->
                    <!--<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_add_appointment<?=$val_d->id?>">
                Add Appointment
              </button>-->
              <a href="<?php echo base_url()."dealer/dealer/dealer_interaction_sales/".urisafeencode($val_d->id);?>"><button type="button" class="btn btn-info">Interaction</button></a>

                           <?php  //}  ?>

                                        </div> 
                                        
                                    </div>
    
                         <!--Add appointment-->
      <div class="modal modal-info fade" id="modal_add_appointment<?=$val_d->id?>">
         <form role="form" method="post" action="<?php echo base_url()."appointment/appoint/save_appointment"?>" enctype= "multipart/form-data">

          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ADD Appointment</h4>
              </div>
              <div class="modal-body">
                 <!--<div class="col-md-6">-->
                 <div class="form-group" >
                 <label>Dealer name</label>
                 <input class="form-control" name="d_name" placeholder="Dealer Name..." type="text" value="<?=$val_d->d_name;?>" readonly="">               
                <input class="dealer_view_id"  name="dealer_id" type="hidden" value="<?=$val_d->id;?>"> 
                <!--<input class="gd_id"  name="gd_id" type="hidden" value="<?=$val_d->id;?>">-->                  
            <!--<span class="control-label" for="inputError" style="color: red"></span>-->
                 </div>
       
                <div class="form-group">
                  <label>Reason to meet</label>
                  <textarea class="form-control" rows="3" name="reason" placeholder="Reason to meet ..."></textarea>
                </div>                  
                 
                <div class="form-group">
                <label>DOA:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input class="form-control pull-right" name="doa" id="datepicker_doa<?=$val_d->id;?>" type="text">
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
          
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Save changes</button>
              </div>
            </div>
          
         </form>
            <!-- /.modal-content -->
          </div> <!--/ add appointment-->
                       
                       
          <div class="modal modal-info fade" id="modal_info_dealer_interaction<?=$val_d->id?>">
          <form role="form" method="post" onsubmit="return validateForm(<?=$val_d->id;?>)"  action="<?php echo base_url()."dealer/dealer/dealer_interaction"?>" enctype= "multipart/form-data">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Dealer Interaction</h4>
              </div>
              <div class="modal-body">
                 <!--<div class="col-md-6">-->
                <div class="form-group" >
                 <label>Dealer name</label>
                 <input class="form-control" name="d_name" placeholder="Dealer Name..." type="text" value="<?=$val_d->d_name;?>" readonly="">               
                <input class="dealer_view_id"  name="dealer_view_id" type="hidden" value="<?=$val_d->id;?>"> 
                <input class="gd_id"  name="d_id" type="hidden" value="<?=$val_d->id;?>">                  
            <!--<span class="control-label" for="inputError" style="color: red"></span>-->
                </div>
                 
                 <div class="form-group">
                    <label id="telephonic<?=$val_d->id ?>" style="display: block">Telephonic Interaction
                     <input name="telephonic" id="telephonic1" value="1" type="checkbox">
                    </label>
                   
                 </div>
       
                <div class="form-group" id="jw_<?=$val_d->id ?>" style="display: block">
                     <label>Joint Working</label>
                     <select name="team_member[]" multiple="multiple" class="form-control select2" style="width: 100%;">
                          <!--<option value="">---Sample Name---</option>-->
                <?php 
                foreach($team_list as $k_tl => $val_tl){
                    
                ?>   
                  <option value="<?=$val_tl->userid?>" <?php if(isset($_POST['team_member'])){echo set_select('team_member',  $val_tl->userid);} ?>><?=$val_tl->username;?></option>
                  <?php }  ?>
              <!--<option value="none" id="none" >NONE</option>-->

                </select>
                </div>
                 
                 
<!--                 </div>
                  <div class="col-md-6">-->
                  <div class="form-group" >
                      
                      <table class="table table-bordered" style="background:#00c0ef">
                <tbody><tr>
                  
                  <th>Meeting Type</th>
                  <th>Value</th>
                </tr>
                <tr>
                  <td>Sale</td>
                  <td id="sale<?=$val_d->id ?>" style="display: block"><input class="form-control" name="m_sale" placeholder="Sales info..." type="text" >  </td>
                  
                </tr>
                <tr >
                  <td>Sample/Gift</td>
                  <td id="sample<?=$val_d->id ?>" style="display: block"><select name="m_sample[]" multiple="multiple" class="form-control select2" style="width: 100%;">
                          <option value="">---Sample Name---</option>
                <?php 
                foreach($ms as $k_ms => $val_ms){
                    
                ?>   
                  <option value="<?=$val_ms->id?>" <?php if(isset($_POST['m_sample'])){echo set_select('m_sample',  $val_ms->id);} ?>><?=$val_ms->sample_name;?></option>
                  <?php }  ?>
              <!--<option value="none" id="none" >NONE</option>-->

                </select> </td>
                 
                </tr>
                <tr>
                  <td>Payment</td>
                  <td id="payment<?=$val_d->id ?>" style="display: block"><input class="form-control" name="m_payment" placeholder="Payment info..." type="text" > </td>
                  
                </tr>
                <tr>
                  <td>Stock</td>
                  <td id="stock<?=$val_d->id ?>" style="display: block"><input class="form-control" name="m_stock" placeholder="Stock info..." type="text" > </td>
                  
                </tr>
                <tr>
                  <td>Meet or Not Meet</td>
                  <td><div class="radio">
                    <label id="meet<?=$val_d->id ?>" style="display: block">
                      <input name="meet_or_not" id="optionsRadios1" value="1" type="radio">
                      Meet
                    </label>
                  </div>
                  <div class="radio">
                    <label id="notmmeet<?=$val_d->id ?>" style="display: block">
                      <input name="meet_or_not" id="optionsRadios1" value="0" type="radio">
                      Not Meet
                    </label>
                  </div></td>
                  
                </tr>
              </tbody></table>

                  </div> 

                   <div class="form-group">
                            <label>Remark</label>

                            <textarea class="form-control" rows="3" name="remark" placeholder="About the Meeting ..."></textarea>


                        </div>
                
                    <div class="form-group" >
                          <label>Followup Action</label>
                   <input class="form-control" name="fup_a" id="datepicker_fup<?=$val_d->id;?>" type="text">
                    </div>

                    <div class="form-group" >
                          <label>Date of Interaction</label>
                   <input class="form-control" name="doi_doc" id="datepicker_doi<?=$val_d->id ?>" type="text">
                    </div>
                  
                      
                  </div>
              
              
              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Save changes</button>
              </div>
            </div>
          </form>
          <?php // echo form_close(); ?>
            <!-- /.modal-content -->
          </div>             
                       
          <script type="text/javascript">
              
               $('#sale<?=$val_d->id ?>').on("change", function(){
//               alert('mee');
               var sale_value = $(this).val();
               
             if(sale_value === ''){
               $("#meet<?=$val_d->id ?>").css("display","none");
               $("#notmmeet<?=$val_d->id ?>").css("display","none");
                  }
                  else{
                      $("#meet<?=$val_d->id ?>").css("display","block");
                       $("#notmmeet<?=$val_d->id ?>").css("display","block");
                  }
            
           });
           
            $('#payment<?=$val_d->id ?>').on("change", function(){
//               alert('mee');
               var payment_value = $(this).val();
               
             if(payment_value === ''){
               $("#meet<?=$val_d->id ?>").css("display","none");
               $("#notmmeet<?=$val_d->id ?>").css("display","none");
                  }
                  else{
                      $("#meet<?=$val_d->id ?>").css("display","block");
                       $("#notmmeet<?=$val_d->id ?>").css("display","block");
                  }
            
           });
           
           $('#stock<?=$val_d->id ?>').on("change", function(){
//               alert('mee');
               var stock_value = $(this).val();
               
             if(stock_value === ''){
               $("#meet<?=$val_d->id ?>").css("display","none");
               $("#notmmeet<?=$val_d->id ?>").css("display","none");
                  }
                  else{
                      $("#meet<?=$val_d->id ?>").css("display","block");
                       $("#notmmeet<?=$val_d->id ?>").css("display","block");
                  }
            
           });
           
           
            $('#meet<?=$val_d->id ?>').on("click", function(){
//               alert('mee');
               var sale_value = $(this).val();
               
             if(sale_value === ''){
               $("#sale<?=$val_d->id ?>").css("display","none");
               $("#sample<?=$val_d->id ?>").css("display","none");
                $("#payment<?=$val_d->id ?>").css("display","none");
                 $("#stock<?=$val_d->id ?>").css("display","none");
                 $("#jw_<?=$val_d->id ?>").css("display","none");
                  }
                  else{
                      $("#sale<?=$val_d->id ?>").css("display","block");
                       $("#sample<?=$val_d->id ?>").css("display","block");
                        $("#payment<?=$val_d->id ?>").css("display","block");
                         $("#stock<?=$val_d->id ?>").css("display","block");
                          $("#jw_<?=$val_d->id ?>").css("display","block");
                  }
            
           });
           
           $('#notmmeet<?=$val_d->id ?>').on("click", function(){
//               alert('mee');
               var sale_value = $(this).val();
               
             if(sale_value === ''){
              $("#sale<?=$val_d->id ?>").css("display","none");
               $("#sample<?=$val_d->id ?>").css("display","none");
                $("#payment<?=$val_d->id ?>").css("display","none");
                 $("#stock<?=$val_d->id ?>").css("display","none");
                  $("#jw_<?=$val_d->id ?>").css("display","none");
                  }
                  else{
                      $("#sale<?=$val_d->id ?>").css("display","block");
                       $("#sample<?=$val_d->id ?>").css("display","block");
                        $("#payment<?=$val_d->id ?>").css("display","block");
                         $("#stock<?=$val_d->id ?>").css("display","block");
                          $("#jw_<?=$val_d->id ?>").css("display","block");
                  }
            
           });
              
               $(function(){
               
               
                var $eventSelect3= $('.select2').select2();
                     
                       $eventSelect3.on("change",function(e){
             
         var sample_value = $(this).val();
            
             if(sample_value != ''){
                   
               $("#meet<?=$val_d->id ?>").css("display","none");
               $("#notmmeet<?=$val_d->id ?>").css("display","none");
                  }
                  else{
                        
                     $("#meet<?=$val_d->id ?>").css("display","block");
                       $("#notmmeet<?=$val_d->id ?>").css("display","block");
                  } 

    });
               
         $('#datepicker_doa<?=$val_d->id;?>').datepicker({
                            format:'dd-mm-yyyy',
                            autoclose:true
                      });
                      
       $('#datepicker_fup<?=$val_d->id;?>').datepicker({
           format:'dd-mm-yyyy',
           autoclose:true
       })  ; 
       
        $('#datepicker_doi<?=$val_d->id;?>').datepicker({
           
            format:'dd-mm-yyyy',
            startDate: '-7d',
            endDate: '+0d' ,
            autoclose:true
       })  ; 
       
   
    });
       </script>
       
                  
            <?php } ?>

               </div>
            <!-- /.box-body -->
            </div>  <?php } // close dealer search result 
             ?>
          
          
         <?php  if(!empty($doc_info)){ ?> 
          <div class="box-body">
               <label>Doctors </label>
                <!--<div class="table-responsive">-->
                    
                    <div class="table">
    
                            <div class="rowdivline header blue">
                              <div class="cell">
                               Doctor Name
                              </div>
                              <div class="cell">
                                 Doctor Email
                              </div>
                              <div class="cell">
                                Phone Number
                              </div>
                              <div class="cell">
                                City
                              </div>
                                <div class="cell">
                                Action
                              </div>
                            </div>
                    <?php
                               
                                 foreach($doc_info as $k_c=>$val_c){
                                 ?>
                        
                                <div class="rowdivline">
                                  <div class="cell">
                                    <?=$val_c->d_name;?>
                                  </div>
                                  <div class="cell">
                                   <?=$val_c->d_email;?>
                                  </div>
                                  <div class="cell">
                                    <?=$val_c->d_ph;?>
                                  </div>
                                  <div class="cell">
                                    <?=$val_c->c_city;?>
                                  </div>
                                    <div class="cell">
                                      <a href="<?php echo base_url()."doctors/doctor/edit_doctor/". urisafeencode($val_c->id);?>"><button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                                      | <a href="<?php echo base_url()."doctors/doctor/view_doctor_for_interaction/". urisafeencode($val_c->id);?>"><button type="button" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                                              <!--| <a href="<?php echo base_url()."doctors/doctor/del_doctor/".urisafeencode($val_c->id);?>" onclick="return confirm('Are you sure want to delete this record.')" class=""><button type="button" class="btn btn-info"><i class="fa fa-trash-o" aria-hidden="true"></i></button></a>-->
                                      <!-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_info_doctor<?=$val_c->id ?>">
                 Interaction
                 </button>-->					<a href="<?php echo base_url()."doctors/doctor/doctor_interaction_sales/".urisafeencode($val_c->id);?>">												<button type="button" class="btn btn-info">Interaction</button>											</a>
                <!--<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_info_appointment<?=$val_c->id ?>">
                 Appointment
                 </button> -->
                                    </div>
                                </div>
       
       <!--Doctor Appointment-->
       <div class="modal modal-info fade" id="modal_info_appointment<?=$val_c->id ?>">
        <form role="form" method="post" action="<?php echo base_url()."appointment/appoint/save_appointment"?>" enctype= "multipart/form-data">

          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Appointment Add</h4>
              </div>
              <div class="modal-body">
                 <!--<div class="col-md-6">-->
                 <div class="form-group" >
                 <label>Person name</label>
                 <input class="form-control" name="d_name" placeholder="Person Name..." type="text" value="<?=$val_c->d_name;?>" readonly="">               
                  <input class="c_id"  name="dealer_id" type="hidden" value="<?=$val_c->id;?>"> 
               <input class="dealer_view_id"  name="dealer_view_id" type="hidden" value="<?=$val_c->id;?>"> 
             <!--<span class="control-label" for="inputError" style="color: red"></span>-->
                 </div>
                 
                 
                 
                 
                <div class="form-group">
                <label>DOA:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input class="form-control pull-right" name="doa" id="datepicker_doa<?=$val_c->id ?>" type="text">
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
                      
                  <div class="form-group">
                  <label>Reason to meet</label>
                  <textarea class="form-control" rows="3" name="reason" placeholder="Reason to meet ..."></textarea>
                </div>
                    
                
                  </div>  <!--End of contact edit modal-->
              
              
              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Save changes</button>
              </div>
            </div>
          
        </form>
              
            <!-- /.modal-content -->
          </div>
                        
           <!--Doctor Interaction-->              
         <div class="modal modal-info fade" id="modal_info_doctor<?=$val_c->id ?>">
          <form role="form" method="post"  action="<?php echo base_url()."dealer/dealer/dealer_interaction"?>" enctype= "multipart/form-data">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Doctor Interaction</h4>
              </div>
              <div class="modal-body">
                 <!--<div class="col-md-6">-->
                 <div class="form-group" >
                 <label>Doctor name</label>
                 <input class="form-control" name="doc_name" placeholder="Dealer Name..." type="text" value="<?=$val_c->d_name;?>" readonly="">               
                 <input class="dealer_view_id"  name="dealer_view_id" type="hidden" value="<?=$val_c->id;?>"> 
                 <input class="gd_id"  name="doc_id" type="hidden" value="<?=$val_c->id;?>">                  
            <!--<span class="control-label" for="inputError" style="color: red"></span>-->
                 </div>
                 
                  <div class="form-group">
                    <label id="telephonic<?=$val_c->id ?>" style="display: block">Telephonic Interaction
                     <input name="telephonic" id="telephonic1" value="1" type="checkbox">
                    </label>
                   
                 </div>
       
                 
                 <div class="form-group" id="jw_<?=$val_c->id ?>" style="display: block">
                     <label>Joint Working</label>
                     <select name="team_member[]" multiple="multiple" class="form-control select2" style="width: 100%;">
                          <!--<option value="">---Sample Name---</option>-->
                <?php 
                foreach($team_list as $k_tl => $val_tl){
                    
                ?>   
                  <option value="<?=$val_tl->userid?>" <?php if(isset($_POST['team_member'])){echo set_select('team_member',  $val_tl->userid);} ?>><?=$val_tl->username;?></option>
                  <?php }  ?>
              <!--<option value="none" id="none" >NONE</option>-->

                </select>
                </div>
                 
                 
                  <div class="form-group" >
                      <!--<label>Meeting Types *</label>-->
                      
                <table class="table table-bordered" style="background: #00c0ef;">
                <tbody><tr>
                  
                  <th>Meeting</th>
                  <th>Value</th>
                 
                </tr>
                
                <tr >
                  <td>Secondary Sale</td>
                  <td id="sale<?=$val_c->id ?>" style="display: block"><input class="form-control" id="sale_dealer<?=$val_c->id;?>" name="m_sale" placeholder="Sales info..." type="text" ></td>
                  
                </tr>
                <tr >
                  <td>Sample</td>
                  <td id="sample<?=$val_c->id ?>" style="display: block"><select name="m_sample[]" multiple="multiple" class="form-control select2" style="width: 100%;">
                          <option value="">---Sample Name---</option>
                <?php 
                foreach($ms as $k_ms => $val_ms){
                    
                ?>   
                  <option value="<?=$val_ms->id?>" <?php if(isset($_POST['m_sample'])){echo set_select('m_sample',  $val_ms->id);} ?>><?=$val_ms->sample_name;?></option>
                  <?php }  ?>
              <!--<option value="none" id="none" >NONE</option>-->

                </select> </td>
                 
                </tr>
                <tr >
                  <td>Met</td>
                  <td><div class="radio">
                    <label id="meet<?=$val_c->id ?>" style="display: block">
                      <input name="meet_or_not" id="optionsRadios1" value="1" type="radio">
                      Only Discussion
                    </label>
                  </div>
                  </td>
                  
                </tr>
                <tr >
                    <td>Not Met</td>
                    <td><div class="radio">
                    <label id="notmmeet<?=$val_c->id ?>" style="display: block">
                      <input name="meet_or_not" id="not_meet<?=$val_c->id ?>" value="0" type="radio">
                      Not Met
                    </label>
                  </div></td>
                </tr>
               
              </tbody></table>
                      

                  </div>  

       <div class="form-group" id="d_list<?=$val_c->id ?>" style="display: none">
           <label>Dealer/pharmacy List</label>
          
    <select id="doc_dealer_pharma<?=$val_c->id ?>" name="dealer_id" class="form-control select2" style="width: 100%;">
              <?php
           if(!empty($val_c->dealers_id)){
           ?>     
                <?php 
                foreach($dealer_data as $k_s => $val_s){
                    
                    /*for dealers id who belogs to this doctor*/
                                if(!empty(($val_c->dealers_id))){   
                                    $dealers_are = explode(',', $val_c->dealers_id);
                                }
                                else{
                                    $dealers_are=array();
                                }  
                    /*end of dealers id who belogs to this doctor */

                     if(in_array($val_s->dealer_id,$dealers_are)){
                    
                ?>   
                  <option value="<?=$val_s->dealer_id?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_s->dealer_id);} ?>><?=$val_s->dealer_name.','.$val_s->city_name;?></option>
                  <?php } } ?>
                  
                  
                  
                  <?php 
                foreach($pharma_list as $k_s => $val_s){
                    
                    /*for dealers id who belogs to this doctor*/
                                if(!empty(($val_c->dealers_id))){   
                                    $dealers_are = explode(',', $val_c->dealers_id);
                                }
                                else{
                                    $dealers_are=array();
                                }  
                    /*end of dealers id who belogs to this doctor */

                     if(in_array($val_s['id'],$dealers_are)){
                    
                ?>   
                  <option value="<?=$val_s['id']?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_s['id']);} ?>><?=$val_s['com_name'].', (Sub Dealer)';?></option>
                  <?php } } ?>
                  
                  
              <!--<option value="none" id="none" >NONE</option>-->
 <?php } ?>
    </select> <br/>

     <button type="button" class="btn btn-warning"  data-toggle="modal" data-target="#modal_add_dealer<?=$val_c->id ?>">Add Dealer/Sub Dealer  </button>

    <!--<a href="<?= base_url()?>doctors/doctor/edit_doctor/<?php echo urisafeencode($val_c->id); ?>" style="color: #fff"><button type="button" class="btn btn-warning">Add Dealer/Sub Dealer  </button></a>-->

           <?php // }else{ ?>
           
     <!--<button type="button" class="btn btn-warning"  data-toggle="modal" data-target="#modal_add_dealer<?=$val_c->id ?>">Add Dealer/Sub Dealer  </button>-->

           <!--<a href="<?= base_url()?>doctors/doctor/edit_doctor/<?php echo urisafeencode($val_c->id); ?>" style="color: #fff"><button type="button" class="btn btn-warning">Add Dealer/Sub Dealer  </button></a>-->
              
           
           <?php // } ?>
    
</div>

                        <div class="form-group">
                            <label>Remark</label>
               
                     <textarea class="form-control" rows="3" name="remark" placeholder="About the Meeting ..."></textarea>

                        </div>
                
                      <div class="form-group" >
                          <label>Followup Action</label>
                   <input class="form-control" name="fup_a" id="datepicker_fup<?=$val_c->id ?>" type="text">
                      </div>

                  <div class="form-group" >
                          <label>Date of Interaction</label>
                   <input class="form-control" name="doi_doc" id="datepicker_doi<?=$val_c->id ?>" type="text">
                    </div>
                  
                      
                  </div>
              
              
              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Save changes</button>
              </div>
            </div>
          </form>
          <?php // echo form_close(); ?>
            <!-- /.modal-content -->
          </div>

          
       <script type="text/javascript">
           $('#sale_dealer<?=$val_c->id ?>').on("change", function(){
               
               var sale_value = $(this).val();
               
             if(sale_value === ''){
               $("#d_list<?=$val_c->id ?>").css("display","none");
                  }
                  else{
                      $("#d_list<?=$val_c->id ?>").css("display","block");
                  }
            
           });
           
            $('#sale<?=$val_c->id ?>').on("change", function(){
//               alert('mee');
               var sale_value = $(this).val();
               
             if(sale_value === ''){
               $("#meet<?=$val_c->id ?>").css("display","none");
               $("#notmmeet<?=$val_c->id ?>").css("display","none");
                  }
                  else{
                      $("#meet<?=$val_c->id ?>").css("display","block");
                       $("#notmmeet<?=$val_c->id ?>").css("display","block");
                  }
            
           });
    
       $('#meet<?=$val_c->id ?>').on("click", function(){
//               alert('mee');
               var sale_value = $(this).val();
               
             if(sale_value === ''){
               $("#sale<?=$val_c->id ?>").css("display","none");
               $("#sample<?=$val_c->id ?>").css("display","none");
                $("#jw_<?=$val_c->id ?>").css("display","none");
                  }
                  else{
                      $("#sale<?=$val_c->id ?>").css("display","block");
                       $("#sample<?=$val_c->id ?>").css("display","block");
                       $("#jw_<?=$val_c->id ?>").css("display","block");
                  }
            
           });
           
           $('#notmmeet<?=$val_c->id ?>').on("click", function(){
//               alert('mee');
               var sale_value = $(this).val();
               
             if(sale_value === ''){
               $("#sale<?=$val_c->id ?>").css("display","none");
               $("#sample<?=$val_c->id ?>").css("display","none");
                $("#jw_<?=$val_c->id ?>").css("display","none");
                  }
                  else{
                      $("#sale<?=$val_c->id ?>").css("display","block");
                       $("#sample<?=$val_c->id ?>").css("display","block");
                       $("#jw_<?=$val_c->id ?>").css("display","block");
                  }
            
           });
    
           
           
           
           
      $(function(){
      var $eventSelect2= $('.select2').select2();
    
          $eventSelect2.on("change",function(e){
             
         var sample_value = $(this).val();
            
             if(sample_value != ''){
                   
               $("#meet<?=$val_c->id ?>").css("display","none");
               $("#notmmeet<?=$val_c->id ?>").css("display","none");
                  }
                  else{
                        
                     $("#meet<?=$val_c->id ?>").css("display","block");
                       $("#notmmeet<?=$val_c->id ?>").css("display","block");
                  } 

    });
         
         
 $('#datepicker_contact<?=$val_c->id ?>').datepicker({
              format:'dd-mm-yyyy',
              autoclose: true
    }) ; 
      $('#datepicker_doa<?=$val_c->id;?>').datepicker({
                            format:'dd-mm-yyyy',
                            autoclose:true
                      });
       $('#datepicker_dob<?=$val_c->id;?>').datepicker({
           format:'dd-mm-yyyy',
           autoclose:true
       })  ; 
       $('#datepicker_fup<?=$val_c->id;?>').datepicker({
           format:'dd-mm-yyyy',
           autoclose:true
       })  ; 
       $('#datepicker_doi<?=$val_c->id;?>').datepicker({
           format:'dd-mm-yyyy',
           startDate: '-7d',
            endDate: '+0d' ,
            autoclose:true
       })  ;
       
   
    });
          </script>
    <script type="text/javascript">   // for multipile model open
        $("#modal_add_dealer<?=$val_c->id ?>").on('hidden.bs.modal', function (event) {
            if ($('.modal:visible').length) //check if any modal is open
            {
              $('body').addClass('modal-open');//add class to body
            }
          });
        </script>        
      
   <!--Add dealer/pharmacy-->     
  <div class="modal modal-info fade" id="modal_add_dealer<?=$val_c->id ?>">
          <form id="<?=$val_c->id ?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Dealer/Sub Dealer</h4>
              </div>
              <div class="modal-body">
                  
                  
       <div class="form-group" id="d_list<?=$val_c->id ?>">
           <label>Dealer/pharmacy List</label>
           <?php
//           if(!empty($val_c->dealers_id)){
           ?>
           <select multiple="" id="dealer_id<?=$val_c->id ?>" name="dealer_id[]" class="form-control select5" style="width: 100%;">
                  
                <?php 
                foreach($dealer_data as $k_s => $val_s){
                    
                    /*for dealers id who belogs to this doctor*/
                                if(!empty(($val_c->dealers_id))){   
                                    $dealers_are = explode(',', $val_c->dealers_id);
                                }
                                else{
                                    $dealers_are=array();
                                }  
                    /*end of dealers id who belogs to this doctor */

                     if(in_array($val_s->dealer_id,$dealers_are)){
//                    if($val_s->blocked==0){
                ?>   
               <option value="<?=$val_s->dealer_id?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_s->dealer_id);} ?> selected=""><?=$val_s->dealer_name.','.$val_s->city_name;?></option>
                <?php  } else{
                if($val_s->status==TRUE){     ?>
                
                   <option value="<?=$val_s->dealer_id?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_s->dealer_id);} ?> ><?=$val_s->dealer_name.','.$val_s->city_name;?></option>
   
               <?php     
                } } } ?>
                  
                  
                  
                  <?php 
                foreach($pharma_list as $k_pl => $val_pl){
                    
                    /*for dealers id who belogs to this doctor*/
                                if(!empty(($val_c->dealers_id))){   
                                    $dealers_are = explode(',', $val_c->dealers_id);
                                }
                                else{
                                    $dealers_are=array();
                                }  
                    /*end of dealers id who belogs to this doctor */

                     if(in_array($val_pl['id'],$dealers_are)){
//                     if($val_pl['blocked']==0){
                ?>   
               <option value="<?=$val_pl['id']?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_pl['id']);} ?> selected=""><?=$val_pl['com_name'].', (Sub Dealer)';?></option>
                <?php }
                
                elseif($val_pl['status']==1){
                    
                 ?>
             <option value="<?=$val_pl['id']?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_pl['id']);} ?> ><?=$val_pl['com_name'].', (Sub Dealer)';?></option>

               <?php
                }
                
                
               } ?>
                  
                  
              <!--<option value="none" id="none" >NONE</option>-->

    </select> <br/>
                    <!--<button type="button" class="btn btn-warning"  data-toggle="modal" data-target="#modal_add_dealer<?=$val_c->id ?>">Add Dealer/Sub Dealer  </button>-->

                    
                      
           <?php // } ?>
<span class="control-label" id="dealer_id_help<?=$val_c->id ?>" for="inputError" style="color: red"><?php echo form_error('dealer_id'); ?></span>

</div>

                      
                  </div>
              
              
              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button id="submit" type="submit" class="btn btn-outline submit" >Save changes</button>
              </div>
            </div>
          </form>
          <?php // echo form_close(); ?>
            <!-- /.modal-content -->
          </div>

        
          
                                <?php } ?>
    
 
                    <!--<p><?php echo $links; ?></p>-->
            </div>
            <!-- /.box-body -->
         <!--</div>-->
          </div> <?php } // doctor search result close ?>
        
         
           <?php  if(!empty($pharmacy_info)){ ?> 
          <div class="box-body">
               <label>Sub Dealer </label>
                <!--<div class="table-responsive">-->
                    
                    <div class="table">
    
                            <div class="rowdivline header blue">
                              <div class="cell">
                               Sub Dealer Name
                              </div>
                              <div class="cell">
                                 Sub Dealer Email
                              </div>
                              <div class="cell">
                                Phone Number
                              </div>
                              <div class="cell">
                                City
                              </div>
                                <div class="cell">
                                Action
                              </div>
                            </div>
                    <?php
                               
                                 foreach($pharmacy_info as $k_p=>$val_p){
                                 ?>
                        
                                <div class="rowdivline">
                                  <div class="cell">
                                    <?=$val_p->com_name;?>
                                  </div>
                                  <div class="cell">
                                   <?=$val_p->com_email;?>
                                  </div>
                                  <div class="cell">
                                    <?=$val_p->com_ph;?>
                                  </div>
                                  <div class="cell">
                                    <?=$val_p->c_city;?>
                                  </div>
                                    <div class="cell">
                                      <a href="<?php echo base_url()."pharmacy/pharmacy/edit_pharmacy/".urisafeencode($val_p->id);?>"><button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                                    | <a href="<?php echo base_url()."pharmacy/pharmacy/view_pharmacy_for_interaction/". urisafeencode($val_p->id);?>"><button type="button" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                                     <!--   <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_info_doctor<?=$val_p->id ?>">
                 Interaction
                 </button> -->						<a href="<?php echo base_url()."pharmacy/pharmacy/pharma_interaction_sales/".urisafeencode($val_p->id);?>">												<button type="button" class="btn btn-info">Interaction</button>											</a>
               <!-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_info_appointment<?=$val_p->id ?>">
                 Appointment
                 </button> -->
                                    
<!--                     <?php if($val_p->status==1){ ?>   
                                    | <a href="<?php echo base_url()."pharmacy/pharmacy/inactive_pharmacy/".urisafeencode($val_p->id);?>" onclick="return confirm('Are you sure want to In-Active this pharmacy.')" class=""><button type="button" class="btn btn-success">Active</button></a>
                                        <?php } ?>
                   <?php if($val_p->status==0){ ?>  
                                    | <a href="<?php echo base_url()."pharmacy/pharmacy/active_pharmacy/".urisafeencode($val_p->id);?>" onclick="return confirm('Are you sure want to Active this pharmacy.')" class=""><button type="button" class="btn btn-warning">In-Active</button></a>
                                        <?php } ?>
                     <?php if($val_p->blocked==1){ ?>  
                                    | <a href="<?php echo base_url()."pharmacy/pharmacy/remain_pharmacy/".urisafeencode($val_p->id);?>" onclick="return confirm('Are you sure want to Remain this pharmacy.')" class=""><button type="button" class="btn btn-danger">Suspended</button></a>
                                        <?php } ?>
                   <?php if($val_p->blocked==0){ ?>  
                                    | <a href="<?php echo base_url()."pharmacy/pharmacy/blocked_pharmacy/".urisafeencode($val_p->id);?>" onclick="return confirm('Are you sure want to Suspend this pharmacy.')" class=""><button type="button" class="btn btn-success">Remain</button></a>
                                        <?php } ?>
                                    
                                    -->
                                    
                                    </div>
                                </div>
       
   <!--pharmacy Appointment-->
       <div class="modal modal-info fade" id="modal_info_appointment<?=$val_p->id ?>">
        <form role="form" method="post" action="<?php echo base_url()."appointment/appoint/save_appointment"?>" enctype= "multipart/form-data">

          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Appointment Add</h4>
              </div>
              <div class="modal-body">
                 <!--<div class="col-md-6">-->
                 <div class="form-group" >
                 <label>Sub Dealer name</label>
                 <input class="form-control" name="com_name" placeholder="Person Name..." type="text" value="<?=$val_p->com_name;?>" readonly="">               
                  <input class="c_id"  name="person_id" type="hidden" value="<?=$val_p->id;?>"> 
               <input class="dealer_view_id"  name="dealer_view_id" type="hidden" value="<?=$val_p->id;?>"> 
             <!--<span class="control-label" for="inputError" style="color: red"></span>-->
                 </div>
                 
                <div class="form-group">
                <label>DOA:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input class="form-control pull-right" name="doa" id="datepicker_doa<?=$val_p->id ?>" type="text">
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
                      
                  <div class="form-group">
                  <label>Reason to meet</label>
                  <textarea class="form-control" rows="3" name="reason" placeholder="Reason to meet ..."></textarea>
                </div>
                    
                
                  </div>  <!--End of contact edit modal-->
              
              
              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Save changes</button>
              </div>
            </div>
          
        </form>
              
            <!-- /.modal-content -->
          </div>
                        
          <!--Sub Dealer Interaction-->              
         <div class="modal modal-info fade" id="modal_info_doctor<?=$val_p->id ?>">
          <form role="form" method="post" onsubmit="return validateForm(<?="23".$val_p->id ?>)"  action="<?php echo base_url()."dealer/dealer/dealer_interaction"?>" enctype= "multipart/form-data">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Sub Dealer Interaction</h4>
              </div>
              <div class="modal-body">
                 <!--<div class="col-md-6">-->
                 <div class="form-group" >
                 <label>Sub Dealer name</label>
                 <input class="form-control" name="com_name" placeholder="Sub Dealer Name..." type="text" value="<?=$val_p->com_name;?>" readonly="">               
                 <input class="dealer_view_id"  name="dealer_view_id" type="hidden" value="<?=$val_p->id;?>"> 
                <input class="gd_id"  name="pharma_id" type="hidden" value="<?=$val_p->id;?>">                  
            <!--<span class="control-label" for="inputError" style="color: red"></span>-->
                 </div>
                 
                  <div class="form-group">
                    <label id="telephonic<?=$val_p->id ?>" style="display: block">Telephonic Interaction
                     <input name="telephonic" id="telephonic1" value="1" type="checkbox">
                    </label>
                   
                 </div>
       
                 <div class="form-group" id="jw_<?=$val_p->id ?>" style="display: block">
                     <label>Joint Working</label>
                     <select name="team_member[]" multiple="multiple" class="form-control select2" style="width: 100%;">
                          <!--<option value="">---Sample Name---</option>-->
                <?php 
                foreach($team_list as $k_tl => $val_tl){
                    
                ?>   
                  <option value="<?=$val_tl->userid?>" <?php if(isset($_POST['team_member'])){echo set_select('team_member',  $val_tl->userid);} ?>><?=$val_tl->username;?></option>
                  <?php }  ?>
              <!--<option value="none" id="none" >NONE</option>-->

                </select>
                </div>
                 
                 
                  <div class="form-group" >
                      <!--<label>Meeting Types *</label>-->
                      
                <table class="table table-bordered" style="background: #00c0ef;">
                <tbody><tr>
                  
                  <th>Meeting</th>
                  <th>Value</th>
                 
                </tr>
                
                <tr >
                  <td>Secondary Sale</td>
                  <td id="sale<?=$val_p->id ?>" style="display: block"><input class="form-control" id="sale_dealer<?=$val_p->id;?>" name="m_sale" placeholder="Sales info..." type="text" ></td>
                  
                </tr>
                <tr >
                  <td>Sample</td>
                  <td id="sample<?=$val_p->id ?>" style="display: block"><select name="m_sample[]" multiple="multiple" class="form-control select3" style="width: 100%;">
                          <option value="">---Sample Name---</option>
                <?php 
                foreach($ms as $k_ms => $val_ms){
                    
                ?>   
                  <option value="<?=$val_ms->id?>" <?php if(isset($_POST['m_sample'])){echo set_select('m_sample',  $val_ms->id);} ?>><?=$val_ms->sample_name;?></option>
                  <?php }  ?>
              <!--<option value="none" id="none" >NONE</option>-->

                </select> </td>
                 
                </tr>
                <tr >
                  <td>Met</td>
                  <td><div class="radio">
                    <label id="meet<?=$val_p->id ?>" style="display: block">
                      <input name="meet_or_not" id="optionsRadios1" value="1" type="radio">
                      Only Discussion
                    </label>
                  </div>
                  </td>
                  
                </tr>
                <tr >
                    <td>Not Met</td>
                    <td><div class="radio">
                    <label id="notmmeet<?=$val_p->id ?>" style="display: block">
                      <input name="meet_or_not" id="not_meet<?=$val_p->id ?>" value="0" type="radio">
                      Not Met
                    </label>
                  </div></td>
                </tr>
               
              </tbody></table>
                      

                  </div>  

       <div class="form-group" id="d_list<?=$val_p->id ?>" style="display: none">
           <label>Dealer List</label>
           
    <select id="pharmacy_dealers<?=$val_p->id ?>"  name="dealer_id" class="form-control select4" style="width: 100%;">
            <?php
           if(!empty($val_p->dealers_id)){
           ?>       
                <?php 
                foreach($dealer_data as $k_s => $val_s){
                    
                    /*for dealers id who belogs to this doctor*/
                                if(!empty(($val_p->dealers_id))){   
                                    $dealers_are = explode(',', $val_p->dealers_id);
                                }
                                else{
                                    $dealers_are=array();
                                }  
                    /*end of dealers id who belogs to this doctor */

                     if(in_array($val_s->dealer_id,$dealers_are)){
                    
                ?>   
                  <option value="<?=$val_s->dealer_id?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_s->dealer_id);} ?>><?=$val_s->dealer_name.','.$val_s->city_name;?></option>
                  <?php } } ?>
              <!--<option value="none" id="none" >NONE</option>-->
  <?php } ?>
    </select><br/>
         <button type="button" class="btn btn-warning"  data-toggle="modal" data-target="#modal_add_dealer<?=$val_p->id ?>">Add Dealer</button>
       
    <!--<a href="<?= base_url()?>pharmacy/pharmacy/edit_pharmacy/<?php echo urisafeencode($val_p->id); ?>" style="color: #fff"><button type="button" class="btn btn-warning">Add More Dealer </button></a>-->
          
          <?php // }else{ ?>
           <!--<button type="button" class="btn btn-warning"  data-toggle="modal" data-target="#modal_add_dealer<?=$val_p->id ?>">Add Dealer</button>-->
    
           <!--<a href="<?= base_url()?>pharmacy/pharmacy/edit_pharmacy/<?php echo urisafeencode($val_p->id); ?>" style="color: #fff"><button type="button" class="btn btn-warning">Add Dealer </button></a>-->
              
           
           <?php //} ?>  
    
</div>

                        <div class="form-group">
                            <label>Remark</label>
               
                     <textarea class="form-control" rows="3" name="remark" placeholder="About the Meeting ..."></textarea>

                        </div>
                
                      <div class="form-group" >
                          <label>Followup Action</label>
                   <input class="form-control" name="fup_a" id="datepicker_fup<?=$val_p->id ?>" type="text">
                      </div>
                 
                   <div class="form-group" >
                          <label>Date of Interaction</label>
                   <input class="form-control" name="doi_doc" id="datepicker_doi<?=$val_p->id ?>" type="text">
                     
                   </div>
                  
                      
                  </div>
              
              
              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Save changes</button>
              </div>
            </div>
          </form>
          
            <!-- /.modal-content -->
          </div>
<script type="text/javascript">   // for multipile model open
        $("#modal_add_dealer<?=$val_p->id ?>").on('hidden.bs.modal', function (event) {
            if ($('.modal:visible').length) //check if any modal is open
            {
              $('body').addClass('modal-open');//add class to body
            }
          });
        </script> 
          
       <script type="text/javascript">
           
           $(function(){
         $('.select2').select2();      
       var $eventSelect4= $('.select4').select2();
      var $eventSelect3 = $('.select3').select2();
    
          $eventSelect3.on("change",function(e){
            
         var sample_value = $(this).val();
            
             if(sample_value != ''){
                   
               $("#meet<?=$val_p->id ?>").css("display","none");
               $("#notmmeet<?=$val_p->id ?>").css("display","none");
                  }
                  else{
                        
                     $("#meet<?=$val_p->id ?>").css("display","block");
                       $("#notmmeet<?=$val_p->id ?>").css("display","block");
                  } 

    });
         
         
 $('#datepicker_contact<?=$val_p->id ?>').datepicker({
              format:'dd-mm-yyyy',
              autoclose: true
    }) ; 
      $('#datepicker_doa<?=$val_p->id;?>').datepicker({
                            format:'dd-mm-yyyy',
                            autoclose:true
                      });
       $('#datepicker_dob<?=$val_p->id;?>').datepicker({
           format:'dd-mm-yyyy',
           autoclose:true
       })  ; 
       $('#datepicker_fup<?=$val_p->id;?>').datepicker({
           format:'dd-mm-yyyy',
           autoclose:true
       })  ; 
        $('#datepicker_doi<?=$val_p->id;?>').datepicker({
            format:'dd-mm-yyyy',
            startDate: '-7d',
            endDate: '+0d' ,
            autoclose:true
       })  ; 
   
    });
           
           
           $('#sale_dealer<?=$val_p->id ?>').on("change", function(){
               
               var saledealer_value = $(this).val();
               
             if(saledealer_value === ''){
               $("#d_list<?=$val_p->id ?>").css("display","none");
                  }
                  else{
                      $("#d_list<?=$val_p->id ?>").css("display","block");
                  }
            
           });
           
            $('#sale<?=$val_p->id ?>').on("change", function(){
//               alert('mee');
               var sale_value = $(this).val();
               
             if(sale_value === ''){
               $("#meet<?=$val_p->id ?>").css("display","none");
               $("#notmmeet<?=$val_p->id ?>").css("display","none");
                  }
                  else{
                      $("#meet<?=$val_p->id ?>").css("display","block");
                       $("#notmmeet<?=$val_p->id ?>").css("display","block");
                  }
            
           });
    
       $('#meet<?=$val_p->id ?>').on("click", function(){
//               alert('mee');
               var sale_value = $(this).val();
               
             if(sale_value === ''){
               $("#sale<?=$val_p->id ?>").css("display","none");
               $("#sample<?=$val_p->id ?>").css("display","none");
                $("#jw_<?=$val_p->id ?>").css("display","none");
                  }
                  else{
                      $("#sale<?=$val_p->id ?>").css("display","block");
                       $("#sample<?=$val_p->id ?>").css("display","block");
                        $("#jw_<?=$val_p->id ?>").css("display","block");
                  }
            
           });
           
           $('#notmmeet<?=$val_p->id ?>').on("click", function(){
//               alert('mee');
               var sale_value = $(this).val();
               
             if(sale_value === ''){
               $("#sale<?=$val_p->id ?>").css("display","none");
               $("#sample<?=$val_p->id ?>").css("display","none");
                $("#jw_<?=$val_p->id ?>").css("display","none");
                  }
                  else{
                      $("#sale<?=$val_p->id ?>").css("display","block");
                       $("#sample<?=$val_p->id ?>").css("display","block");
                        $("#jw_<?=$val_p->id ?>").css("display","block");
                  }
            
           });
    
          $('#sale_dealer<?=$val_p->id ?>').on("change", function(){
               
               var sale_value = $(this).val();
               
             if(sale_value === ''){
               $("#d_list<?=$val_p->id ?>").css("display","none");
                  }
                  else{
                      $("#d_list<?=$val_p->id ?>").css("display","block");
                  }
            
           });  
       
          </script>
          
          
          <!--Add dealer for pharmacy interaction-->        
<div class="modal modal-info fade" id="modal_add_dealer<?=$val_p->id ?>">
          <form id="<?=$val_p->id ?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Dealer</h4>
              </div>
              <div class="modal-body">
                  
                  
       <div class="form-group" id="d_list<?=$val_p->id ?>">
           <label>Dealer List</label>
           <?php
//           if(!empty($val_p->dealers_id)){
           ?>
           <select multiple="" id="dealer_id<?=$val_p->id ?>" name="dealer_id[]" class="form-control select5" style="width: 100%;">
                  
                <?php 
                foreach($dealer_data as $k_s => $val_s){
                    
                    /*for dealers id who belogs to this doctor*/
                                if(!empty(($val_p->dealers_id))){   
                                    $dealers_are = explode(',', $val_p->dealers_id);
                                }
                                else{
                                    $dealers_are=array();
                                }  
                    /*end of dealers id who belogs to this doctor */

                     if(in_array($val_s->dealer_id,$dealers_are)){
//                    if($val_s->blocked==0){
                ?>   
               <option value="<?=$val_s->dealer_id?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_s->dealer_id);} ?> selected=""><?=$val_s->dealer_name.','.$val_s->city_name;?></option>
                <?php  } else{
                if($val_s->status==1){     ?>
                
                   <option value="<?=$val_s->dealer_id?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_s->dealer_id);} ?> ><?=$val_s->dealer_name.','.$val_s->city_name;?></option>
   
               <?php     
                } } } ?>
              
                  
              <!--<option value="none" id="none" >NONE</option>-->

    </select> <br/>
                    <!--<button type="button" class="btn btn-warning"  data-toggle="modal" data-target="#modal_add_dealer<?=$val_c->id ?>">Add Dealer/Sub Dealer  </button>-->

                    
                      
           <?php // } ?>
<span class="control-label" id="dealer_id_help<?=$val_p->id ?>" for="inputError" style="color: red"><?php echo form_error('dealer_id'); ?></span>

</div>

                      
                  </div>
              
              
              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button id="submitpharmacy" type="submit" class="btn btn-outline submitpharmacy" >Save changes</button>
              </div>
            </div>
          </form>
          <?php // echo form_close(); ?>
            <!-- /.modal-content -->
          </div>  
                                <?php } ?>
    
 
                    <!--<p><?php echo $links; ?></p>-->
            </div>
            <!-- /.box-body -->
         <!--</div>-->
          </div> <?php } // pharmacy search result close ?> 
         
         
         
      <?php  if(empty($d_info) && empty($doc_info) && empty($pharmacy_info)){  echo "No result Found"; } ?>
  
          
          
          
          
          
          
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>


 <!--Select2--> 
<script src="<?= base_url()?>design/bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
     var dp;
         var $eventSelect5= $('.select5').select2();
    
          $eventSelect5.on("change",function(e){
             
        var  dealer_pharma = $(this).val();
                    dp =  dealer_pharma;
         //alert(dealer_pharma);
           
    });
        
$(".submitpharmacy").click(function(){
      
        var newdealer_pharma =  dp;
   var formid = $(this).closest("form").attr('id'); 
      
   

   
//    alert(formid);

//var email = $("#email").val();
//var password = $("#password").val();
//var contact = $("#contact").val();
// Returns successful data submission message when the entered information is stored in database.
var dataString = 'dealers='+ newdealer_pharma+'&pharma_id='+formid;
if(newdealer_pharma=='' || formid=='')
{
alert("Please Fill All Fields");
}
else
{
// AJAX Code To Submit Form.
$.ajax({
type: "POST",
url: "<?= base_url()?>pharmacy/pharmacy/add_dealer_pharma",
data: dataString,
cache: false,
success: function(result){
        alert(result);
        $.ajax({
        type: "POST",
        url: "<?= base_url()?>pharmacy/pharmacy/pharmacy_dealer_list/"+formid,
        cache: false,
        success: function(result){
//            alert(result);
        $("#pharmacy_dealers"+formid).html(result);
        //$("#dealer_id"+formid).append(result);

        }
        });
}
});


}
return false;
});
});
    
    
    
    </script>

<script type="text/javascript">
    $(document).ready(function(){
     var dp;
         var $eventSelect5= $('.select5').select2();
    
          $eventSelect5.on("change",function(e){
             
        var  dealer_pharma = $(this).val();
                    dp =  dealer_pharma;
         //alert(dealer_pharma);
           
    });
        
$(".submit").click(function(){ // for doctor interaction add dealer/pharmacy
      
        var newdealer_pharma =  dp;
   var formid = $(this).closest("form").attr('id'); 
      
   

   
//    alert(formid);

//var email = $("#email").val();
//var password = $("#password").val();
//var contact = $("#contact").val();
// Returns successful data submission message when the entered information is stored in database.
var dataString = 'dealerpharma='+ newdealer_pharma+'&doctor_id='+formid;
if(newdealer_pharma=='' || formid=='')
{
alert("Please Fill All Fields");
}
else
{
// AJAX Code To Submit Form.
$.ajax({
type: "POST",
url: "<?php echo base_url() ?>doctors/doctor/add_dealer_pharma",
data: dataString,
cache: false,
success: function(result){
            alert(result);

            $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>doctors/doctor/dealer_pharma_list/"+formid,
            cache: false,
            success: function(result){
            //    alert(result);
            $("#doc_dealer_pharma"+formid).html(result);
            //$("#dealer_id"+formid).append(result);

            }
            });

}
});


}
return false;
});
});
    
    
    
    </script>
