/*global module:false*/
module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    // Metadata.
    pkg: grunt.file.readJSON('package.json'),
    banner: '/*! <%= pkg.title || pkg.name %> - v<%= pkg.version %> - ' +
      '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
      '<%= pkg.homepage ? "* " + pkg.homepage + "\\n" : "" %>' +
      '* Copyright (c) <%= grunt.template.today("yyyy") %> <%= pkg.author.name %>;' +
      ' Licensed <%= _.pluck(pkg.licenses, "type").join(", ") %> */\n',
    // Task configuration.
    concat: {
      jsfiles: {
	      src: [
			// libraries
			"libs/js/jquery-2.2.2.min.js", "libs/js/underscore.js", "libs/js/grapnel.js", 
			// element modules
			"app/js/elements.js", 
				"app/js/modules/gallery.js", 
			// custom / generic app starter
			"index.js"
			],
	      dest: 'concat/js/concat.js',
	    },
	  css: {
	    src: 'app/css/*.css',
	    dest: 'concat/css/concat.css'
	  }
	    
    },
    uglify: {
      options: {
        banner: '<%= banner %>'
      },
      dist: {
        src: '<%= concat.jsfiles.dest %>',
        dest: 'deploy/js/concat.min.js'
      }
    },

	cssmin: {
	  target: {
	    files: [{
	      expand: true,
	      cwd: 'concat/css',
	      src: ['*.css', '!*.min.css'],
	      dest: 'deploy/css',
	      ext: '.min.css'
	    }]
	  }
	}
  });

  // These plugins provide necessary tasks.
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  

  // Default task.
  grunt.registerTask('default', [ 'concat', 'uglify', 'cssmin']);

};
