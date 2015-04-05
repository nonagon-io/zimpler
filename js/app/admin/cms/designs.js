angular.module("cms-siteinfo", ['common', 'generic-modal', 'admin', 'ngAnimate', 'ui.codemirror'])

.controller("CmsDesignController", 
	['$scope', '$rootScope', '$window', '$location', '$timeout', 
		'submitForm', 'checkFormDirty', 'propertiesPanel', 'httpEx', 'modal', 'keydownHandler',
	function($scope, $rootScope, $window, $location, $timeout, 
				submitForm, checkFormDirty, propertiesPanel, httpEx, modal, keydownHandler) {

	keydownHandler.handlers.push(function($event) {

		if($event.keyCode === 8) {

			$scope.$apply(function() {

				$scope.designer.delete(
					$scope.designer, 
					$scope.designer.activePanel);
			});
		}
	});

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

		$scope.designerView = "edit-code";

		$scope.designer.refreshEditor = true;
		$timeout(function () {
			$scope.designer.refreshEditor = false;
		}, 100);
	}

	function codeToCanvas() {

	}

	function canvasToCode() {

		try {

			var panels = $scope.designer.panels;
			var code = _canvasToCode(panels, "v", 1);

			$scope.designer.html = code;

		} catch(e) {

			$scope.designer.valid = false;
			return false;
		}

		$scope.designer.valid = true;
		return true;
	}

	function _canvasToCode(panels, mode, level, horzCells, horzStarts) {

		if(panels.length == 0) return;

		if(mode == "v") {

			// Sort by row.
			panels.sort(function(a, b) { 

				if(a.row != b.row) return a.row - b.row;
				else return a.col - b.col
			});

		} else {

			// Sort by col.
			panels.sort(function(a, b) { 

				if(a.col != b.col) return a.col - b.col; 
				else return a.row - b.row;
			});
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

				group.col = (mode == "v" ? panel.col : 0);
				group.row = (mode == "h" ? panel.row : 0);

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

					group.col = (mode == "v" ? panel.col : 0);
					group.row = (mode == "h" ? panel.row : 0);
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

		_.each(groups, function(group) {

			var indent = Array(level).join("\t");

			var singlePanel = (group.panels.length == 1) &&
				(mode == 'v' && _(group.panels).first().col == 0 || mode == 'h');

			if(singlePanel) {

				var firstItem = _(group.panels).first();

				if(mode == "v") {

					var cls = "";

					if(firstItem) {
						cls = cls.concat("zm-height-" + firstItem.sizeY);

						if(firstItem.sizeX < 10)
							cls = cls.concat(" uk-width-" + firstItem.sizeX + "-10");
					}

					code = code.concat(indent + "<div class=\"" + cls + "\"></div>\r\n");

				} else {

					var totalSize = 10;
					if(horzCells) totalSize = horzCells;

					var cls = "uk-width-" + group.size + "-" + totalSize;

					if(firstItem && firstItem.cls)
						cls = cls.concat(" " + firstItem.cls);

					if(firstItem) {
						cls = cls.concat(" " + "zm-height-" + firstItem.sizeY);
					}

					code = code.concat(indent + "<div class=\"" + cls + "\"></div>\r\n");
				}

			} else {

				var nextLevel = level + 1;

				if(mode == "v") {

					var expectHorzStart = horzStarts || 0;
					var updatedPanels = [];

					for(var i=0; i<group.panels.length; i++) {

						var panel = group.panels[i];
						var blankCols = panel.col - expectHorzStart;

						if(blankCols > 0) {

							var blankPanel = {

								cls: "zm-invisible",
								row: panel.row, 
								col: expectHorzStart, 
								sizeX: blankCols, 
								sizeY: panel.sizeY
							}

							updatedPanels.push(blankPanel);
						}

						updatedPanels.push(panel);
						expectHorzStart = panel.col + panel.sizeX;
					}

					code = code.concat(indent + "<div class=\"uk-grid uk-grid-collapse\">\r\n");
					code = code.concat(_canvasToCode(updatedPanels, 
						mode == "v" ? "h" : "v", nextLevel, horzCells, horzStarts));
					code = code.concat(indent + "</div>\r\n");

				} else if(mode == "h") {

					var totalSize = 10;
					if(horzCells) totalSize = horzCells;

					var cls = "uk-width-" + group.size + "-" + totalSize;

					code = code.concat(indent + "<div class=\"" + cls + "\">\r\n");
					code = code.concat(_canvasToCode(group.panels, 
						mode == "v" ? "h" : "v", nextLevel, group.size, group.start));
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

	$scope.keyDown = function(e) {

		if(e.keyCode == 27) {

			if($scope.componentExpanded) {
				$scope.designer.hideProperties();
				return;
			}

			if($scope.designer.activePanel) {
				$scope.designer.clearActivePanel();
				return;
			}
		}
	}

	$scope.designer = {

		valid: true,

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
				},
				stop: function(e, el, widget) {

					canvasToCode();
				}
			}, 
			resizable: {
				enabled: true,
				stop: function(e, el, widget) {

					canvasToCode();
				}
			}
		},

		refreshEditor: false,

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

			canvasToCode();
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

			if($event) {

				var target = $($event.target);

				if(target.hasClass("n-canvas-panel") ||
					target.hasClass("n-inner-panel") ||
					target.hasClass("n-layout-grid") ||
					target.hasClass("gridster")) {

					this.activePanel = null;
					this.hideProperties();
				}

			} else {

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