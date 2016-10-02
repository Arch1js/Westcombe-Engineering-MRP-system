//ADMIN///
app.directive("edit", function () { //admin panel edit modal
	return {
		restrict: "A",
		controller: adminCtrl,
		templateUrl: "/users/admin/templates/admin_editUser.html"
	}
});

app.directive("add", function () { //admin panel add user modal
	return {
		restrict: "A",
		controller: adminCtrl,
		templateUrl: "/users/admin/templates/admin_addUser.html"
	}
});

app.directive("delete", function () { //admin panel delete user modal
	return {
		restrict: "A",
		templateUrl: "/users/admin/templates/admin_deleteUser.html"
	}
});

////////////////////////////////////////////////////////////////////

//Super User/Admin///
app.directive("editorder", function () { //edit orders modal
	return {
		restrict: "A",
		templateUrl: "/users/templates/editOrder.html"
	}
});

app.directive("addstock", function () { //edit orders modal
	return {
		restrict: "A",
		templateUrl: "/users/templates/addStock.html"
	}
});

app.directive("editstock", function () { //edit orders modal
	return {
		restrict: "A",
		templateUrl: "/users/templates/editStock.html"
	}
});

app.directive("editmakelist", function () { //edit makelist modal
	return {
		restrict: "A",
		templateUrl: "/users/templates/editMakelist.html"
	}
});
////////////////////////////////////////////////////////////////////


//Miscellaneous//
app.directive("loading", function () { //loading animation directive
	return {
		restrict: "A",
		templateUrl: "/users/loading_spinner.html"
	}
});

app.directive("navbar", function () { //navigation bar tabs directive
	return {
		restrict: "A",
		templateUrl: "/users/admin/templates/admin_navTabs.php"
	}
});
///////////////////////////////////////////////////////////////////
