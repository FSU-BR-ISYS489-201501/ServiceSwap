<html>
<header></header>
<body>
<?php
// Declares the forbidden word array then connects to the satabase and populates it with forbidden words from the database
$forbiddenInput = array();
$z = 0;
include "../Includes/config.php";
	$ReturnPhrases = mysqli_query($conn, "SELECT * FROM InappropriateContent ORDER BY InapprPhrase"); #BC- Select all rows from the phrases table
	while ($Row = mysqli_fetch_array($ReturnPhrases)) {
		$forbiddenInput[$z] = $Row['InapprPhrase'];
		$z = $z + 1;
		}
mysqli_close($conn);
echo "</br>";
echo "</br>";
$forbiddenLength = count($forbiddenInput);
// declares the input array
$inputArray = array();
// pulls the input from the post
$input = $_POST["input"]; 
//parses the input using Blank space as the delimiter
$inputArray = explode(" ", $input);
//counts how long the input is
$inputLength = count($inputArray);
//Checks the arrays against each other to look for matches
for ($x = 0; $x < $inputLength; $x++)
{
	for ($y = 0; $y < $forbiddenLength; $y++)
	{
		if ($inputArray[$x] == $forbiddenInput[$y])
		{
			echo "Forbidden word found.";
			echo "</br>";
			echo $forbiddenInput[$y];
			echo "</br>";
			echo "</br>";
		}
	}
}
?>
</form>
</body>
</html>
</html>