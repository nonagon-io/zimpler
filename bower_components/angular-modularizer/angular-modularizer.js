if(!angular)
	throw "AngularJS was not loaded.";

angular.loadedModules = [];

(function(angular) {
	
	var __angular_module = angular.module;
	var __loaded_modules = {};
	
	angular.module = function(name, dependencies, configFn) {

		if(!__loaded_modules[name]) {
			angular.loadedModules.push(name);

			dependencies = dependencies || [];
			var module = __angular_module(name, dependencies, configFn);
			__loaded_modules[name] = module;

			return module;

		} else {

			return __loaded_modules[name];
		}
	};
	
	angular.modularize = function(root) {
	
		angular.module(root, angular.loadedModules);
	};
  
})(angular);