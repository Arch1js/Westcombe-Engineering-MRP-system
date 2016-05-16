<?php
session_start();
require '../dbconnect.php';

if(!isset($_SESSION['user']))
{
	header("Location: ../validate_session.php");
}

$res=mysqli_query($mysqli, "SELECT * FROM administrators WHERE user_id=".$_SESSION['user']);
$userRow=mysqli_fetch_array($res);
?>
<html ng-app="WEapp">
<head>
  <title>Welcome - <?php echo $userRow['username'];?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css"><!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.css">
	<link rel="stylesheet" href="/css/stock_style.css" type="text/css" /><!-- login Stylesheet -->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.29/angular.js"></script><!-- AngularJS -->
	<script src="../dependencies/ui-bootstrap-tpls-1.2.5.js"></script><!-- Bootstrap UI -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script><!-- JQuery -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script><!-- Bootstrap JS -->

	<!-- Services -->
	<script src="/js/functions.js"></script>
	<!-- Directives -->
	<script src="/js/directives.js"></script>
</head>
<body>
	<div ng-controller="mainCtrl">
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
	        <img width="70px" height="40px" alt="Westcombe MRP system" src="../Asets/westcombe_logo_small.png">
	      </a>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	        <li><a href="/views/index.php">Home</a></li>
	        <li><a href="#">Orders</a></li>
	        <li class="active"><a href="/stock.php">Stock</a></li>
	        <li><a href="#">Jobs</a></li>
	        <li><a href="#">Metrics</a></li>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	        <div id="content">
	          	<?php echo $userRow['username'];
	              $username= $userRow['username'];
	              require '../dbconnect.php';
	              $res=mysqli_query($mysqli,"SELECT * FROM administrators WHERE user_id=".$_SESSION['user']);
	              echo '<img id="profile_image" height="300" width="300" src="../Asets/photo.png">';
	              ?>
								<a href="../user_logout.php?logout" title="Logout"><i class="fa fa-sign-out fa-lg" aria-hidden="true"></i></a>
	          </div>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	<button type="button" class="btn btn-primary" ng-click="loadStock(1)">Load stock</button>
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
        <th>Finished Part#</th>
        <th>Casting or Supplier Pt.No</th>
        <th>Description</th>
				<th>Qty's BOM</th>
				<th>Additional Info</th>
				<th>Stores Location</th>
				<th>Finished Part Weight(kg)</th>
				<th>P/P Cost Raw</th>
				<th>Selling Price</th>
				<th>Rejects/Scrap</th>
				<th>Raw Material Stock</th>
				<th>Finished Goods Stock</th>
				<th>Current Total Stock</th>
				<th>Supplier</th>
      </tr>
    </thead>
    <tbody>
      <tr ng-model="results" ng-repeat="i in data | start: (currentPage - 1) * pageSizeInput | limitTo: pageSizeInput">
        <td>{{i.Finished_Part}}</td>
        <td>{{i.Casting_or_Supplier_Pt_No}}</td>
        <td>{{i.Description}}</td>
        <td>{{i.Qty_s_BOM}}</td>
        <td>{{i.Additional_Info}}</td>
        <td>{{i.Stores_Location}}</td>
        <td>{{i.Finished_Part_Weight_Kg}}</td>
        <td>{{i.P_P_Cost_Raw}}</td>
        <td>{{i.Selling_Price}}</td>
				<td>{{i.Rejects_Scrap}}</td>
				<td>{{i.Raw_Material_Stock}}</td>
				<td>{{i.Finished_Goods_Stock}}</td>
				<td>{{i.Current_Total_Stock}}</td>
				<td>{{i.Supplier}}</td>
      </tr>
    </tbody>
  </table>
</body>
</div>
</div>
</html>
