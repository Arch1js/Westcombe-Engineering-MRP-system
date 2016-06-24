<?php
$data = file_get_contents("php://input");
require '../../dbconnect.php';
$objData = json_decode($data);

$password_hash = password_hash("$objData->password", PASSWORD_DEFAULT);

$sql="UPDATE administrators SET password=? WHERE user_id=?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("si",$password_hash,$objData->userID);

$stmt->execute();
$stmt->close();
?>
