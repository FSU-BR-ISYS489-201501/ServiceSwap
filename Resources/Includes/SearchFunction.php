<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html>
<?php
	
//Gives error message if they don't enter anything into the search bar
	if(isset($_POST['submit'])) {
	if(isset($_GET['go'])){
// SQL Injection - Makes sure only letters are entered into the search
	if(preg_match("^/[A-Za-z]+/",$_POST['Search'])){
		//Name of form field we are checking against
		$Search=$_POST['Search']
//Connects to the database
	include("../Resources/Includes/config.php");
//Select the database
	$mydb=mysql_select_db("isys489c_BR_ServiceSwap")
//Select the database table
	$Sql="SELECT * FROM OfferedServices WHERE OffServTitle LIKE'%".$Search."%' OR OffServDescription LIKE '%".$Search."%'" ;
//Run the Query against the mysql query function
//Query is stored in result variable
	$Result=mysql_query($Sql);
//Create while loop through result set
	while($row=mysql_fetch_array($Result)){
		$ServiceName =$row['OffServTitle'];
		$ServiceDescription = $row['OffServDescription'];
		$ID=$row['ID'];
//Display the results of the array
	echo "<ul>\n";
	echo "<li>"."<a href=\"search.php?id=$ID\">" .$ServiceName. " ".$ServiceDescription. "</a></li>\n";
	echo "</ul>";
	}
	}
	else {
		echo "<p> Please enter a search query</p>";
	}
	}
	}
//Attribution to: http://www.webreference.com/programming/php/search/3.html
?>


	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Search Bar Function</title>
	</head>
	<body>
		<form method="post" action="searchresults.php" id="searchbar">
			<label for="search"> Search </label>
			<input type="text" name="Search" size="50" maxlength="150">
			<input type="submit" name="submit" value="Search">
		</form>
	</body>
</html>