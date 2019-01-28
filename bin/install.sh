#!/usr/bin/expect --
#
# Written by Travis Kent Beste
# Wed Feb 14 09:41:06 CST 2018

set timeout 500

spawn composer create-project -sdev zendframework/skeleton-application www

#Do you want a minimal install (no optional packages)? Y/n
expect "Y/n" { send "n\n" }

#Would you like to install the developer toolbar? y/N
expect "y/N" { send "n\n"}

#Would you like to install caching support? y/N
expect "y/N" { send "y\n"}

#Would you like to install database support (installs zend-db)? y/N
expect "y/N" { send "y\n"}

#Would you like to install forms support? y/N
expect "y/N" { send "y\n"}

#Will install zendframework/zend-mvc-form (^1.0)
#When prompted to install as a module, select application.config.php or modules.config.php
#Would you like to install JSON de/serialization support? y/N
expect "y/N" { send "y\n"}

#Would you like to install logging support? y/N
expect "y/N" { send "y\n"}

#Would you like to install MVC-based console support? (We recommend migrating to zf-console, symfony/console, or Aura.CLI) y/N
expect "y/N" { send "y\n"}

#Would you like to install i18n support? y/N
expect "y/N" { send "y\n"}

#Would you like to install the official MVC plugins, including PRG support, identity, and flash messages? y/N
expect "y/N" { send "y\n"}

#Will install zendframework/zend-mvc-plugins (^1.0.1)
#When prompted to install as a module, select application.config.php or modules.config.php
#Would you like to use the PSR-7 middleware dispatcher? y/N
expect "y/N" { send "n\n"}

#Would you like to install sessions support? y/N
expect "y/N" { send "y\n"}

#Will install zendframework/zend-session (^2.7.1)
#When prompted to install as a module, select application.config.php or modules.config.php
#Would you like to install MVC testing support? y/N
expect "y/N" { send "y\n"}

#Will install zendframework/zend-test (^3.0.1)
#Would you like to install the zend-di integration for zend-servicemanager? y/N
expect "y/N" { send "y\n"}

#Please select which config file you wish to inject 'Zend\Cache' into:
#[0] Do not inject
#[1] config/modules.config.php
#[2] config/development.config.php.dist
#Make your selection (default is 0):1
expect "):" { send "1\n"}

#Remember this option for other packages of the same type? (y/N) y
expect "y/N" { send "y\n" }

#Do you want to remove the existing VCS (.git, .svn..) history? [Y,n]? y
expect "\[Y\,n\]\?" { send "y\n" }

expect "development mode." { send "\n" }

close
