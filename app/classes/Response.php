<?php

namespace MVC\Classes;

class Response
{
    public static function redirect($location = null)
    {
        if ($location) {
            if (!headers_sent()) {
                header('Location: ' . $location);
                exit;
            } else {
                echo '<script type="text/javascript">';
                echo 'window.location.href="' . $location . '";';
                echo '</script>';
                echo '<noscript>';
                echo '<meta http-equiv="refresh" content="0;url=' . $location . '" />';
                echo '</noscript>';
                exit;
            }
        }
    }

    public static function back()
    {
        header('Location: javascript://history.go(-1)');
        exit;
    }

    public static function error()
    {
        return http_response_code();
    }
    
    public static function set($code)
    {
        return http_response_code($code);
    }

}