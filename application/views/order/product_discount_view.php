<?php

/* 
 * Niraj Kumar
 * date : 23-10-2017
 * show list of users
 */
$productlist = json_encode($product_list);
//  pr($user_info); die;

?>

<link href="<?= base_url()?>design/css/div_table/one.css" rel="stylesheet" type="text/css"/>
<link href="<?= base_url()?>design/css/div_table/custom_table.css" rel="stylesheet" type="text/css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="<?= base_url()?>design/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style>
@media
	only screen and (max-width: 760px),
	(min-device-width: 768px) and (max-device-width: 1024px)  {
		/*
		Label the data
		*/
		td:nth-of-type(1):before { content: "Product Name"; }
		td:nth-of-type(2):before { content: "MRP"; }	
		td:nth-of-type(3):before { content: "Quantity"; }
		td:nth-of-type(4):before { content: "Discount"; }
		td:nth-of-type(5):before { content: "Net Value"; }
	}
	
</style>
<div class="content-wrapper">
   
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
		<?php echo get_flash(); ?>
          <div class="box">
		   <?php echo form_open_multipart($action);?>
            <!-- /.box-header -->
            <div class="box-body">
				<input type="hidden" name ="order_id" value="<?= $order_id ?>">
				<input type="hidden" name ="person_id" value="<?= $person_id ?>">
				
				<input type="hidden" class="grand_total" name ="grand_total" value="0">
                <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Product Name</th>
                  <th>MRP</th>            
                  <th>Quantity</th>
                  <th>Discount</th>
                  <th>Net Value</th>
				  
                  
                </tr>
                </thead>
                <tbody>
				 <?php if(!empty($product_list)){ $gt=0;foreach($product_list as $product){ $gt=$gt+get_product_amount($product); ?>
                 <tr>
					<input type="hidden" class="" name ="productid[]" value="<?= $product ?>">
					<input type="hidden" class="" name ="actual[]" value="<?= get_product_amount($product)?>">
					<td><?= get_product_name($product).'('.get_packsize_name($product).')';?></td>
					<td class="product_amount_<?= $product?>"><?= get_product_amount($product)?></td>
					<td><input class="form-control quantity" value="1" proid="<?= $product?>" name="quantity[]" id="quantity<?= $product?>" type="number"></td>		
					<td><input class="form-control discount" value="0" proid="<?= $product?>" name="discount[]" id="discount<?= $product?>" type="number"></td>
					<td><input class="form-control net_amount_<?= $product?>" readonly value="<?=get_product_amount($product)?>" name="net[]" id="net" placeholder="" type="number"></td>
				 </tr>
                <?php }  } ?>
                </tbody>
				<tfoot>
					<tr>
					  <td colspan="4" style="text-align:right">Total Amount</td>
					  <td class="total_amount"></td>
					</tr>
				</tfoot>
              </table>
			</div>
			<div class="row">
            <div class="col-md-12">
                <!--<div class="form-group">-->
                <div class="box-footer">
					<button type="submit" class="btn btn-info pull-right">Add</button>
                </div>
            </div>
        </div>
			  <?php
			  echo form_close(); 
			  ?>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  
<script type='text/javascript'>
$(document).on('blur','.discount',function(){
	
	var dis=$(this).val();
	if(dis!=''){
		if(dis<100){
			var add=0;
			var proid=$(this).attr('proid');
			var amount=$('.product_amount_'+proid).html();
			var net_amount=(amount-((amount*dis)/100))*$('#quantity'+proid).val();
			 $('.net_amount_'+proid).val(parseFloat(net_amount).toFixed(2));
		  
			  
			$.each(<?=$productlist?>, function( index, value ) {
				if($('.net_amount_'+value).val()!=''){
				add=add+parseFloat($('.net_amount_'+value).val());
				}
				
			});
			$('.total_amount').html( parseFloat(add).toFixed(2)); 
			$('.grand_total').val(parseFloat(add).toFixed(2));
		}
		else
		{
			alert('Please Enter Discount Below 100');
		}
	}
	else{
		alert('Please Enter Discount Greater or equal 0');
		$(this).val(0);
		var add2=0;
		var proid=$(this).attr('proid');
			var amount=$('.product_amount_'+proid).html();
			var net_amount=(amount-((amount*dis)/100))*$('#quantity'+proid).val();
			 $('.net_amount_'+proid).val(parseFloat(net_amount).toFixed(2));
		$.each(<?=$productlist?>, function( index, value ) {
			if($('.net_amount_'+value).val()!=''){
			add2=add2+parseFloat($('.net_amount_'+value).val());
			}
		});
		$('.total_amount').html( parseFloat(add2).toFixed(2)); 
		$('.grand_total').val(parseFloat(add2).toFixed(2));
		
	}

});

$( document ).ready(function() {
	var add1=0;
	$.each(<?=$productlist?>, function( index, value ) {
			if($('.net_amount_'+value).val()!=''){
			add1=add1+parseFloat($('.net_amount_'+value).val());
			}
			
		})
	$('.total_amount').html( parseFloat(add1).toFixed(2)); 
	$('.grand_total').val(parseFloat(add1).toFixed(2));
    
});
$(document).on('blur','.quantity',function()
{
    var qnty=$(this).val();
if(qnty!=''){
    
    if(qnty>0){		
        var add=0;		
        var proid=$(this).attr('proid');
        var amount=$('.product_amount_'+proid).html();	
        var net_amount=(amount-((amount*$('#discount'+proid).val())/100))*qnty;			 $('.net_amount_'+proid).val(parseFloat(net_amount).toFixed(2));	
        $.each(<?=$productlist?>, function( index, value )
        {			
            if($('.net_amount_'+value).val()!='')
            {				add=add+parseFloat($('.net_amount_'+value).val());			
            }						
            });		
            $('.total_amount').html( parseFloat(add).toFixed(2)); 	
            $('.grand_total').val(parseFloat(add).toFixed(2));	
            }else	
            {		
                alert('Please Enter Quantity greater than 1');	
                }	
                }	
                else{	
                    alert('Please Enter Quatity Greater or equal 1');
                    $(this).val(1);	
                    var add2=0;	
                    var proid=$(this).attr('proid');
                    var amount=$('.product_amount_'+proid).html();
                    var net_amount=(amount-((amount*$('#discount'+proid).val())/100))*1;		
                    $('.net_amount_'+proid).val(parseFloat(net_amount).toFixed(2));
                    $.each(<?=$productlist?>, function( index, value ) {
                        if($('.net_amount_'+value).val()!=''){		
                            add2=add2+parseFloat($('.net_amount_'+value).val());			}	
                            });	
                            $('.total_amount').html( parseFloat(add2).toFixed(2)); 	
                            $('.grand_total').val(parseFloat(add2).toFixed(2));		
                    }
    
});
</script>


