<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once './db_functions.php';
include_once './db_connect.php';
$db = new DB_Functions();
$db_con = new DB_Connect();
$con = $db_con->connect();
$result = $db->selectInventory($con);
$count=0;
$outp = '{ "success": true,"inventory" : ';
    $outp .= '[';
while ($row = mysqli_fetch_row($result)){

/*
	$outp .= '{"hostname['.$count.']":"'  . $row["1"] . '",';
    $outp .= '"macaddr['.$count.']":"'   . $row["2"]        . '",';
    $outp .= '"ip['.$count.']":"'   . $row["3"]        . '",';
    $outp .= '"flag['.$count.']":"'. $row["4"]     . '"}';
    */

    $outp .= '{"name":"'  . $row["1"] . '",';
    $outp .= '"temp":"'   . $row["2"]        . '",';
	  $outp .= '"macaddress":"'. $row["0"]     . '"},';

}
	$outp = substr($outp, 0,-1);
	$outp .="]";
	$outp .="}";
print $outp;



?>
