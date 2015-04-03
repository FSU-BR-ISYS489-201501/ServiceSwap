<?php

$servername = "mysql.isys489.com";
$username = "isys489c_spscam";
$password = "k5;Tpd#4(c_;";
$dbname = "isys489c_BR_ServiceSwap";

// Create connection
$Connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($Connection->connect_error) {
    die("Connection failed: " . $Connection->connect_error);
}
//echo "Connected successfully";
?>
