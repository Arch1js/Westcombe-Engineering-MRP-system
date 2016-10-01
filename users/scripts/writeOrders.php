<?php
	include ("../dbconnect.php");

	date_default_timezone_set("Europe/London");

	$currentDate=getdate();
	// $todaysDate = "$currentDate[mday]-0$currentDate[mon]-$currentDate[year]"; //gets current date with added formating
	// $todaysDate_replaced = str_replace('/', '-', $todaysDate); //change the date format suitable for database
	// $todaysDateFormated = date("Y-m-d", strtotime($todaysDate_replaced));
	//
	// $todaysDateFormated = '2016-06-13'; // manual date for testing purposes
	// $todaysDate = '13-06-2016';

	// $todaysDateFormated = '2016-06-20'; //same
	// $todaysDate = '20-06-2016';

	$todaysDateFormated = '2016-08-02'; // manual date for testing purposes
	$todaysDate = '02-08-2016';

	$sql = "SELECT Order_Receive_Date FROM orders WHERE Order_Receive_Date IN (SELECT MAX(Order_Receive_Date) FROM orders)";
	$stmt = $mysqli->prepare($sql);
	$stmt->execute();

	$result = $stmt->get_result();
	$data = array();

	while ($row = mysqli_fetch_array($result)) {
		$orderDate = $row['Order_Receive_Date'];
	}

	if($orderDate == $todaysDateFormated) { //if todays date is the same as date in orders table
		return; //do nothing
	}
	else { //write new orders data to database

			$file_location = "../../uploads/$todaysDate.csv"; //location of the orders file

			$handle = fopen($file_location, "r");

			$flag = true;
			while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
			{
				if($flag) { $flag = false; continue; } //skip the first line
				$supplier = $filesop[0];
				$delivery = $filesop[1];
				$quantity = $filesop[2];
				$consignee = $filesop[3];
				$orderline = $filesop[4];

				$date_replaced = str_replace('/', '-', $delivery); //change the date format suitable for database
				$date = date("Y-m-d", strtotime($date_replaced));

				$status = 'Active';

				$sql = "INSERT INTO orders (Supplier_Product_Code, Earliest_Delivery_Date_Time, Order_Quantity, Consignee_Code, Order_Line_Status,Order_Receive_Date, Status) VALUES (?,?,?,?,?,?,?)";
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param("ssissss", $supplier,$date, $quantity,$consignee,$orderline,$todaysDateFormated, $status);
				$stmt->execute();
		}
	}
?>
