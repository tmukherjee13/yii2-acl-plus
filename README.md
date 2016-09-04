ACL exended for Yii v2
======================
Control access level of users using rbac

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist tmukherjee13/yii2-acl-plus "*"
```

or add

```
"tmukherjee13/yii2-acl-plus": "*"
```

to the require section of your `composer.json` file.


Usage
-----
Work in progress.


Menu (Optional)
---------------

If you want to use the menu module provided with the extension, you need to create the necessary tables by executing :

```php
./yii migrate --migrationPath=@tmukherjee13/aclplus/migrations
```
