<?php
include ("../dbconnect.php"); //db connection

date_default_timezone_set("Europe/London");

$currentDate=getdate();

$todaysDate = "$currentDate[mday]-0$currentDate[mon]-$currentDate[year]"; //gets current date with added formating
$todaysDate_replaced = str_replace('/', '-', $todaysDate); //change the date format suitable for database
$todaysDateFormated = date("Y-m-d", strtotime($todaysDate_replaced));

// $todaysDateFormated = '2016-08-02';

//get the necessary info from orders table
$sql = "SELECT id, Consignee_Code, Earliest_Delivery_Date_Time, Supplier_Product_Code, Order_Quantity FROM orders WHERE Order_Receive_Date in (SELECT MAX(Order_Receive_Date) from orders);";
$stmt = $mysqli->prepare($sql); //prepare sql

$stmt->execute(); //execute statement
$result = $stmt->get_result();
$stmt->close();
$data = array(); //results stroed in array

while ($row = mysqli_fetch_array($result)) { //loop trough results and store in array
  $data[] = $row;
}

$sql4 = "SELECT makelist_creation_date FROM makelist WHERE makelist_creation_date IN (SELECT MAX(makelist_creation_date) FROM makelist)";
$stmt4 = $mysqli->prepare($sql4);

$stmt4->execute();
$result4 = $stmt4->get_result();
$stmt4->close();
$data4 = array();

while ($row4 = mysqli_fetch_array($result4)) { //loop trough results and store in array
  $makelist_creation_date = $row4['makelist_creation_date'];
}
if($todaysDateFormated == $makelist_creation_date) {
  return;
}
else {
  foreach ($data as $data) { //foreach in orders array
  	$partNo = $data['Supplier_Product_Code']; //setting each rows data to temporary variable for use in later queries
  	$orderQty = $data['Order_Quantity'];
  	$orderID = $data['id'];
  	$customer = $data['Consignee_Code'];
  	$delivery_date = $data['Earliest_Delivery_Date_Time'];

  	$sql2 = "SELECT Finish_Goods_Stock, Description, Trigger_qty, Replenish_qty FROM stock WHERE Finished_Part=?";
  	$stmt2 = $mysqli->prepare($sql2);
  	$stmt2->bind_param("s", $partNo);

  	$stmt2->execute();
  	$result2 = $stmt2->get_result();
  	$stmt2->close();
  	$data2 = array();

  	while ($row2 = mysqli_fetch_array($result2)) { //loop trough results from stock table
  		$data2[] = $row2;
  		$stockQty = $row2['Finish_Goods_Stock'];
  		$description = $row2['Description'];
      $trigger_qty = $row2['Trigger_qty'];
      $replenish_qty = $row2['Replenish_qty'];


  		if($orderQty > $stockQty || $stockQty <= $trigger_qty) {

  			$reqQty = $trigger_qty + abs($stockQty - $orderQty) + $replenish_qty; //get the quantity needed to cover order

  			$status = 'Active'; //sett all makelist items to Active

  			if($stockQty == '') {
  				$stockQty = 0;
  			}

  			$sql3="INSERT INTO makelist (orderID, part_no, description, customer, delivery_date, stock, order_qty, req_qty, trigger_qty, replenish_qty, status, makelist_creation_date)
  			VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
  			$stmt3 = $mysqli->prepare($sql3);
  			$stmt3->bind_param("issssiiiiiss", $orderID, $partNo, $description, $customer, $delivery_date, $stockQty, $orderQty, $reqQty, $trigger_qty, $replenish_qty, $status, $todaysDateFormated);

  			$stmt3->execute();
  			$stmt3->close();

  		}

  	}
  }
}


?>
