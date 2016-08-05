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
git clone https://github.com/ycrao/tinyme.git tinyme.dev
cd tinyme.dev
cp .env.example .env
vim .env
composer install
cd app
chmod -R 755 storage
```



Demo site: http://tinyme.yas.so

## Documentation

`TinyMe` using third-party components, you can get help from their offical website.

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
