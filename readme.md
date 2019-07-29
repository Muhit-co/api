# Muhit API

### Build Status
#### Master: 
[![Build Status](https://travis-ci.org/Muhit-co/api.svg?branch=master)](https://travis-ci.org/Muhit-co/api)

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
