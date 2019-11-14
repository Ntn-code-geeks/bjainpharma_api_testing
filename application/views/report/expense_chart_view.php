<?php
/*
* Niraj Kumar
* Dated: 30-oct-2017
*
* Show Report Details
*
*/
 

 // $pharmacy_list =json_decode($pharma_list);
//pr($dealer_list); die;

?>
<!--<link href="<?= base_url()?>design/css/div_table/one.css" rel="stylesheet" type="text/css"/>-->
<style type="text/css">
  .highcharts-credits{
    display: none
  }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?= base_url()?>design/js/highcharts.js"></script>
<script src="<?= base_url()?>design/js/exporting.js"></script>
<div class="content-wrapper">
  
  <!-- Main content -->
  <section class="content">
    <?php echo get_flash(); ?>
    
    
          <div class="box box-success">
            <!--<div class="box box-primary">-->
            
            <div class="box-header">
              <h3 class="box-title"></h3>
            </div>
          <div class="box-body">
              <div class="row">
                <div id = "container" style = ""></div>
              </div>
          <!-- /.box -->
        </div>
        <!-- /.col (left) -->
      </div>
      
    <!--            </div>
    /.box
  </div>
  /.col
</div>-->
<!-- /.row -->
</section>
<!-- /.content -->
</div>
<script language = "JavaScript">
  $(document).ready(function() {
  var title = {
  text: "Expense Chart of <?=$user?>"  
  };
  var subtitle = {
  text: 'Source: BJain '
  };
  var xAxis = {
  categories: <?php echo json_encode($range);?>,
  title: {
  text: 'Date of Inteaction  '
  },
  };
  var yAxis = {
  title: {
  text: 'Expense In rupees '
  },
  plotLines: [{
  value: 0,
  width: 1,
  color: '#808080'
  }]
  };   
  var plotOptions = {
               line: {
                  dataLabels: {
                     enabled: true
                  },   
                  //enableMouseTracking: false
               }
            };
  var tooltip = {
  valueSuffix: ' rs.'
  }
  var legend = {
  layout: 'vertical',
  align: 'right',
  verticalAlign: 'middle',
  borderWidth: 0
  };
  var series =  [{
  name: 'Expense',
  color: '#FF0000',

  data: <?php echo json_encode($expense_chart);?>
  }, 
  {
  name: 'Sencondary Sale',
  color:'#008000',
  data: <?php echo json_encode($sale_chart);?>
  }, 
  ];
  
  var exporting= {
        filename: '<?=$user?>'
    }

  var json = {};
  json.title = title;
  json.subtitle = subtitle;
  json.xAxis = xAxis;
  json.yAxis = yAxis;
  json.tooltip = tooltip;
  json.legend = legend;
  json.series = series;
  json.plotOptions = plotOptions;
   json.exporting = exporting;
  $('#container').highcharts(json);
  });
</script>