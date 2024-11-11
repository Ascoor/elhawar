# استخدام PHP 7.3 مع PHP-FPM
FROM php:7.4-fpm

# تثبيت Nginx و Supervisor
RUN apt-get update && apt-get install -y nginx supervisor

# تثبيت الحزم اللازمة (بما في ذلك libssl-dev لدعم openssl و libicu-dev لدعم intl)
RUN apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libicu-dev \
    libxml2-dev \
    libzip-dev \
    libexif-dev \
    libssl-dev \
    libonig-dev \
    unzip \
    git \
    curl \
    && rm -rf /var/lib/apt/lists/*

# تثبيت ملحقات PHP المطلوبة
RUN docker-php-ext-install exif bcmath intl json xml mbstring fileinfo tokenizer

# إعداد مكتبة gd
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# تثبيت امتدادات إضافية
RUN docker-php-ext-install mysqli pdo pdo_mysql zip
# تثبيت Node.js 12 وNPM 6
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@6
# تثبيت Composer 2.2.21
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.2.21

# إعداد مجلد العمل
WORKDIR /var/www/html/elhawar

# نسخ ملفات المشروع إلى مجلد العمل
COPY . .

# ضبط أذونات الملفات
RUN chown -R www-data:www-data /var/www/html/elhawar && chmod -R 755 /var/www/html/elhawar

# إعداد Git
RUN git config --global --add safe.directory /var/www/html/elhawar

# تثبيت حزم Composer
RUN composer install --no-dev --optimize-autoloader --no-interaction || true

# نسخ إعدادات Nginx وSupervisor
COPY nginx-config.conf /etc/nginx/conf.d/default.conf
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# إعداد أذونات مجلدات التخزين
RUN chmod -R 775 storage bootstrap/cache && chown -R www-data:www-data storage bootstrap/cache

# فتح المنفذ 80
EXPOSE 80

# تشغيل Supervisor لإدارة php-fpm وNginx
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
