<?php
session_start();

// remove all session variables created when logging into the website
unset($_SESSION['email']);
unset($_SESSION['fname']);
unset($_SESSION['lname']);

// Destroy the session created during login
session_destroy();

// Check to see if the session still exists
if(isset($_SESSION['email'])){
	header("location: message.php?msg=Error:_Logout_Failed");
if(isset($_SESSION['fname'])){
	header("location: message.php?msg=Error:_Logout_Failed");
if(isset($_SESSION['lname'])){
	header("location: message.php?msg=Error:_Logout_Failed");
}

// if the session and all variables were destroyed, redirect the user to the index page
else {
	header("location: index.php");
	exit();
}	 
?>