<!DOCTYPE html>
<html>
<!-- EditUnacceptedPhrases.php 
Author: Brian Caughell
Date: March 2015
Description: A quick and dirty page to list, add to, edit, and delete a list of unaccepted phrases. 
Dependencies: Unaccepted Phrases list(currently a text file, this will need to be changed to point to the DB
when it's available. 
			NewUnacceptedPhrase.php
			EditExistingPhrase.php
			CommitEdit.php
			ConfirmDelete.php
			DeletePhrase.php
To Do: 	More thorough error checking (don't allow numbers, possibly check for common words, set a minimum character number)
		Set a character limit for submissions- need the data dictionary for this
		Change from accessing text list to database table
		Combine common actions to functions (Check for duplicates, add phrase, delete phrase)
		Javascript for pop-up windows- this will combine the dependent php files to this one
		Check input data for SQL injection
-->
<head>
<!-- BC- Style for scroll box -->
	<style>
	div.scroll {
		width: 300px;
		height: 300px;
		overflow-y: scroll;
	}
	</style>
<!-- BC- Style for line numbers in table -->
	<style>
	td.ln {
		padding: 5px;
		text-align: right;
	}
	</style>
	<title>Edit Unaccepted Phrases</title>
</head>
<body>
<div class="scroll">
<table>
<?php 
	$File = "../Includes/UnacceptedPhrases.txt"; #BC- Set the file path
	$Entries = file($File); #BC- Read the file entries into an array
	$Entries = array_filter(array_merge(array(0), array_map('strtolower', $Entries))); /*BC- Offset the array by 1 to 
	match the file line numbers, make each entry lowercase for ease of comparison */
	#BC- Read each line of the array into a table
	foreach ($Entries as $Value_Num => $Value) {
		echo "<tr>";
		echo '<td class="ln">'. $Value_Num .'</td>'; #BC- Right align the line numbers, add some padding for readability 
		echo "<td>$Value</td>"; 
		echo '<td><form action="EditExistingPhrase.php"><input type="hidden" name="line" value="'.$Value_Num.'"><input type="hidden" name="entry" value="'.$Value.'"><input type="submit" value="Edit"></form></td>'; #BC- Edit link
		echo '<td><form action="ConfirmPhraseDelete.php"><input type="hidden" name="line" value="'.$Value_Num.'"><input type="hidden" name="entry" value="'.$Value.'"><input type="submit" value="Delete"></form></td>'; #BC- Delete link
		echo "</tr>";
	}
?>
</table>
</div>
<br>
<p>
<!-- BC- Area to input new phrase -->
<form action="NewUnacceptedPhrase.php"> 
New entry: <input type ="text" name="newentry" size="50"> <br> <br>
<input type="submit" value="Submit">
</form>
</p>
</body>
</html>