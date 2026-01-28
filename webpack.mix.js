const mix = require("laravel-mix");

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

mix.js("resources/js/app.js", "public/js")
    .postCss("resources/css/app.css", "public/css", [
        require("postcss-import"),
        require("tailwindcss"),
        require("autoprefixer"),
    ])
    .options({
        processCssUrls: false,
    });

mix.styles([
    "node_modules/bootstrap/dist/css/bootstrap.min.css",
    "node_modules/bootstrap-icons/font/bootstrap-icons.css",
    "node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css",
    "node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css"
], "public/css/vendor.css");

mix.copyDirectory("node_modules/bootstrap-icons/font/fonts", "public/css/fonts");

if (mix.inProduction()) {
    mix.version();
}
