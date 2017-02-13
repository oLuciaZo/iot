<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once './db_functions.php';
include_once './db_connect.php';
$db = new DB_Functions();
$db_con = new DB_Connect();
$con = $db_con->connect();
$result = $db->getAllDevices($con);
$count=0;
$outp = '{ "success": true,"monitor" : ';
    $outp .= '[';
while ($row = mysqli_fetch_row($result))
{

/*
	$outp .= '{"hostname['.$count.']":"'  . $row["1"] . '",';
    $outp .= '"macaddr['.$count.']":"'   . $row["2"]        . '",';
    $outp .= '"ip['.$count.']":"'   . $row["3"]        . '",';
    $outp .= '"flag['.$count.']":"'. $row["4"]     . '"}';
    */

    $outp .= '{"name":"'  . $row["0"] . '",';
    $outp .= '"macaddress":"'   . $row["1"]        . '",';
    $outp .= '"humidity":"'   . $row["2"]        . '",';
    $outp .= '"temp":"'   . $row["3"]        . '",';
	  $outp .= '"time":"'. $row["4"]     . '"},';

}
	$outp = substr($outp, 0,-1);
	$outp .="]";
	$outp .="}";
print $outp;



?>
