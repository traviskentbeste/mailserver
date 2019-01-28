#!/bin/sh
#
# Written by Travis Kent Beste
# Wed Aug 12 15:53:17 CEST 2015

#--------------------#
# config
#--------------------#
MYSQL=/usr/bin/mysql
MYSQLADMIN=/usr/bin/mysqladmin

ROOT_USER=root
ROOT_PASSWORD=vagrant

DATABASE=postfix
USERNAME=postfix
PASSWORD=postfix

#--------------------#
# database
#--------------------#
#if [[ ! -z "`$MYSQL -u $ROOT_USER -p$ROOT_PASSWORD -qfsBe "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME='$DATABASE'" 2>&1`" ]];
#then
	#echo "$DATABASE EXISTS"
#else
	echo "$DATABASE DOES NOT EXIST, adding..."
	`$MYSQLADMIN -u $ROOT_USER -p$ROOT_PASSWORD create $DATABASE`
#fi

#--------------------#
# process mysql table queries
#--------------------#
echo "adding $USERNAME with password $PASSWORD to $DATABASE"
$MYSQL -u $ROOT_USER -p$ROOT_PASSWORD mysql -e "grant all on $DATABASE.* TO $USERNAME@localhost with grant option;"
$MYSQL -u $ROOT_USER -p$ROOT_PASSWORD mysql -e "update user set Password=password('$PASSWORD') where User='$USERNAME'"
$MYSQL -u $ROOT_USER -p$ROOT_PASSWORD mysql -e "update user set Super_priv='Y' where User='$USERNAME'"
$MYSQL -u $ROOT_USER -p$ROOT_PASSWORD mysql -e "flush privileges"
