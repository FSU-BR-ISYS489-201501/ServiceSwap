<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html>
<?php
//Connects to the database
	include("Resources/config.php");
	
//Gives error message if they don't search anything
	if(!isset($_POST['submit']])) {
		echo "<p> Please enter a search query</p>";
	}
//Search Query
	$DatabaseSearch="SELECT * FROM services WHERE OffServTitle LIKE '%".$_POST['search']."%' OR OffServDescription LIKE '%".$_POST['search']."%'";

//Results of Query are placed here
	$QuerySearch=mysql_query($search_sql);

	if(mysql_num_rows($QuerySearch)!=0) {
//Organize results into table
	$i = 0;
	$search_rs=mysql_feth_array($QuerySearch){
		echo $search_rs[$i];
		i++;
	}
	}
?>


	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Search Bar Function</title>
		<script src="https://www.google.com/jsapi" type="text/javascript"></script>
		<script language="Javascript" type="text/javascript">
			function Search(){
				// create a search control
				var searchControl = new google.search.SearchControl(null);
				
			}		
		</script>
	</head>
	<body>
		<form method="post" action="searchresults.php" id="searchbar">
			<label for="search"> Search </label>
			<input type="text" name="search" size="50" maxlength="150">
			<input type="submit" name="submit" value="Search">
		</form>
	</body>
</html>