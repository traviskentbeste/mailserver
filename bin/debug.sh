#!/bin/sh
env PHP_IDE_CONFIG="serverName=vagrant" XDEBUG_CONFIG="idekey=PHPSTORM" $@

# for Symfony apps use following
# env PHP_IDE_CONFIG="serverName=vagrant" XDEBUG_CONFIG="idekey=PHPSTORM" SYMFONY_DEBUG="1" $@
