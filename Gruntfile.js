'use strict';
module.exports = function( grunt ) {
    var pkg = grunt.file.readJSON( 'package.json' );
    grunt.initConfig({

        // Setting folder templates
        dirs: {
            dist: 'assets/dist/',
            source: 'assets/source/',
        },

        // Compile all .sass files.
        sass: {
            options: {
                sourceMap: true,
                style: 'expanded'
            },
            dist: {
                files: {
                    '<%= dirs.dist %>/css/public.css': '<%= dirs.source %>/sass/style.scss',
                    '<%= dirs.source %>/css/public.css': '<%= dirs.source %>/sass/style.scss',
                }
            }
        },

        // Minify all css files
        cssmin: {
            options: {
                mergeIntoShorthands: false,
                sourceMap: true,
                root: 'root'
            },
            target: {
                files: {
                    '<%= dirs.dist %>/css/public.min.css': [
                        '<%= dirs.dist %>/css/public.css',
                    ],
                }
            }
        },

        // Babel: Converts ES6/ES7 into plain JS
        babel: {
            options: {
                sourceMap: false,
                presets: [ 'env' ],
            },
            dist: {
                files: {
                    '<%= dirs.dist %>/js/public.min.js': '<%= dirs.source %>/js/*.js',
                }
            }
        },

        // Minify all js files
        uglify: {
            options: {
                mangle: false,
                sourceMap: true
            },
            my_target: {
                files: {
                    '<%= dirs.dist %>/js/public.min.js': [
                        '<%= dirs.source %>/js/public.js',
                    ],
                }
            }
        },

        // Watching all changes
        watcher: {
            sass: {
                files: ['<%= dirs.source %>/sass/**/*.scss' ],
                tasks: ['sass', 'cssmin'],
                livereload: {
                    options: {
                        livereload: true
                    }
                }
            },
            scripts: {
                files: [
                    '<%= dirs.source %>/js/*.js',
                ],
                tasks: ['uglify']
            }
        },

        // Generate POT files.
        makepot: {
            target: {
                options: {
                    domainPath: '/languages/', // Where to save the POT file.
                    potFilename: 'elementor-addons-boilerplate.pot', // Name of the POT file.
                    type: 'wp-plugin', // Type of project (wp-plugin or wp-theme).
                    potHeaders: {
                        'report-msgid-bugs-to': 'https://elementor-addons-boilerplate.com.au/',
                        'language-team': 'LANGUAGE <EMAIL@ADDRESS>'
                    }
                }
            }
        },

        // Clean up build directory
        clean: {
            main: ['build/']
        },

        // Copy the plugin into the build directory
        copy: {
            main: {
                src: [
                    '**',
                    '!node_modules/**',
                    '!build/**',
                    '!testing/**',
                    '!bin/**',
                    '!.git/**',
                    '!Gruntfile.js',
                    '!package.json',
                    '!package-lock.json',
                    '!debug.log',
                    '!phpunit.xml',
                    '!.gitignore',
                    '!.gitmodules',
                    '!npm-debug.log',
                    '!assets/less/**',
                    '!tests/**',
                    '!**/Gruntfile.js',
                    '!**/package.json',
                    '!**/README.md',
                    '!**/export.sh',
                    '!**/*~'
                ],
                dest: 'build/'
            }
        },

        //Compress build directory into <name>.zip and <name>-<version>.zip
        compress: {
            main: {
                options: {
                    mode: 'zip',
                    archive: './build/boilerplate-v'+ pkg.version + '.zip'
                },
                expand: true,
                cwd: 'build/',
                src: ['**/*'],
                dest: 'boilerplate'
            }
        },
    });

    // Load NPM tasks to be used here
    grunt.loadNpmTasks( 'grunt-wp-i18n' );
    grunt.loadNpmTasks( 'grunt-contrib-clean' );
    grunt.loadNpmTasks( 'grunt-contrib-copy' );
    grunt.loadNpmTasks( 'grunt-contrib-compress' );
    grunt.loadNpmTasks( 'grunt-sass' );
    grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
    grunt.loadNpmTasks( 'grunt-babel' );
    grunt.loadNpmTasks( 'grunt-contrib-uglify' );
    grunt.loadNpmTasks('grunt-watcher');

    grunt.registerTask( 'default', [
        'sass', 'minifycss', 'minifyjs', 'watcher'
    ]);

    grunt.registerTask( 'minifycss', [
        'cssmin'
    ]);

    grunt.registerTask( 'minifyjs', [
        'uglify'
    ]);

    grunt.registerTask('release', [
        'makepot',
    ]);

    grunt.registerTask( 'zip', [
        'clean',
        'uglify',
        'cssmin',
        'copy',
        'compress'
    ])
};