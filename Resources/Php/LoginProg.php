<?php
/*if error testing, add these lines to the code*/
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

/*check if login was requested by the server*/
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	/*signing into database*/
	$DBHost = '';
	$DBUser = '';
	$DBPass = '';
		
	$Conn = mysqli_connect($DBHost, $DBUser, $DBPass);
	if(! $Conn ){
		die('Could not connect: ' . mysqli_error($Conn));
	};
			
	/*select database*/
	mysqli_select_db($Conn, 'vintpixdb');
	
	/*get inputs and place into variables*/
	$Email = mysqli_real_escape_string($Conn, $_POST["email"]);
	$Password = mysqli_real_escape_string($Conn, $_POST["passw"]);
	
	/*check if the login info was typed in by the user*/
	if (isset($Email) && isset($Password) && trim($Email) != '' && trim($Password) != ''){
		
		/*send query to search database for if user exists*/
		$FindUserQuery = "SELECT * " . "FROM `account` " . "WHERE `email`='" . $Email . "' LIMIT 1";

		$RetVal = mysqli_query($Conn, $FindUserQuery);
		if(! $RetVal ){
			die('Could not get data: ' . mysqli_error($Conn));
		};
		
		/*checks if username exists*/
		if (mysqli_num_rows($RetVal)!==0){
			
			/*retrieve results from query*/
			$Row = mysqli_fetch_array($RetVal, MYSQL_ASSOC );
			
			/*stores information from the user's row in variables*/
			$PasswordDB = mysqli_real_escape_string($Conn, $Row["pwd"]);
			$EmailDB = mysqli_real_escape_string($Conn, $Row["email"]);
			$saltDB = mysqli_real_escape_string($Conn, $Row["salt"]);
			$idDB = mysqli_real_escape_string($Conn, $Row["acc_id"]);
			
			/*verifying password*/
			$PWMatch = password_verify($Password, $PasswordDB);
			
			/*check if the hashed password is the same as the hashed password in the database*/
			if ($PWMatch){
				
				/*start session for user information use throughout website*/
				session_start();
				$_SESSION["email"] = $Row["email"];
				$_SESSION["fname"] = $Row["fname"];
				$_SESSION["lname"] = $Row["lname"];
				header("Location: home.php");
				exit;
			}
			/*redirects to login if password is incorrect; error 1*/
			else {
				header("Location: login.php?error=1");
				exit;
			}
		}
		/*redirects to login if user does not exist; error 2*/
		else{
			header("Location: login.php?error=2");
			exit;
		}
	}
	/*redirects to login if user did not input username or password; error 3*/
	else{
		header("Location: login.php?error=3");
		exit;
	}
}
else{
	header("Location: login.php");
	exit;
}
?>