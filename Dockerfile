FROM php:7.4-apache

LABEL maintainer="rizwan@celestialsys.com"

ARG PackageName
ARG PackageVersion
ARG NexusUser
ARG NexusPassword
ARG GitUsr
ARG GitToken
ARG PHPsdkGitURL
ARG PHPsdkBranch

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN apt-get update \
    && apt-get install -y git zip unzip zlib1g-dev libzip-dev wget \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN apt-get update && apt-get install -y libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/*
RUN pecl install imagick-beta
RUN docker-php-ext-enable imagick

RUN docker-php-ext-install zip \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install bcmath


WORKDIR /var/www/html/
COPY . .
EXPOSE 80
RUN composer install

# get the desired php sdk branch
RUN git clone --branch=${PHPsdkBranch} https://${GitUsr}:${GitToken}@${PHPsdkGitURL} /tmp/phpsdk \
    && /bin/cp -fr /tmp/phpsdk/* /var/www/html/vendor/froala/wysiwyg-editor-php-sdk/ \
    && rm -rf /tmp/phpsdk

# get the desired unpublished core library
RUN wget --no-check-certificate --user ${NexusUser}  --password ${NexusPassword} https://nexus.tools.froala-infra.com/repository/Froala-npm/${PackageName}/-/${PackageName}-${PackageVersion}.tgz
RUN tar -xvf ${PackageName}-${PackageVersion}.tgz

RUN cp -a package/. vendor/froala/wysiwyg-editor/
RUN rm -rf package/ ${PackageName}-${PackageVersion}.tgz
