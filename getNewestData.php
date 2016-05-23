<?php
	include ("dbconnect.php");
	// include('writeOrders.php');
	$data = file_get_contents("php://input");
	$objData = json_decode($data);


$sql = "select * from orders LIMIT ?,?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ii", $objData->start,$objData->dataCount);


$sql2 = "select count(*) as count from orders";
$stmt2 = $mysqli->prepare($sql2);

$sql3 = "select Order_Receive_Date as week from orders LIMIT 1";
$stmt3 = $mysqli->prepare($sql3);

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

$stmt3->execute();
$result3 = $stmt3->get_result();
$data3 = array();

while ($row3 = mysqli_fetch_array($result3)) {
  $data3[] = $row3;
}

echo json_encode(array($data,$data2,$data3));
$stmt->close();

?>
