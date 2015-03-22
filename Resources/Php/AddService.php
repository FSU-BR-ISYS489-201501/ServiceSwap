<?php session_start(); ?>

<!DOCTYPE html>

<html>
<?php 
 $page_title = "Add a Service to a Provider Account!";
 // Includes file needs to allow file_uploads = On
 //Add the Header
//include ('Resources/header.html');
//include("Resources/file_with_errors.php"); 
//include("Resources/Functions.php");
//include("Resources/LoggedFooter.php");
//include("Resources/NavBarLogged.php");
//include("Resources/UnacceptedPhrases.php");

//include("Resources/config.php");
//include("Resources/frontcontroller.php");
?>
 
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
	    $InsertInto = "INSERT INTO clients (OffServTitle, OffServDescription , ServCategory, , , , , ) 
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
		
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Creidt to: http://techstream.org/Web-Development/PHP/Multiple-File-Upload-with-PHP-and-MySQL
//by Anush on Tech Steam
if(isset($_FILES['files'])){
    $errors= array();
	foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
		$file_name = $key.$_FILES['files']['name'][$key];
		$file_size =$_FILES['files']['size'][$key];
		$file_tmp =$_FILES['files']['tmp_name'][$key];
		$file_type=$_FILES['files']['type'][$key];
		
        if($file_size > 640000)
		{
			$errors[]='File size must be less under 800 x 800 pixels';
        }		
        
		$query="INSERT into OfferedServiceImages (`OffServImage`); ";
        $desired_dir="user_data";
		
        if(empty($errors)==true)
		{
            if(is_dir($desired_dir)==false)
			{
                mkdir("$desired_dir", 0700);		// Create directory if it does not exist
            }
            if(is_dir("$desired_dir/".$file_name)==false)
			{
                move_uploaded_file($file_tmp,"user_data/".$file_name);
            }
			else
			{									//rename the file if another one exist
                $new_dir="user_data/".$file_name.time();
                 rename($file_tmp,$new_dir) ;				
            }
            mysql_query($query);			
        }
		else
		{
                print_r($errors);
        }
    }

}
///end sources
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	

}		
else 
{ // Invalid submitted values.
	//the main error string

    $ErrorString = "You have not filled out the fields for";
	
	//runs through if else's to concat the string
	if(empty($_POST['ShortName']))
	{ 
		$ErrorString = $ErrorString ."naming your service, ";
	}
	elseif(empty($_POST['ServiceDescripton'])) 
	{
		$ErrorString = $ErrorString."entering a service description, ";
	}
	
	elseif(empty($_POST['ServiceCategorys'])) 
	{
		$ErrorString = $ErrorString."selecting a service category, ";
	}
	
	elseif(empty($_POST['TravelDistance']))	
	{
		$ErrorString = $ErrorString."selecting your travel distance, ";
	}
	
	elseif(empty($_POST['SuggestedPrice']))
	{
		$ErrorString = $ErrorString."naming your suggested price, ";
	}
	
	//adding the ending
	$ErrorString = $ErrorString."these are required to post the service";
	
	//Actually show the errors
	echo '<h1>Error!</h1>
	<p class="error"> echo "$ErrorString"</p>';
	
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
					 <label>Enter your suggested price for your service and your currency: </label><br>
					 <input type="text" name="SuggestedPrice" value ="<?php if(isset($_POST['SuggestedPrice'])) echo $_POST['SuggestedPrice']?>"/>
				</p>
				
				<!-- Images to upload  -->
				<p>
					<label>Select up to 5 images to upload:</label><br>
					<input type= "file" name = 'files[]' multiple = 'true'/>
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
<?php/include("Resources/LoggedFooter.php");?>	
</html>