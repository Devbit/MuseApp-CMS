<?php
session_start();

//redirect functie
function returnheader($location){
	$returnheader = header("location: $location");
	return $returnheader;
}

include_once 'config.php';
$errors = array();
if (isset($_GET['id']) && isset($_GET['token']))
$id =$_GET['id'];$token =$_GET['token'];

if(isset($_POST["iebugaround"])){

//Ingevulde velden fetchen
$passw = trim(htmlentities($_POST['password']));

// Check voor lege velden
if(empty($passw)){ $errors[] = "U heeft geen wachtwoord ingevuld";}

if(!$errors){
	
	$passw = $passw;
	$salt = "%765]VZwaZ-|H/4";
	$pepper = "-S8qxBR18Ed0";
	$passencrypt = hash('sha256', $salt . $passw . $pepper); 
	
	$result = mysql_query("UPDATE users SET password= '" . $passencrypt . "', password_token='' WHERE id='" . $id . "' AND password_token='". $token . "'") OR die(mysql_error());
	$finish = 1;
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
        <title>MuseApp - Wachtwoord wijzigen</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
		<META NAME="ROBOTS" CONTENT="INDEX, FOLLOW">
        
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
	<div class="login-header"></div><br/><br/>
    <?php
	$result = mysql_query("SELECT email,password_token FROM users WHERE id= '". $id . "' AND password_token='". $token . "'");
	if(mysql_num_rows($result) > 0) { ?>
        <form action="#" method="post" style="margin:10px;">
            		<?php
			if(count($errors) > 0){
				echo "<div style='color:rgb(255, 133, 0);'>";
				foreach($errors as $error){
					echo $error . "<br />";
				}echo "</div>";}
		?><br/>
        	<input name="iebugaround" type="hidden" value="1"> 

            <fieldset class="fieldset-password">
            <label>Nieuw wachtwoord</label><input type="password" name="password" class="username"/></fieldset>
			<br/>
            <fieldset>
                <input name="submit" id="submit" value="Submit" class="login-submit" type="submit"/>
            </fieldset>
        	<br/>
        </form>
     <?php
	} elseif($finish < 1) {
		echo "<div style='color:rgb(255, 133, 0);margin-top:20px;margin-left:10px;'>Deze link is helaas niet meer geldig.</div>";
	} else {
		echo "<div style='color:rgb(255, 133, 0);margin-top:20px;margin-left:10px;'>Uw wachtwoord is gewijzigd, u kunt <a href='index.php'>hier</a> inloggen</div>";
	}
	 ?>
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