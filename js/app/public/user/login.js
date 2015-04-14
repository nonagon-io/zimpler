angular.module('login', [])
 
.controller('LoginController', function($scope, $locale) {
	
	$("#identity").focus();
	
	$scope.submit = function($event) {
		
		$scope.loginForm.$submitted = true;
		
		if($scope.loginForm.$invalid) {
			
			$event.preventDefault();
		}
	}

	$scope.notify = function(message, type) {
		
		var icon = null;
		if(!type) type = 'info';
		
		if(type == 'info') {
			icon = '<i class="uk-icon-info-circle"></i> ';
		} else if(type == 'success') {
			icon = '<i class="uk-icon-check-circle"></i> ';
		} else if(type == 'warning') {
			icon = '<i class="uk-icon-exclamation-circle"></i> ';
		} else if(type == 'danger') {
			icon = '<i class="uk-icon-times-circle"></i> ';
		}
		
		UIkit.notify({
		    message : icon + message,
		    status  : type,
		    timeout : 5000,
		    pos     : 'top-center'
		});
		
		$("#identity").focus();
	}
	
});