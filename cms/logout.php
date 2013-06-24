<?php
session_start();

//redirect function
function returnheader($location){
	$returnheader = header("location: $location");
	return $returnheader;
}

include_once 'config.php';

// destroy cookies and sessions
setcookie("userloggedin", "");
$username = "";
session_destroy();

//redirect
returnheader("index.php");

?>