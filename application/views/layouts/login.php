<?php $loggedData=logged_user_data();?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
    <head>
    	<meta charset="utf-8">
        <title><?php echo isset($page_title)?$page_title:ucfirst($this->uri->rsegments[1]);?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <?php $this->load->view("elements/head");?>
    </head>

    <body class="login">
        <div class="menu-toggler sidebar-toggler">
        </div>
        <div class="logo">
            <a href="<?php echo URL;?>">
                <img src="<?php echo AURL;?>img/logo.png" alt="logo" class="logo-default"/>
            </a>
        </div>
        
        <div class="content">
            <?php $this->load->view($page_view, array('loggedData'=>$loggedData));?>
        </div>
        
        <div class="copyright">
            <?php echo date('Y');?> © crm. Admin Panel.
        </div>
       
        <?php $this->load->view("elements/footer");?>
        <script src="<?php echo base_url('assets/backend/pages/scripts/login.js');?>" type="text/javascript"></script>
        
        <script>
		jQuery(document).ready(function() {       
			Metronic.init();
			Layout.init();
			Login.init();
		});
		</script>
    </body>
</html>
