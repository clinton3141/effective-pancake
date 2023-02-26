Running the project:

1. `composer install`
2. `npm install`
3. `npm run build`
4. `./vendor/bin/sail up -d`
5. `./vendor/bin/sail artisan migrate`
6. Visit http://localhost/ for the app. http://localhost:8080/ for phpmyadmin (server `mariadb`, username `sail`, password: `password`)
7. Tests can be run with `./vendor/bin/sail artisan test`
