<?php

if (!function_exists('env')) {

    /**
     * Get ENV variable
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    function env($name, $default = null)
    {
        return getenv($name) ? : $default;
    }

}


if (!function_exists('encrypt_password')) {

    /**
     * Generate a password by `md5 + salt`
     *
     * @param string $password
     * @param string $salt
     * @return string
     */
    function encrypt_password($password, $salt = 'TinyMe&168')
    {
        return md5(substr(md5($password), 6, -8).$salt);
    }
}


if (!function_exists('str_rand')) {

    /**
     * Generate rand string
     * 
     * @param int $len
     * @return string
     */
    function str_rand($len)
    {
        $str = 'abcdefghijkmnpqrstuvwxyz0123456789ABCDEFGHIGKLMNPQRSTUVWXYZ';
        $rand = '';
        for ($i = 0; $i < $len - 1; $i ++) {
            $rand .= $str[mt_rand(0, strlen($str) - 1)];
        }
       return $rand;
    }
}


 

