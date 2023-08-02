FROM php:8.2.8-cli-bookworm

RUN apt-get update \
	&& apt-get install --yes --show-progress --verbose-versions zip unzip git

RUN git config --global user.name masakazu-hirano \
	&& git config --global user.email @users.noreply.github.com \
	&& git config --global init.defaultBranch master

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
	&& php composer-setup.php && php -r "unlink('composer-setup.php');" \
	&& mv composer.phar /usr/local/bin/composer

COPY . /usr/local/src
WORKDIR /usr/local/src

RUN composer update && composer install
