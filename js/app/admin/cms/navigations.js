angular.module("cms-siteinfo", ['common', 'generic-modal', 'admin', 'ngAnimate'])

.controller("CmsNavigationController", ['$scope', '$window', 'submitForm', 'checkFormDirty', 
	function($scope, $window, submitForm, checkFormDirty) {
	
	$scope.editingData = null;
	
	$scope.levels = [{ 
		number: 1,
		items: [{
			
			key: 'Home',
			name: 'Home',
			url: ''
		}]
	}];
	
	$scope.addItem = function(level) {
		
		$scope.levels[level].items.push({});
	};
	
	$scope.edit = function(item) {
		
		$scope.editingData = item;
	}
	
	$scope.expand = function(level, item, event) {
		
		event.stopPropagation();
		
		for(var i=0; i<level.items.length; i++)
			level.items[i].expanded = false;
		
		item.expanded = true;
		
		// Slice all other levels off.
		$scope.levels = $scope.levels.slice(0, level.number);
		$scope.levels.push({
			number: level.number + 1,
			items: []
		});
		
		setTimeout(function() {
			adjustColumnsView();
		}, 1);
	}

	$scope.collapse = function(level, item, event) {
		
		event.stopPropagation();
		
		// Slice all other levels off.
		$scope.levels = $scope.levels.slice(0, level.number);
		
		item.expanded = false;
	}
	
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
	
	var adjustColumnsView = function() {
		var columnLeft = 0;
		$(".n-columns-view").children().each(function(i, elem) {
			
			$(elem).css("left", columnLeft + "px");
			columnLeft += $(elem).outerWidth();
		});
	};
	
	adjustColumnsView();
	
}]);