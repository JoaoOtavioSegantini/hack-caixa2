FROM php:8.1.1-fpm

RUN apt-get update && apt-get install -y --allow-downgrades \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    gnupg gnupg2 and gnupg1 wget libltdl-dev

RUN cat /etc/os-release \
  && apt-get update \
  && curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
  && curl https://packages.microsoft.com/config/ubuntu/20.04/prod.list \
      > /etc/apt/sources.list.d/mssql-release.list \
  && apt-get install -y --no-install-recommends apt-transport-https \
  && apt-get update \
  && ACCEPT_EULA=Y apt-get install -y msodbcsql17 odbcinst=2.3.7 odbcinst1debian2=2.3.7 unixodbc-dev=2.3.7 unixodbc=2.3.7 mssql-tools

RUN wget ftp://ftp.unixodbc.org/pub/unixODBC/unixODBC-2.3.11.tar.gz && \
    tar -xzf unixODBC-2.3.11.tar.gz && \
    cd unixODBC-2.3.11 && \
    ./configure --enable-ltdl-install --prefix=/usr/local/unixODBC && \
    make && \
    make install

RUN pecl install sqlsrv
RUN pecl install pdo_sqlsrv

RUN usermod -u 1000 www-data

WORKDIR /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

USER www-data

EXPOSE 9000
