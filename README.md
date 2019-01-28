# mailserver
Helps to keep track of users on a postfix and dovecot mailserver for centos7

# docs
Docs folder contains configurations for dovecot and postfix

# install
1. ./bin/initializeMysql.sh <dbname> <user> <password>
2. Then, run the doctirne migration script to setup the database tables:
3. ./vendor/bin/doctrine-module -n migrations:migrate next