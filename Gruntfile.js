var path = 'app/webroot/';

module.exports = function(grunt){

	require("matchdep").filterDev("grunt-*").forEach(grunt.loadNpmTasks);
	
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        concat: {
        	options: {
	        	seperator: ';',	
        	},
        	dist: {
	        	src: ['app/webroot/js/plugins/angular.min.js', 'app/webroot/js/min/timer.min.js', 'app/webroot/js/min/carousel.min.js', 'app/webroot/js/min/transition.min.js', 'app/webroot/js/min/app.min.js', 'app/webroot/js/min/controller.min.js', 'app/webroot/js/iga/directives.js', 'app/webroot/js/min/services.min.js'],
	        	dest: 'app/webroot/js/min/iga.min.js'
        	}
        },
        cssmin: {
        	minify: {
	        	expand: true,
	        	cwd: path+'css',
	        	src: ['*.css', '!*.min.css'],
	        	dest: path+'css',
	        	ext: '.min.css'
        	}  
        },
        uglify: {
		    build: {
		        files: {
		            'app/webroot/js/iga.min.js': ['app/webroot/js/plugins/angular.min.js', 'app/webroot/js/plugins/timer.js', 'app/webroot/js/plugins/angular-ui/carousel.js', 'app/webroot/js/plugins/angular-ui/transition.js', 'app/webroot/js/iga/app.js', 'app/webroot/js/iga/controller.js', 'app/webroot/js/iga/directives.js', 'app/webroot/js/iga/services.js']
/*
		            'app/webroot/js/min/carousel.min.js': ['app/webroot/js/plugins/angular-ui/carousel.js'],
		            'app/webroot/js/min/transition.min.js': ['app/webroot/js/plugins/angular-ui/transition.js'],
		            'app/webroot/js/min/app.min.js': ['app/webroot/js/iga/app.js'],
		            'app/webroot/js/min/controller.min.js': ['app/webroot/js/iga/controller.js'],
		            'app/webroot/js/min/directives.min.js': ['app/webroot/js/iga/directives.js'],
		            'app/webroot/js/min/services.min.js': ['app/webroot/js/iga/services.js']
*/
		            
		        }
		    }
		},
		watch: {
			scripts: {
				files: [path+'js/iga/*.js', path+'css/*.css'],
				tasks: ['uglify', 'cssmin'],
				options: {
				  spawn: false
				}
			}
		}
    });

    grunt.registerTask('default', []);

};