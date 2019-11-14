<?php

/**
 * Developer : Shailesh Saraswat
 * Dated: 10-July-2018
 * Email: sss.shailesh@gmail.com
 * 
 * View for Compose An Email 
 * 
 */
//pr($qutation_data);
//pr($email_list_data); die;

?>
  <style>
    #example_filter label {width: 100%;}
    #example_filter .input-sm{width: 80% !important;margin-left: 5px;}
</style>
<script src="<?= base_url()?>design/ajax_googleapis/jquery.min.js" type="text/javascript"></script>

  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?= base_url()?>design/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  
  
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Mail
        <!--<small>13 new messages</small>-->
      </h1>
      <ol class="breadcrumb">
          <li><a href="<?= base_url()?>user/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php echo form_open_multipart($action); ?>
        
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <?php echo get_flash(); ?>
              <h3 class="box-title">Compose Mail</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong>Select Mail to : </strong><br>
                <input type="radio" name="mail_to" value="pharma.reports@bjain.com" checked >&nbsp;&nbsp;To Admin &nbsp;&nbsp;
                <input type="radio" name="mail_to" value="pharmahr@bjain.com">&nbsp;&nbsp; To HR &nbsp;&nbsp;
                <input type="radio" name="mail_to" value="orderadmin@bjain.com" >&nbsp;&nbsp; For Order related &nbsp;&nbsp; 
                <input type="radio" name="mail_to" value="research2@bjain.com" >&nbsp;&nbsp; For Quality related &nbsp;&nbsp;
                <br><br>
              <div class="form-group">
                <input required class="form-control" name="subject" id="subject" placeholder="Subject:">
              </div>
              <div class="form-group">
                <textarea required id="compose-textarea" name="body" class="form-control" style="height: 300px"><?=set_value('body')?></textarea>
              </div>
              <div class="form-group">
                <label>Attach File </label>
                <input type="file" name="file1" id="file">
                <span class="control-label" for="" style="">File type allowed jpg,jpeg,png only.</span>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="pull-right">
                <!--<button type="button" class="btn btn-default"><i class="fa fa-pencil"></i> Draft</button>-->
                <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
              </div>
              <!--<button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>-->
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /. box -->
        </div>
        <?php echo form_close(); ?>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  
  <!-- Bootstrap WYSIHTML5 -->

<!--<script src="<?= base_url()?>design/bower_components/select2/dist/js/select2.full.min.js"></script>-->

<!-- Page Script -->
<script>
  $(function () {
    $("#compose-textarea").wysihtml5();
  });
</script>
