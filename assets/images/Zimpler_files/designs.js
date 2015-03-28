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
			margins: 0,
			mobileModeEnabled: false,
			draggable: {
				enabled: true,
				start: function(e, el, widget) {

					$scope.designer.setActive($scope.designer, widget);
				}
			}
		},

		add: function(parent, type) {

			if(!parent.panels)
				parent.panels = [];

			var targetRow = 0;
			for(var i=0; i<parent.panels.length; i++) {

				var rowReach = parent.panels[i].row + parent.panels[i].sizeY;
				if(rowReach > targetRow)
					targetRow = rowReach;
			}

			parent.panels.push({ sizeX: 10, sizeY: 1, row: targetRow, col: 0 })
		},

		setActive: function(parent, panel) {

			parent.activePanel = panel;
		},

		delete: function(parent, panel) {

			parent.panels = $.grep(parent.panels, function(item) {

				return item != panel;
			});

			if(parent.activePanel == panel)
				parent.activePanel = null;
		}
	};

}]);