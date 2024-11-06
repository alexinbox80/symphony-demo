docker-compose up -d
docker exec -it php sh


#symfony
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate

#drop all tables in database
php bin/console doctrine:schema:drop --full-database --force

#seeder
php bin/console doctrine:fixtures:load

php bin/console cache:clear
