<?php
$data = file_get_contents("php://input");
require '../../dbconnect.php';
$objData = json_decode($data);

$password_hash = password_hash("$objData->password", PASSWORD_DEFAULT);

$sql = "INSERT INTO administrators (username, email, password, privilige) VALUES (?,?,?,?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ssss",$objData->username,$objData->email,$password_hash,$objData->privilige);

$stmt->execute();
$stmt->close();
?>
