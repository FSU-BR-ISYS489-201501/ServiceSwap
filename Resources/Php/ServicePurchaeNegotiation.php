<html>
<head>
</head>
<body>

<form action="NegotiationDate" method="post">
	<p>Date: <input type="date" name="date" size="10" maxlength="12" value="<?php if (isset($_POST['date'])) echo $_POST['date']; ?>"/>
	<input type="submit" name="Accept" value="Accept" />
	<button type="button" onclick="myFunction1()">Counter Offer</button>
    <script>
    function myFunction1() {
    document.getElementById("demo1").innerHTML = '<input type="text" name="input1" size="25">';}
    </script>
    <p id="demo1"></p>

	
<form action="NegotiationTime" method="post">
	<p>Time: <input type="time" name="time" size="10" maxlength="12" value="<?php if (isset($_POST['time'])) echo $_POST['time']; ?>"/>
	<input type="submit" name="Accept" value="Accept" />
	<button type="button" onclick="myFunction2()">Counter Offer</button>
    <script>
    function myFunction2() {
    document.getElementById("demo2").innerHTML = '<input type="text" name="input2" size="25">';}
    </script>
    <p id="demo2"></p>
	
	
<form action="NegotiationPayment" method="post">
	<p>Payment <input type="payment" name="payment" size="10" maxlength="12" value="<?php if (isset($_POST['payment'])) echo $_POST['payment']; ?>"/>
	<input type="submit" name="Accept" value="Accept" />
	<button type="button" onclick="myFunction3()">Counter Offer</button>
    <script>
    function myFunction3() {
    document.getElementById("demo3").innerHTML = '<input type="text" name="input3" size="25">';}
    </script>
    <p id="demo3"></p>
</form>
</body>
</html>