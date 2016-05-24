<?php
$data = file_get_contents("php://input");
require '../dbconnect.php';
$objData = json_decode($data);

$sql="UPDATE administrators SET username=?,
email=?,
privilige=?
WHERE user_id=?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sssi",$objData->username,
$objData->email,
$objData->privilige,
$objData->userID);

$stmt->execute();
$stmt->close();
?>
