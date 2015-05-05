<?php
session_start();
?>
<!DOCTYPE html>
<html>
<!-- EditUnacceptedPhrases.php 
Author: Brian Caughell
Date: March 2015
Description: Page to list, edit, delete, and add new unacceptable phrases within the database.
Dependencies: PhraseAjax.php
					Config.php
-->
<head> 
<!-- BC-  jQuery scripts and stylesheets courtesy jquery.com -->

<!-- BC- Style for scroll box -->
	<style>
	div.scroll {
		width: 500px;
		height: 300px;
		overflow-y: scroll;
	}
	</style>
<!-- BC- Style for line numbers in table -->
	<style>
	td.ln {
		padding: 5px;
		text-align: right;
	}
	.override{
		border-style: none;
	}
	</style>
	<link rel="stylesheet" type="text/css" href="../Css/jquery-ui.css"> 
	<link type="text/css" rel="stylesheet" href="../Css/jquery.mmenu.all.css"/> 
	<link rel="stylesheet" href="../Css/swap_br.css" type="text/css" media="screen">
	<link rel="stylesheet" href="../Css/stylesheet.css" type="text/css" charset="utf-8" />
	<script src="../Js/jquery-1.11.2.min.js"></script>
	<script src="../Js/jquery-ui.js"></script>
	<title>Edit Unaccepted Phrases</title>
<body>
<?php

#BC-  Redirect script courtesy GaryDevenay, please see http://stackoverflow.com/questions/7066527/redirect-a-user-after-the-headers-have-been-sent
function redirect(){
    $url = "http://brserviceswap.isys489.com/";
    $string = '<script type="text/javascript">';
    $string .= 'window.location = "' . $url . '"';
    $string .= '</script>';
    echo $string;
}
include "../Includes/frontcontroller.php";
#BC- Redirect the user if they aren't logged in. This page should be for admin access only. 
if(check_session_head() == false){
	redirect();
}

?>

<div class="scroll">
	<table>
		<tr>
			<th>ID</th>
			<th>EmployeeID</th>
			<th>Phrase</th>
			<th colspan="2">Actions</th>
		</tr>
		<?php 
		include "../Includes/config.php"; // BC- configuation data for the database
		$ReturnPhrases = mysqli_query($conn, "SELECT * FROM InappropriateContent ORDER BY InapprPhrase"); #BC- Select all rows from the phrases table
			#BC- Loop through each returned phrase, setting each one as a row in a table
			while ($Row = mysqli_fetch_array($ReturnPhrases)) {
				echo "<tr>";
				echo '<td class="ln">'. $Row['InapprContID'].'</td>'; #BC- Right align the line numbers, add some padding for readability 
				echo '<td class="ln">'.$Row['EmployeeID']."</td>"; 
				echo '<td>'.$Row['InapprPhrase']."</td>";
				echo '<td><button class="EditButton" name="'.$Row['InapprContID'].'" value="'.$Row['InapprPhrase'].'">Edit</button></td>'; #BC- Edit link
				echo '<td><button class="DeleteButton" name="'.$Row['InapprContID'].'" value="'.$Row['InapprPhrase'].'">Delete</button></td>'; #BC- Delete link
				echo "</tr>";
			}
			mysqli_close($conn); // BC - Close the database connection
		?>
	</table>
</div>
<br>
<p>
<!-- BC- Area to input new phrase -->
	<form id="newphrase" class="form"> 
	<input type="hidden" name="action" value="newphrase">
	<table class="override">
		<tr class="override">
			<td class="override">New entry:</td><td class="override"><input type ="text" id="newentry" name="newentry" size="25"> </td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="Submit"></td>
		</tr>
	</table>
	</form>
</p>
<!--BC- Jquery dialogs area -->
<div id="DeleteDialog" title="Confirm phrase deletion">
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
<script>
$(function() {
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
			"Cancel": function() {
				$(this).dialog("close");
			},
			"OK": function(){
				$(this).dialog("close");
				$("#confirmdelete").submit(); // BC- Submit the form- this will be handled by AJAX
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
			"Cancel": function() {
				$(this).dialog("close");
				$(".phrasetoedit").val(""); // BC- Clear out any values that were pulled into the dialog
				$("#newentry").val("");
				$(".idtoedit").val("");
			},
			"OK": function(){
				$(this).dialog("close");
				$("#editphrase").submit(); // BC- Submit the form, AJAX handles the submission
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
</html>