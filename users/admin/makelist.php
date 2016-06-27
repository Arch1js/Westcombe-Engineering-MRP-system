<?php
session_start();
require '../dbconnect.php';

if(!isset($_SESSION['user']))
{
	header("Location: ../validate_session.php");
}
else if($_SESSION["privilige"] != 'admin') {
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
	<link rel="stylesheet" href="../../css/makelist_style.css" type="text/css" /><!-- Stylesheet -->
	<link rel="stylesheet" href="../../css/loader_animation.css" type="text/css" /><!-- Stylesheet -->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.29/angular.js"></script><!-- AngularJS -->
	<script src="../../dependencies/ui-bootstrap-tpls-1.2.5.js"></script><!-- Bootstrap UI -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script><!-- JQuery -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script><!-- Bootstrap JS -->

	<!-- Services -->
	<script src="../../js/makelistFunctions.js"></script>
	<!-- Directives -->
	<script src="../../js/directives.js"></script>
</head>
<body ng-controller="makelistCtrl">
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
					<li><a href="/users/admin/admin_page.php">Home</a></li>
					<li><a href="/users/admin/manageUsers.php">Users</a></li>
					<li><a href="/users/admin/orders.php">Orders</a></li>
					<li><a href="/users/admin/stock.php">Stock</a></li>
					<li class="active"><a href="/users/admin/makelist.php">Makelist</a></li>
					<li><a href="/users/admin/metrics.php">Metrics</a></li>
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
			<label> Order ID: </label>
			<input type="text" class="form-control" maxlength="20" ng-model="record.orderID" disabled/>
		</div>
		<div class="col-md-4 col-sm-4">
			<label>Part number: </label>
			<input type="text" class="form-control" maxlength="20" ng-model="record.part_no" disabled/>
		</div>
			<div class="col-md-2 col-sm-3">
				<label>Status: </label>
				<select class="form-control" ng-model="record.status">
					<option value="Active">Active</option>
					<option value="Pending">Pending</option>
					<option value="On-Hold">On-Hold</option>
				</select>
		</div>
		</div>
	</form>
	<form class="form-inline" role="form">
		<div id="change_form" class="form-group">
		<div class="col-md-3 col-sm-4">
			<label>Stock Qty: </label>
			<input type="text" class="form-control" maxlength="38" ng-model="record.stock" disabled/>
		</div>
		<div class="col-md-3 col-sm-4">
			<label>Order Qty: </label>
			<input type="text" class="form-control" maxlength="9" ng-model="record.order_qty"/>
		</div>
		<div class="col-md-4 col-sm-3">
			<label>Required Qty: </label>
			<input type="text" class="form-control" maxlength="50" ng-model="record.req_qty"/>
		</div>
		</div>
	</form>
	<form class="form-inline" role="form">
		<div id="change_form" class="form-group">
		<div class="col-md-4 col-sm-4">
			<label>Customer id: </label>
			<input type="text" class="form-control" maxlength="38" ng-model="record.customer" disabled/>
		</div>
		<div class="col-md-4 col-sm-4">
			<label>Delivery date: </label>
			<input type="text" class="form-control" maxlength="10" ng-model="record.delivery_date"/>
		</div>
		</div>
	</form>
	<form class="form-inline" role="form">
		<div id="change_form" class="form-group">
			<div class="col-md-6 col-sm-5">
				<label>Product description: </label>
				<textarea type="text" class="form-control" maxlength="120" ng-model="record.description"rows="6" cols="40" disabled></textarea>
			</div>
			<div class="col-md-6 col-sm-5">
				<label>Comments (max lenght 120 char): </label>
				<textarea type="text" class="form-control" maxlength="120" ng-model="record.comments"rows="6" cols="40"></textarea>
			</div>
		</div>
	</form>
	</div>
	<div class="modal-footer">
	<button type="submit" class="btn btn-success" data-dismiss="modal" ng-click="updateMakelist(record)">Save changes</button>
		<button type="button" class="btn btn-warning" data-toggle="modal" data-dismiss="modal">Cancel</button>
	</div>
</div>
</div>
</div>
	<div class="col-md-4 col-sm-4 no-print" id="action_buttons" ng-hide="action_buttons">
		<button type="button" class="btn btn-warning" ng-click="getNewMakelistData()"><span class="fa fa-refresh"></span> Get Data</button>
		<button type="button" class="btn btn-success" ng-click="getMakelist(1)"><span class="fa fa-tasks"></span> Load Data</button>
		<button type="button" class="btn btn-danger"  ng-click="editOrder = !editOrder"><span class="fa fa-pencil-square-o"></span> Edit</button>
		<button type="button" class="btn btn-primary"  ng-click="printMakelist()"><span class="fa fa-print"></span> Print Jobs</button>
	</div>
	<div class="col-md-1 col-sm-5 col-xs-12 no-print" id="page_controller" ng-hide="perPage">
		<select class="form-control" ng-model="pageSizeInput" ng-init="pageSizeInput='10'" ng-change="getMakelist(currentPage)">
				<option value="10" selected>10</option>
				<option value="25">25</option>
				<option value="50">50</option>
				<option value="100">100</option>
		</select>
	</div>
	<div id="paginator_top" class="col-md-4 col-sm-6 no-print" ng-hide="paginator">
		<div id="pageCounter">
			<p>Page {{currentPage}} of {{numberOfItems/pageSizeInput | roundup}}</p>
		</div>
		<pagination total-items="numberOfItems" items-per-page="pageSizeInput"  ng-change="getMakelist(currentPage)" ng-model="currentPage" max-size="5" class="pagination-sm"></pagination>
	</div>
<table class="table table-striped">
	<thead>
		<tr>
		<th>Order ID</th>
		<th>Part number</th>
		<th>Description</th>
		<th>Customer</th>
		<th>Delivery Date</th>
		<th>Stock</th>
		<th>Order qty</th>
		<th>Required qty</th>
		<th>Status</th>
		<th>Comments</th>
	</tr>
</thead>
<tbody ng-show="table_body">
	<tr ng-repeat="i in data | start: (currentPage - 1) * pageSizeInput | limitTo: pageSizeInput">
		<td>{{i.orderID}}</td>
		<td>{{i.part_no}}</td>
		<td>{{i.description}}</td>
		<td>{{i.customer}}</td>
		<td>{{i.delivery_date}}</td>
		<td>{{i.stock}}</td>
		<td>{{i.order_qty}}</td>
		<td>{{i.req_qty}}</td>
		<td>{{i.status}}</td>
		<td>{{i.comments}}</td>
		<td><i style="cursor:pointer" class="fa fa-pencil" aria-hidden="true" data-toggle="modal" data-target="#editModal" ng-click="openSelection(i)" ng-show="editOrder"></i></td>
	</tr>
	</tbody>
</table>
<div id="paginator_bottom" class="col-md-4 col-sm-6 no-print" ng-hide="paginator_bottom">
	<pagination total-items="numberOfItems" items-per-page="pageSizeInput"  ng-change="getMakelist(currentPage)" ng-model="currentPage" max-size="5" class="pagination-sm"></pagination>
</div>
<div loading></div>
<div class="alert alert-danger" ng-show="nodataError" class="col-xs-12">
	<strong>Error!</strong> No pending jobs found!
</div>
<div class="alert alert-success" ng-show="dataRefreshSuccess" class="col-xs-12">
	<strong>Awesome!</strong> List is updated with newest jobs! Press 'Load Data' to see them.
</div>
</body>
</html>
