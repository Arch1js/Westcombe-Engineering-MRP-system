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
  <title>Stock Take - <?php echo $userRow['username'];?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css"><!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.css">
	<link rel="stylesheet" href="../../css/stock_style.css" type="text/css" /><!-- login Stylesheet -->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.29/angular.js"></script><!-- AngularJS -->
	<script src="../../dependencies/ui-bootstrap-tpls-1.2.5.js"></script><!-- Bootstrap UI -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script><!-- JQuery -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script><!-- Bootstrap JS -->

	<!-- Services -->
	<script src="../../js/stockTakeFunctions.js"></script>
	<!-- Directives -->
	<script src="../../js/directives.js"></script>
</head>
<body>
	<div ng-controller="stockTakeCtrl">
		<nav class="navbar navbar-inverse navbar-default">
		  <div class="container-fluid">
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
<div class="col-md-2 col-xs-12">
	<form ng-submit="quickSearch(1)">
		<div class="input-group">
			<input id="qicksearch" type="text" class="form-control" ng-model="quicksearch" ng-init="quicksearch=''" value="" placeholder="Enter keyword">
			<div style="cursor:pointer" ng-click="quickSearch(1)" class="input-group-addon"><i class="fa fa-search"></i></div>
		</div>
	</form>
</div>
	<div class="col-md-1 col-sm-5 col-xs-12" id="page_controller">
		<select class="form-control" ng-model="pageSizeInput" ng-init="pageSizeInput='10'" ng-change="loadStock(currentPage)">
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
	<pagination total-items="numberOfItems" items-per-page="pageSizeInput"  ng-change="loadStock(currentPage)" ng-model="currentPage" max-size="5" class="pagination-sm"></pagination>
	</div>
	<div class="contents">
  <table class="table table-striped">
    <thead>
      <tr>
				<th>ID</th>
				<th>User</th>
				<th>Time</th>
				<th>Part No</th>
				<th>Qty Before</th>
				<th>Qty After</th>
			</tr>
    </thead>
    <tbody ng-show="table_body">
      <tr  ng-repeat="i in data | orderBy:sortKey:reverse | start: (currentPage - 1) * pageSizeInput | limitTo: pageSizeInput">
				<td>{{i.id}}</td>
        <td>{{i.user}}</td>
        <td>{{i.changeTime}}</td>
        <td>{{i.part}}</td>
        <td>{{i.stockQty_Before}}</td>
        <td>{{i.stockQty_After}}</td>
			</tr>
    </tbody>
  </table>
	<div id="paginator_bottom" class="col-md-4 col-sm-6" ng-show="paginator_bottom">
		<pagination total-items="numberOfItems" items-per-page="pageSizeInput"  ng-change="loadStock(currentPage)" ng-model="currentPage" max-size="5" class="pagination-sm"></pagination>
	</div>
	<div loading></div>
</body>
</div>
</div>
</html>
