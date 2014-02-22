clean:
	php app/console assets:install
	php app/console cache:clear --env=prod
	php app/console cache:clear

assetic:
	php app/console assets:install web
	php app/console assetic:dump -e=prod

install: composer_install do_install create_db update_db clean

composer_install:
	php composer.phar install -o

composer_update:
	php composer.phar update

do_install:
	mkdir -p app/cache app/logs app/config web/uploads web/js web/css
	setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs app/config web/uploads web/js web/css
	setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs app/config web/uploads web/js web/css

update: composer_update do_install rebuild_db assetic clean

rebuild_db: remove_db create_db update_db

create_db:
	php app/console doctrine:database:create

update_db:
	php app/console doctrine:schema:update --force
	php app/console doctrine:fixtures:load --append

remove_db:
	php app/console doctrine:database:drop --force

upgrade: update
	php composer.phar update