angular.module("setting-general", ['common', 'generic-modal', 'admin', 'ngAnimate'])

.controller("SettingGeneralController", ['$scope', 'submitForm', 'checkFormDirty', function($scope, submitForm, checkFormDirty) {
	
	$scope.editingData = {};
	
	$scope.save = function($event) {
		
		if($event)
			$event.preventDefault();
		
		submitForm($scope, $scope.mainForm, "POST",
			$event.target.attributes.action.value, $scope.editingData).
			success(function(data, status, headers, config) {
				
				$scope.originalData = angular.copy($scope.editingData);
				
				$scope.mainForm.$setPristine(); 
				$scope.mainForm.$setUntouched();
				
				UIkit.notify("<i class='uk-icon-check'></i> " + 
					$scope.successMessage, { status: "success", timeout: 1000, pos: "top-right" });
			});
	}
	
	$scope.cancel = function() {
		
		checkFormDirty($scope.mainForm).confirm(function() {
			
			$scope.editingData = angular.copy($scope.originalData);
			
			$scope.mainForm.$setPristine(); 
			$scope.mainForm.$setUntouched();
		});
	}
	
	$scope.$on('init', function(event, args) {
		
		$scope.originalData = angular.copy($scope.editingData);
	});
}]);