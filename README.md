# IPPI

PHP Web based tool to track your IP space

Site:
https://github.com/alasdairkeyes/ippi


Author
- Alasdair Keyes - https://akeyes.co.uk/


Installation
This assumes some knowledge of Laravel/Composer setup

- Extract IPPI files from tarball or git clone the repository from Github
- Download and install composer https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx
- Run composer update in the IPPI root folder (Takes a few minutes) `composer.phar update`
- Create Mysql database and user
```
mysql> CREATE DATABASE ippi;
mysql> GRANT ALL ON ippi.* TO 'ippi'@'localhost' INDENTIFIED BY 'password'; 
```
- Copy the .env.example file to .env `cp .env.example .env`
- Update .env file and set the following values
- Set APP_KEY to random 32 character string
- Set DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
- Change any other values you like, but they are not required
- In Apache/NGINX set your site's web site document root to `/path/to/ippi/public`
- If using apache, ensure that mod rewrites are enabled and .htaccess files can perform rewrites
- If using NGINX, your best bet is to setup PHP-FPM

Notes
- None at present


License
- GPL v3 - See included license file


Dependencies
- PHP 5.5.9
- Laravel
- Composer
- GMP extension (www.php.net/manual/en/book.gmp.php)


Thanks
- IP Manipulation library - https://github.com/rlanvin/php-ip
- Laravel Framework - https://laravel.com/

