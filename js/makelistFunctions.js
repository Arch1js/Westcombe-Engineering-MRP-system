var app = angular.module('WEapp', ['ui.bootstrap']);

function makelistCtrl($scope, $http, $filter) { //main controller for stock page

  $scope.makelist = 'active';
  $scope.data = [];
  $scope.dataCount = [];

  $scope.printMakelist = function() { //print
    window.print();
  }

  $scope.setStatusColor = function(i) { //set colours for different statuses
    if (i.status == "Active" || i.status == "Doing") {
      return "btn-info";
    }
    else if(i.status == "Pending") {
      return "btn-warning";
    }
    else if(i.status == "Done") {
      return "btn-success";
    }
    else {
      return "btn-danger";
    }
  }

  $scope.openSelection = function(i) { //open selection in new modal window
      $scope.record = i;
  }

  $scope.updateMakelist = function() { //update makelist data

    $scope.url = '/users/scripts/updateMakelist.php';
    var data = {
      id: $scope.record.orderID,
      status: $scope.record.status,
      order_qty: $scope.record.order_qty,
      req_qty: $scope.record.req_qty,
      delivery_date: $scope.record.delivery_date,
      comments: $scope.record.comments
    };

    $http.post($scope.url, data);
  }

  $scope.getPreviousMakelists = function() { //get previous week makelist data

    $scope.url = '/users/scripts/getPreviousMakelists.php'; //post address

    $http.post($scope.url).
      success(function(data, status) {

        $scope.orderWeekArray= data[0]; //save week data to array
        $scope.makelistWeek = $scope.orderWeekArray[0].week;

        $scope.getMakelist(1); //run function on page load
      });
  }

  $scope.getPreviousMakelists();

  $scope.getNewMakelistData = function() {

    //hide all things while data is loaded
    $scope.dataRefreshSuccess = false;
    $scope.nodataError = false;
    $scope.paginator_bottom = true;
    $scope.table_body = false;
    $scope.loading = true;

    $scope.url = '/users/scripts/getMakelistData.php';

    $http.post($scope.url).
      success(function(data,status) {
      $scope.loading = false;
      $scope.dataRefreshSuccess = true; //show success message
    });
  }

  $scope.getMakelist = function(page, status) {

    //hide all things while data is loaded
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

    if(!status) {
      var status = $('.nav-tabs .active').text(); //get the current tab name
    }

    var data = { //data to be sent
      date: $scope.makelistWeek,
      status: status,
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
