<?php
$connection = mysql_connect("localhost","elektrae_museapp","museappftp") OR die(mysql_error());
$db_select = mysql_select_db("elektrae_museapp",$connection) OR die(mysql_error());
?>