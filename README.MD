## To test app run this commands
1. `Clone this repository`
2. `Install docker in your machine`

### Open project folder in terminal and run 
```
docker-compose up -d
```

### In browser open
```
http://localhost:8741
```

# Some command to work with symfony manual

## Create symfony project 
```
composer create-project symfony/skeleton football-tournament-manager
```

## Start  server
```
wget https://get.symfony.com/cli/installer -O - | bash

symfony server:start
```
or
```
php bin/console server:run 0.0.0.0:8000
```

## Clear cache
```
php bin/console cache:clear
```

## Create some files
```
php bin/console make:entity Team
php bin/console make:controller DefaultController
php bin/console make:form TournamentType
```

## Migration
```
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```
or
```
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```






