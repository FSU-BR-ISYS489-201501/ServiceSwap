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
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		//Connect to the database
		include("../Resources/Includes/config.php");
		//Select the database
		$mydb=mysql_connect_db("isys489c_BR_ServiceSwap")
		
		$startDate = mysql_real_escape_string($_POST['startDate']);
		$endDate = mysql_real_escape_string)$_POST['endDate']);
		$timeStart = mysql_real_escape_string($_POST['timeStart']);
		$timeEnd = mysql_real_escape_string($_POST['timeEnd']);
		$paymentType = mysql_real_escape_string($_POST['paymentType']);
		$additionalDetails = mysql_real_escape_string($_POST['additionalDetails']);
		$currency = mysql_real_escape_string($_POST['currency']);
		$description = mysql_real_escape_string($_POST['description']);
		
		
		$query = "INSERT INTO ServiceNegotiations (ServNegoStartDate, ServNegoEndDate, ServNegoStartTime, ServNegoEndTime, ServNegoPaymentType, ServNegoAdditionalDetails, ServNegoDescription, ServNegoPrice)
				VALUES('$_POST['startDate']', '$_POST['endDate']', '$_POST['timeStart']', '$_POST['timeEnd']', '$_POST['paymentType']', '$_POST['additionalDetails']', '$_POST['description']', '$_POST['currency']')"
		
		echo $query;
	}
	?>
	Date Start : <input type="text" name="startDate" value="<?php if (isset($_POST['startDate'])) echo $_POST['startDate']; ?>" required>
	<BR>
	<BR>Non-Negotiable : <input type="checkbox" name="startDateBox"></BR>
	<BR>
	Date Finish : <input type="text" name="endDate" value="<?php if (isset($_POST['endDate'])) echo $_POST['endDate']; ?>" required>
	<BR>
	<BR>Non-Negotiable : <input type="checkbox" name="endDateBox" value=""></BR>
	<BR>
	From : <select name="timeStart" value="<?php if (isset($_POST['timeStart'])) echo $_POST['timeStart']; ?>" required>
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
	To : <select name="timeEnd" value="<?php if (isset($_POST['timeEnd'])) echo $_POST['timeEnd']; ?>" required>
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
	
Payment Type : <select onchange="myFunction3(value)" name="paymentType" value="<?php if (isset($_POST['paymentType'])) echo $_POST['paymentType']; ?>" required>
<option value="" disabled="" selected="" style="display:none;">Select one--</option>
<option value="1">PayPal</option>
<option value="2">Service</option>
<option value="3">Both</option>
</select>

    <script>
	
		function myFunction3($i) {
		if ($i == 1)
		document.getElementById("demo3").innerHTML = 'Currency : <input type="text" name="currency" value="<?php if (isset($_POST['currency'])) echo $_POST['currency']; ?>" required> </br> Description : <input type="text" name="description" value="<?php if (isset($_POST['description'])) echo $_POST['description']; ?>" >';
		if ($i == 2)
		document.getElementById("demo3").innerHTML = '';
		if ($i == 3)   
		document.getElementById("demo3").innerHTML = 'Currency : <input type="text" name="currency" value="<?php if (isset($_POST['currency'])) echo $_POST['currency']; ?>" required"> </br> Description : <input type="text" name="description" value="<?php if (isset($_POST['description'])) echo $_POST['description']; ?>" >';
		};
		
    </script>
	
<p id="demo3"></p>
	
	Additional Details: <br>
	<textarea name="additionalDetails" rows="5" cols="40" value="<?php if (isset($_POST['additionalDetails'])) echo $_POST['additionalDetails']; ?>" ></textarea>
	<br>
	<br>
	<button type="button" name="close" value="Close" href="">Close</button>
	<input type="submit" name="submit "value="Submit"/>	
</form>
</BODY>
<FOOTER>
	<!---INSERT FOOTER--->
</FOOTER>
</HTML>
