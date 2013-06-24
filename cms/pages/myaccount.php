<?php if(!strlen($_SESSION["SESS_USERNAME"]) > 0)header("location: ../home.php"); 
if(isset($_POST["iebugaround"])){

//Ingevulde velden fetchen
$oldpass = trim(htmlentities($_POST['oldpass']));
$newpass = trim(htmlentities($_POST['newpass']));
$newemail = trim(htmlentities($_POST['newemail']));
// Check voor lege velden
if(empty($oldpass)){ $errors[] = "U heeft uw huidige wachtwoord niet ingevuld."; }elseif(empty($newpass)&&empty($newemail)){ $errors[] = "U heeft geen nieuw wachtwoord ingevuld of nieuw email ingevuld.";}

if(!$errors){
	function encryptpass($passw) {
	$passw = $passw;
	$salt = "%765]VZwaZ-|H/4";
	$pepper = "-S8qxBR18Ed0";
	$passencrypt = hash('sha256', $salt . $passw . $pepper);
	return mysql_real_escape_string($passencrypt);
	}
	$query1 = "SELECT * FROM users WHERE id='".$_SESSION["SESS_USERID"]."' AND password='".encryptpass($oldpass)."'" OR die(mysql_error());
	$result = mysql_query($query1) OR die(mysql_error());
	if(mysql_num_rows($result) > 0){
		if(empty($newpass)){
			$query= mysql_query("UPDATE users SET email= '" . mysql_real_escape_string($newemail) . "' WHERE id='" . $_SESSION["SESS_USERID"] . "'");
		} elseif(empty($newemail)) {
			$query= mysql_query("UPDATE users SET password= '".encryptpass($newpass)."' WHERE id='" . $_SESSION["SESS_USERID"] . "'");
		} else {
	   $query= mysql_query("UPDATE users SET password= '".encryptpass($newpass)."', email= '" . mysql_real_escape_string($newemail) . "' WHERE id='" . $_SESSION["SESS_USERID"] . "'");
		}
		if($query) $errors[] = "Succes! Uw gegevens zijn gewijzigd";

	} else {
	
		//tell there is no username etc
		$errors[] = "Je huidige wachtwoord is niet correct.";
	
	}

}


} else {

$uname = "";

}
	$query1 = mysql_query("SELECT email FROM users WHERE id='".$_SESSION["SESS_USERID"]."'") OR die(mysql_error());
		while($row = mysql_fetch_array($query1)){
?>
        <form action="#" method="post" style="margin:10px;">
            		<?php
			if(count($errors) > 0){
				echo "<div style='color:rgb(255, 133, 0);'>";
				foreach($errors as $error){
					echo $error . "<br />";
				}echo "</div>";}
		?><br/>
        	<input name="iebugaround" type="hidden" value="1"> 

            <fieldset class="fieldset-oldpass">
            <label>Huidig wachtwoord</label><input type="password"  name="oldpass" class="username"/></fieldset>
            <br/>
            <fieldset class="fieldset-newpass">
            <label>Nieuw wachtwoord</label><input type="password" name="newpass" class="username"/></fieldset>
			<br/>
            <fieldset class="fieldset-newold">
            <label>Nieuw email</label><input type="text" name="newemail" value="<?php echo $row['email'];?>" class="username"/></fieldset>
            <br/>
            <fieldset>
                <input name="submit" id="submit" value="Verstuur" class="login-submit" type="submit"/>
            </fieldset>
        	<br/>
        </form>
        <?php }?>