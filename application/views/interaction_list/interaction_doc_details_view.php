<?php

/* 
 * Developer: Niraj Kumar
 * Dated: 20-nov-2017
 * Email: sss.shailesh@gmail.com
 * 
 * for show doctor interaction 
 * 
 */
    $doc_int = $doctor_interaction;
  $secondary_sum=0; 
//    pr($doc_int); die;
    
    
?>
<link href="<?= base_url()?>design/css/div_table/one.css" rel="stylesheet" type="text/css"/><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script><link href="<?= base_url()?>design/css/div_table/custom_table.css" rel="stylesheet" type="text/css"/><link rel="stylesheet" href="<?= base_url()?>design/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"><style>@media	only screen and (max-width: 760px),	(min-device-width: 768px) and (max-device-width: 1024px)  {		/*		Label the data		*/		td:nth-of-type(1):before { content: "Date"; }		td:nth-of-type(2):before { content: "Interaction With"; }		td:nth-of-type(3):before { content: " Interaction By"; }		td:nth-of-type(4):before { content: "City"; }		td:nth-of-type(5):before { content: "Sample"; }		td:nth-of-type(6):before { content: "Met/Not Met"; }		td:nth-of-type(7):before { content: "Secondary Sale"; }		td:nth-of-type(8):before { content: "Remark"; }		td:nth-of-type(9):before { content: "Action"; }	}	</style>
<div class="content-wrapper">

   <section class="content">
<div class="row">
    <?= get_flash();?>
        <div class="col-md-12">
            <div class="box box-default">
                
        <div class="box-header with-border">
<!--             <a href="<?= base_url();?>interaction/interaction/interaction_oncall_view"> 
                    <h3 class="box-title"><button type="button" class="btn btn-block btn-success">Show On Call Interaction</button></h3>
                </a>-->

                     
        </div>
            <!-- /.box-header -->
            <div class="box-body">
                
                <table id="example2" class="table table-bordered table-striped">             					 <thead>						<tr>						  <th>Date</th>				
                		  <th>Interaction With</th>						  <th>Interaction By</th>						  <th>City</th>						  <th>Sample</th>						  <th>Met/Not Met</th>						  <th>Secondary Sale</th>						  <th>Remark</th>						  <th>Action</th>						</tr>					</thead>			
        <tbody>
                <?php
                 if(!empty($doc_int)){
                  foreach($doc_int['doc_info'] as $k_doc=>$val_doc){
                  ?>
                    <tr>	                                     <td>
                        <?= date('Y/m/d',strtotime($val_doc['date'])); ?>
                     </td>
                      <td>
                        <?=$val_doc['customer'];?>
                      </td>
                     <td>
                        <?=$val_doc['user'];?>
                     </td>
                     <td>
                        <?=$val_doc['city'];?>
                     </td>
                      <td>
                        <?=$val_doc['sample']['sample'];?>
                     </td>
                      <td>
                        <?php
                        
                         if($val_doc['metnotmet']==TRUE ){
                           echo "Met";
                         }
                         else if($val_doc['metnotmet']==FALSE && $val_doc['metnotmet']!=NULL ){
                             
                             echo "Not Met" ;
                         }
                      ?>
                            
                     </td>
                      
                     <td>
                        <?=$val_doc['secondary_sale'];?>
                        <?php $secondary_sum=$secondary_sum+$val_doc['secondary_sale']?>
                         <?php if(!empty($val_doc['secondary_sale']) && $val_doc['secondary_sale']!=0){?>
                        <br><a href="<?php echo base_url()."order/interaction_order/view_order/". urisafeencode($val_doc['id']).'/'. urisafeencode($val_doc['doc_id']);?>"  target="_blank">View Product</a>
                         <?php }?>
                      </td>
                      
                      <td>
                        <?=$val_doc['remark'];?>
                      </td>
                        
                      <td>
                        <?php   if(is_admin()){ ?>   
                         <a href="<?php echo base_url()."interaction/edit_doc_interaction/". urisafeencode($val_doc['id'] );?>"><button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                        <?php } ?>
                      </td>
                    </tr>
               <?php  } } ?>
</tbody>
<?php if($secondary_sum!=0){?>
<tfooter><tr><td rowspan="6" colspan="6" style=""><strong>Grand Total</strong></td><td rowspan="" colspan="" style=""><strong><?=$secondary_sum?></strong></td></tr></tfooter>
<?php }?>
</table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

     </div>

 </section>
    <!-- /.content -->
  </div>  
  <script>  
  $(function () {  
    $('#example2').DataTable({     
      'responsive' : true,    
      'paging'      : true, 
      'lengthChange': true,    
      'searching'   : true,    
      'ordering'    : true,    
      'info' : true,   
      'autoWidth'   : true,    
    })  
  })
</script>