angular.module("admin-cms-siteinfo", ["common", "generic-modal", "admin", "ngAnimate"])

.controller("CmsSiteInfoController", function($scope, $window, submitForm, checkFormDirty) {
	
	$scope.editingData = {};
	
	$scope.save = function($event) {
		
		$event.preventDefault();
		
		var culture = $("#cultureSelection").val();
		$scope.editingData.culture = culture;
		
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
	
	var selectedCulture = $("#cultureSelection").val();
	$("#cultureSelection").on("change", function() {
		
		$window.location.href = $scope.baseUrl + "admin/cms/siteinfo?culture=" + $(this).val();
		$("#cultureSelection").val(selectedCulture);
	});
});