<?php

namespace MVC\Classes;

class Request
{
    public static function exists($type = 'post') {
        switch ($type) {
            case 'post':
                return (!empty($_POST)) ? true : false;
                break;
            case 'get':
                return (!empty($_GET)) ? true : false;
                break;
            case 'files':
                return (!empty($_FILES)) ? true : false;
                break;
            default:
                return false;
                break;
        }
    }

    public static function get($item, $info = null)
    {
        if (isset($_POST[$item])) {
            return trim(filter_var($_POST[$item], FILTER_SANITIZE_STRING));
        } elseif (isset($_GET[$item])) {
            return trim(filter_var($_GET[$item], FILTER_SANITIZE_STRING));
        } elseif (isset($_FILES[$item][$info])) {
            return $_FILES[$item][$info];
        }
        
        return null;
    }

    public static function getPrevious()
    {
        return $_SERVER['HTTP_REFERER'];
    }

    public static function getRoot($exclude_path = '')
    {
        return self::getTransferProtocol() . self::getHost()
        . str_replace($exclude_path, '', dirname($_SERVER['SCRIPT_NAME']));
    }

    public static function getUrl()
    {
        return self::getTransferProtocol() . self::getHost() . self::getUri();
    }

    public static function setHeader($error, $phrase)
    {
        return header(self::getServerProtocol() . " $error $phrase");
    }

    public static function getUri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public static function getHost()
    {
        return $_SERVER['HTTP_HOST'];
    }

    public static function getServerProtocol()
    {
        return $_SERVER['SERVER_PROTOCOL'];
    }

    public static function getTransferProtocol()
    {
        $isSecure = false;
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $isSecure = true;
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] ==
            'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] ==
            'on') {
            $isSecure = true;
        }
        
        return $isSecure ? 'https://' : 'http://';
    }
}