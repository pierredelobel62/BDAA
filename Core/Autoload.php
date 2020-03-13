<?php

class Autoload
{
    static function register()
    {
        spl_autoload_register(function($class) {
            require_once(str_replace('\\', '/', $class) . '.php');
        });
    }
}