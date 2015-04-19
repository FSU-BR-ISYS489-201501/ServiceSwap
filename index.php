<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="Libraries/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="Resources/Css/sticky-footer-navbar.css">
    <script src='Resources/js/jquery-1.11.2.min.js' type='text/javascript'></script>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="Libraries/bootstrap/js/bootstrap.js"></script>
</head>
<body>
<?php
	if (isset($_SESSION['email'])){
		include ('Resources/Includes/NavBarLogged.php');
	}
	else{
		include ('Resources/Includes/NavBarNotLogged.php');
	}
?>
<div id="wrap">

    </div>

<?php include ('Resources/Includes/NotLoggedFooter.php'); ?>
<?php
	if (isset($_GET['error'])){
		if ($_GET['error'] == 1){
			echo "<script type='text/javascript'>alert('Username/password does not exist.');</script>";
		}
		else if ($_GET['error'] == 2){
			echo "<script type='text/javascript'>alert('Email was not typed in.');</script>";
		}
		else if ($_GET['error'] == 3){
			echo "<script type='text/javascript'>alert('Email was not typed correctly.');</script>";
		}
		else if ($_GET['error'] == 4){
			echo "<script type='text/javascript'>alert('No password was typed in.');</script>";
		}
		else if ($_GET['error'] == 5){
			echo "<script type='text/javascript'>alert('Your account has been disabled due to inappropriate activity. Contact support for any concerns regarding the ban.');</script>";
		}
		else if ($_GET['error'] == 6){
			echo "<script type='text/javascript'>alert('Your account has been disabled due to inactivity. If you require access to this account, contact technical support.');</script>";
		}
		else if ($_GET['error'] == 7){
			echo "<script type='text/javascript'>alert('Your account has been disabled due to being closed by the owner. If you require access to this account, contact technical support.');</script>";
		}
		else if ($_GET['error'] == 8){
			echo "<script type='text/javascript'>alert('This employee account has been disabled. If your account may have been disabled by mistake, contact technical support about this issue.');</script>";
		}
	}
?>

</body>
</html>