FROM yiisoftware/yii2-php:8.4-fpm-nginx
RUN docker-php-ext-install pdo pdo_mysql