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
  <title>Purchase List - <?php echo $userRow['username'];?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css"><!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.css">
	<link rel="stylesheet" href="../../css/orders_style.css" type="text/css" /><!-- login Stylesheet -->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.29/angular.js"></script><!-- AngularJS -->
	<script src="../../dependencies/ui-bootstrap-tpls-1.2.5.js"></script><!-- Bootstrap UI -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script><!-- JQuery -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script><!-- Bootstrap JS -->

	<!-- Services -->
	<script src="../../js/purchaseFunctions.js"></script>
	<!-- Directives -->
	<script src="../../js/directives.js"></script>
</head>
<body ng-controller="purchaseCtrl">
	<div navbar></div> <!--link to tab directive-->
	<div editorder></div>
		<div class="col-md-5 col-sm-4 no-print" id="action_buttons" ng-hide="action_buttons">
			<button type="button" class="btn btn-warning" ng-click="getNewestData()"><span class="fa fa-refresh"></span> Refresh Data</button>
			<button type="button" class="btn btn-success" ng-click="loadData(1)"><span class="fa fa-tasks"></span> Load Data</button>
			<button type="button" class="btn btn-danger"  ng-click="editOrder = !editOrder"><span class="fa fa-pencil-square-o"></span> Edit</button>
			<button type="button" class="btn btn-primary"  ng-click="printOrder()"><span class="fa fa-print"></span> Print List</button>
		</div>

		<div class="col-md-1 no-print" ng-hide="ordersWeek">
			<select id="week_selector" class="form-control" ng-model="orderWeek" ng-init="orderWeek='week'" ng-change="getOlderOrders()">
				<option ng-repeat="i in orderWeekArray" value="{{i.week}}">{{i.week}}</option>
			</select>
		</div>
		<div class="col-md-1 col-sm-5 col-xs-12 no-print" id="page_controller" ng-hide="perPage">
			<select class="form-control" ng-model="pageSizeInput" ng-init="pageSizeInput='10'" ng-change="loadData(currentPage)">
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
			<pagination total-items="numberOfItems" items-per-page="pageSizeInput"  ng-change="loadData(currentPage)" ng-model="currentPage" max-size="5" class="pagination-sm"></pagination>
		</div>
	<div class="table-responsive">
	<table class="table table-striped">
		<thead>
			<tr>
			<th>ID</th>
			<th ng-click="sort('Supplier_Product_Code')">Supplier Product Code <span class="glyphicon sort-icon" ng-show="sortKey=='Supplier_Product_Code'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
			<th ng-click="sort('Earliest_Delivery_Date_Time')">Earliest Delivery Date/Time<span class="glyphicon sort-icon" ng-show="sortKey=='Earliest_Delivery_Date_Time'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
			<th>Order Receive Date</th>
			<th>Order Quantity</th>
			<th>Consignee Code</th>
			<th>Order Line Status</th>
			<th>Status</th>
			<th>Comment</th>
		</tr>
	</thead>
	<tbody ng-show="table_body">
		<tr ng-repeat="i in data | start: (currentPage - 1) * pageSizeInput | limitTo: pageSizeInput | orderBy:sortKey:reverse">
			<td>{{i.id}}</td>
			<td>{{i.Supplier_Product_Code}}</td>
			<td>{{i.Earliest_Delivery_Date_Time}}</td>
			<td>{{i.Order_Receive_Date}}</td>
			<td>{{i.Order_Quantity}}</td>
			<td>{{i.Consignee_Code}}</td>
			<td>{{i.Order_Line_Status}}</td>
			<td><button ng-class="setStatusColor(i)" class="btn btn-sm">{{i.Status}}</button></td>
			<td>{{i.Comment}}</td>
			<td><i style="cursor:pointer" class="fa fa-pencil" aria-hidden="true" data-toggle="modal" data-target="#editModal" ng-click="openSelection(i)" ng-show="editOrder"></i></td>
		</tr>
		</tbody>
	</table>
	</div>
	<div id="paginator_bottom" class="col-md-4 col-sm-6 no-print" ng-hide="paginator_bottom">
		<pagination total-items="numberOfItems" items-per-page="pageSizeInput"  ng-change="loadData(currentPage)" ng-model="currentPage" max-size="5" class="pagination-sm"></pagination>
	</div>
	<div loading></div>
		<div class="alert alert-danger" ng-show="dataQueryError" class="col-xs-12">
			<strong>Error!</strong> No results found in database!
		</div>
		<div class="alert alert-danger" ng-show="refreshError" class="col-xs-12">
			<strong>Error!</strong> Order data is up to date!
		</div>
		<div class="alert alert-success" ng-show="refreshSuccess" class="col-xs-12">
			<strong>Success!</strong> Database is up to date!
		</div>
</body>
</html>
