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
	$scope.codeView = "html";

	$scope.add = function() {

		$scope.currentView = "designer";
	};

	$scope.cancel = function() {

		$scope.currentView = "list";
	};

	$scope.toggle = function(flag) {

		$scope[flag] = !$scope[flag];
	}

	$scope.designer = {

		panels: [],

		activePanel: null,

		options: {

			columns: 10,
			rowHeight: 50,
			margins: 0
		},

		add: function(parent, type) {

			if(!parent.panels)
				parent.panels = [];

			parent.panels.push({ size: { x: 2, y: 1 }, position: [0, 0] })
		},

		setActive: function(parent, panel) {

			parent.activePanel = panel;
		}
	};

}]);