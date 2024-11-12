docker-compose up -d
docker exec -it php sh

#make new entity
php bin/console make:entity


#create migrations
php bin/console doctrine:migrations:diff

#migrate migrations
php bin/console doctrine:migrations:migrate
#execute specific migration
php bin/console doctrine:migrations:execute --up 'DoctrineMigrations\\Version20241112095658'


#drop all tables in database
php bin/console doctrine:schema:drop --full-database --force

#seed database schema
php bin/console doctrine:fixtures:load

php bin/console cache:clear

composer require symfony/maker-bundle --dev

composer diagnose

composer config -g repo.packagist composer https://packagist.org
composer require zenstruck/foundry --dev
composer require symfony/password-hasher
#make factory
php bin/console make:factory

#route lists
php bin/console debug:router

# make SQL request from console
php bin/console dbal:run-sql 'SELECT * FROM users'

#symfony install
composer create-project symfony/skeleton symfony-demo

composer require --dev doctrine/doctrine-fixtures-bundle

composer require doctrine/doctrine-bundle doctrine/orm
composer require doctrine/doctrine-migrations-bundle
composer require jms/serializer-bundle
composer require sensio/framework-extra-bundle
composer require frendsofsymfony/rest-bundle
composer require friendsofsymfony/rest-bundle
composer require symfony/validator
composer require symfony/serializer
