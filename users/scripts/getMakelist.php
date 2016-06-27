<?php
	include ("../dbconnect.php");
	// include('writeOrders.php');
	$data = file_get_contents("php://input");
	$objData = json_decode($data);
// $start = 0;
// $dataCount = 2;

$sql = "select * from makelist LIMIT ?,?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ii", $objData->start,$objData->dataCount);


$sql2 = "select count(*) as count from makelist";
$stmt2 = $mysqli->prepare($sql2);


$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$data = array();

while ($row = mysqli_fetch_array($result)) {
  $data[] = $row;
}

$stmt2->execute();
$result2 = $stmt2->get_result();
$stmt2->close();
$data2 = array();

while ($row2 = mysqli_fetch_array($result2)) {
  $data2[] = $row2;
}


echo json_encode(array($data,$data2));


?>
