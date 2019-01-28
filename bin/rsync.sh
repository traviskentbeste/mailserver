#!/bin/sh

# some cleanup
rm -fr ./data/cache/*
rm -fr ./data/DoctrineORMModule/Proxy

# copys and syncs
rsync -av --delete ./module/* travis@www.walletsquire.com:/var/www/domains/www.walletsquire.com/module
