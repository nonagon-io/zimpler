angular.module("admin", ['common', 'generic-modal', 'ngAnimate'])

.factory("propertiesPanel", ['$http', '$sce', function($http, $sce) {
	
	return {
		
		isOpen: false,
		scrollTop: 0,
		scrollMaxReached: false,
		propertiesBody: $(".n-properties-panel .n-body"),
		scope: null,
		
		open: function($scope) {
		
			this.isOpen = true;
			this.propertiesBody.scrollTop(0);
			this.scope = $scope;
			
			$this = this;
			
			setTimeout(function() {
				$this.propertiesBody.find(':input:visible:enabled:first').focus();
			}, 300);
			
			var bodyScroll = function() {
				
				if($this.scope) {
					
					$this.scope.$apply(function() {
						
						var scrollBottom = 
							$this.propertiesBody.scrollTop() + 
							$this.propertiesBody.outerHeight();
						
						$this.scrollTop = $this.propertiesBody.scrollTop();
						$this.scrollMaxReached = scrollBottom >= $this.propertiesBody.prop("scrollHeight");
					});
				}
			};
			
			this.bodyScroll = bodyScroll;
			this.propertiesBody.on("scroll", bodyScroll);
		},
		
		close: function() {
		
			this.isOpen = false;
			this.scope = null;
			
			this.propertiesBody.off("scroll", bodyScroll);
		}
	};
	
}])

.controller('AdminController', function($scope, $locale) {
	
	var mainContentBody = $(".n-body .n-content");

	$scope.mainContentBodyScrollTop = 0;
	$scope.mainContentBodyScrollMaxReached = false;
	
	$(".n-body .n-content").on("scroll", function() {
		
		$scope.$apply(function() {
			
			var scrollBottom = mainContentBody.scrollTop() + mainContentBody.outerHeight();
			
			$scope.mainContentBodyScrollTop = mainContentBody.scrollTop();
			$scope.mainContentBodyScrollMaxReached = scrollBottom >= mainContentBody.prop("scrollHeight");
		});
	});
	
	$(function() {
		
		$("table").freezeHeader(); 
	});
});