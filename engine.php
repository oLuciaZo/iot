<?php
date_default_timezone_set('Asia/Bangkok');
require 'PHPMailer/PHPMailerAutoload.php';
include_once '/var/www/html/iot/db_functions.php';
include_once '/var/www/html/iot/db_connect.php';
$db = new DB_Functions();
$db_con = new DB_Connect();
$con = $db_con->connect();
$result_mail = $db->getemail($con);
$Subject = "List of critical devices : ";
$outp = "";
$SMTPAuth = "";
$SMTPSecure = "";
$Host = "";
$Port = "";
$Username = "";
$Password = "";
$From = "";
/*if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    //you need to exit the script, if there is an error
    exit();
}
*/
while($row_mail = mysqli_fetch_row($result_mail)){
  $SMTPAuth = $row_mail["0"];
  $SMTPSecure = $row_mail["1"];
  $Host = $row_mail["2"];
  $Port = $row_mail["3"];
  $Username = $row_mail["4"];
  $Password = $row_mail["5"];
  $From = $row_mail["6"];
}

while(true){
  $result_critical = $db->getCriticalDevices($con);

if(mysqli_num_rows($result_critical)==0){
  //return;
  print "No Devices"."\n";
  sleep(10);
}else{

  $count = 0;
while ($row = mysqli_fetch_row($result_critical)){

  $data_no[$count] = $row["0"];
  $outp .= '"name":"'  . $row["1"] . '",';
  $Subject = "List of critical devices : ".$row["1"].", ";
  $outp .= '<br>';
  $outp .= '"macaddress":"'   . $row["2"]        . '",';
  $outp .= '<br>';
  $outp .= '"humidity":"'   . $row["3"]        . '",';
  $outp .= '<br>';
  $outp .= '"temp":"'   . $row["4"]        . '",';
  $outp .= '<br>';
  $outp .= '"time":"'. $row["6"];
  $outp .= '<br>';
    $count++;
    }
    sendmail($SMTPAuth,$SMTPSecure,$Host,$Port,$Username,$Password,$From,$Subject,$outp);
    foreach ($data_no as $data) {
      $db->updateFlag($data,$con);
    }
    $outp="";
  }
}

function sendmail($SMTPAuth,$SMTPSecure,$Host,$Port,$Username,$Password,$From,$Subject,$outp){

  $mail = new PHPMailer();
  	$mail->IsHTML(true);
  	$mail->IsSMTP();
  	$mail->SMTPAuth   = $SMTPAuth;
  	$mail->SMTPSecure = "$SMTPSecure";
  	$mail->Host       = "$Host";
  	$mail->Port       = "$Port";
  	$mail->Username = "$Username"; // GMAIL username
  	$mail->Password = "$Password"; // GMAIL password
  	$mail->From = "$Username"; // "name@yourdomain.com";
  	$mail->Subject = $Subject;
  	$mail->Body = $outp;
  	$mail->AddAddress($From, "Pi Technology"); // to Address
  	//send the message, check for errors
  	if (!$mail->send()) {
      echo "Mailer Error: " . $mail->ErrorInfo;
  	} else {
      echo "Message sent!"."\n";
  	}
}

 ?>
