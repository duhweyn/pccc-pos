FROM ubuntu:22.04

ENV DEBIAN_FRONTEND=noninteractive

# Prevent package post-install scripts from trying to auto-start services during build
RUN printf '#!/bin/sh\nexit 101\n' > /usr/sbin/policy-rc.d && chmod +x /usr/sbin/policy-rc.d

RUN apt-get update && apt-get install -y \
    software-properties-common curl gnupg2 git unzip \
    nginx supervisor mariadb-server

RUN add-apt-repository ppa:ondrej/php -y && apt-get update && \
    apt-get install -y php8.2 php8.2-fpm php8.2-cli php8.2-mysql \
    php8.2-mbstring php8.2-xml php8.2-curl php8.2-zip php8.2-gd \
    php8.2-bcmath php8.2-intl

RUN curl -sL https://deb.nodesource.com/setup_22.x | bash - && apt-get install -y nodejs
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html
COPY . .

RUN cp .env.example .env

RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Seed the database at build time (data resets to this state on every redeploy)
RUN mkdir -p /run/mysqld && chown mysql:mysql /run/mysqld && \
    service mariadb start && \
    mysql -e "CREATE DATABASE IF NOT EXISTS nexopos; CREATE USER IF NOT EXISTS 'nexo'@'localhost' IDENTIFIED BY 'nexopassword'; GRANT ALL PRIVILEGES ON nexopos.* TO 'nexo'@'localhost'; FLUSH PRIVILEGES;" && \
    service mariadb stop

COPY docker/nginx.conf.template /etc/nginx/sites-available/default.template
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN sed -i 's/\r$//' /usr/local/bin/entrypoint.sh && chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 10000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-n"]