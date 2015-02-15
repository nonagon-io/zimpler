angular.module("cms-siteinfo", ['common', 'generic-modal', 'admin', 'ngAnimate'])

.controller("CmsSiteInfoController", ['$scope', '$window', 'submitForm', 'checkFormDirty', 
	function($scope, $window, submitForm, checkFormDirty) {
	
	$scope.editingData = {};
	
	$scope.save = function() {
		
		var culture = $("#cultureSelection").val();
		$scope.editingData.culture = culture;
		
		submitForm($scope, "mainForm", "").
			success(function(data, status, headers, config) {
				
				$scope.originalData = angular.copy($scope.editingData);
				
				$scope.mainForm.$setPristine(); 
				$scope.mainForm.$setUntouched();
				
				UIkit.notify("<i class='uk-icon-check'></i> " + 
					$scope.successMessage, { status: "success", timeout: 1000, pos: "top-right" });
			});
	}
	
	$scope.cancel = function() {
		
		checkFormDirty($scope, "mainForm").confirm(function() {
			
			$scope.editingData = angular.copy($scope.originalData);
			
			$scope.mainForm.$setPristine(); 
			$scope.mainForm.$setUntouched();
		});
	}
	
	$scope.$on('init', function(event, args) {
		
		$scope.originalData = angular.copy($scope.editingData);
	});
	
	$("#cultureSelection").on("change", function() {
		
		$window.location.href = $scope.baseUrl + "?culture=" + $(this).val();
	});
}]);