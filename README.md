# Swaggie
Simpele API met Swagger-like interface

## Backend
* PHP
* Geen classes (alleen PDO gebruikt)
* Functies

## Frontend
* Vanilla Javascript
* fetch() gebruikt voor communicatie met backend
* JSON (not REST-compliant, maar voor uitleg)

## Servers
* Run a PHP built-in server:
    * php -S localhost:8777
    * eventueel met config voor debugging (php -c /usr/local/etc/php/8.3/php.ini -S localhost:8777)
    * URL van api => routes.js
* API Server (api.php)
    * http://localhost:8777/api/v1/api.php?....
* Frontend (index.html)
    * Inloggen met Admin/Sysop

## Frontend Files
* index.html
* CSS
    * swaggie.css
        * plain css
    * prism.css
        * voor weergave JSON code in browser
* Javascript
    * request.js
        * fetch() promise en helper-functies
    * prism.js
        * weergave JSON code in browser
    * routes.js
        * frontend routes en datacollection

## Database
* autoverhuur.sql

## Links
* [Medium artikel](https://adityan150.medium.com/3-ways-to-fetch-data-from-an-api-endpoint-in-javascript-638fc4ec0ad6)
