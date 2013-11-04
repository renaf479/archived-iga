'use strict';

angular.module('services', [])
	.factory('Rest', function($http) {
		var Rest = {
			get: function(action) {
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
	})
	.factory('Analytics', function() {
		var Analytics = {
			_track: function(action, label) {
				console.log('Logged Event: '+action+' > '+label);
				//_gaq.push(['_trackEvent', type]);
			},
			general: function(action, label) {
				this._track(action, label);	
			},
			event: function(action, label) {
				this._track(action, label);
			},
			link: function(label) {
				this._track('Link Click', label);
			}
		}
		return Analytics;
	});