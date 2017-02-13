<?php

include_once './db_functions.php';
include_once './db_connect.php';
$db = new DB_Functions();
$db_con = new DB_Connect();
$con = $db_con->connect();
$mac = $_POST["mac"];
$name = $_POST["name"];
$temp = $_POST["temp"];
$result = $db->updateInventory($name,$mac,$temp,$con);
//print "UPDATE `iot_inventory` SET `int_name` = '$name' ,`int_temp` = '$temp' WHERE `int_mac` = '$mac' ";
header("Location: inventory.html");


?>
