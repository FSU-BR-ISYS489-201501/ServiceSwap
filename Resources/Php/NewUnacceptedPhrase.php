<!DOCTYPE html>
<html>
<head>
<style>
	a.LinkButton  {
		font: bold 13px Arial;
		text-decoration: none;
		background-color: #EEEEEE;
		color: #333333;
		padding: 2px 6px 2px 6px;
		border-top: 1px solid #CCCCCC;
		border-right: 1px solid #333333;
		border-bottom: 1px solid #333333;
		border-left: 1px solid #CCCCCC;
	} 
</style>
</head>
<body>
<?php 
$File = "../Includes/UnacceptedPhrases.txt"; # BC- Set the file path
$Entries = file($File, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); # BC- load the file into an array
$Entries = array_map('strtolower', $Entries); # BC- convert the entries to lower case
$NewEntry = trim(strtolower($_REQUEST['newentry'])); # BC- read the submitted new entry
$Duplicate = FALSE;
if (strlen($NewEntry) === 0) #BC- Check if no data was submitted. This should actually happen on the previous page.
{
	echo 'No new value submitted.';
}
else #BC- Otherwise check for duplicate and add to the list
{
	# BC- check if the submitted entry already exists in the list
	for ($i=0; $i < count($Entries); $i++)
		{
			if (trim($Entries[$i]) == $NewEntry){
				$Duplicate = TRUE;
				break;
			}
		}
	#BC- if no duplicate is found, write the list
	if ($Duplicate == FALSE){
		array_push($Entries, "$NewEntry");# BC- add the new entry to the array, 
		asort($Entries); # BC- sort the entries
		$FileHandle = fopen($File, 'w'); # BC- create a file handler
		/* BC -This loop adds each entry to the file. There may be a safer/better
		way to do this. Currently the file handler wipes the file and rewrites it */
		foreach ($Entries as $Value) {
				fwrite($FileHandle, "$Value\n");
		}
		echo 'The entry:<br>"<i>'.$NewEntry.'</i>"<br>added to the database.';
		fclose($FileHandle); #BC- close the file
	}
	#BC- if a duplicate is found, return an error.
	else{
		echo 'The entry:<br>"<i>'.$NewEntry.'</i>"<br>already exists in the database.';
	}
}
?>
<br><br>
<a href="EditUnacceptedPhrases.php" class="LinkButton">OK</a>
</body>
</html>