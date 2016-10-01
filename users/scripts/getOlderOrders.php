<?php
include ("../dbconnect.php");

$data = file_get_contents("php://input");
$objData = json_decode($data);

// $date = '2016-06-13';
// $start = 0;
// $dataCount= 10;

$sql = "SELECT * FROM orders WHERE Order_Receive_Date=? LIMIT ?,?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sii", $objData->date, $objData->start,$objData->dataCount);

// max(Order_Receive_Date) as Order_Receive_Date,
$sql2 = "SELECT count(*) as count FROM orders WHERE Order_Receive_Date=? ";
$stmt2 = $mysqli->prepare($sql2);
$stmt2->bind_param("s", $objData->date);
// $sql3 = "SELECT DISTINCT Order_Receive_Date as week FROM orders ORDER BY Order_Receive_Date DESC";
// $stmt3 = $mysqli->prepare($sql3);

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

// $stmt3->execute();
// $result3 = $stmt3->get_result();
// $data3 = array();
//
// while ($row3 = mysqli_fetch_array($result3)) {
//   $data3[] = $row3;
// }

echo json_encode(array($data,$data2));
$stmt->close();

?>
