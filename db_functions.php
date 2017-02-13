<?php

class DB_Functions {

    private $db;
    //public $con;
    //put your code here
    // constructor
    function __construct() {
      //echo "Something";
        //require_once '/var/www/html/iot/config.php';
        //include_once '/var/www/html/iot/db_connect.php';
        // connecting to database
        //$db = new DB_Connect();
        //$con = $db->connect();
        //$this->db = new DB_Connect();
        //$con = $this->db->connect();
        //print $con;
        //$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    }

    // destructor
    function __destruct() {

    }

    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($name, $password, $email, $gcm_regid, $gcm_mac_address) {
        // insert user into database
        $result = mysqli_query("INSERT INTO gcm_users(name, email, password, gcm_regid, gcm_mac_address, created_at) VALUES('$name', '$email', '$password', '$gcm_regid', '$gcm_mac_address', NOW())");
        // check for successful store
        if ($result) {
            // get user details
            $id = mysqli_insert_id(); // last inserted id
            $result = mysqli_query("SELECT * FROM gcm_users WHERE id = $id") or die(mysqli_error());
            // return user details
            if (mysqli_num_rows($result) > 0) {
                return mysqli_fetch_array($result);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function storedata($ip, $mac, $humidity, $temp,$con){
      $result = mysqli_query($con,"INSERT INTO iot_data(data_ip,data_mac,data_humidity,data_temp,data_time) VALUES('$ip', '$mac', '$humidity', '$temp', NOW())");
      //return $result;
    }

    public function storeemail($SMTPAuth, $SMTPSecure, $host, $port, $username, $password, $email,$con){
      $result = mysqli_query($con,"UPDATE iot_email SET `SMTPAuth` = '$SMTPAuth', `SMTPSecure` = '$SMTPSecure', `Host` = '$host', `Port` ='$port' , `Username` = '$username', `Password` = '$password', `From_mail` = '$email' , `Flag` = '1' WHERE 1");
      return $result;
    }

    public function getemail($con){
      $result = mysqli_query($con,"SELECT * FROM iot_email");
      return $result;
    }

    public function updateFlag($data_no,$con){
      $result = mysqli_query($con,"UPDATE iot_data SET `data_flag` = '0' WHERE `data_no` = '$data_no' ");
    }

    public function getAllDevices($con){
      //$con = mysqli_connect("localhost", "sitita", "x]vf4ypfu", "iot");
      //$result = mysqli_query($con,"SELECT `int_name`,`data_mac`,`data_humidity`,`data_temp`,`data_time` FROM ( SELECT * FROM `iot_data` ORDER BY `data_time` DESC ) AS t1 INNER JOIN iot_inventory ON `data_mac` = `int_mac` WHERE `data_time` >= CURDATE() GROUP BY `data_mac`");
      $result = mysqli_query($con,"SELECT `int_name`,`data_mac`,`data_humidity`,`data_temp`,`data_time` FROM iot_data INNER JOIN iot_inventory ON `data_mac` = `int_mac` WHERE data_no IN (SELECT MAX(data_no) FROM iot_data GROUP BY data_mac)  AND `data_time` >= NOW() - INTERVAL 15 MINUTE");
      return $result;
    }
    public function getDownDevices($con){
      //$con = mysqli_connect("localhost", "sitita", "x]vf4ypfu", "iot");
      //$result = mysqli_query($con,"SELECT `int_name`,`data_mac`,`data_humidity`,`data_temp`,`data_time` FROM ( SELECT * FROM `iot_data` ORDER BY `data_time` DESC ) AS t1 INNER JOIN iot_inventory ON `data_mac` = `int_mac` WHERE `data_time` >= CURDATE() GROUP BY `data_mac`");
      $result = mysqli_query($con,"SELECT `int_name`,`data_mac`,`data_time` FROM iot_data INNER JOIN iot_inventory ON `data_mac` = `int_mac` WHERE data_no IN (SELECT MAX(data_no) FROM iot_data GROUP BY data_mac)  AND `data_time` < NOW() - INTERVAL 15 MINUTE");
      return $result;
    }

    public function getChart($mac, $con){
      $result = mysqli_query($con,"SELECT HOUR(data_time),data_mac,data_temp FROM iot_data WHERE data_time>=CURDATE() AND data_mac='$mac'");
      return $result;
    }

    public function getCriticalDevices($con){
      $result = mysqli_query($con,"SELECT `data_no`,`int_name`,`data_mac`,`data_humidity`,`data_temp`,`int_temp`,`data_time`,`data_flag` FROM ( SELECT * FROM `iot_data` ORDER BY `data_time` DESC ) AS t1 INNER JOIN iot_inventory ON `data_mac` = `int_mac` WHERE `data_temp` > `int_temp` AND `data_time` > NOW() - INTERVAL 15 MINUTE AND `data_flag` = '1' GROUP BY `data_mac`");
      //$result = mysqli_query($con,"SELECT `data_no`,`int_name`,`data_mac`,`data_humidity`,`data_temp`,`int_temp`,`data_time`, `data_flag` FROM ( SELECT * FROM `iot_data` ORDER BY `data_time` DESC ) AS t1 INNER JOIN iot_inventory ON `data_mac` = `int_mac` WHERE `data_temp` > `int_temp` AND `data_flag` = '1' GROUP BY `data_mac`");
      return $result;
    }


    public function selectInventory($con){
      $result = mysqli_query($con,"SELECT `int_mac`, `int_name`, `int_temp` FROM `iot_inventory` WHERE 1");
      return $result;
    }

    public function insertIntventory($mac,$con){
      $result = mysqli_query($con,"INSERT INTO iot_inventory (`int_mac`)
      SELECT * FROM (SELECT '$mac') AS tmp
      WHERE NOT EXISTS (
        SELECT `int_mac` FROM iot_inventory WHERE `int_mac` = '$mac'
      )       LIMIT 1;");
    }

    public function updateInventory($name,$mac,$temp,$con){
      $result = mysqli_query($con,"UPDATE `iot_inventory` SET `int_name` = '$name' ,`int_temp` = '$temp' WHERE `int_mac` = '$mac' ");
      //return $result;
    }
    /**
     * Check user is existed or not
     */
    public function isUserExisted($email,$con) {
        $result = mysqli_query($con,"SELECT email from gcm_users WHERE email = '$email'");
        $no_of_rows = mysqli_num_rows($result);
        if ($no_of_rows > 0) {
            // user existed
            return true;
        } else {
            // user not existed
            return false;
        }
    }

}

?>
