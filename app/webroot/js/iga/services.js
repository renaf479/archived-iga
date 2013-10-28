'use strict';

angular.module('services', [])
	.factory('Rest', function($http) {
		var Rest = {
			get: function(action, type) {
				var promise = $http.get('/rest/get/'+action).then(function(response) {
					return response.data;
				});
				return promise;
			},
			post: function(data) {
				var promise = $http.post('/rest/post', data).then(function(response) {
					return response.data;
				});
				return promise;
			}
		};
		return Rest;
	});