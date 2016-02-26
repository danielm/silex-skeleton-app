#!/bin/bash

apache_config_file="/etc/apache2/envvars"
apache_vhost_file="/etc/apache2/sites-available/vagrant_vhost.conf"
project_web_root="public"

apt-get update

# Network settings
IPADDR=$(/sbin/ifconfig eth0 | awk '/inet / { print $2 }' | sed 's/addr://')
sed -i "s/^${IPADDR}.*//" /etc/hosts

echo ${IPADDR} ubuntu.localhost >> /etc/hosts

# Apache
apt-get -y install apache2

sed -i "s/^\(.*\)www-data/\1vagrant/g" ${apache_config_file}
chown -R vagrant:vagrant /var/log/apache2

if [ ! -f "${apache_vhost_file}" ]; then
	cat << EOF > ${apache_vhost_file}
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot /vagrant/${project_web_root}
    LogLevel debug

    ErrorLog /var/log/apache2/error.log
    CustomLog /var/log/apache2/access.log combined

    <Directory /vagrant/${project_web_root}>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
EOF
fi

a2dissite 000-default
a2ensite vagrant_vhost

a2enmod rewrite

service apache2 reload
update-rc.d apache2 enable

# SQLite
apt-get install sqlite3

# Memcached
apt-get -y install memcached
apt-get -y install php5-memcached

# PHP
apt-get -y install php5 php5-curl php5-sqlite php5-cli

service apache2 reload

# Install latest version of Composer globally
if [ ! -f "/usr/local/bin/composer" ]; then
	curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
fi