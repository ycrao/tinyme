# TinyMe

[![Latest Stable Version](https://poser.pugx.org/ycrao/tinyme/v/stable.svg?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)
[![Latest Unstable Version](https://poser.pugx.org/ycrao/tinyme/v/unstable.svg?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)
[![License](https://poser.pugx.org/ycrao/tinyme/license?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)
[![Total Downloads](https://poser.pugx.org/ycrao/tinyme/downloads?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)

>   A tiny php framework based on flight and medoo.

[简体中文读我](README_zh-CN.md)

## Installation

Just like `Laravel` installation, set `public` directory as server root path in `vhost.conf` and using `composer` to install or update packages and so on. You can do these in your terminal like below:

```bash
//using git
git clone https://github.com/ycrao/tinyme.git tinyme
//or using composer, but skip `composer install` command below
composer create-project --prefer-dist ycrao/tinyme tinyme
cd tinyme
cp .env.example .env
vim .env
composer install
cd app
chmod -R 755 storage
php -S 127.0.0.1:9999 -t public
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
curl -X POST http://127.0.0.1:9999/api/login --data "email=foo@example.com&password=123456"
```

#### Response Example

Using `200` as `code` when success.

```json
{
    "code": 200,
    "msg": "OK",
    "data": {
        "uid": "1",
        "token": "TVC66rtXnv7pw3jge4EtyC7qtyKKPxjjGyVUi4K2D",
        "expire_at": 1510233022
    }
}
```

Using non-2xx (`403` 、`500` etc) digital when fail or error.

```json
{
    "code": 403,
    "msg": "illegal or incorrect credentials",
    "data": []
}
```

### get `api/pages`

>   Get current user pages with pagination.

#### Request Example

```
curl http://127.0.0.1:9999/api/pages -H "AUTHORIZATION: Bearer TVC66rtXnv7pw3jge4EtyC7qtyKKPxjjGyVUi4K2D"

# with page
curl http://127.0.0.1:9999/api/pages?page=2&per_page=2 -H "AUTHORIZATION: Bearer TVC66rtXnv7pw3jge4EtyC7qtyKKPxjjGyVUi4K2D"
```

#### Response Example

```json
{
    "code": 200,
    "msg": "OK",
    "data": {
        "total": 2,
        "per_page": 2,
        "current_page": 2,
        "next_page_url": "/api/pages/?page=3&per_page=2",
        "prev_page_url": "/api/pages/?page=1&per_page=2",
        "from": "1",
        "to": "1",
        "data": [
            {
                "id": "1",
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
# POST raw data (in `json` format)
curl -X POST http://127.0.0.1:9999/api/page --data '{"content":"# Hello world\n\nThis is another demo page."}' -H "AUTHORIZATION: Bearer TVC66rtXnv7pw3jge4EtyC7qtyKKPxjjGyVUi4K2D"

# POST data (in form string)
curl -X POST http://127.0.0.1:9999/api/page --data "content=# Hello world\n\nThis is another demo page." -H "AUTHORIZATION: Bearer TVC66rtXnv7pw3jge4EtyC7qtyKKPxjjGyVUi4K2D"
```

#### Response Example

```json
{
    "code":200,
    "msg":"OK",
    "data":{
        "result":"create success!",
        "view_url":"/api/page/4"
    }
}
```

### get `api/page/@id`

>   Get page by specified id.

#### Request Example

```bash
curl http://127.0.0.1:9999/api/page/4 -H "AUTHORIZATION: Bearer TVC66rtXnv7pw3jge4EtyC7qtyKKPxjjGyVUi4K2D"
```

#### Response Example

```json
{
    "code":200,
    "msg":"OK",
    "data":{
        "id":"4",
        "uid":"1",
        "content":"# Hello world\n\nThis is another demo page.",
        "created_at":"2017-11-09 20:36:52",
        "updated_at":"2017-11-09 20:36:52"
    }
}
```

### put `api/page/@id`

>   Update page by specified id.

#### Request Example

```bash
# PUT raw data (in `json` format)
curl -X PUT http://127.0.0.1:9999/api/page/4 --data '{"content":"# Demo\n\nThis is another demo page."}' -H "AUTHORIZATION: Bearer TVC66rtXnv7pw3jge4EtyC7qtyKKPxjjGyVUi4K2D"

# hijack PUT method by passing `_method=put` parameter with POST
curl -X POST http://127.0.0.1:9999/api/page/4 --data "_method=put&content=# Demo\n\nThis is another demo page." -H "AUTHORIZATION: Bearer TVC66rtXnv7pw3jge4EtyC7qtyKKPxjjGyVUi4K2D"
```

#### Response Example

```json
{
    "code":200,
    "msg":"OK",
    "data":{
        "result":"update success!"
    }
}
```

### delete `/api/page/@id`

>   Delete page by specified id.

#### Request Example

```bash
# DELETE
curl -X DELETE http://127.0.0.1:9999/api/page/4 -H "AUTHORIZATION: Bearer TVC66rtXnv7pw3jge4EtyC7qtyKKPxjjGyVUi4K2D"

# hijack DELETE method by passing `_method=delete` parameter with POST
curl -X POST http://127.0.0.1:9999/api/page/4 --data "_method=delete" -H "AUTHORIZATION: Bearer TVC66rtXnv7pw3jge4EtyC7qtyKKPxjjGyVUi4K2D"
```

#### Response Example

```json
{
    "code":200,
    "msg":"OK",
    "data":{
        "result":"delete success!"
    }
}
```

## Documentation

### Kernel

based on `mikecao/flight` , official website : http://flightphp.com/ , https://github.com/mikecao/flight .


### Cache

```php
if (Flight::cache('data')->contains('foo')) {
    $unit = Flight::cache('data')->fetch('foo');
} else {
    $bar = 'bar cache';
    Flight::cache('data')->save('foo', $bar);
}
```

based on `doctrine/cache` , official website : http://docs.doctrine-project.org/en/latest/reference/caching.html , https://github.com/doctrine/cache .

### Log

```php
$logger = Flight::log()->debug('debug log');
```

based on `katzgrau/klogger` , official website : https://github.com/katzgrau/KLogger .


### Database and Model

```php
Flight::model('Page')->getPageByID(1);
Flight::db()->get('tm_page', '*', [
            'id' => 1
            ]);
```

based on `catfan/medoo` , official website : https://github.com/catfan/medoo , http://medoo.in/doc .

## Reference

[flight-app-demo](https://github.com/xubodreamsky/flight-app-demo)

## License

The TinyMe framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

## QQ Group （官方QQ群）

如果你懂中文，欢迎加入官方QQ群：[260655062](http://shang.qq.com/wpa/qunwpa?idkey=c43a551e4bc0ff5c5051ec8f6d901ab21c1e89e3001d6cf0b0b4a28c0fa4d4f8) 。
