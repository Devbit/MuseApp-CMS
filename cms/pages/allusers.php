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
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<link href="../css/blue.css" rel="stylesheet">
	<script src="../js/jquery.tablesorter.min.js"></script>
	<script>
	$(function(){
		$('table').tablesorter({
			theme: 'blue',
			widgets        : ['zebra', 'columns'],
			usNumberFormat : false,
			sortReset      : true,
			sortRestart    : true
		});
	});
	</script>
    <h2>Alle gebruikers</h2>
    <form action="" method="post">
    <table class="tablesorter">
	<thead><tr>
			<th>Selecteren</th>
			<th>Gebruiker</th>
			<th wdit>Email</th>
			<th>Type</th>
			</tr>
	</thead>
	<tbody>
    <?php	if(!$rs = mysql_query("SELECT * FROM users")){echo "Cannot parse query";}
			elseif(mysql_num_rows($rs) == 0) {echo "No records found";} else{while($row = mysql_fetch_array($rs)) {
	echo'

					<tr>
						<td><input name="checkbox[]" type="checkbox" id="checkbox[]" value="'.$row['id'].'"></td>
						<td>'. $row['username'] .'</td>
						<td>'. $row['email'] .'</td>
						<td>';if($row['role'] == 1)echo'Admin';else echo'Gebruiker'; echo'</td>
					</tr>
		';
			}} ?>
	</tbody>
	</table>
    <input type="submit" name="submit" class="save" value="Verwijder geselecteerde" style="margin-right: 120px;"></input>
    </form>
    <?php
	$checkbox = $_POST['checkbox'];
if(isset($_POST['submit'])){
for($i=0;$i<count($checkbox);$i++){
$del_id = $checkbox[$i];
$sql = "DELETE FROM users WHERE id='$del_id'";
$result = mysql_query($sql);
if($result){
echo "<meta http-equiv='refresh'content='0'>";
}
}
}
?>
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