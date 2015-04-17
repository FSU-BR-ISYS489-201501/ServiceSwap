<!DOCTYPE html>
<!-- Disable line 98 when story is linked to other cards -->
<!-- Add a service to a service provider
By: Amber Snow 
5/2/2015
Inserts given fields into the data base for 
service providers to make their "services" active 
and appear on the search function
-->
<html>
<?php 
 $page_title = "Add a Service to a Provider Account!";
 // Includes file needs to allow file_uploads = On
 //Add the Header
//include ('Resources/Includes/header.html');
//include("Resources/Includes/file_with_errors.php"); 
//include("Resources/Includes/Functions.php");
//include("Resources/Includes/LoggedFooter.php");
//include("Resources/Includes/NavBarLogged.php");
//include("Resources/Includes/UnacceptedPhrases.php");

//Get the connection to the Database 
require('../../../config.php');
require('../Includes/frontcontroller.php');
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
    && !empty($_POST['TravelDistance']) && !empty($_POST['SuggestedPrice'])) 

		//Set the Variables 
		$PlaceHolder = mysqli_real_escape_string($conn, trim($_POST['ShortName']));
		$SerName = mysqli_real_escape_string($conn, trim($_POST['ShortName']));
		$ServiceDescripton = $_POST['ServiceDescripton'];
		$ServiceCategorys = $_POST['ServiceCategories'];
		$TravelDistance = mysqli_real_escape_string($conn, trim($_POST['TravelDistance']));
		$SuggestedPrice = mysqli_real_escape_string($conn, trim($_POST['SuggestedPrice']));
		$User = get_current_user_id();
		$Travel = $_POST['Travel'];

		//equipment check box value set
		if(isset($_POST['Equipment']))
		{
			//$Equipment is checked and value = 1
			$Equipment = $_POST['Equipment'];
		}
		else
		{
			//$Equipment is not equal to checked; set value to 0
			$Equipment = 0;
		}
		
		//ServiceExchanges check box value set
		if(isset($_POST['ServiceExchanges']))
		{
			//$ServiceExchanges is checked and value = 1
			$ServiceExchanges = $_POST['ServiceExchanges'];
		}
		else
		{
			//$ServiceExchanges is not equal to checked; set value to 0
			$ServiceExchanges = 0;
		}
		
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
		echo "OffServDistanceUnits: $Travel; Price: $SuggestedPrice ";
		//echo "UserrName: $UserName; UserID: $User: $ID; datetime: $DateTime; Exchanges: $ServiceExchanges, Active: $Active ";
		//echo "Shortname: $PlaceHolder : $SerName, Equip: $Equipment, Description: $ServiceDescripton, Category: $ServiceCategorys, Distance: $TravelDistance, Price: $SuggestedPrice ";
		
		//just here to remind me that sessions exist and might be useful later
		//$ServiceCategorys = $_SESSION["total"];OffServCreation,'$DateTime',
		
	//insert into the database
	    $InsertInto = "INSERT INTO OfferedServices (UserID, AcceptServExchange, ServActive, OffServTitle, OffServDescription , ServCategoryID, OffServDistance, OffServPrice, ServEquipment, OffServDistanceUnits) 
											VALUES ('$ID', '$ServiceExchanges', '$Active', '$SerName', '$ServiceDescripton', '$ServiceCategorys', '$TravelDistance','$SuggestedPrice', '$Equipment', '$Travel')";		
		$RunInsertInto = mysqli_query($conn, $InsertInto); // Run the query	

		$Thankyou = "Your Service is now placed!";
		
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
			<p class="error">Your service could not be placed due to a system error. We apologize for any inconvenience.</p>';
			echo "Error: " . $sql . "<br>" . $conn->error;
		} 
		
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Credit to: http://techstream.org/Web-Development/PHP/Multiple-File-Upload-with-PHP-and-MySQL
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
        
		$query="INSERT * into OfferedServiceImages FROM OffServImage`; ";
        $desired_dir = "user_data";
		
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
	
	if(empty($_POST['TravelDistance']))	
	{
		$ErrorString = "$ErrorString". " " . "selecting your travel distance, ";
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
				 
				<!-- Check box for Equipment -->
				<p><label> Check the box if you have equipment:</label><br>
					<input type="checkbox" name="Equipment" value= "1"/>
				</p> 
				
				<!-- Check box for Accepting Exchanges -->
				<p><label> Check the box if you are willing to accept Service Exchanges:</label><br>
					<input type="checkbox" name="ServiceExchanges" value="1"/>
				</p> 
				
				<!-- Description Textarea Box -->
				<p>
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
				<!-- grabs the servive category from the db and lists in in a select box
				this box, refernces the service categroy id -->	
				<label>Select your service type</label><br>
				<select name = "ServiceCategories"><option value = "">-Select Category-</option>
				<?php
				$sql = mysqli_query($conn, "SELECT ServCategoryID,ServCategory FROM ServiceCategories ORDER BY ServCategory"); 
				#echo "<select name = ServiceCategories value=''></option>";
				while($row = mysqli_fetch_array($sql))
				#foreach ($conn->query($sql) as $row)
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
				
				<!-- TravelDistance Radio Box -->
				<!-- Miles VS Kilometers-->
				<p>
					<input type = "radio" name = "Travel" id = "Kilometers" value = "0" <?php if(isset($_POST['Travel']) && ($_POST['Travel'] == '0')) echo 'checked = "checked"';?> /><label for "Kilometers">Kilometers</label>
					<input type = "radio" name = "Travel" id = "Miles" value = "1" checked = "checked" <?php if(isset($_POST['Travel']) && ($_POST['Travel'] == '1')) echo 'checked = "checked"';?> /><label for "Miles">Miles</label>
				</p>
					
				<!-- TravelDistance Number Box -->
				<p>
					<label>Enter the number of miles your are willing to travel:</label><br>
					<input type="number" name="TravelDistance" min = "0" max = "24,000" value = "<?php if(isset($_POST['TravelDistance'])) echo $_POST['TravelDistance']?>"/>
				</p>
				
				<!-- SuggestedPrice Number Box -->
				<p>
					 <label>Enter your suggested price for your service and your currency: </label><br>
					 <input type="text" name="SuggestedPrice" value ="<?php if(isset($_POST['SuggestedPrice'])) echo $_POST['SuggestedPrice']?>"/>
				</p>
				
				<!-- Check box for Accepting Exchanges -->
				<p><label> Check the box if this Service is Active:</label><br>
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