angular.module('file-manager', ['generic-modal', 'common'])

.controller('FileManagerController', function($scope, $locale, modal, httpEx) {

	$scope.baseUrl = '';
	$scope.list = null;

	$scope.refresh = function() {

		httpEx($scope, "GET", $scope.baseUrl + 'admin/rest/file/list', {}).
			success(function(data, status, headers, config) {

				$scope.list = data.list;
			}).
			error(function(data, status, headers, config) {

				var message = 
					"Could not initialize file manager. Please review the following error:" + 
					"<br/><br/>" + data.error;

				modal.show(message, "Could not initialize file manager");
			});
	};
});