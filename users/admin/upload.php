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
<html>
<head>
  <title>Welcome - <?php echo $userRow['username'];?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css"><!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.css">
	<link rel="stylesheet" href="../../css/stock_style.css" type="text/css" /><!-- login Stylesheet -->
	<link rel="stylesheet" href="../../css/loader_animation.css" type="text/css" /><!-- login Stylesheet -->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.29/angular.js"></script><!-- AngularJS -->
	<script src="../../dependencies/ui-bootstrap-tpls-1.2.5.js"></script><!-- Bootstrap UI -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script><!-- JQuery -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script><!-- Bootstrap JS -->

</head>
<body>
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
	      <ul class="nav navbar-nav">
	        <li><a href="/users/admin/admin_page.php">Home</a></li>
					<li><a href="/users/admin/manageUsers.php">Users</a></li>
	        <li><a href="/users/admin/orders.php">Orders</a></li>
	        <li><a href="/users/admin/stock.php">Stock</a></li>
	        <li><a href="/users/admin/makelist.php">Makelist</a></li>
	        <li><a href="/users/admin/metrics.php">Metrics</a></li>
					<li class="active"><a href="/users/upload.php">Upload</a></li>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	        <div id="content">
	          	<?php echo $userRow['username'];
	              $username= $userRow['username'];

	              $res=mysqli_query($mysqli,"SELECT * FROM administrators WHERE user_id=".$_SESSION['user']);
	              echo '<img id="profile_image" height="300" width="300" src="https://s3-eu-west-1.amazonaws.com/we-asets/photo.png">';
	              ?>
								<a href="/users/user_logout.php?logout" title="Logout"><i class="fa fa-sign-out fa-lg" aria-hidden="true"></i></a>
	          </div>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	<form action="admin_scripts/file_upload.php" method="post" enctype="multipart/form-data" style="margin-left: 20px;">
    Select CSV to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload file" name="submit">
</form>
</body>
</html>
