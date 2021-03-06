<?php

namespace MVC\Classes;

class Session
{

    /**
     * starts a session
     */
    public static function start()
    {
        // if no session exist, start a new session
        if (session_id() == '') {
            session_start();
        }
    }

    /*
     * Check if session exists or not
     */
    public static function exists($name)
    {
        return (isset($_SESSION[$name])) ? true : false;
    }

    /*
     * Set a session by key and value
     */
    public static function set($key, $value)
    {
        return $_SESSION[$key] = $value;
    }

    /**
     * Adds a value as a new array element to the key.
     * useful for collecting error messages etc
     */
    public static function addKey($key, $name, $value)
    {
        $_SESSION[$key][$name] = $value;
    }

    /*
     * Get a session value by key
     */
    public static function get($key)
    {
        return $_SESSION[$key];
    }

    /*
     * Get a sessions array value by key and value
     */
    public static function getKey($key, $name)
    {
        return $_SESSION[$key][$name];
    }

    /*
     * Delete key value from session array
     */
    public static function deleteKey($key, $value)
    {
        unset($_SESSION[$key][$value]);
    }

    /*
     * Arra push to arrays together
     */
    public static function push($key, $value)
    {
        return array_push($_SESSION[$key], $value);
    }

    /*
     * Delete session by key name
     */
    public static function delete($key)
    {
        if (self::exists($key))
        {
            unset($_SESSION[$key]);
        }
    }

    /**
     * deletes the session (= logs the user out)
     */
    public static function destroy()
    {
        session_destroy();
    }

    /*
     * Flash messages by deleting session after it is shown
     */
    public static function flash($key, $string = null)
    {
        if (self::exists($key)) {
            $session = self::get($key);
            self::delete($key);
            return $session;
        }

        return false;
    }

}