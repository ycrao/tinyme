# TinyMe

[![Latest Stable Version](https://poser.pugx.org/ycrao/tinyme/v/stable.svg?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)
[![Latest Unstable Version](https://poser.pugx.org/ycrao/tinyme/v/unstable.svg?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)
[![License](https://poser.pugx.org/ycrao/tinyme/license?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)
[![Total Downloads](https://poser.pugx.org/ycrao/tinyme/downloads?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)

>   基于 `flight` 与 `medoo` 构建的微型php框架。

[English readme](README.md)

## 安装

类似于 `Laravel` 项目的安装，设置服务器网站根目录到 `public` 文件夹，并使用 `composer` 来安装或更新依赖包等等操作。您可以在终端窗口执行以下命令来完成：

```bash
//使用 git
git clone https://github.com/ycrao/tinyme.git tinyme.dev
//或者 使用 composer ，但请忽略执行下面 `composer install` 命令
composer create-project --prefer-dist ycrao/tinyme tinyme.dev
cd tinyme.dev
cp .env.example .env
vim .env
composer install
cd app
chmod -R 755 storage
```

演示站： http://tinyme.yas.so 。

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

## QQ Group （官方QQ群）

如果你懂中文，欢迎加入官方QQ群：[260655062](http://shang.qq.com/wpa/qunwpa?idkey=c43a551e4bc0ff5c5051ec8f6d901ab21c1e89e3001d6cf0b0b4a28c0fa4d4f8) 。
