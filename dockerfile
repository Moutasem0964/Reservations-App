# Use Render’s maintained nginx+PHP-FPM image (supports PHP 8+)
FROM richarvey/nginx-php-fpm:3.1.6

# Set working directory inside the container
WORKDIR /var/www/html

# Copy all your application code
COPY . .

# Tell the image to skip its default composer install (we'll do it ourselves)
ENV SKIP_COMPOSER=1 \
    WEBROOT=/var/www/html/public \
    PHP_ERRORS_STDERR=1 \
    RUN_SCRIPTS=1 \
    REAL_IP_HEADER=1 \
    APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr \
    COMPOSER_ALLOW_SUPERUSER=1

# Install PHP dependencies, optimize autoload, and run any 'post-install' scripts
RUN composer install --no-dev --optimize-autoloader

# (Optional) If you have Node/Vite assets, add something like:
# RUN npm install && npm run build

# Expose the port that PHP’s built-in server will listen on
# (the image’s /start.sh script uses $PORT from Render)
EXPOSE 10000

# Start the container by running Render’s startup script, which:
# 1. Runs migrations/caches if configured
# 2. Launches PHP-FPM + nginx
CMD ["/start.sh"]
