var app = angular.module('WEapp', []);


function stockTakeCtrl($scope, $http) { //main controller for stock page

  $scope.loading = true;
  $scope.data = [];
  $scope.url = '/users/scripts/getProduct.php'; //post url

  var data = {
    location: loc
  };

  $http.post($scope.url,data)
    .success(function(data,status) {
      $scope.loading = false;
      $scope.data= data;
      $scope.copy = angular.copy($scope.data);
    });


$scope.cancel = function() { //cancel stock take action
  $scope.savebtn = false;
  $scope.cancelbtn = false;
  $scope.data = angular.copy($scope.copy); //show qty as it was before
}

$scope.increaseValue = function(i) {
  i.Finish_Goods_Stock += 1;
  $scope.show();
};

$scope.decreaseValue = function(i) {
  i.Finish_Goods_Stock -= 1;
  $scope.show();
};

$scope.show = function() { //show buttons on count change
  $scope.savebtn = true;
  $scope.cancelbtn = true;
}

$scope.saveChange = function(i) {//save change
    $scope.savebtn = false;
    $scope.cancelbtn = false;

    var oldQty = i[4];
    var newQty = i.Finish_Goods_Stock;
    var partNo = i.Finished_Part;
    var location = i.Stores_Location;
    var user = sessionUser;

    $scope.url = '/users/scripts/stockTake.php'; //post url

    var data = {
      oldQty : oldQty,
      newQty: newQty,
      partNo: partNo,
      location: location,
      user: user
    };

    i[4] = i.Finish_Goods_Stock; //save new qty to scope
    $scope.copy = angular.copy($scope.data);

    $http.post($scope.url,data)
    .success(function(status) {
          $('#confirmModal').modal('show');
          console.log(status);
    });
  }
}
