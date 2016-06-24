<?php
$data = file_get_contents("php://input");
require '../dbconnect.php';
$objData = json_decode($data);

$sql = "select * from stock LIMIT ?,?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ii", $objData->start,$objData->dataCount);

$sql2 = "select count(*) as count from stock";
$stmt2 = $mysqli->prepare($sql2);

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
