
// const connect = require('gulp-connect');
// const browserSync = require('browser-sync').get('BrowserSync Server');

module.exports = function (gulp, config, $) {
  gulp.task('watch', 'When any of the locally watched files change, run a specific task.', () => {
    gulp.watch('source/_email-templates/**/*.html', ['email-templates']);
    gulp.watch('source/images/icons/**/*', ['svgstore', 'patternlab']);
    // gulp.watch(['source/styles/**/*.scss', 'node_modules/pegakit-framework/**/*.scss'], ['styles']);
    gulp.watch(['source/**/*.js', '!source/scripts/libs/inline_svg_rev.js'], ['webpack:dev']);

    // Automatically recompile patternlab if our inlined critical JS file changes.
    gulp.watch(['public/scripts/critical.built.js'], ['patternlab']);
    // gulp.watch(['public/styles/critical/**/*'], ['patternlab']);

    gulp.watch([
      'source/_patterns/**/*.twig',
      'source/_patterns/**/*.json',
      'source/_patterns/**/*.yml',
      'source/_patterns/**/*.yaml',
      'source/_patterns/**/*.md',
      'source/_data/**/*.json',
      'source/_twig-components/**/*.php',
      'source/_meta/**/*.twig'
    ], ['patternlab']);

    // gulp.watch([
    //   'source/_data/*.sass.json',
    // ], ['patternlab']);

    // gulp.watch('public/latest-change.txt').on('change', browserSync.reload);
    // gulp.watch("public/scripts/**/*").on('change',  browserSync.reload);
  });
};
