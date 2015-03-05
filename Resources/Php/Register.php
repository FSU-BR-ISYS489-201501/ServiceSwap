<?php include('../Includes/config.php'); ?>
<?php require('password.php'); ?>
<?php require('../Includes/frontcontroller.php'); ?>

<?php

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

if (empty($FirstName) || empty($LastName) || empty($UserName) || empty($Address) || empty($Email) || empty($ReEmail) || empty($Birthday) || empty($Password) || empty($RePassword) || empty($Phone) || empty($Method)) {
    echo "You did not fill out the required fields.";
    die(); // Note this
}
if (valid_email($Email) != true || valid_email($ReEmail) !=true) {
    echo("Invalid email format");
    die();
}
if ($Email !== $ReEmail) {
    echo("Your emails Do not match!");
    die();
}

if ($Password !== $RePassword) {
    echo("Your passwords do not match!");
    die();
}
if (valid_pass($Password) !== true) {
    echo("Your password does not meet the requirements!");
    die();
}


$sql = "INSERT INTO user (FirstName, LastName, UserName, Address, Email, Birthday, Password, Phone1,Method)
VALUES ('$FirstName', '$LastName', '$UserName', '$Address', '$Email', '$Birthday', '$hash', '$Phone', '$Method')";


if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}










?>


