<?php
$data = file_get_contents("php://input");
require '../dbconnect.php';
$objData = json_decode($data);

$sql = "select * from stock WHERE
Finished_Part LIKE ? OR
Casting_or_Supplier_Pt_No LIKE ? OR
Description LIKE ? OR
Additional_Info LIKE ? OR
Stores_Location LIKE ? OR
Supplier LIKE ? LIMIT ?,?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ssssssii",
$objData->quick,
$objData->quick,
$objData->quick,
$objData->quick,
$objData->quick,
$objData->quick,
$objData->start,
$objData->dataCount);

$sql2 = "select count(*) as count from stock WHERE
Finished_Part LIKE ? OR
Casting_or_Supplier_Pt_No LIKE ? OR
Description LIKE ? OR
Additional_Info LIKE ? OR
Stores_Location LIKE ? OR
Supplier LIKE ?";
$stmt2 = $mysqli->prepare($sql2);
$stmt2->bind_param("ssssss",
$objData->quick,
$objData->quick,
$objData->quick,
$objData->quick,
$objData->quick,
$objData->quick);


$stmt->execute();
$result = $stmt->get_result();
$data = array();

while ($row = mysqli_fetch_array($result)) {
  $data[] = $row;
}

$stmt2->execute();
$result2 = $stmt2->get_result();
$data2 = array();

while ($row2 = mysqli_fetch_array($result2)) {
  $data2[] = $row2;
}

echo json_encode(array($data,$data2));

$stmt->close();

?>
