angular.module("common", [])

// Extends ngInit with our process to emit 'init' event on the scope.
.directive('ngInit', function() {
	return {
		restrict: 'A',
		scope: true,
		link: function(scope, elem, attrs) {
			
			scope.$emit('init');
		}
	};
})

// Move to the first invalid form when submit.
.directive('nFocusOnError', function () {
    return {
        restrict: 'A',
        link: function (scope, elem) {

            // set up event handler on the form element
            elem.on('submit', function () {

                // find the first invalid element
                var firstInvalid = angular.element(
                    elem[0].querySelector('.ng-invalid'))[0];

                // if we find one, set focus
                if (firstInvalid) {
                    firstInvalid.focus();
                }
            });
        }
    };
});