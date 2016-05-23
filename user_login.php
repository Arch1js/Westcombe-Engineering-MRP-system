<?php
session_start();
include_once 'dbconnect.php';

if(isset($_SESSION['user'])!="")
{
	header("Location: /views/index.php");
}

    $userEmail = $_POST['user'];
    $userPassword = $_POST['pass'];

    $sql = "SELECT user_id, email, password, privilige FROM administrators WHERE email = ? AND password = md5(?)";

    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param('ss', $userEmail, $userPassword);
    $stmt->execute();

    $stmt->store_result();
    $stmt->bind_result($id, $user, $passwd,$privilige);
    if ($stmt->fetch())
    {
			$_SESSION["user"] = $id;
			if($privilige == 'super user') {
				header("Location: /views/index.php");
			}
			else if ($privilige == 'admin') {
				header("Location: /views/admin_page.php");
			}

    }
else
    {
    header("location: /views/login_failed.html");
    }
?>
