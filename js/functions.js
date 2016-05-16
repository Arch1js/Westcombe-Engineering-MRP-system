var app = angular.module('WEapp', ['ui.bootstrap']);

function mainCtrl($scope, $http, $filter) {
  $scope.data = [];
  $scope.data2 = [];
  $scope.loadStock = function(page) {
    $scope.currentPage = page;
    var incr = $scope.pageSizeInput * $scope.currentPage;
    var start = 0;
    var data = {
      dataCount: incr,
      start: start
    };
  	$scope.url = '/displayOrders.php';
  $http.post($scope.url, data).
      success(function(data,status) {

              $scope.data= data[0];
              $scope.data2= data[1];
              $scope.numberOfItems = $scope.data2[0].count;
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
