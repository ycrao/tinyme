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
