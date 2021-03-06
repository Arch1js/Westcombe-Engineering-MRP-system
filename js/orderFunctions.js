var app = angular.module('WEapp', ['ui.bootstrap']);

function orderCtrl($scope, $http, $filter) { //main controller for stock page

  $scope.orders = 'active';
  $scope.data = [];
  $scope.dataCount = [];
  $scope.orderWeekArray = [];
  $scope.orderWeek = '';
  $scope.paginator_bottom = true;

  $scope.sort = function(keyname){
    $scope.sortKey = keyname;   //set the sortKey to the param passed
    $scope.reverse = !$scope.reverse; //if true make it false and vice versa
  }

  $scope.setStatusColor = function (i) {//set status colours
    if (i.Status == "Active") {
      return "btn-success";
    }
    else if(i.Status == "Pending") {
      return "btn-warning";
    }
    else {
      return "btn-danger";
    }
  }

  $scope.printOrder = function() { //print orders
    window.print();
  }

  $scope.getNewestData = function() {
    $scope.loading = true;
    $scope.table_body = false;
    $scope.ordersWeek = false;
    $scope.paginator_bottom = true;

    var date = new Date();
    // var weekday = date.getDay(); //get current weekday
    var weekday = 1; //static date for testing

    if(weekday == 1) { //get data only on Mondays
      $scope.url = '/users/scripts/writeOrders.php';
      $http.post($scope.url).
      success(function() {
        $scope.loading = false;
        $scope.refreshSuccess = true;
      });
    }
    else {
      $scope.loading = false;
      $scope.refreshError = true;
    }

  }

  $scope.openSelection = function(i) { //open selection in new modal window
  		$scope.record = i;
  }

  $scope.updateOrder = function(record) { //update stock item on database
    $scope.url = '/users/scripts/updateOrder.php';

        var data = {
          id: $scope.record.id,
          comment: $scope.record.Comment,
          status: $scope.record.Status
       };

       $http.post($scope.url, data);
  }

  $scope.loadData = function(page) { //load order data

    //hide all things while data is loaded
    $scope.ordersWeek = false;
    $scope.refreshSuccess = false;
    $scope.refreshError = false;
    $scope.dataQueryError = false;
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

    var date = $scope.orderWeek;
    var start = 0;

    var data = {
      dataCount: incr,
      start: start,
      date: date
    };
    $scope.url = '/users/scripts/getNewestData.php';

    $http.post($scope.url, data).
       success(function(data,status) {

         $scope.data= data[0]; //save returned data to array
         $scope.dataCount= data[1];//save number of returned data to array
         $scope.numberOfItems = $scope.dataCount[0].count;

         if($scope.dataCount[0].count == 0) { //if orders database is empty, display error message
           $scope.dataQueryError = true;
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

  $scope.getPreviousOrders = function() { //get next
    $scope.url = '/users/scripts/getPreviousOrders.php';

    $http.post($scope.url).
      success(function(data, status) {
        $scope.orderWeekArray= data[0];
        $scope.orderWeek = $scope.orderWeekArray[0].week;
        $scope.loadData(1);
      })
  }

  $scope.getPreviousOrders();

  $scope.getOlderOrders = function() { //get next page of orders
    $scope.loadData(1);
    $scope.table_body = false;
    $scope.loading = true;

    var incr = $scope.pageSizeInput * $scope.currentPage;
    var start = 0;

    var data = {
      dataCount: incr,
      start: start,
      date: $scope.orderWeek
   };

    $scope.url = '/users/scripts/getOlderOrders.php';
    $http.post($scope.url, data).
      success(function(data, status) {
        $scope.data= data[0]; //save returned data to array
        $scope.dataCount= data[1];//save number of returned data to array
        $scope.numberOfItems = $scope.dataCount[0].count;

        $scope.table_body = true;
        $scope.loading = false;
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
