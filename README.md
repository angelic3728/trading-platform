# Trading Platform
This repository contains the code for the whitelabel trading platform. 

The platform is build with the following technologies:
* Laravel (PHP Framework)
* Bootstrap (CSS / Sass Framework)
* Viho Theme (jQuery & Bootstrap Theme)
* Laravel Nova (Admin Panel - Customized)

Next to these technologies, we also implement the following API's and services
* IEX (Real-Time stock information)
* Bugsnag (Error Management)


## Installation

### Step 1
Copy `.env.example` to `.env` and update the values based on your settings

### Step 2
Install composer
```
composer install
```

### Step 3
Configure database. First you need to create the tables
```
php artisan migrate
```
### Step 4
Import the IEX data
```
php artisan iex:import-data
```

Then import the ASX data
```
php artisan asx:import-data
```

php artisan db:seed

sudo apt install redis-server
in sudo nano /etc/redis/redis.conf
...............
supervised systemd
...............

### Step 5
Setup your first manager account by inserting a row in the users table. You can leave the password empty.
After the row is saved, run the following command to generate a password
```
php artisan user:set-password
```



### Step 6
Set the first highlighted stocks and widget stocks. At least 1 stocks should be highlighted and enabled for the widget to load the platform.

You can set these by setting the `highlighted` or `widget` columns in the `stocks` table to `1`. You can have up to 4 stocks, funds and cryptos as highlighted.

After changing these values, run `php artisan cache:clear` to clear the cache

### Step 7
Link storage
```
php artisan storage:link
```

### Step 8
php artisan key:generate

## Admin Panel
The admin panel is built on Laravel Nova and is accessible via the `/admin` route.

#### Important: Do not update Laravel nova or the `/nova` folder!
This version of Laravel Nova is customized to auto-fill the transaction fields based on the url. When updating Laravel Nova, this will be removed.
