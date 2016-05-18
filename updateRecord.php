<?php
$data = file_get_contents("php://input");
require 'dbconnect.php';
$objData = json_decode($data);

$sql="UPDATE stock SET Casting_or_Supplier_Pt_No=?,
Finished_Part=?,
Description=?,
Qty_s_BOM=?,
Additional_Info=?,
Stores_Location=?,
Finished_Part_Weight_Kg=?,
P_P_Cost_Raw=?,
Selling_Price=?,
Rejects_Scrap=?,
Raw_Material_Stock=?,
Finish_Goods_Stock=?,
Current_Total_Stock=?,
Supplier=?
WHERE ID=?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sssisssiiiiiisi", $objData->Casting_Supplier_part_no,
$objData->Finished_part_no,
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
$objData->Current_total_stock,
$objData->Supplier,
$objData->ID);

$stmt->execute();
$stmt->close();
?>
