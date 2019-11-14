<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$edit_appoint = json_decode($edit_dealer_list);

//$ap_personid=$edit_appoint->d_id;
//pr($edit_appoint); die;

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<div class="content-wrapper">


    <!-- Main content -->
    <section class="content">
         <?= get_flash();?>
      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Add</h3>

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
                
                <div class="form-group" >
                 <label>Dealer name</label>
                 <input class="form-control" name="d_name" placeholder="Dealer Name..." type="text" value="<?=$edit_appoint->dealer_name;?>" readonly="">               
                <input class="dealer_view_id"  name="dealer_view_id" type="hidden" value="<?=$edit_appoint->d_id;?>"> 
                <input class="gd_id"  name="d_id" type="hidden" value="<?=$edit_appoint->d_id;?>">                  
            <!--<span class="control-label" for="inputError" style="color: red"></span>-->
                 </div>              
             
             
               <div class="form-group" >
                      
                      <table class="table table-bordered" >
                <tbody><tr>
                  
                  <th>Meeting Type</th>
                  <th>Value</th>
                </tr>
                <tr>
                  <td>Sale</td>
                  <td><input class="form-control" name="m_sale" placeholder="Sales info..." type="text" >  </td>
                  
                </tr>
                <tr>
                  <td>Payment</td>
                  <td> <input class="form-control" name="m_payment" placeholder="Payment info..." type="text" > </td>
                  
                </tr>
                <tr>
                  <td>Stock</td>
                  <td><input class="form-control" name="m_stock" placeholder="Stock info..." type="text" > </td>
                  
                </tr>
                <tr>
                  <td>Meet or Not Meet</td>
                  <td><div class="radio">
                    <label>
                      <input name="meet_or_not" id="optionsRadios1" value="1" type="radio">
                      Meet
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input name="meet_or_not" id="optionsRadios1" value="0" type="radio">
                      Not Meet
                    </label>
                  </div></td>
                  
                </tr>
              </tbody></table>

                  </div>  
              
                
            </div>
            <!-- /.col -->
            <div class="col-md-6">
                
                  <div class="form-group" >
                          <label>Followup Action</label>
                   <input class="form-control" name="fup_a" id="datepicker" type="text">
                      </div> 
                
                      <div class="form-group">
                            <label>Remark</label>

                            <textarea class="form-control" rows="10" name="remark" placeholder="About the Meeting ..."></textarea>


                        </div>
                
                                
            
              <!-- /.form-group -->
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
    <!-- /.content -->
  </div>
<script src="<?= base_url()?>design/bower_components/select2/dist/js/select2.full.min.js"></script>

<script type="text/javascript">
    
    $(function(){
        
        var $eventSelect2=  $('.select7').select2();
       $eventSelect2.on("change", function (e) {   
       
        var schoolid = $(this).val();
              
//          var gsid =  $(this).closest('form').find('.gs_id').val;
      
//       alert(gsid);
//        var gsid = document.getElementsByClassName('gs_id');
//       if (gsid.length > 0) {
//	alert (gsid[1].value);
//          }
       
          if(schoolid){
        $.ajax({
           type:"POST",
           url:"<?= base_url();?>school/school_add/sub_meeting_name/",
           data : 'id='+schoolid,
           success:function(res){ 

            if(res){
            
            $("#sub_meeting").html(res);
             

            }

           }
             
        });
    }
 
    });
       
    });
    
    </script>