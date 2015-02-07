module.exports = function(grunt) {
	
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	
	// Project configuration.
	grunt.initConfig({
		uglify: {
			my_target: {
				files: {
					'js/vendor.min.js': [
						'vendor/jquery/dist/jquery.min.js', 
						'vendor/uikit/js/uikit.min.js',
						'vendor/uikit/js/components/form-select.min.js',
						'vendor/intl-tel-input/build/js/intlTelInput.min.js',
						'vendor/angular/angular.min.js',
						'vendor/angular-animate/angular-animate.min.js',
						'vendor/angular-intl-tel/angular-intl-tel.js',
						'vendor/angular-validation-match/dist/angular-input-match.min.js',
						'vendor/freezeh/freezeh.js',
						'vendor/codemirror/lib/codemirror.js',
						'vendor/codemirror/mode/markdown/markdown.js',
						'vendor/codemirror/addon/mode/overlay.js',
						'vendor/codemirror/mode/xml/xml.js',
						'vendor/codemirror/mode/gfm/gfm.js',
						'vendor/marked/lib/marked.js',
						'vendor/uikit/js/components/htmleditor.min.js',
						'vendor/uikit/js/components/notify.min.js'],
						
					'js/lib/libphonenumber.js': [
						'vendor/intl-tel-input/lib/libphonenumber/build/utils.js']
				}
			}
		},
		
		cssmin: {
			target: {
				files: {
					'assets/css/vendor.min.css': [
						'vendor/uikit/css/uikit.almost-flat.min.css',
						'vendor/uikit/css/components/form-select.almost-flat.min.css',
						'vendor/uikit/css/components/form-advanced.almost-flat.min.css',
						'vendor/uikit/css/components/htmleditor.almost-flat.min.css',
						'vendor/uikit/css/components/notify.almost-flat.min.css',
						'vendor/intl-tel-input/build/css/intlTelInput.css',
						'vendor/codemirror/lib/codemirror.css']
				}
			}
		}
	});
};