<!DOCTYPE html>
<!-- Disable line 98 when story is linked to other cards
If you are in the process of connecting this card via sessions for checking purposes
I have lines that need to be disabled, (User variable should be coming in on a session)
so please comment out the certain lines or let me know when you need that done
cell: call or txt 989-859-9520 email:snowa6@ferris.edu -->

<!-- Add a Service request to a Consumer account
By: Amber Snow 
5/2/2015
Inserts given fields into the data base for 
service providers to make their "services" active 
and appear on the search function
-->
<html>
<?php 
 $page_title = "Add a Service to a Consumer Account!";
 // Includes file needs to allow file_uploads = On

//Get the connection to the Database 
require('../../../config.php');
require('../Includes/frontcontroller.php');
require('../Includes/NavBarLogged.php');
?>
 
<center>

<?php 
// CREDIT FOR FUNCTION GOES TO: https://core.trac.wordpress.org/browser/tags/4.1.1/src/wp-includes/user.php#L0
// FUNCTION TO GET USER ID
function get_current_user_id() 
{
	if ( ! function_exists( 'wp_get_current_user' ) )
		return 0;
	$user = wp_get_current_user();
	return ( isset( $user->ID ) ? (int) $user->ID : 0 );
}


//main 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
if (!empty($_POST['ShortName']) && !empty($_POST['ServiceDescripton']) && !empty($_POST['ServiceCategorys']) 
    && !empty($_POST['Zip']) && !empty($_POST['SuggestedPrice'])) 

		//Set the Variables 
		$PlaceHolder = mysqli_real_escape_string($conn, trim($_POST['ShortName']));
		$SerName = mysqli_real_escape_string($conn, trim($_POST['ShortName']));
		$ServiceDescripton = $_POST['ServiceDescripton'];
		$ServiceCategorys = $_POST['ServiceCategories'];
		$SuggestedPrice = mysqli_real_escape_string($conn, trim($_POST['SuggestedPrice']));
		$Zip = $_POST['Zip'];
		$Flag = 0;
		
		if(empty($Zip)) 
		{
			$msg = '<span class="error"> Please enter a zip code value</span>';
			Flag = 1;
		} 
		else if(!is_numeric($Zip)) 
		{
			$msg = '<span class="error"> Zip code entered was not numeric</span>';
			Flag = 1;
		} 
		else if(strlen($Zip) != 5) 
		{
			$msg = '<span class="error"> The Zip code entered was not 5 digits long</span>';
			Flag = 1;
		}
				
		$User = get_current_user_id();
		$Travel = $_POST['Travel'];
	
		//Active check box value set
		if(isset($_POST['Active']))
		{
			//$Active is checked and value = 1
			$Active = $_POST['Active'];
		}
		else
		{
			//$Active is not equal to checked; set value to 0
			$Active = 0;
		}
		
		//Credit to Jordan P. Converted by Amber Snow
		//Grabs the userID and stores it in the session?
		$UserName = $_SESSION["username"];
/////	
		//Setting the user to a known ID for testing
//disable line below when everything is linked		
		$UserName = 'jpiepkow';		
//////
		//Sql select query to get the userid
		$Run = mysqli_query($conn, "SELECT UserID FROM User Where ScreenName = '$UserName' LIMIT 1;");
		while($row = mysqli_fetch_array($Run))
		{
			$ID = $row['UserID'];
		}
		
		//get the server time
		date_default_timezone_set('America/Chicago'); // CDT
		$DateTime = date('d/m/Y H:i:s');
		
		//error checking
		//echo "OffServDistanceUnits: $Travel; Price: $SuggestedPrice ";
		//echo "UserrName: $UserName; UserID: $User: $ID; datetime: $DateTime; Exchanges: $ServiceExchanges, Active: $Active ";
		//echo "Shortname: $PlaceHolder : $SerName, Equip: $Equipment, Description: $ServiceDescripton, Category: $ServiceCategorys, Distance: $TravelDistance, Price: $SuggestedPrice ";
		
		//just here to remind me that sessions exist and might be useful later
		//$ServiceCategorys = $_SESSION["total"];
		
	//insert into the database
	if(Flag == 0)
	{
	    $InsertInto = "INSERT INTO OfferedServices (UserID, ReqServCompleted, ReqServTitle, ReqServDescription , ServCategoryID, ReqServPrice, ReqServLocation ) 
											VALUES ('$ID', '$Active', '$SerName', '$ServiceDescripton', '$ServiceCategorys', '$SuggestedPrice', '$Zip')";		
		$RunInsertInto = mysqli_query($conn, $InsertInto); // Run the query	

		$Thankyou = "Your Request for a service has now been placed!";
	}	
		if ($RunInsertInto)
		{ // If it ran OK.
			// Print a message:
		//Pop up  message box 
		echo "<SCRIPT> alert('$Thankyou'); </SCRIPT>";	
		
		//redirect should go here to send them to the provider page
		
		} 
		else
		{ // If it did not run OK.
			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">Your request could not be placed due to a system error. We apologize for any inconvenience.</p>';
			echo "Error: " . $sql . "<br>" . $conn->error;
		} 
		
		//get the serviceID
		$Run = mysqli_query($conn, "SELECT ReqServID FROM RequestedServices Where UserID = '$ID' AND ReqServTitle = '$SerName' AND ServCategoryID = '$ServiceCategorys' LIMIT 1;");
		while($row = mysqli_fetch_array($Run))
		{
			$ReqServID = $row['ReqServID'];
		}
		
		//checking the service ID so it inserts correctly below
		//echo "Service ID: $ReqServID ";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Credit to: http://techstream.org/Web-Development/PHP/Multiple-File-Upload-with-PHP-and-MySQL
//by Anush on Tech Steam
	
if(isset($_FILES['files'])){
    $errors= array();
	
	foreach($_FILES['files']['tmp_name'] as $key => $tmp_name )
	{
		$file_name = $key.$_FILES['files']['name'][$key];
		$file_size =$_FILES['files']['size'][$key];
		$file_tmp =$_FILES['files']['tmp_name'][$key];
		$file_type=$_FILES['files']['type'][$key];
		
		//checks the file size in smaller then 800 by 800
        if($file_size > 640000)
		{
			$errors[]='File size must be less under 800 x 800 pixels';
        }		
        
		//insert into the table?
		$query = "INSERT INTO OfferedServicesImages(OffServID, OffServImage)
				  VALUES ('$OffServID', '$file_name')";
        $desired_dir = "req_data";
		
        if(empty($errors)==true)
		{
            if(is_dir($desired_dir)==false)
			{
                mkdir("$desired_dir", 0700);		// Create directory if it does not exist
            }
            if(is_dir("$desired_dir/".$file_name)==false)
			{
                move_uploaded_file($file_tmp,"req_data/".$file_name);
            }
			else
			{	//rename the file if another one exist
				//modified the time/file name
				$Time = time();
                $new_dir = "req_data/".$file_name.$Time;
                rename($file_tmp,$new_dir);				
            }
			//changed to sqli statement add the connection
            mysqli_query($conn,$query);			
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
		$ErrorString = "$ErrorString " . " " . "naming your service, ";
	}
	if(empty($_POST['ServiceDescripton'])) 
	{
		$ErrorString = "$ErrorString". " " ."entering a service description, ";
	}
	
	if(empty($_POST['ServiceCategorys'])) 
	{
		$ErrorString = "$ErrorString". " " ."selecting a service category, ";
	}
	
	if(empty($_POST['Zip']))	
	{
		$ErrorString = "$ErrorString". " " . "your location zip code, ";
	}
	
	if(empty($_POST['SuggestedPrice']))
	{
		 $ErrorString = "$ErrorString". " " . "naming your suggested price, ";
	}
	
	//adding the ending
	$ErrorString = "$ErrorString". " " . "these are required to post the service";
	
	//Pop up error message box for all the fields they haven't filled out
	echo "<SCRIPT>
	alert('$ErrorString');
	</SCRIPT>";	
}	
 // End of main
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
				<p> <label>Enter the details about your service:</label><br>
					<textarea name = "ServiceDescripton" rows = '7' cols = '75'/> 
					<?php if(isset($_POST['ServiceDescripton'])){echo htmlentities($_POST['ServiceDescripton'], ENT_QUOTES);}?>
					</textarea> 
				</p>

				<!-- PHP for Select Box to categorize the Service listing-->
				<?php
					/*// Will need to call in a file to get the listings
					//for what listing categorizes are recognized  
					$ServiceArray = array(
					'Carpentry','Child Care','Cleaning','Computer',
					'Computer Repair','Cooking','Craft','Decorating',
					'Driving','Furniture Refinishing','Garden Work','Handy Man',
					'House Repairs','Mechanical','Painting','Photography',
					'Scrap Booking','Sewing','Shopping','Tree Trimming',
					'Tutoring','Yard Work');*/
				?>
				
				<!-- Connects: Code Debugged by  Brian Caughell -->				
				<!-- grabs the service category from the db and lists in in a select box
				this box, references the service category id -->	
				<label>Select your service type:</label><br>
				<select name = "ServiceCategories"><option value = "">-Select Category-</option>
				<?php
				$sql = mysqli_query($conn, "SELECT ServCategoryID,ServCategory FROM ServiceCategories ORDER BY ServCategory"); 
				while($row = mysqli_fetch_array($sql))
				{
					echo "<option value= $row[ServCategoryID]> $row[ServCategory] </option>"; 
				}
				
				?>
				</select>
				
				<!-- Old way b4 database to get the array data for service categories	
				create the state select menu; this works...
				echo '<select name = "ServiceCategorys">';
					foreach($ServiceArray as $value)
					{
						echo"<option value =\"$value\"> $value </option> \n";
					}
				echo '</select>'; 
				-->
				
				<!-- TravelDistance Number Box -->
				<p>
					<label>Please enter your 5 digit zip code:</label><br>
					<input type="text" id="Zip" name="Zip" value="<?php echo $Zip?>" size=5 /><?php echo $msg;?>
				</p>
				
				<!-- SuggestedPrice Number Box -->
				<p>
					 <label>Enter your suggested price for your service and your currency: </label><br>
					 <input type="text" name="SuggestedPrice" value ="<?php if(isset($_POST['SuggestedPrice'])) echo $_POST['SuggestedPrice']?>"/>
				</p>
				
				<!-- Check box for Accepting Exchanges -->
				<p><label> Check the box if this Request is Active:</label><br>
					<input type="checkbox" name="Active" value="1"/>
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
<?php require ('../Includes/LoggedFooter.php');?>
</html>