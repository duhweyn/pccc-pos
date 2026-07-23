FROM ubuntu:22.04

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y \
    software-properties-common curl gnupg2 git unzip \
    nginx supervisor

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

COPY docker/nginx.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN service mariadb start && \
    mysql -e "CREATE DATABASE IF NOT EXISTS nexopos; CREATE USER IF NOT EXISTS 'nexo'@'localhost' IDENTIFIED BY 'nexopassword'; GRANT ALL PRIVILEGES ON nexopos.* TO 'nexo'@'localhost'; FLUSH PRIVILEGES;" && \
    service mariadb stop

EXPOSE 80
CMD ["/usr/bin/supervisord", "-n"]

RUN apt-get update && apt-get install -y \
    software-properties-common curl gnupg2 git unzip \
    nginx supervisor mariadb-server