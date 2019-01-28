#!/bin/sh

rm ./www/CONDUCT.md
rm ./www/CONTRIBUTING.md
rm ./www/docker-compose.yml
rm ./www/Dockerfile
rm ./www/LICENSE.md
mv ./www/phpunit.xml.dist ./www/phpunit.xml
rm ./www/README.md
rm ./www/TODO.md
rm ./www/Vagrantfile

mv ./www/* .
mv ./www/.gitignore ./gitignore
rm -fr ./www
