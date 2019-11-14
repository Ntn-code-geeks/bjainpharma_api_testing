<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


?>
<script src="<?php echo base_url().'design/js/ajax.3.2.js'?>"></script>


<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
    <?php echo get_flash(); ?>
      <!-- Contact Add -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Add Product </h3>

        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php echo form_open_multipart($action);?>
			<br><br>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Product List : </label><br>
						<div class="product_data" id="product_data" >
							<div class="table-responsive">
								<table  class="col-md-12 table" >
									<thead>
										<tr>
									
											<th>
												Product Potency 
											</th>
											<th>
												Product Packsize 
											</th>
											<th>
												Product Name 
											</th>
											<th>
												MRP 
											</th>
											<th>
												Quantity  
											</th>
											<th>
												Discount (%) 
											</th>
											<th>
												Amount  
											</th>
											<th>
												Action  
											</th>
										</tr>
									</thead>
									<tbody>
								

									<div>
										<tr id="procat_name_11" >
									        <th>
	                   							<span>11</span>
	                   						</th>
	                   						
	                   					</tr>
										<tr id="" class="product_row procat_box_11" >
											
	                   						<td >
	                   							<?php if(get_cat_potency('11')){?>
												<select  catid="11" name="product_potency[]" id="" class="product_select_potency form-control procat_option_box_potency_11"  style="width: 100%;">
	                                   	 		
	                            				</select>
	                            				<?php }?>
	                   						</td>
	                   						<td >
												<select  catid="11" name="product_packsize[]" id="" class="product_select_packsize form-control procat_option_box_packsize_11"  style="width: 100%;">
	                                   	 		            
	                            				</select>
	                   						</td>
	                   						<td >
												<select  catid="11" name="product_name[]" id="" class="product_select form-control select2 procat_option_box_11"  style="width: 100%;">
	                                   	 		       
	                            				</select>
	                   						</td>
	                   						<td>
	                   							<input id="" class="form-control pro_mrp_val" name="pro_mrp_val[]" type="text" readonly value="">
	                   						</td>
	                   						<td>
	                   							<input id="" class="form-control pro_qnty" name="pro_qnty[]" type="text" value="">
	                   						</td>
	                   						<td>
	                   							<input id="" class="form-control pro_dis" name="pro_dis[]" type="text" value="">
	                   						</td>
	                   						<td>
	                   							<input id="" class="form-control pro_amt" name="pro_amt[]" type="text" readonly value="0">
	                   						</td>
	                   						
	                   					</tr>
	                   					<tr id="procat_footer_row_11" style="display:none">
									        <td colspan="8" style="text-align:right">
	                   							<button type="button"  catid="11" class="btn btn-info pull-right add_row">Add Product</button>
	                   						</td>
	                   						
	                   					</tr>
						
									</tbody>
									<tfoot>
										<tr>
											<th colspan="7" style="text-align:right"> 
												Total Amount : 
											</th>
											<th id="">
												<input id="tot_amt" class="form-control" name="tot_amt" type="text" readonly value="">
											</th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
	
		</div>
		<div class="row">
            <div class="col-md-12">
                <!--<div class="form-group">-->
                <div class="box-footer">
					<button type="submit" class="btn btn-info pull-right">Add</button>
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
<script src="<?php echo base_url();?>design/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script type='text/javascript'>

  $(document).on('click','.cat_list',function(){
	  var catid=$(this).val();
	  if($(this).is(':checked')){
			$('.procat_box_'+catid).css('display','table-row');
			$('#procat_name_'+catid).css('display','table-row');
			$('#procat_footer_row_'+catid).css('display','table-row');
			if(catid==11 || catid==9 || catid==8 || catid==7)//potency category
    		{
    			$.ajax({
			   type:"POST",
			   url:"<?= base_url();?>order/interaction_order/get_product_potency_list/",
			   data : 'id='+catid,
			   success:function(res){ 
					if(res){
						$(".procat_option_box_potency_"+catid).append(res);
					}

				}
				});	
    		}
			$.ajax({
			   type:"POST",
			   url:"<?= base_url();?>order/interaction_order/get_product_packsize_list/",
			   data : 'id='+catid,
			   success:function(res){ 
					if(res){
						$(".procat_option_box_packsize_"+catid).append(res);
					}

				}
			});		
	  }
	  else
	  {
		$('.procat_box_'+catid).css('display','none');
		$('#procat_name_'+catid).css('display','none');
		$('#procat_footer_row_'+catid).css('display','none');
	  }
  });
   
</script>



<!-- Get details of product on product change -->





<script type='text/javascript'>
    $(".add_row").on("click", function(e) {
  		// alert('asa');
    	var theElement = $(this);
    	var catid=$(this).attr("catid");
    	//alert(catid);
    	if(catid==11 || catid==9 || catid==8 || catid==7)
    	{
    	var strVar = '<tr id="" class="product_row procat_box_'+catid+' "> <td> <select catid="'+catid+'" name="product_potency[]" id="" class="product_select_potency form-control  procat_option_box_potency_'+catid+'" style="width: 100%;"></td><td> <select catid="'+catid+'" name="product_packsize[]" id="" class="product_select_packsize form-control procat_option_box_packsize_'+catid+'" style="width: 100%;"></td><td> <select catid="'+catid+'" name="product_name[]" id="" class="product_select form-control select2 procat_option_box_'+catid+'" style="width: 100%;"></td><td><input id="" class="form-control pro_mrp_val" name="pro_mrp_val[]" type="text" readonly value=""></td><td><input id="" class="form-control pro_qnty" name="pro_qnty[]"type="text" value=""></td><td><input id="" class="form-control pro_dis" name="pro_dis[]" type="text" value=""></td><td><input id="" class="form-control pro_amt" type="text" name="pro_amt[]" readonly value="0"></td><td><button type="button" catid="<?= $category['category_id'] ?>" class="btn btn-danger pull-right delete_row">Delete Product</button></td></tr>';
    	 	$(theElement).closest('tr').before(strVar);
    	 }
    	 else if(catid==1 || catid==2 || catid==3 || catid==4 || catid==6 || catid==10)
    	 {
    	 	var strVar = '<tr id="" class="product_row procat_box_'+catid+' "> <td></td><td> <select catid="'+catid+'" name="product_packsize[]" id="" class="product_select_packsize form-control  procat_option_box_packsize_'+catid+'" style="width: 100%;"></td><td> <select catid="'+catid+'" name="product_name[]" id="" class="product_select form-control select2 procat_option_box_'+catid+'" style="width: 100%;"></td><td><input id="" class="form-control pro_mrp_val" name="pro_mrp_val[]" type="text" readonly value=""></td><td><input id="" class="form-control pro_qnty" name="pro_qnty[]"type="text" value=""></td><td><input id="" class="form-control pro_dis" name="pro_dis[]" type="text" value=""></td><td><input id="" class="form-control pro_amt" type="text" name="pro_amt[]" readonly value="0"></td><td><button type="button" catid="<?= $category['category_id'] ?>" class="btn btn-danger pull-right delete_row">Delete Product</button></td></tr>';
    	 	$(theElement).closest('tr').before(strVar);
    	 }
    	
    });
  
</script>

 <script type='text/javascript'>
	
    $(document).on("click",".product_select_packsize", function() {
  		var catid=$(this).attr("catid");
  		//alert(catid);
  		var theElement = $(this);
  		var procount=$(theElement).has('option').length;
  		if(procount==0)
  		{
  			var option='<option vlaue="">---Select Product---</option>';
   			$.ajax({
			   type:"POST",
			   url:"<?= base_url();?>order/interaction_order/get_product_packsize_list/",
			   data : 'id='+catid,
			   success:function(res){ 
					$(theElement).append(res);
				}
			});
   		}
    });
  
</script>


 <script type='text/javascript'>
	
    $(document).on("click",".product_select_potency", function() {
  		var catid=$(this).attr("catid");
  		//alert(catid);
  		var theElement = $(this);
  		var procount=$(theElement).has('option').length;
  		if(procount==0)
  		{
  			var option='<option vlaue="0">---Select Potency---</option>';
   			$.ajax({
			   type:"POST",
			   url:"<?= base_url();?>order/interaction_order/get_product_potency_list/",
			   data : 'id='+catid,
			   success:function(res){ 
					$(theElement).append(res);
				}
			});
   		}
    });
  
</script>

<script type='text/javascript'>
	
    $(document).on("change",".product_select_packsize", function() {
  		var catid=$(this).attr("catid");
  		var packsize=$(this).val();
  		var theElement = $(this);
  		if(catid==11 || catid==9 || catid==8 || catid==7)
    	{
    		var potency=$(theElement).closest('tr').find('.product_select_potency').val();
    		if(potency!='' || !$.isEmptyObject(potency))
    		{
    			if(!$.isEmptyObject(packsize)){
	    			$.ajax({
					   type:"POST",
					   url:"<?= base_url();?>order/interaction_order/get_product_list/",
					   data : 'catid='+catid+'&packsize='+packsize+'&potency='+potency,
					   success:function(res){ 
							//$(theElement).append(res);
							$(theElement).closest('tr').find('.product_select').html(res);
						}
					});
	    		}
    		}
    	}
		else if(catid==1 || catid==2 || catid==3 || catid==4 || catid==6 || catid==10)
		{
   			$.ajax({
			   type:"POST",
			   url:"<?= base_url();?>order/interaction_order/get_product_list/",
			   data : 'catid='+catid+'&packsize='+packsize,
			   success:function(res){ 
					//$(theElement).append(res);
					$(theElement).closest('tr').find('.product_select').html(res);
				}
			});
	   	}
    });
  
</script>

<script type='text/javascript'>
	
    $(document).on("change",".product_select_potency", function() {
  		var catid=$(this).attr("catid");
  		var potency=$(this).val();
  		var theElement = $(this);
		var packsize=$(theElement).closest('tr').find('.product_select_packsize').val();
		if(packsize!='')
		{
			if(!$.isEmptyObject(packsize)){
				$.ajax({
				   type:"POST",
				   url:"<?= base_url();?>order/interaction_order/get_product_list/",
				   data : 'catid='+catid+'&packsize='+packsize+'&potency='+potency,
				   success:function(res){ 
						//$(theElement).append(res);
						$(theElement).closest('tr').find('.product_select').html(res);
					}
				});
			}
		}


    });
  
</script>

 <script type='text/javascript'>
    $(document).on("click",".delete_row", function() {
    		var theElement = $(this);
  			$(theElement).closest('tr').remove();
  			var extratitles = document.getElementsByName('pro_amt[]');
			var str = 0;
			for (var i = 0; i < extratitles.length; i++) { 
				var inp=extratitles[i];
				 str=str+parseFloat(inp.value);
			}
			$('#tot_amt').val(parseFloat(str).toFixed(2));
   		
    });
   
</script>
 <script type='text/javascript'>
    $(function(){
 		$('body').on('DOMNodeInserted', 'select', function () {
	        $('.select2').select2({selectOnClose: true}).on("select2:select", function(e) {
	        	//alert('sdfds');
	    	var productId= $(this).val();
	    	var theElement = $(this);
	    	var catid=$(this).attr("catid");

			$.ajax({
			   type:"POST",
			   url:"<?= base_url();?>order/interaction_order/get_product_details/",
			   data : 'productid='+productId,
			   success:function(res){ 
					if(res){
						var data = $.parseJSON(res);
						if(data!=false)
						{
							$(theElement).closest('tr').find('.pro_mrp_val').val(data[0].product_price);
							var qunatity=$(theElement).closest('tr').find('.pro_qnty').val();
		  					var dis=$(theElement).closest('tr').find('.pro_dis').val();
		  					var amount=data[0].product_price;
		  					var net_amount=(amount-((amount*dis)/100))*qunatity;
							$(theElement).closest('tr').find('.pro_amt').val(parseFloat(net_amount).toFixed(2));
							var extratitles = document.getElementsByName('pro_amt[]');
							var str = 0;
							for (var i = 0; i < extratitles.length; i++) { 
								var inp=extratitles[i];
								str=str+parseFloat(inp.value);
							}
							$('#tot_amt').val(parseFloat(str).toFixed(2));
						}
						else
						{
							$(theElement).closest('tr').find('.pro_mrp_val').val(0);
							$(theElement).closest('tr').find('.pro_dis').val(0);
							$(theElement).closest('tr').find('.pro_qnty').val(0);
							var qunatity=0;
		  					var dis=0;
		  					var amount=0;
		  					var net_amount=(amount-((amount*dis)/100))*qunatity;
							$(theElement).closest('tr').find('.pro_amt').val(parseFloat(net_amount).toFixed(2));
							var extratitles = document.getElementsByName('pro_amt[]');
							var str = 0;
							for (var i = 0; i < extratitles.length; i++) { 
								var inp=extratitles[i];
								str=str+parseFloat(inp.value);
							}
							$('#tot_amt').val(parseFloat(str).toFixed(2));
						}
					}
				}
			});
   	 	});
    });
  
 });
   
</script>

<script type='text/javascript'>
    
    $(document).on("blur",".pro_dis ", function() {
	    var theElement = $(this);
	  	var dis =$(theElement).val();
	  	var qunatity=$(theElement).closest('tr').find('.pro_qnty').val();
	  	var amount=$(theElement).closest('tr').find('.pro_mrp_val').val();
	   	if(dis!=''){
			if(dis<100){
				var net_amount=(amount-((amount*dis)/100))*qunatity;
				$(theElement).closest('tr').find('.pro_amt').val(parseFloat(net_amount).toFixed(2));
				var extratitles = document.getElementsByName('pro_amt[]');
				var str = 0;
				for (var i = 0; i < extratitles.length; i++) { 
					var inp=extratitles[i];
					 str=str+parseFloat(inp.value);
				}
				$('#tot_amt').val(parseFloat(str).toFixed(2));
			}
			else
			{
				alert('Please Enter Discount Below 100');
			}
		}
		else{
			alert('Please Enter Discount Greater or equal 0');
		}
    });
</script>

<script type='text/javascript'>
    
    $(document).on("blur",".pro_qnty", function() {
	    var theElement = $(this);
	    var qunatity=$(theElement).val();
	  	var dis=$(theElement).closest('tr').find('.pro_dis').val();
	  	var amount=$(theElement).closest('tr').find('.pro_mrp_val').val();
	   if(qunatity!=''){
       		if(qunatity>0){
       			
				var net_amount=(amount-((amount*dis)/100))*qunatity;
				$(theElement).closest('tr').find('.pro_amt').val(parseFloat(net_amount).toFixed(2));
				var extratitles = document.getElementsByName('pro_amt[]'); 
		    	var str = 0;
				for (var i = 0; i < extratitles.length; i++) { 
					var inp=extratitles[i];
					 str=str+parseFloat(inp.value);
				}
				$('#tot_amt').val(parseFloat(str).toFixed(2));
			}
			else	
	        {		
	            alert('Please Enter Quantity greater than 1');	
	        }	
        }	
        else{	
            alert('Please Enter Quatity Greater or equal 1');
        }
});
</script>