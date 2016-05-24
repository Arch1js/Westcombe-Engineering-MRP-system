<?php
	include ("../dbconnect.php");

	date_default_timezone_set("Europe/London");

	$currentDate=getdate();
	$todaysDate = "$currentDate[mday]-0$currentDate[mon]-$currentDate[year]"; //gets current date with added formating
	$todaysDate_replaced = str_replace('/', '-', $todaysDate); //change the date format suitable for database
	$todaysDateFormated = date("Y-m-d", strtotime($todaysDate_replaced));
	// $todaysDateFormated = '2016-05-30';
	// $todaysDate = '30-05-2016';

	$sql = "SELECT Order_Receive_Date FROM orders LIMIT 1";
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
		$sql2 = "DELETE FROM orders";
		$stmt2 = $mysqli->prepare($sql2);
		$stmt2->execute();
			// $file_location = "https://drive.google.com/uc?export=download&id=0B-KUtsSOioNecTZCNFdSRElIV1U"; //location of the orders file using google drive for hosting
			$file_location = "C:\\Users\\Arturs\\Desktop\\$todaysDate.csv"; //location of the orders file

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

				$sql = "INSERT INTO orders (Supplier_Product_Code, Earliest_Delivery_Date_Time, Order_Quantity, Consignee_Code, Order_Line_Status,Order_Receive_Date) VALUES (?,?,?,?,?,?)";
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param("ssisss", $supplier,$date, $quantity,$consignee,$orderline,$todaysDateFormated);
				$stmt->execute();
		}

	}

?>
