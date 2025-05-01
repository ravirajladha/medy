<!DOCTYPE html>
<html lang="en">
<style type="text/css">
    #list33{
        max-height: 400px;
        max-width: 200px;
        min-width: 200px;
        position: absolute;
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
      .ccc{
        margin: 4px;
        font-size: 16px;
      }
      .ccc:hover
      {
        background-color: lightgray;
        border-radius: 20px;
        margin-right: 10px;
      }
</style>
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
        
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->

    </head>


    <aside class="left-panel">

            <!-- brand -->
            <div class="logo" id="myDIV">
                <a href="<?php echo URLROOT;?>/pharmacies/index" style="padding-left: 25px;">
                    <span class="nav-label">
                        <img id="" style="width: 125px;" src="<?php echo URLROOT;?>/img/logo.png" alt="logo">
                    </span>
                </a>
            </div>
            <div class="logo" id="myDI" style="display: none;">
                <a href="<?php echo URLROOT;?>/pharmacies/index" class="">
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
            <nav class="navigation">
                <ul class="list-unstyled">
                    <li class="has-submenu"><a href="<?php echo URLROOT;?>/pharmacies/index"><i class="ion-home"></i> <span class="nav-label">Dashboard</span></a>
                    </li>
                    <li class="has-submenu"><a href="#"><i class="ion-flask"></i> <span class="nav-label">Orders</span></a>
                        <ul class="list-unstyled">
                            <li><a href="<?php echo URLROOT;?>/pharmacies/new_order">New Order</a></li>
                            <li><a href="<?php echo URLROOT;?>/pharmacies/all_orders">All Orders</a></li>
                            <!-- <li><a href="<?php echo URLROOT;?>/pharmacies/active_orders">Active Orders</a></li> -->
                            <li><a href="<?php echo URLROOT;?>/pharmacies/order_request">Request Order IP</a></li>
                            <li><a href="<?php echo URLROOT;?>/pharmacies/order_request_op">Request Order OP</a></li>
                        </ul>
                    </li>
                    <li class="has-submenu"><a href="#"><i class="ion-settings"></i> <span class="nav-label">Items</span></a>
                        <ul class="list-unstyled">
                            <li><a href="<?php echo URLROOT;?>/pharmacies/add_drugs">Add Items</a></li>
                            <li><a href="<?php echo URLROOT;?>/pharmacies/all_drugs">All Items</a></li>
                        </ul>
                    </li>
                    <li class="has-submenu"><a href="#"><i class="ion-compose"></i> <span class="nav-label">Stocks</span></a>
                        <ul class="list-unstyled">
                            <li><a href="<?php echo URLROOT;?>/pharmacies/new_purchase">New Stocks</a></li>
                            <li><a href="<?php echo URLROOT;?>/pharmacies/all_purchase">All Stocks</a></li>
                            <li><a href="<?php echo URLROOT;?>/pharmacies/exp_stock">Expiring Stock</a></li>
                            <li><a href="<?php echo URLROOT;?>/pharmacies/all_stock">All Stocks Details</a></li>
                        </ul>
                    </li>
                    <!-- <li class="has-submenu"><a href="#"><i class="ion-grid"></i> <span class="nav-label">Stock Details</span></a>
                        <ul class="list-unstyled">
                            <li><a href="<?php echo URLROOT;?>/pharmacies/exp_stock">Expiring Stock</a></li>
                            <li><a href="<?php echo URLROOT;?>/pharmacies/all_stock">All Stocks Details</a></li>
                        </ul>
                    </li> -->
                    <li class="has-submenu"><a href="#"><i class="ion-flask"></i> <span class="nav-label">Purchase</span></a>
                        <ul class="list-unstyled">
                            <li><a href="<?php echo URLROOT;?>/pharmacies/new_order_s">New Purchase</a></li>
                            <li><a href="<?php echo URLROOT;?>/pharmacies/all_orders_s">All Purchase</a></li>
                            <li><a href="<?php echo URLROOT;?>/pharmacies/all_orders_s">Purchase Return</a></li>
                            <li><a href="<?php echo URLROOT;?>/pharmacies/all_orders_s">Customer Return</a></li>
                            <li><a href="<?php echo URLROOT;?>/pharmacies/addSuppliers">Add Supplier</a></li>
                            <li><a href="<?php echo URLROOT;?>/pharmacies/allSupliers">All Suppliers</a></li>
                        </ul>
                    </li>
                    <li class="has-submenu"><a href="<?php echo URLROOT;?>/pharmacies/reports"><i class="ion-document"></i> <span class="nav-label">Reports</span></a>
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
                  <input type="text" placeholder="Drug Search..." id="cust1" class="form-control" autocomplete="off">
                  <div id="list33" style="display: none;"></div>
                </form>
                
                <!-- Left navbar -->
                <nav class=" navbar-default hidden-xs" role="navigation">
                    <ul class="nav navbar-nav" style="display: none;">
                        <li class="dropdown" style="display: none;">
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
                        <ul class="dropdown-menu extended fadeInUp animated nicescroll" tabindex="5002" style="display: none;">
                            <li class="noti-header">
                                <p>Notifications</p>
                            </li>
                            <li style="display: none;">
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
                            <span class="username"><?php echo ucwords($_SESSION['user_name']    );?></span> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu extended pro-menu fadeInUp animated" tabindex="5003" style="overflow: hidden; outline: none;">
                            <!-- <li><a href="profile.html"><i class="fa fa-briefcase"></i>Profile</a></li> -->
                            <li><a href="<?php echo URLROOT;?>/pharmacies/settings"><i class="fa fa-cog"></i> Settings</a></li>
                           <!--  <li><a href="#"><i class="fa fa-bell"></i> Friends <span class="label label-info pull-right mail-info">5</span></a></li> -->
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
      $('#cust1').keyup(function(){
        var query = $(this).val();
        if(query!=0)
        {
          $.ajax({
            url:'<?php echo URLROOT;?>/pharmacies/get_drug_autocomplete2',
            type:'POST',
            data:{query:query}, 
            success:function(data)
            {
              $('#list33').fadeIn();
              $('#list33').html(data);
            }
          });
        }
        else
        {
          $('#list33').fadeOut();
        }
      });
       $(document).on('click', '.ccc', function(){
           $('#cust1').val($(this).text()); 
           var p = $('#cust1').val();
           p = p.split("|",2);
           r = p[1].trim();
           window.location.href = "<?php echo URLROOT;?>/pharmacies/drug/"+r+"";
           $('#list33').fadeOut();  
      });
      $(document).click(function (event){
        $('#list33').fadeOut(); 
      });  
    });
  </script>            