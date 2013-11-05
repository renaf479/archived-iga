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
		link: ['scope', 'element', 'attrs', function(scope, attrs, element) {
			element.bind('click', function() {
				var action = element.hasClass('right')? 'Next': 'Prev';
				Analytics.general('Twitter Ticker', action);
			});
		}]
	}
}]);


		/*
link: function(scope, element, attrs) {
			element.bind('click', function() {
				var action = element.hasClass('right')? 'Next': 'Prev';
				Analytics.general('Twitter Ticker', action);
			})
		}
*/



/*
var myModule = angular.module('myModule', []);
myModule.directive('breaksWhenMinified', ['anyService', function(anyService) {
  return {
    restrict: 'A',
    controller: function($scope, $attrs, $element) {
        alert($scope.whatever);
    }
});


var myModule = angular.module('myModule', []);
myModule.directive('breaksWhenMinified', ['anyService', function(anyService) {

  return {
    restrict: 'A',
    controller: ['$scope', '$attrs', '$element', function($scope, $attrs, $element) {
      alert($scope.whatever);
    }]
 };

});
*/