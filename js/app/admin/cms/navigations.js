angular.module("cms-siteinfo", ['common', 'generic-modal', 'admin', 'ngAnimate'])

.controller("CmsNavigationController", ['$scope', '$window', 'submitForm', 'checkFormDirty', 
	function($scope, $window, submitForm, checkFormDirty) {
	
	$scope.editingData = {};
	
	$scope.levels = [{ 
		number: 1,
		items: []
	}];
	
	$scope.addItem = function(level) {
		
		$scope.levels[level].items.push({});
	};
	
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
	
	var selectedCulture = $("#cultureSelection").val();
	$("#cultureSelection").on("change", function() {
		
		$window.location.href = $scope.baseUrl + "?culture=" + $(this).val();
		$("#cultureSelection").val(selectedCulture);
	});
	
	var columnLeft = 0;
	$(".n-columns-view").children().each(function(i, elem) {
		
		$(elem).css("left", columnLeft + "px");
		columnLeft += $(elem).outerWidth();
	});
	
}]);