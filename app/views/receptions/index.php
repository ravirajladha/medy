<?php require APPROOT .'/views/inc_reception/header.php'; ?>

<title>Dashboard | Medhike</title>
<style type="text/css">
    .clock {
    position: absolute;
    right: 40%;
    top: 50%;
    transform: translateX(-50%) translateY(-50%);
    color: #5D6D7E;
    font-size: 60px;
    font-family: Orbitron;
    letter-spacing: 7px;
}
@media (min-width: 320px) and (max-width: 480px) {
    .hide_it{
        margin-left: 0px;
        margin-top: 0px;
    }

    .port_hide_it{
       margin-top: 20px;
    }
}

@media (min-width: 500px) {
    .hide_it{
        margin-left: 40px;
        margin-top: 20px;
    }

    .port_hide_it{
        width: 100%;
        height: 422px;
    }
}
</style>

<div class="wraper container-fluid">
                <div class="page-title"> 
                    <h3 class="title">Welcome &nbsp; <span style="color: #8E44AD;"><?php echo ucwords($_SESSION['user_name']);?></span></h3> 
                </div>
                
               <div class="row">
                    <div class="col-lg-3 col-sm-6">
                    	<a href="<?php echo URLROOT;?>/receptions/new_orders">
                        <div class="widget-panel widget-style-2 bg-pink">
                            <i class="ion-clipboard" style="width: 113px; height: 135px;"></i> 
                            <h2 class="m-0 counter"><?php echo $data['order'];?></h2>
                            <div>Orders</div>
                        </div></a>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="widget-panel widget-style-2 bg-purple">
                            <i class="ion-person-add" style="height: 135px;"></i> 
                            <h2 class="m-0 counter"><?php echo $data['patient'];?></h2>
                            <div>Patients</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="widget-panel widget-style-2 bg-info">
                            <i class="ion-person-stalker" style="height: 135px;"></i> 
                            <h2 class="m-0 counter"><?php echo $data['visit'];?></h2>
                            <div>OP Visits</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="widget-panel widget-style-2 bg-success">
                            <i class="fa fa-wheelchair" aria-hidden="true" style="height: 135px; width: 113px;"></i>
                           
                            <h2 class="m-0 counter"><?php echo $data['admit'];?></h2>
                            <div>IP admits</div>
                        </div>
                    </div>
                </div> <!-- end row -->
           <!-- End row -->
           <div class="page-title"> 
                    <h3 class="title">Quick Stats</h3> 
                </div>
            <div class="wraper container-fluid">

                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="timeline" style="margin-right: 0px;">
                                <li class="timeline-inverted">
                                    <div class="timeline-badge info" ><i class="fa fa-shopping-cart"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title">Orders</h4>
                                        </div>
                                        <div class="timeline-body">
                                            <span>Total Orders: 0 Orders</span>
                                            <span style="float: right;">Today's Orders: 0 Orders</span>
                                        </div>
                                    </div>
                                </li>
                                <!-- <li class="timeline-inverted">
                                    <div id="MyClockDisplay" class="clock" onload="showTime()"></div>
                                </li> -->
                                <li class="timeline-inverted">
                                    <div class="timeline-badge warning"><i class="fa fa-money"></i>
                                    </div>
                                   <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title">Cash Income</h4>
                                            
                                        </div>
                                        <div class="timeline-body">
                                            <span>Total Cash Income: Rs 0</span>
                                            <span style="float: right;">Today's Cash Income: Rs 0</span>
                                        </div>
                                    </div>
                                </li>
                                
                                <li class="timeline-inverted">
                                    <div class="timeline-badge" style="background-color: tomato;"><i class="fa fa-credit-card"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title">Digital Income</h4>
                                            
                                        </div>
                                        <div class="timeline-body">
                                            <span>Total Digital Income: Rs 0</span>
                                            <span style="float: right;">Today's Digital Income: Rs 0</span>
                                        </div>
                                    </div>
                                </li>

                                <li class="timeline-inverted">
                                    <div class="timeline-badge success"><i class="fa fa-inr"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title">Total Income</h4>
                                            
                                        </div>
                                        <div class="timeline-body">
                                            <span>Total Income: Rs 0</span>
                                            <span style="float: right;">Today's Income: Rs 0</span>
                                        </div>
                                    </div>
                                </li>                            
                            </ul>
                        </div>
                        <!-- <div class="col-md-4 hide_it" align="right">
                            <div class="portlet port_hide_it" style=" ">
                                <div class="portlet-heading" >
                                    <h3 class="portlet-title text-dark text-uppercase">
                                        Yearly Sales Report
                                    </h3>
                                    <div class="portlet-widgets" >
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div id="portlet2" class="panel-collapse collapse in">
                                    <div class="portlet-body">
                                        <div id="morris-line-example" style="height: 200px;"></div>
                                        <div class="row text-center m-t-30">
                                    <div class="col-sm-4">
                                        <h4>$ 86,956</h4>
                                        <small class="text-muted"> This Year's Report</small>
                                    </div>
                                    <div class="col-sm-4">
                                        <h4>$ 86,69</h4>
                                        <small class="text-muted">Weekly Sales Report</small>
                                    </div>
                                    <div class="col-sm-4">
                                        <h4>$ 948,16</h4>
                                        <small class="text-muted">Yearly Sales Report</small>
                                    </div>
                                </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
<?php require APPROOT .'/views/inc_reception/footer.php'; ?>


