var igaController = function($scope, Rest) {
	
	$scope.games = {};
	
	
	$scope.init = function() {
		Rest.get('games').then(function(response) {
			$scope.games = response;
		});
	}
	
	
		
}