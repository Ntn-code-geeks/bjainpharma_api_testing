<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$dealer_data = json_decode($dealer_list);   // for all active dealers 
$ms = json_decode($meeting_sample);

 $team_list=json_decode($users_team);  // show child and boss users

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
          
           <form role="form" method="post"   action="<?php echo base_url()."interaction/update_doc_interaction/".$doc_interaction['doc_info'][0]['id']?>" enctype= "multipart/form-data">
        
            <div class="row">
            <div class="col-md-6">
                
                <div class="form-group" >
                 <label>Doctor name</label>
                 <input class="form-control" name="doc_name" placeholder="Dealer Name..." type="text" value="<?=$doc_interaction['doc_info'][0]['customer'];?>" readonly="">               
                 <input class="dealer_view_id"  name="dealer_view_id" type="hidden" value="<?=$doc_interaction['doc_info'][0]['doc_id']?>"> 
                 <input class="gd_id"  name="doc_id" type="hidden" value="<?=$doc_interaction['doc_info'][0]['doc_id']?>">                  
            <!--<span class="control-label" for="inputError" style="color: red"></span>-->
                 </div>
                
             
             
             <div class="form-group" id="jw_<?=$doc_interaction['doc_info'][0]['id'] ?>" style="display: block">
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
                
                   
             <div class="form-group">
                            <label>Remark</label>
               
                     <textarea class="form-control" rows="3" name="remark" placeholder="About the Meeting ..."><?=$doc_interaction['doc_info'][0]['remark']?></textarea>

                        </div>
              
                
            </div>
                <div class="col-md-6">
                <div class="form-group" >
                      <!--<label>Meeting Types *</label>-->
                      
                <table class="table table-bordered" style="background: #00c0ef;">
                <tbody><tr>
                  
                  <th>Meeting</th>
                  <th>Value</th>
                 
                </tr>
                
                <tr>
                  <td>Secondary Sale</td>
                  <td id="sale" style="display: block">
                    <input readonly class="form-control" id="sale_dealer" name="m_sale" placeholder="Sales info..." type="text" value="<?=$doc_interaction['doc_info'][0]['secondary_sale']?>" >
                    <!--  <a href="<?php echo base_url()."order/interaction_order/add_order/". urisafeencode($doc_interaction['doc_info'][0]['id']).'/'. urisafeencode($doc_interaction['doc_info'][0]['doc_id']);?>"><button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a> -->

                  </td>
                  
                </tr>
                <tr >
                  <td>Sample</td>
                  <td id="sample" style="display: block"><select name="m_sample[]" multiple="multiple" class="form-control select2" style="width: 100%;">
                          <option value="">---Sample Name---</option>
                <?php 
                
                     $samples_id = explode(',',$doc_interaction['doc_info'][0]['sample']['sample_id']);
                
                foreach($ms as $k_ms => $val_ms){
                    if(in_array($val_ms->id, $samples_id)){
                ?>   
                          <option value="<?=$val_ms->id?>" <?php if(isset($_POST['m_sample'])){echo set_select('m_sample',  $val_ms->id);} ?> selected=""><?=$val_ms->sample_name;?></option>
                <?php } 
                else{
                  ?>
          <option value="<?=$val_ms->id?>" <?php if(isset($_POST['m_sample'])){echo set_select('m_sample',  $val_ms->id);} ?> ><?=$val_ms->sample_name;?></option>
                 
         <?php
                    
                }
                
                
                          } ?>
              <!--<option value="none" id="none" >NONE</option>-->

                </select> </td>
                 
                </tr>
                <tr >
                  <td>Met</td>
                  <td><div class="radio">
                    <label id="meet" style="display: block">
                       
                        <input name="meet_or_not" id="optionsRadios1" value="1" type="radio"  <?php 
                        if($doc_interaction['doc_info'][0]['metnotmet']==TRUE){echo "checked"; }
                        ?>>
                     
                      Only Discussion
                    </label>
                  </div>
                  </td>
                  
                </tr>
                <tr >
                    <td>Not Met</td>
                    <td><div class="radio">
                    <label id="notmmeet" style="display: block">
                        
                      <input name="meet_or_not" id="not_meet" value="0" type="radio"  <?php 
                        if($doc_interaction['doc_info'][0]['metnotmet']==FALSE && $doc_interaction['doc_info'][0]['metnotmet']!=NULL){ echo "checked"; }
                        ?>>
                        
                      Not Met
                    </label>
                  </div></td>
                </tr>
               
              </tbody></table>
                      

                  </div>   
                    
                </div> 
                
                
            <!-- /.col -->
         <div class="col-md-6">
            
             <div class="form-group" >
                          <label>Date of Interaction</label>
                   <input class="form-control" name="doi_doc" id="datepicker_doi" type="text" value="<?=date('d-m-Y',strtotime($doc_interaction['doc_info'][0]['date']));?>">
                      </div> 
             
         <div class="form-group" id="d_list" style="display: none">
           <label>Dealer/pharmacy List</label>
           <?php
//           if(!empty($doc_interaction['doc_info'][0]['dealers_id'])){
           ?>
       <select id="dealer_id" name="dealer_id" class="form-control select2" style="width: 100%;">
                  
                <?php 
                foreach($dealer_data as $k_s => $val_s){
                    
                     if($val_s->dealer_id==$doc_interaction['doc_info'][0]['dealer_id']){
                    
                ?>   
           <option value="<?=$val_s->dealer_id?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_s->dealer_id);} ?> selected=""><?=$val_s->dealer_name.','.$val_s->city_name;?></option>
                <?php  }
                else{
                  ?>
         <option value="<?=$val_s->dealer_id?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_s->dealer_id);} ?> ><?=$val_s->dealer_name.','.$val_s->city_name;?></option>

           <?php
                    
                }
                
                
           } ?>
                  
                  
                  
                  <?php 
                foreach($pharma_list as $k_pl => $val_pl){
                    
                   
                     if($val_pl['id']==$doc_interaction['doc_info'][0]['dealer_id']){
                     
                ?>   
           <option value="<?=$val_pl['id']?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_pl['id']);} ?> selected=""><?=$val_pl['com_name'].', (Sub Dealer)';?></option>
                <?php }  
                
                else{
                 ?>
                <option value="<?=$val_pl['id']?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_pl['id']);} ?> ><?=$val_pl['com_name'].', (Sub Dealer)';?></option>

           <?php
                    
                }
                
           } ?>
                  
                  
              <!--<option value="none" id="none" >NONE</option>-->

    </select> <br/>
         
         
         <span class="control-label" id="dealer_id_help" for="inputError" style="color: red"><?php echo form_error('dealer_id'); ?></span>

          </div>
          
             
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
           <!--Gender and merried status-->
            <div class="col-md-6">
                
                
                      <div class="form-group" >
                          <label>Followup Action</label>
                          <input class="form-control" name="fup_a" id="datepicker_fup" type="text" value="<?=!empty($doc_interaction['doc_info'][0]['fup_a'])?date('d-m-Y',strtotime($doc_interaction['doc_info'][0]['fup_a'])):'';?>">
                      </div>

                    
              
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
          </form>
        </div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  
  
  <script type="text/javascript">
        $('#sale_dealer').on("change", function(){
               
               var saledealer_value = $(this).val();
              
             if(saledealer_value === ''){
               $("#d_list").css("display","none");
                  }
                  else{
                      $("#d_list").css("display","block");
                  }
            
           });
           
            $('#sale').on("change", function(){
//               alert('mee');
               var sale_value = $(this).val();
//               alert(sale_value);
             if(sale_value === ''){
               $("#meet").css("display","none");
               $("#notmmeet").css("display","none");
                  }
                  else{
                      $("#meet").css("display","block");
                      $("#notmmeet").css("display","block");
                  }
            
           });
    
       $('#meet').on("click", function(){
//               alert('mee');
               var meet_value = $(this).val();
               
             if(meet_value === ''){
               $("#sale").css("display","none");
               $("#sample").css("display","none");
               $("#jw_").css("display","none");
                  }
                  else{
                      $("#sale").css("display","block");
                       $("#sample").css("display","block");
                       $("#jw_").css("display","block");
                  }
            
           });
           
           $('#notmmeet').on("click", function(){
//               alert('mee');
               var notmeet_value = $(this).val();
               
             if(notmeet_value === ''){
               $("#sale").css("display","none");
               $("#sample").css("display","none");
               $("#jw_").css("display","none");
                  }
                  else{
                      $("#sale").css("display","block");
                       $("#sample").css("display","block");
                       $("#jw_").css("display","block");
                  }
            
           });
    
           
           
            
      $(function(){
      $('.select3').select2();
      $('.select2').select2();
      var $eventSelect3= $('.select2').select2();
    
          $eventSelect3.on("change",function(e){
             
         var sample_value = $(this).val();
           
             if(sample_value != ''){
                   
               $("#meet").css("display","none");
               $("#notmmeet").css("display","none");
                  }
                  else{
                        
                     $("#meet").css("display","block");
                       $("#notmmeet").css("display","block");
                  } 

    });
         
         
 $('#datepicker_contact').datepicker({
              format:'dd-mm-yyyy',
              autoclose: true
    }) ; 
      $('#datepicker_doa').datepicker({
                            format:'dd-mm-yyyy',
                            autoclose:true
                      });
       $('#datepicker_dob').datepicker({
           format:'dd-mm-yyyy',
           autoclose:true
       })  ; 
       $('#datepicker_fup').datepicker({
           format:'dd-mm-yyyy',
           autoclose:true
       })  ; 
        $('#datepicker_doi').datepicker({
            format:'dd-mm-yyyy',
            startDate: '-7d',
            endDate: '+0d' ,
            autoclose:true
       })  ; 
       
   
    });
      
      </script>

