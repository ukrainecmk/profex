#!/usr/bin/env bash

debconf-set-selections <<< 'mysql-server-5.5 mysql-server/root_password password rootpass'
debconf-set-selections <<< 'mysql-server-5.5 mysql-server/root_password_again password rootpass'

debconf-set-selections <<< 'phpmyadmin phpmyadmin/reconfigure-webserver multiselect apache2'
debconf-set-selections <<< 'phpmyadmin phpmyadmin/dbconfig-install boolean true'
debconf-set-selections <<< 'phpmyadmin phpmyadmin/mysql/admin-user string root'
debconf-set-selections <<< 'phpmyadmin phpmyadmin/mysql/admin-pass password rootpass'
debconf-set-selections <<< 'phpmyadmin phpmyadmin/mysql/app-pass password rootpass'
debconf-set-selections <<< 'phpmyadmin phpmyadmin/app-password-confirm password rootpass'

apt-get update
apt-get install -y python-software-properties
add-apt-repository ppa:ondrej/php5

apt-get update
apt-get install -q -y apache2 php5 php5-mysql php5-cli php5-curl curl git libapache2-mod-php5 redis-server mc links wget mysql-server phpmyadmin screen imagemagick

# DB Configuration
echo 'CREATE USER 'webchallenge'@'localhost' IDENTIFIED BY "webchallengepa$$"' | mysql -uroot -prootpass
echo "CREATE DATABASE webchallenge" | mysql -uroot -prootpass
echo "GRANT ALL ON webchallenge.* TO 'webchallenge'@'localhost'" | mysql -uroot -prootpass
echo "flush privileges" | mysql -uroot -prootpass

#touch /var/log/databasesetup

if [ -f /vagrant/deploy/data/initial.sql ];
then
    mysql -uroot -prootpass webchallenge < /vagrant/deploy/data/initial.sql
fi

rm -rf /var/www
ln -fs /vagrant /var/www

cd /var/www
export COMPOSER_PROCESS_TIMEOUT=600
/usr/local/bin/composer install

# configs
cp /vagrant/application/settings/config.db_example.php /vagrant/application/settings/config.db.php
cp /vagrant/application/settings/config.url_example.php /vagrant/application/settings/config.url.php
cp /vagrant/application/settings/config_example.php /vagrant/application/settings/config.php
cp /vagrant/example.htaccess /vagrant/.htaccess

# tmp folders
mkdir /vagrant/tmp/tpl_compiled /vagrant/tmp/zend_cache

# phpmyadmin
cp /etc/phpmyadmin/apache.conf /etc/apache2/conf-enabled/phpmyadmin.conf

# Apache
cat /vagrant/deploy/data/apache > /etc/apache2/sites-available/default.conf

# Enabling needed apache modules
a2enmod headers
a2enmod expires
a2enmod rewrite

# Enabling default site
a2ensite default

# Changing port
#sed -i 's/Listen 80/Listen 8080/g' /etc/apache2/ports.conf

# Changing php sessions folder
#sed -i 's/;session.save_path/session.save_path/g' /etc/php5/apache2/php.ini
#sed -i 's/\/var\/lib\/php5/\/var\/lib\/php5\/sessions/g' /etc/php5/apache2/php.ini

# AllowOverride for htaccess
sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Security
# TODO

# Restarting apache && nginx
/etc/init.d/apache2 restart
