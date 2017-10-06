var gulp = require('gulp');
var plugins = require('gulp-load-plugins')();
var del = require('del');
var Q = require('q');


var config = {
    assetsDir: 'app/Resources/assets',
    sassPattern: 'sass/**/*.scss',
    production: !!plugins.util.env.production,
    sourceMaps: !plugins.util.env.production,
    bowerDir: 'vendor/bower_components',
    revManifestPath: 'app/Resources/assets/rev-manifest.json'
};

var app = {};


app.addStyle = function(paths, outputFilename) {
    return gulp.src(paths)
        .pipe(plugins.if(!config.production, plugins.plumber(function(error) {
            console.log(error.toString());
            this.emit('end');
        })))
        .pipe(plugins.if(config.sourceMaps, plugins.sourcemaps.init()))
        .pipe(plugins.sass())
        .pipe(plugins.autoprefixer())
        .pipe(plugins.concat('css/'+outputFilename))
        .pipe(config.production ? plugins.minifyCss() : plugins.util.noop())
        .pipe(plugins.rev())
        .pipe(plugins.if(config.sourceMaps, plugins.sourcemaps.write('.')))
        .pipe(gulp.dest('web'))
        // write the rev-manifest.json file for gulp-rev
        .pipe(plugins.rev.manifest(config.revManifestPath, {
            merge: true
        }))
        .pipe(gulp.dest('.'))
        .pipe(plugins.livereload());
};

app.addScript = function(paths, outputFilename) {
    return gulp.src(paths)
        .pipe(plugins.if(!config.production, plugins.plumber(function(error) {
            console.log(error.toString());
            this.emit('end');
        })))
        .pipe(plugins.if(config.sourceMaps, plugins.sourcemaps.init()))
        .pipe(plugins.concat('js/'+outputFilename))
        .pipe(plugins.if(config.production, plugins.uglify()))
        .pipe(plugins.rev())
        .pipe(plugins.if(config.sourceMaps, plugins.sourcemaps.write('.')))
        .pipe(gulp.dest('web'))
        // write the rev-manifest.json file for gulp-rev
        .pipe(plugins.rev.manifest(config.revManifestPath, {
            merge: true
        }))
        .pipe(gulp.dest('.'))
        .pipe(plugins.livereload());
};

app.doStyles = function() {
    var pipeline = new Pipeline();

    pipeline.add([
        config.assetsDir+'/sass/app.scss'
    ], 'app.css');

    pipeline.add([
        config.assetsDir+'/css_mail/foundation.css',
        config.assetsDir+'/css_mail/mail.css'
    ], 'mail.css');

    return pipeline.run(app.addStyle);
};

app.doScripts = function() {
    var pipeline = new Pipeline();

    pipeline.add([
        config.assetsDir+'/js/vendor/jquery-3.0.0.min.js',
        config.assetsDir+'/js/00-app.js',
        config.assetsDir+'/js/01-common.js',
        config.assetsDir+'/js/02-header.js',
        config.assetsDir+'/js/03-forms.js',
        config.assetsDir+'/js/04-showhide.js',
        config.assetsDir+'/js/05-dropdown.js',
        config.assetsDir+'/js/06-slider.js',
        config.assetsDir+'/js/07-maps.js',
        config.assetsDir+'/js/08-accordion.js',
        config.assetsDir+'/js/09-modal.js',
        config.assetsDir+'/js/10-grecaptcha.js',
        config.assetsDir+'/js/99-pages.js',
        config.assetsDir+'/js/vendor/_jquery-ui.min.js',        
        config.assetsDir+'/js/vendor/bootstrap-slider.min.js',
        config.assetsDir+'/js/vendor/jquery.customSelect.min.js',
        config.assetsDir+'/js/vendor/jquery.knob.min.js',
        config.assetsDir+'/js/vendor/jquery-ui.min.js',
        config.assetsDir+'/js/vendor/nouislider.min.js',
        config.assetsDir+'/js/vendor/ofi.browser.js',
        config.assetsDir+'/js/vendor/select2.min.js',
        config.assetsDir+'/js/vendor/slick.min.js',
        config.assetsDir+'/js/vendor/wNumb.js'
    ], 'app.js');

    pipeline.add([
        config.assetsDir+'/js/admin.js'
    ], 'admin.js');

    return pipeline.run(app.addScript);
};

app.livereload_on_templates = function() {
    return gulp.src('app/Resources/views/base_front.html.twig')
        .pipe(plugins.livereload());
};

app.copy = function(srcFiles, outputDir) {
    return gulp.src(srcFiles)
        .pipe(gulp.dest(outputDir));
};


var Pipeline = function() {
    this.entries = [];
};
Pipeline.prototype.add = function() {
    this.entries.push(arguments);
};
Pipeline.prototype.run = function(callable) {
    var deferred = Q.defer();
    var i = 0;
    var entries = this.entries;
    var runNextEntry = function() {
        // see if we're all done looping
        if (typeof entries[i] === 'undefined') {
            deferred.resolve();
            return;
        }
        // pass app as this, though we should avoid using "this"
        // in those functions anyways
        callable.apply(app, entries[i]).on('end', function() {
            i++;
            runNextEntry();
        });
    };
    runNextEntry();
    return deferred.promise;
};

gulp.task('styles', function() {
    return app.doStyles();
});

gulp.task('styles_libraries', ['styles'], function() {
    var pipeline = new Pipeline();

    pipeline.add([
        config.bowerDir+'/jquery-ui/themes/smoothness/jquery-ui.min.css',
        config.bowerDir+'/semantic/dist/semantic.css',
        config.bowerDir+'/font-awesome/css/font-awesome.css',
        config.bowerDir+'/toastr/toastr.css',
        config.assetsDir+'/icomoon/style.css'
    ], 'libraries.css');

    pipeline.add([
        config.assetsDir+'/soundmanager/css/bar-ui.css'
    ], 'soundmanager/css/soundmanager.css');

    return pipeline.run(app.addStyle);
});

gulp.task('scripts', ['styles_libraries'], function() {
    return app.doScripts();
});

gulp.task('scripts_libraries', ['scripts'], function() {
    var pipeline = new Pipeline();

    pipeline.add([
        config.bowerDir+'/jquery/dist/jquery.js',
        config.bowerDir+'/jquery-ui/jquery-ui.min.js',
        config.bowerDir+'/blueimp-file-upload/js/jquery.iframe-transport.js',
        config.bowerDir+'/blueimp-file-upload/js/jquery.fileupload.js',
        config.bowerDir+'/semantic/dist/semantic.js',
        config.bowerDir+'/toastr/toastr.js'
    ], 'libraries.js');

    pipeline.add([
        config.bowerDir+'/soundmanager2/script/soundmanager2.js'
    ], 'soundmanager.js');

    return pipeline.run(app.addScript);
});

gulp.task('ressources', function() {
    app.copy(
        config.bowerDir+'/font-awesome/fonts/*',
        'web/fonts'
    );

    app.copy(
        config.bowerDir+'/semantic/dist/themes/default/**/*',
        'web/css/themes/default'
    );

    app.copy(
        config.assetsDir+'/icomoon/fonts/*',
        'web/css/fonts'
    );

    app.copy(
        config.assetsDir+'/soundmanager/image/**/*',
        'web/css/soundmanager/image'
    );

    app.copy(
        config.bowerDir+'/jquery-ui/themes/smoothness/images/**/*',
        'web/css/images'
    );
});

gulp.task('livereload_on_templates', function() {
    app.livereload_on_templates();
});

gulp.task('watch_styles', function() {
    return app.doStyles();
});

gulp.task('watch_scripts', function() {
    return app.doScripts();
});

gulp.task('clean', function() {
    del.sync(config.revManifestPath);
    del.sync('web/css/*');
    del.sync('web/js/*');
    del.sync('web/fonts/*');
});

gulp.task('watch', function() {
    plugins.livereload.listen();
    gulp.watch('app/Resources/views/**/*', ['livereload_on_templates']);
    gulp.watch(config.assetsDir+'/'+config.sassPattern, ['watch_styles']);
    gulp.watch(config.assetsDir+'/js/**/*.js', ['watch_scripts']);
});

var tasks_to_launch = ['clean', 'styles', 'styles_libraries', 'scripts', 'scripts_libraries', 'ressources'];

if( !config.production ) {
    tasks_to_launch.push('watch');
}

gulp.task('default', tasks_to_launch);



var realFavicon = require ('gulp-real-favicon');
var fs = require('fs');

// File where the favicon markups are stored
var FAVICON_DATA_FILE = 'faviconData.json';

// Generate the icons. This task takes a few seconds to complete.
// You should run it at least once to create the icons. Then,
// you should run it whenever RealFaviconGenerator updates its
// package (see the check-for-favicon-update task below).
gulp.task('generate-favicon', function(done) {
    realFavicon.generateFavicon({
        masterPicture: config.assetsDir+'/favicon/master_favicon.png',
        dest: 'web/favicons',
        iconsPath: '/favicons',
        design: {
            ios: {
                pictureAspect: 'noChange',
                assets: {
                    ios6AndPriorIcons: false,
                    ios7AndLaterIcons: false,
                    precomposedIcons: false,
                    declareOnlyDefaultIcon: true
                }
            },
            desktopBrowser: {},
            windows: {
                pictureAspect: 'noChange',
                backgroundColor: '#ffffff',
                onConflict: 'override',
                assets: {
                    windows80Ie10Tile: false,
                    windows10Ie11EdgeTiles: {
                        small: false,
                        medium: true,
                        big: false,
                        rectangle: false
                    }
                }
            },
            androidChrome: {
                pictureAspect: 'noChange',
                themeColor: '#ffffff',
                manifest: {
                    name: 'M&M',
                    display: 'standalone',
                    orientation: 'notSet',
                    onConflict: 'override',
                    declared: true
                },
                assets: {
                    legacyIcon: false,
                    lowResolutionIcons: false
                }
            },
            safariPinnedTab: {
                pictureAspect: 'silhouette',
                themeColor: '#5bbad5'
            }
        },
        settings: {
            scalingAlgorithm: 'Mitchell',
            errorOnImageTooSmall: false
        },
        markupFile: FAVICON_DATA_FILE
    }, function() {
        done();
    });
});

// Inject the favicon markups in your HTML pages. You should run
// this task whenever you modify a page. You can keep this task
// as is or refactor your existing HTML pipeline.
gulp.task('inject-favicon-markups', function() {
    gulp.src(['app/Resources/views/template/base_tpl.html.twig'])
        .pipe(realFavicon.injectFaviconMarkups(JSON.parse(fs.readFileSync(FAVICON_DATA_FILE)).favicon.html_code))
        .pipe(gulp.dest('app/Resources/views/template'));
});

// Check for updates on RealFaviconGenerator (think: Apple has just
// released a new Touch icon along with the latest version of iOS).
// Run this task from time to time. Ideally, make it part of your
// continuous integration system.
gulp.task('check-for-favicon-update', function(done) {
    var currentVersion = JSON.parse(fs.readFileSync(FAVICON_DATA_FILE)).version;
    realFavicon.checkForUpdates(currentVersion, function(err) {
        if (err) {
            throw err;
        }
    });
});