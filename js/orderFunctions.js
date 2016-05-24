var app = angular.module('WEapp', ['ui.bootstrap']);

function orderCtrl($scope, $http, $filter) { //main controller for stock page

  $scope.data = [];
  $scope.dataCount = [];
  $scope.orderWeekArray = [];

  $scope.sort = function(keyname){
        $scope.sortKey = keyname;   //set the sortKey to the param passed
        $scope.reverse = !$scope.reverse; //if true make it false and vice versa
    }
  $scope.getNewestData = function() {
    $scope.loading = true;
    var date = new Date();
    var weekday = date.getDay();
    // var weekday = 1;

    if(weekday == 1) { //get data only on Mondays
      $scope.url = '/users/super_user/writeOrders.php';
      $http.post($scope.url);
    }
    else {
      $scope.refreshError = true;
    }
    $scope.loading = false;
  }
  $scope.loadData = function(page) {
    $scope.ordersWeek = true;
    $scope.refreshError = false;
    $scope.dataQueryError = false;
    $scope.paginator_bottom = false
    $scope.table_body = false;
    $scope.loading = true;
    $scope.currentPage = page;

    var incr = $scope.pageSizeInput * $scope.currentPage;
    var start = 0;
           var data = {
             dataCount: incr,
             start: start
       };
         $scope.url = '/users/super_user/getNewestData.php';
       $http.post($scope.url, data).
       success(function(data,status) {

               $scope.data= data[0]; //save returned data to array
               $scope.dataCount= data[1];//save number of returned data to array
               $scope.numberOfItems = $scope.dataCount[0].count;
               $scope.orderWeekArray= data[2];
               $scope.orderWeek = $scope.orderWeekArray[0].week;

               if($scope.dataCount[0].count == 0) { //if orders database is empty, display error message
                 $scope.dataQueryError = true;
                 $scope.paginator_bottom = false;
                 $scope.loading = false;
               }
               else {
               $scope.loading = false;
               $scope.table_body = true;
               $scope.paginator_bottom = true;
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
