#!/bin/sh
#
# Written by Travis Kent Beste
# Fri Oct 26 15:43:45 CDT 2018

# clear out the cache
rm -f ./data/cache/*

object=$1

if [ -z ${object} ]; then
	echo "migrate.sh <object-manager> <action|next/prev>"
	exit;
fi

if [ ${object} == '--help' ]; then
	echo "migrate.sh <object-manager> <action|next/prev>"
	exit;
fi

# get some output
echo "./vendor/bin/doctrine-module \
--object-manager=doctrine.entitymanager.${object}" \
migrations:migrate
echo " "

./vendor/bin/doctrine-module \
--object-manager=doctrine.entitymanager.${object} \
migrations:migrate

