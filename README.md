Rouen Japon
=========

# Install project

> - PHP :7.0

```sh
git clone
```
## Composer

```sh
composer install
```

## Bower

```sh
bower install ./vendor/sonata-project/admin-bundle/bower.json
```

You have to set a value for mailer_user and mailer_password

## Create database tables

```sh
bin/console doctrine:migrations:migrate
```

## Create a root user

```sh
bin/console fos:user:create --super-admin
```

## Prepare your environement

```sh
bin/console cache:clear
bin/console assets:install
```
-----

# Launch your application





