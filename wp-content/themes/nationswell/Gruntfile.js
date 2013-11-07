module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
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
                destCss: 'scss/partials',
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
                tasks: ['compass']
            },
            icons: {
                files: ['icons/*.svg'],
                tasks: ['icons']
            }
        }
    });



    grunt.event.on('watch', function(action, filepath, target) {
        grunt.log.writeln(target + ': ' + filepath + ' has ' + action);
    });

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-webfont');
    grunt.loadNpmTasks('grunt-contrib-compass');

    grunt.registerTask('default', ['webfont','compass']);
    grunt.registerTask('icons', ['webfont','compass']);
};