<?php
/**
* This example shows making an SMTP connection with authentication.
*/

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Asia/Bangkok');

require 'PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer();
	$mail->IsHTML(true);
	$mail->IsSMTP();
	$mail->SMTPAuth   = true;
	$mail->SMTPSecure = "tls";
	$mail->Host       = 'smtp.live.com';
	$mail->Port       = '587';
	$mail->Username = "sitita_charuraks@hotmail.com"; // GMAIL username
	$mail->Password = "luci@s9196919"; // GMAIL password
	$mail->From = "sitita_charuraks@hotmail.com"; // "name@yourdomain.com";
	//$mail->AddReplyTo = "support@thaicreate.com"; // Reply
	//$mail->FromName = "Mr.Weerachai Nukitram";  // set from Name
	$mail->Subject = "Test sending mail.";
	$mail->Body = "My Body & <b>My Description</b>";

	$mail->AddAddress("sitita_charuraks@hotmail.com", "Pi Technology"); // to Address
	//send the message, check for errors
	if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
    echo "Message sent!";
	}
