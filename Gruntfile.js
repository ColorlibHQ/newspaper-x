module.exports = function(grunt) {
  // load all tasks
  require('load-grunt-tasks')(grunt, {scope: 'devDependencies'});

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    checktextdomain: {
        standard: {
            options:{
                text_domain: [ 'newspaper-x', 'epsilon-framework' ], //Specify allowed domain(s)
                create_report_file: "true",
                keywords: [ //List keyword specifications
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
            files: [{
                src: [
                    '**/*.php',
                    '!**/node_modules/**',
                ], //all php
                expand: true,
            }],
        }
    },
    clean: {
        init: {
            src: ['build/']
        },
        build: {
            src: [
                'build/*',
                '!build/<%= pkg.name %>.zip'
            ]
        }
    },
    copy: {
      build: {
          expand: true,
          src: [
              '**',
              '!node_modules/**',
              '!vendor/**',
              '!build/**',
              '!readme.md',
              '!README.md',
              '!phpcs.ruleset.xml',
              '!Gruntfile.js',
              '!package.json',
              '!composer.json',
              '!composer.lock',
              '!set_tags.sh',
              '!newspaper-x.zip',
              '!nbproject/**' ],
          dest: 'build/'
      }
    },
    compress: {
        build: {
            options: {
                pretty: true,                           // Pretty print file sizes when logging.
                archive: '<%= pkg.name %>.zip'
            },
            expand: true,
            cwd: 'build/',
            src: ['**/*'],
            dest: '<%= pkg.name %>/'
        }
    },
  });

  grunt.registerTask('textdomain', ['checktextdomain']);
  // Build task
  grunt.registerTask( 'build-archive', [
      'textdomain',
      'clean:init',
      'copy',
      'compress:build',
      'clean:init'
  ]);
};