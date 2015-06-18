angular.module('file-manager', ['generic-modal', 'common'])

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

	$scope.baseUrl = '';
	$scope.files = null;
	$scope.folders = null;
	$scope.paths = [];
	$scope.isRefreshing = false;
	$scope.selectedItem = null;

	$scope.refresh = function(givenPath) {

		$scope.isRefreshing = true;

		var params = {

			path: givenPath ? givenPath : $scope.paths.join("")
		}

		httpEx($scope, "GET", $scope.baseUrl + 'admin/rest/file/list', params).
			success(function(data, status, headers, config) {

				$scope.files = _.filter(data, function(item) { 
						return item.type == "file" && !item.name.endsWith("/"); 
					});

				$scope.folders = _.filter(data, function(item) { 
						return item.type == "folder"; 
					});

				if(givenPath)
					$scope.paths = givenPath;

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

	$scope.drillDown = function(folder) {

		$scope.paths.push(folder.name);
		$scope.refresh();
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

		}, 10);
	}
});