<!-- PhraseAJax.php 
Author: Brian Caughell
Date: March 2015
Description: A file holding functions to be called on via AJAX from EditUnacceptablePhrases.php 
Dependencies: EditUnacceptablePhrases.php
					Config.php
To Do: 	Is there a minimum phrase length?
			Connect to live database with new config file	
			Read session data for Employee ID
			Pass Employee ID to new entries and edits
			Depending on how the config file is coded, all references to $conn may need to be changed
-->
<?php
#BC- Check what type the incoming 
if (isset($_POST['action'])){
	switch ($_POST['action']){
		case "editphrase":
			editphrase();
			break;
		case "newphrase":
			newphrase();
			break;
		case "deletephrase":
			deletephrase();
			break;
		default:
			break;
	}
}
#BC - Function to handle incoming phrase edits
function editphrase(){
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
		$CheckDuplicates = mysqli_query($conn, "SELECT  COUNT(InapprPhrase) as total FROM InappropriateContent WHERE InapprPhrase='".$NewEntry."'") or die("Connection error: ".mysqli_connect_errno());  #BC- Count the number of times the new phrase appears in the table
		$DuplicateCount = mysqli_fetch_row($CheckDuplicates); #BC- Set the query results as an array
		# BC - If the returned count is greater than zero, the entry already exists
		if ($DuplicateCount[0] > 0){
			echo 'Error: Duplicate value entered.';
		}
		# BC - Update the phrase in the database and return a confirmation
		else{
			$UpdatePhrase = mysqli_query($conn, "UPDATE InappropriateContent SET InapprPhrase = '".$NewEntry."' WHERE InapprContID ='".$Line."'") or die ("Connection error: ".mysqli_connect_errno());
			echo 'The entry: <br>"<i>'.$Entry.'</i>"<br>changed to:<br><i>"'.$NewEntry.'"</i>';	
		}
	}
	exit;
}
# BC - Function to handle incoming new phrases
function newphrase(){
	include '../Includes/config.php';
	$NewEntry = trim(strtolower(preg_replace('/\s\s+/',' ', str_replace("\n"," ",$_POST['newentry'])))); # BC- read the submitted new entry - remove extra spaces and convert to lower case
	# BC - check that the phrase falls within the allowed length
	if (strlen($NewEntry) == 0 || strlen($NewEntry) > 20)
	{
		echo 'Invalid entry length.<br>Entry must be 1-20 characters long.';
	}
	else {
		$CheckDuplicates = mysqli_query($conn, "SELECT  COUNT(InapprPhrase) as total FROM InappropriateContent WHERE InapprPhrase='".$NewEntry."'") or die("Connection error: ".mysqli_connect_errno());  #BC- Count the number of times the new phrase appears in the table
		$DuplicateCount = mysqli_fetch_row($CheckDuplicates); #BC- Set the query results as an array
		# BC - If the returned count is greater than zero, the entry already exists
		if ($DuplicateCount[0] > 0){
			echo 'The entry:<br>"<i>'.$NewEntry.'</i>"<br>already exists in the database.';
		}
		# BC - If all is good, add the phrase to the database. 
		else{
			$AddPhrase = mysqli_query($conn, "INSERT INTO `inappropriatecontent`(`EmployeeID`, `InapprPhrase`) VALUES ('1','".$NewEntry."')") or die("Connection error: ".mysqli_connect_errno()); 
			echo 'The entry:<br>"<i>'.$NewEntry.'</i>"<br>added to the database.';
		}
	}
	exit;
}
# BC- Function to handle incoming phrase deletes
function deletephrase(){
	include '../Includes/config.php';
	$Entry = trim(strtolower($_POST['entry'])); # BC- Read the incoming phrase
	$Line = $_POST['line'];  # BC- Read the incoming line number / ID
	$DeletePhrase = mysqli_query($conn, "DELETE FROM InappropriateContent WHERE InapprContID='".$Line."' && InapprPhrase = '".$Entry."'") or die("Connection error: ".mysqli_connect_errno()); # BC- Delete the phrase from the database
	echo 'The entry: <br>"<i>'.$Entry.'</i>"<br> deleted.'; #BC- Display deletion confirmation
	exit;
}
mysqli_close($conn);
?>