<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if (!function_exists('dd')) {
    /**
     * variable yang akan di dump
     * @param  object|array|string|int|mixed $var variable yang akan di dump
     * @return mixed
     */
    function dd($var)
    {
        die(var_dump($var));
    }
}
