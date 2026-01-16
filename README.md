# TinyMe V2

[![Latest Stable Version](https://poser.pugx.org/ycrao/tinyme/v/stable.svg?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)
[![Latest Unstable Version](https://poser.pugx.org/ycrao/tinyme/v/unstable.svg?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)
[![License](https://poser.pugx.org/ycrao/tinyme/license?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)
[![Total Downloads](https://poser.pugx.org/ycrao/tinyme/downloads?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)

>   A tiny PHP framework based on FlightPHP and Medoo.

[IntroductionPage](https://raoyc.com/tinyme/index.html) | [简体中文读我](README_zh-CN.md)

## Installation

Just like `Laravel` installation, set `public` directory as server root path in `vhost.conf` and using `composer` to install or update packages and so on. You can do these in your terminal like below:

```bash
# using git
git clone https://github.com/ycrao/tinyme.git tinyme
# or using composer, but skip `composer install` command below
composer create-project --prefer-dist ycrao/tinyme tinyme
cd tinyme
cp .env.example .env
vim .env
composer install
cd app
chmod -R 755 storage
php -S 127.0.0.1:9999 -t public
# or using composer
composer start
```
You can view this project page by typing `http://127.0.0.1:9999` url in your browser.

## API Service

Please import `sql\tinyme.sql` to your local MySQL database, then modify `.env` file configuration. 

### Route

| Method   | Route or URI    | Note                                    |
| :------- | :-------------- | :-------------------------------------- |
| `post`   | `/api/login`    | Get access-token by logining account.   |
| `get`    | `/api/pages`    | Get current user pages with pagination. |
| `post`   | `/api/page`     | Create a new page.                      |
| `get`    | `/api/page/@id` | Get page by specified id.               |
| `put`    | `/api/page/@id` | Update page by specified id.            |
| `delete` | `/api/page/@id` | Delete page by specified id.            |

### API error code

| Code               | Note                              |
| :----------------- | :-------------------------------- |
| 500                | fail or error.                    |
| 401 (Unauthorized) | access token already expired.     |
| 403 (Forbidden)    | illegal or incorrect credentials. |
| 404 (Not Found)    | api or route not existed.         |
| 200 (OK)           | success.                          |

### post `api/login`

>   Using email and password to login and get access token. Please recall login api when token is expired, do not call this api frequently when old token(s) not expired.

#### Request Example

```bash
curl --request POST \
  --url http://127.0.0.1:9999/api/login \
  --header 'Content-Type: application/json' \
  --data '{
  "email": "foo@example.com",
  "password": "123456"
}'
```

#### Response Example

Using `200` as `code` when success.

```json
{
  "code": 200,
  "msg": "ok",
  "data": {
    "uid": 1,
    "token": "hdtvEsu3FNEsyR069XNeTCzKSUFyWzAgSe7GcCjy",
    "expire_at": 1768590265
  }
}
```

Using non-2xx (`403` 、`500` etc.) digital when fail or error.

```json
{
  "code": 403,
  "msg": "illegal or incorrect credentials",
  "data": null
}
```

### get `api/pages`

>   Get current user pages with pagination.

#### Request Example

```
curl --request GET \
  --url http://127.0.0.1:9999/api/pages?page=1&per_page=2 \
  --header 'Authorization: Bearer hdtvEsu3FNEsyR069XNeTCzKSUFyWzAgSe7GcCjy'
```

#### Response Example

```json
{
  "code": 200,
  "msg": "ok",
  "data": {
    "total": 1,
    "per_page": 10,
    "current_page": 1,
    "next_page_url": null,
    "prev_page_url": null,
    "from": 1,
    "to": 1,
    "data": [
      {
        "id": 1,
        "content": "# Hello world\n\nThis is a demo page.",
        "created_at": "2017-11-09 13:54:39",
        "updated_at": "2017-11-09 13:54:39"
      }
    ]
  }
}
```

### post `api/page`

>   Create a new page.

#### Request Example

```bash
curl --request POST \
  --url http://127.0.0.1:9999/api/page \
  --header 'Authorization: Bearer hdtvEsu3FNEsyR069XNeTCzKSUFyWzAgSe7GcCjy' \
  --header 'Content-Type: application/json' \
  --data '{"content":"# TinyMe \n\n>  A tiny PHP framework based on FlightPHP and Medoo."}'
```

#### Response Example

```json
{
  "code": 201,
  "msg": "created!",
  "data": {
    "result": "create success!",
    "view_url": "/api/page/2"
  }
}
```

### get `api/page/@id`

>   Get page by specified id.

#### Request Example

```bash
curl --request GET \
  --url http://127.0.0.1:9999/api/page/2 \
  --header 'Authorization: Bearer hdtvEsu3FNEsyR069XNeTCzKSUFyWzAgSe7GcCjy'
```

#### Response Example

```json
{
  "code": 200,
  "msg": "ok",
  "data": {
    "id": 2,
    "uid": 1,
    "content": "# TinyMe \n\n>  A tiny PHP framework based on FlightPHP and Medoo.",
    "created_at": "2026-01-17 01:16:47",
    "updated_at": "2026-01-17 01:16:47"
  }
}
```

### put `api/page/@id`

>   Update page by specified id.

#### Request Example

```bash
curl --request PUT \
  --url http://127.0.0.1:9999/api/page/2 \
  --header 'Authorization: Bearer hdtvEsu3FNEsyR069XNeTCzKSUFyWzAgSe7GcCjy' \
  --header 'Content-Type: application/json' \
  --data '{
  "content": "# Flight \n\n>  Flight is a fast, simple, extensible framework for PHP. Flight enables you to quickly and easily build RESTful web applications."
}'
```

#### Response Example

```json
{
  "code": 200,
  "msg": "ok",
  "data": {
    "result": "update success!"
  }
}
```

### delete `/api/page/@id`

>   Delete page by specified id.

#### Request Example

```bash
curl --request DELETE \
  --url http://127.0.0.1:9999/api/page/2 \
  --header 'Authorization: Bearer hdtvEsu3FNEsyR069XNeTCzKSUFyWzAgSe7GcCjy' \
  --header 'Content-Type: application/json'
```

#### Response Example

```json
{
  "code": 200,
  "msg": "ok",
  "data": {
    "result": "delete success!"
  }
}
```

## Documentation

### Kernel

based on `flightphp/core` [repo](https://github.com/flightphp/core) , official website : https://flightphp.com/  .

### Cache

```php
use flight\Cache;

$app = Flight::app();
// Register cache
$app->register('cache', Cache::class, [__DIR__ . '/../storage/cache']);

$app->cache()->set('hello', 'world', 60 * 60);
$world = $app->cache()->get('hello');
```

based on `flightphp/cache` [repo](https://github.com/flightphp/cache) , official website : https://docs.flightphp.com/en/v3/awesome-plugins/php-file-cache .

### Log

```php
use Monolog\Logger;
use Monolog\Level;
use Monolog\Handler\StreamHandler;

$app = Flight::app();
// Register logger
$app->register('logger', Logger::class, ['tinyme'], function($logger) {
    $logPath = __DIR__ . '/../storage/logs/app.log';
    $logger->pushHandler(new StreamHandler($logPath, Level::Debug));
});
```

based on `monolog/monolog` [repo](https://github.com/Seldaek/monolog) , official website : https://seldaek.github.io/monolog/ .


### Database and Model

```php
use Medoo\Medoo;
use app\utils\Helper;

$app = Flight::app();

// Register database
$app->register('db', Medoo::class, [
    [
        'type' => 'mysql',
        'host' => Helper::env('DB_HOST', 'localhost'),
        'port' => Helper::env('DB_PROT', 3306),
        'database' => Helper::env('DB_DATABASE', 'tinyme'),
        'username' => Helper::env('DB_USERNAME', 'root'),
        'password' => Helper::env('DB_PASSWORD', 'root'),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
    ]
]);

$page = $app->db()->get('tm_page', '*', [
    'id' => 1
]);
```

based on `catfan/medoo` [repo](https://github.com/catfan/medoo) , official website : https://medoo.in/doc .

## Reference

- [flightphp/skeleton](https://github.com/flightphp/skeleton)

## License

The TinyMe framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
