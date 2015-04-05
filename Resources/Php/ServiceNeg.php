<!DOCTYPE HTML>
<HTML>
<HEADER>
	<!---INSERT HEADER--->
</HEADER>
<HEAD>
	<H2>Service Negotiation</H2>
</HEAD>
<BODY>

	<?php
	//Connect to the database
		include("../Resources/Includes/config.php");
	//Select the database
		$mydb=mysql_connect_db("isys489c_BR_ServiceSwap");
	?>

<form name="myForm" method="Post">

	Date Start : <input type="text" name="startDate" value="">
	<BR>
	<BR>Non-Negotiable : <input type="checkbox" name="startDateBox" value=""></BR>
	<BR>
	Date Finish : <input type="text" name="endDate" value="">
	<BR>
	<BR>Non-Negotiable : <input type="checkbox" name="endDateBox" value=""></BR>
	<BR>
	From : <select name="timeStart" required>
		<option value="1">1:00</option>
		<option value="2">2:00</option>
		<option value="3">3:00</option>
		<option value="4">4:00</option>
		<option value="5">5:00</option>
		<option value="6">6:00</option>
		<option value="7">7:00</option>
		<option value="8">8:00</option>
		<option value="9">9:00</option>
		<option value="10">10:00</option>
		<option value="11">11:00</option>
		<option value="12">12:00</option>
	</select>
	To : <select name="timeEnd" required>
		<option value="1">1:00</option>
		<option value="2">2:00</option>
		<option value="3">3:00</option>
		<option value="4">4:00</option>
		<option value="5">5:00</option>
		<option value="6">6:00</option>
		<option value="7">7:00</option>
		<option value="8">8:00</option>
		<option value="9">9:00</option>
		<option value="10">10:00</option>
		<option value="11">11:00</option>
		<option value="12">12:00</option>
	</select>
	
	AM : <input type="radio" name="timeAM" value="AM">
	PM : <input type="radio" name="timePM" value="PM">
	
	<BR>
	<BR>Non-Negotiable : <input type="checkbox" name="timeBox" value=""></BR>
	<BR>
	
	<!-- starts the select statement. onchange="myFunction3(value) tells it to run myFunction3 when ever an option is selected and makes it pass the value to the javascript -->
Payment Type : <select onchange="myFunction3(value)" required>
<!--  This sets up the options and assigns them each a unique value so we can later check which one was selected and respond accordingly in the javascript -->
<option value="" disabled="" selected="" style="display:none;">Select one--</option>
<option value="1">PayPal</option>
<option value="2">Service</option>
<option value="3">Both</option>
</select>
<!-- form is here just so that you could go back at a later point and actually make the inputs function -->
<form>
    <script>
<!-- tells it that this is the function that we called in the select it also tells it to take the value which it is being passed and assign it to the variable $i -->
    function myFunction3($i) {
<!-- these check to see what option was selected and then respond accordingly by seeing if the variiable $i matches a specific number -->
    if ($i == 1)
<!--- this makes it so that if this option was selected it outputs to whatever is marked with the "demo3" ID. Whatever is inside the quotes after the = sign is what will be output there in this case the 2 input boxes -->
    document.getElementById("demo3").innerHTML = 'Currency : <input type="text" name="input1"> </br> Description : <input type="text" name="input2">';
    if ($i == 2)
<!-- this makes it so that if option 2 is selected there wont be any input boxes. this is important because if they select one of the other options then this one it makes the boxes the other options place there dissappear -->    
    document.getElementById("demo3").innerHTML = '';
    if ($i == 3)
<!-- does that same thing as the first option -->    
    document.getElementById("demo3").innerHTML = 'Currency : <input type="text" name="input1"> </br> Description : <input type="text" name="input2">';
    };
    </script>
</form>
<!-- names a p tag with the ID "demo3" so that when the javascript tries to output to that ID it has somewhere to put its output you could also make this just as easily a Div -->
<p id="demo3"></p>
	
	Additional Details: <br>
	<textarea name="comments" rows="5" cols="40"></textarea>
	<br>
	<br>
	<button type="button" value="Close" href="">Close</button>
	<input type="submit" value="Submit" onclick="return confirm('Your negotiation has been sent')" />
	
	<?php
	
	//Define variables and set to empty values
	$startDateErr = "";
	$stateDate = "";
	$endDateErr = "";
	$endDate = "";
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($POST["startDate"])) {
			$startDateErr = "Start date is required";
		}else {
			$startDate = ($_POST["startDate"])
	}
	
	}
	
	?>
	
</form>
</BODY>
<FOOTER>
	<!---INSERT FOOTER--->
</FOOTER>
</HTML>
