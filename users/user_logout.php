<?php
session_start();

if(!isset($_SESSION['user']))
{
	header("Location: /users/login.html");
}
else if(isset($_SESSION['user'])!="")
{
	header("Location: /super_user/index.php");
}

if(isset($_GET['logout']))
{
	session_destroy();
	unset($_SESSION['user']);
	header("Location: /users/login.html");
}
?>
