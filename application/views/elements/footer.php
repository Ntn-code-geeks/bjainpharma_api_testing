<?php



/* 

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */

?>



<!-- jQuery 3 -->

<script src="<?php echo base_url();?>design/bower_components/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap 3.3.7 -->

<script src="<?php echo base_url();?>design/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- iCheck -->

<script src="<?php echo base_url();?>design/plugins/iCheck/icheck.min.js"></script>

<!-- fullCalendar -->

<script src="<?php echo base_url();?>design/bower_components/jquery-ui/jquery-ui.min.js"></script>

<script src="<?php echo base_url();?>design/bower_components/moment/moment.js"></script>

<script src="<?php echo base_url();?>design/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>

 <!--Select2--> 

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

<!--<script src="<?php echo base_url();?>design/bower_components/Chart.js/Chart.js"></script>-->

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->

<!--<script src="<?php //echo base_url();?>design/js/pages/dashboard2.js"></script>-->

<!-- DataTables -->

<script src="<?= base_url()?>design/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>

<script src="<?= base_url()?>design/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?= base_url()?>design/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<script src="<?= base_url()?>design/js/highcharts.js"></script>
<script src="<?= base_url()?>design/js/exporting.js"></script>

<script type="text/javascript">

   

    

    

  $(function () {

    //Initialize Select2 Elements

//  var $eventSelect= $('.select2').select2();

//   $('.select3').select2();

//   $eventSelect.on("change", function (e) {   

//       

//        var schoolid = $(this).val();  

//    if(schoolid=='none'){

// 

//   $("#school_name").css("display", "block");

//   $("#school_city").css("display", "block");

//   $('#box_school').css('display','block');

//       

//    }

//    else{

//        $("#school_name").css("display", "none");

//   $("#school_city").css("display", "none");

//   $('#box_school').css('display','none');

//    }

//    

//    });



    //Datemask dd/mm/yyyy

    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })

    //Datemask2 mm/dd/yyyy

    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })

    //Money Euro

    $('[data-mask]').inputmask()



    //Date range picker

    $('#reservation').daterangepicker(

            {       

    locale: {

      format: 'DD/MM/YYYY'

    },

   

}

            );

     $('#reservation2').daterangepicker(

             

             {       

    locale: {

      format: 'DD/MM/YYYY'

    },

   

}

                );

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

<!--<script> 

  $(function () {

    $('input').iCheck({

      checkboxClass: 'icheckbox_square-blue',

      radioClass: 'iradio_square-blue',

      increaseArea: '20%' // optional

    });

  });

</script>-->

<!-- <script>
  document.onkeydown = function(e) {
        if (e.ctrlKey      || 
            e.keyCode === 117 ||
            e.keyCode === 123) {
            //alert('not allowed');
            return false;
        } else {
            return true;
        }
};
document.onmousedown=disableclick;
status="Right Click Disabled";
function disableclick(e)
{
  if(e.button==2)
   {
     alert(status);
     return false;  
   }
}
</script>   -->