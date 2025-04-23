# Use an image with Nginx + PHP-FPM
FROM richarvey/nginx-php-fpm:3.1.6

WORKDIR /var/www/html
COPY . .

# Install PHP deps
RUN composer install --no-dev --optimize-autoloader

# (Optional) If you build frontend assets:
# RUN npm install && npm run build

EXPOSE 10000
CMD ["/start.sh"]
