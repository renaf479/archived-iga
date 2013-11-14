//Associates correct image coordinates with game
igaApp.directive('gameArt', [function() {
	return {
		replace: true,
		restrict: 'E',
		scope: {
			ngModel: '='	
		},
		template: '<div class="" style="background-image: url(/img/games/{{ngModel.meta.image}})"></div>'
	}
}]);

igaApp.directive('carouselControl', ['Analytics', function(Analytics) {
	return {
		restrict: 'C',
		link: function(scope, element, attrs) {
			element.bind('click', function() {
				var action = element.hasClass('right')? 'Next': 'Prev';
				Analytics.general('Twitter Ticker', action);
			});
		}
	}
}]);

igaApp.directive('voteButton', ['Analytics', function(Analytics) {
	return {
		replace: 	true,
		restrict: 	'E',
		scope: {
			ngClick:	'&',
			ngDisabled:	'=',
			ngModel:	'=',
			type:		'@'
		},
		template: 	'<div}"><a href="{{link}}" target="_blank" class="gameVote-{{type}} transition" data-ng-click="ngClick()" data-ng-disabled="ngDisabled">{{voteDisabled}}</a></div>',
		transclude: true,
		link: function(scope, element, attrs) {
			var message;
			switch(attrs.type) {
				case 'facebook':
					message		= 'Voted for #'+scope.ngModel.meta.hashtag+' for Machinima\'s Gamers Choice Award. Who will you vote for? #IGAs http://awe.sm/bHBdz';
					scope.link 	= 'http://www.facebook.com/sharer.php'+
								'?s=100'+
								'&p[url]='+encodeURIComponent('http://insidegamingawards.com')+
								'&p[images][0]='+encodeURIComponent('http://insidegamingawards.com/img/games/'+scope.ngModel.meta.image)+
								'&p[title]='+encodeURIComponent('Inside Gaming Awards 2013')+
								'&p[summary]='+encodeURIComponent(message);
					break;					
				case 'twitter':
					message 	= 'Voted for #'+scope.ngModel.meta.hashtag+' for Gamers Choice Award. Who will you vote for? #IGAs http://awe.sm/bHBdz'
					scope.link 	= 'https://twitter.com/share?url=/&text='+encodeURIComponent(message);
					break;
			}	
		}
	}
}]);