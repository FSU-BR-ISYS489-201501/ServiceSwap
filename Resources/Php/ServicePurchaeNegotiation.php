<!-- Kevin Ranke -->
<!DOCTYPE HTML>
<html>
<title> Service Purchase Negotiation </title>
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
?>

<head>
<!-- Header here -->
</head>
<body>

<!--  -->
<form action="NegotiationDate" method="post">
	<p>Date: <input type="date" name="date" value=""/>
	<input type="submit" name="Accept" value="Accept" />
	<button type="button" onclick="myFunction1()">Counter Offer</button>
    <script>
    function myFunction1() {
    document.getElementById("date").innerHTML = '<input type="text" name="input1">';}
    </script>
    <p id="date"></p>

	
<form action="NegotiationTime" method="post">
	<p>Time: <input type="time" name="time" value=""/>
	<input type="submit" name="Accept" value="Accept" />
	<button type="button" onclick="myFunction2()">Counter Offer</button>
    <script>
    function myFunction2() {
    document.getElementById("time").innerHTML = '<input type="text" name="input2">';}
    </script>
    <p id="time"></p>
	
	
<form action="NegotiationPayment" method="post">
	Payment <input type="text" name="payment" value="" />
	<input type="submit" name="Accept" value="Accept" />
	<button type="button" onclick="myFunction3()">Counter Offer</button>
    <script>
    function myFunction3() {
    document.getElementById("payment").innerHTML = '<input type="text" name="input3">';}
    </script>
    <p id="payment"></p>
</form>

<input type="submit" name="submit" value="Submit"/>
<a href="History.html"><button>Cancel</button></a>
<button type="button">Reject Negotiation</button>

</body>
<footer>
<!-- Footer goes here -->
</footer>
</html>


