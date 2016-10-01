var app = angular.module('WEapp', ['ui.bootstrap']);

function stockTakeCtrl($scope, $http, $filter) { //main controller for stock page

  $scope.stockTake = 'active';

  $scope.loadStock = function(page) { //load all stock
    $scope.quicksearch = '';
    $scope.loading = true;

    if($scope.quicksearch !== "") {
      quickSearch(page);
    }
    else {
      $scope.error = false;
      $scope.table_body = true;
      $scope.loading = true;
      $scope.paginator_bottom = false;
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
        dataCount: incr,
        start: start
      };

      $scope.url = '/users/scripts/displayStockEvents.php'; //post url
      $http.post($scope.url, data).
        success(function(data,status) {

          $scope.data= data[0]; //save returned data to array
          $scope.data2= data[1];//save number of returned data to array
          $scope.numberOfItems = $scope.data2[0].count;
          $scope.loading = false;
          $scope.paginator_bottom = true;
      });
    }
  }

  $scope.loadStock(1); //run load stock function on page load
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
