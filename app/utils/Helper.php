<?php

namespace app\utils;

use flight\net\Request;


class Helper {

    /**
     * Get environment variable.
     * 
     * @param string $name
     * @param string|null $default
     * @return string|null
     */
    public static function env(string $name, ?string $default = null): ?string
    {
        return $_ENV[$name] ? : $default;
    }

    /**
     * Check if request expects JSON response.
     * 
     * @param Request $request
     * @return bool
     */
    public static function expectsJson(Request $request): bool
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
    
    /**
     * Check if a string contains another string.
     * 
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    public static function strContains(string $haystack, string $needle): bool
    {
        // >= php 8+ 
        if (function_exists('str_contains')) {
            return str_contains($haystack, $needle);
        } else {
            // <= php 7.x
            return strpos($haystack, $needle) !== false;
        }
    }

     /**
      * Generate a random token.
      * 
      * @param int $length
      * @return string
      */
    public static function generateToken(int $length = 40): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = '';
        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $token;
    }

     /**
      * Encrypt password using MD5.
      * 
      * @param string $password
      * @param string $salt
      * @return string
      */
    public static function encryptPassword(string $password, string $salt = 'TinyMe&168'): string
    {
        return md5(substr(md5($password), 6, -8).$salt);
    }

}
