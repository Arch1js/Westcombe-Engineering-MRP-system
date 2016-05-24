<?php
$data = file_get_contents("php://input");
require '../dbconnect.php';
$objData = json_decode($data);

$sql = "INSERT INTO administrators (username, email, password, privilige) VALUES (?,?,md5(?),?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ssss",$objData->username,$objData->email,$objData->password,$objData->privilige);

$stmt->execute();
$stmt->close();
?>
