# Add security headers
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains; preload" always;
    add_header Content-Security-Policy "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://code.jquery.com https://cdnjs.cloudflare.com https://www.googletagmanager.com https://cdn.datatables.net https://www.google.com/recaptcha/ https://www.gstatic.com/recaptcha/ https://cdn.tailwindcss.com; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://fonts.googleapis.com https://cdn.datatables.net https://cdn.tailwindcss.com; font-src 'self' https://fonts.gstatic.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com data:; img-src 'self' data: https: blob:; connect-src 'self' https://www.google-analytics.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://www.google.com https://cdn.tailwindcss.com; frame-src 'self' https://www.google.com/recaptcha/ https://recaptcha.google.com/recaptcha/ https://www.youtube.com; object-src 'none'; base-uri 'self'; form-action 'self';" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-Frame-Options "DENY" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "no-referrer" always;

    # Use ONLY Permissions-Policy (modern standard).
    # Do NOT use Feature-Policy — it is deprecated and causes conflicts.
    add_header Permissions-Policy "geolocation=(), microphone=(), camera=()" always;