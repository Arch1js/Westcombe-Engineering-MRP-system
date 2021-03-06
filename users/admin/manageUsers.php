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
$res=mysqli_query($mysqli, "SELECT username FROM administrators WHERE user_id=".$_SESSION['user']);
$userRow=mysqli_fetch_array($res);
?>
<html ng-app="WEapp">
<head>
  <title>Manage - <?php echo $userRow['username'];?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css"><!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.css">
	<link rel="stylesheet" href="../../css/user_style.css" type="text/css" /><!-- user Stylesheet -->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.29/angular.js"></script><!-- AngularJS -->
	<script src="../../dependencies/ui-bootstrap-tpls-1.2.5.js"></script><!-- Bootstrap UI -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script><!-- JQuery -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script><!-- Bootstrap JS -->

	<!-- Services -->
	<script src="../../js/adminFunctions.js"></script>
	<!-- Directives -->
	<script src="../../js/directives.js"></script>
</head>
<body ng-controller="adminCtrl">
	<div navbar></div> <!--link to tab directive-->
	<!-- Edit Modal directive-->
	<div edit></div>
	<!-- Add Modal directive-->
	<div add></div>
	<!-- Delete Modal directive -->
	<div delete></div>
	<div class="col-md-4" id="action_buttons">
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModal"><span class="fa fa-plus"></span> Add user</button>
		<button type="button" class="btn btn-warning" ng-click="edituser = !edituser"><span class="fa fa-pencil-square-o"></span> Edit user</button>
	</div>
	<div class="col-md-1" ng-show="ordersWeek">
		<p>Week of {{orderWeek}}</p>
	</div>
	<div class="col-md-1 col-sm-5 col-xs-12" id="page_controller">
		<select class="form-control" ng-model="pageSizeInput" ng-init="pageSizeInput='10'" ng-change="loadUsers(currentPage)">
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
		<pagination total-items="numberOfItems" items-per-page="pageSizeInput"  ng-change="loadUsers(currentPage)" ng-model="currentPage" max-size="5" class="pagination-sm"></pagination>
	</div>
	<table class="table table-striped">
		<thead>
			<tr>
			<th>User ID</th>
			<th>Username</th>
			<th>Email Address</th>
			<th>Password (Hash)</th>
			<th>Privilege</th>
		</tr>
	</thead>
	<tbody ng-show="table_body">
		<tr ng-repeat="i in data | start: (currentPage - 1) * pageSizeInput | limitTo: pageSizeInput">
			<td>{{i.user_id}}</td>
			<td>{{i.username}}</td>
			<td>{{i.email}}</td>
			<td>{{i.password}}</td>
			<td>{{i.privilige}}</td>
			<td><i style="cursor:pointer" class="fa fa-pencil" aria-hidden="true" data-toggle="modal" data-target="#editModal" ng-click="openSelection(i)" ng-show="edituser"></i></td>
			<td><i style="cursor:pointer" class="fa fa-trash" aria-hidden="true" data-toggle="modal" data-target="#deleteModal" ng-click="openSelection(i)" ng-show="edituser"></i></td>
		</tr>
		</tbody>
	</table>
	<div loading></div>
</body>
</html>
