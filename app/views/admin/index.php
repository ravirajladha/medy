<?php require APPROOT .'/views/inc_admin/header.php'; 
$pagename = "index";
?>
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
  
  #MyClockDisplay {
    display: none;
  }
  
}
</style>
<?php
    $typeOfSubs = $data['subs']->plan_price_type;
    if($typeOfSubs == 4)
    {
        $checkDate = $data['subs']->trial_end_date;
        $today = date('Y-m-d h:i:s');
        if($today > $checkDate)
        {
            $setTheCheck = 1;
        }
        $diff = abs(strtotime($today) - strtotime($checkDate));
    }
    else
    {
        $checkDate = $data['subs']->end_date;
        $today = $data['subs']->start_date;
        if($today > $checkDate)
        {
            $setTheCheck = 1;
        }
        $diff = abs(strtotime($checkDate) - strtotime($today));
    }

    $years = floor($diff / (365*60*60*24));
    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

    $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60)); 
    $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24  - $hours*60*60)/ 60);
?>

<title>Dashboard | Medhike</title>


<div class="wraper container-fluid">
                <div class="page-title"> 
                    <h3 class="title">Welcome <span style="color: #AF7AC5"><?php echo ucwords($_SESSION['user_name']); ?></span></h3> 
                </div>
                <?php if($days <= 7 && $years == 0 && $months == 0) { ?>
                <div class="alert alert-danger">
                    <?php
                        $t = new DateTime();
                        $c = new DateTime($checkDate);  
                        if($t > $c)
                        {
                            if($typeOfSubs != 4)
                            { 
                    ?>
                                Your <span class="alert-link">SUBSCRIPTION</span> has expired<span class="alert-link">
                                    <a href="<?php echo URLROOT; ?>/admin/getPlans">
                                    <button class="btn btn-info btn-xs m-b-5" style="float: right; width: 100px;">Buy Plan</button></a>

                                    <a href="<?php echo URLROOT; ?>/admin/getPlans">
                                    <button class="btn btn-info btn-xs m-b-5" style="float: right; width: 100px; margin-right: 5px;">Renew</button></a>
                                </span>
                    <?php 
                            } 
                            else
                            { 
                    ?>
                                Your <span class="alert-link">TRIAL</span> has expired<span class="alert-link">
                                    <button class="btn btn-info btn-xs m-b-5" style="float: right; width: 100px;">Buy Plan</button>
                                </span>
                    <?php 
                            } 

                        }
                        if($t < $c)
                        {
                            if($typeOfSubs != 4)
                            { 
                    ?>
                                Your <span class="alert-link">SUBSCRIPTION</span> will expire in
                                <?php
                                    if(!$years == 0)
                                    {
                                        echo $years. " year(s)";
                                    }
                                    if(!$months == 0)
                                    {
                                        echo $months. " month(s)";
                                    }
                                    if(!$days == 0)
                                    {
                                        echo $days. " day(s)";
                                    }
                                    if(!$hours == 0)
                                    {
                                        echo $hours. " hour(s)";
                                    }
                                    if(!$minutes == 0)
                                    {
                                        echo $minutes. " minute(s)";
                                    }

                                ?>
                                <span class="alert-link">
                                    <a href="<?php echo URLROOT; ?>/admin/getPlans">
                                        <button class="btn btn-info btn-xs m-b-5 preLoadButtonsAndATags" style="float: right; width: 100px;">Buy Plan</button>
                                    </a>
                                    <a href="<?php echo URLROOT; ?>/admin/getPlans">
                                        <button class="btn btn-primary btn-xs m-b-5 preLoadButtonsAndATags" style="float: right; width: 100px; margin-right: 5px;">Renew</button>
                                    </a>
                                </span>
                    <?php 
                            } 
                            else
                            { 
                    ?>
                                Your <span class="alert-link">TRIAL</span> will expire in 
                                <?php
                                    if(!$years == 0)
                                    {
                                        echo $years. " year(s)";
                                    }
                                    if(!$months == 0)
                                    {
                                        echo $months. " month(s)";
                                    }
                                    if(!$days == 0)
                                    {
                                        echo $days. " day(s)";
                                    }
                                    if(!$hours == 0)
                                    {
                                        echo $hours. " hour(s)";
                                    }
                                    if(!$minutes == 0)
                                    {
                                        echo $minutes. " minute(s)";
                                    }

                                ?><span class="alert-link">
                                    <a href="<?php echo URLROOT; ?>/admin/getPlans">
                                        <button class="btn btn-info btn-xs m-b-5" style="float: right; width: 100px;">Buy Plan</button>
                                    </a>
                                </span>
                    <?php 
                            }
                        }
                    ?>
                </div>
                <?php } 
                ?>

                <?php 
                    if($today > $checkDate)
                    {
                ?>
                <div class="alert alert-danger">
                    Your account subscription is ended
                    <span class="alert-link">
                        <a href="<?php echo URLROOT; ?>/admin/getPlans">
                            <button class="btn btn-info btn-xs m-b-5 preLoadButtonsAndATags" style="float: right; width: 100px;">Buy Plan</button>
                        </a>
                    </span>
                </div>
                <?php
                    }
                ?>
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
                            <h2 class="m-0 counter"><?php echo $data['ipd'];?></h2>
                            <div>Consultations</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="widget-panel widget-style-2 bg-success">
                            <i class="fa fa-file" aria-hidden="true" style="height: 135px; width: 113px; font-size: 50px; padding-top: 45px;"></i>
                           
                            <h2 class="m-0 counter"><?php echo $data['opd'];?></h2>
                            <div>Reports</div>
                        </div>
                    </div>
                </div> <!-- end row -->
           <!-- End row -->
            <div class="wraper container-fluid">
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
            </div>
        </div>
       
<script type="text/javascript">
        function showTime(){
        var date = new Date();
        var h = date.getHours(); // 0 - 23
        var m = date.getMinutes(); // 0 - 59
        var s = date.getSeconds(); // 0 - 59
        var session = "AM";
        
        if(h == 0){
            h = 12;
        }
        
        if(h > 12){
            h = h - 12;
            session = "PM";
        }
        
        h = (h < 10) ? "0" + h : h;
        m = (m < 10) ? "0" + m : m;
        s = (s < 10) ? "0" + s : s;
        
        var time = h + ":" + m + ":" + s + " " + session;
        document.getElementById("MyClockDisplay").innerText = time;
        document.getElementById("MyClockDisplay").textContent = time;
        
        setTimeout(showTime, 1000);
        
    }

    showTime();

</script>

<!-- <script type="text/javascript">
    var requestUrl = "http://ip-api.com/json";

    $.ajax({
      url: requestUrl,
      type: 'GET',
      success: function(json)
      {
        // alert(json.countryCode);
      },
      error: function(err)
      {
        console.log("Request failed, error= " + err);
      }
    });
</script> -->

<?php require APPROOT .'/views/inc_admin/footer.php'; ?>


<?php if(isset($_SESSION['12345679813256789321679524']))
{ ?> 
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
     
      swal("Payment Successful!", "Your Account is Created. Thank You..!", "success");

    </script> 
<?php } 
unset($_SESSION['12345679813256789321679524']);
?>




<!------ Include the above in your HEAD tag ---------->

<link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container">
    <div class="row">
<!-- Modal -->
    </div>
</div>
