var igaController = function($scope, Rest, $timeout) {
	$scope.tweets 	= {};
	$scope.games 	= {};
	$scope.voteDisabled	= '';
	
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
		
		Rest.get('twitter').then(function(response) {
			$scope.tweets = response;
		});
		
			//Starts countdown
			var dString = "Nov 20, 2013 16:46 PDT";
			var d1 = new Date(dString);
			var d2 = new Date();
		$scope.countdown = Math.floor((d1.getTime() - d2.getTime())/1000);
	}
	
	
	//Logs vote and returns social prompt if applicable
	$scope.vote = function(model, type) {
		var post 		= model;
			post.route	= 'vote';
		
		Rest.post(post).then(function(response) {
			$scope.voteDisabled = true;
			
			$timeout(function() {
				$scope.voteDisabled = false;
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
}