<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 $state_name = json_decode($statename);

  $val_d = json_decode($edit_dealer_list);
  
  $ms = json_decode($meeting_sample);
  
  $team_list=json_decode($users_team); 
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
    <?php echo get_flash(); ?>
      <!-- Contact Add -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Add Interaction</h3>
                 <br>
          <span style="color: red;font-size: 20px">*</span> are required Fields.
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php echo form_open_multipart($action);?>
				<div class="row">
					<div class="col-md-12">
						
						
						
					<input type="hidden" name="path_info" <?php if($old_data!=''){?>  value="<?=$old_data->path_info;?>"<?php }else{?> value="<?=$path_info;?>"<?php }?>>	
					<input type="hidden" name="city"  <?php if($old_data!=''){?> value="<?=$old_data->city_code;?>"<?php }else{?> value="<?=$city;?>"<?php }?> >	
					 <div class="form-group" >
						<label>Dealer name</label>
						<input class="form-control" name="d_name" placeholder="Dealer Name..." type="text" value="<?=$val_d->dealer_name;?>" readonly="">        
						<input class="dealer_view_id"  name="dealer_view_id" type="hidden" value="<?=$val_d->d_id;?>"> 
						<input class="gd_id"  name="d_id" type="hidden" value="<?=$val_d->d_id;?>">                  
					<!--<span class="control-label" for="inputError" style="color: red"></span>-->
					</div>

					<div class="form-group">
						<label id="telephonic<?=$val_d->d_id ?>" style="display: block">Telephonic Interaction
						<input name="telephonic" <?php if($old_data!=''){echo $old_data->telephonic?'checked':'';}?> id="telephonic1" value="1" type="checkbox">
						</label>
					</div>

					<div class="form-group" id="jw_<?=$val_d->d_id;?>" style="display: block">
						<label>Joint Working</label>
						<select name="team_member[]" multiple="multiple" class="form-control select2" style="width: 100%;">
						  <!--<option value="">---Sample Name---</option>-->
						<?php 
						foreach($team_list as $k_tl => $val_tl){?>   
						<option value="<?=$val_tl->userid?>" <?php if($old_data!=''){ $jointarr=explode(',',$old_data->joint_working); echo in_array($val_tl->userid,$jointarr)?'selected':''; }  ?> <?php if(isset($_POST['team_member'])){echo set_select('team_member',  $val_tl->userid);} ?>><?=$val_tl->username;?></option>
						<?php }  ?>
						<!--<option value="none" id="none" >NONE</option>-->
						</select>
					</div>
					<?php if($date_interact==''){?>
					<div class="form-group" >

					  <label>Date of Interaction<span style="color: red;font-size: 20px">*</span></label>

						<input required class="form-control" name="doi_doc" value="<?php if($old_data!=''){ echo $old_data->interaction_date;}?>" id="datepicker_doi<?=$val_d->d_id ?>" type="text">

					</div>

					<?php }else{?>
						<input class="form-control" name="doi_doc" value="<?php echo date('d-m-Y',strtotime($date_interact));?>" id="datepicker_doi<?=$val_d->d_id ?>" type="hidden">
					<?php }?>
					<div class="form-group" >
						<table class="table table-bordered" style="background:#00c0ef">
							<tbody><tr>

							<th>Meeting Type</th>
							<th>Value</th>
							</tr>
							<tr>
							<td>Sale</td>
							<?php if($order_amount!=''){?>
							 <td id="sale<?=$val_d->d_id ?>" style="display: block"><input class="form-control" readonly id="sale_dealer<?=$val_d->d_id;?>" name="m_sale" value='<?=$order_amount?>' type="text" ></td> 
							<?php }else{?>
								<td id="sale<?=$val_d->d_id ?>" style="display: block">
								<button type="submit" value="secondary_product" name="save" class="btn btn-info ">Add Product</button>
							  </td> 
							 <?php }?>
							</tr>
							<tr >
							<td>Sample/Gift</td>
							<td id="sample<?=$val_d->d_id ?>" style="display: block"><select name="m_sample[]" multiple="multiple" class="form-control select2" style="width: 100%;">
							  <option value="">---Sample Name---</option>
							<?php 
							foreach($ms as $k_ms => $val_ms){

							?>   
							<option value="<?=$val_ms->id?>" <?php if($old_data!=''){ $jointarr=explode(',',$old_data->sample); echo in_array($val_ms->id,$jointarr)?'selected':''; }  ?> <?php if(isset($_POST['m_sample'])){echo set_select('m_sample',  $val_ms->id);} ?>><?=$val_ms->sample_name;?></option>
							<?php }  ?>
							<!--<option value="none" id="none" >NONE</option>-->
							</select> </td>
							</tr>
							<tr>
							<td>Payment</td>
							<td id="payment<?=$val_d->d_id ?>" style="display: block"><input class="form-control" name="m_payment" placeholder="Payment info..." type="text" > </td>

							</tr>
							<tr>
							<td>Stock</td>
							<td id="stock<?=$val_d->d_id ?>" style="display: block"><input class="form-control" name="m_stock" placeholder="Stock info..." type="text" > </td>

							</tr>
							<tr>
							<td>Meet or Not Meet<span style="color: red;font-size: 20px">*</span></td>
							<td><div class="radio">
							<label id="meet<?=$val_d->d_id ?>" style="display: block">
							<input name="meet_or_not" id="optionsRadios1" value="1" type="radio">
							Meet
							</label>
							</div>
							<div class="radio">
							<label id="notmmeet<?=$val_d->d_id ?>" style="display: block">
							<input name="meet_or_not" id="optionsRadios1" value="0" type="radio">
							Not Meet
							</label>
							</div></td>

							</tr>
							<tr>
							<td>Order By</td>
							<td><div class="radio">

                    <label id="telephonic<?=$val_d->d_id ?>"style="display: <?php echo $order_amount!=''?'block':'none'?>">Telephonic Interaction
                    <input name="telephonic" <?php if($old_data!=''){echo $old_data->telephonic?'checked':'';}?> id="telephonic1" value="1" type="checkbox">
                     <br>
                    Leave unchecked if order received by physically.

                    </label>
                  </div></td>

							</tr>
							</tbody>
						</table>

					</div> 

					<div class="form-group">
						<label>Remark</label>

						<textarea class="form-control" rows="3" name="remark" placeholder="About the Meeting ..."><?php if($old_data!=''){ echo $old_data->remark; }?></textarea>


					</div>

					<div class="form-group" >
					  <label>Followup Action</label>
					<input class="form-control" name="fup_a" value="<?php if($old_data!=''){ echo $old_data->followup_date;}?>" id="datepicker_fup<?=$val_d->d_id;?>" type="text">
					</div>
					<div class="form-group">
					<label>Stay &nbsp; : &nbsp;&nbsp;</label>
					<br>
					<input  type="radio" class="form-check-input stay" checked <?php echo set_checkbox('stay',0); ?> name="stay" id="stay" value="0">
					&nbsp;Not Stay &nbsp;
					<input type="radio" <?php echo set_checkbox('stay',1); ?> class="form-check-input ts stay" name="stay" id="stay1" value="1">
					&nbsp;  Stay &nbsp;
					<span class="control-label" for="inputError" style="color: red"><?php echo form_error('stay'); ?></span>
					</div>
					<div class="form-group">
		              <label>Back HO &nbsp; : &nbsp;&nbsp;</label>
		              <br>
		              <input  type="radio" class="form-check-input houp" checked <?php echo set_checkbox('up',0); ?> name="up" id="houp" value="0">
		              &nbsp;No &nbsp;
		              <input type="radio" <?php echo set_checkbox('up',1); ?> class="form-check-input ts houp" name="up" id="houp1" value="1">
		              &nbsp;  Yes &nbsp;
		              <span class="control-label" for="inputError" style="color: red"><?php echo form_error('up'); ?></span>
		            </div>

					<div class="form-group">
					<label>Send Mail to Dealer &nbsp; : &nbsp;&nbsp;</label>
					<br>
					<input  type="radio" class="form-check-input" checked name="dealer_mail" id="" value="1">
					&nbsp;Yes &nbsp;
					<input type="radio" class="form-check-input" name="dealer_mail" id="" value="0">
					&nbsp;  No &nbsp;
					</div>
		
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<!--<div class="form-group">-->
						<div class="box-footer">
							<button type="submit" value="save_data" name="save" class="btn btn-info pull-right">Save</button>
						</div>
					</div>
				</div>
          
			  <?php
			  echo form_close(); 
			  ?>
        </div>
        <!-- /.box-body -->
         <!-- /.box -->

    </section>
    <!-- /.content -->
	</div>
 </div>
<script type="text/javascript">
              $('#sale<?=$val_d->d_id ?>').on("change", function(){
//               alert('mee');
               var sale_value = $(this).val();
               
             if(sale_value === ''){
               $("#meet<?=$val_d->d_id ?>").css("display","none");
               $("#notmmeet<?=$val_d->d_id ?>").css("display","none");
                  }
                  else{
                      $("#meet<?=$val_d->d_id ?>").css("display","block");
                       $("#notmmeet<?=$val_d->d_id ?>").css("display","block");
                  }
            
           });
           
            $('#payment<?=$val_d->d_id ?>').on("change", function(){
//               alert('mee');
               var payment_value = $(this).val();
               
             if(payment_value === ''){
               $("#meet<?=$val_d->d_id ?>").css("display","none");
               $("#notmmeet<?=$val_d->d_id ?>").css("display","none");
                  }
                  else{
                      $("#meet<?=$val_d->d_id ?>").css("display","block");
                       $("#notmmeet<?=$val_d->d_id ?>").css("display","block");
                  }
            
           });
           
           $('#stock<?=$val_d->d_id ?>').on("change", function(){
//               alert('mee');
               var stock_value = $(this).val();
               
             if(stock_value === ''){
               $("#meet<?=$val_d->d_id ?>").css("display","none");
               $("#notmmeet<?=$val_d->d_id ?>").css("display","none");
                  }
                  else{
                      $("#meet<?=$val_d->d_id ?>").css("display","block");
                       $("#notmmeet<?=$val_d->d_id ?>").css("display","block");
                  }
            
           });
           
           
            $('#meet<?=$val_d->d_id ?>').on("click", function(){
//               alert('mee');
               var sale_value = $(this).val();
               
             if(sale_value === ''){
               $("#sale<?=$val_d->d_id ?>").css("display","none");
               $("#sample<?=$val_d->d_id ?>").css("display","none");
                $("#payment<?=$val_d->d_id ?>").css("display","none");
                 $("#stock<?=$val_d->d_id ?>").css("display","none");
                  $("#jw_<?=$val_d->d_id ?>").css("display","none");
                  }
                  else{
                      $("#sale<?=$val_d->d_id ?>").css("display","block");
                       $("#sample<?=$val_d->d_id ?>").css("display","block");
                        $("#payment<?=$val_d->d_id ?>").css("display","block");
                         $("#stock<?=$val_d->d_id ?>").css("display","block");
                          $("#jw_<?=$val_d->d_id ?>").css("display","block");
                  }
            
           });
           
           $('#notmmeet<?=$val_d->d_id ?>').on("click", function(){
//               alert('mee');
               var sale_value = $(this).val();
               
             if(sale_value === ''){
              $("#sale<?=$val_d->d_id ?>").css("display","none");
               $("#sample<?=$val_d->d_id ?>").css("display","none");
                $("#payment<?=$val_d->d_id ?>").css("display","none");
                 $("#stock<?=$val_d->d_id ?>").css("display","none");
                  $("#jw_<?=$val_d->d_id ?>").css("display","none");
                  }
                  else{
                      $("#sale<?=$val_d->d_id ?>").css("display","block");
                       $("#sample<?=$val_d->d_id ?>").css("display","block");
                        $("#payment<?=$val_d->d_id ?>").css("display","block");
                         $("#stock<?=$val_d->d_id ?>").css("display","block");
                         $("#jw_<?=$val_d->d_id ?>").css("display","block");
                  }
            
           });
              
               $(function(){
                   
                     var $eventSelect3= $('.select2').select2();
                     
                       $eventSelect3.on("change",function(e){
             
         var sample_value = $(this).val();
            
             if(sample_value != ''){
                   
               $("#meet<?=$val_d->d_id ?>").css("display","none");
               $("#notmmeet<?=$val_d->d_id ?>").css("display","none");
                  }
                  else{
                        
                     $("#meet<?=$val_d->d_id ?>").css("display","block");
                       $("#notmmeet<?=$val_d->d_id ?>").css("display","block");
                  } 

    });
                   
         $('#datepicker_doa<?=$val_d->d_id;?>').datepicker({
                            autoclose:true
                      });
       $('#datepicker_fup<?=$val_d->d_id;?>').datepicker({
           autoclose:true
       })  ; 
        $('#datepicker_doi<?=$val_d->d_id;?>').datepicker({
          
            startDate: '-7d',
            endDate: '+0d' ,
            autoclose:true
       })  ;
       
   
    });
</script>


	<script type="text/javascript">
	$(document).ready(function(){
             
	var saledealer_value = $('#sale_dealer<?=$val_d->d_id ?>').val();
	//alert(saledealer_value);
	if(saledealer_value != '' && typeof  saledealer_value != 'undefined'){

	  $("#d_list<?=$val_d->d_id ?>").css("display","block");
	  $("#meet<?=$val_d->d_id ?>").css("display","none");
      $("#notmmeet<?=$val_d->d_id ?>").css("display","none");
	}
});
	
	</script>
	
	<script type="text/javascript">
	$(document).ready(function(){
             
	var saledealer_value = $('#sale_dealer<?=$val_d->d_id ?>').val();
	//alert(saledealer_value);
	if(saledealer_value != '' && typeof  saledealer_value != 'undefined'){
	  $("#meet<?=$val_d->d_id ?>").css("display","none");
      $("#notmmeet<?=$val_d->d_id?>").css("display","none");
	}



	});
	
	</script>

<script>
    $('.stay').change(function() {
     if($('.stay:checked').val()==1)
     {
        $( "#houp" ).prop( "checked", true );
     }
    });
    $('.houp').change(function() {
       if($('#stay1').is(":checked"))
       {
          $( "#houp" ).prop( "checked", true );
       }
    });
</script>
	