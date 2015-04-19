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
			url: "PhraseAjax.php", // BC- the AJAX document holds the functions handling the form submissions
			data: $(this).serialize(), // BC- set the data of the form into an array for POST
			success: function(data) {
					var x = data; // BC- Grab the result of the submission - these are coded as echo statements within the AJAX document
					document.getElementById("ConfirmDialog").innerHTML = x; // BC- Set the contents of the confirmation dialog to the result
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
		width: 800px;
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
<div class="scroll">
	<table>
		<tr>
			<th>ID</th>
			<th>Service Title</th>
			<th>Category</th>
			<th>Description</th>
			<th>Price</th>
			<th>Distance</th>
			<th>Equip. Provided</th>
			</tr>
		<?php 
		include "../Includes/config.php"; // BC- configuation data for the database
		$EquipProvided = "";
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
				echo "<tr>";
				echo '<td class="ln">'. $Row['OffServID'].'</td>'; #BC- Right align the line numbers, add some padding for readability 
				echo '<td>'.$Row['OffServTitle']."</td>";
				echo '<td>'.$Row['ServCategory']."</td>";
				echo '<td>'.$Row['OffServDescription']."</td>";
				echo '<td>'.$Row['OffServPrice']."</td>";
				echo '<td>'.$Row['OffServDistance']."</td>";
				echo '<td>'.$EquipProvided."</td>";
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
	<table >
		<tr>
		<th>Service Title</th>
		<th>Category</th>
		<th>Description</th>
		<th>Price</th>
		<th>Distance</th>
		<th>Equip.<br>Provided</th>
		</tr>
		<tr id="newservice">
		<form action="">
			<td><input type="text" name="title" size="20"></td>
			<td><select name="category"> 
				<option value="" selected>Category</option>
				<?php 
					include "../Includes/config.php";
					$ReturnCategories = mysqli_query($conn, "SELECT ServCategory FROM ServiceCategories");
					while ($Row = mysqli_fetch_array($ReturnCategories)) {
						echo '<option value="'.$Row['ServCategory'].'">'.$Row['ServCategory'].'</option>';
					}
				?>
				</select>
			</td>
			<td><textarea name="description" rows="5" cols="30" style="resize:vertical"></textarea></td>
			<td><input type="text" name="price" size="10"></td>
			<td><input type="text" name="distance" size="10"></td>
			<td><select name="equipprovided">
				<option value="0" selected>No</option>
				<option value="1">Yes</option>
				</select>
			</td>
		</form>
		</tr>


	</table>

<!-- BC- Area to input new phrase -->
</p>
<!--BC- Jquery dialogs area -->
<div id="DeleteDialog" title="Confirm service deletion">
	<form id= "confirmdelete" class="form">
		<input type="hidden" name="action" value="deletephrase">
		<input type="hidden" class="idtodelete" name="line" value="">
		Are you sure you want to delete the entry : <input class="phrasetodelete" name="entry" value="" readonly>
	</form>
</div>
<div id="EditDialog" title="Edit phrase">
	<form id="editphrase" class="form">
		<input type="hidden" name="action" value="editphrase">
		<input type="hidden" class="idtoedit" name="line" value="">
		<input type="hidden" class="phrasetoedit" name="entry" value="">
		New entry: <input type ="text" id="editedentry" name="newentry" size="25" value=""><!--BC- Pass both the old and new values to the CommitEdit page -->
	</form>
</div>
<div id="ConfirmDialog" title "">
</div>
</body>
</html>