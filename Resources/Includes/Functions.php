<?php
/* BC- This function accepts an array and a string
and checks if the string exists within the array.
It returns -1 if no match is found, otherwise it
returns the index of the match */
function DuplicateCheck($array, $value){
for ($i=0; $i < count($array); $i++)
	{
		if (trim(strtolower($array[$i])) == trim(strtolower($value))){
			return $i;
			break;
		}
	}
return -1;
}
?>
