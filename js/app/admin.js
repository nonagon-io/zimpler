angular.module("admin", ['generic-modal', 'ngAnimate'])

.directive('shortcut', function() {
	return {
		restrict: 'E',
		replace: true,
		scope: true,
		link: function(scope, elem, attrs) {
			
			jQuery(document).on('keydown', function(e){
				
				scope.$apply(scope.keyDown(e));
			});
		}
	};
})

.directive('nDirtyCheck', function() {
	return {
		restrict: 'A',
		link: function(scope, elem, attrs) {
			
			window.onbeforeunload = function (event) {
				
				if(!$(elem).hasClass("ng-dirty"))
					return;
				
				var message = 
					'If you leave this page now you are going to lose all unsaved changes.';
				
				return message;
			}
		}
	}
	
})

.factory('httpEx', ['$http', '$sce', function($http, $sce) {
	
	return function($scope, method, url, data) {
		
		$scope.connectionError = false;
			
		if(method == "POST" || method == "PUT" || method == "DELETE") {
			
			if(!data) data = {};
			
			for(var n in $scope.csrf)
				data[n] = $scope.csrf[n];
				
			return $http({ 
				
				method: method,
				url: ($scope.baseUrl ? $scope.baseUrl : "") + url, 
				data: $.param(data),
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			});
			
		} else {
			
			var params = "";
			if(data) {
				
				params = "?" + $.param(data);
			}
			
			return $http({ 
				
				method: method,
				url: $scope.baseUrl + url + params
			}).
			error(function(data, status, headers, config) {
				
				$scope.connectionError = true;
				
				if(status == 0) {
				
					$scope.connectionErrorMessage = $sce.trustAsHtml(
						"Network error. Please check your internet connection and try again.");
						
				} else if(status == 401) {
					
					$scope.connectionErrorMessage = $sce.trustAsHtml(
						"You don't have permission to view the resource.");
						
				} else if(status >= 500) {
					
					$scope.connectionErrorMessage = $sce.trustAsHtml(
						"We are sorry but there is the problem during processing your request.<br/>" +
						"If problem persists, please contact your system administrator.");
						
				} else {
					
					$scope.connectionErrorMessage = $sce.trustAsHtml(
						"We are sorry but unknown error has just occorred :(<br/>" +
						"If problem persists, please contact your system administrator.");
				}
			});
		}
	};
}])

.factory('submitForm', ['$q', 'httpEx', function($q, httpEx) {
	
	function defaultPromise(promise) {
		
		promise.success = function(fn) {
			
			promise.then(function() {
				fn.apply(this, arguments);
			});
			
			return promise;
		}
		
		promise.error = function(fn) {
			
			promise.then(null, function() {
				fn.apply(this, arguments);
			})
			
			return promise;
		}
		
		return promise;
	}
	
	return function($scope, formName, url) {
		
		var defer = $q.defer();
		
		if(!$scope[formName].$valid) {
			return defaultPromise(defer.promise);
		}
		
		var method = "POST";
		if($scope.editingData.id) {
			
			method = "PUT";
		}
	
		return httpEx($scope, method, url, $scope.editingData);
	};
}])

.factory('checkFormDirty', ['$q', 'modal', function($q, modal) {
	
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

	return function($scope, formName) {
		
		var defer = $q.defer();
		
		if($scope[formName].$dirty) {
			
			modal.show(
				"If you continue all changes you have been made will be lost.<br/>" +
				"Are you sure you want to continue?", "Unsafe changes detected", {
					
					danger: true,
					bgclose: true,
					okTitle: "Continue",
					icon: "exclamation-circle"
				})
				.ok(function() {
					
					defer.resolve();
				})
				.cancel(function() {
					
					defer.reject();
				})
				
			return confirmPromise(defer.promise);
		}
		
		var promise = confirmPromise(defer.promise);
		
		defer.resolve();
		
		return promise;
	};
}])

.controller('AdminController', function($scope, $rootScope, $locale) {
	
	var mainContentBody = $(".n-body .n-content");
	var propertiesBody = $(".n-properties-panel .n-body");

	$scope.mainContentBodyScrollTop = 0;
	$scope.mainContentBodyScrollMaxReached = false;
	
	$rootScope.isPropertiesPanelOpen = false;
	
	$scope.propertyPanelScrollTop = 0;
	$scope.propertyPanelScrollMaxReached = false;
	
	$rootScope.openPropertiesPanel = function() {
		
		$rootScope.isPropertiesPanelOpen = true;
		
		propertiesBody.scrollTop(0);
		
		setTimeout(function() {
			propertiesBody.find(':input:visible:enabled:first').focus();
		}, 300);
	}
	
	$rootScope.closePropertiesPanel = function() {
		
		$rootScope.isPropertiesPanelOpen = false;
	}

	$(".n-properties-panel .n-body").on("scroll", function() {
		
		$scope.$apply(function() {
			
			var scrollBottom = propertiesBody.scrollTop() + propertiesBody.outerHeight();
			
			$scope.propertyPanelScrollTop = propertiesBody.scrollTop();
			$scope.propertyPanelScrollMaxReached = scrollBottom >= propertiesBody.prop("scrollHeight");
		});
	});
	
	$(".n-body .n-content").on("scroll", function() {
		
		$scope.$apply(function() {
			
			var scrollBottom = mainContentBody.scrollTop() + mainContentBody.outerHeight();
			
			$scope.mainContentBodyScrollTop = mainContentBody.scrollTop();
			$scope.mainContentBodyScrollMaxReached = scrollBottom >= mainContentBody.prop("scrollHeight");
		});
	});
	
	$(function() {
		
		$("table").freezeHeader(); 
	});
});