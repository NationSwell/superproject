module.exports = function(grunt) {


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
            build: {
                files: {
                    'js/build/combined.min.js': '.grunt-cache/combined.js'
                }
            }
        },
        concat: {
            options: {
                separator: ';'
            },
            build: {
                files: {
                    '.grunt-cache/combined.js': [
                        'js/src/vendor/touche.js',
                        'js/src/vendor/twig.min.js',
                        'js/build/twig-templates.js',
                        'js/src/vendor/media.match.js',
                        'js/src/vendor/enquire.js',
                        'js/src/vendor/jquery.cookie.js',
                        'js/src/vendor/jquery.ajaxchimp.js',
                        'js/src/vendor/jquery.mousewheel.min.js',
                        'js/src/vendor/jquery.transit.min.js',
                        'js/src/vendor/jquery.touchSwipe.js',
                        'js/src/vendor/jquery.carouFredSel-6.2.1.js',
                        'js/src/vendor/jquery.validate.min.js',
                        'js/src/vendor/jquery.cookie.js',
                        'js/src/vendor/jquery.ba-throttle-debounce.js',
                        'js/src/vendor/waypoints.min.js',
                        'js/src/vendor/waypoints-sticky.min.js',
                        'js/src/vendor/audiojs/audio.min.js',
                        'js/src/vendor/imagesloaded.pkgd.js',
                        'js/src/events.js',
                        'js/src/masked-input.js',
                        'js/src/vendor/ReSmenu-master/jquery.resmenu.min.js',
                        'js/src/vendor/ReStable/jquery.restable.js',
                        'js/src/ga-tracking.js',
                        'js/src/main.js',
                    ]
                }
            }
        },
        compass: {
            dev: {
                options: {
                    bundleExec: true,
                    cssDir: 'css',
                    sassDir: 'scss',
                    imagesDir: 'img',
                    relativeAssets: true,
                    generatedImagesPath: 'img',
                    require: ['breakpoint'],
                    environment: 'development',
                    sourcemap: true
                }
            },
            prod: {
                options: {
                    bundleExec: true,
                    cssDir: 'css',
                    sassDir: 'scss',
                    imagesDir: 'img',
                    relativeAssets: true,
                    generatedImagesPath: 'img',
                    require: ['breakpoint'],
                    environment: 'production',
                    sourcemap: false
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
                    hashes: false,
                    startCodepoint: 0xF101,
                    codepoints: {
                        star: 0xF100
                    }
                }
            }
        },
        watch: {
            css: {
                files: '**/*.scss',
                tasks: ['compass:dev', 'bumpVersion']
            },
            icons: {
                files: ['icons/*.svg'],
                tasks: ['default']
            },
            js: {
                files: ['js/src/*.js', 'js/src/vendor/*.js'],
                tasks: ['js']
            },
            twig: {
                files: 'views-client/*.twig',
                tasks: ['js']
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

    grunt.registerTask('base', ['twig', 'concat', 'uglify', 'bumpVersion']);
    grunt.registerTask('dev', ['base', 'compass:dev', 'watch']);
    grunt.registerTask('prod', ['base', 'compass:prod']);
    grunt.registerTask('default', ['dev']);

    grunt.task.registerTask('bumpVersion', 'Bump the version number file', function() {

        var version = parseInt(grunt.file.read('version.txt'));
        version++;

        grunt.file.write('version.txt', version);

        grunt.log.writeln(this.name + " Updating version number to: " + version);
    });

};