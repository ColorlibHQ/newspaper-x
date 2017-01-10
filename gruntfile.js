'use strict';
module.exports = function (grunt) {

	// load all tasks
	require('load-grunt-tasks')(grunt, { scope: 'devDependencies' });

	grunt.initConfig({
		pkg          : grunt.file.readJSON('package.json'),
		makepot      : {
			target: {
				options: {
					domainPath     : '/languages/',
					potFilename    : '<%= pkg.name %>.pot',
					potHeaders     : {
						poedit                 : true,
						'x-poedit-keywordslist': true
					},
					processPot     : function (pot, options) {
						pot.headers[ 'report-msgid-bugs-to' ] = 'https://www.colorlib.com/';
						pot.headers[ 'language-team' ] = 'Colorlib <office@colorlib.com>';
						pot.headers[ 'last-translator' ] = 'Colorlib <office@colorlib.com>';
						pot.headers[ 'language-team' ] = 'Colorlib <office@colorlib.com>';
						return pot;
					},
					updateTimestamp: true,
					type           : 'wp-theme'

				}
			}
		},
		addtextdomain: {
			target: {
				options: {
					updateDomains: true,
					textdomain   : '<%= pkg.name %>'
				},
				files  : {
					src: [
						'*.php',
						'!node_modules/**'
					]
				}
			}
		},

		clean: {
			init  : {
				src: [ 'build/' ]
			},
			build : {
				src: [
					'build/*',
					'!build/<%= pkg.name %>.zip'
				]
			},
			cssmin: {
				src: [ 'layout/css/*.min.css' ]
			},
			jsmin : {
				src: [
					'layout/js/*.min.js',
					'layout/js/*.min.js.map',
					'layout/js/**/*.min.js',
					'layout/js/**/*.min.js.map'
				]
			}
		},
		copy : {
			readme: {
				src : 'readme.md',
				dest: 'build/readme.txt'
			},
			build : {
				expand: true,
				src   : [ '**', '!node_modules/**', '!build/**', '!readme.md', '!Gruntfile.js', '!package.json', '!nbproject/**' ],
				dest  : 'build/'
			}
		},

		compress: {
			build: {
				options: {
					pretty : true,
					archive: 'build/<%= pkg.name %>.zip'
				},
				expand : true,
				cwd    : 'build/',
				src    : [ '**/*' ],
				dest   : '<%= pkg.name %>/'
			}
		},

		uglify: {
			macho: {
				options: {
					sourceMap    : false,
					sourceMapName: 'sourceMap.map'
				},
				src    : [ 'assets/vendors/machothemes/**/*.js', '!assets/vendors/machothemes/machothemes.min.js' ],
				dest   : 'assets/vendors/machothemes/machothemes.min.js'
			}
		},

		checktextdomain: {
			standard: {
				options: {
					text_domain       : [ 'newspaper-x' ], //Specify allowed domain(s)
					create_report_file: "true",
					keywords          : [ //List keyword specifications
						'__:1,2d',
						'_e:1,2d',
						'_x:1,2c,3d',
						'esc_html__:1,2d',
						'esc_html_e:1,2d',
						'esc_html_x:1,2c,3d',
						'esc_attr__:1,2d',
						'esc_attr_e:1,2d',
						'esc_attr_x:1,2c,3d',
						'_ex:1,2c,3d',
						'_n:1,2,4d',
						'_nx:1,2,4c,5d',
						'_n_noop:1,2,3d',
						'_nx_noop:1,2,3c,4d'
					]
				},
				files  : [ {
					src   : [
						'**/*.php',
						'!**/node_modules/**',
						'!**/framework/**'
					], //all php
					expand: true
				} ]
			}
		},

		imagemin: {
			jpg    : {
				options: {
					progressive: true
				}
			},
			png    : {
				options: {
					optimizationLevel: 7
				}
			},
			dynamic: {
				files: [ {
					expand: true,
					cwd   : 'assets/images/',
					src   : [ '**/*.{png,jpg,gif}' ],
					dest  : 'assets/images/'
				} ]
			}
		},

		cssmin: {
			target: {
				files: [ {
					expand: true,
					cwd   : 'assets/css',
					src   : [ '*.css', '!*.min.css' ],
					dest  : 'assets/css',
					ext   : '.min.css'
				} ]
			}
		}


	});

	grunt.config('watch', {
		js: {
			files  : 'assets/vendors/machothemes/**/*.js',
			tasks  : [ 'uglify' ],
			options: {
				spawn: false
			}
		}
	});
	grunt.event.on('watch', function (action, filepath) {
		// Determine task based on filepath
		var get_ext = function (path) {
			var ret = '';
			var i = path.lastIndexOf('.');
			if ( -1 !== i && i <= path.length ) {
				ret = path.substr(i + 1);
			}
			return ret;
		};
		switch ( get_ext(filepath) ) {
				// PHP
			case 'php' :
				grunt.config('paths.php.files', [ filepath ]);
				break;
				// JavaScript
			case 'js' :
				grunt.config('paths.js.files', [ filepath ]);
				break;
		}
	});

	grunt.registerTask('default', []);

	// Build .pot file
	grunt.registerTask('buildpot', [
		'makepot'
	]);

	// Check Missing Text Domain Strings
	grunt.registerTask('textdomain', [
		'checktextdomain'
	]);

	// Minify Images
	grunt.registerTask('minimg', [
		'imagemin:dynamic'
	]);

	// Minify CSS
	grunt.registerTask('mincss', [
		'clean:cssmin',
		'cssmin'
	]);

	// Minify JS
	grunt.registerTask('minjs', [
		'clean:jsmin',
		'uglify'
	]);

	// Task to minify all static resources
	grunt.registerTask('allmin', [
		'minimg',
		'mincss',
		'minjs'
	]);

	// Build task
	grunt.registerTask('build-archive', [
		'allmin',
		'clean:init',
		'copy',
		'compress:build',
		'clean:build'
	]);

	grunt.registerTask('watch_all', [ 'watch:js' ]);
};