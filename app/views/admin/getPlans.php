<?php require APPROOT .'/views/inc_admin/header.php'; 
$pagename = "index";
?>
<!-- animate -->
<link rel="stylesheet" href="<?php echo URLROOT;?>/medhike_website/css/animate.css">
    <!-- bootstrap -->
    <link rel="stylesheet" href="<?php echo URLROOT;?>/medhike_website/css/bootstrap.min.css">
    <!-- magnific popup -->
    <link rel="stylesheet" href="<?php echo URLROOT;?>/medhike_website/css/magnific-popup.css">
    <!-- owl carousel -->
    <link rel="stylesheet" href="<?php echo URLROOT;?>//medhike_website/css/owl.carousel.min.css">
    <!-- icons -->
    <link rel="stylesheet" href="<?php echo URLROOT;?>//medhike_website/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT;?>//medhike_website/css/line-awesome.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT;?>//medhike_website/css/themify-icons.css">
    <link rel="stylesheet" href="<?php echo URLROOT;?>//medhike_website/css/flaticon.css">
    <!-- slick slider -->
    <link rel="stylesheet" href="<?php echo URLROOT;?>//medhike_website/css/slick.css">
    <!-- animated slider -->
    <link rel="stylesheet" href="<?php echo URLROOT;?>//medhike_website/css/animated-slider.css">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="<?php echo URLROOT;?>//medhike_website/css/style.css">
    <!-- responsive Stylesheet -->
    <link rel="stylesheet" href="<?php echo URLROOT;?>//medhike_website/css/responsive.css">
<?php
function getVisIpAddr() { 
      
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) { 
        return $_SERVER['HTTP_CLIENT_IP']; 
    } 
    else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
        return $_SERVER['HTTP_X_FORWARDED_FOR']; 
    } 
    else { 
        return $_SERVER['REMOTE_ADDR']; 
    } 
} 

$ip = getVisIPAddr(); 

$ipdat = @json_decode(file_get_contents( 
    "http://www.geoplugin.net/json.gp?ip=" . $ip)); 
$country = $ipdat->geoplugin_currencyCode; 
// $country = "INR"; 
?>
<style type="text/css">
    .material-switch > input[type="checkbox"] {
    display: none;   
}
.material-switch > label {
    cursor: pointer;
    height: 0px;
    position: relative; 
    width: 40px;  
}
.material-switch > label::before {
    background: #01358D;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
    border-radius: 8px;
    content: '';
    height: 16px;
    margin-top: -8px;
    position:absolute;
    transition: all 0.4s ease-in-out;
    width: 40px;
}
.material-switch > label::after {
    background: #f9556d;
    border-radius: 16px;
    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
    content: '';
    height: 24px;
    left: -4px;
    margin-top: -8px;
    position: absolute;
    top: -4px;
    transition: all 0.3s ease-in-out;
    width: 24px;
}
.material-switch > input[type="checkbox"]:checked + label::before {
    background: #01358D;
    /*opacity: 0.5;*/
}
.material-switch > input[type="checkbox"]:checked + label::after {
    background: #f9556d;
    left: 20px;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<div class="pricing-page-area pd-top-12" id="pricing">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6">
                <div class="section-title text-center">
                    <h2 class="title">Choose your <span>Plan</span></h2>
                </div>
                <ul class="">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-2 "><span style="font-size: 18px!important;color: #5B6880;"><b>Monthly</b></span></div>
                        <div class="col-lg-2">
                            <div class="material-switch" style="padding-left: 15px;">
                                <input id="someSwitchOptionDefault" name="someSwitchOption001" type="checkbox"/>
                                <label for="someSwitchOptionDefault" class="label-default"></label>
                            </div>
                        </div>
                        <div class="col-lg-2"><span style="font-size: 18px!important;color: #5B6880;"><b>Annualy</b></span></div>
                    </div>
                </ul><br>
            </div>
        </div>
        <div class="row no-gutters justify-content-center">
            <div class="col-xl-3 col-lg-4 col-sm-6">
                 <div class="single-pricing text-center">
                    <h6 class="title">CLINIC</h6>
                    <div class="thumb">
                        <img src="<?php echo URLROOT; ?>/medhike_website/img/price/1.png" alt="pricing">
                    </div>
                    <h3 class="price" >
                        <?php if($country == 'INR') { ?>
                            <i class="fa fa-inr" aria-hidden="true"></i>
                            <x id="c1">999</x> <span>/<y id="per1">Monthly</y></span>
                        <?php } else { ?>
                            <i class="fa fa-usd"></i>
                            <x id="c1">49</x> <span>/<y id="per1">Monthly</y></span>
                        <?php } ?> 
                    </h3>
                    <ul>
                        <li>50 Doctor</li>
                        <li>1 Reception</li>
                        <li>Admin</li>
                        <!-- <li>Video Calling(1000 minutes)</li> -->
                        <li>&nbsp;</li>
                        <li>&nbsp;</li>
                        <li>&nbsp;</li>
                        <li>&nbsp;</li>
                        <li>&nbsp;</li>
                        <li>&nbsp;</li>
                    </ul>
                    <form action="<?php echo URLROOT;?>/admin/payment/1" method="POST">
                        <?php if($country == 'INR') { ?>
                            <input type="hidden" name="currencyType" value="1">
                            <input type="hidden" name="price" id="priceClinic" value="999">
                        <?php } else { ?>
                            <input type="hidden" name="currencyType" value="2">
                            <input type="hidden" name="price" id="priceClinic" value="49">
                        <?php } ?>
                        <input type="hidden" name="mOrY" class="monthlyOrAnnualy" value="1"><br>
                        <button class="btn btn-white btn-rounded" type="submit">Buy</button>
                    </form>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                 <div class="single-pricing text-center single-pricing-active">
                    <h6 class="title">HOSPITAL</h6>
                    <div class="thumb">
                        <img src="<?php echo URLROOT; ?>/medhike_website/img/price/2.png" alt="pricing">
                    </div>
                    <h3 class="price" id="">
                        <?php if($country == 'INR') { ?>
                            <i class="fa fa-inr" aria-hidden="true"></i>
                            <x id="c2">4500</x> <span>/<y id="per2">Monthly</y></span>
                        <?php } else { ?>
                            <i class="fa fa-usd"></i>
                            <x id="c2">149</x> <span>/<y id="per2">Monthly</y></span>
                        <?php } ?>
                        </h3>
                    <ul>
                        <li>Unlimited Doctors</li>
                        <li>Unlimited Receptions</li>
                        <li>Unlimited Nurses</li>
                        <li>Admin </li>
                        <li>Ward Manager</li>
                        <li>Laboratory</li>
                        <li>Pharmacy</li>
                        <li>OT & ICU</li>
                        <li>Patients</li>
                        <!-- <li>Video Calling(5000 minutes)</li> -->
                        <li>&nbsp;</li>
                    </ul>
                    <form action="<?php echo URLROOT;?>/admin/payment/2" method="POST">
                        <?php if($country == 'INR') { ?>
                            <input type="hidden" name="currencyType" value="1">
                            <input type="hidden" name="price" id="priceClinicPro" value="4500">
                        <?php } else { ?>
                            <input type="hidden" name="currencyType" value="2">
                            <input type="hidden" name="price" id="priceClinicPro" value="149">
                        <?php } ?>
                        
                        <input type="hidden" name="mOrY" class="monthlyOrAnnualy" value="1">
                        <button class="btn btn-white btn-rounded">Buy</button>
                    </form>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                 <div class="single-pricing text-center single-pricing">
                    <h6 class="title">HOSPITAL PRO</h6>
                    <div class="thumb">
                        <img src="<?php echo URLROOT; ?>/medhike_website/img/price/2.png" alt="pricing">
                    </div>
                        <h3 class="price" id="">
                        <?php if($country == 'INR') { ?>
                            <i class="fa fa-inr" aria-hidden="true"></i>
                            <x id="c3">9500</x> <span>/<y id="per3">Monthly</y></span>
                        <?php } else { ?>
                            <i class="fa fa-usd"></i>
                            <x id="c3">249</x> <span>/<y id="per3">Monthly</y></span>
                        <?php } ?>
                    </h3>
                    <ul>
                        <li>Unlimited Doctors</li>
                        <li>Unlimited Receptions</li>
                        <li>Unlimited Nurses</li>
                        <li>Admin </li>
                        <li>Ward Manager</li>
                        <li>Laboratory</li>
                        <li>Pharmacy</li>
                        <li>OT & ICU</li>
                        <li>Patients</li>
                        <li>Video Calling(5000 minutes)</li>
                        <li>Patient App</li>
                    </ul>
                    <form action="<?php echo URLROOT;?>/admin/payment/3" method="POST">
                        <?php if($country == 'INR') { ?>
                            <input type="hidden" name="currencyType" value="1">
                            <input type="hidden" name="price" id="priceClinicPro" value="9500">
                        <?php } else { ?>
                            <input type="hidden" name="currencyType" value="2">
                            <input type="hidden" name="price" id="priceClinicPro" value="249">
                        <?php } ?>
                        
                        <input type="hidden" name="mOrY" class="monthlyOrAnnualy" value="1">
                        <button class="btn btn-white btn-rounded">Buy</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- pricing area End -->   
<?php
    if($country == "INR")
    {
?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#someSwitchOptionDefault').change(function(){
            if(document.getElementById("c1").innerHTML == '9999')
            {
                document.getElementById("c1").innerHTML="999";
                $('#priceClinic').val(999);
                $('.monthlyOrAnnualy').val(1);
                document.getElementById("per1").innerHTML="Monthly";

                document.getElementById("c2").innerHTML="4500";   
                $('#priceClinicPro').val(4500);
                $('.monthlyOrAnnualy').val(1);
                document.getElementById("per2").innerHTML="Monthly";

                document.getElementById("c3").innerHTML="9500";  
                $('#priceClinicPro').val(9500);
                $('.monthlyOrAnnualy').val(1); 
                document.getElementById("per3").innerHTML="Monthly";
            }
            else
            {
                document.getElementById("c1").innerHTML="9999";
                $('#priceClinic').val(9999);
                $('.monthlyOrAnnualy').val(2);
                document.getElementById("per1").innerHTML="Annualy";

                document.getElementById("c2").innerHTML="45000";  
                $('#priceClinicPro').val(45000);
                $('.monthlyOrAnnualy').val(2); 
                document.getElementById("per2").innerHTML="Annualy";

                document.getElementById("c3").innerHTML="95000";   
                $('#priceClinicPro').val(95000);
                $('.monthlyOrAnnualy').val(2);
                document.getElementById("per3").innerHTML="Annualy";

            }
            
        });
    });
</script>
<?php
    } else { 
?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#someSwitchOptionDefault').change(function(){
             if(document.getElementById("c1").innerHTML == '490')
            {
                document.getElementById("c1").innerHTML="49";
                $('#priceClinic').val(49);
                $('.monthlyOrAnnualy').val(1);
                document.getElementById("per1").innerHTML="Monthly";
                document.getElementById("c2").innerHTML="149";   
                $('#priceClinicPro').val(149);
                $('.monthlyOrAnnualy').val(1);
                document.getElementById("per2").innerHTML="Monthly";

                 document.getElementById("c3").innerHTML="249";   
                $('#priceClinicPro').val(249);
                $('.monthlyOrAnnualy').val(1);
                document.getElementById("per3").innerHTML="Monthly";
            }
            else
            {
                document.getElementById("c1").innerHTML="490";
                $('#priceClinic').val(490);
                $('.monthlyOrAnnualy').val(2);
                document.getElementById("per1").innerHTML="Annualy";
                document.getElementById("c2").innerHTML="1490";  
                $('#priceClinicPro').val(1490);
                $('.monthlyOrAnnualy').val(2); 
                document.getElementById("per2").innerHTML="Annualy";

                 document.getElementById("c3").innerHTML="2490";  
                $('#priceClinicPro').val(2490);
                $('.monthlyOrAnnualy').val(2); 
                document.getElementById("per3").innerHTML="Annualy";

            }
            
        });
    });
</script>
<?php
    }
?>
<!-- pricing area End --> 
    <!-- jquery -->
    <script src="<?php echo URLROOT;?>/medhike_website/js/jquery-2.2.4.min.js"></script>
    <!-- popper -->
    <script src="<?php echo URLROOT;?>/medhike_website/js/popper.min.js"></script>
    <!-- bootstrap -->
    <script src="<?php echo URLROOT;?>/medhike_website/js/bootstrap.min.js"></script>
    <!-- magnific popup -->
    <script src="<?php echo URLROOT;?>/medhike_website/js/jquery.magnific-popup.js"></script>
    <!-- wow -->
    <script src="<?php echo URLROOT;?>/medhike_website/js/wow.min.js"></script>
    <!-- owl carousel -->
    <script src="<?php echo URLROOT;?>/medhike_website/js/owl.carousel.min.js"></script>
    <!-- slick slider -->
    <script src="<?php echo URLROOT;?>/medhike_website/js/slick.js"></script>
    <!-- cssslider slider -->
    <script src="<?php echo URLROOT;?>/medhike_website/js/jquery.cssslider.min.js"></script>
    <!-- waypoint -->
    <script src="<?php echo URLROOT;?>/medhike_website/js/waypoints.min.js"></script>
    <!-- counterup -->
    <script src="<?php echo URLROOT;?>/medhike_website/js/jquery.counterup.min.js"></script>
    <!-- imageloaded -->
    <script src="<?php echo URLROOT;?>/medhike_website/js/imagesloaded.pkgd.min.js"></script>
    <!-- isotope -->
    <script src="<?php echo URLROOT;?>/medhike_website/js/isotope.pkgd.min.js"></script>
    <!-- world map -->
    <script src="<?php echo URLROOT;?>/medhike_website/js/worldmap-libs.js"></script>
    <script src="<?php echo URLROOT;?>/medhike_website/js/worldmap-topojson.js"></script>
    <script src="<?php echo URLROOT;?>/medhike_website/js/mediaelement.min.js"></script>
     <!-- main js -->
    <script src="<?php echo URLROOT;?>/medhike_website/js/main.js"></script>
<?php require APPROOT .'/views/inc_admin/footer.php'; ?>