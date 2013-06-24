<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nieuwe plaatst aanmaken</title>
</head>

<body>
<?php
require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();
					if(isset($_POST['submiteditor'])) {
						$title = mysql_real_escape_string($_POST['titel']);
						$uitgelicht = mysql_real_escape_string($_POST['uitgelicht']);
						$info = mysql_real_escape_string($_POST['info']);
						$otherinfo = mysql_real_escape_string($_POST['otherinfo']);
						$history = mysql_real_escape_string($_POST['history']);
						$unveilingmonth = mysql_real_escape_string($_POST['unveilingmonth']);
						$unveilingday = mysql_real_escape_string($_POST['unveilingday']);
						$unveilingyear = mysql_real_escape_string($_POST['unveilingyear']);
						$zipcode = mysql_real_escape_string($_POST['zipcode']);
						$address = mysql_real_escape_string($_POST['address']);
						$city = mysql_real_escape_string($_POST['city']);
						$community = mysql_real_escape_string($_POST['community']);
						$state = mysql_real_escape_string($_POST['state']);
						$artist = mysql_real_escape_string($_POST['artist']);
						$latitude = mysql_real_escape_string($_POST['latitude']);
						$longitude = mysql_real_escape_string($_POST['longitude']);
						$image = mysql_real_escape_string($_POST['image']);
	
						
						$date = date('Y-m-d H:i:s');
      					$query= mysql_query("INSERT INTO monumenten (ID, modified_date, title, uitgelicht, info, otherinfo, history, unveilingday, unveilingmonth, unveilingyear, zipcode, address, city, community, state, artist, latitude, longitude, image) VALUES ('','" . $date . "','" . $title . "','" . $uitgelicht . "','" . $info . "','" . $otherinfo . "','" . $history . "','" . $unveilingday . "','" . $unveilingmonth . "','" . $unveilingyear . "','" . $zipcode . "','" . $address . "','" . $city . "','" . $community . "','" . $state . "','" . $artist . "','" . $latitude . "','" . $longitude . "','" . $image . "')") or die(MySQL_Error());
					}
					
						echo "
						<form method='post' action='' enctype='multipart/form-data'>
							<p>Titel:  <input type='text' name='titel' ></input></p>
							<p>Uitgelicht: <select name='uitgelicht'>
									<option value='1'>Ja</option>
									<option value='0'>Nee</option>
							</select></p>
							<p>Info:  <input type='text' name='info' ></input></p>
							<p>Otherinfo:  <input type='text' name='otherinfo' ></input></p>
							<p>History:  <input type='text' name='history' ></input></p>
							<p>Openingsdag: <select name='unveilingday'>
									<option value='1'>1</option>
									<option value='2'>2</option>
									<option value='3'>3</option>
									<option value='4'>4</option>
									<option value='5'>5</option>
									<option value='6'>6</option>
									<option value='7'>7</option>
									<option value='8'>8</option>
									<option value='9'>9</option>
									<option value='10'>10</option>
									<option value='11'>11</option>
									<option value='12'>12</option>
									<option value='13'>13</option>
									<option value='14'>14</option>
									<option value='15'>15</option>
									<option value='16'>16</option>
									<option value='17'>17</option>
									<option value='18'>18</option>
									<option value='19'>19</option>
									<option value='20'>20</option>
									<option value='21'>21</option>
									<option value='22'>22</option>
									<option value='23'>23</option>
									<option value='24'>24</option>
									<option value='25'>25</option>
									<option value='26'>26</option>
									<option value='27'>27</option>
									<option value='28'>28</option>
									<option value='29'>29</option>
									<option value='30'>30</option>
									<option value='31'>31</option>
							</select></p>
							<p>Openingsmaand: <select name='unveilingmonth'>
									<option value='1'>1</option>
									<option value='2'>2</option>
									<option value='3'>3</option>
									<option value='4'>4</option>
									<option value='5'>5</option>
									<option value='6'>6</option>
									<option value='7'>7</option>
									<option value='8'>8</option>
									<option value='9'>9</option>
									<option value='10'>10</option>
									<option value='11'>11</option>
									<option value='12'>12</option>
							</select></p>
							<p>Openingsjaar:  <input type='text' name='unveilingyear' ></input></p>
							<p>Postcode:  <input type='text' name='zipcode' ></input></p>
							<p>Adres:  <input type='text' name='address' ></input></p>
							<p>Stad:  <input type='text' name='city' ></input></p>
							<p>Gemeente:  <input type='text' name='community' ></input></p>
							<p>Provincie:  <input type='text' name='state' ></input></p>
							<p>Artiest:  <input type='text' name='artist' ></input></p>
							<p>Breedtegraad:  <input type='text' name='latitude' ></input></p>
							<p>Lengtegraad:  <input type='text' name='longitude' ></input></p>
							<p>Afbeelding:  <input type='text' name='image' ></input></p>
							
							
							<input type='submit' name='submiteditor' value='Save'>
						</form>
"; ?>
</body>
</html>
