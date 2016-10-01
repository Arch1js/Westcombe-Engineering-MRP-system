<?php
include ("../dbconnect.php"); //db connection

date_default_timezone_set("Europe/London");

$timestamp = date("Y-m-d H:i:s"); //gets current date with added formating

$data = file_get_contents("php://input");
$objData = json_decode($data);

$sql="UPDATE stock SET Finish_Goods_Stock=? WHERE Finished_Part=? AND Stores_Location=?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("iss",$objData->newQty,
$objData->partNo,
$objData->location);

$stmt->execute();
$stmt->close();

$sql="INSERT INTO stockTake (user, changeTime, part, stockQty_Before, stockQty_After) VALUES (?,?,?,?,?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sssii",$objData->user,$timestamp,$objData->partNo,$objData->oldQty,$objData->newQty);

$stmt->execute();
$stmt->close();
?>
