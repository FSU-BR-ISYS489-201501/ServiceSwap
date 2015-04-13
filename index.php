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
	}
?>

</body>
</html>