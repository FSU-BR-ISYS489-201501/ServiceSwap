<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--Travis Awrey-->
<!-- http://www.webreference.com/programming/php/search/3.html-->
<!-- using pieces of the search function code made by Jordan.-->
<html>
<head>
<style>
    #nav {
    line-height:20px;
    background-color:#eeeeee;
    height:1000px;
    float:left;
    padding:5px;
    }

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Search Bar Function</title>

</style>
</head>
<body>

		<form method="POST" action="Untitled1.php?go" id="searchbar">
			<label for="keyword"> Keyword </label>
			<input type="text" name="Search" size="50" maxlength="150">


            <label for="zipcode"> Zipcode: </label>
			<input type="text" name="Search" size="5" maxlength="5">
            <select name="Catagory">
                <option value="Catagory">Catagory.</option>
            <input type="submit" name="Submit" value="Search"><br>

            <input type="checkbox" name="check_list[]" value="value 1">
            <label for="check_list[]"> Most Recent </label>

            <input type="checkbox" name="check_list[]" value="value 2">
            <label for="check_list[]"> Top Rated Provider </label>

            <input type="checkbox" name="check_list[]" value="value 3">
            <label for="check_list[]"> Price (Low to High) </label>

            <input type="checkbox" name="check_list[]" value="value 4">
            <label for="check_list[]"> Price (High to Low) </label>

            <input type="checkbox" name="check_list[]" value="value 5">
            <label for="check_list[]"> Requested Services </label><br>

		</form>


	</body>

<?php
//Gives error message if they don't enter anything into the search bar
	if(isset($_POST['Submit'])) {
	if(isset($_GET['go'])){
// SQL Injection - Makes sure only letters are entered into the search
	// if(preg_match("^/[A-Za-z]+/",$_POST['Search'])){
		//Name of form field we are checking against
		$Search=$_POST['Search'];
//Connects to the database
	include('config.php');

//Select the database table
	$Sql="SELECT * FROM OfferedServices WHERE OffServTitle LIKE'%".$searchbar."%' OR OffServDescription LIKE '%".$Search."%'" ;
//Run the Query against the mysql query function
//Query is stored in result variable

	$Result=mysqli_query($conn,$Sql);

//Create while loop through result set
	while($row=mysqli_fetch_array($Result)){
		$ServiceName =$row['OffServTitle'];
		$ServiceDescription = $row['OffServDescription'];
        $Price=$row['OffServPrice'];
        $Service_Distance=$row['OffServDistance'];
        $Service_ID=$row['OffServID'];

    if ($row> 0) {
    // output data of each row
    while($row = $Result->fetch_assoc()) {
        echo "<html><br></html>";
        echo $row["OffServTitle"]. " - Price: " . $row["OffServPrice"]. " " . $row["OffServDescription"]. "<br>";
    }
}
    else {
    echo "There were no results, would you like to post one?";
   }

}
}
}
?>
</html>