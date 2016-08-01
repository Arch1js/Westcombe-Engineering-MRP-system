var app = angular.module('WEapp', ['ui.bootstrap']);

function makelistCtrl($scope, $http, $filter) { //main controller for stock page

  $scope.data = [];
  $scope.dataCount = [];

  $scope.printMakelist = function() {
    window.print();
  }

  $scope.setStatusColor = function(i) {
    if (i.status == "Active") {
      return "btn-success";
    }
    else if(i.status == "Pending") {
      return "btn-warning";
    }
    else {
      return "btn-danger";
    }
  }

  $scope.openSelection = function(i) { //open selection in new modal window
      $scope.record = i;
  }

  $scope.updateMakelist = function() {
    var data = {
      id: $scope.record.orderID,
      status: $scope.record.status,
      order_qty: $scope.record.order_qty,
      req_qty: $scope.record.req_qty,
      delivery_date: $scope.record.delivery_date,
      comments: $scope.record.comments
    };
    $scope.url = '/users/scripts/updateMakelist.php';
    $http.post($scope.url, data);
  }

  $scope.getPreviousMakelists = function() {
    $scope.url = '/users/scripts/getPreviousMakelists.php';
    $http.post($scope.url).
      success(function(data, status) {
        $scope.orderWeekArray= data[0];
        $scope.makelistWeek = $scope.orderWeekArray[0].week;

        $scope.getMakelist(1); //run function on page load
      });
  }

  $scope.getPreviousMakelists();

  $scope.getNewMakelistData = function() {
    $scope.dataRefreshSuccess = false;
    $scope.nodataError = false;
    $scope.paginator_bottom = true;
    $scope.table_body = false;
    $scope.loading = true;

    $scope.url = '/users/scripts/getMakelistData.php';
    $http.post($scope.url).
    success(function(data,status) {
      $scope.loading = false;
      $scope.dataRefreshSuccess = true;
    });
  }

  $scope.getMakelist = function(page) {

    $scope.dataRefreshSuccess = false;
    $scope.nodataError = false;
    $scope.paginator_bottom = true;
    $scope.table_body = false;
    $scope.loading = true;

    $scope.currentPage = page;
    if($scope.pageSizeInput == null) {
      $scope.pageSizeInput = 10;
      var incr = $scope.pageSizeInput * $scope.currentPage;
    }
    else {
      var incr = $scope.pageSizeInput * $scope.currentPage;
    }

    var start = 0;

    var data = {
      date: $scope.makelistWeek,
      dataCount: incr,
      start: start
    };
    $scope.url2 = '/users/scripts/getMakelist.php';
    $http.post($scope.url2,data).
      success(function(data,status) {
        $scope.data= data[0]; //save returned data to array
        $scope.dataCount= data[1];//save number of returned data to array
        $scope.numberOfItems = $scope.dataCount[0].count;

        if($scope.dataCount[0].count == 0) { //if orders database is empty, display error message
          $scope.nodataError = true;
          $scope.paginator_bottom = true;
          $scope.loading = false;
        }
        else {
          $scope.loading = false;
          $scope.table_body = true;
          $scope.paginator_bottom = false;
        }

      });
    }

}
app.filter('start', function () { //splice search results for pagination
    return function (input, start) {
        if (!input || !input.length) { return; }

        start = +start;
        return input.slice(start);
    };
});
app.filter('roundup', function () { //page number rounding filter
        return function (value) {
            return Math.ceil(value);
        };
    });
