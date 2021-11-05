# Create the .env file if it does not exist.
echo "---Created .env file from .env.example into src directory---"
if [[ ! -f "./src/.env" ]] && [[ -f "./src/.env.example" ]];
then
cp ./src/.env.example ./src/.env
fi

set -e [ -f "./src/.env" ]
export $(cat ./src/.env | grep -v ^# | xargs);

echo "---Starting services using docker-compose---"
docker-compose up -d 
# docker-compose up -d --build --remove-orphans --force-recreate

echo "---Installing dependencies---"
docker-compose exec app composer update --working-dir=/var/www
docker-compose exec app composer install --ignore-platform-reqs --working-dir=/var/www

echo "---Generating key---"
docker-compose exec app php artisan config:clear && key:generate && echo New key updated

# echo Host: 127.0.0.1
# until docker-compose exec db mysql -h 127.0.0.1 -u $DB_USERNAME -p$DB_PASSWORD -D $DB_DATABASE --silent -e "show databases;"
# do
#   echo "Waiting for database connection..."
#   sleep 5
# done

echo "---Seeding database---"
docker-compose exec app php artisan migrate --env=local && echo Database migrated
docker-compose exec app php artisan db:seed --env=local && echo Database seeded
