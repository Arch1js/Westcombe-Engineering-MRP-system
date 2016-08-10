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
  <title>Makelist - <?php echo $userRow['username'];?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css"><!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.css">
	<link rel="stylesheet" href="../../css/makelist_style.css" type="text/css" /><!-- Stylesheet -->

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
					<img width="70px" height="40px" alt="Westcombe MRP system" src="https://s3-eu-west-1.amazonaws.com/we-asets/westcombe_logo_small.png">
				</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				 <div navbar></div> <!--link to tab directive-->
				<ul class="nav navbar-nav navbar-right">
					<div id="content">
							<?php echo $userRow['username'];?>
								<img id="profile_image" height="300" width="300" src="https://s3-eu-west-1.amazonaws.com/we-asets/photo.png">
								<div ng-show="badge" class="badge"><i class="fa fa-bell-o" aria-hidden="true"></i></div></image>
								<a href="/users/user_logout.php?logout" title="Logout"><i class="fa fa-sign-out fa-lg" aria-hidden="true"></i></a>
						</div>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
<ul class="nav nav-tabs no-print">
  <li class="active"><a data-toggle="tab" href="#Make" ng-click="getMakelist(1, 'Make')">Make</a></li>
  <li><a data-toggle="tab" href="#Supply" ng-click="getMakelist(1, 'Supply')">Supply</a></li>
</ul>
<div editmakelist></div>
<div class="tab-content">
	 <div id="Make" class="tab-pane fade in active">

	<div class="col-md-4 col-sm-4 no-print" id="action_buttons" ng-hide="action_buttons">
		<button type="button" class="btn btn-warning" ng-click="getNewMakelistData()"><span class="fa fa-refresh"></span> Get Data</button>
		<button type="button" class="btn btn-success" ng-click="getPreviousMakelists()"><span class="fa fa-tasks"></span> Load Data</button>
		<button type="button" class="btn btn-danger"  ng-click="editMakelist = !editMakelist"><span class="fa fa-pencil-square-o"></span> Edit</button>
		<button type="button" class="btn btn-primary"  ng-click="printMakelist()"><span class="fa fa-print"></span> Print Jobs</button>
	</div>
	<div class="col-md-1 no-print" ng-hide="ordersWeek">
		<select id="week_selector" class="form-control" ng-model="makelistWeek" ng-init="orderWeek='week'" ng-change="getMakelist(currentPage)">
			<option ng-repeat="i in orderWeekArray" value="{{i.week}}">{{i.week}}</option>
		</select>
	</div>
	<div class="col-md-1 col-sm-5 col-xs-12 no-print" id="page_controller" ng-hide="perPage">
		<select class="form-control" ng-model="pageSizeInput" ng-init="pageSizeInput='10'" ng-change="getMakelist(currentPage, 'Make')">
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
		<pagination total-items="numberOfItems" items-per-page="pageSizeInput"  ng-change="getMakelist(currentPage, 'Make')" ng-model="currentPage" max-size="5" class="pagination-sm"></pagination>
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
		<th>Trigger qty</th>
		<th>Replenish qty</th>
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
		<td>{{i.trigger_qty}}</td>
		<td>{{i.replenish_qty}}</td>
		<td><button ng-class="setStatusColor(i)" class="btn btn-sm">{{i.status}}</button></td>
		<td>{{i.comments}}</td>
		<td><i style="cursor:pointer" class="fa fa-pencil" aria-hidden="true" data-toggle="modal" data-target="#editModal" ng-click="openSelection(i)" ng-show="editMakelist"></i></td>
	</tr>
	</tbody>
</table>
<div id="paginator_bottom" class="col-md-4 col-sm-6 no-print" ng-hide="paginator_bottom">
	<pagination total-items="numberOfItems" items-per-page="pageSizeInput"  ng-change="getMakelist(currentPage, 'Make')" ng-model="currentPage" max-size="5" class="pagination-sm"></pagination>
</div>
</div>

<div id="Supply" class="tab-pane fade">
		<div class="col-md-4 col-sm-4 no-print" id="action_buttons" ng-hide="action_buttons">
			<button type="button" class="btn btn-danger"  ng-click="editMakelist = !editMakelist"><span class="fa fa-pencil-square-o"></span> Edit</button>
			<button type="button" class="btn btn-primary"  ng-click="printMakelist()"><span class="fa fa-print"></span> Print Jobs</button>
		</div>
<div class="col-md-1 no-print" ng-hide="ordersWeek">
 <select id="week_selector" class="form-control" ng-model="makelistWeek" ng-init="orderWeek='week'" ng-change="getMakelist(currentPage, 'Supply')">
	 <option ng-repeat="i in orderWeekArray" value="{{i.week}}">{{i.week}}</option>
 </select>
</div>
<div class="col-md-1 col-sm-5 col-xs-12 no-print" id="page_controller" ng-hide="perPage">
 <select class="form-control" ng-model="pageSizeInput" ng-init="pageSizeInput='10'" ng-change="getMakelist(currentPage, 'Supply')">
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
 <pagination total-items="numberOfItems" items-per-page="pageSizeInput"  ng-change="getMakelist(currentPage, 'Supply')" ng-model="currentPage" max-size="5" class="pagination-sm"></pagination>
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
		 <th>Trigger qty</th>
		 <th>Replenish qty</th>
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
			 <td>{{i.trigger_qty}}</td>
			 <td>{{i.replenish_qty}}</td>
			 <td><button ng-class="setStatusColor(i)" class="btn btn-sm">{{i.status}}</button></td>
			 <td>{{i.comments}}</td>
			 <td><i style="cursor:pointer" class="fa fa-pencil" aria-hidden="true" data-toggle="modal" data-target="#editModal" ng-click="openSelection(i)" ng-show="editMakelist"></i></td>
		</tr>
	</tbody>
</table>
<div id="paginator_bottom" class="col-md-4 col-sm-6 no-print" ng-hide="paginator_bottom">
	<pagination total-items="numberOfItems" items-per-page="pageSizeInput"  ng-change="getMakelist(currentPage)" ng-model="currentPage" max-size="5" class="pagination-sm"></pagination>
</div>
</div>
<div class="alert alert-danger" ng-show="nodataError" class="col-xs-12">
	<strong>Error!</strong> No pending jobs found!
</div>
<div class="alert alert-success" ng-show="dataRefreshSuccess" class="col-xs-12">
	<strong>Awesome!</strong> List is updated with newest jobs! Press 'Load Data' to see them.
</div>
<div loading></div>
</div>
</body>
</html>
