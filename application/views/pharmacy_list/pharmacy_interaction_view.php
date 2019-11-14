<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

  $pharmacy_info = json_decode($edit_pharmacy_list);
   $ms = json_decode($meeting_sample);
  $dealer_data = json_decode($dealer_list);   // for all active dealers 

  $team_list=json_decode($users_team);  // show child and boss users

  
  $pharma_int_info  = json_decode($interaction_info_pharmacy);
  
//   pr($team_list); die;

?>
<link href="<?= base_url()?>design/css/div_table/one.css" rel="stylesheet" type="text/css"/>
<link href="<?= base_url()?>design/css/div_table/custom_table.css" rel="stylesheet" type="text/css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="<?= base_url()?>design/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<style>
@media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px)  {
		/*
		Label the data
		*/

		td:nth-of-type(1):before { content: "Interaction By"; }
		td:nth-of-type(2):before { content: "Dealer"; }
	/*	td:nth-of-type(3):before { content: "Secondary Sale"; }
		td:nth-of-type(4):before { content: "Met/Not Met"; }
		td:nth-of-type(5):before { content: "Sample Name"; }
		td:nth-of-type(6):before { content: "Remark"; }*/
		td:nth-of-type(7):before { content: "Follow up Date"; }
		td:nth-of-type(7):before { content: "Interaction Date"; }
	}

</style>

<div class="content-wrapper modal-open">
     <?php echo get_flash(); ?>
    <section class="content">
<div class="box box-default color-palette-box">
      <!-- COLOR PALETTE -->
      <div class="box box-default color-palette-box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-tag"></i>Sub Dealer Information</h3>
          
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-sm-4">
              <!--<h4 class="text-center">Name</h4>-->

              <div class="color-palette-set">
                  <strong> Name: </strong><?=$pharmacy_info->com_name;?>
                
              </div>
            </div>
            <!-- /.col -->
            <div class="col-sm-4">
             

              <div class="color-palette-set">
                  <strong> Email:</strong><?=$pharmacy_info->com_email;?>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-sm-4">
             

              <div class="color-palette-set">
                  <strong> Contact Number: </strong><?=$pharmacy_info->com_ph;?>
              </div>
            </div>
            <!-- /.col -->
            
          </div>
          <!-- /.row -->
          <div class="row">
                   <!-- /.col -->
            <div class="col-sm-4">
            
              <div class="color-palette-set">
                  <strong>City : </strong><?=$pharmacy_info->city_name;?>
              </div>
            </div>
            <!-- /.col -->
            
          </div>
          <div class="row">
              <div class="col-md-6">
                  
              </div>
              <div class="col-md-6">
              <div class="box-tools pull-right">
              
<!--              <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_add_doctor">
                Add Doctor
              </button>-->
              <?php if(!empty($pharmacy_info)){?>
              <!--<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_add_appointment">
                Add Appointment
              </button>
              <button style="margin: 6px;" type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_info_pharmacy">
                Interaction
              </button>-->			  <a href="<?php echo base_url()."pharmacy/pharmacy/pharma_interaction_sales/".urisafeencode($pharmacy_info->id);?>">						<button type="button" class="btn btn-info">Interaction</button></a>
              <?php }?>
              </div>
          </div>
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div></div>
        
        
        <!--Add Appointment-->
        <div class="modal modal-info fade" id="modal_add_appointment">
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
                <label>Sub Dealer name</label>
                 <input class="form-control" name="com_name" placeholder="Person Name..." type="text" value="<?=$pharmacy_info->com_name;?>" readonly="">               
                  <input class="dealer_view_id"  name="person_id" type="hidden" value="<?=$pharmacy_info->id;?>"> 
                <!--<input class="gd_id"  name="gd_id" type="hidden" value="">-->                  
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
          </div>
        
        
        <!--Sub Dealer Interaction-->
        
        <div class="modal modal-info fade" id="modal_info_pharmacy">
          <form role="form" method="post" onsubmit="return validateForm(<?="23".$pharmacy_info->id ?>)"  action="<?php echo base_url()."dealer/dealer/dealer_interaction"?>" enctype= "multipart/form-data">
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
                 <input class="form-control" name="com_name" placeholder="Sub Dealer Name..." type="text" value="<?=$pharmacy_info->com_name;?>" readonly="">               
                 <input class="dealer_view_id"  name="dealer_view_id" type="hidden" value="<?=$pharmacy_info->id;?>"> 
                <input class="gd_id"  name="pharma_id" type="hidden" value="<?=$pharmacy_info->id;?>">                  
            <!--<span class="control-label" for="inputError" style="color: red"></span>-->
                 </div>
                 
                 <div class="form-group">
                    <label id="telephonic<?=$pharmacy_info->id ?>" style="display: block">Telephonic Interaction
                     <input name="telephonic" id="telephonic1" value="1" type="checkbox">
                    </label>
                   
                 </div>
                 
                 <div class="form-group" id="jw_<?=$pharmacy_info->id ?>" style="display: block">
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
                      <!--<label>Meeting Types *</label>-->
                      
                <table class="table table-bordered" style="background: #00c0ef;">
                <tbody><tr>
                  
                  <th>Meeting</th>
                  <th>Value</th>
                 
                </tr>
                
                <tr >
                  <td>Secondary Sale</td>
                  <td id="sale<?=$pharmacy_info->id ?>" style="display: block"><input class="form-control" id="sale_dealer<?=$pharmacy_info->id;?>" name="m_sale" placeholder="Sales info..." type="text" ></td>
                  
                </tr>
                <tr >
                  <td>Sample</td>
                  <td id="sample<?=$pharmacy_info->id ?>" style="display: block"><select name="m_sample[]" multiple="multiple" class="form-control select2" style="width: 100%;">
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
                    <label id="meet<?=$pharmacy_info->id ?>" style="display: block">
                      <input name="meet_or_not" id="optionsRadios1" value="1" type="radio">
                      Only Discussion
                    </label>
                  </div>
                  </td>
                  
                </tr>
                <tr >
                    <td>Not Met</td>
                    <td><div class="radio">
                    <label id="notmmeet<?=$pharmacy_info->id ?>" style="display: block">
                      <input name="meet_or_not" id="not_meet<?=$pharmacy_info->id ?>" value="0" type="radio">
                      Not Met
                    </label>
                  </div></td>
                </tr>
               
              </tbody></table>
                      

                  </div>  

       <div class="form-group" id="d_list<?=$pharmacy_info->id ?>" style="display: none">
           <label>Dealer List</label>
            <?php
           if(!empty($pharmacy_info->id)){
           ?>
    <select id="pharmacy_dealers<?=$pharmacy_info->id?>" name="dealer_id" class="form-control select4" style="width: 100%;">
                  
                <?php 
                foreach($dealer_data as $k_s => $val_s){
                    
                    /*for dealers id who belogs to this doctor*/
                                if(!empty(($pharmacy_info->dealers_id))){   
                                    $dealers_are = explode(',', $pharmacy_info->dealers_id);
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

                </select><br/>
                
         <button type="button" class="btn btn-warning"  data-toggle="modal" data-target="#modal_add_dealer<?=$pharmacy_info->id ?>">Add Dealer</button>
            
            <!--<a href="<?= base_url()?>pharmacy/pharmacy/edit_pharmacy/<?php echo urisafeencode($pharmacy_info->id); ?>" style="color: #fff"><button type="button" class="btn btn-warning">Add More Dealer </button></a>-->
          
          <?php }else{ ?>
         
         <button type="button" class="btn btn-warning"  data-toggle="modal" data-target="#modal_add_dealer<?=$pharmacy_info->id ?>">Add Dealer</button>
    
           <!--<a href="<?= base_url()?>pharmacy/pharmacy/edit_pharmacy/<?php echo urisafeencode($pharmacy_info->id); ?>" style="color: #fff"><button type="button" class="btn btn-warning">Add Dealer </button></a>-->
              
           
           <?php } ?>  
           
           
           
           
    
</div>

                        <div class="form-group">
                            <label>Remark</label>
               
                     <textarea class="form-control" rows="3" name="remark" placeholder="About the Meeting ..."></textarea>

                        </div>
                
                      <div class="form-group" >
                          <label>Followup Action</label>
                   <input class="form-control" name="fup_a" id="datepicker_fup<?=$pharmacy_info->id ?>" type="text">
                      </div>

                      <div class="form-group" >
                          <label>Date of Interaction</label>
                   <input class="form-control" name="doi_doc" id="datepicker_doi<?=$pharmacy_info->id ?>" type="text">
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
    
     
   <!--Add dealer-->        
<div class="modal modal-info fade" id="modal_add_dealer<?=$pharmacy_info->id ?>">
          <form id="<?=$pharmacy_info->id ?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Dealer</h4>
              </div>
              <div class="modal-body">
                  
                  
       <div class="form-group" id="d_list<?=$pharmacy_info->id ?>">
           <label>Dealer List</label>
           <?php
//           if(!empty($pharmacy_info->dealers_id)){
           ?>
           <select multiple="" id="dealer_id<?=$pharmacy_info->id ?>" name="dealer_id[]" class="form-control select5" style="width: 100%;">
                  
                <?php 
                foreach($dealer_data as $k_s => $val_s){
                    
                    /*for dealers id who belogs to this doctor*/
                                if(!empty(($pharmacy_info->dealers_id))){   
                                    $dealers_are = explode(',', $pharmacy_info->dealers_id);
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
<span class="control-label" id="dealer_id_help<?=$pharmacy_info->id ?>" for="inputError" style="color: red"><?php echo form_error('dealer_id'); ?></span>

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
        
        
          <?php if(!empty($pharma_int_info)){ ?>
      <!--<h2 class="page-header">Interaction</h2>-->
      <div class="row">
        <div class="col-md-12">
            <div class="box box-default collapsed-box">
                
         <div class="box-header with-border">
             <h3  class="box-title">Interaction List</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
            <!--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>-->
          </div>
        </div>
            <!-- /.box-header -->
            <div class="box-body">
                
               <table id="example2" class="table table-bordered table-striped">
                <thead>
					<tr>
						<th> Interaction By </th>
						<th> Dealer</th>
						<!-- <th> Secondary Sale</th>
						<th> Met/Not Met</th>
						<th> Sample Name</th>
						<th> Remark</th> -->
						<th> Follow up Date</th>
						<th>Interaction Date</th>
					</tr>
                </thead>
                <tbody>
                 <?php
                 if(!empty($pharma_int_info)){
                  foreach($pharma_int_info as $k_si=>$val_si){
                  ?>
				  <tr>
                    <td><?=$val_si->interactionBy;?> </td>
                    <td><?=$val_si->deal_name;?> </td>
                    <!-- <td><?=$val_si->meeting_sale;?> </td>
                    <td>
                                    <?php
                                    if($val_si->meet_or_not_meet==TRUE){
                                     echo "Yes";   
                                    }
                                    else if($val_si->meet_or_not_meet==FALSE && $val_si->meet_or_not_meet!=NULL){
                                         echo "No";
                                    }
                                    
                                    ?>
                     </td>
                     <td> <?=$val_si->sample_name->sample_name;?> </td>
                     <td><?=$val_si->remark;?> </td> -->
                    <td><?= $val_si->follow_up_action!=NULL ? date('d-M-Y',strtotime($val_si->follow_up_action)):'';?> </td>
					<td><?=date('d-M-Y',strtotime($val_si->date_of_interaction));?> </td>
				 </tr>
                    <?php  } } ?>
                     <?php if(!empty($doci_info)){ foreach($doci_info as $k_ci=>$val_ci){ ?>
                    <tr>
                         <td> <?=$val_ci->d_name;?> </td>
                         <td><?=$val_ci->username;?> </td>
                         <!-- <td><?=$val_ci->mmt_name;?> </td>
                         <td> <?=$val_ci->remark;?> </td>
                         <td> <?=$val_ci->additional_remark;?> </td> -->
                         <td><?=date('m/d/Y',strtotime($val_ci->follow_up_action));?> </td>
					 </tr>
                     <?php  } } ?>
				</tbody>
             </table>
    
  </div>
                
                
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

     </div> <?php } ?>
        
        
        
        
    </section>
    
</div>

<script type="text/javascript">   // for multipile model open
        $("#modal_add_dealer<?=$pharmacy_info->id ?>").on('hidden.bs.modal', function (event) {
            if ($('.modal:visible').length) //check if any modal is open
            {
              $('body').addClass('modal-open');//add class to body
            }
          });
        </script> 

<script type="text/javascript">
    
    
    
           $('#sale_dealer<?=$pharmacy_info->id ?>').on("change", function(){
               
               var sale_value = $(this).val();
               
             if(sale_value === ''){
               $("#d_list<?=$pharmacy_info->id ?>").css("display","none");
                  }
                  else{
                      $("#d_list<?=$pharmacy_info->id ?>").css("display","block");
                  }
            
           });
           
            $('#sale<?=$pharmacy_info->id ?>').on("change", function(){
//               alert('mee');
               var sale_value = $(this).val();
               
             if(sale_value === ''){
               $("#meet<?=$pharmacy_info->id ?>").css("display","none");
               $("#notmmeet<?=$pharmacy_info->id ?>").css("display","none");
                  }
                  else{
                      $("#meet<?=$pharmacy_info->id ?>").css("display","block");
                       $("#notmmeet<?=$pharmacy_info->id ?>").css("display","block");
                  }
            
           });
    
       $('#meet<?=$pharmacy_info->id ?>').on("click", function(){
//               alert('mee');
               var sale_value = $(this).val();
               
             if(sale_value === ''){
               $("#sale<?=$pharmacy_info->id ?>").css("display","none");
               $("#sample<?=$pharmacy_info->id ?>").css("display","none");
                $("#jw_<?=$pharmacy_info->id ?>").css("display","none");
                  }
                  else{
                      $("#sale<?=$pharmacy_info->id ?>").css("display","block");
                       $("#sample<?=$pharmacy_info->id ?>").css("display","block");
                        $("#jw_<?=$pharmacy_info->id ?>").css("display","block");
                  }
            
           });
           
           $('#notmmeet<?=$pharmacy_info->id ?>').on("click", function(){
//               alert('mee');
               var sale_value = $(this).val();
               
             if(sale_value === ''){
               $("#sale<?=$pharmacy_info->id ?>").css("display","none");
               $("#sample<?=$pharmacy_info->id ?>").css("display","none");
                $("#jw_<?=$pharmacy_info->id ?>").css("display","none");
                  }
                  else{
                      $("#sale<?=$pharmacy_info->id ?>").css("display","block");
                       $("#sample<?=$pharmacy_info->id ?>").css("display","block");
                       $("#jw_<?=$pharmacy_info->id ?>").css("display","block");
                  }
            
           });
    
           
           
           
           
      $(function(){
       $('.select2').select2();
      var $eventSelect3= $('.select4').select2();
    
          $eventSelect3.on("change",function(e){
             
         var sample_value = $(this).val();
            
             if(sample_value != ''){
                   
               $("#meet<?=$pharmacy_info->id ?>").css("display","none");
               $("#notmmeet<?=$pharmacy_info->id ?>").css("display","none");
                  }
                  else{
                        
                     $("#meet<?=$pharmacy_info->id ?>").css("display","block");
                       $("#notmmeet<?=$pharmacy_info->id ?>").css("display","block");
                  } 

    });
         
         
 $('#datepicker_contact<?=$pharmacy_info->id ?>').datepicker({
              format:'dd-mm-yyyy',
              autoclose: true
    }) ; 
      $('#datepicker_doa<?=$pharmacy_info->id;?>').datepicker({
                            format:'dd-mm-yyyy',
                            autoclose:true
                      });
       $('#datepicker_dob<?=$pharmacy_info->id;?>').datepicker({
           format:'dd-mm-yyyy',
           autoclose:true
       })  ; 
       $('#datepicker_fup<?=$pharmacy_info->id;?>').datepicker({
           format:'dd-mm-yyyy',
           autoclose:true
       })  ; 
         $('#datepicker_doi<?=$pharmacy_info->id;?>').datepicker({
            format:'dd-mm-yyyy',
            startDate: '-7d',
            endDate: '+0d' ,
            autoclose:true
       })  ;
       
   
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
        
$(".submit").click(function(){
      
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
	  $(function () {
		$('#example2').DataTable({
		  'responsive' : true,
		  'paging'      : true,
		  'lengthChange': true,
		  'searching'   : true,
		  'ordering'    : true,
		  'info'        : true,
		  'autoWidth'   : true,
		});
	  });

	</script>