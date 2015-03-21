<?php include('../Includes/config.php'); ?>
<?php require('password.php'); ?>
<?php require('../Includes/frontcontroller.php'); ?>

<?php
//data sterilization
$FirstName = mysqli_real_escape_string($conn, $_POST["FirstName"]);
$LastName = mysqli_real_escape_string($conn, $_POST["LastName"]);
$UserName = mysqli_real_escape_string($conn, $_POST["UserName"]);
$Address = mysqli_real_escape_string($conn, $_POST["Address"]);
$Email = mysqli_real_escape_string($conn, $_POST["Email"]);
$ReEmail = mysqli_real_escape_string($conn, $_POST["ReEmail"]);
$Birthday = mysqli_real_escape_string($conn, $_POST["Birthday"]);
$Password = mysqli_real_escape_string($conn, $_POST["Password"]);
$RePassword = mysqli_real_escape_string($conn, $_POST["RePassword"]);
$Phone = mysqli_real_escape_string($conn, $_POST["Phone"]);
$Method = mysqli_real_escape_string($conn, $_POST["Method"]);
$hash = password_hash($password, PASSWORD_BCRYPT);
$key = $UserName . $Email . date('mY');
$key = md5($key);
//check if any form fields empty
if (empty($FirstName) || empty($LastName) || empty($UserName) || empty($Address) || empty($Email) || empty($ReEmail) || empty($Birthday) || empty($Password) || empty($RePassword) || empty($Phone) || empty($Method)) {
    echo "You did not fill out the required fields.";
    die(); // Note this
}
//is valid email
if (valid_email($Email) != true || valid_email($ReEmail) !=true) {
    echo("Invalid email format");
    die();
}
//emails both match each other
if ($Email !== $ReEmail) {
    echo("Your emails Do not match!");
    die();
}
//passwords both match each other
if ($Password !== $RePassword) {
    echo("Your passwords do not match!");
    die();
}
//password checked that it meets requirements
if (valid_pass($Password) !== true) {
    echo("Your password does not meet the requirements!");
    die();
}
//check if user already exists
$check="SELECT * FROM user WHERE UserName = '$UserName'";
$sql = mysqli_query($conn,$check);
$data = mysqli_fetch_array($sql, MYSQLI_NUM);
if($data[0] > 1) {
    echo "User Already in Exists<br/>";
    die();
}

//if not killed at this point new user is entered into database
$sql = "INSERT INTO user (FirstName, LastName, UserName, Address, Email, Birthday, Password, Phone1,Method)
VALUES ('$FirstName', '$LastName', '$UserName', '$Address', '$Email', '$Birthday', '$hash', '$Phone', '$Method')";

//send the start of a confirmation email
//commented out in order to have working before pushed live
//$TheUser = "$Email";
//$UserSubject = "Thank You";
//$UserHeaders = "From: admin@swap.com\n";

//$UserMessage = "Thank you for joining our site.";



//mail($TheUser,$UserSubject,$UserMessage,$UserHeaders);

//send data to database
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}










?>


