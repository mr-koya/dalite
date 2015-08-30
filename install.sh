#!/bin/bash
cd "$(dirname "$0")"
php -r "eval('?>'.file_get_contents('https://getcomposer.org/installer'));"
php composer.phar install --no-dev
