angular.module("cms-siteinfo", ['common', 'generic-modal', 'admin', 'ngAnimate'])

.controller("CmsDesignController", 
	['$scope', '$rootScope', '$window', '$location', 'submitForm', 
		'checkFormDirty', 'propertiesPanel', 'httpEx', 'modal',
	function($scope, $rootScope, $window, $location, submitForm, 
				checkFormDirty, propertiesPanel, httpEx, modal) {

	$scope.items = [];
	$scope.currentView = "list";
	$scope.fullScreen = false;
	$scope.canvasExpanded = true;
	$scope.designerView = "edit-canvas";

	$scope.add = function() {

		$scope.currentView = "designer";
	};

	$scope.cancel = function() {

		$scope.currentView = "list";
	};

	$scope.toggle = function(flag) {

		$scope[flag] = !$scope[flag];
	}

}]);