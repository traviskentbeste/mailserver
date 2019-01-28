#!/bin/sh
#
# Travis Kent Beste
# Fri Oct 26 21:55:20 CDT 2018

composer require tencorners/zend-generator
composer require doctrine/doctrine-orm-module 1.1.8
composer require doctrine/migrations 1.8.1
composer require zendframework/zend-authentication
composer require zendframework/zend-math
composer require zendframework/zend-crypt
composer require zendframework/zend-captcha
composer update zendframework/zend-validator
composer require zendframework/zend-mail
composer require zendframework/zend-serializer
composer require zendframework/zend-permissions-rbac

