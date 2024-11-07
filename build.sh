docker-compose up -d
docker exec -it php sh


#create migrations
php bin/console doctrine:migrations:diff
#migrate migrations
php bin/console doctrine:migrations:migrate

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