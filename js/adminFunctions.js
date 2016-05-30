var app = angular.module('WEapp', ['ui.bootstrap']);

function adminCtrl($scope, $http, $filter) { //main controller for stock page

  window.onload = function() {
    $scope.loadUsers(1);
  };
  $(document).ready(function() {
    $('#save_password').addClass('disabled');
    $('#add_user').addClass('disabled');

    $("#password2").keyup(validate);
    $("#user_password2").keyup(validate2);
});



function validate() { //validates if passwords match

  var password1 = $("#password1").val();
  var password2 = $("#password2").val();

  var user_password1 = $("#user_password1").val();
  var user_password2 = $("#user_password2").val();

    if(password1 != password2) {
      $('#save_password').addClass('disabled');
       $("#validate-status").text("Passwords dont match!");
    }
    else {
        $("#validate-status").text("");
        $('#save_password').removeClass('disabled');
    }

}
function validate2() { //password validation for new user form

  var user_password1 = $("#user_password1").val();
  var user_password2 = $("#user_password2").val();

    if(user_password1 != user_password2) {
      $('#add_user').addClass('disabled');
       $("#validate-status2").text("Passwords dont match!");
    }
    else {
        $("#validate-status2").text("");
        $('#add_user').removeClass('disabled');
    }

}
  $scope.data = [];
  $scope.data2 = [];

  $scope.openSelection = function(i) {
    $scope.user = i;
  }
$scope.updateCredentials = function(user) {
  $scope.url = '/users/admin/updateUser.php'; //post url
  var data = {
    userID: $scope.user.user_id,
    username: $scope.user.username,
    email: $scope.user.email,
    privilige: $scope.user.privilige
  };
$http.post($scope.url, data);
}

$scope.updatePassword = function(user) {
  $scope.url = '/users/admin/updatePassword.php'; //post url
  var data = {
    userID: $scope.user.user_id,
    password: $scope.user.newPassword
  };
$http.post($scope.url, data);
}

  $scope.loadUsers = function(page) { //load all stock
      $scope.loading = true;
      $scope.currentPage = page;
      var incr = $scope.pageSizeInput * $scope.currentPage;
      var start = 0;
    var data = {
      dataCount: incr,
      start: start
    };
    $scope.url = '/users/admin/displayUsers.php'; //post url
  $http.post($scope.url, data).
      success(function(data,status) {

              $scope.data= data[0]; //save returned data to array
              $scope.data2= data[1];//save number of returned data to array
              $scope.numberOfItems = $scope.data2[0].count;
              $scope.table_body = true;
              $scope.loading = false;

      });

  }

  $scope.addUser = function() { //add new stock item to database
     $scope.url = '/users/admin/addUser.php';
        var data = {
          username: $scope.user.username,
          email: $scope.user.email,
          privilige: $scope.user.privilige,
      		password: $scope.user.password
        };
        $http.post($scope.url, data);
    }

    $scope.deleteUser = function() { //add new stock item to database
       $scope.url = '/users/admin/deleteUser.php';
          var data = {
            userID: $scope.user.user_id
          };
          $http.post($scope.url, data);

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
