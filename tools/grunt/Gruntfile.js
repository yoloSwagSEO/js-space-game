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
		autoprefixer: {
			options: {
				// Add some browser thresholds for css compatibility in the future
				// (for example: we are supporting only IE8, Firefox 32 and Chrome 35, etc)
			},
			files: {
				src: '../../css/dist/*.css'
			}
		},
		watch: {
      source: {
        files: ['../../sass/dist/**/*.scss'],
        tasks: ['sass_globbing','sass', 'autoprefixer'],
        options: {
          livereload: false // needed to run LiveReload
        }
      }
    }
	});
	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-sass-globbing');
	grunt.loadNpmTasks('grunt-autoprefixer');
	grunt.registerTask('default',['watch']);
};
