<html>
<body>



<?php

// define variable
$Search;

// no validation required as card specified 
   	if (empty($_POST["Search"])) {
     $Search = "";
   } else {
     $Search = test_input($_POST["Search"]);
   }
	
	
function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>

<!--Sample example of saving the variable Inserted into the search bar: -->

<form method="POST" action="<?PHP echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
   
   Name: <input type="text" name="Search">
 <input type=submit>
</form>

<?php 
echo $Search
?>




<!-- Use the pre-existing category drop down so I'm just making a fake one for now -->

<?php
// define variable
$Category;

if (empty($_POST["Category"])) {
     $Category = "option1";
   } else {
     $Category = test_input($_POST["Category"]);
   }
?>

<form method=post>
<SELECT name="Category">
  <option value="option1">Category</option>
  <option value="option2">Mechanics</option>
  <option value="option3">Driving</option>
</select>
<input type=submit>
</form>



<?php
echo $Category;
?>



<?php
// define variables
$Zip;
$ZipError;

//validate zip input

   	

   if (empty($_POST["Zip"])) {
     $ZipError = "A valid zip code must be entered.";
   } else {
     $Zip = test_input($_POST["Zip"]);
     // CHECK if name only contains letters and whitespace
     if(preg_match('/^[0-9]+$/', input)) {
       $ZipError = "Only numbers may be used for Zip"; 
     }
   }

	
function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>

<!-- Inserted into the Zip bar: -->

<form method="POST" action="<?PHP echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
   
   Zip: <input type="text" length="5" name="Zip">
   <span class="error">* <?php echo $ZipError;?></span>
   <input type=submit>
</form>

<?php 
echo $Zip
?>



</body>
</html>

