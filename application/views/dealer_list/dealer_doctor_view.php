<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$dealer_info=json_decode($edit_dealer_list);
//pr($dealer_info); die;
$doc_info=json_decode($doctor_of_dealer);  // for doctor details

 $team_list=json_decode($users_team);  // show child and boss users

if(isset($pharmacy_of_dealer)){
$pharmacy_info=json_decode($pharmacy_of_dealer);  // for pharmacy details
}
 $dealer_data = json_decode($dealer_list);   // for all active dealers 
 
 $ms = json_decode($meeting_sample);
 if(isset($appointment_of_dealer)){
   $dealer_appointment_info = json_decode($appointment_of_dealer);     
 }
// pr($dealer_appointment_info); die;

 if(isset($group_name) && !empty($group_name)){
 $group_dealer_name = json_decode($group_name);
  }
  else{
      $group_dealer_name='';
  }
 if(!empty($interaction_info_dealer)){
    $di_info= json_decode($interaction_info_dealer); 
 }
 else{
     $di_info=NULL;
 }
 
 if(!empty($interaction_info_doctor)){
    $doc_int_info= json_decode($interaction_info_doctor); 
 }
 else{
     $doc_int_info=NULL;
 }
 
  if(!empty($interaction_info_pharmacy)){
    $pharma_int_info= json_decode($interaction_info_pharmacy); 
 }
 else{
     $pharma_int_info=NULL;
 }
 
 
// pr($interaction_info_contact); die;
 
if(!empty($dealer_info->gd_id)){
  
    $dealer_of_group = json_decode($dealers);
//    pr($dealer_of_group); die;
}


$mm_name = json_decode($main_meeting_name);

  $state_data=json_decode($statename);
//pr($meeting_name); die;

?>
<link href="<?= base_url()?>design/css/div_table/one.css" rel="stylesheet" type="text/css"/>
<link href="<?= base_url()?>design/css/div_table/custom_table.css" rel="stylesheet" type="text/css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="<?= base_url()?>design/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<style>
@media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px)  {
		/* Label the data	*/
		.example2 td:nth-of-type(1):before { content: "Name"; }
		.example2 td:nth-of-type(2):before { content: "Email"; }
		.example2 td:nth-of-type(3):before { content: "Phone Number"; }
		.example2 td:nth-of-type(4):before { content: "Action"; }
		
		#example4 td:nth-of-type(1):before { content: "Interaction With"; }
		#example4 td:nth-of-type(2):before { content: "Interaction By"; }
		/*#example4 td:nth-of-type(3):before { content: "Sale"; }
		#example4 td:nth-of-type(4):before { content: "Payment"; }
		#example4 td:nth-of-type(5):before { content: "Stock"; }
		#example4 td:nth-of-type(6):before { content: "Met/Not Met"; }
		#example4 td:nth-of-type(7):before { content: "Remark"; }*/
		#example4 td:nth-of-type(3):before { content: "Follow up Date"; }
		#example4 td:nth-of-type(4):before { content: "Interaction Date"; }
		
		.example5 td:nth-of-type(1):before { content: "Interaction With"; }
		.example5 td:nth-of-type(2):before { content: "Interaction By"; }
		/*.example5 td:nth-of-type(3):before { content: "Sale"; }
		.example5 td:nth-of-type(4):before { content: "Met/Not Met"; }
		.example5 td:nth-of-type(5):before { content: "Sample Name"; }
		.example5 td:nth-of-type(6):before { content: "Remark"; }*/
		.example5 td:nth-of-type(3):before { content: "Follow up Date"; }
		.example5 td:nth-of-type(4):before { content: "Interaction Date"; }
	}

</style>

<div class="content-wrapper">
    <?php echo get_flash();?>
    <!-- Main content -->
    <section class="content">
        <!--group dealer information-->
         <?php
  //pr($dealer_of_group); die;
       //if(!empty($group_dealer_name)){
       if(False){
      ?>
      
      <!-- END ALERTS AND CALLOUTS -->     
      <div class="box box-default color-palette-box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-tag"></i>C & F Name</h3>
          
            <!-- /.box-header -->
            <div class="box-body">
                
                <div class="table">
    
                        <div class="rowdivline header">
                          <div class="cell">
                            Name
                          </div>
                          <div class="cell">
                            Email
                          </div>
                          <div class="cell">
                            Phone Number
                          </div>
                          <div class="cell">
                            City Name
                          </div>
                            <div class="cell">
                            Action
                          </div>
                        </div>
                    <?php            
                  foreach($group_dealer_name as $k_gs=>$val_gs){
                  ?>
                            <div class="rowdivline">
                              <div class="cell">
                                <?=$val_gs->d_name;?>
                              </div>
                              <div class="cell">
                                <?=$val_gs->email;?>
                              </div>
                              <div class="cell">
                                <?=$val_gs->d_ph;?>
                              </div>
                              <div class="cell">
                                <?=$val_gs->city_name;?>
                              </div>
                                <div class="cell">
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_info_editgroup<?=$val_gs->id ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button> 
                             | <a href="<?php echo base_url()."dealer/dealer/view_group_dealer_for_doctor/". urisafeencode($val_gs->id);?>"><button type="button" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
<!--                  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_info_groupname<?=$val_gs->id ?>">
                 Interaction
                 </button> 
                 <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_info_groupappointment<?=$val_gs->id ?>">
                 Appointment
                 </button>  -->
                                </div>
                            </div>
                    
            
        <div class="modal modal-info fade" id="modal_info_editgroup<?=$val_gs->id ?>">
            
         <form role="form" method="post" action="<?php echo base_url()."dealer/dealer/add_group_dealer/".urisafeencode($val_gs->id)?>" enctype= "multipart/form-data">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Dealer Edit</h4>
              </div>
              <div class="modal-body">
                 <!--<div class="col-md-6">-->
                 <div class="form-group" id="group_dealer_state">
             
                <label>Dealer State</label>
                 
         <select name="dealer_state" id="group_dealer_state<?=$val_gs->id;?>"  class="form-control select5" style="width: 100%;">
                  <option value="">--State--</option>
                <?php 
                foreach($state_data as $k_st => $val_st){
                    if($val_st->state_id==$val_gs->state_id){
                ?>   
                  <option value="<?=$val_st->state_id?>" selected="" ><?=$val_st->state_name;?></option>

                    <?php } else{?>
                  <option value="<?=$val_st->state_id?>" <?php if(isset($_POST['dealer_state'])){echo set_select('dealer_state',  $val_st->state_id);} ?>  ><?=$val_st->state_name;?></option>
                <?php } }  ?>
                  
                </select>
            <span class="control-label" for="inputError" style="color: red"><?php echo form_error('dealer_state'); ?></span>

                   </div>
                 
                 
                 <div class="form-group">
             
                <label>Dealer City</label>
                 
         <select name="dealer_city" id="group_dealer_city<?=$val_gs->id;?>"  class="form-control select1" style="width: 100%;">
                  <option value="<?=$val_gs->city_id?>"><?=$val_gs->city_name?></option>
                <?php 
//                foreach($city_data as $k_c => $val_c){
                ?>   
                  <!--<option value="<?=$val_c->city_id?>" <?php // if(isset($_POST['dealer_city'])){echo set_select('dealer_city',  $val_c->city_id);} ?>  ><?= $val_c->city_name;?></option>-->
                <?php // } ?>
                  
                </select>
            <span class="control-label" for="inputError" style="color: red"><?php echo form_error('group_dealer_city'); ?></span>

              </div>
       
<!--                 </div>
                  <div class="col-md-6">-->
                 <div class="form-group">
                <label>Email address</label>
                <?php
                if(empty($val_gs->gd_id)){
                ?>
                  <input class="form-control" name="dealer_email" placeholder="Enter email ..." type="email" value="<?=$val_gs->email?>">
                <span class="help-block" for="inputError" style="color: red"><?php echo form_error('dealer_email'); ?></span>
                      <?php }else{ ?>
               <input class="form-control" name="group_dealer_email" placeholder="Enter email ..." type="email" value="<?=$val_gs->email?>">
              
               <span class="help-block" for="inputError" style="color: red"><?php echo form_error('group_dealer_email'); ?></span>
 
             <?php } ?>
                </div>

              <div class="form-group">
                <label>Dealer Name</label>
                 <?php
                if(empty($val_gs->gd_id)){
                ?>
                 <!--<input class="form-control" name="dealer_id" placeholder="Enter Dealer name..." type="hidden" value="<?=$val_gs->id?>">-->

                <input class="form-control" name="dealer_name" placeholder="Enter Dealer name..." type="text" value="<?=$val_gs->d_name?>">
                <?php }else{ ?>
                 <!--<input class="form-control" name="group_dealer_id" placeholder="Enter Dealer name..." type="hidden" value="<?=$val_gs->id?>">-->

                <input class="form-control" name="group_dealer_name" placeholder="Enter Dealer name..." type="text" value="<?=$val_gs->d_name?>">
                <?php }?>
              
              </div>
                      
              <div class="form-group">
                 <label>Contact Number</label>
                 <?php
                if(empty($val_gs->gd_id)){
                ?>
                  <input class="form-control" name="dealer_num" placeholder="Enter Phone number..." type="text" value="<?=$val_gs->d_ph;?>">
                <?php }else{ ?>
                 <input class="form-control" name="group_dealer_num" placeholder="Enter Phone number..." type="text" value="<?=$val_gs->d_ph;?>">
               <span class="help-block" for="inputError" style="color: red"><?php echo form_error('group_dealer_num'); ?></span>
 
            <?php } ?>
                 <!--<span class="help-block" for="inputError" style="color: red"><?php echo form_error('dealer_num'); ?></span>-->
              </div>
                      
                                    
               <div class="form-group">
                 <label>Alternate Contact Number</label>
                  <input class="form-control" name="dealer_alt_num" placeholder="Enter Alternate Phone number..." type="text" value="<?=$val_gs->alt_phone ?>">
             
                <!--<span class="help-block" for="inputError" style="color: red"><?php //echo form_error('dealer_num'); ?></span>-->

              </div>
                    <div class="form-group">
                  <label>About the Dealer</label>
                  
                   <?php
                if(empty($val_gs->gd_id)){
                ?>
                 
                  
                  <textarea class="form-control" rows="3" name="about_s" placeholder="About the Dealer ..."><?=$val_gs->d_about?></textarea>
                
                <?php } else{?>
                       <textarea class="form-control" rows="3" name="group_about_d" placeholder="About the Dealer ..."><?=$val_gs->d_about?></textarea>
                <?php }?>
                 </div>

                <div class="form-group">
                  <label>Dealer Address</label>
                  <textarea class="form-control" rows="3" name="d_address" placeholder="Dealer Address ..."><?=$val_gs->d_address?></textarea>
                </div>

                      
                  </div> <!--/ modal end-->
              
              
              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-outline"  value="Save changes">
              </div>
            </div>
          
              </form>
            <!-- /.modal-content -->
          </div>
                      

     <script type="text/javascript">
      $(function(){             
 $('#datepickerf<?=$val_gs->id ?>').datepicker({
              autoclose: true
    }) 
    
    $('#datepickerdo_in<?=$val_gs->id ?>').datepicker({
              autoclose: true
    }) 
    });
          </script>                 
                      
                 <?php }  ?>
    
    
  </div>
           
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
      </div>
      
      <?php } ?>
        
        
        <!--/ end group dealer info-->
         
       <div class="box box-default color-palette-box">
      <!-- COLOR PALETTE -->
      <div class="box box-default color-palette-box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-tag"></i><?php if(!empty($dealer_of_group)){ echo "C & F Information";} else{ echo "Dealer Information";} ?></h3>
          
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-sm-4">
              <!--<h4 class="text-center">Name</h4>-->

              <div class="color-palette-set">
                  <strong> Name: </strong><?=$dealer_info->dealer_name;?>
                
              </div>
            </div>
            <!-- /.col -->
            <div class="col-sm-4">
             

              <div class="color-palette-set">
                  <strong> Email:</strong><?=$dealer_info->d_email;?>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-sm-4">
             

              <div class="color-palette-set">
                  <strong> Contact Number: </strong><?=$dealer_info->d_ph;?>
              </div>
            </div>
            <!-- /.col -->
            
          </div>
          <!-- /.row -->
          <div class="row">
                   <!-- /.col -->
            <div class="col-sm-4">
            
              <div class="color-palette-set">
                  <strong>About: </strong><?=$dealer_info->d_about;?>
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
              <?php if(empty($dealer_info->gd_id)){?>
              <!--<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_add_appointment">
                Add Appointment
              </button>-->
              <a href="<?php echo base_url()."dealer/dealer/dealer_interaction_sales/".urisafeencode($dealer_info->d_id);?>">
				<button type="button" class="btn btn-info">Interaction</button></a>
              <?php }?>
              </div>
          </div>
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div></div>
      <!-- /.box -->
              <!-- /.modal-dialog -->
        <!--</div>-->
        
       <?php if(!empty($dealer_appointment_info) || isset($dealer_appointment_info)){ ?>
        <div class="col-md-12">
                    <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-info"></i>You have an Appointment with this Dealer!</h4>
                <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                  <th>Date of appointment</th>
                  <th>Time of appointment</th>
                  <th>Reason to Meet</th>
                  
                </tr>  
                  </thead>
                  <tbody>
                    <?php
                        
                        foreach ($dealer_appointment_info as $k_sap => $val_sap) {
                      ?>                    
                    
                <tr>
                    <td><?=date('D d-m-Y', strtotime($val_sap->doa));?></td>
                  <td><?=date('h:i A', strtotime($val_sap->toa))?></td>
                  <td>
                   <?=$val_sap->reason_to_meet;?>
                  </td>
                </tr>
                        <?php 
                        
                          } // appointment loop

                        ?>
                
                  </tbody></table></div>
              </div>
                </div>
        
       <?php } ?>
        
        
      <?php
       if(!empty($doc_info)){
      ?>
      
      <!-- START ALERTS AND CALLOUTS -->
      <!--<h2 class="page-header">Contact of this Dealer</h2>-->

      <div class="row">
        <div class="col-md-12">

         <div class="box box-default collapsed-box">
                
         <div class="box-header with-border">
             <h3  class="box-title">Doctor List</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
            <!--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>-->
          </div>
        </div>
            <!-- /.box-header -->
            <div class="box-body">
			
			<table id="example2" class="table table-bordered table-striped example2">
                <thead>
					<tr>
						<th> Name </th>
						<th> Email</th>
						<th> Phone Number</th>
						<th> Action</th>
					</tr>
                </thead>
                <tbody>
				<?php foreach($doc_info as $k_c=>$val_c){ ?> 
				<tr>
                    <td> <?=$val_c->d_name;?></td>
					<td><?=$val_c->d_email;?></td>
					<td><?=$val_c->d_ph;?></td>
					<td>
           <!--<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_info_edit_doctor<?=$val_c->id ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </button>-->
                                              <!--| <a href="<?php echo base_url()."contact/contact/del_doctor/".urisafeencode($val_c->id);?>" onclick="return confirm('Are you sure want to delete this record.')" class=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>-->	
			
			<a href="<?php echo base_url()."doctors/doctor/doctor_interaction_sales/".urisafeencode($val_c->id);?>">				<button type="button" class="btn btn-info">Interaction</button>	</a>								  
                 <!-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_info_doctor<?=$val_c->id ?>">
                 Interaction
                 </button>
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_info_appointment<?=$val_c->id ?>">
                 Appointment
                 </button>-->
				 </td>
			</tr>
          <?php }  ?>
    
		 </tbody>
       </table>
  </div>
                
                

          
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

      </div>
      <?php } ?>
      <!-- /.row -->
   
 
     
      <?php
       if(!empty($pharmacy_info)){
      ?>
      
      <!-- START ALERTS AND CALLOUTS -->
      <!--<h2 class="page-header">Contact of this Dealer</h2>-->

      <div class="row">
        <div class="col-md-12">

         <div class="box box-default collapsed-box">
                
         <div class="box-header with-border">
             <h3  class="box-title">Retail Sub Dealer List</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
            <!--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>-->
          </div>
        </div>
            <!-- /.box-header -->
            <div class="box-body">
                
          <table id="example3" class="table table-bordered table-striped example2">
			<thead>
					<tr>
						<th> Name </th>
						<th> Email</th>
						<th> Phone Number</th>
						<th> Action</th>
					</tr>
                </thead>
			<tbody>
			 <?php foreach($pharmacy_info as $k_c=>$val_c){?> 
				<tr>
				 <td><?=$val_c->com_name;?></td>
				  <td><?=$val_c->com_email;?></td>
				  <td><?=$val_c->com_ph;?></td>
					<td>
				   <!--<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_info_edit_doctor<?=$val_c->id ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </button>-->
					<!--| <a href="<?php echo base_url()."contact/contact/del_doctor/".urisafeencode($val_c->id);?>" onclick="return confirm('Are you sure want to delete this record.')" class=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>--><a href="<?php echo base_url()."pharmacy/pharmacy/pharma_interaction_sales/".urisafeencode($val_c->id);?>">		<button type="button" class="btn btn-info">Interaction</button></a>
					<!--<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_info_doctor<?=$val_c->id ?>">
						 Interaction
						</button>
					 <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_info_appointment<?=$val_c->id ?>">
						 Appointment
						</button>-->
						 </td>
					</tr>
			  
         <?php }  ?>
			</tbody>
		</table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

      </div>
      <?php } ?>
 
 
 
 
 
      <?php
  //pr($dealer_of_group); die;
       if(!empty($dealer_info->gd_id)){
      ?>
      
      <!-- END ALERTS AND CALLOUTS -->
      <!--<h2 class="page-header">Dealers of this Group</h2>-->
      
      <div class="row">
        <div class="col-md-12">

          <div class="box box-default collapsed-box">
                
                
         <div class="box-header with-border">
             <?php if(empty($dealer_info->gd_id)){?>  
         <h3 class="box-title" >Dealer List</h3>
             <?php }else{?>
         
         <h3 class="box-title" >Dealer List</h3>
             <?php }?>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
            <!--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>-->
          </div>
        </div>
            <!-- /.box-header -->
            <div class="box-body">
                
                <div class="table">
    
    <div class="rowdivline header">
      <div class="cell">
        Name
      </div>
      <div class="cell">
        Email
      </div>
      <div class="cell">
        Phone Number
      </div>
      <div class="cell">
       City Name
      </div>
        <div class="cell">
       Action
      </div>
    </div>
     <?php            
                  foreach($dealer_of_group as $k_gs=>$val_gs){
                  ?>
    <div class="rowdivline">
      <div class="cell">
        <?=$val_gs->d_name;?>
      </div>
      <div class="cell">
        <?=$val_gs->email;?>
      </div>
      <div class="cell">
        <?=$val_gs->d_ph;?>
      </div>
      <div class="cell">
        <?=$val_gs->city_name;?>
      </div>
        <div class="cell">
         <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_info_edit<?=$val_gs->id ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>  
         | <a href="<?php echo base_url()."dealer/dealer/view_dealer_for_doctor/". urisafeencode($val_gs->id);?>"><button type="button" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i></button></a> 
         <?php if(empty($dealer_info->gd_id)){?>     
         <!-- | <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_info_groupdealer<?=$val_gs->id ?>">
                 Interaction
                 </button> | 
                 <!--<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_info_appointment<?=$val_gs->id ?>" style="margin: 6px;">
                 Appointment
                 </button>-->
         <?php } ?>
      </div>
    </div>
                    

          <div class="modal modal-info fade" id="modal_info_edit<?=$val_gs->id ?>">
            
         <form role="form" method="post" action="<?php echo base_url()."dealer/dealer/add/".urisafeencode($val_gs->id)?>" enctype= "multipart/form-data">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Dealer Edit</h4>
              </div>
              <div class="modal-body">
                 <!--<div class="col-md-6">-->
                 <div class="form-group" id="group_dealer_state">
             
                <label>Dealer State</label>
                 
         <select name="dealer_state" id="group_dealer_state<?=$val_gs->id;?>"  class="form-control select5" style="width: 100%;">
                  <option value="">--State--</option>
                <?php 
                foreach($state_data as $k_st => $val_st){
                    if($val_st->state_id==$val_gs->state_id){
                ?>   
                  <option value="<?=$val_st->state_id?>" selected="" ><?=$val_st->state_name;?></option>

                    <?php } else{?>
                  <option value="<?=$val_st->state_id?>" <?php if(isset($_POST['dealer_state'])){echo set_select('dealer_state',  $val_st->state_id);} ?>  ><?=$val_st->state_name;?></option>
                <?php } }  ?>
                  
                </select>
            <span class="control-label" for="inputError" style="color: red"><?php echo form_error('dealer_state'); ?></span>

                   </div>
                 
                 
                 <div class="form-group">
             
                <label>Dealer City</label>
                 
         <select name="dealer_city" id="group_dealer_city<?=$val_gs->id;?>"  class="form-control select1" style="width: 100%;">
                  <option value="<?=$val_gs->city_id?>"><?=$val_gs->city_name?></option>
                <?php 
//                foreach($city_data as $k_c => $val_c){
                ?>   
                  <!--<option value="<?=$val_c->city_id?>" <?php // if(isset($_POST['dealer_city'])){echo set_select('dealer_city',  $val_c->city_id);} ?>  ><?= $val_c->city_name;?></option>-->
                <?php // } ?>
                  
                </select>
            <span class="control-label" for="inputError" style="color: red"><?php echo form_error('group_dealer_city'); ?></span>

              </div>
       
<!--                 </div>
                  <div class="col-md-6">-->
                 <div class="form-group">
                <label>Email address</label>
                <?php
                if(empty($val_gs->gd_id)){
                ?>
                  <input class="form-control" name="dealer_email" placeholder="Enter email ..." type="email" value="<?=$val_gs->email?>">
                <?php }else{ ?>
               <input class="form-control" name="group_dealer_email" placeholder="Enter email ..." type="email" value="<?=$val_gs->email?>">
              
               <span class="help-block" for="inputError" style="color: red"><?php echo form_error('group_dealer_email'); ?></span>
 
             <?php } ?>
                </div>

              <div class="form-group">
                <label>Dealer Name</label>
                 <?php
                if(empty($val_gs->gd_id)){
                ?>
                 <!--<input class="form-control" name="dealer_id" placeholder="Enter Dealer name..." type="hidden" value="<?=$val_gs->d_id?>">-->

                <input class="form-control" name="dealer_name" placeholder="Enter Dealer name..." type="text" value="<?=$val_gs->dealer_name?>">
                <?php }else{ ?>
                 <!--<input class="form-control" name="group_dealer_id" placeholder="Enter Dealer name..." type="hidden" value="<?=$val_gs->d_id?>">-->

                <input class="form-control" name="group_dealer_name" placeholder="Enter Dealer name..." type="text" value="<?=$val_gs->dealer_name?>">
                <?php }?>
              
              </div>
                      
              <div class="form-group">
                 <label>Contact Number</label>
                 <?php
                if(empty($val_gs->gd_id)){
                ?>
                  <input class="form-control" name="dealer_num" placeholder="Enter Phone number..." type="text" value="<?=$val_gs->d_ph;?>">
                <?php }else{ ?>
                 <input class="form-control" name="group_dealer_num" placeholder="Enter Phone number..." type="text" value="<?=$val_gs->d_ph;?>">
               <span class="help-block" for="inputError" style="color: red"><?php echo form_error('group_dealer_num'); ?></span>
 
            <?php } ?>
                 <!--<span class="help-block" for="inputError" style="color: red"><?php echo form_error('dealer_num'); ?></span>-->
              </div>
                                    
               <div class="form-group">
                 <label>Alternate Contact Number</label>
                  <input class="form-control" name="dealer_alt_num" placeholder="Enter Alternate Phone number..." type="text" value="<?=$val_gs->alt_phone ?>">
             
                <!--<span class="help-block" for="inputError" style="color: red"><?php //echo form_error('dealer_num'); ?></span>-->

              </div>
                    <div class="form-group">
                  <label>About the Dealer</label>
                  
                   <?php
                if(empty($val_gs->gd_id)){
                ?>
                 
                  
                  <textarea class="form-control" rows="3" name="about_s" placeholder="About the Dealer ..."><?=$val_gs->d_about?></textarea>
                
                <?php } else{?>
                       <textarea class="form-control" rows="3" name="group_about_d" placeholder="About the Dealer ..."><?=$val_gs->d_about?></textarea>
                <?php }?>
                 </div>

                <div class="form-group">
                  <label>Dealer Address</label>
                  <textarea class="form-control" rows="3" name="d_address" placeholder="Dealer Address ..."><?=$val_gs->d_address?></textarea>
                </div>

                      
                  </div> <!--/ modal end-->
              
              
              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-outline"  value="Save changes">
              </div>
            </div>
          
              </form>
            <!-- /.modal-content -->
          </div>
                      
     <script type="text/javascript">
      $(function(){             
 $('#datepicker_group<?=$val_gs->id ?>').datepicker({
              autoclose: true
    });
//     $('#dealer_datepicker_doa<?=$val_gs->id;?>').datepicker({
//           autoclose:true
//      }); 
//       $('#datepickerdo_in<?=$val_gs->id;?>').datepicker({
//           autoclose:true
//      }); 
      
    });
          </script>                 
                      
                 <?php }  ?>             
    
    
  </div>
                

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

      </div>
      
      <?php } ?>
      
     <?php if(!empty($di_info)){ ?>
      <!--<h2 class="page-header">Interaction</h2>-->
      <div class="row">
        <div class="col-md-12">
            <div class="box box-default collapsed-box">
                
         <div class="box-header with-border">
             <h3  class="box-title">Interaction List with Dealer</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
            <!--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>-->
          </div>
        </div>
            <!-- /.box-header -->
            <div class="box-body">
                
			<table id="example4" class="table table-bordered table-striped">
				<thead>
						<tr>
							<th> Interaction With </th>
							<th> Interaction By</th>
							<!-- <th> Sale</th>
							<th> Payment</th>
							<th> Stock</th>
							<th> Met/Not Met</th>
							<th> Remark</th> -->
							<th> Follow up Date</th>
							<th> Interaction Date</th>
						</tr>
					</thead>
				<tbody>
    
                 <?php
                 if(!empty($di_info)){
                  foreach($di_info as $k_si=>$val_si){
                  ?>
					<tr>
						 <td>   <?=$val_si->dealer_name;?></td>
						 <td><?=$val_si->username;?></td>
						<!--  <td> <?=$val_si->meeting_sale;?></td>
						 <td><?=$val_si->meeting_payment;?></td>
						 <td><?=$val_si->meeting_stock;?></td>
						 <td>
							<?php
							if($val_si->meet_or_not_meet==TRUE){
							  echo "Met";  
							}
							elseif($val_si->meet_or_not_meet==FALSE && $val_si->meet_or_not_meet!=NULL){
							   echo "Not Met";    
							}
							
							?></td>
						 <td><?=$val_si->remark;?></td> -->
						 <td><?=$val_si->follow_up_action!=NULL ? date('d-M-Y',strtotime($val_si->follow_up_action)):'';?></td>
						 <td><?=date('d-M-Y',strtotime($val_si->date_of_interaction));?></td>
							
					   </tr>
                    <?php  } } ?>
                     <?php
                      if(!empty($doci_info)){
                  foreach($doci_info as $k_ci=>$val_ci){
                  ?>
						<tr>
						   <td> <?=$val_ci->d_name;?></td> 
						   <td> <?=$val_ci->username;?></td> 
						   <!-- <td><?=$val_ci->mmt_name;?></td> 
						   <td>   <?=$val_ci->remark;?></td> 
						   <td>   <?=$val_ci->additional_remark;?></td>  -->
						   <td> <?= $val_ci->follow_up_action!=NULL ? date('d-M-Y',strtotime($val_ci->follow_up_action)):'';?>  </td>      
							<?php //date('d-M-Y',strtotime($val_ci->follow_up_action));?>
						</tr>
		
                     <?php  } } ?>
					</tbody>
				</table>
 
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

     </div> <?php } ?>
      
          <?php if(!empty($doc_int_info)){ ?>
      <!--<h2 class="page-header">Interaction</h2>-->
      <div class="row">
        <div class="col-md-12">
            <div class="box box-default collapsed-box">
                
         <div class="box-header with-border">
             <h3  class="box-title">Interaction List with Doctor</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
            <!--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>-->
          </div>
        </div>
            <!-- /.box-header -->
            <div class="box-body">
                
                <table id="example5" class="table table-bordered table-striped example5">
				<thead>
						<tr>
							<th> Interaction With </th>
							<th> Interaction By</th>
							<!-- <th> Sale</th>
							<th> Met/Not Met</th>
							<th> Sample Name</th>
							<th> Remark</th> -->
							<th> Follow up Date</th>
							<th> Interaction Date</th>
						</tr>
					</thead>
				<tbody>
    
                 <?php
                 if(!empty($doc_int_info)){
                  foreach($doc_int_info as $k_si=>$val_si){
                  ?>
                    <tr>
                        <td><?=$val_si->interactionwith;?></td>
                        <td><?=$val_si->interactionBy;?></td>
                        <!-- <td><?=$val_si->meeting_sale;?></td>
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
                        <td><?=$val_si->samples->samples;?></td>
                        <td><?=$val_si->remark;?></td> -->
                        <td><?=$val_si->follow_up_action!=NULL ? date('d-M-Y',strtotime($val_si->follow_up_action)):'';?></td>
                        <td> <?=date('d-M-Y',strtotime($val_si->date_of_interaction));?></td>
					</tr>
                    <?php  } } ?>
                     <?php
                      if(!empty($doci_info)){
                  foreach($doci_info as $k_ci=>$val_ci){
                  ?>
                    <tr>
                        <td><?=$val_ci->d_name;?></td>
                        <td><?=$val_ci->username;?></td>
                       <!--  <td><?=$val_ci->mmt_name;?></td>
                        <td><?=$val_ci->remark;?></td>
                        <td><?=$val_ci->additional_remark;?></td> -->
                        <td><?=$val_ci->follow_up_action!=NULL ? date('d-M-Y',strtotime($val_ci->follow_up_action)):'';?></td>
                    </tr>
                     <?php  } } ?>
    
					</tbody>
				</table>
 
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

     </div> <?php } ?>
        
          <?php if(!empty($pharma_int_info)){ ?>
      <!--<h2 class="page-header">Interaction</h2>-->
      <div class="row">
        <div class="col-md-12">
            <div class="box box-default collapsed-box">
                
         <div class="box-header with-border">
             <h3  class="box-title">Interaction List with Sub Dealer</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
            <!--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>-->
          </div>
        </div>
            <!-- /.box-header -->
            <div class="box-body">
               <table id="example6" class="table table-bordered table-striped example5">
				<thead>
						<tr>
							<th> Interaction With </th>
							<th> Interaction By</th>
							<!-- <th> Sale</th>
							<th> Met/Not Met</th>
							<th> Sample Name</th>
							<th> Remark</th> -->
							<th> Follow up Date</th>
							<th> Interaction Date</th>
						</tr>
					</thead>
				<tbody>
                 <?php
                 if(!empty($pharma_int_info)){
                  foreach($pharma_int_info as $k_si=>$val_si){
                  ?>
					<tr>
						<td><?=$val_si->interactionwith;?></td>
						<td><?=$val_si->interactionBy;?></td>
						<!-- <td><?=$val_si->meeting_sale;?></td>
						<td>
						<?php
						if($val_si->meet_or_not_meet==TRUE){
						 echo "Yes";   
						}
						else if($val_si->meet_or_not_meet==FALSE && $val_si->meet_or_not_meet!=NULL){
							 echo "No";
						}
						
						?>
						<td><?=$val_si->sample_name->sample_name;?></td>
						<td><?=$val_si->remark;?></td> -->
						<td> <?=$val_si->follow_up_action!=NULL ? date('d-M-Y',strtotime($val_si->follow_up_action)):'';?></td>
						<td><?=date('d-M-Y',strtotime($val_si->date_of_interaction));?></td>
					   </tr>
                    <?php  } } ?>
                     <?php
                      if(!empty($doci_info)){
                  foreach($doci_info as $k_ci=>$val_ci){
                  ?>
                     <tr>
						<td><?=$val_ci->d_name;?></td>
						<td><?=$val_ci->username;?></td>
						<!-- <td><?=$val_ci->mmt_name;?></td>
						<td><?=$val_ci->remark;?></td>
						<td><?=$val_ci->additional_remark;?></td> -->
						<td><?=$val_ci->follow_up_action!=NULL ? date('d-M-Y',strtotime($val_ci->follow_up_action)):'';?></td>   
                      </tr>
                     <?php  } } ?>
    
					</tbody>
				</table>
 
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

     </div> <?php } ?>
        
        
      
      

    </section>
    <!-- /.content -->
  </div>

<script type="text/javascript">
    
    
$(function(){
    $('#datepicker').datepicker({
              autoclose: true
    })
    $('#datepicker_dob').datepicker({
              autoclose: true
    })
    $('#datepicker_fup').datepicker({
        autoclose:true
    });
     $('#datepicker_doi').datepicker({
          
            startDate: '-7d',
            endDate: '+0d' ,
            autoclose:true
       })  ;
     $('#datepickerdo_in').datepicker({
        autoclose:true
    });
    
    
    
    
     $('.select2').select2(); 
   var $eventSelect3= $('.select5').select2();
   
    var $eventSelect4 =$('.select1').select2();
     $eventSelect3.on("change",function(e){
         var stateid = $(this).val();  
          var gsid = document.getElementsByClassName('gd_id'); 
         if(stateid){
        $.ajax({
           type:"POST",
           url:"<?= base_url();?>dealer/dealer/dealer_city/",
           data : 'id='+stateid,
           success:function(res){ 

            if(res){
                
             for (i = 0; i < gsid.length; i++) {
            $("#group_dealer_city"+gsid[i].value).html(res);
               }
            

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
   
   
 
    });
    
    
    
</script>

<script type="text/javascript">
    
    $('#m_yes').click(function(){
    
   $("#sp_name").css("display", "block");
   $("#sp_email").css("display", "block");
   
    
});

$('#m_no').click(function(){
    
   $("#sp_name").css("display", "none");
   $("#sp_email").css("display", "none"); 
    
});
function validateForm(id) {
//    alert(id);
     var has_error;
    var x = $('#main_meeting_id_group'+id).val();
     $('#main_meeting_id_group_help'+id).html('');  
//   alert(x);
    if (x == '') {
        $('#main_meeting_id_group_help'+id).html('Please Select Meeting Type');
            $('#main_meeting_id_group_help'+id).focus();
//            event.preventDefault();
           return false;
    }
    else{
        return true;
    }
    
    
} 
</script>

<script type="text/javascript">
$(function(){

   var $eventSelect_ad= $('.select5').select2();
   var $eventSelect4 =$('.select7').select2();
     $eventSelect_ad.on("change",function(e){
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
//    else{
//        $("#dealer_state").empty();
//        $("#dealer_city").empty();
//    }
        
    });
 
    
})



</script>

	<script type="text/javascript">
	  $(function () {
		$('#example2,#example3,#example4,#example5,#example6').DataTable({
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

	