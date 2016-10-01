<?php
include ("../dbconnect.php");

$data = file_get_contents("php://input");
$objData = json_decode($data);


$sql = "SELECT DISTINCT Order_Receive_Date as week FROM orders ORDER BY Order_Receive_Date DESC";
$stmt = $mysqli->prepare($sql);

$stmt->execute();
$result = $stmt->get_result();
$data = array();

while ($row = mysqli_fetch_array($result)) {
  $data[] = $row;
}

echo json_encode(array($data));
$stmt->close();
?>
