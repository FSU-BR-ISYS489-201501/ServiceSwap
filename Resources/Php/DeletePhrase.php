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
	<title>Phrase Deleted</title>
</head>
<body>
<?php
include '../Includes/Functions.php';
$Entry = $_REQUEST['entry'];
$File = "../Includes/UnacceptedPhrases.txt"; # BC- Set the file path
$Entries = file($File, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); # BC- load the file into an array - placeholder for DB
$Entries = array_map('strtolower', $Entries); #BC- Set the array entries to lower case
$EntryLine = DuplicateCheck($Entries, $Entry); #BC - set the line of the matching entry
if ($EntryLine >= 0) #BC- Make sure the entry exists
{
	unset($Entries[$EntryLine]); #BC- Remove the specified phrase from the array
	asort($Entries); # BC- Sort the entries
	################ The following will be changed to access database ################
	$FileHandle = fopen($File, 'w'); # BC- create a file handler
	/* BC -This loop adds each entry to the file. There may be a safer/better
	way to do this. Currently the file handler wipes the file and rewrites it */
		foreach ($Entries as $Value) {
				fwrite($FileHandle, "$Value\n");
		};
		fclose($FileHandle); #BC- close the file
	################                End DB change block                ################
		echo 'The entry: <br>"<i>'.$Entry.'</i>"<br> deleted.'; #BC- Display deletion confirmation
		
}
else #BC - In case the entry doesn't exist or is already deleted
{
	echo "Error: Phrase not found.";
}
?>
<br><br>
<a href="EditUnacceptedPhrases.php" class="LinkButton">OK</a> 
</body>
</html>