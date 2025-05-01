<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="<?php echo URLROOT;?>/img/favicon.png">
        <!-- Google-Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:100,300,400,600,700,900,400italic' rel='stylesheet'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <!-- Bootstrap core CSS -->
        <link href="<?php echo URLROOT;?>/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo URLROOT;?>/css/bootstrap-reset.css" rel="stylesheet">
        <!--Animation css-->
        <link href="<?php echo URLROOT;?>/css/animate.css" rel="stylesheet">
        <!--Icon-fonts css-->
        <link href="<?php echo URLROOT;?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="<?php echo URLROOT;?>/assets/ionicon/css/ionicons.min.css" rel="stylesheet" />
        <!-- Custom styles for this template -->
        <link href="<?php echo URLROOT;?>/css/style.css" rel="stylesheet">
        <link href="<?php echo URLROOT;?>/css/helper.css" rel="stylesheet">
        <link href="<?php echo URLROOT;?>/css/style-responsive.css" rel="stylesheet" />


        <link href="<?php echo URLROOT;?>/assets/tagsinput/jquery.tagsinput.css" rel="stylesheet" />
        <link href="<?php echo URLROOT;?>/assets/toggles/toggles.css" rel="stylesheet" />
        <link href="<?php echo URLROOT;?>/assets/timepicker/bootstrap-timepicker.min.css" rel="stylesheet" />
        <link href="<?php echo URLROOT;?>/assets/timepicker/bootstrap-datepicker.min.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="<?php echo URLROOT;?>/assets/colorpicker/colorpicker.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo URLROOT;?>/assets/jquery-multi-select/multi-select.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo URLROOT;?>/assets/select2/select2.css" />
        <link rel="stylesheet" href="<?php echo URLROOT;?>/assets/morris/morris.css">
        <link href="<?php echo URLROOT;?>/assets/sweet-alert/sweet-alert.min.css" rel="stylesheet">
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
    <body>
    <style type="text/css">
      #pat_list_div
      {
        max-height: 400px;
        max-width: 200px;
        min-width: 200px;
        position: absolute;
        background-color: white;
        border: solid;
        border-width: 1px;
        border-color: lightgray;
        font-size: 13px;
        cursor: pointer;
        z-index: 50;
        text-align: left;
        border-radius: 20px;
      }
      .head_sty
      {
        margin: 4px;
        font-size: 16px;
      }
      .head_sty:hover
      {
        background-color: lightgray;
        border-radius: 20px;
        margin-right: 10px;
      }
</style>    
        <!-- Aside Start-->
        <aside class="left-panel">

            <!-- brand -->
            <div class="logo" id="myDIV">
                <a href="<?php echo URLROOT;?>/acc/index" style="padding-left: 25px;">
                    <span class="nav-label">
                        <img id="" style="width: 125px;" src="<?php echo URLROOT;?>/img/logo.png" alt="logo">
                    </span>
                </a>
            </div>
            <div class="logo" id="myDI" style="display: none;">
                <a href="<?php echo URLROOT;?>/acc/index" class="">
                    <img id ="mu" src="<?php echo URLROOT;?>/img/logoSide.png" style="width:25px; height: 20px;">
                </a>
            </div>
            <script>
                function myFunction()
                {
                  var e = $(window).width();
                  if(e < 768)
                  {
                    var xx = document.getElementById("myDIV");
                    xx.style.display = "block";
                  }
                  else
                  {
                      var x = document.getElementById("myDIV");
                      var y = document.getElementById("myDI");
                      if (x.style.display == "none")
                      {
                        x.style.display = "block";
                        y.style.display = "none";
                      }              
                      else{
                        y.style.display = "block";
                        x.style.display = "none";
                      }
                  }     
                }
            </script>
            <!-- / brand -->
            <!-- Navbar Start -->
            <nav class="navigation">
                <ul class="list-unstyled">
                    <li class="has-submenu"><a href="<?php echo URLROOT;?>/acc/index"><i class="ion-home"></i> <span class="nav-label">Dashboard</span></a>
                    </li>
                    <li class="has-submenu"><a href="<?php echo URLROOT;?>/acc/reports"><i class="ion-document"></i> <span class="nav-label">Reports</span></a>
                    </li>
                    <!-- <li class="has-submenu"><a href="#"><i class="ion-flask"></i> <span class="nav-label">View Patients</span></a>
                        <ul class="list-unstyled">
                            <li><a href="<?php echo URLROOT;?>/nurses/visits">Visits</a></li>
                            <li><a href="<?php echo URLROOT;?>/nurses/admits">Admisnions</a></li>
                        </ul>
                    </li> -->
                </ul>
            </nav>         
        </aside>
        <!-- Aside Ends-->


        <!--Main Content Start -->
        <section class="content">
            
            <!-- Header -->
            <header class="top-head container-fluid">
                <button type="button" onclick="myFunction()" class="navbar-toggle pull-left">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
                <!-- Search -->
                <form role="search" class="navbar-left app-search pull-left hidden-xs">
                  <input type="text" placeholder="Patient Search..." id="patient_name_list" class="form-control" autocomplete="off">
                  <div id="pat_list_div" style="display: none;"></div>
                </form>
                
                <!-- Left navbar -->
                <nav class=" navbar-default hidden-xs" role="navigation">
                    <ul class="nav navbar-nav" style="display: none;">
                        <li class="dropdown">
                          <a data-toggle="dropdown" class="dropdown-toggle" href="#">English <span class="caret"></span></a>
                            <ul role="menu" class="dropdown-menu">
                                <li><a href="#">German</a></li>
                                <li><a href="#">French</a></li>
                                <li><a href="#">Italian</a></li>
                                <li><a href="#">Spanish</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- Right navbar -->
                <ul class="list-inline navbar-right top-menu top-right-menu">  
                    <!-- mesages -->  
                    <li class="dropdown" style="display: none;">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="fa fa-envelope-o "></i>
                            <span class="badge badge-sm up bg-purple count">4</span>
                        </a>
                        <ul class="dropdown-menu extended fadeInUp animated nicescroll" tabindex="5001">
                            <li>
                                <p>Messages</p>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="pull-left"><img src="img/avatar-2.jpg" class="img-circle thumb-sm m-r-15" alt="img"></span>
                                    <span class="block"><strong>John smith</strong></span>
                                    <span class="media-body block">New tasks needs to be done<br><small class="text-muted">10 seconds ago</small></span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="pull-left"><img src="img/avatar-3.jpg" class="img-circle thumb-sm m-r-15" alt="img"></span>
                                    <span class="block"><strong>John smith</strong></span>
                                    <span class="media-body block">New tasks needs to be done<br><small class="text-muted">3 minutes ago</small></span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="pull-left"><img src="img/avatar-4.jpg" class="img-circle thumb-sm m-r-15" alt="img"></span>
                                    <span class="block"><strong>John smith</strong></span>
                                    <span class="media-body block">New tasks needs to be done<br><small class="text-muted">10 minutes ago</small></span>
                                </a>
                            </li>
                            <li>
                                <p><a href="inbox.html" class="text-right">See all Messages</a></p>
                            </li>
                        </ul>
                    </li>
                    <!-- /messages -->
                    <!-- Notification -->
                    <li class="dropdown" style="display: none;">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="fa fa-bell-o"></i>
                            <span class="badge badge-sm up bg-pink count">3</span>
                        </a>
                        <ul class="dropdown-menu extended fadeInUp animated nicescroll" tabindex="5002">
                            <li class="noti-header">
                                <p>Notifications</p>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="pull-left"><i class="fa fa-user-plus fa-2x text-info"></i></span>
                                    <span>New user registered<br><small class="text-muted">5 minutes ago</small></span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="pull-left"><i class="fa fa-diamond fa-2x text-primary"></i></span>
                                    <span>Use animate.css<br><small class="text-muted">5 minutes ago</small></span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="pull-left"><i class="fa fa-bell-o fa-2x text-danger"></i></span>
                                    <span>Send project demo files to client<br><small class="text-muted">1 hour ago</small></span>
                                </a>
                            </li>
                            
                            <li>
                                <p><a href="#" class="text-right">See all notifications</a></p>
                            </li>
                        </ul>
                    </li>
                    <!-- /Notification -->

                    <!-- user login dropdown start-->
                    <li class="dropdown text-center">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <img alt="" src="<?php echo URLROOT;?>/user_profile_pictures/<?php echo $_SESSION['user_photo_medhike_87_71_18_08_80_none_med_hi_ke_no'];?>" class="img-circle profile-img thumb-sm">
                            <span class="username"><?php echo ucwords($_SESSION['user_name']);?></span> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu extended pro-menu fadeInUp animated" tabindex="5003" style="overflow: hidden; outline: none;">
                            <!-- <li><a href="<?php echo URLROOT;?>/receptions/help"><i class="fa fa-question-circle"></i> Help</a></li> -->
                            <li style="display: none;"><a href="profile.html"><i class="fa fa-briefcase"></i>Profile</a></li>
                            <li><a href="<?php echo URLROOT;?>/receptions/settings"><i class="fa fa-cog"></i> Settings</a></li>
                            <li style="display: none;"><a href="#"><i class="fa fa-bell"></i> Friends <span class="label label-info pull-right mail-info">5</span></a></li>
                            <li><a href="<?php echo URLROOT;?>/users/logout"><i class="fa fa-sign-out"></i> Log Out</a></li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->       
                </ul>
                <!-- End right navbar -->
            </header>
            <!-- Header Ends -->
            <!-- Page Content Start -->
            <!-- ================== -->

  <script type="text/javascript">
     $(document).ready(function(){
      $('#patient_name_list').keyup(function(){
        var query3 = $(this).val();
        if(query3!=0)
        {
          $.ajax({
            url:'<?php echo URLROOT;?>/receptions/get_auto_patient_name_for_header',
            type:'POST',
            data:{query3:query3}, 
            success:function(data)
            {
              $('#pat_list_div').fadeIn();
              $('#pat_list_div').html(data);
            }
          });
        }
        else
        {
          $('#pat_list_div').fadeOut();
        }
      });
       $(document).on('click', '.head_sty', function(){
           $('#pat_list_div').val($(this).text()); 
           var p = $('#pat_list_div').val();
           p = p.split("(",2);
           p[1] = p[1].replace(/[{()}]/g, "");
           r = p[1].trim();
           window.location.href = "<?php echo URLROOT;?>/receptions/view_profile_patient/"+r+"";
           $('#pat_list_div').fadeOut();  
      });
      $(document).click(function (event){
        $('#pat_list_div').fadeOut(); 
      });  
    });
  </script>         