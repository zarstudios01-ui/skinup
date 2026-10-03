FROM wordpress:php8.3-apache

COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html

RUN printf '%s\n' \
 '#!/bin/sh' \
 'rm -f /etc/apache2/mods-enabled/mpm_*.load /etc/apache2/mods-enabled/mpm_*.conf' \
 'ln -s /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load' \
 'ln -s /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf' \
 'echo "MPMs enabled:"; ls /etc/apache2/mods-enabled | grep mpm' \
 'exec docker-entrypoint.sh apache2-foreground' \
 > /usr/local/bin/start.sh && chmod +x /usr/local/bin/start.sh

ENTRYPOINT ["/usr/local/bin/start.sh"]
