angular.module("cms-siteinfo", ['common', 'generic-modal', 'admin', 'ngAnimate'])

.controller("CmsDesignController", 
	['$scope', '$rootScope', '$window', '$location', 'submitForm', 
		'checkFormDirty', 'propertiesPanel', 'httpEx', 'modal',
	function($scope, $rootScope, $window, $location, submitForm, 
				checkFormDirty, propertiesPanel, httpEx, modal) {

	$scope.items = [];
	$scope.currentView = "list";

	$scope.add = function() {

		$scope.currentView = "designer";
	};

	$scope.cancel = function() {

		$scope.currentView = "list";
	};

}]);