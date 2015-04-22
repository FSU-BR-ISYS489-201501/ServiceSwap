<!DOCTYPE html>
<html>
<!-- EditServiceList.php 
Author: Brian Caughell
Date: April 2015
Description: Page to list, edit, delete, and add new services within the database.
Dependencies: PhraseAjax.php
					Config.php

-->
<head> 
<!-- BC-  jQuery scripts and stylesheets courtesy jquery.com -->
<link rel="stylesheet" type="text/css" href="../Css/jquery-ui.css">
<script src="../Js/jquery-1.11.2.min.js"></script>
<script src="../Js/jquery-ui.js"></script>
 <script>
$(document).ready(function() {
	<!-- BC- jQuery confirmation box for edits/deletes -->
	$("#ConfirmDialog").dialog({
		autoOpen:false,
		resizable: false,
		width: 350,
		modal: true,
		buttons:{
			"OK":function(){
			$(this).dialog("close");
			$(this).innerHTML = ""; // BC- Clear out the confirmation text from the dialog.
			location.reload(); // BC- Reload the page- the calling function has return false so the modal form will display 
			$("#newentry").val(""); // BC- Clear any text within the newentry text field
			}
		}
	});
	<!-- BC- jQuery delete dialog -->
	$("#DeleteDialog").dialog({
		autoOpen: false,
		resizable: false,
		width: 350,
		modal: true,
		buttons: {
			"OK": function(){
				$(this).dialog("close");
				$("#confirmdelete").submit(); // BC- Submit the form- this will be handled by AJAX
			},
			Cancel: function() {
				$(this).dialog("close");
			}
		}
		});
	<!-- BC- jQuery delete button click event handler -->
	$( ".DeleteButton").click(function() {
		$(".phrasetodelete").val($(this).attr("value")); // BC- Set the values in the dialog to the corresponding values of the button
		$(".idtodelete").val($(this).attr("name"));
		$("#DeleteDialog").dialog( "open" ); // BC- Open the DeleteDialog 
	});
	<!-- BC- jQuery edit dialog -->
	$("#EditDialog").dialog({
		autoOpen: false,
		resizable: false,
		width: 350,
		modal: true,
		buttons: {
			"OK": function(){
				$(this).dialog("close");
				$("#editphrase").submit(); // BC- Submit the form, AJAX handles the submission
				},
			Cancel: function() {
				$(this).dialog("close");
				$(".phrasetoedit").val(""); // BC- Clear out any values that were pulled into the dialog
				$("#newentry").val("");
				$(".idtoedit").val("");
			}
		}
		});
	<!-- BC- jQuery edit button click event handler -->
	$( ".EditButton").click(function() {
		$(".phrasetoedit").val($(this).attr("value")); // BC- Set the values in the dialog to the corresponding values of the button
		$("#editedentry").val($(this).attr("value"));
		$(".idtoedit").val($(this).attr("name"));
		$("#EditDialog").dialog( "open" ); // BC- Open the EditDialog 
	});
	<!-- BC- AJAX handler for form submissions
	$(".form").submit(function() {
		$.ajax({
			type: "POST",
			url: "ServiceAjax.php", // BC- the AJAX document holds the functions handling the form submissions
			data: $(this).serialize(), // BC- set the data of the form into an array for POST
			success: function(data) {
					var x = data; // BC- Grab the result of the submission - these are coded as echo statements within the AJAX document
					document.getElementById("ConfirmDialog").innerHTML = x;
					$("#newtitle").val("");
					$("#newcategory").val("");
					$("#newdescription").val("");
					$("#newprice").val("");
					$("#newdistance").val("");
					$("#newunits").val("0");
					$("#newexchange").val("0");
					$("#newequipment").val("0");
			}

		});
		$("#ConfirmDialog").dialog("open"); // BC - Display the confirmation dialog with the returned text. 
		return false; // BC- Return false so page does not auto-refresh. This allows the confirmation dialog to display
	});
});
</script>
<!-- BC- Style for scroll box -->
	<style>
	div.scroll {
		width: 900px;
		height: 300px;
		overflow-y: scroll;
	}
	#newservice {
	 	vertical-align: top;
	}
	}
	</style>
<!-- BC- Style for line numbers in table -->
	<style>
	td.ln {
		padding: 5px;
		text-align: right;
	}
	</style>
	<title>Edit Services</title>
</head>
<body>
<h3>Active Services</h3>
<div class="scroll">
	<table>
		<tr>
			<th>ID</th>
			<th>Service Title</th>
			<th>Category</th>
			<th>Description</th>
			<th>Price</th>
			<th>Distance</th>
			<th>Accept<br>Exchange</th>
			<th>Equip. Provided</th>
		</tr>
		<?php 
		include "../Includes/config.php"; // BC- configuation data for the database
		$EquipProvided = "";
		$AcceptExchange = "";
		$DistanceUnits = "";
		$ReturnServices = mysqli_query($conn, "SELECT * FROM OfferedServices INNER JOIN ServiceCategories ON OfferedServices.ServCategoryID = ServiceCategories.ServCategoryID WHERE ServActive=1" ); #BC- Select all rows from the phrases table
		#$ReturnServices = mysqli_query($conn, "SELECT o.*, s.* FROM OfferedServices AS o, INNER JOIN ServiceCategories AS s ON o.ServCategoryID = s.ServCategoryID WHERE o.ServActive=1"); #BC- Select all rows from the phrases table	
		#BC- Loop through each returned phrase, setting each one as a row in a table
			while ($Row = mysqli_fetch_array($ReturnServices)) {
				switch($Row['ServEquipment']){
					case 0 : 
						$EquipProvided = "No";
						break;
					case 1 : 
						$EquipProvided = "Yes";
						break;
				}
				switch($Row['OffServDistanceUnits']){
					case 0:
						$DistanceUnits = "km";
						break;
					case 1:
						$DistanceUnits = "mi";
						break;

				}
				switch($Row['AcceptServExchange']){
					case 0:
						$AcceptExchange = "No";
						break;
					case 1:
						$AcceptExchange = "Yes";
						break;

				}
				echo "<tr>";
				echo '<td class="ln">'. $Row['OffServID'].'</td>'; #BC- Right align the line numbers, add some padding for readability 
				echo '<td>'.$Row['OffServTitle'].'</td>';
				echo '<td>'.$Row['ServCategory'].'</td>';
				echo '<td>'.$Row['OffServDescription']."</td>";
				echo '<td>'.$Row['OffServPrice']."</td>";
				echo '<td>'.$Row['OffServDistance'].' '.$DistanceUnits.'</td>';
				echo '<td>'.$AcceptExchange.'</td>';
				echo '<td>'.$EquipProvided.'</td>';
				#echo '<td><button class="EditButton" name="'.$Row['InapprContID'].'" value="'.$Row['InapprPhrase'].'">Edit</button></td>'; #BC- Edit link
				#echo '<td><button class="DeleteButton" name="'.$Row['InapprContID'].'" value="'.$Row['InapprPhrase'].'">Delete</button></td>'; #BC- Delete link
				echo "</tr>";
			}
			mysqli_close($conn); // BC - Close the database connection
		?>
	</table>
</div>
<br>
<p>
	<h3>Add a New Service</h3>
	<table >
		<tr>
		<th>Service Title</th>
		<th>Category</th>
		<th>Description</th>
		<th>Price</th>
		<th>Distance</th>
		<th>km/mi</th>
		<th>Accept<br>Exchange</th>
		<th>Equip.<br>Provided</th>
		</tr>
		<tr id="newservice">
		<form class="form"><input type="hidden" name="action" value="newservice">
			<td><input type="text" id="newtitle" name="newtitle" size="20"></td>
			<td><select name="category" id="newcategory"> 
				<option value="-1" selected>Category</option>
				<?php 
					include "../Includes/config.php";
					$ReturnCategories = mysqli_query($conn, "SELECT ServCategory, ServCategoryID FROM ServiceCategories");
					while ($Row = mysqli_fetch_array($ReturnCategories)) {
						echo '<option value="'.$Row['ServCategoryID'].'">'.$Row['ServCategory'].'</option>';
					}
				?>
				</select>
			</td>
			<td><textarea name="newdescription" id="newdescription" rows="5" cols="30" style="resize:vertical"></textarea></td>
			<td><input type="text" name="newprice" id="newprice" size="10"></td>
			<td><input type="text" name="newdistance" id="newdistance" size="10"></td>
			<td><select name="newunits" id="newunits">
				<option value="0" selected>km</option>
				<option value="1">mi</option>
				</select>
			</td>
			<td><select name="newexchange" id="newexchange">
				<option value="0" selected>No</option>
				<option value="1">Yes</option>
				</select>
			</td>
			<td><select name="newequipment" id="newequipment">
				<option value="0" selected>No</option>
				<option value="1">Yes</option>
				</select>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td><input type="submit" value="Submit"></td>
		</tr>
		</form>
	</table>
</p>
<br>
<p>
<h3>Deactivate/Reactivate Services</h3>
<div class="scroll">
	<table>
		<tr>
			<th>Status</th>
			<th>ID</th>
			<th>Service Title</th>
			<th>Category</th>
			<th>Description</th>
			<th>Price</th>
			<th>Distance</th>
			<th>Accept<br>Exchange</th>
			<th>Equip. Provided</th>
			</tr>
		<?php 
		include "../Includes/config.php"; // BC- configuation data for the database
		$EquipProvided = "";
		$Active = "";
		$AcceptExchange = "";
		$DistanceUnits = "";
		$ReturnServices = mysqli_query($conn, "SELECT * FROM OfferedServices INNER JOIN ServiceCategories ON OfferedServices.ServCategoryID = ServiceCategories.ServCategoryID" ); #BC- Select all rows from the phrases table
		#$ReturnServices = mysqli_query($conn, "SELECT o.*, s.* FROM OfferedServices AS o, INNER JOIN ServiceCategories AS s ON o.ServCategoryID = s.ServCategoryID WHERE o.ServActive=1"); #BC- Select all rows from the phrases table	
		#BC- Loop through each returned phrase, setting each one as a row in a table
			while ($Row = mysqli_fetch_array($ReturnServices)) {
				switch($Row['ServEquipment']){
					case 0 : 
						$EquipProvided = "No";
						break;
					case 1 : 
						$EquipProvided = "Yes";
						break;
				}
				switch($Row['ServActive']){
					case 0 :
						$Active = "Inactive";
						break;
					case 1 :
						$Active = "Active";
						break;

				}
				switch($Row['OffServDistanceUnits']){
					case 0:
						$DistanceUnits = "km";
						break;
					case 1:
						$DistanceUnits = "mi";
						break;

				}
				switch($Row['AcceptServExchange']){
					case 0:
						$AcceptExchange = "No";
						break;
					case 1:
						$AcceptExchange = "Yes";
						break;

				}

				echo "<tr>";
				echo '<form class="form"><input type="hidden" name="action" value="toggleactive">';
				echo '<input type="hidden" name="activestatus" value="'.$Row['ServActive'].'">';
				echo '<input type="hidden" name="servid" value="'.$Row['OffServID'].'">';
				echo '<td><input type="submit" value="'.$Active.'"></td>';
				echo '</form>';
				echo '<td class="ln">'. $Row['OffServID'].'</td>'; #BC- Right align the line numbers, add some padding for readability 
				echo '<td>'.$Row['OffServTitle']."</td>";
				echo '<td>'.$Row['ServCategory']."</td>";
				echo '<td>'.$Row['OffServDescription']."</td>";
				echo '<td>'.$Row['OffServPrice']."</td>";
				echo '<td>'.$Row['OffServDistance'].' '.$DistanceUnits.'</td>';
				echo '<td>'.$AcceptExchange.'</td>';
				echo '<td>'.$EquipProvided.'</td>';
				#echo '<td><button class="EditButton" name="'.$Row['InapprContID'].'" value="'.$Row['InapprPhrase'].'">Edit</button></td>'; #BC- Edit link
				#echo '<td><button class="DeleteButton" name="'.$Row['InapprContID'].'" value="'.$Row['InapprPhrase'].'">Delete</button></td>'; #BC- Delete link
				echo '</form>';
				echo "</tr>";
			}
			mysqli_close($conn); // BC - Close the database connection
		?>
	</table>
</div>
</p>
<!--BC- Jquery dialogs area -->
<div id="ConfirmDialog" title "">
</div>
</body>
</html>