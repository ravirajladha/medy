<?php require APPROOT .'/views/inc_ot/header.php'; ?>

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
                    	<a href="<?php echo URLROOT;?>/ot/current_operation">
                        <div class="widget-panel widget-style-2 bg-pink" style="height: 135px;">
                            <i class="fa fa-heartbeat" style=" height: 155px;"></i> 
                            <h2 class="m-0 counter"><?php echo $data['req'];?></h2>
                            <div>Current Operations</div>
                        </div></a>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <a href="<?php echo URLROOT;?>/ot/active_operation">
                        <div class="widget-panel widget-style-2 bg-purple" style="height: 135px;">
                            <i class="fa fa-heartbeat" style="height: 135px;"></i> 
                            <h2 class="m-0 counter"><?php echo $data['active'];?></h2>
                            <div>&nbspActive &nbsp Operations</div>
                        </div>
                    </a>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <a href="<?php echo URLROOT;?>/ot/completed_operation">
                        <div class="widget-panel widget-style-2 bg-info" style="height: 135px;">
                            <i class="fa fa-hospital-o" style="height: 155px;"></i> 
                            <h2 class="m-0 counter"><?php echo $data['completed'];?></h2>
                            <div>Completed Operations</div>
                        </div>
                    </a>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <a href="<?php echo URLROOT;?>/ot/canceled_operation">
                        <div class="widget-panel widget-style-2 bg-success" style="height: 135px;">
                            <i class="fa fa-ambulance" aria-hidden="true" style="height: 155px; width: 113px;"></i>
                           
                            <h2 class="m-0 counter"><?php echo $data['canceled'];?></h2>
                            <div>Canceled Operations</div>
                        </div>
                    </a>
                    </div>
                </div> <!-- end row -->
           <!-- End row -->
          
           
        </div>

<?php require APPROOT .'/views/inc_ot/footer.php'; ?>