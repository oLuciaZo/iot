<?php
//if(isset($_GET["humidity"]) && isset($_GET["temp"]) && isset($_GET["mac"]) && isset($_GET["ip"])){
  $SMTPAuth = $_POST["SMTPAuth"];
  $SMTPSecure = $_POST["SMTPSecure"];
  $host = $_POST["host"];
  print $port = $_POST["port"];
  $username = $_POST["username"];
  print $password = $_POST["password"];
  $email = $_POST["from"];


  include_once './db_functions.php';
  include_once './db_connect.php';
  $db = new DB_Functions();
  $db_con = new DB_Connect();
  $con = $db_con->connect();
$db->storeemail($SMTPAuth, $SMTPSecure, $host, $port, $username, $password, $email,$con);
//$db->insertIntventory($mac);
  //print $mac." ".$humidity." ".$temp;
  header("Location: index.html");

//}

?>
