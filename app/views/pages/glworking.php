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
<a href="https://www.google.com/maps?q=<?php echo $latitude;?>,<?php echo $longitude;?>" target="_blank">click to view in map</a>
<?php
    echo "<br>Latitude: ".$latitude     = $json['latitude'];
    echo "<br>Longitude".$longitude     = $json['longitude'];
    echo "<br>".$city     = $json['city']."<br>";
    echo $region   = $json['region_name']."<br>";
    echo $country  = $json['country_name']."<br>";
?>
