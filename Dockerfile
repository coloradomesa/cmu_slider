FROM php:5-apache
RUN docker-php-ext-install pdo pdo_mysql
COPY . /var/www/html/cmu_slider/
ENV MYSQL_HOST=mysql
ENV MYSQL_DB=cmu_slider
ENV MYSQL_USER=root
ENV MYSQL_PASS=scoobydoobydoo
VOLUME /var/www/html/cmu_slider/img