module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		sass_globbing: {
			js_game: {
				options: {
					useSingleQuotes: false,
					signature: '// scss import collection'
				},
				files: {
					'../../sass/imports.scss': '../../sass/dist/**/*.scss',
				}
			}
		},
		sass: {
			dist: {
				files: {
					'../../css/dist/main.css' : '../../sass/imports.scss'
				}
			}
		},
		watch: {
      source: {
        files: ['../../sass/dist/**/*.scss'],
        tasks: ['sass_globbing','sass'],
        options: {
          livereload: true // needed to run LiveReload
        }
      }
    }
	});
	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-sass-globbing');
	grunt.registerTask('default',['watch']);
};
