var app = angular.module('WEapp', ['ui.bootstrap']);

function purchaseCtrl($scope, $http, $filter) { //main controller for stock page
  $scope.purchase_list = 'active';
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
