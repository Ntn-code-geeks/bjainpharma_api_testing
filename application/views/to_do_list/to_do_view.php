<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($todo_info_doc) || !empty($todo_info_doc) ){
$todo_doc=json_decode($todo_info_doc);
}

if(isset($todo_info_dealer) || !empty($todo_info_dealer) ){
$todo_dealer=json_decode($todo_info_dealer);
}

//pr($todo_dealer); die;
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
  
         <?php if(isset($todo_doc) || !empty($todo_dealer)){ ?>
       
       <h3  class="box-title" id="picker" style="text-align: center"><?="Today"?>
       
       </h3>
          <div class="box box-primary">
            <div class="box-footer clearfix no-border">
              <a href="<?= base_url()?>to_do_list/to_do/completed_list"><button class="btn btn-default pull-left">Completed TODO</button></a>  
              <!--<button type="submit" class="btn btn-default pull-right">Done</button>-->
            </div>
            <div class="box-header ui-sortable-handle" style="cursor: move;">
<!--              <i class="ion ion-clipboard"></i>

              <h3 class="box-title">To Do List</h3>-->
                 
             <button class="prev-day" type="button">Previous Day</button>
            
              <?= get_flash();?>
              <div class="box-tools pull-right">
                  <button class="next-day" type="button" style="margin-top: 5px;">Next Day</button>

              </div>
            </div>
              
              <?php echo form_open_multipart($action); ?>  
            <!-- /.box-header -->
            <div class="box-body">
              <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
             
              <ul class="todo-list ui-sortable" id="todo_datewise">
                <?php
                if(!empty($todo_doc)){
                foreach($todo_doc as $k=>$val){ ?>
                <li style="" class="">
 
                  <?php if(!empty($val->doc_name)){ ?>
                  <!-- checkbox -->
                  <input name="doc_id[]" value="<?=$val->id;?>" type="checkbox">
                     <!-- todo text -->
                  <span class="text"><?=$val->doc_name?></span>
               
                  
                <?php } } ?>
    
                </li>
                <?php } ?>
                
                   <?php 
                   if(!empty($todo_dealer)){
                   foreach($todo_dealer as $k=>$val){ ?>
                <li style="" class="">
 
                  <?php if(!empty($val->d_name)){ ?>
                  <!-- checkbox -->
                  <input name="d_id[]" value="<?=$val->id;?>" type="checkbox">
                     <!-- todo text -->
                  <span class="text"><?=$val->d_name?></span>
               
                  
                   <?php } } ?>
    
                </li>
                <?php } ?>

              </ul>
           <div class="box-footer clearfix no-border">
              <!--<a href="<?= base_url()?>to_do_list/to_do/completed_list"><button class="btn btn-default pull-left">Completed TODO</button></a>-->  
              <button type="submit" class="btn btn-default pull-right">Done</button>
            </div>
             
            </div>
              <?php echo form_close(); ?>
            <!-- /.box-body -->
            
            
          </div>
      
         <?php } else{ ?>
        <div class="box box-primary">
            <div class="box-header ui-sortable-handle" style="cursor: move;">
              <i class="ion ion-clipboard"></i>

              <h3 class="box-title">To Do List</h3>
              <?= get_flash();?>
              <div class="box-tools pull-right">

              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
             
              <ul class="todo-list ui-sortable">
                  <?php echo "No to Do List";?>
              </ul>
            </div></div>
         <?php } ?>
    </section>
</div>

<script type="text/javascript">
   $(function(){   
       var currentDate = new Date();  

$('.next-day').on("click", function () {
    var date = currentDate;
    
   date.setDate(date.getDate() + 1)
  $('#picker').html(getISODateTime(date));
   Call(date);
});

$('.prev-day').on("click", function () {
    var date = currentDate;
   date.setDate(date.getDate() - 1)
     $('#picker').html(getISODateTime(date));
    Call(date);
});
    });
   
   
    function Call(date)
{
         
//         alert("cityid");
         if(date){
        $.ajax({
           type:"POST",
           url:"<?= base_url();?>to_do_list/to_do/todo_datewise",
           data : 'followupdate='+getISODateTime(date),
           success:function(res){ 

            if(res){

            $("#todo_datewise").html(res);

            }
//            else{
//               $("#school_state").empty();
//            }
           }
             
        });
    }

    };
   
   
   function getISODateTime(d){
    // padding function
    var s = function(a,b){return(1e15+a+"").slice(-b)};

    // default date parameter
    if (typeof d === 'undefined'){
        d = new Date();
    };

    // return ISO datetime
    return d.getFullYear() + '-' +
        s(d.getMonth()+1,2) + '-' +
        s(d.getDate(),2) + ' ' ;
//        s(d.getHours(),2) + ':' +
//        s(d.getMinutes(),2) + ':' +
//        s(d.getSeconds(),2);
}
   
   
    </script>