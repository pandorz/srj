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

## Node

```sh
npm install
```


## Bower

```sh
npm install -g bower
bower install ./vendor/sonata-project/admin-bundle/bower.json
```

You have to set a value for mailer_user and mailer_password

## Node

```sh
npm install -g gulp
```

## Create database tables

```sh
bin/console doctrine:database:create
bin/console doctrine:migrations:migrate
```

## Required data

### Headings list
```sh
bin/console doctrine:fixtures:load
```

### Create a root user
```sh
bin/console fos:user:create --super-admin
bin/console sonata:admin:setup-acl
bin/console sonata:admin:generate-object-acl
```

## Prepare your environement

```sh
bin/console cache:clear
bin/console assets:install
gulp
```
-----

# Launch your application





