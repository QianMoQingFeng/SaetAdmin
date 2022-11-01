<?php

use think\facade\Route;
use think\addons\middleware\Addons;

if (isset($_SERVER['PATH_INFO'])) {

    $addons = scandir(root_path() . '/addons');
    foreach ($addons as $key => $value) {
        if (count(explode('.', $value)) > 1) {
            unset($addons[$key]);
        }
    }

    $addon = explode('/', $_SERVER['PATH_INFO'])[1];
    if (in_array($addon, $addons)) {
        define('IS_ADDON', true);
        Route::any(':addon/:controller/:action', '\\think\\addons\\Route@execute')->middleware(Addons::class);
    } else {
        define('IS_ADDON', false);
    }
    
}
