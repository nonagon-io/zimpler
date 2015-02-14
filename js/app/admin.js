angular.module("admin", ['common', 'generic-modal', 'ngAnimate'])

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