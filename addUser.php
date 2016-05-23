<?php
include_once 'dbconnect.php';
$user = 'admin2';
$email='a.dobrajs@gmail.com';
$pass = 'letmein';
$priv = 'admin';
$sql = "INSERT INTO administrators (username, email, password, privilige) VALUES (?,?,md5(?),?)";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param('ssss', $user, $email, $pass, $priv);
$stmt->execute();
?>
