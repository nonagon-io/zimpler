angular.module("cms-siteinfo", ['common', 'generic-modal', 'admin', 'ngAnimate', 'ui.codemirror'])

.controller("CmsDesignController", 
	['$scope', '$rootScope', '$window', '$location', '$timeout', 
		'submitForm', 'checkFormDirty', 'propertiesPanel', 'httpEx', 'modal', 'keydownHandlers',
	function($scope, $rootScope, $window, $location, $timeout, 
				submitForm, checkFormDirty, propertiesPanel, httpEx, modal, keydownHandlers) {

	keydownHandlers.push(function($event) {

		if($event.keyCode === 8) {

			$scope.$apply(function() {

				$scope.designer.delete(
					$scope.designer.activePanel);
			});

		} else if($event.keyCode === 27) {

			$scope.$apply(function() {

				if($scope.componentExpanded) {
					$scope.designer.hideProperties();
					return;
				}

				if($scope.designer.activePanel) {
					$scope.designer.clearActivePanel();
					return;
				}
			});

		} else if($event.keyCode === 70) { // "f"

			if($scope.currentView == "designer") {

				$scope.$apply(function() {
					$scope.toggle("fullScreen");
				});
			}
		} else if($event.shiftKey && $event.keyCode == 187) { // "+"

			if($scope.currentView == "designer") {

				$scope.$apply(function() {
					
					$scope.designer.add($scope.designer, "panel");
				});
			}
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

		$scope.codeToCanvas();
		$scope.designerView = "edit-canvas";
	}

	$scope.switchToCodeView = function() {

		$scope.canvasToCode();

		$scope.designerView = "edit-code";

		$scope.designer.refreshEditor = true;
		$timeout(function () {
			$scope.designer.refreshEditor = false;
		}, 100);
	}

	$scope.codeToCanvas = function() {

	}

	$scope.canvasToCode = function() {

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

					var cls = [];

					if(firstItem) {

						if(firstItem.heightFactor == "grid") {
							cls.push("zm-height-" + firstItem.sizeY)
						} else if(firstItem.heightFactor == "fill") {
							cls.push("uk-height-1-1");
						}

						if(firstItem.css)
							cls.push(firstItem.css);

						if(firstItem.sizeX < 10)
							cls.push("uk-width-" + firstItem.sizeX + "-10");
					}

					if(cls.length) 
						cls = " class=\"" + cls.join(" ") + "\"";

					code = code.concat(indent + "<div" + cls + "></div>\r\n");

				} else {

					var totalSize = 10;
					if(horzCells) totalSize = horzCells;

					var cls = ["uk-width-" + group.size + "-" + totalSize];

					if(firstItem) {

						if(firstItem.heightFactor == "grid") {
							cls.push("zm-height-" + firstItem.sizeY)
						} else if(firstItem.heightFactor == "fill") {
							cls.push("uk-height-1-1");
						}

						if(firstItem.css)
							cls.push(firstItem.css);
					}

					code = code.concat(indent + "<div class=\"" + cls.join(" ") + "\"></div>\r\n");
				}

			} else {

				var nextLevel = level + 1;

				if(mode == "v") {

					var expectHorzStart = horzStarts || 0;
					var updatedPanels = [];
					var hasAnyFullHeight = false;

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

						if(panel.heightFactor == "fill")
							hasAnyFullHeight = true;
					}

					var cls = ["uk-grid uk-grid-collapse"];

					if(hasAnyFullHeight)
						cls.push("uk-height-1-1");

					code = code.concat(indent + "<div class=\"" + cls.join(" ") + "\">\r\n");

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

	$scope.designer = {

		canvasView: "large",

		valid: true,
		panels: [],
		activePanel: null,

		css: "",
		heightFactor: "auto",

		fillSizeY: 12,

		options: {

			columns: 10,
			rowHeight: 50,
			margins: 0,
			mobileModeEnabled: false,
			draggable: {
				enabled: true,
				start: function(e, el, widget) {

					$scope.designer.setActive(widget);
				},
				stop: function(e, el, widget) {

					$scope.designer.determineAdjacentsAttributes(widget);
					$scope.canvasToCode();
				}
			}, 
			resizable: {
				enabled: true,
				stop: function(e, el, widget) {

					$scope.designer.determinePanelAttributes(widget);
					$scope.canvasToCode();
				}
			}
		},

		refreshEditor: false,

		setCanvasView: function(view) {

			this.canvasView = view;
			this.options.draggable.enabled = (view == 'large');
		},

		add: function(type) {

			if(!this.panels)
				this.panels = [];

			var targetCol = 0;
			var targetRow = 0;
			var targetSizeX = 10;
			var targetSizeY = 2;
			var targetHeightFactor = "grid";

			for(var i=0; i<this.panels.length; i++) {

				var panel = this.panels[i];
				var rowReach = panel.row;

				rowReach += panel.sizeY;

				if(panel.col + panel.sizeX >= 10) {

					targetCol = 0;
					targetSizeX = 10;
					targetSizeY = 2;
					targetHeightFactor = "grid";

				} else {

					targetCol = panel.col + panel.sizeX;
					targetSizeX = this.options.columns - targetCol;
					targetSizeY = panel.sizeY;

					if(panel.heightFactor == "fill")
						targetHeightFactor = "fill";
				}

				if(rowReach > targetRow)
					targetRow = rowReach;
			}

			this.panels.push({ 

				sizeX: targetSizeX, 
				sizeY: targetSizeY, 
				row: targetRow, 
				col: targetCol,

				heightFactor: targetHeightFactor,
				type: 'container',

				container: {

					columns: 10,
					rowHeight: 5
				},

				content: {

					html: null
				},
				nav: {

					levels: 2
				},
				slide: {

					transition: "fade",
					slices: 10,
					kenburns: "false",
					duration: 1000,
					autoplay: "true",
					autoplayInterval: 7000,
					videoautoplay: "true",
					videomute: "true",
				},
				items: {

					layout: "basic"
				}
			});

			$scope.canvasToCode();
		},

		setActive: function(panel) {

			this.activePanel = panel;
		},

		delete: function(panel) {

			this.panels = $.grep(this.panels, function(item) {

				return item != panel;
			});

			if(this.activePanel == panel)
				this.activePanel = null;

			// HACK: Wait until all animation finished. 
			// Still does not see other way else to do.
			setTimeout(function() {

				$scope.$apply(function() {
					$scope.designer.determineEachRowAttributes();
				});

			}, 700);
		},

		clearActivePanel: function($event) {

			if($event) {

				var target = $($event.target);

				if(target.hasClass("n-canvas-panel") ||
					target.hasClass("n-inner-panel") ||
					target.hasClass("n-layout-grid") ||
					target.hasClass("gridster")) {

					this.activePanel = null;
				}

			} else {

				this.activePanel = null;
			}
		},

		showProperties: function() {

			$scope.componentExpanded = true;
		},

		hideProperties: function() {

			$scope.componentExpanded = false;
		},

		panelHeightFactorChanged: function() {

			if(this.activePanel.heightFactor == "fill") {

				this.activePanel.sizeY = this.fillSizeY;

				for(var i=0; i<this.panels.length; i++) {

					var panel = this.panels[i];
					if(panel.row == this.activePanel.row) {

						panel.heightFactor = this.activePanel.heightFactor;
						panel.sizeY = this.activePanel.sizeY;
					}
				}

			} else {

				// Move it away from the adjacent cells if any of panel of 
				// the same row has "fill" height factor.

				$this = this;

				var isAnyFill = _(this.panels).any(function(panel) {

					return panel.row == $this.activePanel.row && panel.heightFactor == "fill";
				});

				if(isAnyFill) {

					var bottomMost = _(this.panels).max(function(panel) {

						return panel.row + panel.sizeY;
					})

					this.activePanel.col = 0;
					this.activePanel.row = bottomMost.row + bottomMost.sizeY;
					this.activePanel.sizeX = this.options.columns;
				}
			}
		},

		determinePanelAttributes: function(panel) {

			if(panel.heightFactor != "fill") {

				// Change the height factor of the panel to 'fill' if any of the adjacent
				// panels having 'fill' height factor.

				var isAnyFill = _(this.panels).any(function(currentPanel) {

					return panel != currentPanel && 
							panel.row == currentPanel.row && 
							currentPanel.heightFactor == "fill";
				});

				if(isAnyFill) {

					 panel.heightFactor = "fill";
					 panel.sizeY = this.fillSizeY;
				}

			} else {

				// Change the height factor of the panel to 'grid' if any of the adjacent
				// panels are not having 'fill' height factor.

				var isAnyUnFill = _(this.panels).any(function(currentPanel) {

					return panel != currentPanel &&
							panel.row == currentPanel.row && 
							currentPanel.heightFactor != "fill";
				});

				if(isAnyUnFill) {

					 panel.heightFactor = "grid";
				}
			}
		},

		determineAdjacentsAttributes: function(panel) {

			if(panel.heightFactor != "fill") {

				// Change all adjacent panels height factor to 'grid' if the adjacent
				// panel having 'fill' height factor.

				for(var i=0; i<this.panels.length; i++) {

					var currentPanel = this.panels[i];
					if(panel != currentPanel &&
						currentPanel.row == panel.row && currentPanel.heightFactor == "fill") {

						currentPanel.heightFactor = "grid";
					}
				}
			} else {

				// Change all adjacent panels height factor to 'fill' if the adjacent
				// panel does not having 'fill' height factor.

				for(var i=0; i<this.panels.length; i++) {

					var currentPanel = this.panels[i];
					if(panel != currentPanel &&
						currentPanel.row == panel.row && currentPanel.heightFactor != "fill") {

						currentPanel.heightFactor = panel.heightFactor;
						currentPanel.sizeY = panel.sizeY;
					}
				}
			}
		},

		determineEachRowAttributes: function() {

			for(var i=0; i<this.panels.length; i++) {

				var panel = this.panels[i];

				if(panel.heightFactor == "fill") {

					// Change the height factor of the panel to 'grid' if any of the adjacent
					// panels are not having 'fill' height factor.

					var isAnyUnFill = _(this.panels).any(function(currentPanel) {

						return panel != currentPanel && 
								panel.row == currentPanel.row && 
								currentPanel.heightFactor != "fill";
					});

					if(isAnyUnFill) {

						panel.heightFactor = "grid";
					}
				}

				// Check for overflow sizeX of each panels.
				if(panel.sizeX > this.options.columns)
					panel.sizeX = this.options.columns;
			}
		}
	};
}]);