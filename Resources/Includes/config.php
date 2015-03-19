<?php
$servername = "mysql.isys489.com";
$username = "isys489c_spscam";
$password = "k5;Tpd#4(c_;";
$dbname = "isys489c_BR_ServiceSwap";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";
?>
