var resultsController = function($scope) {
	$scope.results 	= angular.fromJson(_results);
}

resultsController.$inject = ['$scope'];