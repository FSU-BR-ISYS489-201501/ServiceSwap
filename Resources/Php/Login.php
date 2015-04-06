
<?php
/*
The purpose of this file is to ensure that the proper data validation 
and security measures are taken before a user is allowed to view the website.

//Zach Adkins and Joe Brown
Variable Definitions:

$pageName: Holds the current page name or file name.
$data:  holds user input during data sanitation process
$connection: holds connection to 
$email: Email address entered by user
$password: Password entered by user


$valid: holds true or false value to determine if the user entered a valid data for the email and password field
$conn: equals to $connection variable. value returned from function
$findUserQuery: query syntax for select statement
$result: holds query results
$pwmatch: holds a true or false value representating if the password the user entered was the same as the database that is in the password.

$_SESSION["email"]: holds users email 
$_SESSION["fname"]: holds users first name
$_SESSION["lname"]: hods users last name
$errorMsg: Holds current error message

$emailErr: Holds email error message
$passErr: Holds pass error message
msqlErrorCode: Holds the error code for the mysql error
msqlErrorStatus: Holds the message for the mysql error
mysqlError: Holds true or false representing if it is a mysql error or not
mysqlErrorType: Holds the type of mysqlError
*/

include('../includes/config.php');
error_reporting(E_ALL);
ini_set('display_errors', '1');
$pageName = basename($_SERVER['PHP_SELF']);
$mysqlError = FALSE;
$mysqlErrorType ='';

//check if login was requested by the server
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	//gets rid of dangerous characters
	function clean($data) 
	{	
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	$valid = TRUE;
	
	//validates all data
	if(empty($_POST["email"])) 
    {
		$emailErr = 'Email is required';
		$valid = FALSE;
	} 
	else 
	{
		$email = clean($_POST["email"]);
	}
	
	if(empty($_POST["pass"])) 
	{
		$passwErr = 'Password is required';
		$valid = FALSE;
	} 
	else 
	{
		$password = clean($_POST["email"]);
	}

	
	if($valid)
	{
		//creates a connection to the database
		$conn = connectToDb();
			
		$email = mysqli_real_escape_string($email);
		$findUserQuery = "SELECT * FROM account WHERE email ='".$email."' LIMIT 1";

		//executes query
		$result = mysqli_query($conn, $findUserQuery);
		if(!$result)
		{
			$msqlErrorCode = $mysqli_errno($conn);
			$msqlErrorStatus = $mysqli_error($conn);
			
			//$mysqlError=TRUE;
			//$mysqlErrorType='Query';
			
			sqlErrors($msqlErrorCode,$msqlErrorStatus,$pageName);
			$errorMsg='Website Issue, administrator has been notified.';
			die();
		}
		
		//checks if user exists
		if(mysqli_num_rows($result)!= 0)
		{
			$row = mysqli_fetch_array($result, MYSQL_ASSOC );
			
			/*stores results from query in the following variables*/
			
			$passwordDB = $row["pwd"];
			$emailDB = $row["email"];
			//$saltDB = $row["salt"];
			//$idDB = $row["acc_id"];
		
			//verifying password, checks if the password is the same as the hashed password in the database
			
			$pwmatch = password_verify($password, $passwordDB);
			
			if($pwmatch)
			{
				//starts session and initiates session variables
				session_start();
			
				$_SESSION["email"] = $row["email"];
				$_SESSION["fname"] = $row["fname"];
				$_SESSION["lname"] = $row["lname"];
			
				header("Location: home.php");
			}
			else 
			{
				$errorMsg = 'Invalid Username Or Password';
			}
		}
		else
		{
			$errorMsg = 'Invalid Username Or Password';
		}
		
		mysqli_close($conn);
	}		
	

}

?>

Displaying Login2.txt.
