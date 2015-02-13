if(!angular)
	throw "AngularJS was not loaded.";

angular.loadedModules = [];

(function(angular) {
	
	var __angular_moduled = angular.module;
	
	angular.module = function(name, dependencies, configFn) {
		
		angular.loadedModules.push(name);
		
		dependencies = dependencies || [];
		var module = __angular_moduled(name, dependencies, configFn);
		
		return module;
	};
	
	angular.modularize = function(root) {
	
		angular.module(root, angular.loadedModules);
	};
  
})(angular);