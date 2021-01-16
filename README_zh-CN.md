# TinyMe

[![Latest Stable Version](https://poser.pugx.org/ycrao/tinyme/v/stable.svg?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)
[![Latest Unstable Version](https://poser.pugx.org/ycrao/tinyme/v/unstable.svg?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)
[![License](https://poser.pugx.org/ycrao/tinyme/license?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)
[![Total Downloads](https://poser.pugx.org/ycrao/tinyme/downloads?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)

>   基于 `flight` 与 `medoo` 构建的微型php框架。

[宣传页面](https://raoyc.com/tinyme/index.html) | [English readme](README.md)

## 安装

类似于 `Laravel` 项目的安装，设置服务器网站根目录到 `public` 文件夹，并使用 `composer` 来安装或更新依赖包等等操作。您可以在终端窗口执行以下命令来完成：

```bash
//使用 git
git clone https://github.com/ycrao/tinyme.git tinyme
//或者 使用 composer ，但请忽略执行下面 `composer install` 命令
composer create-project --prefer-dist ycrao/tinyme tinyme
cd tinyme
cp .env.example .env
vim .env
composer install
cd app
chmod -R 755 storage
php -S 127.0.0.1:9999 -t public
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
curl -X POST http://127.0.0.1:9999/api/login --data "email=foo@example.com&password=123456"
```

#### 响应示例

使用 `200` 状态码表示成功。

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

当失败或者错误时，请使用 `非2xx` （如 `403` 、`500`  等）数字状态。

```json
{
    "code": 403,
    "msg": "illegal or incorrect credentials",
    "data": []
}
```

### get `api/pages`

>   获取当前用户所有页面，附带分页。

#### 请求示例

```
curl http://127.0.0.1:9999/api/pages -H "AUTHORIZATION: Bearer TVC66rtXnv7pw3jge4EtyC7qtyKKPxjjGyVUi4K2D"

# with page
curl http://127.0.0.1:9999/api/pages?page=2&per_page=2 -H "AUTHORIZATION: Bearer TVC66rtXnv7pw3jge4EtyC7qtyKKPxjjGyVUi4K2D"
```

#### 响应示例

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

>   创建一个新页面。

#### 请求示例

```bash
# POST raw data (in `json` format)
curl -X POST http://127.0.0.1:9999/api/page --data '{"content":"# Hello world\n\nThis is another demo page."}' -H "AUTHORIZATION: Bearer TVC66rtXnv7pw3jge4EtyC7qtyKKPxjjGyVUi4K2D"

# POST data (in form string)
curl -X POST http://127.0.0.1:9999/api/page --data "content=# Hello world\n\nThis is another demo page." -H "AUTHORIZATION: Bearer TVC66rtXnv7pw3jge4EtyC7qtyKKPxjjGyVUi4K2D"
```

#### 响应示例

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

>   获取指定 id 页面。

#### 请求示例

```bash
curl http://127.0.0.1:9999/api/page/4 -H "AUTHORIZATION: Bearer TVC66rtXnv7pw3jge4EtyC7qtyKKPxjjGyVUi4K2D"
```

#### 响应示例

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

>   更新指定 id 页面。

#### 请求示例

```bash
# PUT raw data (in `json` format)
curl -X PUT http://127.0.0.1:9999/api/page/4 --data '{"content":"# Demo\n\nThis is another demo page."}' -H "AUTHORIZATION: Bearer TVC66rtXnv7pw3jge4EtyC7qtyKKPxjjGyVUi4K2D"

# hijack PUT method by passing `_method=put` parameter with POST
curl -X POST http://127.0.0.1:9999/api/page/4 --data "_method=put&content=# Demo\n\nThis is another demo page." -H "AUTHORIZATION: Bearer TVC66rtXnv7pw3jge4EtyC7qtyKKPxjjGyVUi4K2D"
```

#### 响应示例

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

>   删除指定 id 页面。

#### 请求示例

```bash
# DELETE
curl -X DELETE http://127.0.0.1:9999/api/page/4 -H "AUTHORIZATION: Bearer TVC66rtXnv7pw3jge4EtyC7qtyKKPxjjGyVUi4K2D"

# hijack DELETE method by passing `_method=delete` parameter with POST
curl -X POST http://127.0.0.1:9999/api/page/4 --data "_method=delete" -H "AUTHORIZATION: Bearer TVC66rtXnv7pw3jge4EtyC7qtyKKPxjjGyVUi4K2D"
```

#### 响应示例

```json
{
    "code":200,
    "msg":"OK",
    "data":{
        "result":"delete success!"
    }
}
```

## 文档

`TinyMe` 使用第三方组件，你可以从他们各自网站获得相应帮助。

### 核心

基于 `mikecao/flight` ，官方网站： http://flightphp.com/ ， https://github.com/mikecao/flight 。


### 缓存（Cache）

```php
if (Flight::cache('data')->contains('foo')) {
    $unit = Flight::cache('data')->fetch('foo');
} else {
    $bar = 'bar cache';
    Flight::cache('data')->save('foo', $bar);
}
```

基于 `doctrine/cache` ，官方网站： http://docs.doctrine-project.org/en/latest/reference/caching.html ， https://github.com/doctrine/cache 。

### 日志（Log）

```php
$logger = Flight::log()->debug('debug log');
```

基于 `katzgrau/klogger` ， 官方网站： https://github.com/katzgrau/KLogger 。


### 数据库（Database）与模型（Model）

```php
Flight::model('Page')->getPageByID(1);
Flight::db()->get('tm_page', '*', [
            'id' => 1
            ]);
```

基于 `catfan/medoo` ，官方网站 : https://github.com/catfan/medoo ， http://medoo.in/doc 。

## 参考

[flight-app-demo](https://github.com/xubodreamsky/flight-app-demo)

## 授权协议

`TinyMe` 是以 [MIT 授权协议](http://opensource.org/licenses/MIT) 发布的开源软件。
