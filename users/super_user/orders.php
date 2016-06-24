<?php
session_start();
require '../dbconnect.php';

if(!isset($_SESSION['user']))
{
	header("Location: ../validate_session.php");
}
else if($_SESSION["privilige"] != 'super user') {
	header("Location: ../access_denied.html");
}
$res=mysqli_query($mysqli, "SELECT * FROM administrators WHERE user_id=".$_SESSION['user']);
$userRow=mysqli_fetch_array($res);
?>
<html ng-app="WEapp">
<head>
  <title>Welcome - <?php echo $userRow['username'];?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css"><!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.css">
	<link rel="stylesheet" href="../../css/orders_style.css" type="text/css" /><!-- login Stylesheet -->
	<link rel="stylesheet" href="../../css/loader_animation.css" type="text/css" /><!-- login Stylesheet -->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.29/angular.js"></script><!-- AngularJS -->
	<script src="../../dependencies/ui-bootstrap-tpls-1.2.5.js"></script><!-- Bootstrap UI -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script><!-- JQuery -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script><!-- Bootstrap JS -->

	<!-- Services -->
	<script src="../../js/orderFunctions.js"></script>
	<!-- Directives -->
	<script src="../../js/directives.js"></script>
</head>
<body ng-controller="orderCtrl">
	<nav class="navbar navbar-inverse navbar-default">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">
					<img width="70px" height="40px" alt="Westcombe MRP system" src="../../Asets/westcombe_logo_small.png">
				</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="/admin_page.php">Home</a></li>
					<li class="active"><a href="orders.php">Orders</a></li>
					<li><a href="stock.php">Stock</a></li>
					<li><a href="#">Jobs</a></li>
					<li><a href="#">Metrics</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<div id="content">
							<?php echo $userRow['username'];
								$username= $userRow['username'];
								require '../dbconnect.php';
								$res=mysqli_query($mysqli,"SELECT * FROM administrators WHERE user_id=".$_SESSION['user']);
								echo '<img id="profile_image" height="300" width="300" src="../../Asets/photo.png">';
								?>
								<a href="../user_logout.php?logout" title="Logout"><i class="fa fa-sign-out fa-lg" aria-hidden="true"></i></a>
						</div>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
	<!-- Edit Modal -->
	<div class="modal fade" id="editModal" role="dialog">
			<div class="modal-dialog modal-lg">
	<!-- Modal content-->
	<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
					<img width="100px" height="40px" alt="Brand" src="../../Asets/westcombe.png"><!-- Logo -->
	</div>
	<div class="modal-body">
	<form class="form-inline" role="form">
		<div id="change_form" class="form-group">
		<div class="col-md-4 col-sm-4">
			<label>ID: </label>
			<input type="text" class="form-control" maxlength="20" ng-model="record.id" disabled/>
		</div>
		<div class="col-md-4 col-sm-4">
			<label>Supplier product code: </label>
			<input type="text" class="form-control" maxlength="20" ng-model="record.Supplier_Product_Code" disabled/>
		</div>
			<div class="col-md-3 col-sm-3">
			<label>Earliest Delivery Date: </label>
			<input type="text" class="form-control" maxlength="5" ng-model="record.Earliest_Delivery_Date_Time" disabled/>
		</div>
		</div>
	</form>
	<form class="form-inline" role="form">
		<div id="change_form" class="form-group">
		<div class="col-md-4 col-sm-4">
			<label>Order Quantity: </label>
			<input type="text" class="form-control" maxlength="38" ng-model="record.Order_Quantity" disabled/>
		</div>
		<div class="col-md-4 col-sm-4">
			<label>Consignee Code: </label>
			<input type="text" class="form-control" maxlength="9" ng-model="record.Consignee_Code" disabled/>
		</div>
		<div class="col-md-3 col-sm-3">
			<label>Order Line Status: </label>
			<input type="text" class="form-control" maxlength="50" ng-model="record.Order_Line_Status" disabled/>
		</div>
		</div>
	</form>
	<form class="form-inline" role="form">
		<div id="change_form" class="form-group">
			<div class="col-md-7 col-sm-5">
				<label>Comments (max lenght 120 char): </label>
				<textarea type="text" class="form-control" maxlength="120" ng-model="record.Comment"rows="6" cols="40"></textarea>
			</div>
			<div class="col-md-4 col-sm-4">
				<label>Status: </label>
				<select class="form-control" ng-model="record.Status">
					<option value="Active">Active</option>
					<option value="Pending">Pending</option>
					<option value="On-Hold">On-Hold</option>
				</select>
			</div>
		</div>
	</form>
	</div>
	<div class="modal-footer">
	<button type="submit" class="btn btn-success" data-dismiss="modal" ng-click="updateOrder(record)">Save changes</button>
		<button type="button" class="btn btn-warning" data-toggle="modal" data-dismiss="modal">Cancel</button>
	</div>
</div>
</div>
</div>
	<div class="col-md-3 col-sm-4" id="action_buttons">
		<button type="button" class="btn btn-warning" ng-click="getNewestData()">Refresh Data</button>
		<button type="button" class="btn btn-success" ng-click="loadData(1)">Load Data</button>
		<button type="button" class="btn btn-danger"  ng-click="editOrder = !editOrder">Edit</button>
	</div>
	<div class="col-md-1" ng-show="ordersWeek">
		<p>Week of {{orderWeek}}</p>
	</div>
	<div class="col-md-1 col-sm-5 col-xs-12" id="page_controller">
		<select class="form-control" ng-model="pageSizeInput" ng-init="pageSizeInput='10'" ng-change="loadData(currentPage)">
				<option value="10" selected>10</option>
				<option value="25">25</option>
				<option value="50">50</option>
				<option value="100">100</option>
		</select>
	</div>
	<div id="paginator_top" class="col-md-4 col-sm-6">
		<div id="pageCounter">
			<p>Page {{currentPage}} of {{numberOfItems/pageSizeInput | roundup}}</p>
		</div>
		<pagination total-items="numberOfItems" items-per-page="pageSizeInput"  ng-change="loadData(currentPage)" ng-model="currentPage" max-size="5" class="pagination-sm"></pagination>
	</div>
<table class="table table-striped">
	<thead>
		<tr>
		<th>ID</th>
		<th>Supplier Product Code</th>
		<th>Earliest Delivery Date/Time</th>
		<th>Order Quantity</th>
		<th>Consignee Code</th>
		<th>Order Line Status</th>
		<th>Status</th>
		<th>Comment</th>
	</tr>
</thead>
<tbody ng-show="table_body">
	<tr ng-repeat="i in data | start: (currentPage - 1) * pageSizeInput | limitTo: pageSizeInput">
		<td>{{i.id}}</td>
		<td>{{i.Supplier_Product_Code}}</td>
		<td>{{i.Earliest_Delivery_Date_Time}}</td>
		<td>{{i.Order_Quantity}}</td>
		<td>{{i.Consignee_Code}}</td>
		<td>{{i.Order_Line_Status}}</td>
		<td>{{i.Status}}</td>
		<td>{{i.Comment}}</td>
		<td><i style="cursor:pointer" class="fa fa-pencil" aria-hidden="true" data-toggle="modal" data-target="#editModal" ng-click="openSelection(i)" ng-show="editOrder"></i></td>
	</tr>
	</tbody>
</table>
<div id="paginator_bottom" class="col-md-4 col-sm-6" ng-show="paginator_bottom">
	<pagination total-items="numberOfItems" items-per-page="pageSizeInput"  ng-change="loadData(currentPage)" ng-model="currentPage" max-size="5" class="pagination-sm"></pagination>
</div>
<div loading></div>
	<div class="alert alert-danger" ng-show="dataQueryError" class="col-xs-12">
		<strong>Error!</strong> No results found in database!
	</div>
	<div class="alert alert-danger" ng-show="refreshError" class="col-xs-12">
		<strong>Error!</strong> Order data is up to date!
	</div>
</body>
</html>
