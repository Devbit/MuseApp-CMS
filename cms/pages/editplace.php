<?php
if(!strlen($_SESSION["SESS_USERNAME"]) > 0)header("location: ../home.php"); 
if (isset($_GET['id']))
$id =$_GET['id'];
$errors = array();
include_once("pictureupload.php");
if(!$rs = mysql_query("SELECT * FROM monumenten WHERE id='" . $id . "'")){echo "Cannot parse query";}
elseif(mysql_num_rows($rs) == 0) {echo "No records found";}
else{
	while($row = mysql_fetch_array($rs)) {
								if(count($errors) > 0){
							echo "<div style='color:rgb(255, 133, 0);'>";
						foreach($errors as $error){
							echo $error . "<br />";
						}echo "</div>";}
	if(($row['userid'] == $_SESSION["SESS_USERID"])|| ($_SESSION["SESS_ROLE"] == 1)) {
						$titel = $row['title'];
						$uitgelicht = $row['uitgelicht'];
						$info = $row['info'];
						$otherinfo = $row['otherinfo'];
						$history = $row['history'];
						$unveilingmonth = $row['unveilingmonth'];
						$unveilingday = $row['unveilingday'];
						$unveilingyear = $row['unveilingyear'];
						$zipcode = $row['zipcode'];
						$address = $row['address'];
						$city = $row['city'];
						$community = $row['community'];
						$state = $row['state'];
						$artist = $row['artist'];
						$latitude = $row['latitude'];
						$longitude = $row['longitude'];
						$image = $row['image'];
						$thumb = $row['thumb'];
						$category = $row['category'];

	if(isset($_POST['submiteditor'])) {
						$titel = mysql_real_escape_string($_POST['titel']);
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
						if(empty($newurl)) {$image = $row['image'];$thumb = $row['thumb'];}
						else {
						$image = "http://".$_SERVER['SERVER_NAME']."/".$newurl;
						$thumb = "http://".$_SERVER['SERVER_NAME']."/appthumbs/".end(explode("/",$newurl));
						}
						$category = mysql_real_escape_string($_POST['category']);
    	if($query= mysql_query("UPDATE monumenten SET title= '" . $title . "', uitgelicht= '". $uitgelicht . "', info='" . $info . "', otherinfo='" . $otherinfo . "', history='" . $history . "', unveilingmonth='" . $unveilingmonth . "', unveilingday='" . $unveilingday . "', unveilingyear='" . $unveilingyear . "', zipcode='" . $zipcode . "', address='" . $address . "', city='" . $city . "', community='" . $community . "', state='" . $state . "', artist='" . $artist . "', latitude='" . $latitude . "', longitude='" . $longitude. "', image='" . $image . "', thumb='" . $thumb. "', category='" . $category. "' WHERE id='" . $id . "'") or die(MySQL_Error()));
		if($query) $errors[] = "Succes! Uw plaats is aangepast.";
	}
						
						echo "<h2>Deze plaats aanpassen</h2>";
						echo'
						<img src="' . $thumb . '"  width="200px" style="position:absolute;margin-left:800px;"/>
						<form method="post" action="" enctype="multipart/form-data" class="placeform">
							<p>Titel:  <input type="text" name="titel" value="'.$titel.'"></input></p>
							<p>Uitgelicht: <select name="uitgelicht">
									<option value="'.$uitgelicht.'">'.$uitgelicht.'</option>
									<option value="1">Ja</option>
									<option value="0">Nee</option>
							</select></p>
							<p>Info:  <input type="text" name="info" value="'.$info.'"></input></p>
							<p>Otherinfo:  <input type="text" name="otherinfo" value="'.$otherinfo.'"></input></p>
							<p>History:  <input type="text" name="history" value="'.$history.'"></input></p>
							<p>Openingsdag: <select name="unveilingday">
									<option value="'.$unveilingday.'" selected>'.$unveilingday.'</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
									<option value="13">13</option>
									<option value="14">14</option>
									<option value="15">15</option>
									<option value="16">16</option>
									<option value="17">17</option>
									<option value="18">18</option>
									<option value="19">19</option>
									<option value="20">20</option>
									<option value="21">21</option>
									<option value="22">22</option>
									<option value="23">23</option>
									<option value="24">24</option>
									<option value="25">25</option>
									<option value="26">26</option>
									<option value="27">27</option>
									<option value="28">28</option>
									<option value="29">29</option>
									<option value="30">30</option>
									<option value="31">31</option>
							</select></p>
							<p>Openingsmaand: <select name="unveilingmonth">
									<option value="'.$unveilingmonth.'">'.$unveilingmonth.'</option>				
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
							</select></p>
							<p>Openingsjaar:  <input type="text" name="unveilingyear" value="'.$unveilingyear.'"></input></p>
							<p>Postcode:  <input type="text" name="zipcode" value="'.$zipcode.'"></input></p>
							<p>Adres:  <input type="text" name="address" value="'.$address.'"></input></p>
							<p>Stad:  <input type="text" name="city" value="'.$city.'"></input></p>
							<p>Gemeente:  <input type="text" name="community" value="'.$community.'"></input></p>
							<p>Provincie:  <input type="text" name="state" value="'.$state.'"></input></p>
							<p>Artiest:  <input type="text" name="artist" value="'.$artist.'"></input></p>
							<p>Breedtegraad:  <input type="text" name="latitude" value="'.$latitude.'"></input></p>
							<p>Lengtegraad:  <input type="text" name="longitude" value="'.$longitude.'"></input></p>
							<p>Afbeelding: <input type="file" name="fileup" /></p>
							<p>Categorie: <select name="category">
									<option value="'.$category.'">'.$category.'</option>	
									<option value="Monument">Monument</option>
									<option value="Museum">Museum</option>
							</select></p>
							
									<input type="submit" class="save" name="submiteditor" value="Save"><br/><br/>
						</form>
';
	} else {
		$errors[] = "Deze plaats is niet van u.";
	}}}

?>
