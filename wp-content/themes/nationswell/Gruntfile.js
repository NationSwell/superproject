module.exports = function(grunt) {

    var jsFiles = {
        files: {
            'js/build/combined.min.js': [
                'js/src/vendor/twig.min.js',
                'js/build/twig-templates.js',
                'js/src/vendor/enquire.js',
                'js/src/vendor/jquery.cookie.js',
                'js/src/vendor/jquery.ajaxchimp.js',
                'js/src/vendor/jquery.transit.min.js',
                'js/src/vendor/jquery.touchSwipe.min.js',
                'js/src/vendor/jquery.carouFredSel-6.2.1.min.js',
                'js/src/vendor/jquery.validate.min.js',
                'js/src/vendor/jquery.cookie.js',
                'js/src/vendor/waypoints.min.js',
                'js/src/vendor/waypoints-sticky.min.js',
                'js/src/vendor/audiojs/audio.min.js',
                'js/src/main.js'
            ]
        }
    };

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        twig: {
            options: {
                amd_wrapper: false,
                variable: 'twigs',
                template: 'var {{ variable }} = {};\n{{ templates }}\n'
            },
            build: {
                files: {
                    'js/build/twig-templates.js': ['views-client/*.twig']
                }
            }
        },
        uglify: {
            options: {
                mangle: false
            },
            build: jsFiles
        },
        concat: {
            options: {
                separator: ';'
            },
            build: jsFiles
        },
        compass: {
            dist: {
                options: {
                    config: 'config.rb'
                }
            }
        },
        webfont: {
            icons: {
                src: 'icons/*.svg',
                dest: 'fonts',
                destCss: 'scss/partials/base',
                options: {
                    stylesheet: 'scss',
                    relativeFontPath: '../fonts',
                    htmlDemo: false,
                    hashes: false
                }
            }
        },
        watch: {
            css: {
                files: '**/*.scss',
                tasks: ['compass', 'bumpVersion']
            },
            icons: {
                files: ['icons/*.svg'],
                tasks: ['icons']
            },
            js: {
                files: ['js/src/*.js', 'js/src/vendor/*.js'],
                tasks: ['concat', 'bumpVersion']
            },
            twig: {
                files: 'views-client/*.twig',
                tasks: ['twig', 'concat', 'bumpVersion']
            }
        }
    });



    grunt.event.on('watch', function(action, filepath, target) {
        grunt.log.writeln(target + ': ' + filepath + ' has ' + action);
    });

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-webfont');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-twig');

    grunt.registerTask('default', ['webfont','compass', 'twig', 'uglify', 'bumpVersion']);
    grunt.registerTask('icons', ['webfont','compass']);

    grunt.task.registerTask('bumpVersion', 'Bump the version number file', function() {

        var time = new Date().getTime();

        grunt.file.write('version.txt', time);

        grunt.log.writeln(this.name + " Updating version number to: " + time);
    });

};