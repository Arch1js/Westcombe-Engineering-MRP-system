var app = angular.module('WEapp', ['ui.bootstrap']);

function stockCtrl($scope, $http, $filter) { //main controller for stock page
  $scope.data = [];
  $scope.data2 = [];

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
  	$scope.url = '/users/scripts/displayStock.php'; //post url
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

  $scope.loadStock(1); //run function on page load

  $scope.openSelection = function(i) { //open selection in new modal window
  		$scope.record = i;
  }

  $scope.edit = function() { //show edit icon
    $scope.editrecord = true;
  }

  $scope.sort = function(keyname){
  			$scope.sortKey = keyname;   //set the sortKey to the param passed
  			$scope.reverse = !$scope.reverse; //if true make it false and vice versa
  	}
  $scope.quickSearch = function(page) { //Quick search function
    $scope.table_body = false;
    $scope.error = false;
    $scope.loading = true;
    $scope.currentPage = page;
    var incr = $scope.pageSizeInput * $scope.currentPage;
    var start = 0;
           var data = {
             dataCount: incr,
             start: start,
             quick: $scope.quicksearch
       };
         $scope.url = '/users/scripts/quickSearch.php';
       $http.post($scope.url, data).
       success(function(data,status) {

               $scope.data= data[0];
               $scope.data2= data[1];
               $scope.numberOfItems = $scope.data2[0].count;

               if($scope.data2[0].count == 0) { //if search query fails, display error message
       					$scope.error = true;
                $scope.paginator_bottom = false;
                $scope.loading = false;
       				}
              else {
                $scope.error = false;
                $scope.loading = false;
              }
       });
       $scope.table_body = true;
       $scope.loading = false;

  }
  $scope.addRecord = function(i) { //add new stock item to database
   $scope.url = '/users/scripts/addRecord.php';
          var data = {
            Finished_part_no: $scope.Finished_Part,
            Casting_Supplier_part_no: $scope.Casting_or_Supplier_Pt_No,
    				BOM: $scope.Qty_s_BOM,
    				Supplier: $scope.Supplier,
    				Stores_Location: $scope.Stores_Location,
    				Finished_part_weight: $scope.Finished_Part_Weight_Kg,
    				P_P_Cost_Raw: $scope.P_P_Cost_Raw,
    				Selling_Price: $scope.Selling_Price,
    				Rejects_Scrap: $scope.Rejects_Scrap,
    				Raw_Material_Stock: $scope.Raw_Material_Stock,
    				Finished_goods_stock: $scope.Finish_Goods_Stock,
    				Current_total_stock: $scope.Current_Total_Stock,
    				Additional_Info: $scope.Additional_Info,
    				Description: $scope.Description,
            Trigger: $scope.AddTrigger_qty,
            Replenish: $scope.AddReplenish_qty,
            Qty_ready_for_use: $scope.Qty_ready_for_use,
            Qty_WIP: $scope.Qty_WIP,
            Days_to_deliver: $scope.Days_to_deliver
      };
      console.log(data);
      $http.post($scope.url, data);

  $scope.data.push(data);

  }
  $scope.updateRecord = function(record) { //update stock item on database
    $scope.url = '/users/scripts/updateRecord.php';

        var data = {
          Finished_part_no: $scope.record.Finished_Part,
          Casting_Supplier_part_no: $scope.record.Casting_or_Supplier_Pt_No,
   				BOM: $scope.record.Qty_s_BOM,
   				Supplier: $scope.record.Supplier,
   				Stores_Location: $scope.record.Stores_Location,
   				Finished_part_weight: $scope.record.Finished_Part_Weight_Kg,
   				P_P_Cost_Raw: $scope.record.P_P_Cost_Raw,
   				Selling_Price: $scope.record.Selling_Price,
   				Rejects_Scrap: $scope.record.Rejects_Scrap,
   				Raw_Material_Stock: $scope.record.Raw_Material_Stock,
   				Finished_goods_stock: $scope.record.Finish_Goods_Stock,
   				Current_total_stock: $scope.record.Current_Total_Stock,
   				Additional_Info: $scope.record.Additional_Info,
   				Description: $scope.record.Description,
          Trigger: $scope.record.Trigger_qty,
          Replenish: $scope.record.Replenish_qty,
          Qty_ready_for_use: $scope.record.Qty_ready_for_use,
          Qty_WIP: $scope.record.Qty_WIP,
          Days_to_deliver: $scope.record.Days_to_deliver,
          ID:$scope.record.ID
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
