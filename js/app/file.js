angular.module('file-manager', ['generic-modal', 'common', 'ngFileUpload'])

.factory('fileManager', ['$q', '$sce', function($q, $sce) {

	return {

		scope: null,

		updateLayout: function() {

			if(!this.scope) return;
			this.scope.updateLayout();
		}
	}

}])

.controller('FileManagerController', function($scope, $locale, $timeout, modal, httpEx, fileManager, Upload) {

	fileManager.scope = $scope;

	$scope.files = null;
	$scope.folders = null;
	$scope.path = "";
	$scope.paths = [];
	$scope.isRefreshing = false;
	$scope.selectedItem = null;
	$scope.upload = {};
	$scope.initialized = false;

	$scope.newFolderName = '';
	$scope.newFolderNameValid = false;
	$scope.newFolderNameFresh = false;
	$scope.newFolderNameDuplicated = false;
	$scope.newFolderServerError = false;
	$scope.newFolderCreating = false;

	$scope.refresh = function(givenPath) {

		$scope.isRefreshing = true;

		var params = {

			path: givenPath ? givenPath.join("/") : $scope.paths.join("/")
		}

		httpEx($scope, "GET", $scope.baseUrl + 'file/rest/file/list', params).
			success(function(data, status, headers, config) {

				$scope.files = _.filter(data, function(item) { 
						return item.type == "file" && !item.name.endsWith("/"); 
					});

				$scope.folders = _.filter(data, function(item) { 
						return item.type == "folder"; 
					});

				if(givenPath) {

					$scope.paths = givenPath;
					$scope.path = $scope.paths.join("/");
				}

				$scope.updateLayout();
				$scope.isRefreshing = false;
				$scope.selectedItem = null;
			}).
			error(function(data, status, headers, config) {

				var message = 
					"Could not initialize file manager. Please review the following error:" + 
					"<br/><br/>" + data.error;

				modal.show(message, "Could not initialize file manager");
				$scope.isRefreshing = false;

			});
	};

	$scope.deleteUpload = function(uploadItem) {

		var proceed = function() {

			$scope.upload[$scope.path].uploadList = 
				_.filter($scope.upload[$scope.path].uploadList,
					function(item) {

						return item != uploadItem;
					});
		}

		if(uploadItem.uploadError) {

			proceed();

		} else {

			$scope.confirmDelete(uploadItem, function() {

				uploadItem.uploader.abort();
			});
		}
	}

	$scope.deleteFile = function(fileItem) {

		$scope.confirmDelete(fileItem, function() {

			var params = {

				file: fileItem.name,
				path: $scope.path
			}

			httpEx($scope, "DELETE", $scope.baseUrl + 'file/rest/file', params).
				success(function(data, status, headers, config) {

					$scope.files = _.filter($scope.files, function(item) { 
							return item != fileItem
						});

					$scope.updateLayout();
				});
		});
	}

	$scope.deleteFolder = function($event, folderItem) {

		$event.stopPropagation();

		$scope.confirmDelete(folderItem, function() {

			var params = {

				path: $scope.path + '/' + folderItem.name
			}

			httpEx($scope, "DELETE", $scope.baseUrl + 'file/rest/file/folder', params).
				success(function(data, status, headers, config) {

					$scope.folders = _.filter($scope.folders, function(item) { 
							return item != folderItem
						});

					$scope.updateLayout();
				});
		});
	}

	$scope.confirmDelete = function(item, proceed) {

		modal.show(
			"Are you sure you want to delete \"" + item.name + "\"?<br/>", 
			"Confirm deletion", {
				
				danger: true,
				bgclose: true,
				icon: "exclamation-circle"
			})
			.ok(function() {
				
				proceed();
			});
	}

	$scope.drillDown = function(folder) {

		var paths = angular.copy($scope.paths);
		paths.push(folder.name);

		$scope.refresh(paths);
	};

	$scope.drillUp = function(arg) {

		var paths = angular.copy($scope.paths);

		if(!arg) {

			paths.pop();

		} else if(arg == '/') {

			paths = [];

		} else if(!isNaN(arg)) {

			for(var i=0; i<arg; i++) {

				paths.pop();
			}
		}

		$scope.refresh(paths);
	}

	$scope.select = function(item) {

		$scope.selectedItem = item;
	}

	$scope.preview = function(item) {


	}

	$scope.updateLayout = function() {

		$timeout(function() {
			var elements = $(".n-file-manager [data-uk-grid]").get();

			for(var i=0; i<elements.length; i++) {

				var element = elements[i];
				var grid = UIkit.grid(element, { gutter: 20, animation: false });
				grid.updateLayout();
			}

			$scope.initialized = true;

		}, 10);
	}

	$scope.getProgressStyle = function(uploadItem) {

		return {

			width: uploadItem.progressPercent + "%"
		};
	}

	$scope.newFolder = function() {

		var modal = UIkit.modal(".n-create-folder-dialog");
		modal.show();

		$scope.newFolderNameDuplicated = false;
		$scope.newFolderNameValid = false;
		$scope.newFolderNameFresh = true;
		$scope.newFolderName = "";

		$(".n-create-folder-dialog input[type=text]").focus();
	}

	$scope.commitNewFolder = function() {

		$scope.newFolderName = $scope.newFolderName.trim();

		var params = null;

		if($scope.csrf) {
			params = $scope.csrf;
		} else {
			params = {};
		}

		$scope.newFolderCreating = true;

		params.path = $scope.path;
		params.folderName = $scope.newFolderName;
	    
		httpEx($scope, "POST", $scope.baseUrl + 'file/rest/file/folder', params).
			success(function(data, status, headers, config) {

				$scope.newFolderCreating = false;

				$scope.folders.push(data);
				$scope.updateLayout();

				var modal = UIkit.modal(".n-create-folder-dialog");
				modal.hide();
			}).
			error(function(data, status, headers, config) {

				$scope.newFolderCreating = false;
				$scope.newFolderServerError = true;
			});
	}

	$scope.cancelNewFolder = function() {

		var modal = UIkit.modal(".n-create-folder-dialog");
		modal.hide();
	}

	$scope.$watch("newFolderName", function(newValue) {

		var regexp = /^[a-zA-Z0-9-_]+$/;

		if (newValue.search(regexp) == -1) {
		    $scope.newFolderNameValid = false;
		} else {
		    $scope.newFolderNameValid = true;
		}

		if($scope.newFolderNameValid) {

			// Also check if it is duplicated.
			var isDuplicated = _.any($scope.folders, function(item) { 
					return item.name == newValue.trim(); 
				});

			$scope.newFolderNameValid = !isDuplicated;
			$scope.newFolderNameDuplicated = isDuplicated;
		}
	});

	$scope.$watch(function() { 

		if($scope.upload[$scope.path])
			return $scope.upload[$scope.path].uploadList;

		return null;

	}, function() {

		$timeout(function() {
			$scope.updateLayout();
		}, 100);

		var performUpload = function(uploadItem) {

			var formData = null;

			if($scope.csrf) {
				formData = $scope.csrf;
			} else {
				formData = {};
			}

			formData.path = $scope.path;

			uploadItem.uploader = Upload.upload({
				url: $scope.baseUrl + "file/rest/file/upload",
				file: uploadItem,
				fileFormDataName: "file",
				withCredentials: true,
				fields: formData,
				sendFieldsAs: "form"
			}).
			progress(function(evt) {

				var percent = parseInt(100.0 * evt.loaded / evt.total);
				uploadItem.progressPercent = percent;

			}).
			success(function(data, status, headers, config) {

				if(!data.error) {

					$scope.upload[$scope.path].uploadList = 
						_.filter($scope.upload[$scope.path].uploadList,
							function(item) {

								return item != uploadItem;
							});

					$scope.files.push(data);

				} else {

					uploadItem.uploadError = true;
					uploadItem.errorMessage = data.error.replace(/<\/?[^>]+(>|$)/g, "");

					$scope.updateLayout();
				}
			}).
			error(function(data, status, headers, config) {

				uploadItem.uploadError = true;
			});
		};

		if($scope.upload[$scope.path]) {

			var list = $scope.upload[$scope.path].uploadList;
			for(var i=0; i<list.length; i++) {

				var uploadItem = list[i];

				if(!uploadItem.uploader) {

					performUpload(uploadItem);
				}
			}
		}
	});

	var checkFileTransfer = function(e) {

	    var dt = e.originalEvent.dataTransfer;
	    if(dt.types != null && (dt.types.indexOf ? dt.types.indexOf('Files') != -1 : 
	    	dt.types.contains('application/x-moz-file'))) {

	        $(".n-drop-zone").show();
	    }
	};

	$(".n-file-manager").on('dragover', checkFileTransfer);
	$(".n-drop-zone").on("dragover", checkFileTransfer);
	$(".n-drop-zone").on('dragleave', function(e) { $(".n-drop-zone").hide(); });
	$(".n-drop-zone").on('drop', function(e) { $(".n-drop-zone").hide(); });

	$(".n-files-zone").on("scroll", function(e) {

		$scope.$apply(function() {
			$scope.fileScrollTop = $(".n-files-zone").scrollTop();
		});
	});
});