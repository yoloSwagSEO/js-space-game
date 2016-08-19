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
				browsers: ['last 4 versions']
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
		},
		uglify: {
	    all_src : {
	      options : {
	        sourceMap : false,
	        sourceMapName : 'sourceMap.map'
	      },
	      src : '../../js/**/*.js',
	      dest : '../../js/dist/composite.all.min.js'
	    }
	  }
	});
	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-sass-globbing');
	grunt.loadNpmTasks('grunt-autoprefixer');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.registerTask('jscomp', ['uglify']);
	grunt.registerTask('default',['watch']);
};
