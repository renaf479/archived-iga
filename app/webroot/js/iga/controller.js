var igaController = function($scope, Rest, $timeout, Analytics) {
	$scope.tweets 	= {};
	$scope.games 	= {};
	$scope.voteDisabled	= false;
	$scope.newsletter = {};
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
		Analytics.general('Page Load');
		Rest.get('games').then(function(response) {
			_loadGames(response.sort($scope.random));
		});
		
		Rest.get('twitter').then(function(response) {
			$scope.tweets = response;
		});
		
		//Starts countdown
		var dString = "Dec 4, 2013 7:00 PST";
		var d1 = new Date(dString);
		var d2 = new Date();
		
		$scope.countdown = Math.floor((d1.getTime() - d2.getTime())/1000);
	}
	
	//Loges email for newsletter
	$scope.subscribe = function() {
		Analytics.general('Newsletter');
		$scope.notification	= 'Newsletter subscribed. Thank you!';
		
		$timeout(function() {
			$scope.notification = false;
		}, timeout);
		
/*
		var post 		= $scope.newsletter;
			post.route	= 'newsletter';
			
		Rest.post(post).then(function(response) {
			Analytics.general('Newsletter');
			$scope.newsletter	= {};
			$scope.notification	= 'Newsletter subscribed. Thank you!';
			
			$timeout(function() {
				$scope.notification = false;
			}, timeout);
		});
*/
	}
	
	//Randomizes the orderBy results
	$scope.random = function(){
    	return 0.5 - Math.random();
	}
	
	//Logs click-thrus	
	$scope.trackEvent = function(action, location) {
		switch(action) {
			case 'link':
				Analytics.link(location);
				break;
		}
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
				var label = (type === 'twitter')? 'Twitter': 'Facebook';
				Analytics.general('Vote', model.meta.title, label);
/*
				var message, link;
				switch(type) {
					case 'facebook':
						message	= 'Voted for #'+model.meta.hashtag+' for Machinima\'s Gamers Choice Award. Who will you vote for? #IGAs http://...';
						link 	= 'http://www.facebook.com/sharer.php'+
									'?s=100'+
									'&p[url]='+domain+
									'&p[images][0]='+domain+'/img/games/'+model.meta.image+
									'&p[title]=Inside Gaming Awards 2013'+
									'&p[summary]='+encodeURIComponent(message);
						Analytics.general('Vote', model.meta.title, 'Facebook');
						break;
					case 'twitter':
						message = 'Voted for #'+model.meta.hashtag+' for Gamers Choice Award. Who will you vote for? #IGAs http://...'
						link 	= 'https://twitter.com/share?url=/&text='+encodeURIComponent(message);
						Analytics.general('Vote', model.meta.title, 'Twitter');
						break;
				}
				window.open(link, '_blank');
*/
			} else {
				Analytics.general('Vote', model.meta.title, 'General');
			}
		});
	}	
}

igaController.$inject = ['$scope', 'Rest', '$timeout', 'Analytics'];