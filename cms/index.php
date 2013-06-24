<?php
session_start();

//redirect functie
function returnheader($location){
	$returnheader = header("location: $location");
	return $returnheader;
}

include_once 'config.php';
$errors = array();
if(isset($_POST["iebugaround"])){

//Ingevulde velden fetchen
$uname = trim(htmlentities($_POST['username']));
$passw = trim(htmlentities($_POST['password']));

// Check voor lege velden
if(empty($uname)){ $errors[] = "U heeft geen gebruikernaam ingevuld"; }elseif(empty($passw)){ $errors[] = "U heeft geen wachtwoord ingevuld";}

if(!$errors){
	
	$passw = $passw;
	$salt = "%765]VZwaZ-|H/4";
	$pepper = "-S8qxBR18Ed0";
	$passencrypt = hash('sha256', $salt . $passw . $pepper); 

	$query = "SELECT * FROM users WHERE username='".mysql_real_escape_string($uname)."' AND password='".mysql_real_escape_string($passencrypt)."'" OR die(mysql_error());
	$result = mysql_query($query) OR die(mysql_error());
	if(mysql_num_rows($result) > 0){
	
		while($row = mysql_fetch_array($result)){
		
			$idsess = stripslashes($row["id"]);
			$username = stripslashes($row["username"]);
			$userrole= stripslashes($row["role"]);
			
			$_SESSION["SESS_USERID"] = $idsess;
			$_SESSION["SESS_USERNAME"] = $username;
			$_SESSION["SESS_ROLE"] = $userrole;
			
			setcookie("userloggedin", $username);
			setcookie("userloggedin", $username, time()+43200); // expires in 1 hour
			
			//success lets login to page
			returnheader("home.php");
		
		}
	
	} else {
	
		//tell there is no username etc
		$errors[] = "Je gebruikersnaam of wachtwoord is onjuist.";
	
	}

}


} else {

$uname = "";

}
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>MuseApp - Login</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
		<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
        
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
    <div class="wrapper-login">
    <div class="wrapper-logo" onclick="location.href='index.php';"></div>
    <div id="loginform">
	<div class="login-header"><h3>Login<h3/></div><br/><br/>
        <form action="#" method="post" style="margin:10px;">
            		<?php
			if(count($errors) > 0){
				echo "<div style='color:rgb(255, 133, 0);'>";
				foreach($errors as $error){
					echo $error . "<br />";
				}echo "</div>";}
		?><br/>
        	<input name="iebugaround" type="hidden" value="1"> 

            <fieldset class="fieldset-username">
            <label>Gebruikernaam</label>
            <input type="text" name="username" class="username" value="<?php echo $uname ; ?>"/></fieldset>
            <br/>
            <fieldset class="fieldset-password">
            <label>Wachtwoord</label><input type="password" name="password" class="username"/></fieldset>
			<br/>
            <fieldset>
                <input name="submit" id="submit" value="Login" class="login-submit" type="submit"/>
                <a href="forgotpassword.php" style="float: right;" class="button">Wachtwoord vergeten</a> <br/><br/>
                <a href="register.php" style="float: right;" class="button">Registreren</a>
            </fieldset>
        	<br/>
        </form>
	</div>

    </div>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            var _gaq=[['_setAccount','UA-41562977-1'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src='//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>