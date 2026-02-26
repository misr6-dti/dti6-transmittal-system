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

// Dynamic resource root for subdirectory deployments
// Set MIX_ASSET_URL in .env to match your APP_URL (e.g., /dti6-tms/public)
if (process.env.MIX_ASSET_URL) {
    const url = new URL(process.env.MIX_ASSET_URL, 'http://localhost');
    mix.setResourceRoot(url.pathname.replace(/\/$/, '') + '/');
}

mix.js("resources/js/app.js", "public/js")
    .postCss("resources/css/app.css", "public/css", [
        require("tailwindcss"),
        require("autoprefixer"),
    ])
    .options({
        processCssUrls: false,
    });

// Vendor styles removed (Tailwind migration)

if (mix.inProduction()) {
    mix.version();
}
