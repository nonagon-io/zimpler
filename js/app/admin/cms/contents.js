angular.module("admin-cms-contents", ["common", "generic-modal", "admin", "admin-cms", "ngAnimate"])

.config(['$locationProvider', function AppConfig($locationProvider) {

    $locationProvider.html5Mode(true);
    $locationProvider.hashPrefix('?');

}])

.controller("CmsContentController", [
	"$scope", "$locale", "$location", "$timeout", "httpEx", "requestParams",
	"submitForm", "cmsPropertiesPanel", "fileManagerPopup", "checkFormDirty", 
	"checkableListManager", "modal", "keydownHandlers",
	function($scope, $locale, $location, $timeout, httpEx, requestParams,
			 submitForm, propertiesPanel, fileManagerPopup, checkFormDirty, 
			 checkableListManager, modal, keydownHandlers) {

	keydownHandlers.push(function($event) {

		if($event.keyCode === 27) {

			$scope.$apply(function() {

				$scope.propertiesPanel.close();
			});
		}
	});

	var headerCheckBox = null;

	$scope.list = null;
	$scope.selectedItem = null;
	$scope.lastEditedItem = null;
	$scope.propertiesPanel = propertiesPanel;
	$scope.isRefreshing = false;
	$scope.isKeywordActive = false;
	$scope.currentCulture = $location.search().c || window.defaultLanguage;
	$scope.currentCultureFullName = $("#cultureSelection option:selected").html().trim();
	$scope.fileManagerPopup = fileManagerPopup;
	$scope.checkableListManager = checkableListManager;

	$scope.pagination = null;
	$scope.pageSize = 20;
	$scope.currentPage = $location.search().p || 0;
	$scope.order = null;
	$scope.orderDir = "desc";

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

		checkableListManager.uncheckAllItems();

		$scope.isRefreshing = true;

		var page = $location.search()['p'];
		var keyword = $location.search()['q'];
		var culture = $location.search()['c'];
		var pageSize = $scope.pageSize;

		$scope.searchKeyword = keyword;
		$scope.isKeywordActive = $scope.searchKeyword;

		if(!page) page = 0;
		$scope.currentPage = page;

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

					//$scope.selectedItem = newSelectedItem;
				}

				// Select the page
				if(!$scope.pagination) {

					$scope.pagination = UIkit.pagination($(".uk-pagination").get()[0], {

						items: data.total,
						itemsOnPage: pageSize,
						currentPage: Math.floor(data.from / params.take) + 1
					});

				} else {

					$scope.pagination.options.items = data.total;
					$scope.pagination.options.currentPage = $scope.currentPage + 1;
					$scope.pagination.init();
				}

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

			var key = item.key;
			var culture = $scope.currentCulture;

			$scope.loadPropertiesData(key, culture);
		}

		if($scope.checkableListManager.isAnyItemChecked()) return;
		
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

	$scope.activateItem = function(e, item) {
		
		if($scope.lastEditedItem && item.id == $scope.lastEditedItem.id) {
			
			setTimeout(function() {
				
				$(e.target).
					fadeIn(200).fadeOut(200).
					fadeIn(200).fadeOut(200).
					fadeIn(200).fadeOut(200).
					fadeIn(200);

				$timeout(function() {

					$scope.lastEditedItem = null;

				}, 3000);
				
			}, 100);
		}
	};

	$scope.loadPropertiesData = function(key, culture) {

		$scope.propertiesPanel.isCommandsHidden = true;

		var params = {

			key: key,
			culture: culture
		}

		httpEx($scope, "GET", $scope.baseUrl + "cms/rest/content", params).
			success(function(data, status, headers, config) {

				if(!data.culture)
					data.culture = $scope.currentCulture;

				$scope.editingData = data;
				$scope.editingData.headerTitle = data.title;

				if(!$scope.editingData.revision)
					$scope.editingData.revision = 1;

				$timeout(function() {
					$scope.propertiesPanel.propertiesForm.$setPristine();
					$scope.propertiesPanel.propertiesForm.$setUntouched();
				}, 1);

				$scope.propertiesPanel.isHeaderExpanded = 
					($scope.editingData.status == "published" || 
					 $scope.editingData.status == "draft");

				$scope.isLoadingEditingData = false;
				$scope.propertiesPanel.isCommandsHidden = false;
			}).
			error(function(data, status, headers, config) {

				$scope.isLoadingEditingData = false;
			});
	}

	$scope.areAllCheckedItemsPublishable = function() {

		var items = $scope.checkableListManager.getCheckedItems();
		return _.all(items, function(item) { return item.status == 'draft'; });
	}

	$scope.publishAllChecked = function() {

		modal.show(
			"You are about to publish all checked content in the selected language world wild. " +
			"Please make sure everything correct before proceed. " +
			"Are you sure you want to continue?", "Publish confirmation", {
				
				danger: false,
				bgclose: true,
				okTitle: "Yes",
				icon: "info-circle"
			})
			.ok(function() {

				var items = $scope.checkableListManager.getCheckedItems();
				var keys = _.map(items, function(item) { return item.key; });

				var params = requestParams.create($scope, {

					keys: keys,
					culture: $scope.currentCulture
				});

				httpEx($scope, "POST", $scope.baseUrl + "cms/rest/content/publish", params).
					success(function(data, status, headers, config) {

						if(data.error) {

							return;
						}

						$scope.refresh();
					});
			});
	}

	$scope.deleteAllChecked = function() {

		modal.show(
			"Are you sure you want to delete all checked content?<br/>" +
			"You are not able to undo this deletion. All of checked content will be permanently lost!",
			"Delete confirmation", {
				
				danger: true,
				bgclose: true,
				okTitle: "Yes",
				cancelTitle: "No",
				icon: "exclamation-circle"
			})
			.ok(function() {

				$scope.propertiesPanel.close({force: true});

				var items = $scope.checkableListManager.getCheckedItems();
				var ids = _.map(items, function(item) { return item.id; });

				var params = requestParams.create($scope, {

					ids: ids
				});
				
				httpEx($scope, "DELETE", $scope.baseUrl + "cms/rest/content", params).
					success(function(data, status, headers, config) {

						$scope.refresh();
					});
			});
	}

	$scope.propertiesPanel.publishableCheck = function() {

		var isValid = $scope.propertiesPanel.propertiesForm.$valid;

		if($scope.editingData) {

			if($scope.editingData.type == "html") {
				isValid &= $scope.editingData.html != null;

				if($scope.editingData.html) {

					var striped = $scope.editingData.html.replace(/<\/?[^>]+(>|$)/g, "").trim();
					if(striped == "" || striped == "&nbsp;")
						isValid = false;
				}
			}
		}

		return isValid;
	}

	$scope.$on("$locationChangeSuccess", function() {

		$scope.refresh();
	});

	$scope.propertiesPanel.on("publish", function(params, callback) {

		modal.show(
			"You are about to publish this content world wild. " +
			"Please make sure everything correct before proceed. " +
			"Are you sure you want to continue?", "Publish Confirmation", {
				
				danger: false,
				bgclose: true,
				okTitle: "Yes",
				icon: "info-circle"
			})
			.ok(function() {

				var params = requestParams.create($scope, {

					key: $scope.editingData.key,
					culture: $scope.currentCulture
				});

				httpEx($scope, "POST", $scope.baseUrl + "cms/rest/content/publish", params).
					success(function(data, status, headers, config) {

						if(data.error) {

							return;
						}

						$scope.refresh();
						callback(true);
					});
			});
	});

	$scope.propertiesPanel.on("save", function(params, callback) {

		var proceed = function() {

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

					} else {

						$scope.selectedItem.headerTitle = data.content.title;

						$scope.selectedItem.publicTitle = data.content.publicTitle;
						$scope.selectedItem.group = data.content.group;
						$scope.selectedItem.description = data.content.description;
						$scope.selectedItem.type = data.content.type;
						$scope.selectedItem.modified = data.content.modified;
						$scope.selectedItem.status = data.content.status;
					}

					$scope.lastEditedItem = $scope.selectedItem;

					// Move to the right page of added record.
					var query = $location.search();
					var keywordFlag = false;

					var params = {

						id: data.content.id,
						culture: query.c || window.defaultLanguage,
						keyword: query.q || null,
						order: query.o || 'modified',
						dir: query.d || 'desc'
					};

					if(method == "POST") {

						// Force remove keyword search if add new record.

						if($scope.searchKeyword) {

							$scope.searchKeyword = "";
							keywordFlag = true;
						}

						params.keyword = null;
					}

					httpEx($scope, "GET", $scope.baseUrl + "cms/rest/content/rank", params).
						success(function(data, status, headers, config) {

							var rank = data;
							var page = Math.floor(rank / $scope.pageSize);

							if(page == $scope.currentPage && !keywordFlag) {
								$scope.refresh();
							} else {
								$location.search({ 
									p: page, 
									q: $scope.searchKeyword, 
									c: $scope.currentCulture 
								});
							}
						});

					
					callback(true);
				});
		}

		if(!$scope.editingData.id) {

			modal.show(
				"Please make sure the Key is correct " + 
				"because you are not allowed to change it after the first save. Are you sure you want to proceed?",
				"Attention", {
					
					danger: true,
					bgclose: true,
					okTitle: "Yes",
					cancelTitle: "No",
					icon: "exclamation-circle"
				})
				.ok(function() {

					proceed();
				});

			if(params.event) {

				$(params.event.target).blur();
			}

		} else {

			proceed();
		}
	});

	$scope.propertiesPanel.on("new-revision", function(params, callback) {

		modal.show(
			"Are you sure you want to create new revision for this content?<br/>",
			"Confirmation", {
				
				danger: false,
				bgclose: true,
				okTitle: "Yes",
				cancelTitle: "No",
				icon: "info-circle"
			})
			.ok(function() {

				var params = requestParams.create($scope, {

					key: $scope.editingData.key,
					culture: $scope.editingData.culture
				});
				
				httpEx($scope, "POST", $scope.baseUrl + "cms/rest/content/rev", params).
					success(function(data, status, headers, config) {

						$scope.refresh();
						$scope.loadPropertiesData(params.key, params.culture);
					});
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

	$scope.propertiesPanel.on("delete", function() {

		modal.show(
			"Are you sure you want to delete this content?<br/>",
			"Delete confirmation", {
				
				danger: true,
				bgclose: true,
				okTitle: "Yes",
				cancelTitle: "No",
				icon: "exclamation-circle"
			})
			.ok(function() {

				$scope.propertiesPanel.close({force: true});

				var params = requestParams.create($scope, {

					id: $scope.editingData.id
				});
				
				httpEx($scope, "DELETE", $scope.baseUrl + "cms/rest/content", params).
					success(function(data, status, headers, config) {

						$scope.refresh();
					});
			});
	});

	$scope.propertiesPanel.on("delete-rev", function() {

		modal.show(
			"Are you sure you want to delete the latest draft?<br/>",
			"Confirmation", {
				
				danger: true,
				bgclose: true,
				okTitle: "Yes",
				cancelTitle: "No",
				icon: "exclamation-circle"
			})
			.ok(function() {

				var params = requestParams.create($scope, {

					key: $scope.editingData.key,
					culture: $scope.editingData.culture,
					revision: $scope.editingData.revision
				});
				
				httpEx($scope, "DELETE", $scope.baseUrl + "cms/rest/content/rev", params).
					success(function(data, status, headers, config) {

						$scope.refresh();
						$scope.loadPropertiesData(params.key, params.culture);
					});
			});
	});

	$scope.propertiesPanel.on("culture-changed", function(data) {

		var name = $scope.propertiesPanel.dom(
			".n-culture-selection option:selected").html().trim();

		$scope.currentCultureFullName = name;

		$("#cultureSelection").val(data);
		$scope.currentCulture = data;
		$scope.persistPageParameterChanged();

		var key = $scope.editingData.key;
		var culture = $scope.editingData.culture;

		$scope.loadPropertiesData(key, culture);
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

	checkableListManager.initialize($scope);
}]);