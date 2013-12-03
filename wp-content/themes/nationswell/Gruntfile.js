module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        uglify: {
            options: {
                mangle: false
            },
            build: {
                files: {
                    'js/build/combined.min.js': [
                        'js/src/vendor/matchMedia.js',
                        'js/src/vendor/matchMedia.addListener.js',
                        'js/src/vendor/enquire.js',
                        'js/src/vendor/jquery.cookie.js',
                        'js/src/vendor/jquery.ajaxchimp.js',
                        'js/src/vendor/jquery.transit.min.js',
                        'js/src/vendor/jquery.touchSwipe.min.js',
                        'js/src/vendor/jquery.carouFredSel-6.2.1.min.js',
                        'js/src/vendor/jquery.cookie.js',
                        'js/src/vendor/waypoints.min.js',
                        'js/src/vendor/waypoints-sticky.min.js',
                        'js/src/main.js'
                    ]
                }
            }
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
                tasks: ['uglify', 'bumpVersion']
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

    grunt.registerTask('default', ['webfont','compass', 'bumpVersion']);
    grunt.registerTask('icons', ['webfont','compass']);

    grunt.task.registerTask('bumpVersion', 'Bump the version number file', function() {

        var time = new Date().getTime();

        grunt.file.write('version.txt', time);

        grunt.log.writeln(this.name + " Updating version number to: " + time);
    });

};