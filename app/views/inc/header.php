<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Olian is a bootstrap minimal & clean admin template">
    <meta name="keywords" content="inventory, art of living inventory, art of living, art, living">
    <meta name="author" content="Themesbox17">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Medhike</title>
    <!-- Fevicon -->
    <link rel="shortcut icon" href="<?php echo URLROOT;?>/assets2/images/logo.png">
    <!-- Start css -->
    <!-- Switchery css -->
    <link href="<?php echo URLROOT;?>/assets2/plugins/switchery/switchery.min.css" rel="stylesheet">
    <!-- Apex css -->
    <link href="<?php echo URLROOT;?>/assets2/plugins/apexcharts/apexcharts.css" rel="stylesheet">
    <!-- Slick css -->
    <link href="<?php echo URLROOT;?>/assets2/plugins/slick/slick.css" rel="stylesheet">
    <link href="<?php echo URLROOT;?>/assets2/plugins/slick/slick-theme.css" rel="stylesheet">
    

    <link href="<?php echo URLROOT;?>/assets2/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo URLROOT;?>/assets2/css/icons.css" rel="stylesheet" type="text/css">


    
    <link href="<?php echo URLROOT;?>/assets2/css/flag-icon.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo URLROOT;?>/assets2/css/style.css" rel="stylesheet" type="text/css">
    <!-- End css -->
    <!-- Select2 css -->
    <link href="<?php echo URLROOT;?>/assets2/plugins/select2/select2.min.css" rel="stylesheet" type="text/css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
     <script type="text/javascript">
          $('input').attr('autocomplete','off');
    </script>

</head>
<body class="vertical-layout">    
    <!-- Start Containerbar -->
    <div id="containerbar">
        <!-- Start Leftbar -->
        <div class="leftbar">
            <!-- Start Sidebar -->
            <div class="sidebar" style="background-color: #01358D;">
                <!-- Start Logobar -->
                <div class="logobar" style="margin-bottom: 0px 0px 0px 0px; padding: 20px 0px;">
                    <a href="<?php echo URLROOT;?>/pages/index" class="logo logo-large"><img src="<?php echo URLROOT;?>/img/logo.png" class="img-fluid" alt="logo" ></a>

                    <a href="<?php echo URLROOT;?>/pages/index" class="logo logo-small"><img src="<?php echo URLROOT;?>/img/logoSide.png" class="img-fluid" alt="logo" style="height: inherit;"></a>
                </div>

                <!-- End Logobar -->


                <?php if($_SESSION['user_type'] != 0){ ?>
                <!-- Start Navigationbar -->
                <div class="navigationbar">
                    <ul class="vertical-menu">
                       
                        <li>
                            <a href="<?php echo URLROOT;?>/pages/index">
                                <i class="ri-dashboard-line"></i><span>Dashboard</span>
                            </a> 
                        </li>
                        <li>
                            <a href="<?php echo URLROOT;?>/pages/water_level">
                                <i class="ri-stack-line"></i><span>Water level Stock</span>
                            </a> 
                        </li>
                        <li>
                            <a href="javaScript:void();">
                                <i class="ri-stack-line"></i><span>Items</span><i class="ri-arrow-right-s-line"></i>
                            </a> 
                            <ul class="vertical-submenu">
                                <li><a href="<?php echo URLROOT;?>/pages/additem">New Item</a></li>
                                <li><a href="<?php echo URLROOT;?>/pages/all_items">All Items</a></li>
                            </ul>
                        </li>
                          
                        <li>
                            <a href="javaScript:void();">
                                <i class="ri-stack-line"></i><span>Stocks</span><i class="ri-arrow-right-s-line"></i>
                            </a>
                            <ul class="vertical-submenu">
                          
                                <li><a href="<?php echo URLROOT;?>/pages/stocks">All Stocks</a></li>
                            </ul> 
                        </li>

                        <li>
                            <a href="javaScript:void();">
                                <i class="ri-stack-line"></i><span>Vendors</span><i class="ri-arrow-right-s-line"></i>
                            </a> 
                            <ul class="vertical-submenu">
                                <li><a href="<?php echo URLROOT;?>/pages/addvenders">New Vendors</a></li>
                                <li><a href="<?php echo URLROOT;?>/pages/all_venders">All Vendors</a></li>
                            </ul>
                        </li>
                       
                        <li>
                            <a href="javaScript:void();">
                                <i class="ri-stack-line"></i><span>Purchase Order</span><i class="ri-arrow-right-s-line"></i>
                            </a> 
                             <ul class="vertical-submenu">
                                <li><a href="<?php echo URLROOT;?>/pages/add_purchase_order">New Purchase Order</a></li>
                                <li><a href="<?php echo URLROOT;?>/pages/purchase_order">All Purchase Order</a></li>
                                <li><a href="<?php echo URLROOT;?>/pages/non_purchase">Non Purchase Goods</a></li>
                                <li><a href="<?php echo URLROOT;?>/pages/all_non_purchase_order">All Non Purchase Order</a></li>
                            </ul>
                        </li>
                        <li>

                            <a href="javaScript:void();">
                                <i class="ri-stack-line"></i><span>Sales Order</span><i class="ri-arrow-right-s-line"></i>
                            </a> 
                            <ul class="vertical-submenu">
                                <li><a href="<?php echo URLROOT;?>/pages/add_sales_order">New Sales Invoice</a></li>
                                <li><a href="<?php echo URLROOT;?>/pages/sales_order">All Sales Invoice</a></li>
                               <!--  <li><a href="<?php echo URLROOT;?>/pages/add_distributor_order">New Distributor Order</a></li>
                                 <li><a href="<?php echo URLROOT;?>/pages/all_distributor_order">All Distributor Order</a></li> -->
                                 <li><a href="<?php echo URLROOT;?>/pages/stock_out">Sales Order</a></li>
                                 <li><a href="<?php echo URLROOT;?>/pages/all_stock_out">All Sales Order</a></li>
                                 <!-- <li>
                                     <a href="<?php echo URLROOT;?>/pages/stock_out_with_out_package">Stock Out without Package</a>
                                 </li> -->
                            </ul>
                        </li>

                        <li>
                             <a href="<?php echo URLROOT;?>/pages/new_stock_return">
                                <i class="ri-stack-line"></i><span>Sales Return</span><!-- <i class="ri-arrow-right-s-line"></i> -->
                            </a>
                        </li>

                         <li>
                            <a href="javaScript:void();">
                                <i class="ri-stack-line"></i><span>Delivery Challan</span><i class="ri-arrow-right-s-line"></i>
                            </a> 
                            <ul class="vertical-submenu">
                                <li><a href="<?php echo URLROOT;?>/pages/add_delivery_challan">New Delivery Challan</a></li>
                                <li><a href="<?php echo URLROOT;?>/pages/all_delivery_challan">All Delivery Challan</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javaScript:void();">
                                <i class="ri-stack-line"></i><span>Direct Package</span><i class="ri-arrow-right-s-line"></i>
                            </a> 
                            <ul class="vertical-submenu">
                                <li><a href="<?php echo URLROOT;?>/pages/new_direct_package">New Direct Package</a></li>
                                <li><a href="<?php echo URLROOT;?>/pages/all_direct_package">All Direct Package</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javaScript:void();">
                                <i class="ri-stack-line"></i><span>Distributor</span><i class="ri-arrow-right-s-line"></i>
                            </a> 
                            <ul class="vertical-submenu">
                                <li><a href="<?php echo URLROOT;?>/pages/add_distributor">New Distributor</a></li>
                                <li><a href="<?php echo URLROOT;?>/pages/all_distributor">All Distributor</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javaScript:void();">
                                <i class="ri-stack-line"></i><span>Customers</span><i class="ri-arrow-right-s-line"></i>
                            </a> 
                            <ul class="vertical-submenu">
                                <li><a href="<?php echo URLROOT;?>/pages/addcustomer">New Customer</a></li>
                                <li><a href="<?php echo URLROOT;?>/pages/all_customer">All Customer</a></li>
                            </ul>
                        </li>
                        <!--<li>-->
                        <!--    <a href="javaScript:void();">-->
                        <!--        <i class="ri-stack-line"></i><span>Expenses</span><i class="ri-arrow-right-s-line"></i>-->
                        <!--    </a>-->
                        <!--    <ul class="vertical-submenu">-->
                        <!--        <li><a href="<?php echo URLROOT;?>/pages/addexpenses">New Expenses</a></li>-->
                        <!--        <li><a href="<?php echo URLROOT;?>/pages/all_expenses">All Expenses </a></li>-->
                        <!--    </ul>-->
                        <!--</li>-->
                        <li>
                             <a href="javaScript:void();">
                                <i class="ri-stack-line"></i><span>Reports</span><i class="ri-arrow-right-s-line"></i>
                            </a> 
                             <ul class="vertical-submenu">
                                 <li><a href="<?php echo URLROOT;?>/pages/reports">Reports</a></li>
                            </ul>  
                        </li> 
                         <li>
                             <a href="<?php echo URLROOT;?>/pages/checkqr">
                                <i class="ri-stack-line"></i><span>Check QR Code</span><i class="ri-arrow-right-s-line"></i>
                            </a> 
                             
                        </li>   
                        <li>
                             <a href="<?php echo URLROOT;?>/pages/settings">
                                <i class="ri-stack-line"></i><span>Manage details</span><i class="ri-arrow-right-s-line"></i>
                            </a> 
                             
                        </li>
                        <!-- ********** Hr part start **************** -->

                        <!--<li>-->
                        <!--        <a href="javaScript:void();">-->
                        <!--            <i class="ri-stack-line"></i><span>Employees</span><i class="ri-arrow-right-s-line"></i>-->
                        <!--        </a> -->
                        <!--        <ul class="vertical-submenu">-->
                        <!--            <li><a href="<?php echo URLROOT;?>/admin/add_employees">Add Employee</a></li>-->
                        <!--            <li><a href="<?php echo URLROOT;?>/admin/all_employees">All Employees</a></li>-->
                                    <!-- <li><a href="<?php echo URLROOT;?>/admin/verify_employee">Verify Employee</a></li> -->
                        <!--        </ul>-->
                        <!--    </li>-->
                            
                            <!--<li>-->
                            <!--    <a href="javaScript:void();">-->
                            <!--        <i class="ri-stack-line"></i><span>Leaves</span><i class="ri-arrow-right-s-line"></i>-->
                            <!--    </a>-->
                            <!--    <ul class="vertical-submenu">-->
                            <!--        <li><a href="<?php echo URLROOT;?>/admin/leave_applications">Leave Applications</a></li>-->
                            <!--        <li><a href="<?php echo URLROOT;?>/admin/all_leaves">All Leaves</a></li>-->
                            <!--    </ul> -->
                            <!--</li>-->

                            <!--<li>-->
                            <!--    <a href="javaScript:void();">-->
                            <!--        <i class="ri-stack-line"></i><span>Loans</span><i class="ri-arrow-right-s-line"></i>-->
                            <!--    </a>-->
                            <!--    <ul class="vertical-submenu">-->
                            <!--        <li><a href="<?php echo URLROOT;?>/admin/loan_applications">Loan Applications</a></li>-->
                            <!--        <li><a href="<?php echo URLROOT;?>/admin/all_loans">All Loans</a></li>-->
                            <!--    </ul> -->
                            <!--</li>-->

                           <!--<li>-->
                           <!--     <a href="javaScript:void();">-->
                           <!--         <i class="ri-stack-line"></i><span>Salary</span><i class="ri-arrow-right-s-line"></i>-->
                           <!--     </a>-->
                           <!--     <ul class="vertical-submenu">-->
                                   <!--  <li><a href="<?php echo URLROOT;?>/admins/salary">Calculate Salary</a></li>
                           <!--         <li><a href="<?php echo URLROOT;?>/admins/salarycurr">View all salaries</a></li> -->-->
                           <!--         <li><a href="<?php echo URLROOT;?>/admins/calculateEmployeeSalary">Calculate Salary</a></li>-->
                           <!--         <li><a href="<?php echo URLROOT;?>/admins/employeeSalaries">View all salaries</a></li>-->
                           <!--     </ul> -->
                           <!-- </li>-->
                            <!--<li >-->
                            <!--    <a href="javaScript:void();">-->
                            <!--        <i class="ri-stack-line"></i><span >Project <br>Management</span><i class="ri-arrow-right-s-line"></i>-->
                            <!--    </a> -->
                            <!--     <ul class="vertical-submenu">-->
                            <!--        <li><a href="<?php echo URLROOT;?>/admins/create_project">Create Project</a></li>-->
                            <!--        <li><a href="<?php echo URLROOT;?>/admins/all_projects">All Project</a></li>-->
                            <!--        <li><a href="<?php echo URLROOT;?>/admins/add_task">Add Task</a></li>-->
                            <!--        <li><a href="<?php echo URLROOT;?>/admins/all_task">All Task</a></li>-->
                            <!--    </ul>-->
                            <!--</li>-->


                        <!--<li>-->
                        <!--     <a href="javaScript:void();">-->
                        <!--        <i class="ri-stack-line"></i><span>Cloud Attendance</span><i class="ri-arrow-right-s-line"></i>-->
                        <!--    </a> -->
                             

                        <!--    <ul class="vertical-submenu">-->
                                 <!-- <li><a href="<?php echo URLROOT;?>/pages/cloud">Cloud Attendance</a></li> -->
                        <!--         <li><a href="#" onclick="myFunction()">Cloud Attendance</a></li>-->

                        <!--         <li><a href="<?php echo URLROOT;?>/pages/upload_attendence">Upload Attendance</a></li>-->

                        <!--    </ul> -->

                        <!--     <script>-->
                        <!--        function myFunction()-->
                        <!--        {-->
                        <!--            var myWindow = window.open("https://www.ontimeemployeemanager.com", "", "width=1000, height=900");-->
                        <!--        }-->
                        <!--    </script>-->
 
                        <!--</li>-->

                        <!-- ********** Hr part end **************** --> 

                    </ul>
                </div>
                <!-- End Navigationbar -->
                <?php }?>
            </div>
            <!-- End Sidebar -->
        </div>
        <!-- End Leftbar -->
        <!-- Start Rightbar -->
        <div class="rightbar">
            <!-- Start Topbar Mobile -->
            <div class="topbar-mobile">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="mobile-logobar">
                            <a href="<?php echo URLROOT;?>/index" class="mobile-logo"><img src="<?php echo URLROOT;?>/assets2/images/art1.png" class="img-fluid" alt="logo"></a>
                        </div>
                        <div class="mobile-togglebar">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <div class="topbar-toggle-icon">
                                        <a class="topbar-toggle-hamburger" href="<?php echo URLROOT;?>/javascript:void();">
                                            <span class="iconbar">
                                                <i class="ri-more-fill menu-hamburger-horizontal"></i>
                                                <i class="ri-more-2-fill menu-hamburger-vertical"></i>
                                            </span>
                                         </a>
                                     </div>
                                </li>
                                <li class="list-inline-item">
                                    <div class="menubar">
                                        <a class="menu-hamburger" href="<?php echo URLROOT;?>/javascript:void();">
                                            <span class="iconbar">
                                                <i class="ri-menu-2-line menu-hamburger-collapse"></i>
                                                <i class="ri-close-line menu-hamburger-close"></i>
                                            </span>
                                         </a>
                                     </div>
                                </li>                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Start Topbar -->
            <div class="topbar">
                <!-- Start row -->
                <div class="row align-items-center">
                    <!-- Start col -->
                    <div class="col-md-12 align-self-center">
                        <div class="togglebar">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <div class="menubar">
                                        <a class="menu-hamburger" href="<?php echo URLROOT;?>/javascript:void();">
                                            <span class="iconbar">
                                                <i class="ri-menu-2-line menu-hamburger-collapse"></i><i class="ri-close-line menu-hamburger-close"></i>
                                            </span>
                                         </a>
                                     </div>
                                </li>
                                <li class="list-inline-item" style="display: none">
                                    <div class="searchbar">
                                        <form>
                                            <div class="input-group">
                                              <input type="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
                                              <div class="input-group-append">
                                                <button class="btn" type="submit" id="button-addon2"><i class="ri-search-line"></i></button>

                                              </div>
                                            </div>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="infobar">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <div class="profilebar">
                                        <div class="dropdown">
                                          <a class="dropdown-toggle" href="<?php echo URLROOT;?>/#" role="button" id="profilelink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo URLROOT;?>/assets2/images/users/profile.svg" class="img-fluid" alt="profile"><span class="live-icon"><?php echo $_SESSION['user_name']; ?></span></a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profilelink">
                                                <?php if($_SESSION['user_type'] == 0){ ?>
                                                    <!-- <a class="dropdown-item"  href="<?php echo URLROOT; ?>/pages/change_db"><i class="ri-settings-3-line"></i>Change DataBase</a> -->
                                                    <!-- <a class="dropdown-item"  href="<?php echo URLROOT; ?>/pages/all_permissions1"><i class="ri-settings-3-line"></i>Permissions</a> -->
                                                     <a href="<?php echo URLROOT; ?>/pages/change_pass" class="dropdown-item" href="#"><i class="ri-settings-3-line"></i>Settings</a>
                                                <?php }else{?>
                                                    <a href="<?php echo URLROOT; ?>/pages/change_pass" class="dropdown-item" href="#"><i class="ri-settings-3-line"></i>Settings</a>
                                                <?php }?>
                                                <a class="dropdown-item text-danger" href="<?php echo URLROOT;?>/users/logout"><i class="ri-shut-down-line"></i>Logout</a>
                                            </div>
                                        </div>
                                    </div>                                   
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- End col -->
                </div> 
                <!-- End row -->
            </div>
            <!-- End Topbar -->