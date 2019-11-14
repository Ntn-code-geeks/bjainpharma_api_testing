<?php

/* 

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */
/*$url="https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=201301&destinations=201307&mode=transit&key=AIzaSyCR0sPg9k9PZJ7mBOSJiHxsUkPY96MJCtg";
$url="https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=201301&destinations=201307&key=AIzaSyCR0sPg9k9PZJ7mBOSJiHxsUkPY96MJCtg";
$api = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=201301&destinations=201307&mode=bicycling&key=AIzaSyCR0sPg9k9PZJ7mBOSJiHxsUkPY96MJCtg");
            $data = json_decode($api);
            pr($data);
            die;
$api = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=201301&destinations=201307&key=AIzaSyCR0sPg9k9PZJ7mBOSJiHxsUkPY96MJCtg");
            $data = json_decode($api);
            pr($data);
            die;*/
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>





<div class="content-wrapper">



    <!-- Main content -->

    <section class="content">

    <?php echo get_flash(); ?>

      <!-- Contact Add -->

      <div class="box box-default">

        <div class="box-header with-border">

          <h3 class="box-title">Add Tour Plan</h3>



        </div>

        <!-- /.box-header -->

        <div class="box-body">
          <?php echo form_open_multipart($action);?>
                <table id="example2" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Source City</th>
                    <th>Destination City </th>
                    <th>Start Time </th>
                    <th>End Time </th>
                    <th>Remark </th>
                    <th>Tour Date </th>
                  </tr>
               </thead>
                <tbody>
                     <?php 

                        $nextmonth = date('m')+1;
                        $year = date('Y');

                        // echo $nextmonth.'<br>';
                        
                        $lastday = date("t", strtotime($nextmonth));
                        $date1 = date('Y-m-', strtotime('+1 month'));

                        //die;
                       // $start_date = $date1.'01';
                        $start_date =$year.'-'.$nextmonth.'-01';
                  
                        $end_date = $year.'-'.$nextmonth.'-'.$lastday;

                        while (strtotime($start_date) <= strtotime($end_date)){
                         $tdate= date ("Y-m-d", strtotime($start_date));
                         $result=get_holiday_details( date('Y-m-d', strtotime($tdate)));
                            if($result) { ?>
                            <!-- for holiday -->
                            <tr>
                                <td>
                                  <select name="source_city[]" id="source_city"  class="form-control select2" style="width: 100%;">
                                    <option value="">--Select City --</option>
                                    <?php foreach($city_data as $city){ ?>   
                                   <option value="<?=$city['city_id']?>" ><?=$city['city_name'].'('.$city['state_name'].')'?></option><?php }  ?>
                                  </select>
                                </td>
                                <td>
                                  <select name="dest_city[]" id="dest_city"  class="form-control select2" style="width: 100%;">
                                    <option value="">--Select City--</option>
                                    <?php foreach($city_data as $city){ ?>   
                                    <option value="<?=$city['city_id']?>" ><?=$city['city_name'].'('.$city['state_name'].')'?></option><?php }  ?>
                                  </select>
                                </td>
                                <td>
                                  <div class="bootstrap-timepicker">
                                    <input readonly type="text" name="tour_st_time[]" id="tour_st_time" class="form-control timepicker"></div>
                                </td>
                                <td>
                                  <div class="bootstrap-timepicker">
                                    <input readonly type="text" name="tour_time_end[]" id="tour_time_end" class="form-control timepicker"></div>
                                </td>
                                <td>
                                  <textarea readonly class="form-control" rows="3" name="remark[]" id="remark" placeholder="About the Plan ..."><?php echo $result->remark;?></textarea>
                                  <span  style="color:green">Holiday.</span>
                                </td>
                                <td>
                                   <input readonly class="form-control pull-right" name="tour_date[]" value="<?php echo date ("d-m-Y", strtotime($start_date))?>" id="tour_date" type="text">
                                   <input class="form-control pull-right" name="assign_by[]" value="0" id="tour_date" type="hidden">
                                </td>
                              </tr>



                            <?php } else { 
                              $resulttask=get_assign_task( date('Y-m-d', strtotime($tdate)));
                              if($resulttask){

                              ?>
                               <tr>
                                <td>
                                  <select required="" name="source_city[]" id="source_city"  class="form-control select2" style="width: 100%;">
                                    <option value="">--Select City --</option>
                                    <?php foreach($city_data as $city){ ?>   
                                    <option value="<?=$city['city_id']?>" ><?=$city['city_name'].'('.$city['state_name'].')'?></option><?php }  ?>
                                  </select>
                                </td>
                                <td>
                                  <input readonly type="text" name="dest_city1[]" id="dest_city1" value ="<?=get_city_name($resulttask->destination)?>" class="form-control">
                                  <input  type="hidden" name="dest_city[]" id="dest_city" value="<?=$resulttask->destination; ?>" class="form-control">
    
                                </td>
                                <td>
                                  <div class="bootstrap-timepicker">
                                    <input readonly type="text" name="tour_st_time[]" id="tour_st_time" class="form-control timepicker"></div>
                                </td>
                                <td>
                                  <div class="bootstrap-timepicker">
                                    <input readonly type="text" name="tour_time_end[]" id="tour_time_end" class="form-control timepicker"></div>
                                </td>
                                <td>
                                  <textarea readonly class="form-control" rows="3" name="remark[]" id="remark" placeholder="About the Plan ..."><?php echo $resulttask->remark;?></textarea>
                                  <span  style="color:red">This task assign by <?php echo get_user_name($resulttask->assign_by)?> Sir.</span>
                                </td>
                                <td>
                                   <input readonly class="form-control pull-right" name="tour_date[]" value="<?php echo date ("d-m-Y", strtotime($start_date))?>" id="tour_date" type="text">
                                   <input class="form-control pull-right" name="assign_by[]" value="<?php echo $resulttask->assign_by;?>" id="tour_date" type="hidden">
                                </td>
                              </tr>


                             
                              <?php } else { 
                                $remark=get_followup( date('Y-m-d', strtotime($tdate)));
                                if( $remark!='')
                                {
                                ?>

                                 <tr>
                                <td>
                                  <select  name="source_city[]" id="source_city"  class="form-control select2" style="width: 100%;">
                                    <option value="">--Select City --</option>
                                    <?php foreach($city_data as $city){ ?>   
                                    <option value="<?=$city['city_id']?>" ><?=$city['city_name'].'('.$city['state_name'].')'?></option><?php }  ?>
                                  </select>
                                </td>
                                <td>
                                  <select  name="dest_city[]" id="dest_city"  class="form-control select2" style="width: 100%;">
                                    <option value="">--Select City--</option>
                                    <?php foreach($city_data as $city){ ?>   
                                    <option value="<?=$city['city_id']?>" ><?=$city['city_name'].'('.$city['state_name'].')'?></option><?php }  ?>
                                  </select>
                                </td>
                                <td>
                                  <div class="bootstrap-timepicker">
                                    <input readonly type="text" name="tour_st_time[]" id="tour_st_time" class="form-control timepicker"></div>
                                </td>
                                <td>
                                  <div class="bootstrap-timepicker">
                                    <input readonly type="text" name="tour_time_end[]" id="tour_time_end" class="form-control timepicker"></div>
                                </td>
                                <td>
                                  <textarea  class="form-control" rows="3" name="remark[]" id="remark" placeholder="About the Plan ..."><?php echo $remark;?></textarea>
                                   <span  style="color:blue">Pre Planned Follow Up.</span>
                                
                                </td>
                                <td>
                                   <input readonly class="form-control pull-right" name="tour_date[]" value="<?php echo date ("d-m-Y", strtotime($start_date))?>" id="tour_date" type="text">
                                   <input class="form-control pull-right" name="assign_by[]" value="0" id="tour_date" type="hidden">
                                </td>
                              </tr>


                                <?php } else { 
                                 ?>
                                <tr>
                                <td>
                                  <select name="source_city[]" id="source_city"  class="form-control select2" style="width: 100%;">
                                    <option value="">--Select City --</option>
                                    <?php foreach($city_data as $city){ ?>   
                                    <option value="<?=$city['city_id']?>" ><?=$city['city_name'].'('.$city['state_name'].')'?></option><?php }  ?>
                                  </select>
                                </td>
                                <td>
                                  <select name="dest_city[]" id="dest_city"  class="form-control select2" style="width: 100%;">
                                    <option value="">--Select City--</option>
                                    <?php foreach($city_data as $city){ ?>   
                                    <option value="<?=$city['city_id']?>" ><?=$city['city_name'].'('.$city['state_name'].')'?></option><?php }  ?>
                                  </select>
                                </td>
                                <td>
                                  <div class="bootstrap-timepicker">
                                    <input readonly type="text" name="tour_st_time[]" id="tour_st_time" class="form-control timepicker"></div>
                                </td>
                                <td>
                                  <div class="bootstrap-timepicker">
                                    <input readonly type="text" name="tour_time_end[]" id="tour_time_end" class="form-control timepicker"></div>
                                </td>
                                <td>
                                  <textarea <?php echo date('D',strtotime($start_date))=='Sun'?'readonly':'';?> class="form-control" rows="3" name="remark[]" id="remark" placeholder="About the Plan ..."><?php echo date('D',strtotime($start_date))=='Sun'?'Day is Sunday':'';?></textarea>
                                  <?php echo date('D',strtotime($start_date))=='Sun'?'<span  style="color:red">Sunday.</span>':'';?>
                                   
                                </td>
                                <td>
                                   <input readonly class="form-control pull-right" name="tour_date[]" value="<?php echo date ("d-m-Y", strtotime($start_date))?>" id="tour_date" type="text">

                                   <input class="form-control pull-right" name="assign_by[]" value="0" id="tour_date" type="hidden">
                                </td>
                              </tr>
                            <?php }}}?>
                  <?php $start_date = date ("Y-m-d", strtotime("+1 day", strtotime($start_date))); } ?>
                </tbody>
              </table>
       	  </div>
      		<div class="row">
              <div class="col-md-12">
                  <!--<div class="form-group">-->
                  <div class="box-footer">
      	           <button type="submit" class="btn btn-info pull-right">Save</button>
                  </div>
              </div>
          </div>
          <!-- /.row -->
         <?php echo form_close();  ?>
  </div>
        <!-- /.box-body -->
</div>
      <!-- /.box -->
</section>
    <!-- /.content -->
</div>

<script src="<?php echo base_url();?>design/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script type='text/javascript'>
  $('#datepickerend').datepicker({
              autoclose: true
    }) ;
    $(function(){
    $('.select2').select2();
    });
</script>