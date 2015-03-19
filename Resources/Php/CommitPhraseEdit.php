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
	<title>Phrase Edited</title>
</head>
<body>
<?php
include '../Includes/Functions.php';
$Entry = trim(strtolower($_REQUEST['entry']));
$Line = $_REQUEST['line']-1; #BC - Offset line number to match array index
$NewEntry = trim(strtolower($_REQUEST['newentry']));
if (strcmp($Entry,$NewEntry)== 0)
{
	echo 'No changes made.';
}
elseif (strlen($NewEntry) == 0)
{
	echo 'No new value submitted.';
}
else
{
	$File = "../Includes/UnacceptedPhrases.txt"; # BC- Set the file path
	$Entries = file($File, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); # BC- load the file into an array
	$Entries = array_map('strtolower', $Entries);
	# BC - Check if the entered value is a duplicate of any existing entries
	if (DuplicateCheck($Entries, $NewEntry) >= 0)
	{
		echo 'Error: Duplicate value entered.';
	}
	else
	{
		unset($Entries[$Line]); # BC - Remove the old entry from array
		array_push($Entries, "$NewEntry"); # BC - Add the new entry value to the array
		asort($Entries); # BC- sort the entries
################ The following will be changed to access database ################
		$FileHandle = fopen($File, 'w'); # BC- create a file handler
		/* BC -This loop adds each entry to the file. There may be a safer/better
		way to do this. Currently the file handler wipes the file and rewrites it */
		foreach ($Entries as $Value) {
			fwrite($FileHandle, "$Value\n");
		};
		fclose($FileHandle); #BC- close the file
################                End DB change block                ################
		echo 'The entry: <br>"<i>'.$Entry.'</i>"<br>changed to:<br><i>"'.$NewEntry.'"</i>';	
	}
}
?>
<br><br>
<a href="EditUnacceptedPhrases.php" class="LinkButton">OK</a>
</body>
</html>