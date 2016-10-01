<?php
$data = file_get_contents("php://input");
require '../dbconnect.php';
$objData = json_decode($data);

$sql = "SELECT Finished_Part, Description, Stores_Location, Raw_Material_Stock, Finish_Goods_Stock FROM stock WHERE Stores_Location=?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $objData->location);

$stmt->execute();
$result = $stmt->get_result();
$data = array();

while ($row = mysqli_fetch_array($result)) {
  $data[] = $row;
}

echo json_encode($data);
$stmt->close();
?>
