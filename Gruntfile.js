// Gruntfile.js
module.exports = function (grunt) {

    grunt.initConfig({
        // JS TASKS ================================================================
        // check all js files for errors
        jshint: {
            all: ['public/assets/js/*.js']
        },
        // take all the js files and minify them into app.min.js
        uglify: {
            build: {
                files: {
                    'public/assets/js/admin.min.js': 'public/assets/js/admin.js',
                    'public/assets/js/admin_signin.min.js': 'public/assets/js/admin_signin.js',
                    'public/assets/js/main.min.js': 'public/assets/js/main.js'
                }
            }
        },
        // CSS TASKS ===============================================================
        // process the less file to app.css
        less: {
            build: {
                files: {
                    'public/assets/css/admin.less.css': 'public/assets/css/admin.css',
                    'public/assets/css/admin_signin.less.css': 'public/assets/css/admin_signin.css',
                    'public/assets/css/main.less.css': 'public/assets/css/main.css'
                }
            }
        },
        // take the processed app.css file and minify
        cssmin: {
            build: {
                files: {
                    'public/assets/css/admin.min.css': 'public/assets/css/admin.less.css',
                    'public/assets/css/admin_signin.min.css': 'public/assets/css/admin_signin.less.css',
                    'public/assets/css/main.min.css': 'public/assets/css/main.less.css'
                }
            }
        },
        // COOL TASKS ==============================================================
        // watch css and js files and process the above tasks
        watch: {
            css: {
                files: ['public/assets/css/*.css'],
                tasks: ['less', 'cssmin']
            },
            js: {
                files: ['public/assets/js/*.js'],
                tasks: ['jshint', 'uglify']
            }
        },
        // run watch and nodemon at the same time
        concurrent: {
            options: {
                logConcurrentOutput: true
            },
            tasks: ['watch']
        }

    });

    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-concurrent');

    grunt.registerTask('default', ['less', 'cssmin', 'jshint', 'uglify', 'concurrent']);

};