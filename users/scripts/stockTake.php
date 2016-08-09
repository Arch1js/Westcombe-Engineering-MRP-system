<?php
$data = file_get_contents("php://input");
require '../dbconnect.php';
$objData = json_decode($data);

$sql="UPDATE stock SET Finish_Goods_Stock=? WHERE Finished_Part=? AND Stores_Location=?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("iss",$objData->newQty,
$objData->partNo,
$objData->location);

$stmt->execute();
$stmt->close();
?>
