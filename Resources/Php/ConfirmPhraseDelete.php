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
	<title>Confirm Phrase Deletion</title>
</head>
<body>
<?php
$Entry = $_REQUEST['entry'];
$Line = $_REQUEST['line'];
echo 'Are you sure you want to delete the entry <br>"<i>'.$Entry.'</i>" on line '.$Line.'?<br>';
echo '<br><br><form action="DeletePhrase.php"><input type="hidden" name="line" value="'.$Line.'"><input type="hidden" name="entry" value="'.$Entry.'"><input type="submit" value="OK"></form>';
?>
<br>
<a href="EditUnacceptedPhrases.php" class="LinkButton">Cancel</a>
</body>
</html>