var igaController = function($scope, Rest, $timeout) {
	
	$scope.games 	= {};
	$scope.disabled	= '';
	
	var timeout		= 3000;
	
	//Parse JSON feed of games
	function _loadGames(data) {
		$scope.games	= data;
	}
	
	//Page init
	$scope.init = function() {
		Rest.get('games').then(function(response) {
			_loadGames(response);
		});
	}
	
	//Logs vote and returns social prompt if applicable
	$scope.vote = function(model, type) {
		var post 		= model;
			post.route	= 'vote';
		
		Rest.post(post).then(function(response) {
			$scope.disabled = model.id;
			
			$timeout(function() {
				$scope.disabled = '';
			}, timeout);
			
			_loadGames(response);
			if(typeof type !== 'undefined') {
				var message;
				switch(type) {
					case 'facebook':
						message	= 'Voted for #'+model.meta.hashtag+' for Machinima’s Gamers Choice Award. Who will you vote for? #IGAs <shortened link to site>';
						break;
					case 'twitter':
						message = 'Voted for #'+model.meta.hashtag+' for Gamers Choice Award. Who will you vote for? #IGAs <shortened link to site>'
						break;
				}
				
				console.log(message);
			}
		});
	}
	
	//Disables voting button for rate limiting
	$scope.voteDisabled = function(model) {
		if(model === $scope.disabled) {
			return true;
		} else {
			return false;
		}
	}
		
}