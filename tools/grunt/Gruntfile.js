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
        tasks: ['sass_globbing','sass', 'ftp_push'],
        options: {
          livereload: true // needed to run LiveReload
        }
      }
    },
		ftp_push: {
			js_game: {
				options: {
					host: "w013fbb2.kasserver.com",
					dest: "/",
					port: 21,
					username: "f00bc720",
					password: "MvVthSs24mRA3AQg",
					keepAlive: 10000
				},
        files: [
          {expand: true, cwd: './', src: ['../../css/dist/**/*.*'], dest: './'},
					{expand: true, cwd: './', src: ['../../sass/*.*'], dest: './'}
        ]
			}
		}
	});
	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-sass-globbing');
	grunt.loadNpmTasks('grunt-ftp-push');
	grunt.registerTask('default',['watch']);
};
