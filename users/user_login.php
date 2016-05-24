<?php
session_start();
include_once 'dbconnect.php';

if(isset($_SESSION['user'])!="")
{
	header("Location: /login.php");
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
			$_SESSION["privilige"] = $privilige;
			if($privilige == 'admin') {
				header("Location: /users/admin/admin_page.php");
			}
			else if ($privilige == 'super user') {
				header("Location: /users/super_user/index.php");
			}
			else if ($privilige == 'user') {
				header("Location: /users/user/main.php");
			}

    }
else
    {
    header("location: /users/login_failed.html");
    }
?>
