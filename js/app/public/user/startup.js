angular.module('startup', ['ngIntlTel', 'validation.match'])
 
.controller('StartupController', function($scope, $locale) {
	
	$("#firstName").focus();
	
	$scope.submit = function($event) {
		
		$scope.startupForm.$submitted = true;
		
		if($scope.startupForm.$invalid) {
			
			$event.preventDefault();
		}
	}
});