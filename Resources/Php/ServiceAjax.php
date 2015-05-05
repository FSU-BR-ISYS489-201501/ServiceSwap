<!-- PhraseAJax.php 
Author: Brian Caughell
Date: March/April 2015
Description: A file holding functions to be called on via AJAX from EditUnacceptablePhrases.php 
Dependencies: EditUnacceptablePhrases.php
					Config.php
-->
<?php
	$Title = "";
	$CategoryID = "";
	$Description = "";
	$Price = "";
	$Distance = "";
	$Units = "";
	$Exchange = "";
	$Equipment = "";
	$ID = "";
include '../Includes/config.php';
#BC- Check what type the incoming 
if (isset($_POST['action'])){
	switch ($_POST['action']){
		case "toggleactive":
			toggleactive($conn);
			break;
		case "newservice":
			newservice($conn);
			break;
		case "editservice":
			grabservice($conn);
			break;
		case "commitedit":
			commitedit($conn);
			break;
		default:
			break;
	}
}

function toggleactive($conn){
	#BC Function to toggle a service to active/inactive.
	$Status = $_POST['activestatus'];
	$Entry = $_POST['servid'];
	$StatusStr = "";
	if($Status == 0){
		$Status = 1;
		$StatusStr = "activated.";
	}
	else{
		$Status = 0;
		$StatusStr = "deactivated.";
	}
	$UpdateStatus = $conn -> prepare("UPDATE OfferedServices SET ServActive = ? WHERE OffServID=$Entry") ;#BC - Create a prepared statement
	$UpdateStatus->bind_param("i",$Status);#BC- Set the parameters for the prepared statement
	$UpdateStatus->execute(); #BC- Update the phrase
	$UpdateStatus->close(); #BC- Close the statement
	echo "Service ".$StatusStr;
	exit;
}

function preppost(){
	$Title = trim(preg_replace('/\s\s+/',' ', str_replace("\n"," ",$_POST['newtitle'])));
	$CategoryID = (int)$_POST['newcategory'];
	$Description = trim(preg_replace('/\s\s+/',' ', str_replace("\n"," ",$_POST['newdescription'])));
	$Price = trim(preg_replace('/\s\s+/',' ', str_replace("\n"," ",$_POST['newprice'])));
	$Distance = (int)$_POST['newdistance'];
	$Units = (int)$_POST['newunits'];
	$Exchange = (int)$_POST['newexchange'];
	$Equipment = (int)$_POST['newequipment'];
	$ID = 1;
}


function newservice($conn){
	$Title = trim(preg_replace('/\s\s+/',' ', str_replace("\n"," ",$_POST['newtitle'])));
	$CategoryID = (int)$_POST['newcategory'];
	$Description = trim(preg_replace('/\s\s+/',' ', str_replace("\n"," ",$_POST['newdescription'])));
	$Price = trim(preg_replace('/\s\s+/',' ', str_replace("\n"," ",$_POST['newprice'])));
	$Distance = (int)$_POST['newdistance'];
	$Units = (int)$_POST['newunits'];
	$Exchange = (int)$_POST['newexchange'];
	$Equipment = (int)$_POST['newequipment'];
	$ID = 1;

	if (strlen($Title) > 0 && strlen($Title<=20) && $CategoryID>0 && strlen($Description) > 0 && !is_null($Price) && !is_null($Distance) && !is_null($Units) && !is_null($Price) && !is_null($Exchange) && !is_null($Equipment)){
		include '../Includes/config.php';
		$AddService = $conn->prepare("INSERT INTO OfferedServices (UserID, ServCategoryID, OffServTitle, OffServDescription, OffServPrice, OffServDistance,OffServDistanceUnits, AcceptServExchange, ServEquipment, ServActive) VALUES (?,?,?,?,?,?,?,?,?,?)") ; #BC - Create a prepared statement
		$AddService->bind_param("iisssiiiii", $ID, $CategoryID, $Title, $Description, $Price, $Distance, $Units, $Exchange, $Equipment, $ID); #BC- Set the parameters for the prepared statement
		$AddService->execute(); # BC - Add the service
		$AddService->close(); # BC- Close the statement
		$Message = $Title." added to database.";
		echo $Message;
		/*
		BC I was attempting to return a json encoded array to hold a success status and message, but
		was unable to figure out how to do this correctly.
		$Array = array("stat"=>"success", "resp"=>$Message);
		echo json_encode($Array);
		*/
	}
	else{
		/* BC- I could not get form validation to work in this case- I wasn't able to successfully return a statement based
			on success or failure of the submission. Therefore the page only returns a generic error if
			there are any problems.
			*/
		$Message = "Error.";
		echo $Message;
		/*
		$Array = array("stat"=>"error", "resp"=>$Message);
		echo json_encode(array($Array));
		*/
	}

}

function grabservice($conn){
	$Title ="";
	$Category = "";
	$Description = "";
	$ServId = $_POST['servid'];
	include '../Includes/config.php';
	$Query = "SELECT * FROM OfferedServices INNER JOIN ServiceCategories ON OfferedServices.ServCategoryID = ServiceCategories.ServCategoryID WHERE OffServID = $ServId";
	$GrabService = mysqli_query($conn, $Query);
	while ($Row = mysqli_fetch_array($GrabService)){
		$Title = $Row['OffServTitle'];
		$Category = $Row['ServCategory'];
		$Description = $Row['OffServDescription'];
		$Price = $Row['OffServPrice'];
		$Distance = $Row['OffServDistance'];	
		switch($Row['ServEquipment']){
					case 0 : 
						$EquipProvided = "No";
						$BoolEquip = 0;
						$OtherEquip ="Yes";
						$OtherEquipBool = 1;
						break;
					case 1 : 
						$EquipProvided = "Yes";
						$BoolEquip = 1;
						$OtherEquip = "No";
						$OtherEquipBool = 0;
						break;
		}
		switch($Row['OffServDistanceUnits']){
			case 0:
				$DistanceUnits = "km";
				$OtherUnits = "mi";
				break;
			case 1:
				$DistanceUnits = "mi";
				$OtherUnits = "km";
				break;

		}
		switch($Row['AcceptServExchange']){
			case 0:
				$AcceptExch = "No";
				$BoolExch = 0;
				$OtherExch = "Yes";
				$OtherExchBool = 1;
				break;
			case 1:
				$AcceptExch = "Yes";
				$BoolExch = 1;
				$OtherExch = "No";
				$OtherExchBool = 0;
				break;

		}
	}



	mysqli_close($conn);
				echo '<input type="hidden" name="servid" value="'.$ServId.'"><input type="hidden" name="action" value="commitedit">';
				echo '<table>';
				echo '<tr>';
				echo '<th>Title</th>';
				echo '<th>Category</th>';
				echo '<th colspan="2">Description</th>';
		
				echo '<tr>';
				echo '<td><input type="text" id="newtitle" name="newtitle" style="width:200px" value="'.$Title.'"></td>';
				echo '<td><select name="newcategory" id="newcategory" size="5">';
				include "../Includes/config.php";
				$ReturnCategories = mysqli_query($conn, "SELECT ServCategory, ServCategoryID FROM ServiceCategories");
					while ($Row = mysqli_fetch_array($ReturnCategories)) {
						if ($Row['ServCategory'] == $Category){
							echo '<option value="'.$Row['ServCategoryID'].'" selected>'.$Category.'</option>';
						}
						else {
							echo '<option value="'.$Row['ServCategoryID'].'">'.$Row['ServCategory'].'</option>';
						}	
					}
				echo "</select></td>";
				echo '<td colspan="2"><textarea rows="5" cols="30" id="newdescription" name="newdescription" style="resize:none">'.$Description.'</textarea></td></tr>';
				echo '<tr><th>Price</th>';
				echo '<th>Distance</th>';
				echo '<th>Exchange</th>';
				echo '<th>Equip. Provided</th></tr>';
				echo '<td style="text-align:center"><input type="text" id="newprice" name="newprice" size="10" style="text-align:right" value="'.$Price.'"></td>';
				echo '<td style="text-align:center"><input type="text" id="newdistance" name="newdistance" style="text-align:right; width:50%" value="'.$Distance.'"">';
				echo '<select name="newunits" id="newunits">';
				echo '<option value="'.$DistanceUnits.'" selected>'.$DistanceUnits.'</option>';
				echo '<option value="'.$OtherUnits.'">'.$OtherUnits.'</option></select></td>';
				echo '<td style="text-align:center"><select name="newexchange" id="newexchange">';
				echo '<option value="'.$BoolExch.'" selected>'.$AcceptExch.'</option>';
				echo '<option value="'.$OtherExchBool.'">'.$OtherExch.'</option></select></td>';
				echo '<td style="text-align:center"><select name="newequipment" id="newequipment">';
				echo '<option value="'.$BoolEquip.'" selected>'.$EquipProvided.'</option>';
				echo '<option value="'.$OtherEquipBool.'">'.$OtherEquip.'</option></select></td>';
				echo '</tr>';
				echo "</table>";
					

				mysqli_close($conn);	
}

function commitedit($conn){
	$ServId = $_POST['servid'];
	$Title = trim(preg_replace('/\s\s+/',' ', str_replace("\n"," ",$_POST['newtitle'])));
	$CategoryID = (int)$_POST['newcategory'];
	$Description = trim(preg_replace('/\s\s+/',' ', str_replace("\n"," ",$_POST['newdescription'])));
	$Price = trim(preg_replace('/\s\s+/',' ', str_replace("\n"," ",$_POST['newprice'])));
	$Distance = (int)$_POST['newdistance'];
	$Units = (int)$_POST['newunits'];
	$Exchange = (int)$_POST['newexchange'];
	$Equipment = (int)$_POST['newequipment'];
	$ID = 1;
	if (strlen($Title) > 0 && strlen($Title<=20) && $CategoryID>0 && strlen($Description) > 0 && !is_null($Price) && !is_null($Distance) && !is_null($Units) && !is_null($Price) && !is_null($Exchange) && !is_null($Equipment)){
		include '../Includes/config.php';
		$CommitEdit = $conn->prepare("UPDATE OfferedServices SET UserID=?, ServCategoryID=?, OffServTitle=?, OffServDescription=?, OffServPrice=?, OffServDistance=?,OffServDistanceUnits=?, AcceptServExchange=?, ServEquipment=?, ServActive=? WHERE OffServID = ?") ; #BC - Create a prepared statement
		$CommitEdit->bind_param("iisssiiiiii", $ID, $CategoryID, $Title, $Description, $Price, $Distance, $Units, $Exchange, $Equipment, $ID, $ServId);  #BC- Set the parameters for the prepared statement
		$CommitEdit->execute(); # BC - Add the service
		$CommitEdit->close(); # BC- Close the statement
		$data = $Title." updated successfully.";
		echo $data;
		exit;
	}
	else{
		echo "Error.";
		exit;
	}	
	exit;
}


mysqli_close($conn);
?>