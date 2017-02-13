<?php
if(isset($_GET["humidity"]) && isset($_GET["temp"]) && isset($_GET["mac"]) && isset($_GET["ip"])){
  $humidity = $_GET["humidity"];
  $temp = $_GET["temp"];
  $mac = $_GET["mac"];
  $ip  = $_GET["ip"];
  include_once './db_functions.php';
  include_once './db_connect.php';
  $db = new DB_Functions();
  $db_con = new DB_Connect();
  $con = $db_con->connect();
  $result = $db->getAllDevices($con);
$db->storedata($ip, $mac, $humidity, $temp,$con);
$db->insertIntventory($mac,$con);
  //print $mac." ".$humidity." ".$temp;

}

?>
