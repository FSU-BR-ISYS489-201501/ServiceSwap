<!-- PhraseAJax.php 
Author: Brian Caughell
Date: March 2015
Description: A file holding functions to be called on via AJAX from EditUnacceptablePhrases.php 
Dependencies: EditUnacceptablePhrases.php
					Config.php
-->
<?php
include '../Includes/config.php';
#BC- Check what type the incoming 

if (isset($_POST['action'])){
	switch ($_POST['action']){
		case "toggleactive":
			toggleactive($conn);
			break;
		case "newservice":
			newservice($conn);
			break;
		default:
			break;
	}
}

function toggleactive($conn){
	$Status = $_POST['activestatus'];
	$Entry = $_POST['servid'];
	$StatusStr = "";
	if($Status == 0){
		$Status = 1;
		$StatusStr = "activated.";
	}
	else{
		$Status = 0;
		$StatusStr = "deactivated.";
	}
	$UpdateStatus = $conn -> prepare("UPDATE OfferedServices SET ServActive = ? WHERE OffServID=$Entry") ;#BC - Create a prepared statement
	$UpdateStatus->bind_param("i",$Status);#BC- Set the parameters for the prepared statement
	$UpdateStatus->execute(); #BC- Update the phrase
	$UpdateStatus->close(); #BC- Close the statement
	echo "Service ".$StatusStr;
	exit;
}

function newservice($conn){
	$Title = trim(preg_replace('/\s\s+/',' ', str_replace("\n"," ",$_POST['newtitle'])));
	$CategoryID = (int)$_POST['category'];
	$Description = trim(preg_replace('/\s\s+/',' ', str_replace("\n"," ",$_POST['newdescription'])));
	$Price = trim(preg_replace('/\s\s+/',' ', str_replace("\n"," ",$_POST['newprice'])));
	$Distance = (int)$_POST['newdistance'];
	$Units = (int)$_POST['newunits'];
	$Exchange = (int)$_POST['newexchange'];
	$Equipment = (int)$_POST['newequipment'];
	$ID = 1;
	if (strlen($Title) > 0 && strlen($Title<=20) && $CategoryID>0 && strlen($Description) > 0 && !is_null($Price) && !is_null($Distance) && !is_null($Units) && !is_null($Price) && !is_null($Exchange) && !is_null($Equipment)){
		include '../Includes/config.php';
		$AddService = $conn->prepare("INSERT INTO OfferedServices (`UserID`, `ServCategoryID`, `OffServTitle`, `OffServDescription`, `OffServPrice`, `OffServDistance`,`OffServDistanceUnits`, `AcceptServExchange`, `ServEquipment`, `ServActive`) VALUES (?,?,?,?,?,?,?,?,?,?)") ; #BC - Create a prepared statement
		$AddService->bind_param("iisssiiiii", $ID, $CategoryID, $Title, $Description, $Price, $Distance, $Units, $Exchange, $Equipment, $ID); #BC- Set the parameters for the prepared statement
		$AddService->execute(); # BC - Add the service
		$AddService->close(); # BC- Close the statement
		$data = "Added to database.";
		return $data;
		exit;
	}
	else{
		echo "Error.";

	}
	
}


#BC - Function to handle incoming phrase edits
function editphrase($conn){
	include '../Includes/config.php';
	$Entry = trim(strtolower($_POST['entry'])); # BC - read the old entry to compare
	$Line = $_POST['line']; # BC- read the line number - this corresponds to the id in the database
	$NewEntry = trim(strtolower(preg_replace('/\s\s+/',' ', str_replace("\n"," ",$_POST['newentry'])))); # BC- read the submitted new entry - remove extra spaces and convert to lower case
	if (strcmp($Entry,$NewEntry)== 0)
	{
		echo 'No changes made.';
	}
	elseif (strlen($NewEntry) == 0 || strlen($NewEntry) > 20)
	{
		echo 'Invalid entry length.<br>Entry must be 1-20 characters long.';
	}
	else
	{
		$DuplicateCount = checkduplicates($conn, $NewEntry);
		# BC - If the returned count is greater than zero, the entry already exists
		if ($DuplicateCount > 0){
			echo 'Error: Duplicate value entered.';
		}
		# BC - Update the phrase in the database and return a confirmation
		else{
			$UpdatePhrase = $conn -> prepare("UPDATE InappropriateContent SET InapprPhrase = ? WHERE InapprContID='".$Line."'") ;#BC - Create a prepared statement
			$UpdatePhrase->bind_param("s",$NewEntry);#BC- Set the parameters for the prepared statement
			$UpdatePhrase->execute(); #BC- Update the phrase
			$UpdatePhrase->close(); #BC- Close the statement
			/*
			$UpdatePhrase = mysqli_query($conn, "UPDATE InappropriateContent SET InapprPhrase = '".$NewEntry."' WHERE InapprContID ='".$Line."'") or die ("Connection error: ".mysqli_connect_errno());*/
			echo 'The entry: <br>"<i>'.$Entry.'</i>"<br>changed to:<br><i>"'.$NewEntry.'"</i>';	
		}
	}
	exit;
}
# BC - Function to handle incoming new phrases
function newphrase($conn){
	include '../Includes/config.php';
	$NewEntry = trim(strtolower(preg_replace('/\s\s+/',' ', str_replace("\n"," ",$_POST['newentry'])))); # BC- read the submitted new entry - remove extra spaces and convert to lower case
	# BC - check that the phrase falls within the allowed length
	if (strlen($NewEntry) == 0 || strlen($NewEntry) > 20)
	{
		echo 'Invalid entry length.<br>Entry must be 1-20 characters long.';
	}
	else {
		$DuplicateCount = checkduplicates($conn, $NewEntry);
		if ($DuplicateCount > 0){
			echo 'The entry:<br>"<i>'.$NewEntry.'</i>"<br>already exists in the database.';
		}
		# BC - If all is good, add the phrase to the database. 
		else{
			$AddPhrase = $conn ->prepare("INSERT INTO InappropriateContent (`EmployeeID`, `InapprPhrase`) VALUES (?,?)") ; #BC - Create a prepared statement
			$EmployeeID = 1;
			$AddPhrase->bind_param("is", $EmployeeID, $NewEntry); #BC- Set the parameters for the prepared statement
			$AddPhrase->execute(); # BC - Add the phrase
			$AddPhrase->close(); # BC- Close the statement
			#$AddPhrase = mysqli_query($conn, "INSERT INTO `inappropriatecontent`(`EmployeeID`, `InapprPhrase`) VALUES ('1','".$NewEntry."')") or die("Connection error: ".mysqli_connect_errno()); 
			echo 'The entry:<br>"<i>'.$NewEntry.'</i>"<br>added to the database.';
		}
	}
	exit;
}
# BC- Function to handle incoming phrase deletes
function deletephrase($conn){
	include '../Includes/config.php';
	$Entry = $_POST['entry']; # BC- Read the incoming phrase
	$Line = $_POST['line'];  # BC- Read the incoming line number / ID
	$DeletePhrase = $conn -> prepare("DELETE FROM InappropriateContent WHERE InapprContID =? AND InapprPhrase=?") ; #BC - Create a prepared statement
	$DeletePhrase->bind_param("is",$Line, $Entry); #BC- Set the parameters for the prepared statement
	$Result = $DeletePhrase->execute();# BC- Delete the phrase from the database
	$DeletePhrase->close();
	echo 'The entry: <br>"<i>'.$Entry.'</i>"<br> deleted.'; #BC- Display deletion confirmation
	exit;
}
mysqli_close($conn);
?>