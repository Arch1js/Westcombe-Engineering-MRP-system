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
  <title>Metrics - <?php echo $userRow['username'];?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css"><!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.css">
	<link rel="stylesheet" href="../../css/metrics_style.css" type="text/css" /><!--Stylesheet -->
	<link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">

	<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
	<script src="https://www.amcharts.com/lib/3/serial.js"></script>
	<script src="https://www.amcharts.com/lib/3/themes/dark.js"></script>
	<script src="https://www.amcharts.com/lib/3/pie.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
  <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.29/angular.js"></script><!-- AngularJS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/1.3.2/ui-bootstrap-tpls.min.js"></script><!-- Bootstrap UI -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script><!-- JQuery -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script><!-- Bootstrap JS -->

	<!-- Services -->
	<script src="../../js/metricsFunctions.js"></script>
	<!-- Directives -->
	<script src="../../js/directives.js"></script>
</head>
<body ng-controller="chartCtrl">
	<div>
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
	<div class="contents">
		<div class="col-md-12">
			<div id="line_chart">
				<!-- <div class="ct-chart ct-perfect-square" id="chart1"></div> -->
				<div id="chartdiv"></div>
			</div>
		</div>
		<div class="col-md-4 col-sm-12">
			<div id="chart">
				<div id="chart2div"></div>
			</div>
		</div>
		<div class="col-md-4 col-sm-12">
			<div id="chart">
				<center>
				<h2>Stock Value</h2>
			</center>
				<div id="chart3div"></div>
			</div>
		</div>
		<div class="col-md-4 col-sm-12">
			<div id="chart">
				<div id="chart4div"></div>
			</div>
		</div>
	</div>
</body>
</html>
