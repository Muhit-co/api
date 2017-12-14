# Muhit API

[ ![Codeship Status for Muhit-co/api](https://codeship.com/projects/dbffa660-e41a-0132-e4fa-16773c71d38d/status?branch=master)](https://codeship.com/projects/81787)

## Local Development 

Requires npm, homebrew, redis, mysql.


### Install dependencies:

```
composer install
npm install
```

Then make sure you have a local mysql database setup according to the configuration in `.env`


### Run server:

`npm run stack`

In case necessary, run `php artisan cache:clear`