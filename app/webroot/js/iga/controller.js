var igaController = function($scope, Rest, $timeout) {
	$scope.tweets 	= {};
	$scope.games 	= {};
	$scope.voteDisabled	= '';
	$scope.email = '';
	$scope.notification = '';
	
	$scope.carousel	= {
		interval:	5000
	}
	
	var timeout		= 7000;
	
	//Parse JSON feed of games
	function _loadGames(data) {
		$scope.games	= data;
	}
	
	//Page init
	$scope.init = function() {
		Rest.get('games').then(function(response) {
			_loadGames(response.sort($scope.random));
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
	
	//Randomizes the orderBy results
	$scope.random = function(){
    	return 0.5 - Math.random();
	}
	
	//Logs vote and returns social prompt if applicable
	$scope.vote = function(model, type) {
		var post 		= model;
			post.route	= 'vote';
		
		Rest.post(post).then(function(response) {
			$scope.notification = 'Vote submitted for '+model.meta.title;
			$scope.voteDisabled = true;
			
			$timeout(function() {
				$scope.voteDisabled = false;
				$scope.notification = false;
			}, timeout);
			
			//_loadGames(response);
			if(typeof type !== 'undefined') {
				var message, link;
				switch(type) {
					case 'facebook':
						message	= 'Voted for #'+model.meta.hashtag+' for Machinima\'s Gamers Choice Award. Who will you vote for? #IGAs http://...';
						link 	= 'http://www.facebook.com/sharer.php?'+
									'?s=100'+
									'&p[url]=http://iga.willfu.com'+
									'&p[images][0]=http://iga.willfu.com/img/'+model.image+
									'&p[title]=Inside Gaming Awards 2013'+
									'&p[summary]'+message;
						break;
					case 'twitter':
						message = 'Voted for #'+model.meta.hashtag+' for Gamers Choice Award. Who will you vote for? #IGAs http://...'
						link 	= 'https://twitter.com/share?url=/&text='+encodeURIComponent(message);
						break;
				}
				
				window.open(link, '_blank');
			}
		});
	}	
}