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
$email = trim(htmlentities($_POST['email']));

// Check voor lege velden
if(function_exists('filter_var') && !filter_var($email, FILTER_VALIDATE_EMAIL)){
	$errors[] = "Verbeter alstublieft uw email.";
}

if(!$errors){
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $passw = substr( str_shuffle( $chars ), 0, 10);
	$salt = "%765]VZwaZ-|H/4";
	$pepper = "-S8qxBR18Ed0";
	$emailencrypt = hash('sha256', $salt . $passw . $pepper);
	$result = mysql_query("SELECT id,email FROM users WHERE email= '". $email . "'");
	if(mysql_num_rows($result) > 0) {
		$result1 = mysql_query("UPDATE users SET password_token= '" . $emailencrypt . "' WHERE email='" . $email . "'") OR die(mysql_error());
	while ($row = mysql_fetch_assoc($result)) {	
	//Email versturen
	$to = $row['email'];	//ontvanger
	$subject = 'LIMS - Wachtwoord wijzigen'; //onderwerp
	$random_hash = sha1(date('r', time())); //SHA1 random hash genereren
	$headers = "From: info@lims.nl\r\nReply-To: webmaster@example.com"; //overige headers
	$headers .= "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\""; //boundry en mime type
	//bericht
$message = '
--PHP-alt-' . $random_hash .'
Content-Type: text/plain; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

Wachtwoord herstellen
Wanneer u op de link hieronder klikt heeft u de mogelijkheid om uw wachtwoord te wijzigen. Let op! Deze link kan maar 1 keer gebruikt worden om uw wachtwoord te wijzigen.
http://jsonapp.tk/cms/passwordreset.php?id='. $row['id'] . '&token=' . $emailencrypt . '
	
--PHP-alt-' . $random_hash .'
Content-Type: text/html; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

<div class="wrapper"><br/><br/>
<img src="http://jsonapp.tk/cms/img/museapp-logo.png" width="500px" height="126px" >
<h2>Wachtwoord herstellen</h2>
<p>Wanneer u op de link hieronder klikt heeft u de mogelijkheid om uw wachtwoord te wijzigen. Let op! Deze link kan maar 1 keer gebruikt worden om uw wachtwoord te wijzigen.</p>
<a href="http://jsonapp.tk/cms/passwordreset.php?id='. $row['id'] . '&token=' . $emailencrypt . '">http://jsonapp.tk/cms/passwordreset.php?id='. $row['id'] . '&token=' . $emailencrypt . '</a>
</div>
<style type="text/css">
.wrapper {
width:600px;
margin:0px auto;
}
</style>
--PHP-alt-' . $random_hash .'--
';
	$mail_sent = @mail( $to, $subject, $message, $headers ); //email versturen
	if($mail_sent) $errors[] = "Er is een email naar u verstuurt waarmee u uw wachtwoord kunt wijzigen."; //succes bericht
	}
	} else $errors[] = "Er is een email naar u verstuurt waarmee u uw wachtwoord kunt wijzigen."; //succes bericht
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
        <title>MuseApp - Wachtwoord vergeten</title>
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
        <form action="#" method="post" style="margin:10px;">
            		<?php
			if(count($errors) > 0){
				echo "<div style='color:rgb(255, 133, 0);'>";
				foreach($errors as $error){
					echo $error . "<br />";
				}echo "</div>";}
		?><br/>
        	<input name="iebugaround" type="hidden" value="1"> 

            <fieldset>
            <label>Email</label><input type="text" name="email" class="username"/></fieldset>
			<br/>
            <fieldset>
                <input name="submit" id="submit" value="Submit" class="login-submit" type="submit"/>
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