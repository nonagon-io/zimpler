angular.module('generic-modal', [])

.factory('modal', ['$q', '$sce', function($q, $sce) {
	
	function modalPromise(promise) {
		
		promise.ok = function(fn) {
			
			promise.then(function() {
				fn.apply(this, arguments);
			});
			
			return promise;
		}
		
		promise.cancel = function(fn) {
			
			promise.then(null, function() {
				fn.apply(this, arguments);
			})
			
			return promise;
		}
		
		return promise;
	}

	return {
		
		_defer: null,
		_modal: null,

		show: function(message, header, options) {
			
			var $this = this;
			
			$this.icon = null;
			$this.header = "";
			$this.message = "";
			$this.okTitle = "OK";
			$this.cancelTitle = "Cancel";
			$this.bgclose = false;
			$this.danger = false;
			$this.okOnly = false;
			
			if(options) {
				
				if(options.bgclose)
					$this.bgclose = options.bgclose;
					
				if(options.okTitle)
					$this.okTitle = options.okTitle;
					
				if(options.cancelTitle)
					$this.cancelTitle = options.cancelTitle;
				
				if(options.danger)
					$this.danger = options.danger;

				if(options.okOnly)
					$this.okOnly = options.okOnly;
				
				if(options.icon) {
					
					$this.icon = $sce.trustAsHtml(
						"<i class='uk-icon-" + options.icon + "'></i>");
				}
			}
			
			var modal = UIkit.modal("#genericModal", { bgclose: $this.bgclose });
			
			modal.show();
			
			$this._modal = modal;
			$this._defer = $q.defer();
			
			$this.message = $sce.trustAsHtml(message);
			$this.header = $sce.trustAsHtml(header);
			
			return modalPromise($this._defer.promise);
		}
	};
}])
 
.controller('ModalController', 
	['$scope', '$locale', 'modal', 
	function($scope, $locale, modal) {
		
	$scope.modal = modal;
	
	$scope.ok = function() {
		
		if(modal._defer)
			modal._defer.resolve();
		
		modal._modal.hide();
	}
	
	$scope.cancel = function() {
		
		if(modal._defer)
			modal._defer.reject();

		modal._modal.hide();
	}

}]);