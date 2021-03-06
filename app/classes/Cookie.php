<?php

namespace MVC\Classes;

class Cookie
{
    /*
     * Check if cookie exists by name
     */
    public static function exists($name)
    {
        return (isset($_COOKIE[$name])) ? true : false;
    }

    /*
     * Get cookie value by name
     */
    public static function get($name)
    {
        return $_COOKIE[$name];
    }

    /*
     * Set a cookie and exipiry
     */
    public static function set($name, $value, $expiry)
    {
        if (setcookie($name, $value, time() + $expiry, '/', null, null, true)) {
            return true;
        }
        
        return false;
    }
    
    /*
     * Delete cookie by setting expiry to zero
     */
    public static function delete($name)
    {
        self::set($name, '', time() - 1);
    }

}