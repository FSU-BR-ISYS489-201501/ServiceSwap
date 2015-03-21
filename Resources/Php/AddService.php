<?php session_start(); ?>

<!DOCTYPE html>

<html>
<?php 
 $page_title = "Add a Service to a Provider Account!";
 // Includes file needs to allow file_uploads = On
 //Add the Header
 //include ('includes/header.html'); ?>
 
<!-- Get the connection to the Database -->
<?php // require ('../mysqli_connect.php');?>

<center>

<?php 

//main 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
if (!empty($_POST['ShortName']) && !empty($_POST['ServiceDescripton']) && !empty($_POST['ServiceCategorys']) 
    && !empty($_POST['TravelDistance']) && !empty($_POST['SuggestedPrice'])) 
{
		//Set the Variables 
		$ShortName = mysqli_real_escape_string($dbc, trim($_POST['ShortName']));
		$ServiceDescripton = $_POST['ServiceDescripton'];
		$ServiceCategorys = mysqli_real_escape_string($dbc, trim($_POST['ServiceCategorys']));
		$TravelDistance = mysqli_real_escape_string($dbc, trim($_POST['TravelDistance']));
		$SuggestedPrice = mysqli_real_escape_string($dbc, trim($_POST['SuggestedPrice']));
		
		//get the server time
		date_default_timezone_set('America/Chicago'); // CDT
		$DateTime = date('d/m/Y == H:i:s');
		
		//just here to remind me that sessions exist and might be userful later
		//$ServiceCategorys = $_SESSION["total"];
		
		//insert into the database
	    $InsertInto = "INSERT INTO clients (Fname, Lname, Street, City, State, Zipcode, Phone, card) 
		VALUES ('$ShortName', '$ServiceDescripton', '$ServiceCategorys', '$TravelDistance','$SuggestedPrice', '$DateTime')";		
		$RunInsertInto = @mysqli_query ($dbc, $InsertInto); // Run the query.
		
		if ($RunInsertInto) 
		{ // If it ran OK.
			// Print a message:
			echo '<h1>Thank you</h1>
		    <p>Your Service is now placed!</p><p><br /></p>';
			
		//clears the query
		$InsertInto = "";		
        $RunInsertInto = @mysqli_query ($dbc, $InsertInto); // Run the query.
		
		} 
		else
		{ // If it did not run OK.
			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">Your service could not be placed due to a system error. We apologize for any inconvenience.</p>';
		}
		
}		
else 
{ // Invalid submitted values.
	//the main error string
    $ErrorString = "You have not filled out the fields for";
	
	//runs through if else's to concat the string
	if(empty($_POST['ShortName']))
		{ $ErrorString = $ErrorString ."naming your service, ";}
	
	else if(empty($_POST['ServiceDescripton'])) 
		{$ErrorString = $ErrorString."entering a service description, ";}
	
	else if(empty($_POST['ServiceCategorys'])) 
		{$ErrorString = $ErrorString."selecting a service category, ";}
	
	else if(empty($_POST['TravelDistance']))	
		{$ErrorString = $ErrorString."selecting your travel distance, ";}
	
	else if(empty($_POST['SuggestedPrice']))
		{$ErrorString = $ErrorString."naming your suggested price, ";}
	
	//adding the ending
	$ErrorString = $ErrorString."these are required to post the service";
	
	//Actually show the errors
	echo '<h1>Error!</h1>
	<p class="error">$ErrorString</p>';
	
}	
 // End of main
}
?> 

<!-- Leave the PHP section and create the HTML form -->
</center>
	<form action = "AddService.php" method = "POST" enctype = "multipart/form-data">
		<h2><legend>Add a Service to your account:</legend></h2>
			<fieldset>
			
			    <!-- Text Box for ShortName -->
				<p>
					<label>Name your service:</label><br>
					<input type = "text" name = "ShortName" value ="<?php if(isset($_POST['ShortName'])) echo $_POST['ShortName']?>"/>
				</p>
				
				<!-- Description Textarea Box -->
				<p>
					<label>Enter a description of your service:</label><br>
					<textarea name = "ServiceDescripton" rows = '7' cols = '75'/> </textarea>
				</p>
				
				<!-- PHP for Select Box to categorize the Service listing-->
				
				<?php
					// Will need to call in a file to get the listings
					//for what listing categorizes are recognized  
					$ServiceArray = array(
					'Carpentry','Child Care','Cleaning','Computer',
					'Computer Repair','Cooking','Craft','Decorating',
					'Driving','Furniture Refinishing','Garden Work','Handy Man',
					'House Repairs','Mechanical','Painting','Photography',
					'Scrap Booking','Sewing','Shopping','Tree Trimming',
					'Tutoring','Yard Work');

				//create the state select menu
				echo '<select name = "ServiceCategorys">';
					foreach($ServiceArray as $value)
					{
						echo"<option value =\"$value\"> $value </option> \n";
					}
				echo '</select>';
				?>
					
				<!-- TravelDistance Number Box -->
				<p>
					<label>Enter the number of miles your are willing to travel:</label><br>
					<input type="number" name="TravelDistance" min = "0" max = "24,000">
				</p>
				
				<!-- SuggestedPrice Number Box -->
				<p>
					 <label>Enter your suggested price for your service: </label><br>
					$<input type="number" name="SuggestedPrice" min = ".01" step="0.01" max = "100,000,000">
				</p>
				
				<!-- Images to upload  -->
				<p>
					Select image to upload:
					<input type = "file" name = "FileToUpload[]" id = "FileToUpload">
					<input type = "button" id = " add_more " value = "Add More Files"/>
				</p>
							
	     <!-- Submit button -->
		<p>
			<button type = "submit" name = "submit" value = "Submit"/>
			Submit
			</button>
		</p>			
</fieldset>
</form>
<br>	
<?php include ('includes/footer.html');?>	
</html>