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
	<title>Edit Phrase</title>
</head>
<body>
<?php
$Entry = $_REQUEST['entry'];
$Line = $_REQUEST['line'];
echo 'Please edit the entry:<br><i>"'.$Entry.'"</i><br> below.';
echo '<br><br>';
echo '<form action="CommitPhraseEdit.php">';
#BC- Area to edit phrase.
echo '<input type="hidden" name="line" value="'.$Line.'"><input type="hidden" name="entry" value="'.$Entry.'">';
echo 'New entry: <input type ="text" name="newentry" size="50" value="'.$Entry.'">'; #BC- Pass both the old and new values to the CommitEdit page
echo '<br><br>';
echo '<input type="submit" value="Submit">';
?>
<br><br>
<a href="EditUnacceptedPhrases.php" class="LinkButton">Cancel</a>
</body>
</html>