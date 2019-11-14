<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$appointment_data = json_decode($ap_list);
//pr($appointment_data); die;

?>
<!-- fullCalendar -->
  <link rel="stylesheet" href="<?php echo base_url();?>design/bower_components/fullcalendar/dist/fullcalendar.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>design/bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
 
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
                <small><a href="<?= base_url();?>appointment/appoint/add_appointment"> 
                    <button type="button" class="btn btn-block btn-success">Add New</button>
                </a></small>
        
      </h1>
        
<!--      <ol class="breadcrumb">
        <li><a href="<?= base_url();?>user/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Appointment view</li>
      </ol>-->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
          <?php echo get_flash(); ?>

        <!-- /.col -->
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-body no-padding">
              <!-- THE CALENDAR -->
              <div id="calendar"></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      
      
      <div class="modal modal-info fade" id="modal-info">
          <div class="modal-dialog">
             
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                  <span id="modeltime"></span> to <span id="modalEndtime"></span>
                  <h4 id="modalTitle" class="modal-title"></h4>
                  
              </div>
              <div class="modal-body" id="modalBody">
                  <!--<input class="form-control" type="text"  value="">-->
                <!--<p>One fine body&hellip;</p>-->
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
<!--                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Interaction</button>-->
                
<!--                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_info_interaction">
                 Interaction
                 </button>-->
               <p id="interaction"></p>
                <p id="edit_model"></p>
              </div>
            </div>
             
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
    
      
    </section>
    <!-- /.content -->
  </div>
</div>

<!-- jQuery 3 -->
<script src="<?php echo base_url();?>design/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url();?>design/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url();?>design/plugins/iCheck/icheck.min.js"></script>

<!-- Select2 -->
<script src="<?php echo base_url();?>design/bower_components/select2/dist/js/select2.full.min.js"></script>

<!-- InputMask -->
<script src="<?php echo base_url();?>design/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo base_url();?>design/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo base_url();?>design/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="<?php echo base_url();?>design/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>design/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="<?php echo base_url();?>design/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="<?php echo base_url();?>design/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="<?php echo base_url();?>design/plugins/timepicker/bootstrap-timepicker.min.js"></script>



<!-- FastClick -->
<script src="<?php echo base_url();?>design/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url();?>design/js/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url();?>design/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="<?php echo base_url();?>design/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url();?>design/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url();?>design/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url();?>design/bower_components/Chart.js/Chart.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="<?php //echo base_url();?>design/js/pages/dashboard2.js"></script>-->
<!-- fullCalendar -->

<script src="<?php echo base_url();?>design/bower_components/moment/moment.js"></script>
<script src="<?php echo base_url();?>design/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>

<script src="<?php echo base_url();?>design/bower_components/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript">
  $(function () {
var currentLangCode = 'en';

        // build the language selector's options
        $.each($.fullCalendar.langs, function(langCode) {
            $('#lang-selector').append(
                $('<option/>')
                    .attr('value', langCode)
                    .prop('selected', langCode == currentLangCode)
                    .text(langCode)
            );
        });

        // rerender the calendar when the selected option changes
        $('#lang-selector').on('change', function() {
            if (this.value) {
                currentLangCode = this.value;
                $('#calendar').fullCalendar('destroy');
                renderCalendar();
            }
        });
    /* initialize the external events
     -----------------------------------------------------------------*/
    function init_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    init_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()
    $('#calendar').fullCalendar({
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'today',
        month: 'month',
        week : 'week',
        day  : 'day'
      },
      eventClick:  function(event, jsEvent, view) {
		 
            $('#modalTitle').html(event.title);
            $('#modalBody').html(event.description);
            $('#modalEndtime').html(event.endtime);
            $('#modeltime').html(event.time);
            $('#edit_model').html(event.link);
            $('#interaction').html(event.link2);
            $('#modal-info').modal();
        },
      //Random default events
      events    : <?=$ap_list?>,
      
                buttonIcons: false, // show the prev/next text
//                weekNumbers: true,
               
                eventLimit: true, 

    });
 
  })
</script>
<script>
  $(function () {
    //Initialize Select2 Elements
  var $eventSelect= $('.select2').select2();
   $('.select3').select2();
   $eventSelect.on("change", function (e) {   
       
        var schoolid = $(this).val();  
    if(schoolid=='none'){
 
   $("#school_name").css("display", "block");
   $("#school_city").css("display", "block");
       
    }
    else{
        $("#school_name").css("display", "none");
   $("#school_city").css("display", "none");
    }
    
    });

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Date picker
    $('#datepicker').datepicker({
              autoclose: true
    })

//    //iCheck for checkbox and radio inputs
//    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
//      checkboxClass: 'icheckbox_minimal-blue',
//      radioClass   : 'iradio_minimal-blue'
//    })
//    //Red color scheme for iCheck
//    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
//      checkboxClass: 'icheckbox_minimal-red',
//      radioClass   : 'iradio_minimal-red'
//    })
//    //Flat red color scheme for iCheck
//    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
//      checkboxClass: 'icheckbox_flat-green',
//      radioClass   : 'iradio_flat-green'
//    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>

<?php 
// below script for stylish radio and checkbox button
?>
<script> 
    $('#modal-info').click(function(){
        
        var text = $('#modalTitle').text();
           $uu  =   text;
    alert(<?php echo $uu;?>);
    })
    
//  $(function () {
//    $('input').iCheck({
//      checkboxClass: 'icheckbox_square-blue',
//      radioClass: 'iradio_square-blue',
//      increaseArea: '20%' // optional
//    });
//  });
</script>
<script type="text/javascript">
    $(function(){
       
        var $eventSelect2=  $('.select7').select2();
       $eventSelect2.on("change", function (e) {   
       
        var schoolid = $(this).val();
              
          var gsid =  $(this).closest('form').find('.gs_id').val;
      
//       alert(gsid);
        var gsid = document.getElementsByClassName('gs_id');
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
            for (i = 0; i < gsid.length; i++) {
            $("#sub_meeting_group_school"+gsid[i].value).html(res);
               }

            }

           }
             
        });
    }
 
    });
       
       
    });

</script>

