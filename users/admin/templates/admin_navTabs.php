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
      <ul class="nav navbar-nav">
        <li ng-class="home"><a href="/users/admin/admin_page.php">Home<span class="sr-only">(current)</span></a></li>
        <li ng-class="users"><a href="/users/admin/manageUsers.php">Users</a></li>
        <li ng-class="orders"><a href="/users/admin/orders.php">Orders</a></li>
        <li ng-class="stock"><a href="/users/admin/stock.php">Stock</a></li>
        <li ng-class="stockTake"><a href="/users/admin/stockTake.php">Stock Events</a></li>
        <li ng-class="makelist"><a href="/users/admin/makelist.php">Makelist</a></li>
        <li ng-class="metrics"><a href="/users/admin/metrics.php">Metrics</a></li>
        <li ng-class="purchase_list"><a href="/users/admin/purchaseList.php">Purchase list</a></li>
        <li ng-class="upload"><a href="/users/admin/upload.php">Upload</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <div id="content">
            <?php session_start(); echo $_SESSION['username'];?>
              <img id="profile_image" height="300" width="300" src="https://s3-eu-west-1.amazonaws.com/we-asets/photo.png">
              <div ng-show="badge" class="badge"><i class="fa fa-bell-o" aria-hidden="true"></i></div></image>
              <a href="/users/user_logout.php?logout" title="Logout"><i class="fa fa-sign-out fa-lg" aria-hidden="true"></i></a>
          </div>
      </ul>
    </div>
  </div>
</nav>
