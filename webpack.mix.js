const mix = require('laravel-mix');


/**
    Laravel Mix Bundle Analyzer
    Allows the review of assets compiled for the site

 */

/*
require('laravel-mix-bundle-analyzer');

if (!mix.inProduction()) {
    mix.bundleAnalyzer();
}
*/





/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

/*
mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);
*/


//Backend
mix.js('resources/admin/js/app.js', 'public/admin/js') //compiles the content  of app.js and creates the file in 'public/admin/js'
    .sass('resources/admin/css/app.scss', 'public/admin/css')   //The sass method allows you to compile Sass into CSS
    .js('node_modules/popper.js/dist/popper.js', 'public/js')
    .js('resources/admin/js/pages/admins/list.js', 'public/admin/js/pages/admins/list.js')
    .js('resources/admin/js/pages/clients/list.js', 'public/admin/js/pages/clients/list.js')
    .js('resources/admin/js/pages/users/list.js', 'public/admin/js/pages/users/list.js')
    .js('resources/admin/js/pages/include/modal.js', 'public/admin/js/pages/include/modal.js')
    .js('resources/js/app.js', 'public/js') //compiles the content  of app.js and creates the file in 'public/js'
    .sass('resources/sass/app.scss', 'public/css')   //The sass method allows you to compile Sass into CSS

    .sourceMaps()
    .version(); // aka "cache busting". It versions the files by adding ?#123456789 after the file name. Must use {{mix('myfile')}} instead of {{asset('myfile')}}


//To copy the latest TinyMCE files to the public directory: NPM run DEV
//https://artisansweb.net/install-use-tinymce-wysiwyg-html-editor-laravel/

mix.copyDirectory('node_modules/tinymce/icons', 'public/node_modules/tinymce/icons');
mix.copyDirectory('node_modules/tinymce/plugins', 'public/node_modules/tinymce/plugins');
mix.copyDirectory('node_modules/tinymce/skins', 'public/node_modules/tinymce/skins');
mix.copyDirectory('node_modules/tinymce/themes', 'public/node_modules/tinymce/themes');
mix.copy('node_modules/tinymce/jquery.tinymce.js', 'public/node_modules/tinymce/jquery.tinymce.js');
mix.copy('node_modules/tinymce/jquery.tinymce.min.js', 'public/node_modules/tinymce/jquery.tinymce.min.js');
mix.copy('node_modules/tinymce/tinymce.js', 'public/node_modules/tinymce/tinymce.js');
mix.copy('node_modules/tinymce/tinymce.min.js', 'public/node_modules/tinymce/tinymce.min.js');
