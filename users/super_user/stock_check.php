<?php
session_start();
require '../dbconnect.php';

if(!isset($_SESSION['user']))
{
	header("Location: ../../validate_session.php");
}
else if($_SESSION["privilige"] != 'super user') {
	header("Location: ../../access_denied.html");
}
$res=mysqli_query($mysqli, "SELECT username FROM administrators WHERE user_id=".$_SESSION['user']);
$userRow=mysqli_fetch_array($res);
?>
<html ng-app="WEapp">
<head>
  <title>Stock Check - <?php echo $userRow['username'];?></title>
  <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css"><!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.css">
	<link rel="stylesheet" href="../../../css/stocktake_style.css" type="text/css" /><!--Stylesheet -->


	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.29/angular.js"></script><!-- AngularJS -->
	<script src="https://code.jquery.com/jquery-2.1.3.min.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script><!-- Bootstrap JS -->

	<!-- Services -->
	<script src="../../../js/stockTake.js"></script>
	<!-- Directives -->
	<script src="../../../js/directives.js"></script>

	<script>
		var loc = <?php echo json_encode($_GET['location']); ?>;
	</script>

</head>
<body ng-controller="stockTakeCtrl">
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
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav navbar-right">
	        <div id="content">
	          	<?php echo $userRow['username'];?>
	              <img id="profile_image" height="300" width="300" src="https://s3-eu-west-1.amazonaws.com/we-asets/photo.png"></image>
								<a href="/users/user_logout.php?logout" title="Logout"><i class="fa fa-sign-out fa-lg" aria-hidden="true"></i></a>
	          </div>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	<!-- Modal -->
<div class="modal fade" id="confirmModal" role="dialog">
	<div class="modal-dialog">
	<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
					<img width="100px" height="40px" alt="Brand" src="https://s3-eu-west-1.amazonaws.com/we-asets/westcombe.png"><!-- Logo -->
				</div>
				<div class="modal-body">
					<p>Stock Quantity is updated!</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<div loading></div>
	<div class="container">
		<div class="col-xs-12" id="item" ng-repeat="i in data">
				<div class="form-inline">
					<div class="form-group col-xs-4">
						<label>Part No.</label>
						<p>{{i.Finished_Part}}</p>
				</div>
				<div class="form-group col-xs-4">
					<label>Description</label>
					<p>{{i.Description}}</p>
				</div>
				<div class="form-group col-xs-4">
					<h1>{{i.Stores_Location}}</h1>
				</div>
			</div>
			<div class="col-xs-6">
				 <input class="form-control input-lg" id="inputlg" type="number" ng-model="i.Finish_Goods_Stock" ng-change="show()">
			</div>
			<div class="col-xs-3">
				<button class="btn btn-success" ng-show="savebtn" ng-click="saveChange(i)">Save</button>
			</div>
			<div class="col-xs-3">
				<button class="btn btn-warning" ng-show="cancelbtn" ng-click="cancel()">Cancel</button>
			</div>
		</div>
	</div>

</body>
</html>
