
<!-- BJ --> 

<?php

function getLnt($zip){
	
	$url = "http://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($zip)."&sensor=false";
	$result_string = file_get_contents($url);
	$result = json_decode($result_string, true);
	$result1[]=$result['results'][0];
	$result2[]=$result1[0]['geometry'];
	$result3[]=$result2[0]['location'];
	
	return $result3[0];
}

function getDistance($zip1, $zip2, $unit){
	
	$first_lat = getLnt($zip1);
	$next_lat = getLnt($zip2);
	
	$lat1 = $first_lat['lat'];
	$lon1 = $first_lat['lng'];
	
	$lat2 = $next_lat['lat'];
	$lon2 = $next_lat['lng'];	
	
	$theta=$lon1-$lon2;
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +
			cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
			cos(deg2rad($theta));
	$dist = acos($dist);
	$dist = rad2deg($dist);
	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);
	
	if ($unit == "K"){
		return ($miles * 1.609344)." KM";
	}
	else if ($unit =="N"){
		return ($miles * 0.8684)." Miles";
	}
	else{
		return $miles." Miles";
	}
	
}

?>

<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<link rel="stylesheet" href="css/style.css">
<title>Distance Calculation</title>
</head>
<body>

<div align="center">
	<table border="0" width="1000" cellspacing="0" cellpadding="0">
		<tr>
			<td width="250" height="25">&nbsp;</td>
			<td width="600">&nbsp;</td>
			<td width="150">&nbsp;</td>
		</tr>
		<tr>
			<td width="250">&nbsp;</td>
			<td width="600"><div class="content"> <h1> Distance between both zip codes </h1> 



				<form method="POST" action="?flag=true">
				<table border="0" width="100%" cellspacing="0" cellpadding="0">
					<tr>
						
							<td width="23%" height="34">Enter Zip1</td>
							<td width="28%" height="34">
							<input type="text" name="zipCode" size="20" value="<?php print $_POST['zipCode']; ?>"></td>
							<td height="34">&nbsp;</td>
						
					</tr>
					<tr>
							<td width="23%" height="34">Enter Zip2</td>
							<td width="28%" height="34">
							<input type="text" name="zipCode2" size="20" value="<?php print $_POST['zipCode2']; ?>"></td>
							<td height="34">&nbsp;</td>
					</tr>
					<tr>
							<td width="23%" height="34">Unit</td>
							<td width="28%" height="34">
							<input type="radio" value="K" name="unit" checked>KM 
							<input type="radio" value="N" name="unit">Miles</td>
							<td height="34">&nbsp;</td>
					</tr>
					<tr>
							<td width="23%" height="34">&nbsp;</td>
							<td width="28%" height="34">
							<input type="submit" value="Submit" name="B1"></td>
							<td height="34">&nbsp;</td>
					</tr>
				</table>
				</form>
				<p>&nbsp;
				<?php
					if($_GET['flag']){
					
					 $distance = getDistance($_POST['zipCode'],$_POST['zipCode2'],$_POST['unit']);
				?>
				<table border="0" width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td width="30%" height="30">Distance</td>
						<td><?php print $distance; ?></td>
					</tr>
					</table>
				<?php
				}
				?>
				<p>&nbsp;</div></td>
			<td width="150">&nbsp;</td>
		</tr>
	</table>
</div>

</body>

</html>