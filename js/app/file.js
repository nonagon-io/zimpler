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

.controller('FileManagerController', function($scope, $locale, $timeout, modal, httpEx, fileManager) {

	fileManager.scope = $scope;

	$scope.files = null;
	$scope.folders = null;
	$scope.path = "";
	$scope.paths = [];
	$scope.isRefreshing = false;
	$scope.selectedItem = null;
	$scope.upload = {};
	$scope.initialized = false;

	$scope.refresh = function(givenPath) {

		$scope.isRefreshing = true;

		var params = {

			path: givenPath ? givenPath.join("") : $scope.paths.join("")
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
					$scope.path = $scope.paths.join("");
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

		$scope.confirmDelete(uploadItem, function() {

		});
	}

	$scope.deleteFile = function(fileItem) {

		$scope.confirmDelete(fileItem, function() {

		});
	}

	$scope.deleteFolder = function($event, folderItem) {

		$event.stopPropagation();

		$scope.confirmDelete(folderItem, function() {

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

	$scope.drillUp = function() {

		var paths = angular.copy($scope.paths);
		paths.pop();

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

	$scope.$watch(function() { 

		if($scope.upload[$scope.path])
			return $scope.upload[$scope.path].uploadList;

		return null;

	}, function() {

		$timeout(function() {
			$scope.updateLayout();
		}, 100);
	})

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
});