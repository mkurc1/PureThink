clean:
	php app/console assets:install
	php app/console cache:clear --env=prod
	php app/console cache:clear

cleans: clean
	php app/console assets:install --symlink

assetic:
	php app/console assets:install web
	php app/console assetic:dump -e=prod

assetic_dev:
	php app/console assetic:dump

assetic_watch:
	php app/console assetic:dump --watch

install: composer_install do_install create_db update_db cleans

composer_install:
	php composer.phar install -o

composer_update:
	php composer.phar update

do_install:
	mkdir -p app/cache app/logs app/config web/uploads web/js web/css web/template
	setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs app/config web/uploads web/js web/css web/template
	setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs app/config web/uploads web/js web/css web/template

update: composer_update do_install rebuild_db assetic clean

rebuild_db: remove_db create_db update_db

create_db:
	php app/console doctrine:database:create

update_db:
	php app/console doctrine:schema:update --force
	php app/console khepin:yamlfixtures:load

remove_db:
	php app/console doctrine:database:drop --force

upgrade: update
	php composer.phar update