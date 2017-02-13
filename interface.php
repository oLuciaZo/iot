<?php
$ip = $_POST['ipaddress'];
$net = $_POST['netmask'];
$gw = $_POST['gateway'];
//print $ip = $_POST['ipaddress'];
//print $net = $_POST['netmask'];
//print $gw = $_POST['gateway'];
//print "<br>";
//print 'sudo -n /sbin/ifconfig enp0s3 '.$ip.' netmask '.$net.' up';
//echo exec('/sbin/ifconfig enp0s3 | grep "inet addr:"');
/*$ip = '192.168.1.111';
//if($ipConf != $ip) {
    $ifdownSuccess = exec("sudo -n ifconfig enp0s3 down", $downOutput, $downRetvar);
    $ifupSuccess = exec("sudo -n ifconfig enp0s3 up ".$ip, $upOutput, $upRetvar);
    //TODO: check for ifupSucess and revert to old ip if the command failed
    var_dump($downOutput);
    var_dump($downRetvar);
    var_dump($ifdownSuccess);
    var_dump($upOutput);
    var_dump($upRetvar);
    var_dump($ifupSuccess);
//}
*/
//echo exec('sudo -n /sbin/ifconfig enp0s3 down');
//echo exec('sudo -n /sbin/ifconfig enp0s3 '.$ip.' netmask '.$net.' up');
//echo exec('sudo -n route add -net 0.0.0.0 netmask 0.0.0.0 gw '.$gw.'');
//header("Location: interface_setup.php");

$file = fopen("/etc/network/interfaces","w");

echo fwrite($file,"source /etc/network/interfaces.d/*"."\n");
echo fwrite($file,"auto lo"."\n");
echo fwrite($file,"iface lo inet loopback"."\n");
echo fwrite($file,"\n");
echo fwrite($file,"auto enp0s3"."\n");
echo fwrite($file,"iface enp0s3 inet static"."\n");
echo fwrite($file,"address $ip"."\n");
echo fwrite($file,"netmask $net"."\n");
//echo fwrite($file,"network 192.168.1.0"."\n");
//echo fwrite($file,"broadcast 192.168.1.255"."\n");
echo fwrite($file,"gateway $gw"."\n");
echo fwrite($file,"\n");
echo fwrite($file,"auto enp0s8"."\n");
echo fwrite($file,"iface enp0s8 inet dhcp"."\n");
fclose($file);
header("Location: index.html");
shell_exec('sh /home/sitita/reboot.sh');


 ?>
