<?php
$data = file_get_contents("php://input");
require '../../dbconnect.php';
$objData = json_decode($data);

$sql = "DELETE FROM administrators WHERE user_id=?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i",$objData->userID);

$stmt->execute();
$stmt->close();
?>
