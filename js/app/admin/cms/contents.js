angular.module("admin-cms-contents", ["common", "generic-modal", "admin", "admin-cms", "ngAnimate"])

.controller("CmsContentController", 
	function($scope, $rootScope, $locale, $location, $timeout, httpEx, 
			 submitForm, propertiesPanel, cmsConfirmPublish, cmsPublish, 
			 cmsNewRev, cmsConfirmDelRev, cmsDelRev, fileManagerPopup) {

	$scope.list = null;
	$scope.selectedItem = null;
	$scope.propertiesPanel = propertiesPanel;
	$scope.currentUserId = null;
	$scope.isRefreshing = false;
	$scope.isKeywordActive = false;
	$scope.currentCulture = $location.search().culture || "en-us";
	$scope.currentCultureFullName = $("#cultureSelection option:selected").html().trim();
	$scope.fileManagerPopup = fileManagerPopup;

	$scope.tinymceOptions = {

		onChange: function(e) {
			// put logic here for keypress and cut/paste changes
		},
		file_browser_callback: ($scope.fileManagerSetting != "disable") ? 
			function(fieldName, url, type, win) {

				var fileManagerCommitCallback = function(fileItem) {

					var targetField = win.document.getElementById(fieldName);
					var container = $(targetField).parents(".mce-container-body");

					var widthElem = container.find("input[aria-label='Width']");
					var heightElem = container.find("input[aria-label='Height']");

					widthElem.val("80%");

					targetField.value = fileItem.url;
					
				}

				fileManagerPopup.open(fileManagerCommitCallback);

			} : null,
		inline: false,
		height: 300,
		menubar: false,
		plugins: 'advlist autolink link image lists charmap',
		skin: 'lightgray',
		theme : 'modern'
	};

	$scope.refresh = function() {

		$scope.isRefreshing = true;

		var page = $location.search()['p'];
		var keyword = $location.search()['q'];
		var pageSize = 20;

		$scope.searchKeyword = keyword;
		$scope.isKeywordActive = $scope.searchKeyword;

		if(!page) page = 0;

		var params = {

			skip: page * pageSize,
			take: pageSize
		};

		if(keyword)
			params["keyword"] = keyword;

		httpEx($scope, "GET", $scope.baseUrl + "cms/rest/content/list", params).
			success(function(data, status, headers, config) {

				$scope.list = data;

				$scope.isRefreshing = false;
			});
	}

	$scope.detectSearch = function($event) {

		if($event.keyCode == 13) {

			$scope.search();
		}
	}

	$scope.search = function() {

		$location.search({ p: 0, q: $scope.searchKeyword });
	}

	$scope.clearSearch = function() {

		$scope.searchKeyword = "";
		$scope.search();
	}

	$scope.select = function(item) {

		var checkedItems = $.grep($scope.list.items, function(item, i) {
			
			return item.checked;
		});
		
		if(checkedItems.length > 0) return;
		
		if($scope.propertiesPanel.isOpen) {
			
			// Verify if current properties dirty.
			checkFormDirty($scope.propertiesPanel.propertiesForm).
				confirm(function() {
					
					$scope.selectedItem = item;

					$scope.editingData = angular.copy(item);
					$scope.editingData.headerTitle = item.username;
				});
				
		} else {
			
			$scope.selectedItem = item;
			$scope.propertiesPanel.open($scope,
				"uk-width-1-1 uk-width-medium-2-3 uk-width-large-1-3");
			
			$scope.editingData = angular.copy(item);
			$scope.editingData.headerTitle = item.username;
			$scope.editingData.allowDelete = (item.id != $scope.currentUserId);
		}
	}

	$scope.newItem = function() {

		$scope.editingData = {
			
			headerTitle: "New Item",
			culture: $scope.currentCulture,
			status: "draft",
			revision: 1,
			type: "html"
		};
		
		$scope.propertiesPanel.open($scope, 
			"uk-width-1-1 uk-width-medium-2-3 uk-width-large-1-2");
	}

	$scope.$on("$locationChangeSuccess", function() {

		$scope.refresh();
	});

	$scope.propertiesPanel.on("save", function(params, callback) {
		
		var action = $("form[name='propertiesPanel.propertiesForm']").attr("action");

		var method = "POST";
		if($scope.editingData.id) {
			
			method = "PUT";
		}
		
		submitForm($scope, $scope.propertiesPanel.propertiesForm, 
			method, action, $scope.editingData).
			success(function(data, status, headers, config) {
				
				if(method == "POST") {
					
					$scope.editingData = data.content;
					$scope.editingData.headerTitle = data.content.title;
					
				} else {

					$scope.selectedItem.headerTitle = data.content.title;

					$scope.selectedItem.group = data.content.group;
					$scope.selectedItem.type = data.content.type;
					$scope.selectedItem.modified = data.content.modified;
					$scope.selectedItem.status = data.content.status;
				}
				
				callback(true);
			});
	});

	$scope.propertiesPanel.on("closed", function() {
		
		$scope.editingData = null;
		$scope.selectedItem = null;

		$timeout(function() {

			$scope.propertiesPanel.propertiesForm.$setPristine();
			$scope.propertiesPanel.propertiesForm.$setUntouched();

		}, 1);
	});

	$scope.propertiesPanel.on("culture-changed", function(data) {

		var name = $scope.propertiesPanel.dom(
			".n-culture-selection option:selected").html().trim();

		$scope.currentCultureFullName = name;
	});	

	$(".uk-pagination").on("select.uk.pagination", function(e, pageIndex) {

		$scope.$apply(function() {

			var query = $location.search();
			query.p = pageIndex;

	    	$location.search(query);
	    });
	});
	
	$("#cultureSelection").on("change", function() {
		
		var selectedCulture = $("#cultureSelection").val();
		$scope.currentCulture = selectedCulture;
		$scope.refresh();
	});
});