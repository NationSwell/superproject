module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        uglify: {
            options: {},
            build: {
                src: '',
                dest: ''
            }
        },
        concat: {
            options: {},
            build: {
                src: [],
                dest: ''
            }
        },
        webfont: {
            icons: {
                src: 'icons/*.svg',
                dest: 'fonts',
                destCss: 'scss/partials',
                options: {
                    stylesheet: 'scss',
                    relativeFontPath: '/static/fonts',
                    htmlDemo: false
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-webfont');

    grunt.registerTask('default', ['uglify','concat']);
    grunt.registerTask('icons', 'webfont');
};