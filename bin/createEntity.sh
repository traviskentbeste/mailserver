#!/bin/bash
#
# Written by Travis Kent Beste
# Sat Oct 21 15:53:15 CDT 2017

# original
#./vendor/doctrine/doctrine-module/bin/doctrine-module orm:convert-mapping --namespace="Album\\Entity\\" --force  --from-database annotation ./module/Album/src/
#./vendor/doctrine/doctrine-module/bin/doctrine-module orm:generate-entities ./module/Album/src/ --generate-annotations=true

HELP=0
VERBOSE=0
REMOVE_GENERATEDVALUE=0
DEBUG=0
MODULE=
TABLE=

#----------------------------------------#
# usage
#----------------------------------------#
usage() {
	echo "Usage : $0";
	echo " "
	echo "	** please note, you need to use an equals sign to set the variable **"
	echo " "
	echo "	--module=MODULE_NAME : (required) module name"
	echo "	--table=TABLE_NAME   : (required) table name -> IN CAMEL CASE!"
	echo "	--verbose            : verbose output"
	echo "	--debug              : debug output"
	echo "	--help               : this help"
	exit 1;
}

#----------------------------------------#
# command line arguments
#----------------------------------------#
for i in "$@"
	do
	case $i in
		-m=*|--module=*)
		MODULE="${i#*=}"
		shift # past argument=value
	;;
		-t=*|--table=*)
		TABLE="${i#*=}"
		shift # past argument=value
	;;
		-v|--debug)
		DEBUG=1;
		shift # past argument=value
	;;
		-v|--verbose)
		VERBOSE=1;
		shift # past argument=value
	;;
		-h|--help)
		HELP=1;
		shift # past argument=value
	;;
		--default)
		DEFAULT=YES
		shift # past argument with no value
	;;
	*)
		# unknown option
	;;
	esac
done

if [ $HELP == 1 ]; then
	usage
fi
if [ -z "$MODULE" ]; then
	usage
fi
if [ -z "$TABLE" ]; then
	usage
fi

#todo : camel case!
# move to uppercase
#MODULE=$(echo "$MODULE" | tr '[:upper:]' '[:lower:]')
#TABLE=$(echo "$TABLE" | tr '[:upper:]' '[:lower:]')

# uppercase the first character
#MODULE=${MODULE^}
#TABLE=${TABLE^}

#----------------------------------------#
# main
#----------------------------------------#
# create the directory
directory=./module/$MODULE/src/Entity

if [ ! -e ${directory} ]; then
	mkdir -p ${directory}
fi

if [ $DEBUG == 1 ]; then
	echo "input variables..."
	echo "	directory = ${directory}"
	echo "	DEBUG     = ${DEBUG}"
	echo "	VERBOSE   = ${VERBOSE}"
	echo "	HELP      = ${HELP}"
	echo "	MODULE    = ${MODULE}"
	echo "	TABLE     = ${TABLE}"
fi

# pre cleanup
if [ -f $directory/${TABLE}.php ]; then
	if [ $DEBUG == 1 ]; then
		echo "rm $directory/${TABLE}.php"
	fi
	rm $directory/${TABLE}.php
else
	if [ $DEBUG == 1 ]; then
		echo "no directory $directory/${TABLE}.php"
	fi
fi

#----------------------------------------#
#
#----------------------------------------#
if [ $VERBOSE == 1 ]; then
	echo "1. creating annotation files..."
fi
if [ $DEBUG == 1 ]; then
	echo "./vendor/bin/doctrine orm:convert-mapping -q --filter='\\\\${TABLE}$' --namespace='${TABLE}\\Entity\\' --force --from-database annotation $directory"
fi
# this filter looks a bit weird, but the full path would be Product\\Entity\\{$TABLE}
./vendor/bin/doctrine orm:convert-mapping -q --filter="\\\\${TABLE}$" --namespace="${TABLE}\\Entity\\" --force --from-database annotation $directory

#----------------------------------------#
#
#----------------------------------------#
if [ $VERBOSE == 1 ]; then
	echo "2. creating entities..."
fi
if [ $DEBUG == 1 ]; then
	echo "./vendor/bin/doctrine orm:generate-entities --filter='\\\\${TABLE}$' --no-backup --no-interaction --generate-annotations=true $directory"
fi
./vendor/bin/doctrine orm:generate-entities -q --filter="\\\\${TABLE}$" --no-backup --no-interaction --generate-annotations=true $directory

#----------------------------------------#
#
#----------------------------------------#
if [ $VERBOSE == 1 ]; then
	echo "3. moving files to our entity directory..."
fi
if [ $DEBUG == 1 ]; then
	echo "mv $directory/${TABLE}/Entity/* $directory"
fi
mv $directory/${TABLE}/Entity/* $directory

#----------------------------------------#
#
#----------------------------------------#
if [ $VERBOSE == 1 ]; then
	echo "4. cleanup..."
fi
if [ $DEBUG == 1 ]; then
	echo "rm -fr $directory/${TABLE}/"
fi
rm -fr $directory/${TABLE}/

#----------------------------------------#
#
#----------------------------------------#
if [ $REMOVE_GENERATEDVALUE == 1 ]; then
	if [ $VERBOSE == 1 ]; then
		echo "5. remove generated value from file..."
	fi
	if [ $DEBUG == 1 ]; then
		echo "sed -i '/ORM\\GeneratedValue/ d' $directory/${TABLE}.php "
	fi
	sed -i '/ORM\\GeneratedValue/ d' $directory/${TABLE}.php 
fi

#----------------------------------------#
#
#----------------------------------------#
if [ $VERBOSE == 1 ]; then
	echo "6. add setId to file..."
fi
if [ $DEBUG == 1 ]; then
	echo "./bin/addId.pl $directory ${TABLE} > ./tmp.php"
	echo "mv ./tmp.php $directory/${TABLE}.php"
fi
./bin/addId.pl $directory ${TABLE} > ./tmp.php
mv ./tmp.php $directory/${TABLE}.php

#----------------------------------------#
#
#----------------------------------------#
if [ $VERBOSE == 1 ]; then
	echo "6. redo namespace..."
fi
if [ $DEBUG == 1 ]; then
	echo 'sed -i "s/namespace ${TABLE}\\\\Entity;/namespace ${MODULE}\\\\Entity;/" $directory/${TABLE}.php'
fi
sed -i "s/namespace ${TABLE}\\\\Entity;/namespace ${MODULE}\\\\Entity;/" $directory/${TABLE}.php


#----------------------------------------#
#
#----------------------------------------#
if [ $VERBOSE == 1 ]; then
	echo "7. redo namespace paths..."
fi
if [ $DEBUG == 1 ]; then
	echo "sed -i \"s/\\\\${TABLE}\\\\Entity/\\\\${MODULE}\\\\Entity/\" $directory/${TABLE}.php"
fi
sed -i "s/${TABLE}\\\\Entity/${MODULE}\\\\Entity/" $directory/${TABLE}.php

