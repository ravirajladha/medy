<?php require APPROOT .'/views/inc_patient/header.php'; ?>
<title>Dashboard | Medhike</title>
<div class="wraper container-fluid">
                <div class="page-title"> 
                    <h3 class="title">Welcome !</h3> 
                </div>

               <div class="row">
                    <div class="col-lg-3 col-sm-6">
                    	
                        <div class="widget-panel widget-style-2 white-bg">
                            <i style="color: #FF0066" class="ion-eye"></i> 
                            <h2 style="color: gray" class="m-0 counter"><?php echo $data['order'];?></h2>
                            <div style="color:gray; font-size: 16px;">Orders</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="widget-panel widget-style-2 white-bg">
                            <i style="color: #660099" class="ion-wifi"></i> 
                            <h2 style="color: gray" class="m-0 counter"><?php echo $data['patient'];?></h2>
                            <div style="color: gray; font-size: 16px;">Visits</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="widget-panel widget-style-2 white-bg">
                            <i style="color: #2196F3" class="ion-ios7-pricetag"></i> 
                            <h2 style="color: gray" class="m-0 counter"><?php echo $data['visit'];?></h2>
                            <div style="color: gray; font-size: 16px;">IP Admits</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="widget-panel widget-style-2 white-bg">
                            <i style="color: #33CC99" class="ion-android-contacts"></i> 
                            <h2 style="color: gray" class="m-0 counter"><?php echo $data['admit'];?></h2>
                            <div style="color: gray; font-size: 16px;">Prescriptions</div>
                        </div>
                    </div>
                </div> <!-- end row -->
           <!-- End row -->
<!-- <div class="wraper container-fluid">
                <div class="page-title"> 
                    <h3 class="title">Timeline</h3> 
                </div>

                <div class="row">

                    <div class="col-sm-12">

                        <ul class="timeline">

                            <li class="timeline-inverted">
                                <div class="timeline-badge"><i class="ion-android-note"></i>
                                </div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h4 class="timeline-title">Orders</h4>
                                        
                                    </div>
                                    <div class="timeline-body">
                                        <p>Total Orders: 0 Orders</p>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-inverted">
                                <div class="timeline-badge warning"><i class="fa fa-money"></i>
                                </div>
                               <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h4 class="timeline-title">Cash Income</h4>
                                        
                                    </div>
                                    <div class="timeline-body">
                                        <p>Total Cash Income: Rs 0</p>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-inverted">
                                <div class="timeline-badge danger"><i class="fa fa-credit-card"></i>
                                </div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h4 class="timeline-title">Digital Income</h4>
                                        
                                    </div>
                                    <div class="timeline-body">
                                        <p>Total Digital Income: Rs 0</p>
                                    </div>
                                </div>
                            </li>

                            <li class="timeline-inverted">
                                <div class="timeline-badge success"><i class="fa fa-credit-card"></i>
                                </div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h4 class="timeline-title">Total Income</h4>
                                        
                                    </div>
                                    <div class="timeline-body">
                                        <p>Total Income: Rs 0</p>
                                    </div>
                                </div>
                            </li>                            
                        </ul>
                    </div>
                </div>
            </div> -->
        </div>
<?php require APPROOT .'/views/inc_patient/footer.php'; ?>


