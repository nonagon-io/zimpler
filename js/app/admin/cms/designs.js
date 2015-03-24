angular.module("cms-siteinfo", ['common', 'generic-modal', 'admin', 'ngAnimate'])

.controller("CmsDesignController", 
	['$scope', '$rootScope', '$window', '$location', 'submitForm', 'checkFormDirty', 'propertiesPanel', 'httpEx', 'modal',
	function($scope, $rootScope, $window, $location, submitForm, checkFormDirty, propertiesPanel, httpEx, modal) {

	$scope.items = [];

	$scope.add = function() {

		$scope.items.push({

			id: 1,
			name: "Untitled",
			thumbnail: null
		});
	};

}]);