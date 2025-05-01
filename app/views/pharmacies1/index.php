<?php require APPROOT .'/views/inc_pharmacy/header.php'; ?>
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
  
  #MyClockDisplay {
    display: none;
  }
  
}
</style>
<div class="wraper container-fluid">
                <div class="page-title"> 
                    <h3 class="title">Welcome !</h3> 
                </div>

               <div class="row">
                    <div class="col-lg-3 col-sm-6">
                    	<a href="<?php echo URLROOT;?>/receptions/new_orders">
                        <div class="widget-panel widget-style-2 white-bg">
                            <i style="color: #FF0066" class="ion-eye"></i> 
                            <h2 style="color: gray" class="m-0 counter"><?php echo $data['new_order_count'];?></h2>
                            <div style="color:gray; font-size: 16px;">New Order</div>
                        </div></a>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="widget-panel widget-style-2 white-bg">
                            <i style="color: #660099" class="ion-wifi"></i> 
                            <h2 style="color: gray" class="m-0 counter"><?php echo $data['drug'];?></h2>
                            <div style="color: gray; font-size: 16px;">New Drug</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="widget-panel widget-style-2 white-bg">
                            <i style="color: #2196F3" class="ion-ios7-pricetag"></i> 
                            <h2 style="color: gray" class="m-0 counter"><?php echo $data['stock'];?></h2>
                            <div style="color: gray; font-size: 16px;">New Stock</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="widget-panel widget-style-2 white-bg">
                            <i style="color: #33CC99" class="ion-android-contacts"></i> 
                            <h2 style="color: gray" class="m-0 counter">100</h2>
                            <div style="color: gray; font-size: 16px;">Support</div>
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
                                        <h4 class="timeline-title">Date: <?php echo date('d-m-Y');?></h4>   
                                    </div>
                                    <div class="timeline-body">
                                        <p>Number Of Orders: <?php echo $data['counter'];?>
                                        &nbsp &nbsp
                                            Total Income: <?php echo $data['sum'];?>
                                        &nbsp &nbsp
                                            Total Product Sold: <?php echo $data['product_sold'];?>
                                        </p>

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
<?php require APPROOT .'/views/inc_pharmacy/footer.php'; ?>
