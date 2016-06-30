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
  <title>Welcome - <?php echo $userRow['username'];?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css"><!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.css">
	<link rel="stylesheet" href="../../css/loader_animation.css" type="text/css" /><!-- loader animation Stylesheet -->
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
					<li class="active"><a href="/users/admin/manageUsers.php">Users<span class="sr-only">(current)</span></a></li>
	        <li><a href="/users/admin/orders.php">Orders</a></li>
	        <li><a href="/users/admin/stock.php">Stock</a></li>
	        <li><a href="/users/admin/makelist.php">Makelist</a></li>
	        <li><a href="/users/admin/metrics.php">Metrics</a></li>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	        <div id="content">
	          	<?php echo $userRow['username'];
	              $username= $userRow['username'];
	              require '../dbconnect.php';
	              $res=mysqli_query($mysqli,"SELECT * FROM administrators WHERE user_id=".$_SESSION['user']);
	              echo '<img id="profile_image" height="300" width="300" src="https://s3-eu-west-1.amazonaws.com/we-asets/photo.png">';
	              ?>
								<a href="/users/user_logout.php?logout" title="Logout"><i class="fa fa-sign-out fa-lg" aria-hidden="true"></i></a>
	          </div>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	<!-- Add Modal -->
	<div class="modal fade" id="addModal" role="dialog">
			<div class="modal-dialog modal-md">
	<!-- Modal content-->
	<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
					<img width="100px" height="40px" alt="Brand" src="https://s3-eu-west-1.amazonaws.com/we-asets/westcombe.png"><!-- Logo -->
	</div>
	<div class="modal-body">
	<form class="form-inline" role="form">
		<div id="change_form" class="form-group">
		<div class="col-md-4 col-sm-4">
			<label>Username: </label>
			<input type="text" class="form-control" maxlength="20" ng-model="user.username" required/>
		</div>
		<div class="col-md-4 col-sm-4">
			<label>Email: </label>
			<input type="text" class="form-control" maxlength="20" ng-model="user.email" required/>
		</div>
			<div class="col-md-3 col-sm-3">
				<label >Privilige: </label>
				<select class="form-control" ng-model="user.privilige">
					<option value="user" selected>User</option>
					<option value="super user">Super User</option>
					<option value="admin">Administrator</option>
				</select>
		</div>
		</div>
	</form>
	<form class="form-inline" role="form">
		<div id="change_form" class="form-group">
			<div class="col-md-4 col-sm-4">
				<label>Password: </label>
				<input id="user_password1" type="password" class="form-control" ng-model="user.password" maxlength="15" required autofocus/>
			</div>
			<div class="col-md-4 col-sm-4">
				<label>Confirm Password: </label>
				<input id="user_password2" type="password" class="form-control" maxlength="15" required />
			</div>
		</div>
	</form>
	<p id="validate-status2"></p>
	</div>
	<div class="modal-footer">
	<button id="add_user" type="button" class="btn btn-success" data-dismiss="modal" ng-click="addUser()">Add User</button>
		<button type="button" class="btn btn-warning" data-toggle="modal" data-dismiss="modal">Cancel</button>
	</div>
</div>
</div>
</div>
<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" role="dialog">
	<div class="modal-dialog modal-md">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<img width="100px" height="40px" alt="Brand" src="https://s3-eu-west-1.amazonaws.com/we-asets/westcombe.png"><!-- Logo -->
			</div>
			<div class="modal-body">
				<h3>Are you sure you want to delete this user?</h3>
				<p><b>User ID:</b> {{user.user_id}}</p>
				<p><b>Username:</b> {{user.username}}</p>
				<p><b>Email:</b> {{user.email}}</p>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-danger" data-dismiss="modal" ng-click="deleteUser()">Delete</button>
				<button type="button" class="btn btn-warning" data-toggle="modal" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
	<!-- Edit Modal -->
<div class="modal fade" id="editModal" role="dialog">
 <div class="modal-dialog modal-md">
	<!-- Modal content-->
	<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
					<img width="100px" height="40px" alt="Brand" src="https://s3-eu-west-1.amazonaws.com/we-asets/westcombe.png"><!-- Logo -->
	</div>
	<div class="modal-body">
		<ul class="nav nav-tabs">
	  	<li class="active"><a data-toggle="tab" href="#basic">Credentials</a></li>
			<li><a data-toggle="tab" href="#password">Password</a></li>
		</ul>
		<div class="tab-content">
    		<div id="basic" class="tab-pane fade in active">
					<form class="form-inline" role="form">
						<div id="change_form" class="form-group">
							<br>
						<div class="col-md-4 col-sm-4">
							<label>User ID: </label>
							<input type="text" class="form-control" maxlength="5" ng-model="user.user_id" disabled/>
						</div>
						<div class="col-md-3 col-sm-3">
							<label>Username: </label>
							<input type="text" class="form-control" maxlength="20" ng-model="user.username"/>
						</div>
						</div>
					</form>
					<form class="form-inline" role="form">
						<div id="change_form" class="form-group">
							<div class="col-md-4 col-sm-4">
								<label >Privilige: </label>
								<select class="form-control" ng-model="user.privilige">
									<option value="user" selected>User</option>
									<option value="super user">Super User</option>
									<option value="admin">Administrator</option>
								</select>
							</div>
							<div class="col-md-3 col-sm-3">
								<label>Email: </label>
								<input type="text" class="form-control" maxlength="20" ng-model="user.email"/>
							</div>
						</div>
					</form>
					<div class="modal-footer">
					<button type="submit" class="btn btn-success" data-dismiss="modal" ng-click="updateCredentials(user)">Save changes</button>
						<button type="button" class="btn btn-warning" data-toggle="modal" data-dismiss="modal">Cancel</button>
					</div>
				</div>
				<div id="password" class="tab-pane fade">
					<form class="form-inline" role="form">
						<div id="change_form" class="form-group">
							<br>
							<div class="col-md-4 col-sm-4">
								<label>Password: </label>
								<input id="password1" type="password" class="form-control" ng-model="user.newPassword" maxlength="15" required autofocus/>
							</div>
							<div class="col-md-4 col-sm-4">
								<label>Confirm Password: </label>
								<input id="password2" type="password" class="form-control" ng-model="user.repeatPassword" maxlength="15" required />
							</div>
						</div>
					</form>
					<p id="validate-status"></p>
					<div class="modal-footer">
					<button id="save_password" type="submit" class="btn btn-success" data-dismiss="modal" ng-click="updatePassword(user)">Save changes</button>
						<button type="button" class="btn btn-warning" data-toggle="modal" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
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
		<th>Privilige</th>
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
