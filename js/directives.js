app.directive("navbar", function () {
	return {
		restrict: "A",
		templateUrl: "../views/nav-bar.php"
	}
});
app.directive("loading", function () {
	return {
		restrict: "A",
		templateUrl: "../views/loading_spinner.html"
	}
});
