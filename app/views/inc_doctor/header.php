<!DOCTYPE html>
<style type="text/css">
    #listt0,#list3,#list5{
        max-height: 300px;
        max-width: 200px;
        min-width: 200px;
        position: absolute;
        overflow-y: auto;
        overflow-x: hidden;
        background-color: white;
        border: solid;
        border-width: 1px;
        border-color: lightgray;
        padding-left: 10px;
        font-size: 13px;
        cursor: pointer;
        z-index: 50;
        text-align: left;
        border-radius: 20px;
      }
      .ee{
        margin: 4px;
        font-size: 16px;
      }
      .ee:hover
      {
        background-color: #EAEDED;
        padding: 2px;
        border-radius: 20px;
        margin-right: 10px;
      }
</style>
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
        <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

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
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->

        <script src='<?php echo URLROOT; ?>/autocomp/jquery-3.1.1.min.js' type='text/javascript'></script>
        <link href='<?php echo URLROOT; ?>/autocomp/jquery-ui.min.css' rel='stylesheet' type='text/css'>
        <script src='<?php echo URLROOT; ?>/autocomp/jquery-ui.min.js' type='text/javascript'></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>


    <body>
        <!-- Aside Start-->
        <aside class="left-panel">

            <!-- brand -->
            <div class="logo" id="myDIV">
                <a href="<?php echo URLROOT;?>/doctors/index" style="padding-left: 25px;">
                    <span class="nav-label">
                        <img id="" style="width: 125px;" src="<?php echo URLROOT;?>/img/logo.png" alt="logo">
                    </span>
                </a>
            </div>
            <div class="logo" id="myDI" style="display: none;">
                <a href="<?php echo URLROOT;?>/doctors/index" class="">
                    <img id ="mu" src="<?php echo URLROOT;?>/img/logoSide.png" style="width:25px; height: 20px;">
                </a>
            </div>

            <script>
                function myFunction()
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
            </script>
            <!-- / brand -->
        
            <!-- Navbar Start -->
            <nav class="navigation">
                <ul class="list-unstyled">
                    <li class="has-submenu"><a href="<?php echo URLROOT;?>/doctors/index"><i class="ion-home"></i> <span class="nav-label">Dashboard</span></a>
                    </li>
                    <li class="has-submenu"><a href="<?php echo URLROOT;?>/doctors/admissions"><i class="fa fa-wheelchair"></i> <span class="nav-label">IP Patients</span></a>
                    </li>
                    <li class="has-submenu"><a href="<?php echo URLROOT;?>/doctors/view_patients"><i class="ion-ios7-people"></i> <span class="nav-label">OP Patients</span></a>
                    </li>
                    <li class="has-submenu"><a href="<?php echo URLROOT;?>/doctors/view_emergency"><i class="ion-medkit"></i> <span class="nav-label">Emergency</span></a>
                    </li>
                    <li class="has-submenu"><a href="<?php echo URLROOT;?>/doctors/doc"><i class=" fa fa-user-md"></i> <span class="nav-label">Doctors</span></a>
                    </li>
                    <li class="has-submenu"><a href="<?php echo URLROOT;?>/doctors/docProfile/<?php echo $_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no'] ?>"><i class="ion-android-contact"></i> <span class="nav-label">My Profile</span></a>
                    </li>
                    <li class="has-submenu"><a href="<?php echo URLROOT;?>/doctors/instructions"><i class="ion-compose"></i> <span class="nav-label">Instructions</span></a>
                    </li>
                    <!-- <li class="has-submenu"><a href="/doctors/timeslots"><i class="ion-clock"></i> <span class="nav-label">Time Slots</span></a>
                    </li> -->
                    <li class="has-submenu"><a href="<?php echo URLROOT;?>/doctors/operations"><i class="ion-heart"></i> <span class="nav-label">Operations</span></a>
                    </li>
                     <li class="has-submenu"><a href="#"><i class="ion-document"></i> <span class="nav-label">All Reports</span></a>
                        <ul class="list-unstyled">
                            <li><a href="<?php echo URLROOT;?>/doctors/allxraydetails">All Reports</a></li>
                        </ul>
                    </li>
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
                  <input type="text" id="cust" placeholder="Patient Search..." class="form-control" autocomplete="off">
                  <div id="list3" style="display: none;"></div>
                </form>
                
                <!-- Left navbar -->
               <!--  <nav class=" navbar-default hidden-xs" role="navigation">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                          <a data-toggle="dropdown" class="dropdown-toggle" href="#">English <span class="caret"></span></a>
                            <ul role="menu" class="dropdown-menu">
                                <li><a href="#">German</a></li>
                                <li><a href="#">French</a></li>
                                <li><a href="#">Italian</a></li>
                                <li><a href="#">Spanish</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Files</a></li>
                        <li><a href="../frontend/" target="_blank">Frontend</a></li>
                    </ul>
                </nav> -->
                
                <!-- Right navbar -->
                <ul class="list-inline navbar-right top-menu top-right-menu">  
                    <li class="dropdown" style="display: none;">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="fa fa-envelope-o "></i>
                            <span class="badge badge-sm up bg-purple count"></span>
                        </a>
                        <ul  style="display: none;" class="dropdown-menu extended fadeInUp animated nicescroll" tabindex="5001">
                            <li>
                                <p></p>
                            </li>
                            <li>
                                
                            </li>
                            <li  style="display: none;">
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
                            <img alt="" src="<?php echo URLROOT;?>/img/avatar-2.jpg" class="img-circle profile-img thumb-sm">
                            <span class="username"><?php echo ucwords($_SESSION['user_name']);?> </span> <span class="caret"></span>
                        </a>
                        <?php
                        ?>
                        <ul class="dropdown-menu extended pro-menu fadeInUp animated" tabindex="5003" style="overflow: hidden; outline: none;">
                            <!-- <li><a href="profile.html"><i class="fa fa-briefcase"></i>Profile</a></li> -->
                            <li><a href="<?php echo URLROOT;?>/doctors/settings_doc"><i class="fa fa-cog"></i> Settings</a></li>
                            <!-- <li><a href="#"><i class="fa fa-bell"></i> Friends <span class="label label-info pull-right mail-info">5</span></a></li> -->
                            <li><a href="<?php echo URLROOT;?>/users/logout"><i class="fa fa-sign-out"></i> Log Out</a></li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->       
                </ul>
                <!-- End right navbar -->

            </header>
  <script type="text/javascript">
     $(document).ready(function(){
      $('#cust').keyup(function(){
        var query3 = $(this).val();
          $.ajax({
            url:'<?php echo URLROOT;?>/doctors/get_auto_patient_name',
            type:'POST',
            data:{query3:query3}, 
            success:function(data)
            {
              $('#list3').fadeIn();
              $('#list3').html(data);
            }
          });
      });
       $(document).on('click', '.ee', function(){
           $('#cust').val($(this).text()); 
           var p = $('#cust').val();
           p = p.split("|",2);
           window.location.href = "<?php echo URLROOT;?>/doctors/view_profile/"+p[1]+"";
           $('#list3').fadeOut();  
      });
      $(document).click(function (event){
        $('#list3').fadeOut(); 
      });  
    });
  </script>