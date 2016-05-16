<?php
session_start();

if(!isset($_SESSION['user']))
{
	header("Location: /views/login.html");
}
else if(isset($_SESSION['user'])!="")
{
	header("Location: /views/index.php");
}

if(isset($_GET['logout']))
{
	session_destroy();
	unset($_SESSION['user']);
	header("Location: /views/login.html");
}
?>
