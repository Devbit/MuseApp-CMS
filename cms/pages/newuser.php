<?php
session_start();
require_once("../user.cookies.php");
if($_SESSION["SESS_ROLE"] != 1)header("location: ../home.php");
$username = $_SESSION["SESS_USERNAME"];
require_once('../config.php');

if (isset($_GET['page']))
{$page = 'pages/'.$_GET['page'].'.php';}
else
{$page = 'pages/myplaces.php';}
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>MuseApp</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
		<META NAME="ROBOTS" CONTENT="INDEX, FOLLOW">
        
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link rel="stylesheet" href="../css/normalize.css">
        <link rel="stylesheet" href="../css/main.css">
        <script src="../js/vendor/modernizr-2.6.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

		<div class="wrapper-logo"></div>
        
        <!--Menu-->
        <?php require_once("menu.php");?>
		
        <div class="wrapper">

<?php
$errors = array();

if(isset($_POST["iebugaround"])){

//Ingevulde velden fetchen
$uname = trim(htmlentities($_POST['username']));
$passw = trim(htmlentities($_POST['password']));
$passwc = trim(htmlentities($_POST['passwordcheck']));
$fname = trim(htmlentities($_POST['email']));

// Check voor errors
$query = mysql_query("SELECT username FROM users WHERE username = '". $uname ."'"); 
if (mysql_num_rows($query) > 0) { 
    $errors[] = "De gebruikersnaam is al in gebruik";
} else if(empty($passw)){
	$errors[] = "Vul alstublieft een wachtwoord in.";
} else if(empty($passwc)){
	$errors[] = "Vul alstublieft een validatie wachtwoord in.";
} else if(($passw) != ($passwc)) {
	$errors[] = "Uw validatie wachtwoord komt niet overeen.";
} else if(function_exists('filter_var') && !filter_var($fname, FILTER_VALIDATE_EMAIL)){
	$errors[] = "Verbeter alstublieft uw email.";
}

if(!$errors){

	$passw = $passw;
	$salt = "%765]VZwaZ-|H/4";
	$pepper = "-S8qxBR18Ed0";
	$passencrypt = hash('sha256', $salt . $passw . $pepper); 
	
	$username 		 = mysql_real_escape_string($_POST['username']);
	$password        = mysql_real_escape_string($passencrypt);
	$email      	 = mysql_real_escape_string($_POST['email']);
	$role     	 	 = mysql_real_escape_string($_POST['role']);
	
	$result = mysql_query("INSERT INTO users (id, username, password, email, role) VALUES ('','" . $username . "', '" . $password . "', '" . $email . "', '" . $role . "')") OR die(mysql_error());
	
	if($result_num > 0){
	
		while($row = mysql_fetch_array($result)){
			
			//success lets login to page
			$errors[] = "De registratie was succesvol.";
		
		}
	} 
	
	$errors[] = "De registratie was succesvol.";

}


} else {

$uname = "";

}

?>
<h2>Nieuwe gebruiker</h2><br/>
        <form action="#" method="post" style="margin:10px;">
            		<?php
			if(count($errors) > 0){
				echo "<div style='color:rgb(255, 133, 0);'>";
				foreach($errors as $error){
					echo $error . "<br />";
				}echo "</div>";}
		?><br/>
        	<input name="iebugaround" type="hidden" value="1"> 
            
            <label>Gebruikersnaam</label>
            <fieldset class="fieldset2"><input type="text" name="username" class="requiredField" value="<?php echo $uname ; ?>"/></fieldset>
            
            <label>Wachtwoord</label>
            <fieldset class="fieldset2"><input type="password" name="password" class="text requiredField subject"/></fieldset>
            
            <label>Wachtwoord opnieuw</label>
            <fieldset class="fieldset2"><input type="password" name="passwordcheck" class="text requiredField subject"/></fieldset>
            
            <label>E-mail</label>
            <fieldset class="fieldset2"><input type="text" name="email" class="text requiredField subject"/></fieldset>
            
            <label>Type gebruiker</label>
            <fieldset class="fieldset2"><select name='role'>
				<option value='2'>Gebruiker</option>
				<option value='1'>Admin</option>
			</select></fieldset>
            <br/>
            <fieldset><input name="submit" id="submit" value="Aanmaken" class="button big round deep-red" type="submit"/></fieldset>
        
        </form>
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