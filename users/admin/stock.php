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
  <title>Stock - <?php echo $userRow['username'];?></title>
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
	<script src="../../js/stockFunctions.js"></script>
	<!-- Directives -->
	<script src="../../js/directives.js"></script>
</head>
<body>
	<div ng-controller="stockCtrl">
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
		    </div>
		  </div>
		</nav>
<div addstock></div> <!--add stock item modal -->
<div editstock></div> <!--edit stock item modal -->
<div class="col-md-2 col-xs-12">
	<form ng-submit="quickSearch(1)">
		<div class="input-group">
			<input id="qicksearch" type="text" class="form-control" ng-model="quicksearch" ng-init="quicksearch=''" value="" placeholder="Enter keyword">
			<div style="cursor:pointer" ng-click="quickSearch(1)" class="input-group-addon"><i class="fa fa-search"></i></div>
		</div>
	</form>
</div>
<div class="col-md-4" id="action_buttons">
	<button type="button" class="btn btn-primary" ng-click="loadStock(1)"><span class="fa fa-tasks"></span> Load stock</button>
	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModal"><span class="fa fa-plus"></span> Add new</button>
	<button type="button" class="btn btn-warning" ng-click="editrecord = !editrecord"><span class="fa fa-pencil-square-o"></span> Edit</button>
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
				<th ng-click="sort('ID')">ID<span class="glyphicon sort-icon" ng-show="sortKey=='ID'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
        <th ng-click="sort('Part_No')">Finished Part# <span class="glyphicon sort-icon" ng-show="sortKey=='Part_No'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
        <th ng-click="sort('Casting_Supplier')">Casting or Supplier Pt.No<span class="glyphicon sort-icon" ng-show="sortKey=='Casting_Supplier'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
        <th ng-click="sort('Description')">Description<span class="glyphicon sort-icon" ng-show="sortKey=='Description'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
				<th ng-click="sort('BOM')">Qty's BOM<span class="glyphicon sort-icon" ng-show="sortKey=='BOM'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
				<th ng-click="sort('Add_Info')">Additional Info<span class="glyphicon sort-icon" ng-show="sortKey=='Add_Info'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
				<th ng-click="sort('Stores_Location')">Stores Location<span class="glyphicon sort-icon" ng-show="sortKey=='Stores_Location'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
				<th ng-click="sort('Finished_Part_Weight_Kg')">Finished Part Weight(kg)<span class="glyphicon sort-icon" ng-show="sortKey=='Finished_Part_Weight_Kg'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
				<th ng-click="sort('P_P_Cost_Raw')">P/P Cost Raw<span class="glyphicon sort-icon" ng-show="sortKey=='P_P_Cost_Raw'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
				<th ng-click="sort('Selling_Price')">Selling Price<span class="glyphicon sort-icon" ng-show="sortKey=='Selling_Price'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
				<th ng-click="sort('Rejects_Scrap')">Rejects/Scrap<span class="glyphicon sort-icon" ng-show="sortKey=='Rejects_Scrap'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
				<th ng-click="sort('Raw_Material_Stock')">Raw Material Stock<span class="glyphicon sort-icon" ng-show="sortKey=='Raw_Material_Stock'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
				<th ng-click="sort('Finished_Goods_Stock')">Finished Goods Stock<span class="glyphicon sort-icon" ng-show="sortKey=='Finished_Goods_Stock'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
				<th ng-click="sort('Current_Total_Stock')">Current Total Stock<span class="glyphicon sort-icon" ng-show="sortKey=='Current_Total_Stock'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
				<th ng-click="sort('Supplier')">Supplier<span class="glyphicon sort-icon" ng-show="sortKey=='Supplier'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
				<th>Trigger Qty</th>
				<th>Replenish Qty</th>
				<th>Qty ready for use</th>
				<th>Qty Work In Progress</th>
				<th>Days to deliver</th>
			</tr>
    </thead>
    <tbody ng-show="table_body">
      <tr  ng-repeat="i in data | start: (currentPage - 1) * pageSizeInput | limitTo: pageSizeInput | orderBy:sortKey:reverse">
				<td>{{i.ID}}</td>
        <td>{{i.Finished_Part}}</td>
        <td>{{i.Casting_or_Supplier_Pt_No}}</td>
        <td>{{i.Description}}</td>
        <td>{{i.Qty_s_BOM}}</td>
        <td>{{i.Additional_Info}}</td>
        <td>{{i.Stores_Location}}</td>
        <td>{{i.Finished_Part_Weight_Kg}}</td>
        <td>{{i.P_P_Cost_Raw | currency:"£":0}}</td>
        <td>{{i.Selling_Price | currency:"£":0}}</td>
				<td>{{i.Rejects_Scrap}}</td>
				<td>{{i.Raw_Material_Stock}}</td>
				<td>{{i.Finish_Goods_Stock}}</td>
				<td>{{i.Current_Total_Stock}}</td>
				<td>{{i.Supplier}}</td>
				<td>{{i.Trigger_qty}}</td>
				<td>{{i.Replenish_qty}}</td>
				<td>{{i.Qty_ready_for_use}}</td>
				<td>{{i.Qty_WIP}}</td>
				<td>{{i.Days_to_deliver}}</td>
				<td><i style="cursor:pointer" class="fa fa-pencil" aria-hidden="true" data-toggle="modal" data-target="#editModal" ng-click="openSelection(i)" ng-show="editrecord"></i></td>
				<!-- <td><i style="cursor:pointer" class="fa fa-pencil" aria-hidden="true" data-toggle="modal" data-target="#editModal" ng-click="openSelection(i)"></i></td> -->
			</tr>
    </tbody>
  </table>
	<div id="paginator_bottom" class="col-md-4 col-sm-6" ng-show="paginator_bottom">
		<pagination total-items="numberOfItems" items-per-page="pageSizeInput"  ng-change="loadStock(currentPage)" ng-model="currentPage" max-size="5" class="pagination-sm"></pagination>
	</div>
	<div loading></div>
</body>
<div class="alert alert-danger" ng-show="error" class="col-xs-12">
		<strong>Error!</strong> No results found. Please try another query!
	</div>
</div>
</div>
</html>
