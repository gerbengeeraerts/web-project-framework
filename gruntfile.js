module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    uglify: {
      options: {
        banner: '/*! <%= pkg.name %> <%= pkg.author %> <%= grunt.template.today("yyyy-mm-dd") %> */\n',
        screwIE8: true
      },
      build: {
        src: './js/app.js',
        dest: './deploy/js/app.min.js'
      }
    },

    compass: {
      build: {
        options: {
          sassDir: './css',
          cssDir: './deploy/css/',
          environment: 'development'
        }
      }
    },

    watch: {
      css: {
        files: './css/**/*.scss',
        tasks: ['styles'],
        options: {
          livereload: true,
        }
      },
      js: {
        files: './js/**/*.js',
        tasks: ['scripts'],
        options: {
          livereload: true,
        },
      },
    },

  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-beep');

  grunt.registerTask('styles', ['compass']);
  grunt.registerTask('scripts', ['uglify']);

};
