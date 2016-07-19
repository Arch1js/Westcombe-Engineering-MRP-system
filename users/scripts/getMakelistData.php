<?php
include ("../dbconnect.php"); //db connection

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

foreach ($data as $data) { //foreach in orders array
	$partNo = $data['Supplier_Product_Code']; //setting each rows data to temporaru variable for use in later queries
	$orderQty = $data['Order_Quantity'];
	$orderID = $data['id'];
	$customer = $data['Consignee_Code'];
	$delivery_date = $data['Earliest_Delivery_Date_Time'];

	$sql2 = "SELECT Finish_Goods_Stock, Description FROM stock WHERE Finished_Part=?";
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


		if($orderQty >= $stockQty) {

			$reqQty = abs($stockQty - $orderQty); //get the quantity needed to cover order
			$status = 'Active'; //sett all makelist items to Active

			if($stockQty == '') {
				$stockQty = 0;
			}

      date_default_timezone_set("Europe/London");

    	$currentDate=getdate();
      
      $todaysDate = "$currentDate[mday]-0$currentDate[mon]-$currentDate[year]"; //gets current date with added formating
      $todaysDate_replaced = str_replace('/', '-', $todaysDate); //change the date format suitable for database
      $todaysDateFormated = date("Y-m-d", strtotime($todaysDate_replaced));

			$sql3="INSERT INTO makelist (orderID, part_no, description, customer, delivery_date, stock, order_qty, req_qty, status, makelist_creation_date)
			VALUES(?,?,?,?,?,?,?,?,?,?)";
			$stmt3 = $mysqli->prepare($sql3);
			$stmt3->bind_param("issssiiiss", $orderID, $partNo, $description, $customer, $delivery_date, $stockQty, $orderQty, $reqQty, $status, $todaysDateFormated);

			$stmt3->execute();
			$stmt3->close();

			// echo ' (We dont have enough in stock, so wee need to make more)';
			// echo '<br>';
		}
		// else if ($orderQty < $stockQty){
		// // 	echo '(We have enough in stock to cover order)';
		// // 	echo '<br>';
		// }
		// else {
		// 	echo 'error';
		// 	echo '<br>';
		// }
	}
}

// echo json_encode(array($data,$data2,$data3));

?>
