<?php
$data = file_get_contents("php://input");
require '../dbconnect.php';


$sql = "SELECT 'Raw material' as Title, SUM(P_P_Cost_Raw * Raw_Material_Stock) AS Stock from stock";
$stmt = $mysqli->prepare($sql);

$sql2 = "SELECT 'Finished goods' as Title, SUM(Selling_Price * Finish_Goods_Stock) AS Stock from stock";
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

while ($row = mysqli_fetch_array($result2)) {
  $data2[] = $row;
}

echo json_encode(array($data,$data2, JSON_PRETTY_PRINT));
$stmt->close();

?>
