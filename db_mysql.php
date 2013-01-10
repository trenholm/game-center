<?php 
$url = '';
$usr = '';
$pwd = '';
$db = '';

$con = mysql_connect($url,$usr,$pwd);
if (!$con) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db($db, $con);
?>