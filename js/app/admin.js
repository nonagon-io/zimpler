angular.module("admin", ['common', 'generic-modal', 'ngAnimate'])

.factory("propertiesPanel", 
	['$http', '$sce', '$window', 'checkFormDirty',
	function($http, $sce, $window, checkFormDirty) {
	
	return {
		
		isOpen: false,
		scrollTop: 0,
		scrollMaxReached: false,
		panel: $(".n-properties-panel"),
		propertiesBody: $(".n-properties-panel .n-body"),
		widthClasses: "uk-width-1-1 uk-width-medium-2-3 uk-width-large-6-10",
		scope: null,
		observers: {},
		
		on: function(event, delegate) {
			
			if(event) {
				
				if(!this.observers[event])
					this.observers[event] = [];
				
				this.observers[event].push(delegate);
			}
		},
		
		off: function(event, delegate) {
			
			if(event && this.observers[event]) {
				
				var observers = this.observers[event];
				var newObservers = [];
				
				for(var i=0; i<observers.length; i++) {
					
					if(observers[i] == delegate)
						continue;
						
					newObservers.push(observers[i]);
				}
				
				this.observers[event] = newObservers;
			}
		},
		
		fire: function(event, data, callback) {
			
			if(!this.observers[event])
				this.observers[event] = [];
			
			var observers = this.observers[event];	
			for(var i=0; i<observers.length; i++) {
				
				var delegate = observers[i];
				delegate(data, callback);
			}
		},
		
		open: function($scope, widthClasses) {
			
			if(widthClasses)
				this.widthClasses = widthClasses;
		
			this.isOpen = true;
			this.propertiesBody.scrollTop(0);
			this.scope = $scope;
			
			$this = this;
			
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
			
			var resize = function() {
				
				if($this.scope) {
					
					$this.offsetLeft = $this.panel.offset().left;
					$this.scope.$apply();
				}
			};
			
			this.resize = resize;
			$($window).on("resize", resize);
			
			this.panel.one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend',
				function(e) {
				
					$this.offsetLeft = $this.panel.offset().left;
					
					if($this.scope)
						$this.scope.$apply();
				});
			
			setTimeout(function() {
				
				$this.propertiesBody.find(':input:visible:enabled:first').focus();
				
			}, 300);
			
			setTimeout(function() {
				
				bodyScroll();
				
			}, 1);
			
			$this.scope.propertiesPanel.propertiesForm.$setPristine(); 
		},
		
		close: function() {
			
			$this = this;
			
			checkFormDirty(this.scope.propertiesPanel.propertiesForm).confirm(function() {
				
				$this.scope.propertiesPanel.propertiesForm.$setUntouched();
				
				$this.offsetLeft = 0;
				$this.isOpen = false;
				$this.scope = null;
	
				$this.propertiesBody.off("scroll", $this.bodyScroll);
				$($window).off("resize", $this.resize);
			});
		},
		
		save: function($event, option) {

			if($event)
				$event.preventDefault();
				
			this.scope.propertiesPanel.propertiesForm.$setSubmitted();
			
			if(!this.scope.propertiesPanel.propertiesForm.$valid) {
				return;
			}
			
			var $this = this;
			this.fire("save", null, function(result) {

				$this.scope.propertiesPanel.propertiesForm.$setUntouched();
				$this.scope.propertiesPanel.propertiesForm.$setPristine();
				
				if(result && option && option.alsoClose) {
					
					$this.close();
				}
			});
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