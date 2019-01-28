#!/bin/sh
#
# Written by Travis Kent Beste
# Mon Oct 15 11:47:00 CDT 2018

database=$1
username=$2
password=$3

if [ -z ${database} ]; then
	echo "usage :"
	echo "./mysql.sh database username password"
	exit
fi

if [ -z ${username} ]; then
	echo "usage :"
	echo "./mysql.sh database username password"
	exit
fi

if [ -z ${password} ]; then
	echo "usage :"
	echo "./mysql.sh database username password"
	exit
fi

echo "database : $database"
echo "username : $username"
echo "password : $password"

# close stdout
#exec 1<&-

# close stderr
exec 2<&-

if [ -z `mysql -u root -pvagrant -e "show databases" | grep ${database}` ]; then
	mysqladmin -u root -pvagrant create ${database}
fi

mysql -u root -pvagrant mysql -e "CREATE USER '${username}'@'%' IDENTIFIED BY '${password}';"
mysql -u root -pvagrant mysql -e "GRANT ALL PRIVILEGES ON *.* TO '${username}'@'%' WITH GRANT OPTION;"
mysql -u root -pvagrant mysql -e "FLUSH PRIVILEGES;"
