#!/usr/bin/env bash

# Setup profiling if environment variable is set
if [ -n "$PROFILER_ENABLE" ]
then
  echo 'auto_prepend_file="/var/www/html/setup/profiler.php"' >> /usr/local/etc/php/php.ini
  echo "To start profiling, set a Cookie named 'profile' on the Beacon endpoint."
fi

composer --optimize-autoloader install
/usr/local/bin/apache2-foreground
