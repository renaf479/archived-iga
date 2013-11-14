var resultsController = function($scope) {
	$scope.results 	= angular.fromJson(_results);
	$scope.total	= 0;
	
	angular.forEach($scope.results, function(value, key) {
		$scope.total = Number($scope.total) + Number(value.votes);
	});
}

resultsController.$inject = ['$scope'];