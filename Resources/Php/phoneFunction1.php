

<?php
//SE
//Phone number function used to make sure the phone number is only numbers when it is submitted into the database.
//Phone number must be 11 digits to fit in the database based on international calls
//Adding an example to the sign up and edit pages will help users not get confused when adding there phone number
//Example: Enter phone number like 12345678901
function phoneNumber($phone) {
  $numbersOnly = preg_replace("/[^\d]/", "", $phone);
  return preg_replace("/^1?(\d{1})(\d{3})(\d{3})(\d{4})$/", "$1$2$3$4", $numbersOnly);
// Sources: http://stackoverflow.com/questions/5872096/function-to-add-dashes-to-us-phone-number-in-php
  }

	//Test Code
	//echo phoneNumber("1(616)457-1397");

?>


	
