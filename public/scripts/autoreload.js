const browserSync = require('browser-sync').create()

browserSync.init({
    server:{
        // Base Port
        port: 4000,
        baseDir: '.', // Base directory
        index: 'index.php' // Index file
    }
});

// Watch for changes in all the files in the public folder and app folder and reload the browser
browserSync.watch(['./public/**/*.*', './app/**/*.*']).on('change', browserSync.reload);
