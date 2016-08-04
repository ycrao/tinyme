<?php

use Katzgrau\KLogger\Logger;
use Psr\Log\LogLevel;


/**
 * TinyMe kernel class
 *
 * @author raoyc <raoyc2009@gmail.com>
 */
class TinyMe
{

    protected static $_log;
    protected static $_db = [];
    protected static $_model = [];
    protected static $_cache = [];
    protected static $_controller = [];
    protected static $_url;

    /**
     * bootstrap
     * for framework bootstrap.
     */
    public static function bootstrap()
    {

        //route
        require APP_PATH.'/routes.php';

        //set timezone
        $timezone = env('APP_TIMEZONE', 'Asia/Shanghai');
        date_default_timezone_set($timezone);

        //filters
        if (get_magic_quotes_gpc()) {
            $_GET = self::stripslashesDeep($_GET);
            $_POST = self::stripslashesDeep($_POST);
            $_COOKIE = self::stripslashesDeep($_COOKIE);
        }

        $_REQUEST = array_merge($_GET, $_POST, $_COOKIE);


        /*--
        Flight maps start
        --*/

        //log
        Flight::map('log', [__CLASS__, 'log']);

        //db : database
        Flight::map('db', [__CLASS__, 'db']);

        //model
        Flight::map('model', [__CLASS__, 'getModel']);

        //cache
        Flight::map('cache', [__CLASS__, 'cache']);

        //get controller
        Flight::map('controller', [__CLASS__, 'getController']);

        //halt response
        Flight::map("halt", array(__CLASS__, "halt"));


        //404 error
        Flight::map('notFound', function() {

            //Flight::log()->error(Flight::request()->ip.': '.Flight::request()->method.' '.Flight::request()->url.' not Found !');
            Flight::log()->error('404 NOT FOUND !', json_decode(json_encode(Flight::request()), true));
            //include 'errors/404.html';
            return Flight::render('404');
        });

        /*
        Flight::map('error', function(Exception $ex){
            // Handle error
            Flight::log()->error('500 Error : '.$ex->getTraceAsString());
            echo $ex->getTraceAsString();
        });
        */

        /*--
        Flight maps end
        --*/
    }

    /**
     * stripslashesDeep
     * deep data filters.
     */
    public static function stripslashesDeep($data)
    {
        if (is_array($data)) {
            return array_map([__CLASS__, __FUNCTION__], $data);
        } else {
            return stripslashes($data);
        }
    }

    /**
     * Log
     * based on `katzgrau/klogger` , official website : https://github.com/katzgrau/KLogger .
     */
    public static function log()
    {
        $logDir = Flight::get('log.path');
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
        if (!isset(self::$_log)) {
            $options = [
                'extension'      => 'log',
                'dateFormat'     => 'Y-m-d H:i:s',
                'prefix'         => 'log_',
            ];
            $logger = new Logger($logDir, LogLevel::DEBUG, $options);
            self::$_log = $logger;
        }

        return self::$_log;
    }

    /**
     * Database
     * based on `catfan/medoo` , official website : https://github.com/catfan/medoo , http://medoo.in/doc .
     */
    public static function db($name = 'default')
    {
        if(!isset(self::$_db[$name])) {

            $db = Flight::get('db.'.$name);
            if(is_array($db)) {
                $db_host    = isset($db['host']) ? $db['host'] : 'localhost';
                $db_port    = isset($db['port']) ? $db['port'] : 3306;
                $db_user    = isset($db['user']) ? $db['user'] : 'root';
                $db_pass    = isset($db['pass']) ? $db['pass'] : '';
                $db_name    = isset($db['name']) ? $db['name'] : 'demo';
                $db_charset = isset($db['charset']) ? $db['charset'] : 'utf8';
            }

            $db = new medoo([
                'database_type' => 'mysql',
                'database_name' => $db_name,
                'server'        => $db_host,
                'port'          => $db_port,
                'username'      => $db_user,
                'password'      => $db_pass,
                'charset'       => $db_charset
            ]);

            self::$_db[$name] = $db;
        }

        return self::$_db[$name];
    }

    /**
     * getModel
     * get model by name.
     */
    public static function getModel($name, $initDb = true) 
    {
        $class = '\\'.trim(str_replace('/', '\\', $name), '\\').'Model';
        if (!isset(self::$_model[$name])) {
            $instance = new $class();
            if($initDb) {
                $instance->setDb(self::db());
            }
            self::$_model[$name] = $instance;
        }

        return self::$_model[$name];
    }

    /**
     * Cache
     * based on `doctrine/cache` , official website : http://docs.doctrine-project.org/en/latest/reference/caching.html , https://github.com/doctrine/cache .
     * using file cache here.
     */
    public static function cache($path = 'data') 
    {
        $path = Flight::get('cache.path').'/'.$path;
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        if (!isset(self::$_cache[$path])) {
            $cache = new \Doctrine\Common\Cache\FilesystemCache($path, '.cache');
            self::$_cache[$path] = $cache;
        }

        return self::$_cache[$path];
    }

    /**
     * getController
     * get controller by name.
     */
    public static function getController($name) 
    {
        $class = '\\'.trim(str_replace('/', '\\', $name), '\\').'Controller';
        if(!isset(self::$_controller[$class])) {
            $instance = new $class();
            self::$_controller[$class] = $instance;
        }

        return self::$_controller[$class];
    }


    /**
     * Halt
     * do something before sending response.
     */
    public static function halt($msg = '', $code = 200) {
        Flight::response(false)
            ->status($code)
            ->header("Content-Type", "text/html; charset=utf8")
            ->write($msg)
            ->send();
    }

}
