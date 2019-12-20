### PREREQUISITES

Site's code was hosted on GitHub, so you should ***consider all the data compromised***, since GitHub is constantly being
searched by bots to collect logins, passwords and other sensitive data.

It is assumed that you're using .deb-based LAMP server to host your site, and that you've SSH access to it with SUDO-capabale user
account. If, for example, you're using NGINX instead of (or as a frontend for) Apache, or Postgres instead of Mysql,
 or working through web interface like phpMyAdmin and cPanel, you've to read the instruction and to adapt it to
fit your server or virtual hosting.

You need to have:

- Apache mod_rewrite and mod_expires enabled. If they're not enabled yet, do it like this:
```shell script
  sudo a2enmod rewrite
  sudo a2enmod expires
```

- PHP, ideally v.7.3 or higher, and some PHP packages, including pdo_mysql, php7.3-mbstring and php7.3-xml. You can
check, if your PHP installation meets requerements by executing this command, after you'd clone code from GitHub:
```shell script
  cd /var/www/YOURSITE.COM/
  php7.3 requirements.php
```
If there are errors due to missing PHP packages, you can add them like this:
```shell script
  sudo apt-get install php7.3-mbstring php7.3-xml
  sudo service apache2 restart
```

- OPTIONAL, but highly recommended - Certbot ACME client to get and renew free SSL certificates, installable like this:
```shell script
  sudo apt-get install python-letsencrypt-apache
```

# DEPLOYMENT

- Clone site's files from GitHub. Replace YOURSITE.COM with a folder name you're going to place files at:
```shell script
  cd /var/www/
  git clone --recursive https://github.com/renatus/futureAgencyTest.git YOURSITE.COM
```

- Install all the dependencies
```shell script
  cd /var/www/YOURSITE.COM/
  composer install
```

- Set file ownership and permissions. Replace YOUR_LINUX_USERNAME with actual Linux username;
if you're not sure, use `echo "$USER"` command to find it out.
```shell script
  cd /var/www/YOURSITE.COM/

  sudo chown -vR YOUR_LINUX_USERNAME:www-data 'runtime'
  sudo chown -vR YOUR_LINUX_USERNAME:www-data 'web'
  sudo chown -v YOUR_LINUX_USERNAME:www-data 'yii'

  sudo chmod -vR 0775 'runtime'
  sudo chmod -vR 0770 'web/assets'
  sudo chmod -vR 0755 'yii'
```

- Create MySQL database and user, give necessary permissions. Please, replace sample DB name, username and password with
 something else.

```mysql
  create database YOUR_DB_NAME;
  GRANT ALL ON YOUR_DB_NAME.* TO 'YOUR_DB_UNAME'@localhost IDENTIFIED BY 'YOUR_DB_PASSWORD';
  mysql -uYOUR_DB_UNAME -p YOUR_DB_NAME < 2019_12_09-future_dbbackup.sql
```

After that, delete database backup file, even though it should not be web-accessible in it's current place:
```shell script
rm /var/www/YOURSITE.COM/2019_12_20-future_dbbackup.sql
```

- OPTIONAL - If you'd ever like to delete all the comments and have a fresh start, log in to MYSQL and:
```mysql
  USE YOUR_DB_NAME;
  DROP TABLE IF EXISTS `comments`;
  CREATE TABLE `comments` (
    `comment_id` int(11) NOT NULL AUTO_INCREMENT,
    `time_created` datetime DEFAULT CURRENT_TIMESTAMP,
    `user_name` varchar(1000) NOT NULL,
    `comment_text` text NOT NULL,
    PRIMARY KEY (`comment_id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores siteuser-entered comments.';
```

- Create MySQL database to run tests
```mysql
  create database YOUR_TEST_DB_NAME;
  GRANT ALL ON YOUR_TEST_DB_NAME.* TO 'YOUR_DB_UNAME'@localhost IDENTIFIED BY 'YOUR_DB_PASSWORD';
```
 
- At `config/db.php` replace database credentials to match those you've set for YOUR_DB_NAME.

- At `config/test_db.php` replace database credentials to match those you've set for YOUR_TEST_DB_NAME.

- If you're going to send e-mails from your site (for now it has no such functionality), at `config/params.php` set correct e-mail addresses and mailer.

- At `config/web.php` replace 'cookieValidationKey' value.

- At `web/.htaccess` file replace domain name in
```apacheconfig
  RewriteRule ^index\.php$ http://future.renat.biz/ [R=301,L]
```
with your own domain name.

- At `/etc/apache2/sites-available` folder create `YOURSITE.COM.conf` file:
```apacheconfig
  <VirtualHost *:80>
        # The ServerName directive sets the request scheme, hostname and port that
        # the server uses to identify itself. This is used when creating
        # redirection URLs. In the context of virtual hosts, the ServerName
        # specifies what hostname must appear in the request's Host: header to
        # match this virtual host. For the default virtual host this
        # value is not decisive as it is used as a last resort host regardless.
        # However, you must set it for any further virtual host explicitly.
        ServerName YOURSITE.COM
        ServerAlias www.YOURSITE.COM

        ServerAdmin YOUR_EMAIL@YOURSITE.COM
        DocumentRoot /var/www/YOURSITE.COM/web/

        # Available loglevels: trace8, ..., trace1, debug, info, notice, warn,
        # error, crit, alert, emerg.
        # It is also possible to configure the loglevel for particular
        # modules, e.g.
        #LogLevel info ssl:warn

        ErrorLog /var/www/logs/YOURSITE.COM-error.log

        CustomLog /var/www/logs/YOURSITE.COM-access.log combined

        <Directory /var/www/YOURSITE.COM/web/>
            Options Indexes FollowSymLinks
            AllowOverride All
            Require all granted
        </Directory>
  </VirtualHost>

  # vim: syntax=apache ts=4 sw=4 sts=4 sr noet
```
Please, don't forget to replace *all* the URLs and e-mails with your own. We should not
make `/var/www/YOURSITE.COM/` folder web-accessible, it should be it's `web` subfolder.

- Enable your new domain:
```shell script
  sudo a2ensite YOURSITE.COM
  sudo service apache2 reload
```
Now your site is web-accessible!

- OPTIONAL, but highly recommended - install free SSL certificate for your domain:
```shell script
  sudo service apache2 stop
  sudo /usr/bin/letsencrypt --authenticator standalone --installer apache -d YOURSITE.COM -d www.YOURSITE.COM
  sudo service apache2 start
```
You have to renew this certificate on a regular basis, either manually, with the very same set of commands, or
automatically. However, there may be some problems, when you're trying to do it with cron task runner, so you've to test
everything thoroughly; otherwise your site will become practically inaccessible for most users soon enough.

If you'd prefer to omit this step and don't install SSL certificate, comment out those lines at `web/.htaccess` file:
```apacheconfig
  # Force SSL - it's NOT recommended way to do this, better to work with Apache .conf file.
  RewriteCond %{SERVER_PORT} ^80$
  # Simple redirect will kill POST request
  RewriteCond %{REQUEST_METHOD} !POST
  RewriteRule ^(.*)$ https://%{SERVER_NAME}%{REQUEST_URI} [L,R]
```

### TESTING

- Run functional tests to check, if site works fine; as well as pre-defined unit tests for user-related code.
```shell script
  cd /var/www/YOURSITE.COM/
  vendor/bin/codecept run
```

- Test REST API
  
  GET list of last 10 site visitor-entered comments:
  ```shell script
  curl -i -H "Accept: application/json; q=1.0, */*; q=0.1" "https://YOURSITE.COM/commentrest"
  ```
  
  CREATE site visitor-entered comment:
  ```shell script
  curl -i -H "Accept:application/json" -H "Content-Type:application/json" -XPOST "https://YOURSITE.COM/commentrest/create" -d '{"user_name": "rest_user", "comment_text": "Lorem Ipsum"}'
  ```
  
  TEST - we should ***NOT*** be able to fill "comment_id" and "time_created" fields of comment:
  ```shell script
  curl -i -H "Accept:application/json" -H "Content-Type:application/json" -XPOST "https://YOURSITE.COM/commentrest/create" -d '{"user_name": "rest_user", "comment_text": "Lorem Ipsum", "comment_id": "999", "time_created": "2019-01-01 14:49:28"}'
  ```
  Expected result - comment should be created, but it's ID and creation time will be set by MySQL server, not by our
  request.