<?php
$data = file_get_contents("php://input");
require '../dbconnect.php';
$objData = json_decode($data);

$sql="UPDATE makelist SET status=?, order_qty=?, req_qty=?, delivery_date=?, comments=? WHERE orderID=?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("siissi", $objData->status, $objData->order_qty, $objData->req_qty, $objData->delivery_date, $objData->comments, $objData->id);

$stmt->execute();
$stmt->close();
?>
