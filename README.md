# Creating Basic PHP website for Practicing LAMP stack
> Public Site folder: tutorial
> Admin Site fodler: adminsite
> creating database using script: db_tables.sql
-------

## Setting Up the LAMP stack for PHP development
OS - CentOS/RedHat
```
>>> yum install httpd httpd-manual -y
>>> chkconfig httpd on
>>> cd /etc/httpd/conf
>>> vim httpd.conf
# add the following code
     <VirtualHost *:80>
        ServerName mitutorial.example.com
        DocumentRoot /var/www/html/tutorial
        CustomLog /var/log/httpd/access_log_tutorial common
      </VirtualHost>

>>> vim /etc/hosts
# add the following code
 127.0.0.1 mitutorial.example.com
Note: In real world this name is resolve via DNS server 

>>> mkdir /var/www/html/tutorial
>>> mkdir /var/www/html/tutorial/images
# https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRXX_TCsiRmrsxl748MihkbHErklg4Z8mfBAT-kXPLlwPyKnMJvinNtsxjMy46_Eqp2aNs&usqp=CAU
# download this image in that folder
>>> touch /var/www/html/tutorial/index.html
<html>
    <head>
        <title>Tutorial Home Page</title>
    </head>
    <body>
        <img src="images/tutorial.jpg" width="600" height="300" alt="Tutorial">
        <hr>
        <h3>Welcome to MI Tutorial!</h3>
        <a href="tutorialsearch.html">Search Tutorials</a>
    </body>
</html>

>>> Search on browser http://mitutorial.example.com

>>> yum install mysql-server mysql
>>> systemctl status mysqld
>>> systemctl enable mysql --now

>>> mysql_secure_installation
# prompt for settings and enter root password for db

>>> mysql -u root -p
    >>> select now(), user(), version();
    >>> quit;

>>> yum install php -y
>>> vim /etc/php.ini
    # search for display_errors if of turn on but dont do in production server.
    display_errors = On
>>> systemctl restart httpd
>>> cd /var/www/html/tutorial
>>> mv index.html index.php
    # See index.php
```
----------------

## Accessing Form Data with PHP
```
>>> ls -l
>>> chgrp -R username /var/www/html/tutorial
>>> chmod g+w /var/www/html/tutorial
>>> chmod g+s /var/www/html/tutorial
>>> ls -l
```
> See contactus.html

**Passing Data to the Server**
- Using GET 
- Using POST
- Using Cookie

> See contactus.php

Pass the data to html page and see its working.
```
>>> mail      // to see the mail recieved from server
```
**Validating the user data**
> See contactus2.php
-----------------
## Creating Database schema

> See db_tables.sql

**Query Database**
- select title, author from tutorials where author like "%Izhar%";
- select title, author from tutorials where title like "%Linux%";

-----
## Connecting to database Using PHP

> See db_test.php

*Note: in choose-color.php change the urlnamea as per your configuration to set cookie*

## Adminfolder httpd config
```
>>> vim /etc/httpd/conf/httpd.conf

<VirtualHost *:80>
    ServerName admin.mitutorial.example.com
    DocumentRoot /var/www/html/adminpages
    CustomLog /var/log/httpd/access_log_tutorial common
</VirtualHost>

<Directory /var/www/html/adminpages>
    Order Deny, Allow
    Deny from all
    Allow from 192.168.23
    Allow from 127.0.0.1
</Directory>
```