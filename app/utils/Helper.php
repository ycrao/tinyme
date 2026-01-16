<?php

namespace app\utils;

use flight\net\Request;


class Helper {

    public static function env($name, $default = null)
    {
        return getenv($name) ? : $default;
    }

    public static function expectsJson(Request $request)
    {
        $acceptStr = $request->accept;
        $acceptAny = $acceptJson = false;
        if ($acceptStr == '*/*' || $acceptStr == '*') {
            $acceptAny = true;
        }
        if (self::strContains($acceptStr, '/json') || self::strContains($acceptStr, '+json')) {
            $acceptJson = true;
        }
        $isPjax = $request->header('X-PJAX') == true;
        $isAjax = $request->ajax;
        return ($isAjax && !$isPjax && $acceptAny) || $acceptJson;
    }


    public static function strContains(string $haystack, string $needle)
    {
        // >= php 8+ 
        if (function_exists('str_contains')) {
            return str_contains($haystack, $needle);
        } else {
            // <= php 7.x
            return strpos($haystack, $needle) !== false;
        }
    }

    public static function generateToken($length = 40)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = '';
        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $token;
    }

    public static function encryptPassword($password, $salt = 'TinyMe&168')
    {
        return md5(substr(md5($password), 6, -8).$salt);
    }

}
