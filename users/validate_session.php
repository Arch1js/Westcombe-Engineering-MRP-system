<?php
session_start();
include_once 'dbconnect.php';

if(isset($_SESSION['user'])!="")
{
	header("Location: /login.html");
}

    $userEmail = $_POST['user'];
    $userPassword = $_POST['pass'];

    $sql = "SELECT user_id, email, password FROM administrators WHERE email = ? AND password = md5(?)";

    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param('ss', $userEmail, $userPassword);
    $stmt->execute();

    $stmt->store_result();
    $stmt->bind_result($id, $user, $passwd);
    if ($stmt->fetch())
    {
			$_SESSION["user"] = $id;
			header("Location: /users/super_user/index.php");
    }
else
    {
    header("location: /users/access_denied.html");
    }
    ?>
