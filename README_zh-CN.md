# TinyMe V2

[![Latest Stable Version](https://poser.pugx.org/ycrao/tinyme/v/stable.svg?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)
[![Latest Unstable Version](https://poser.pugx.org/ycrao/tinyme/v/unstable.svg?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)
[![License](https://poser.pugx.org/ycrao/tinyme/license?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)
[![Total Downloads](https://poser.pugx.org/ycrao/tinyme/downloads?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)

>   基于 `flight` 与 `medoo` 构建的微型php框架。

[宣传页面](https://raoyc.com/tinyme/index.html) | [English readme](README.md) | [旧版 TinyMe](https://github.com/ycrao/tinyme/tree/v1)

## 安装

类似于 `Laravel` 项目的安装，设置服务器网站根目录到 `public` 文件夹，并使用 `composer` 来安装或更新依赖包等等操作。您可以在终端窗口执行以下命令来完成：

```bash
# 使用 git
git clone https://github.com/ycrao/tinyme.git tinyme
# 或者使用 composer，但请忽略执行下面 `composer install` 命令
composer create-project --prefer-dist ycrao/tinyme tinyme
cd tinyme
cp .env.example .env
vim .env
composer install
cd app
chmod -R 755 storage
php -S 127.0.0.1:9999 -t public
# 或者使用 composer
composer start
```

在浏览器中输入 `http://127.0.0.1:9999` 网址，您就可以看到本项目页面。

## API 服务

请导入 `sql\tinyme.sql` 到你本地数据库，然后修改 `.env` 配置。

### 路由

| 方法       | 路由 或 URI        | 备注                      |
| :------- | :-------------- | :---------------------- |
| `post`   | `/api/login`    | 通过登录账号获取 access-token 。 |
| `get`    | `/api/pages`    | 获取当前用户所有页面，附带分页。        |
| `post`   | `/api/page`     | 创建一个新页面。                |
| `get`    | `/api/page/@id` | 获取指定 id 页面。             |
| `put`    | `/api/page/@id` | 更新指定 id 页面。             |
| `delete` | `/api/page/@id` | 删除指定 id 页面。             |

### API 错误码

| 状态码                | 备注                |
| :----------------- | :---------------- |
| 500                | 失败或错误。            |
| 401 (Unauthorized) | access token 已过期。 |
| 403 (Forbidden)    | 非法或不正确的（登录）凭证。    |
| 404 (Not Found)    | API 或路由不存在。       |
| 200 (OK)           | 成功。               |

### post `api/login`

>   使用 `email` 和 `password` 账号登录并获取 `access_token` 。如果 token 失效请重新请求此登录接口 ，但请注意：不要在旧 token(s) 没有失效的情况下，频繁调用本接口。

#### 请求示例

```bash
curl --request POST \
  --url http://127.0.0.1:9999/api/login \
  --header 'Content-Type: application/json' \
  --data '{
  "email": "foo@example.com",
  "password": "123456"
}'
```

#### 响应示例

使用 `200` 状态码表示成功。

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

当失败或者错误时，请使用 `非2xx` （如 `403` 、`500`  等）数字状态。

```json
{
  "code": 403,
  "msg": "illegal or incorrect credentials",
  "data": null
}
```

### get `api/pages`

>   获取当前用户所有页面，附带分页。

#### 请求示例

```
curl --request GET \
  --url http://127.0.0.1:9999/api/pages?page=1&per_page=2 \
  --header 'Authorization: Bearer hdtvEsu3FNEsyR069XNeTCzKSUFyWzAgSe7GcCjy'
```

#### 响应示例

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

>   创建一个新页面。

#### 请求示例

```bash
curl --request POST \
  --url http://127.0.0.1:9999/api/page \
  --header 'Authorization: Bearer hdtvEsu3FNEsyR069XNeTCzKSUFyWzAgSe7GcCjy' \
  --header 'Content-Type: application/json' \
  --data '{"content":"# TinyMe \n\n>  A tiny PHP framework based on FlightPHP and Medoo."}'
```

#### 响应示例

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

>   获取指定 id 页面。

#### 请求示例

```bash
curl --request GET \
  --url http://127.0.0.1:9999/api/page/2 \
  --header 'Authorization: Bearer hdtvEsu3FNEsyR069XNeTCzKSUFyWzAgSe7GcCjy'
```

#### 响应示例

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

>   更新指定 id 页面。

#### 请求示例

```bash
curl --request PUT \
  --url http://127.0.0.1:9999/api/page/2 \
  --header 'Authorization: Bearer hdtvEsu3FNEsyR069XNeTCzKSUFyWzAgSe7GcCjy' \
  --header 'Content-Type: application/json' \
  --data '{
  "content": "# Flight \n\n>  Flight is a fast, simple, extensible framework for PHP. Flight enables you to quickly and easily build RESTful web applications."
}'
```

#### 响应示例

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

>   删除指定 id 页面。

#### 请求示例

```bash
curl --request DELETE \
  --url http://127.0.0.1:9999/api/page/2 \
  --header 'Authorization: Bearer hdtvEsu3FNEsyR069XNeTCzKSUFyWzAgSe7GcCjy' \
  --header 'Content-Type: application/json'
```

#### 响应示例

```json
{
  "code": 200,
  "msg": "ok",
  "data": {
    "result": "delete success!"
  }
}
```

## 文档

### 核心

基于 `flightphp/core` [仓库](https://github.com/flightphp/core)，官方网站：https://flightphp.com/ 。

### 缓存（Cache）

```php
use flight\Cache;

$app = Flight::app();
// 注册缓存
$app->register('cache', Cache::class, [__DIR__ . '/../storage/cache']);

$app->cache()->set('hello', 'world', 60 * 60);
$world = $app->cache()->get('hello');
```

基于 `flightphp/cache` [仓库](https://github.com/flightphp/cache)，官方网站：https://docs.flightphp.com/en/v3/awesome-plugins/php-file-cache 。

### 日志（Log）

```php
use Monolog\Logger;
use Monolog\Level;
use Monolog\Handler\StreamHandler;

$app = Flight::app();
// 注册日志记录器
$app->register('logger', Logger::class, ['tinyme'], function($logger) {
    $logPath = __DIR__ . '/../storage/logs/app.log';
    $logger->pushHandler(new StreamHandler($logPath, Level::Debug));
});
```

基于 `monolog/monolog` [仓库](https://github.com/Seldaek/monolog)，官方网站：https://seldaek.github.io/monolog/ 。


### 数据库（Database）与模型（Model）

```php
use Medoo\Medoo;
use app\utils\Helper;

$app = Flight::app();

// 注册数据库
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

基于 `catfan/medoo` [仓库](https://github.com/catfan/medoo)，官方网站：https://medoo.in/doc 。

## 参考

- [flightphp/skeleton](https://github.com/flightphp/skeleton)

## 授权协议

`TinyMe` 是以 [MIT 授权协议](http://opensource.org/licenses/MIT) 发布的开源软件。
