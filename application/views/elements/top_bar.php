<?php



/* 

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */

$users = json_decode(users_list_pharma());

//pr(logged_user_cities()); die;

?>

<style>
#myInput {
	background-position: 10px 12px;
	background-repeat: no-repeat;
	width: 96%;
	font-size: 15px;
	padding: 5px;
	margin: 5px;
	border: 1px solid #ddd;
}
</style>
<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">

<header class="main-header">



    <!-- Logo -->

   

      <a href="http://bjainpharma.com/" class="logo">

          <img style="height: 43px;" src="<?=base_url();?>/design/bjain_pharma/bjain_logo.png" alt=""/>

   

      </a>

    

<!--<button onclick="history.go(-1);"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>-->









    <!-- Header Navbar: style can be found in header.less -->

    <nav class="navbar navbar-static-top">

      <!-- Sidebar toggle button-->

      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">

        <span class="sr-only">Toggle navigation</span>

      </a>

      

      <div class="menu_name" style="display: inline-block;">

      <h3 style="margin: 0px;text-align: center;padding-right: 80px;">

          

     <?php

     if(isset($page_name)){

     echo $page_name;

     }

     ?>

        <!--<small>advanced tables</small>-->

      </h3>

<!--      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>

        <li class="active"><a href="#">School Details view</a></li>

        <li class="active">Data tables</li>

      </ol>-->

    </div>

      

      <!-- Navbar Right Menu -->

      <div class="navbar-custom-menu">

        <ul class="nav navbar-nav">

          <!-- Switch Users: for different account for admin-->

          <?php  

          $switchStatus= $this->session->userdata('switchStatus') ? $this->session->userdata('switchStatus'):0;

          if($switchStatus==1){  // this condition is for admin user ?>

          <li class="dropdown messages-menu">

            <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                

                <img src="<?= base_url()?>design/img/switch_user/user_switch-512.png" alt="" width="20px"/>

<!--              <i class="fa fa-envelope-o"></i>-->

              <span class="label bg-orange">Switch User</span>

            </a>

            <ul class="dropdown-menu" style="max-height: 300px;overflow-y: auto; overflow-x: hidden;" >
			<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for users" title="Type in a name">
              <li class="header">Users Are</li>

              <li>

                 

                <ul class="menu" id="myUL" style="max-height:none;">

                  <?php foreach ($users as $k=>$val){ ?>

                  <li>

                    <a href="#" onClick="userSwitch(<?php echo $val->userid;?>);">

                      <h4 style="margin:0px">

                        <?=$val->username?>                       

                      </h4>

                    </a>

                  </li>

                  <?php } ?>

                  

 

                </ul>

              </li>

<!--              <li class="footer"><a href="#">See All Messages</a></li>-->

            </ul>

          </li>

          <?php }?>

          <!-- /. Switch Users: for different account for admin-->

          <!-- Notifications: style can be found in dropdown.less -->

<!--          <li class="dropdown notifications-menu">

            <a href="#" class="dropdown-toggle" data-toggle="dropdown">

              <i class="fa fa-bell-o"></i>

              <span class="label label-warning">10</span>

            </a>

            <ul class="dropdown-menu">

              <li class="header">You have 9 notifications</li>

              <li>

                 inner menu: contains the actual data 

                <ul class="menu">

                  <li>

                    <a href="#">

                      <i class="fa fa-users text-aqua"></i> 5 Tasks today

                    </a>

                  </li>

                  <li>

                    <a href="#">

                      <i class="fa fa-warning text-yellow"></i> 4 Appointment Today

                    </a>

                  </li>



                </ul>

              </li>

              <li class="footer"><a href="#">View all</a></li>

            </ul>

          </li>-->

          <!-- Tasks: style can be found in dropdown.less -->

<!--          <li class="dropdown tasks-menu">

            <a href="#" class="dropdown-toggle" data-toggle="dropdown">

              <i class="fa fa-flag-o"></i>

              <span class="label label-danger">9</span>

            </a>

            <ul class="dropdown-menu">

              <li class="header">You have 9 tasks</li>

              <li>

                 inner menu: contains the actual data 

                <ul class="menu">

                  <li> Task item 

                    <a href="#">

                      <h3>

                        Design some buttons

                        <small class="pull-right">20%</small>

                      </h3>

                      <div class="progress xs">

                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"

                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">

                          <span class="sr-only">20% Complete</span>

                        </div>

                      </div>

                    </a>

                  </li>

                   end task item 

                  <li> Task item 

                    <a href="#">

                      <h3>

                        Create a nice theme

                        <small class="pull-right">40%</small>

                      </h3>

                      <div class="progress xs">

                        <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"

                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">

                          <span class="sr-only">40% Complete</span>

                        </div>

                      </div>

                    </a>

                  </li>

                   end task item 

                  <li> Task item 

                    <a href="#">

                      <h3>

                        Some task I need to do

                        <small class="pull-right">60%</small>

                      </h3>

                      <div class="progress xs">

                        <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar"

                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">

                          <span class="sr-only">60% Complete</span>

                        </div>

                      </div>

                    </a>

                  </li>

                   end task item 

                  <li> Task item 

                    <a href="#">

                      <h3>

                        Make beautiful transitions

                        <small class="pull-right">80%</small>

                      </h3>

                      <div class="progress xs">

                        <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar"

                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">

                          <span class="sr-only">80% Complete</span>

                        </div>

                      </div>

                    </a>

                  </li>

                   end task item 

                </ul>

              </li>

              <li class="footer">

                <a href="#">View all tasks</a>

              </li>

            </ul>

          </li>-->
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
             <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!--<img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">-->
              <span class="hidden-xs"><?=$this->session->userdata('userName');?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <!--<img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">-->
                <p>
                  <?=$this->session->userdata('userName');?>
                  <small>Bjain</small>
                </p>
              </li>
              <!-- Menu Body -->
                <!--<li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                 /.row 
              </li>-->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat" data-toggle="modal" data-target="#change_password">Change Password</a>
                </div>
                <div class="pull-right">
                  <a href="<?= base_url();?>user/logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
            <!--<li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>-->
        </ul>
      </div>
     </nav>
  </header>

  <div class="modal modal-info fade" id="change_password">
    <form role="form" method="post"   action="<?php echo base_url()."user/change_password"?>" enctype= "multipart/form-data">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Change Password</h4>
          </div>
          <div class="modal-body">
            <div class="form-group" >
              <label>Password *</label>
              <input required class="form-control" id="password" name="password" placeholder="Enter Password..." type="text" >
               <input class="form-control" name="user_id" value="<?=logged_user_data()?>" type="hidden" >
            </div>  
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-outline" >Save</button>
        </div>
      </div>
    </form>
    <?php  echo form_close(); ?>
      <!-- /.modal-content -->
  </div>

<script>
function myFunction() {
    var input, filter, ul, li, a, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";

        }
    }
}
</script>