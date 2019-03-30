/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MariaDB
 Source Server Version : 100119
 Source Host           : localhost
 Source Database       : tinyme

 Target Server Type    : MariaDB
 Target Server Version : 100119
 File Encoding         : utf-8

 Date: 11/09/2017 21:54:51 PM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `tm_pages`
-- ----------------------------
DROP TABLE IF EXISTS `tm_pages`;
CREATE TABLE `tm_pages` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT 'user_id',
  `content` text COMMENT 'content',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `tm_pages`
-- ----------------------------
BEGIN;
INSERT INTO `tm_pages` VALUES ('1', '1', '# Hello world\n\nThis is a demo page.', '2017-11-09 13:54:39', '2017-11-09 13:54:39'), ('2', '1', '# TinyMe\n\n[![Latest Stable Version](https://poser.pugx.org/ycrao/tinyme/v/stable.svg?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)\n[![Latest Unstable Version](https://poser.pugx.org/ycrao/tinyme/v/unstable.svg?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)\n[![License](https://poser.pugx.org/ycrao/tinyme/license?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)\n[![Total Downloads](https://poser.pugx.org/ycrao/tinyme/downloads?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)\n\n>   A tiny php framework based on flight and medoo.\n\n[简体中文读我](README_zh-CN.md)\n\n## Installation\n\nJust like `Laravel` installation, set `public` directory as server root path in `vhost.conf` and using `composer` to install or update packages and so on. You can do these in your terminal like below:\n\n```bash\n//using git\ngit clone https://github.com/ycrao/tinyme.git tinyme\n//or using composer, but skip `composer install` command below\ncomposer create-project --prefer-dist ycrao/tinyme tinyme\ncd tinyme\ncp .env.example .env\nvim .env\ncomposer install\ncd app\nchmod -R 755 storage\nphp -S 127.0.0.1:9999 -t public\n```\nYou can view this project page by typing `http://127.0.0.1:9999` url in your browser.\n\n## Documentation\n\n`TinyMe` using third-party components, you can get help from their offical website.\n\n### Kernel\n\nbased on `mikecao/flight` , official website : http://flightphp.com/ , https://github.com/mikecao/flight .\n\n\n### Cache\n\n```php\nif (Flight::cache(\'data\')->contains(\'foo\')) {\n    $unit = Flight::cache(\'data\')->fetch(\'foo\');\n} else {\n    $bar = \'bar cache\';\n    Flight::cache(\'data\')->save(\'foo\', $bar);\n}\n```\n\nbased on `doctrine/cache` , official website : http://docs.doctrine-project.org/en/latest/reference/caching.html , https://github.com/doctrine/cache .\n\n### Log\n\n```php\n$logger = Flight::log()->debug(\'debug log\');\n```\n\nbased on `katzgrau/klogger` , official website : https://github.com/katzgrau/KLogger .\n\n\n### Database and Model\n\n```php\nFlight::model(\'Page\')->getPageByID(1);\nFlight::db()->get(\'tm_page\', \'*\', [\n            \'id\' => 1\n            ]);\n```\n\nbased on `catfan/medoo` , official website : https://github.com/catfan/medoo , http://medoo.in/doc .\n\n## Reference\n\n[flight-app-demo](https://github.com/xubodreamsky/flight-app-demo)\n\n## License\n\nThe TinyMe framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).\n\n## QQ Group （官方QQ群）\n\n如果你懂中文，欢迎加入官方QQ群：[260655062](http://shang.qq.com/wpa/qunwpa?idkey=c43a551e4bc0ff5c5051ec8f6d901ab21c1e89e3001d6cf0b0b4a28c0fa4d4f8) 。', '2017-11-09 13:56:52', '2017-11-09 13:56:52'), ('3', '1', '# TinyMe\n\n[![Latest Stable Version](https://poser.pugx.org/ycrao/tinyme/v/stable.svg?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)\n[![Latest Unstable Version](https://poser.pugx.org/ycrao/tinyme/v/unstable.svg?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)\n[![License](https://poser.pugx.org/ycrao/tinyme/license?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)\n[![Total Downloads](https://poser.pugx.org/ycrao/tinyme/downloads?format=flat-square)](https://packagist.org/packages/ycrao/tinyme)\n\n>   基于 `flight` 与 `medoo` 构建的微型php框架。\n\n[English readme](README.md)\n\n## 安装\n\n类似于 `Laravel` 项目的安装，设置服务器网站根目录到 `public` 文件夹，并使用 `composer` 来安装或更新依赖包等等操作。您可以在终端窗口执行以下命令来完成：\n\n```bash\n//使用 git\ngit clone https://github.com/ycrao/tinyme.git tinyme\n//或者 使用 composer ，但请忽略执行下面 `composer install` 命令\ncomposer create-project --prefer-dist ycrao/tinyme tinyme\ncd tinyme\ncp .env.example .env\nvim .env\ncomposer install\ncd app\nchmod -R 755 storage\nphp -S 127.0.0.1:9999 -t public\n```\n\n在浏览器中输入 `http://127.0.0.1:9999` 网址，您就可以看到本项目页面。\n\n## 文档\n\n`TinyMe` 使用第三方组件，你可以从他们各自网站获得相应帮助。\n\n### 核心\n\n基于 `mikecao/flight` ，官方网站： http://flightphp.com/ ， https://github.com/mikecao/flight 。\n\n\n### 缓存（Cache）\n\n```php\nif (Flight::cache(\'data\')->contains(\'foo\')) {\n    $unit = Flight::cache(\'data\')->fetch(\'foo\');\n} else {\n    $bar = \'bar cache\';\n    Flight::cache(\'data\')->save(\'foo\', $bar);\n}\n```\n\n基于 `doctrine/cache` ，官方网站： http://docs.doctrine-project.org/en/latest/reference/caching.html ， https://github.com/doctrine/cache 。\n\n### 日志（Log）\n\n```php\n$logger = Flight::log()->debug(\'debug log\');\n```\n\n基于 `katzgrau/klogger` ， 官方网站： https://github.com/katzgrau/KLogger 。\n\n\n### 数据库（Database）与模型（Model）\n\n```php\nFlight::model(\'Page\')->getPageByID(1);\nFlight::db()->get(\'tm_page\', \'*\', [\n            \'id\' => 1\n            ]);\n```\n\n基于 `catfan/medoo` ，官方网站 : https://github.com/catfan/medoo ， http://medoo.in/doc 。\n\n## 参考\n\n[flight-app-demo](https://github.com/xubodreamsky/flight-app-demo)\n\n## 授权协议\n\n`TinyMe` 是以 [MIT 授权协议](http://opensource.org/licenses/MIT) 发布的开源软件。\n\n## QQ Group （官方QQ群）\n\n如果你懂中文，欢迎加入官方QQ群：[260655062](http://shang.qq.com/wpa/qunwpa?idkey=c43a551e4bc0ff5c5051ec8f6d901ab21c1e89e3001d6cf0b0b4a28c0fa4d4f8) 。', '2017-11-09 13:58:39', '2017-11-09 13:58:39');
COMMIT;

-- ----------------------------
--  Table structure for `tm_tokens`
-- ----------------------------
DROP TABLE IF EXISTS `tm_tokens`;
CREATE TABLE `tm_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(11) DEFAULT NULL COMMENT 'user_id',
  `token` varchar(100) DEFAULT NULL COMMENT 'token',
  `expire_at` int(11) DEFAULT NULL COMMENT 'expire timestamp',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`) USING BTREE,
  KEY `uid_token` (`uid`,`token`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `tm_tokens`
-- ----------------------------
BEGIN;
INSERT INTO `tm_tokens` VALUES ('1', '1', 'crQHrvSBNmv84fTW3i7ZaYVIihIUnGtSx8VDdaL87', '1510141596', '2017-11-08 18:46:36', '2017-11-08 18:46:36'), ('2', '1', 'z95BW8363MiykWv10w21iKnVc7IHUGAf1sEygBV3P', '1510141614', '2017-11-08 18:46:54', '2017-11-08 18:46:54'), ('3', '1', 'DPsQn2hudiMRfFkE8GCwaSWTRBCsy3qr6Vq0KjIpi', '1510211333', '2017-11-09 14:08:53', '2017-11-09 14:08:53'), ('4', '1', 'ifpGcwagCU63qACMhyx18ItMyKDvsAScfCu1DTIy9', '1510215367', '2017-11-09 15:16:07', '2017-11-09 15:16:07');
COMMIT;

-- ----------------------------
--  Table structure for `tm_users`
-- ----------------------------
DROP TABLE IF EXISTS `tm_users`;
CREATE TABLE `tm_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `email` varchar(64) NOT NULL DEFAULT '' COMMENT 'email',
  `password` char(32) NOT NULL DEFAULT '' COMMENT 'password',
  `nickname` varchar(128) NOT NULL DEFAULT '' COMMENT 'nickname',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `tm_users`
-- ----------------------------
BEGIN;
INSERT INTO `tm_users` VALUES ('1', 'foo@example.com', '8f94604c843418f04c61839df661bbfe', 'foo_user', '2017-11-07 21:08:31', '2017-11-07 21:08:31'), ('2', 'bar@example.com', '8f94604c843418f04c61839df661bbfe', 'bar_user', '2017-11-07 21:08:31', '2017-11-07 21:08:31');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
