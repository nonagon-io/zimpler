angular.module("admin-cms", ['generic-modal', 'admin'])

.factory('cmsConfirmPublish', ['$q', 'modal', function($q, modal) {
	
	function confirmPromise(promise) {
		
		promise.confirm = function(fn) {
			
			promise.then(function() {
				fn.apply(this, arguments);
			});
			
			return promise;
		}
		
		promise.cancel = function(fn) {
			
			promise.then(null, function() {
				fn.apply(this, arguments);
			})
			
			return promise;
		}
		
		return promise;
	}

	return function($scope) {
		
		var defer = $q.defer();
		
		modal.show(
			"You are about to publish this content over the internet.<br/>" +
			"Are you sure you want to continue?", "Confirmation", {
				
				danger: false,
				bgclose: true,
				okTitle: "Yes",
				icon: "info-circle"
			})
			.ok(function() {
				
				defer.resolve();
			})
			.cancel(function() {
				
				defer.reject();
			})
			
		return confirmPromise(defer.promise);
	};
}])

.factory('cmsConfirmDelRev', ['$q', 'modal', function($q, modal) {
	
	function confirmPromise(promise) {
		
		promise.confirm = function(fn) {
			
			promise.then(function() {
				fn.apply(this, arguments);
			});
			
			return promise;
		}
		
		promise.cancel = function(fn) {
			
			promise.then(null, function() {
				fn.apply(this, arguments);
			})
			
			return promise;
		}
		
		return promise;
	}

	return function($scope) {
		
		var defer = $q.defer();
		
		modal.show(
			"You are about to delete this content revision.<br/>" +
			"Are you sure you want to continue?", "Confirmation", {
				
				danger: true,
				bgclose: true,
				okTitle: "Yes",
				icon: "exclamation-circle"
			})
			.ok(function() {
				
				defer.resolve();
			})
			.cancel(function() {
				
				defer.reject();
			})
			
		return confirmPromise(defer.promise);
	};
}])

.factory('cmsPublish', ['httpEx', function(httpEx) {
	
	return function($scope, contentKey, culture) {
		
		return httpEx($scope, "PUT", 
			"cms/api/content/publish/" + 
				contentKey + "/" + culture);
	};
}])

.factory('cmsNewRev', ['httpEx', function(httpEx) {
	
	return function($scope, contentKey, culture) {
		
		return httpEx($scope, "POST", 
			"cms/api/content/revision/" + 
				contentKey + "/" + culture);
	};
}])

.factory('cmsDelRev', ['httpEx', function(httpEx) {
	
	return function($scope, contentKey, culture, revision) {
		
		return httpEx($scope, "DELETE", 
			"cms/api/content/revision/" + 
				contentKey + "/" + culture + "/" + revision);
	};
}]);