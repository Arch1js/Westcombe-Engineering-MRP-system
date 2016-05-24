app.directive("navbar", function () {
	return {
		restrict: "A",
		templateUrl: "/users/nav-bar.php"
	}
});
app.directive("loading", function () {
	return {
		restrict: "A",
		templateUrl: "/users/loading_spinner.html"
	}
});
