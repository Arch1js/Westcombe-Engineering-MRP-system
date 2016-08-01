<?php
	include ("../dbconnect.php");
	// include('writeOrders.php');
	$data = file_get_contents("php://input");
	$objData = json_decode($data);


$sql = "SELECT DISTINCT makelist_creation_date as week FROM makelist ORDER BY makelist_creation_date DESC";
$stmt = $mysqli->prepare($sql);

$stmt->execute();
$result = $stmt->get_result();
$data = array();

while ($row = mysqli_fetch_array($result)) {
  $data[] = $row;
}
if(empty($data)) {
	echo "Empty";
}
else {
	echo json_encode(array($data));
}

$stmt->close();

?>
