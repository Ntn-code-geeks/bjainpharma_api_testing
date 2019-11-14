<?php



/* 

 * Niraj Kumar

 * Dated: 06-03-2018

 * 

 * Show Travell Report 

 * 

 */



$user_list = json_decode($users);





//pr($dealer_list); die;

 

?>

<!--<link href="<?= base_url()?>design/css/div_table/one.css" rel="stylesheet" type="text/css"/>-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>



<div class="content-wrapper">

   

    <!-- Main content -->

    <section class="content">



   <?php echo get_flash(); ?>

       

        



          <div class="box box-success">

            <!--<div class="box box-primary">-->

            

            <div class="box-header">

              <h3 class="box-title">Get Report</h3>

            </div>

            <?php

            echo form_open($action);

            ?>

            <div class="box-body">

			<div class="row">

			<div class="col-md-7">

              <!-- Date range -->

              <div class="form-group">

                <label>Report Date range:</label>



                <div class="input-group">

                  <div class="input-group-addon">

                    <i class="fa fa-calendar"></i>

                  </div>

                  <input readonly name="report_date" class="form-control pull-right" id="reservation" type="text" value="<?php echo date('d/m/Y').' - '. date('d/m/Y'); ?>">

                </div>

                <!-- /.input group -->

              </div>

              <!-- /.form group -->



              <!-- Date and time range -->

             

              <!-- /.form group -->

           

              <!-- Date and time range -->

              <div class="form-group">

<!--                <label></label>-->



                <div class="input-group">

                  <button type="submit" class="btn btn-default pull-right">

                   Submit

                  </button>

                </div>

              </div>

              <!-- /.form group -->



            </div>

			</div>

          <!-- /.box -->



        </div>

        <!-- /.col (right) -->

      </div>

            <!-- /.box-body -->

         <?php echo form_close(); ?>

          

            

<!--            </div>

           /.box 

        </div>

         /.col 

      </div>-->

      <!-- /.row -->

    </section>

    <!-- /.content -->

  </div>



<script type="text/javascript">

    $(function(){

        

 $('.select3').select2();

 

 $('.select4').select2();

 

	});

</script>