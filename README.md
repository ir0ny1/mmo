#My Market Ottawa
##A Laravel 4, Nginx, MySql, Memcached labour of Love
###Php5 Modules Needed
* php5-mcrypt
* php5-gd
* php5-mysql
* php5-memcached

###Daemons Needed
* memcached

###Initial steps
* Setup A Database
* Copy sample.env.php to .env.local.php
* Setup .env.local.php with seeding / database / email information
* Run composer install
* Run ./artisan migrate::install
* Run ./artisan migrate 
* Run ./artisan db::seed

###Tested With
* Php 5
* HHVM
* Apache2
* Nginx
* MySql

###Loggin in for the first time
The database seeding will create a login for you based on the environment variables.
Simply login with the email and password you specified

###Notes
* Currently there is no way to mock the sending of confirmation emails, the application must be configured with valid SMTP credentials

*Email Dave@Develops.io with any questions*
