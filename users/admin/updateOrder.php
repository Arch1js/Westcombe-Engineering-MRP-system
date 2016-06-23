<?php
$data = file_get_contents("php://input");
require '../dbconnect.php';
$objData = json_decode($data);

$sql="UPDATE orders SET Comment=?, Status=?
WHERE id=?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ssi", $objData->comment, $objData->status,
$objData->id);

$stmt->execute();
$stmt->close();
?>
