angular.module('ngIntlTel', ['ng'])

.directive('intlTel', function() {
	
  return {
    replace:true,
    restrict: 'E',
    require: 'ngModel',
    template: '<input type="text">',
    link: function(scope, element, attrs, ctrl) {
	    
			var read = function() {
				var inputValue = element.val();
				ctrl.$setViewValue(inputValue);
			}
			
			element.intlTelInput({
				defaultCountry: 'auto',
				utilsScript: attrs.utils
			});
			
			element.on('focus blur keyup change', function() {
				
				scope.$apply(read);
			});
			
			read();
			
            ctrl.$parsers.unshift(function(value) {
	            
	            var valid = true;
	            var error = element.intlTelInput("getValidationError");
	            
	            if (error > 0) {
		            
		            valid = false;
				}
				
				if(!value) valid = true;
				
                ctrl.$setValidity('phone', valid);
                return valid ? value : undefined;
            });
            
            ctrl.$formatters.unshift(function(value) {
	            
	            var valid = true;
	            var error = element.intlTelInput("getValidationError");
	            
	            if (error > 0) {
		            
		            valid = false;
				}
				
				if(!value) valid = true;

                ctrl.$setValidity('phone', valid);
                return value;
            });
		}
	}
});