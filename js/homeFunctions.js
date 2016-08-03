var app = angular.module('WEapp', ['ui.bootstrap']);

function homeCtrl($scope, $http) { //main controller for stock page

  $scope.home = 'active';

  var pusher = new Pusher('fcd14057ed504b2df470',{cluster: 'eu'});
	var notificationsChannel = pusher.subscribe('notifications');

	notificationsChannel.bind('new_notification', function(notification){

		var message = notification.message;
    console.log(message);

    toastr.options = {
  "positionClass": "toast-bottom-left",
  };

		toastr.info(message);

	});
$scope.send = function() {
  console.log('Badge');
  $scope.badge = true;

  var text = $scope.notification_text;
  $.post('/js/pusher/notification/index.php', {message: text}).success(function(){
    console.log('Notification sent!');
  });
}
}
