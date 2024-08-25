docker-compose up -d
docker exec -it php sh


symfony
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate

php bin/console cache:clear
