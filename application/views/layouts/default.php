<?php $loggedData=logged_user_data();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=$title?> | Bjain Pharma</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<?php $this->load->view("elements/header");?>
</head>
	
<!--	<body class="hold-transition skin-blue sidebar-mini">-->
        <?php // $this->load->view("elements/header", array('loggedData'=>$loggedData));
        if($this->session->userdata('userId') && $this->session->userdata('SiteUrl_id')== base_url()){
            
            $this->load->view("elements/top_bar");    
            $this->load->view("elements/left_sidebar"); 
          
        }
        ?>
	<?php // $this->load->view($page_view, array('loggedData'=>$loggedData));
                        $this->load->view($page_view);
           ?>

        <?php if($page_view!='appointment/appoint_details_view'){$this->load->view("elements/footer");}?>
 <?php  
          $switchStatus= $this->session->userdata('switchStatus') ? $this->session->userdata('switchStatus'):0;
          if($switchStatus==1){  // this condition is for admin user ?>
			<script type="text/javascript">
			 function userSwitch(userId){
							$.ajax({
								url:"<?= base_url()?>user/switch_account",
								type:"POST",
								data:{userId:userId},
								success : function(response){
									if(response){
										location.href="<?= base_url()?>user/dashboard?tab=dashboard";
									}else{
										alert("Sorry, try later!");
									}
								}
							});
						}

			</script>
          <?php } ?>

    </body>
</html>
