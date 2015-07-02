angular.module("admin-cms-contents", ["common", "generic-modal", "admin", "admin-cms", "ngAnimate"])

.config(['$locationProvider', function AppConfig($locationProvider) {

    $locationProvider.html5Mode(true);
    $locationProvider.hashPrefix('?');

}])

.controller("CmsContentController", 
	function($scope, $rootScope, $locale, $location, $timeout, httpEx, 
			 submitForm, propertiesPanel, cmsConfirmPublish, cmsPublish, 
			 cmsNewRev, cmsConfirmDelRev, cmsDelRev, fileManagerPopup, checkFormDirty) {

	$scope.list = null;
	$scope.selectedItem = null;
	$scope.propertiesPanel = propertiesPanel;
	$scope.currentUserId = null;
	$scope.isRefreshing = false;
	$scope.isKeywordActive = false;
	$scope.currentCulture = $location.search().c || "en-us";
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
		var culture = $location.search()['c'];
		var pageSize = 20;

		$scope.searchKeyword = keyword;
		$scope.isKeywordActive = $scope.searchKeyword;

		if(!page) page = 0;

		var params = {

			skip: page * pageSize,
			take: pageSize,
			culture: $scope.currentCulture
		};

		if(keyword)
			params["keyword"] = keyword;

		httpEx($scope, "GET", $scope.baseUrl + "cms/rest/content/list", params).
			success(function(data, status, headers, config) {

				$scope.list = data;
				$scope.isRefreshing = false;

				if($scope.selectedItem) {

					var newSelectedItem = _.filter($scope.list.items, function(item) {

						return item.id == $scope.selectedItem.id;
					})[0];

					$scope.selectedItem = newSelectedItem;
				}

				UIkit.pagination($(".uk-pagination").get()[0], {

					items: data.total,
					itemsOnPage: pageSize,
					currentPage: Math.floor(data.from / params.take) + 1
				});

			});
	}

	$scope.detectSearch = function($event) {

		if($event.keyCode == 13) {

			$scope.search();
		}
	}

	$scope.search = function() {

		$location.search({ p: 0, q: $scope.searchKeyword, c: $scope.currentCulture });
	}

	$scope.clearSearch = function() {

		$scope.searchKeyword = "";
		$scope.search({ c: $scope.currentCulture });
	}

	$scope.select = function(item) {

		var proceedLoadContent = function() {

			$scope.isLoadingEditingData = true;

			var params = {

				key: item.key,
				culture: $scope.currentCulture
			}

			httpEx($scope, "GET", $scope.baseUrl + "cms/rest/content", params).
				success(function(data, status, headers, config) {

					if(!data.culture)
						data.culture = $scope.currentCulture;

					$scope.editingData = data;
					$scope.editingData.headerTitle = data.title;

					$timeout(function() {
						$scope.propertiesPanel.propertiesForm.$setPristine();
						$scope.propertiesPanel.propertiesForm.$setUntouched();
					}, 1);

					$scope.isLoadingEditingData = false;
				}).
				error(function(data, status, headers, config) {

					$scope.isLoadingEditingData = false;
				});
		}

		var checkedItems = $.grep($scope.list.items, function(item, i) {
			
			return item.checked;
		});
		
		if(checkedItems.length > 0) return;
		
		if($scope.propertiesPanel.isOpen) {
			
			// Verify if current properties dirty.
			checkFormDirty($scope.propertiesPanel.propertiesForm).
				confirm(function() {
					
					$scope.selectedItem = item;

					proceedLoadContent();

					$timeout(function() {
						$scope.propertiesPanel.propertiesForm.$setPristine();
						$scope.propertiesPanel.propertiesForm.$setUntouched();
					}, 1);
				});
				
		} else {
			
			$scope.selectedItem = item;
			$scope.propertiesPanel.open($scope,
				"uk-width-1-1 uk-width-medium-2-3 uk-width-large-1-2");
			
			proceedLoadContent();
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

	$scope.persistPageParameterChanged = function() {

		var query = $location.search();
		query.c = $scope.currentCulture;

		$location.search(query);
	}

	$scope.$on("$locationChangeSuccess", function() {

		$scope.refresh();
	});

	$scope.propertiesPanel.on("save", function(params, callback) {

		$scope.propertiesPanel.propertiesForm.key.$error.duplicated = false;
		
		var action = $("form[name='propertiesPanel.propertiesForm']").attr("action");

		var method = "POST";
		if($scope.editingData.id) {
			
			method = "PUT";
		}
		
		submitForm($scope, $scope.propertiesPanel.propertiesForm, 
			method, action, $scope.editingData).
			success(function(data, status, headers, config) {

				if(data.error) {

					if(data.error == "content_key_exists")
						$scope.propertiesPanel.propertiesForm.key.$error.duplicated = true;

					return;
				}
				
				if(method == "POST") {

					$scope.editingData = data.content;
					$scope.editingData.headerTitle = data.content.title;

					$scope.selectedItem = $scope.editingData;

					$scope.refresh();

				} else {

					$scope.selectedItem.headerTitle = data.content.title;

					$scope.selectedItem.publicTitle = data.content.publicTitle;
					$scope.selectedItem.group = data.content.group;
					$scope.selectedItem.description = data.content.description;
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

		$("#cultureSelection").val(data);
		$scope.currentCulture = data;
		$scope.persistPageParameterChanged();

		var params = {

			key: $scope.editingData.key,
			culture: $scope.editingData.culture
		}

		httpEx($scope, "GET", $scope.baseUrl + "cms/rest/content", params).
			success(function(data, status, headers, config) {

				if(!data.culture)
					data.culture = $scope.editingData.culture;

				$scope.editingData = data;
				$scope.editingData.headerTitle = data.title;

				$timeout(function() {
					$scope.propertiesPanel.propertiesForm.$setPristine();
					$scope.propertiesPanel.propertiesForm.$setUntouched();
				}, 1);
			});
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

		$scope.$apply(function() {
			$scope.currentCulture = selectedCulture;
			$scope.persistPageParameterChanged();
		});
	});
});