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


?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
  
         <?php if(isset($todo_doc) || !empty($todo_doc)){ ?>
       <!--<h3  class="box-title" id="picker" style="text-align: center"><?="Today"?></h3>-->
          <!--<div class="box box-primary">-->
            <div class="box box-default collapsed-box">
                
                
         <div class="box-header with-border">
         <button type="button" class="btn btn-box-tool" data-widget="collapse"> <h3 class="box-title" >To Do Completed Task</h3>
         </button>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
    <?php // } ?>
              
              <?php foreach($todo_doc as $k=>$val){ 
                     
                     $current = strtotime($val->fup);
//    if($k!=0){
                     ?>  
            <!-- /.box-header -->
            <div class="box-body">
              <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
             
              <ul class="todo-list ui-sortable" id="todo_datewise">
               
                <li style="" class="">

                  <span class="text"><?=$val->doc_name?></span>
                
                  <small class="label label-danger"><i class="fa fa-clock-o"></i><?=date('D-d-m-Y', strtotime($val->fup));?></small>

                </li>
              

              </ul>
             
            </div>  <?php } ?>
            <!-- /.box-body -->
           <?php if(isset($todo_dealer) || !empty($todo_dealer)){ ?> 
             <?php foreach($todo_dealer as $k_d=>$val_d){ 
                     
                     $current = strtotime($val_d->fup);
//    if($k!=0){
                     ?>  
            <!-- /.box-header -->
            <div class="box-body">
              <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
             
              <ul class="todo-list ui-sortable" id="todo_datewise">
               
                <li style="" class="">

                  <span class="text"><?=$val_d->d_name?></span>
                
                  <small class="label label-danger"><i class="fa fa-clock-o"></i><?=date('D-d-m-Y', strtotime($val->fup));?></small>

                </li>
              

              </ul>
             
           </div>  <?php } } ?><!-- /.box-body -->
            
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
                  <?php echo "No to Do Completed List";?>
              </ul>
            </div></div>
         <?php } ?>
    </section>
</div>
