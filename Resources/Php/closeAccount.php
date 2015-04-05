<!-- Developer: Javier Orozco -->
<!-- Purpose: The final page before a user will close/deactivate their account that warns the user of what is about to happen and moves
the account information to another table for inactive users -->

<html>
<title>Closing Account</title>
<head>
<!-- INSERT THE HEADER HERE -->
</head>

<body>
<?php
//DATABASE CONNECTION
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Connection credentials
	$servername = "localhost";
	$username = "isys489c_spscam";
	$password = "k5;Tpd#4(c_;";
	$dbname = "isys489c_BR_ServiceSwap";


	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		echo ("The Connection died here");
		echo ('                                   ');
		echo ("Connection failed: " . $conn->connect_error);
	}
	else {
	echo "Connected successfully";
	}
}
// FORM VALIDATION
$validationErr = "";
$Continue = "";
ini_set('short_open_tag', 'on');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST['userReadCheckbox'])) {
		$validationErr = "* Checkbox must be checked to continue";
		$Continue = "closeAccount.php";
		} else {
		$Continue = "accountClosed.php";
		//Change account to inactive
		$sql = "UPDATE User SET Disabled = '1' WHERE UserID = '$user'"; 
		}
}	
// CREDIT FOR FUNCTION GOES TO: https://core.trac.wordpress.org/browser/tags/4.1.1/src/wp-includes/user.php#L0
// FUNCTION TO GET USER ID
function get_current_user_id() {
			if ( ! function_exists( 'wp_get_current_user' ) )
				return 0;
			$user = wp_get_current_user();
			return ( isset( $user->ID ) ? (int) $user->ID : 0 );
		}	
?>

<h4>By deleting your account, the following actions will be performed: </h4>
<ul>
	<li>Any money left on the account will be permanently lost</li>
	<li>You will lose the ability to view the service provider postings in their enirety</li>
	<li>You will no longer be able to post service requests</li>
	<li>Current pending transactions will be lost</li>
	<li>Your account will be set as 'inactive' and you will not be able to log in</li>
	<li>You will no longer be able to post services</li>
	<li>You will no longer be a member of Project Raptor Hawk</li>
</ul>
</p>
<p>
<!-- Beginning of form -->
<form method="post" action="<?=$Continue?>"> 
<!-- Error message that appears if check box is not checked --> <?php echo $validationErr;?>  <br>
<input type="checkbox" name="userReadCheckbox" value="True">I understand and still wish to delete my account<br> 
<a href=""><p><input type="submit" name="deleteAccountButton" value="Submit" /></p>
<?php// echo $Continue?>
</form>
<!-- End of form -->
</p>

</body>

<footer>
<!-- INSERT THE FOOTER HERE -->
<?php // include("/public_html/Resources/Includes/LoggedFooter.php");?>	
<div class="container text-left pull-left">
    <hr />
    <div class="row">
        <div class="col-lg-12">
            <div class="col-md-3">
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="#">About us</a></li>

                </ul>
            </div>
            <div class="col-md-3">
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="#">Help</a></li>

                </ul>
            </div>
            <div class="col-md-3">
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="#">Request Service</a></li>

                </ul>
            </div>
            <div class="col-md-3">
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="#">Post a Service</a></li>

                </ul>
            </div>
        </div>
    </div>


</div>
</footer>