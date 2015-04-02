angular.module("cms-siteinfo", ['common', 'generic-modal', 'admin', 'ngAnimate', 'ui.codemirror'])

.controller("CmsDesignController", 
	['$scope', '$rootScope', '$window', '$location', 'submitForm', 
		'checkFormDirty', 'propertiesPanel', 'httpEx', 'modal',
	function($scope, $rootScope, $window, $location, submitForm, 
				checkFormDirty, propertiesPanel, httpEx, modal) {

	$scope.items = [];
	$scope.currentView = "list";
	$scope.fullScreen = false;
	$scope.componentExpanded = false;
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

	$scope.switchToCanvasView = function() {

		codeToCanvas();
		$scope.designerView = "edit-canvas";
	}

	$scope.switchToCodeView = function() {

		canvasToCode();
		$scope.designerView = "edit-code";
	}

	function codeToCanvas() {

	}

	function canvasToCode() {

		var panels = $scope.designer.panels;
		var code = _canvasToCode(panels, "v", 1);

		console.debug(code);
	}

	function _canvasToCode(panels, mode, level) {

		if(mode == "v") {

			// Sort by row.
			panels.sort(function(a, b) { return a.row - b.row; });

		} else {

			// Sort by col.
			panels.sort(function(a, b) { return a.col - b.col; });
		}

		var code = "";

		// Go through each panel to create vertical/horizontal groups.
		var groups = [];
		var group = {

			panels: [],
			start: 0,
			size: 0
		};

		_.each(panels, function(panel) {

			if(group.panels.length == 0) {

				group.panels.push(panel);

				group.start = (mode == "v" ? panel.row : panel.col);
				group.size = (mode == "v" ? panel.sizeY : panel.sizeX);

			} else {

				var newGroup = false;

				if(mode == "v") {
					newGroup = panel.row >= (group.start + group.size);
				} else {
					newGroup = panel.col >= (group.start + group.size);
				}

				if(newGroup) {

					groups.push(group);
					group = {

						panels: [],
						start: mode == 'v' ? panel.row : panel.col,
						size: 0
					};
				}

				group.panels.push(panel);

				if(mode == "v") {
					if(panel.row + panel.sizeY > group.start + group.size)
						group.size = (panel.row + panel.sizeY) - group.start;
				} else {
					if(panel.col + panel.sizeX > group.start + group.size)
						group.size = (panel.col + panel.sizeX) - group.start;
				}
			}
		});

		groups.push(group);

		console.debug(groups);

		_.each(groups, function(group) {

			var indent = Array(level).join("\t");

			if(group.panels.length == 1) {

				if(mode == "v") {

					code = code.concat(indent + "<div></div>\r\n");

				} else {

					var totalSize = _(groups).sum(function(group) { return group.size; });
					var gcd = _gcd(group.size, totalSize);

					var cls = "uk-width-" + (group.size / gcd) + "-" + (totalSize / gcd);

					code = code.concat(indent + "<div class=\"" + cls + "\"></div>\r\n");
				}

			} else if(group.panels.length > 1) {

				var nextLevel = level + 1;

				if(mode == "v") {

					code = code.concat(indent + "<div class=\"uk-grid uk-grid-collapse\">\r\n");
					code = code.concat(_canvasToCode(group.panels, mode == "v" ? "h" : "v", nextLevel));
					code = code.concat(indent + "</div>\r\n");

				} else {

					var cls = "uk-width-" + group.size + "-10";

					code = code.concat(indent + "<div class=\"" + cls + "\">\r\n");
					code = code.concat(_canvasToCode(group.panels, mode == "v" ? "h" : "v", nextLevel));
					code = code.concat(indent + "</div>\r\n");
				}
			}
		});

		return code;
	}

	function _gcd (a, b) {

	    if(!b) return a;
	    return _gcd(b, a % b);
	};

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

			parent.panels.push({ sizeX: 10, sizeY: 2, row: targetRow, col: 0 })
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
		},

		clearActivePanel: function($event) {

			if($($event.target).hasClass("n-canvas-panel")) {

				this.activePanel = null;
				this.hideProperties();
			}
		},

		showProperties: function() {

			$scope.componentExpanded = true;
		},

		hideProperties: function() {

			$scope.componentExpanded = false;
		}
	};

}]);