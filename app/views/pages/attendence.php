<?php require APPROOT . '/views/inc/header.php'; ?>

            <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-8">
                        <h4 class="page-title">Attendence</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo URLROOT;?>/assets/pages/index">Home</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo URLROOT;?>/assets/pages/index">Attendence</a></li>
                            
                            </ol>
                        </div>
                    </div>
                </div>          
            </div>
            <!-- End Breadcrumbbar -->
<?php    

function get_client_ip()
{
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    } else if (isset($_SERVER['REMOTE_ADDR'])) {
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    } else {
        $ipaddress = 'UNKNOWN';
    }

    return $ipaddress;
}
$PublicIP = get_client_ip();
$json     = file_get_contents("https://tools.keycdn.com/geo.json?host={$PublicIP}");
$json     = json_decode($json, true);
if($json['status']=="success")
{
    $json  = $json['data'];
    $json  = $json['geo'];
    $country  = $json['country_name'];
    $region   = $json['region_name'];
    $city     = $json['city'];
    $latitude     = $json['latitude'];
    $longitude     = $json['longitude'];
    $postal_code     = $json['postal_code'];
}
?>
            <!-- Start Contentbar --> 
            <div class="container">
                <?php if(empty($data['s_emp']->punch_status)){ ?>
                <form method="POST" action="<?php echo URLROOT;?>/pages/punchIn"> 
                    <input type="hidden" name="city" value="<?php echo $city;?>">
                    <div class="row">
                        <div class="col-4"></div>
                        <div class="col-md-2">
                           <button style="border-radius: 100%; height: 150px;" class="btn btn-info btn-lg btn-block font-18 button5_p button_p" id="sub_btn">Punch In</button>
                        </div>
                    </div>
                </form>
                <?php }else{?>
                <form method="POST" action="<?php echo URLROOT;?>/pages/punchOut"> 
                    <input type="hidden" name="city" value="<?php echo $city;?>">
                    <div class="row">
                        <div class="col-4"></div>
                        <div class="col-md-2">
                           <button style="border-radius: 100%; height: 150px;" class="btn btn-success btn-lg btn-block font-18 button5_p button_p" id="sub_btn">Punch Out</button>
                        </div>
                    </div>
                </form>
                <?php }?>
            </div>   
            <!-- End Contentbar -->

<?php require APPROOT . '/views/inc/footer.php'; ?>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>
