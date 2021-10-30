<?php
// includes/thpsecurity is required by thp_classes -- this version is just for demonstration purposes
// it opens the session and checks the permissions of the user.
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL & ~E_NOTICE);

session_start();
include(__DIR__."/menu.php");

$time_start = microtime(true);   // use to track execution time in end_page.php
$today=date("Y-m-d");
$thisyear=date("Y");
$thismonth=date("m");
$thisquarter=floor(($thismonth+2)/3);
if(!($_COOKIE["year"]>1970)) {setcookie("year",$thisyear); $_COOKIE["year"]=$thisyear;}
$year=$_COOKIE["year"];

// Routines to process GET and callbacks
foreach($_GET as $key=>$value) {
	setcookie($key,$value,0,'/');
	$_COOKIE[$key]=$value; // make sure permissions are not handled via $_SESSION
}
function goback($reply){
	$back=$_COOKIE["back"];
	$_SESSION["reply"]=$reply;
	if(!($back>'')) $back="/error";
	header("Location:$back");
}
//Connect to the database
$db = new PDO("sqlite:example.db");
$email="test@test.org"; // clear the session
$can_edit=TRuE; // default for the demo
$admin=TRUE;
function debug($msg,$x) {
	if($_COOKIE["debug"]) {
    	echo("<p>Debug $msg: ");print_r($x);echo("</p>\n");
    }
}
