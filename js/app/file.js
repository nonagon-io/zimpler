angular.module('file-manager', ['generic-modal', 'common', 'ngFileUpload', 'ngDragDrop'])

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

	$scope.viewMode = "tile";

	$scope.newFolderName = '';
	$scope.newFolderNameValid = false;
	$scope.newFolderNameFresh = false;
	$scope.newFolderNameDuplicated = false;
	$scope.newFolderServerError = false;
	$scope.newFolderCreating = false;

	$scope.parentFolderDropBox = [];
	$scope.draggingItem = null;

	$scope.refresh = function(givenPath) {

		$scope.isRefreshing = true;

		var params = {

			path: givenPath ? givenPath.join("/") : $scope.paths.join("/")
		}

		httpEx($scope, "GET", $scope.baseUrl + 'file/rest/file/list', params).
			success(function(data, status, headers, config) {

				$scope.files = _.filter(data, function(item) { 
						return item.type == "file" && !item.name.endsWith("/"); 
					}).map(function(file) {

						var name = file.url.toLowerCase();
						file.isImage = 
								name.endsWith(".png") || 
								name.endsWith(".jpg") ||
								name.endsWith(".gif");

						var fileIcon = "";

						if(name.endsWith(".xls") || name.endsWith(".xlsx")) {
							fileIcon = "uk-icon-file-excel-o";

						} else if(name.endsWith(".doc") || name.endsWith(".docx")) {
							fileIcon = "uk-icon-file-word-o";

						} else if(name.endsWith(".pdf")) {
							fileIcon = "uk-icon-file-pdf-o";

						} else if(name.endsWith(".ppt") || name.endsWith(".pptx")) {
							fileIcon = "uk-icon-file-powerpoint-o";

						} else if(name.endsWith(".zip") || name.endsWith(".rar")) {
							fileIcon = "uk-icon-file-archive-o";

						} else if(name.endsWith(".mp3") || name.endsWith(".wav")) {
							fileIcon = "uk-icon-file-audio-o";

						} else if(name.endsWith(".mp4") || name.endsWith(".mov") || name.endsWith(".wmv")) {
							fileIcon = "uk-icon-file-video-o";

						} else {

							fileIcon = "uk-icon-file-o";							
						}

						file.fileIcon = fileIcon;

						return file;
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

				modal.show(message, "Communication Error", { okOnly: true });
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

		if(folder == $scope.draggingItem) return;

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

	$scope.newFolder = function($event) {

		var modalContainer = $($event.target).parents('.n-file-browser').get().length;

		if(!modalContainer) {

			var modal = UIkit.modal(".n-create-folder-dialog");
			modal.show();

			$(".n-create-folder-dialog input[type=text]").focus();

		} else {

			$(".n-create-folder-dialog").show();
			$(".n-create-folder-dialog input[type=text]").focus();
		}

		$scope.newFolderNameDuplicated = false;
		$scope.newFolderNameValid = false;
		$scope.newFolderNameFresh = true;
		$scope.newFolderName = "";
	}

	$scope.commitNewFolder = function($event) {

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

				var modalContainer = $($event.target).parents('.n-file-browser').get().length;

				if(!modalContainer) {

					var modal = UIkit.modal(".n-create-folder-dialog");
					modal.hide();

				} else {

					$(".n-create-folder-dialog").hide();
				}
			}).
			error(function(data, status, headers, config) {

				$scope.newFolderCreating = false;
				$scope.newFolderServerError = true;
			});
	}

	$scope.cancelNewFolder = function($event) {

		var modalContainer = $($event.target).parents('.n-file-browser').get().length;

		if(!modalContainer) {

			var modal = UIkit.modal(".n-create-folder-dialog");
			modal.hide();

		} else {

			$(".n-create-folder-dialog").hide();
		}
	}

	$scope.switchToTileMode = function() {

		$scope.viewMode = "tile";
		$(".n-folder-container").css("height", "auto");

		$timeout(function() {
			$scope.updateLayout();
		}, 100);
	}

	$scope.switchToColumnsMode = function() {

		$scope.viewMode = "columns";
		$scope.updateColumnsModeLayout();
	}

	$scope.updateColumnsModeLayout = function() {

		var cumulativeMarginLeft = 0;
		var cumulativeMarginTop = 0;
		var elem = $(".n-files-zone");

		do {

			cumulativeMarginLeft += Math.max(0, parseInt(elem.css("margin-left")));
			cumulativeMarginTop += Math.max(0, parseInt(elem.css("margin-top")));

			elem = elem.parent();

		} while(!elem.is("html"));

		cumulativeMarginLeft += Math.max(0, parseInt(elem.css("margin-left")));
		cumulativeMarginTop += Math.max(0, parseInt(elem.css("margin-top")));

		var containerLeft = $(".n-files-zone").offset().left - cumulativeMarginLeft;
		var containerTop = $(".n-files-zone").offset().top - cumulativeMarginTop;
		$(".n-folder-container").css("left", containerLeft + "px");
		$(".n-folder-container").css("top", containerTop + "px");

		$timeout(function() {
			
			var containerHeight = $(".n-files-zone").outerHeight() - 
				parseInt($(".n-folder-container").css("padding-top")) -
				parseInt($(".n-folder-container").css("padding-bottom"));

			$(".n-folder-container").css("height", containerHeight + "px");

			$scope.updateLayout();
		}, 100);
	}

	$scope.onDragStart = function(event, draggable, item) {

		$scope.draggingItem = item;
	}

	$scope.onDragStop = function(event, draggable, item) {

		$timeout(function() {
			$scope.draggingItem = null;
		}, 1000);
	}

	$scope.onFileDrop = function(event, draggable, target) {

		var targetPath = null;

		if(target) {

			if($scope.path) {
				targetPath = $scope.path + "/" + target.name;
			} else {
				targetPath = target.name;
			}

		} else {

			var path = angular.copy($scope.paths);
			path.pop();

			targetPath = path.join('/');
		}

		if($scope.draggingItem.type == "file") {

			$scope.files = _.filter($scope.files, function(item) { 
					return item != $scope.draggingItem
				});

		} else {

			$scope.folders = _.filter($scope.folders, function(item) { 
					return item != $scope.draggingItem
				});
		}

		var params = null;

		if($scope.csrf) {
			params = $scope.csrf;
		} else {
			params = {};
		}

		params.file = $scope.draggingItem.name;
		params.path = $scope.path;
		params.target = targetPath;
		params.type = $scope.draggingItem.type;

		httpEx($scope, "POST", $scope.baseUrl + 'file/rest/file/move', params).
			error(function(data, status, headers, config) {

				var message = 
					"Could not move the " + $scope.draggingItem.type + 
					" due to the communication error.<br/>";

				modal.show(message, "Communication Error", {

					cancelTitle: null

				}).ok(function() {

					$scope.refresh();
				});
			});

		$scope.updateLayout();
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

	$(window).on("resize", function() {

		if($scope.viewMode == "columns")
			$scope.updateColumnsModeLayout();
	});
});