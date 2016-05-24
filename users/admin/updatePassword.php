<?php
$data = file_get_contents("php://input");
require '../dbconnect.php';
$objData = json_decode($data);

$sql="UPDATE administrators SET password=md5(?) WHERE user_id=?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("si",$objData->password,$objData->userID);

$stmt->execute();
$stmt->close();
?>
