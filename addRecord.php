<?php
$data = file_get_contents("php://input");
require 'dbconnect.php';
$objData = json_decode($data);

$sql="INSERT INTO stock(
Casting_or_Supplier_Pt_No,
Description,
Qty_s_BOM,
Additional_Info,
Stores_Location,
Finished_Part_Weight_Kg,
P_P_Cost_Raw,
Selling_Price,
Rejects_Scrap,
Raw_Material_Stock,
Finish_Goods_Stock,
Finished_Part,
Current_Total_Stock,
Supplier)
VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ssisssiiiiisis", $objData->Casting_Supplier_part_no,
$objData->Description,
$objData->BOM,
$objData->Additional_Info,
$objData->Stores_Location,
$objData->Finished_part_weight,
$objData->P_P_Cost_Raw,
$objData->Selling_Price,
$objData->Rejects_Scrap,
$objData->Raw_Material_Stock,
$objData->Finished_goods_stock,
$objData->Finished_part_no,
$objData->Current_total_stock,
$objData->Supplier);
$stmt->execute();
$stmt->close();
?>
