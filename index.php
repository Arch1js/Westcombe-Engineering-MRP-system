<html>
<head>
	<style type="text/css">
	body
	{
		margin: 0;
		padding: 0;
		background-color:#D6F5F5;
		text-align:center;
	}
	.top-bar
		{
			width: 100%;
			height: auto;
			text-align: center;
			background-color:#FFF;
			border-bottom: 1px solid #000;
			margin-bottom: 20px;
		}
	.inside-top-bar
		{
			margin-top: 5px;
			margin-bottom: 5px;
		}
	.link
		{
			font-size: 18px;
			text-decoration: none;
			background-color: #000;
			color: #FFF;
			padding: 5px;
		}
	.link:hover
		{
			background-color: #9688B2;
		}
	</style>


</head>

<body>
    <div style="border:1px dashed #333333; width:300px; margin:0 auto; padding:10px;">

	<form name="import" method="post" enctype="multipart/form-data">
    	<input type="file" name="file" /><br />
        <input type="submit" name="submit" value="Submit" />
    </form>
<?php
	include ("connection.php");

		// $file = $_FILES['file']['tmp_name'];
		$file_location = "C:\\Users\\Arturs\\Desktop\\orders_test2.csv";
		$handle = fopen($file_location, "r");

		$flag = true;
		while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
		{
			if($flag) { $flag = false; continue; }
			$supplier = $filesop[0];
			$delivery = $filesop[1];
			$quantity = $filesop[2];
			$consignee = $filesop[3];
			$orderline = $filesop[4];

			$d = str_replace('/', '-', $delivery);
			$date = date("Y-m-d", strtotime($d));
			// echo $date;
			$sql = mysqli_query($mysqli,"INSERT INTO csv (Supplier_Product_Code, Earliest_Delivery_Date_Time, Order_Quantity, Consignee_Code, Order_Line_Status) VALUES ('$supplier','$date', '$quantity','$consignee','$orderline')");

		}


?>

    </div>
    <hr style="margin-top:300px;" />


</body>
</html>
