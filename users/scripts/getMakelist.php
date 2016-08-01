<?php
	include ("../dbconnect.php");
	// include('writeOrders.php');
	$data = file_get_contents("php://input");
	$objData = json_decode($data);
// $start = 0;
// $dataCount = 2;

$sql = "SELECT * FROM makelist WHERE makelist_creation_date = ? LIMIT ?,?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sii", $objData->date, $objData->start,$objData->dataCount);


$sql2 = "SELECT count(*) as count FROM makelist WHERE makelist_creation_date = ?";
$stmt2 = $mysqli->prepare($sql2);
$stmt2->bind_param("s", $objData->date);


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
