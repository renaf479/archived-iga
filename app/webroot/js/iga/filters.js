'use strict';

angular.module('igaApp.filters', [])
	.filter('createAlias', function() {
		return function(input) {
			if(input) return input.replace(/ /g,'-').toLowerCase();
		}
	});