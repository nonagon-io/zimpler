module.exports = function(grunt) {
	
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	
	// Project configuration.
	grunt.initConfig({
		uglify: {
			my_target: {
				files: {
					'js/vendor.min.js': [
						'vendor/jquery-2.1.3/jquery.min.js', 
						'vendor/uikit-2.16.2/js/uikit.min.js',
						'vendor/uikit-2.16.2/js/components/form-select.min.js',
						'vendor/angular-1.3.9/angular.min.js',
						'vendor/angular-1.3.9/angular-animate.min.js',
						'vendor/freezeh-0.0.1/freezeh.js',
						'vendor/codemirror-4.12/lib/codemirror.js',
						'vendor/codemirror-4.12/mode/markdown/markdown.js',
						'vendor/codemirror-4.12/addon/mode/overlay.js',
						'vendor/codemirror-4.12/mode/xml/xml.js',
						'vendor/codemirror-4.12/mode/gfm/gfm.js',
						'vendor/marked-0.3.2/lib/marked.js',
						'vendor/uikit-2.16.2/js/components/htmleditor.min.js']
				}
			}
		},
		
		cssmin: {
			target: {
				files: {
					'assets/css/vendor.min.css': [
						'vendor/uikit-2.16.2/css/uikit.almost-flat.min.css',
						'vendor/uikit-2.16.2/css/components/form-select.almost-flat.min.css',
						'vendor/uikit-2.16.2/css/components/form-advanced.almost-flat.min.css',
						'vendor/uikit-2.16.2/css/components/htmleditor.almost-flat.min.css',
						'vendor/codemirror-4.12/lib/codemirror.css']
				}
			}
		}
	});
};