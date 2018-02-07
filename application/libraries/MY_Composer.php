<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class MY_Composer
{
    public function __construct()
    {
        // COMPSER VENDOR DIRECTORY
        include APPPATH . 'vendor/autoload.php';
    }
}
