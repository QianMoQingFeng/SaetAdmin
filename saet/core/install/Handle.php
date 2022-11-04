<?php

namespace saet\core\install;

use app\admin\AdminBase;
use think\facade\View;


class Handle 
{

    protected $noLogin = ['install'];

    public function install()
    {
        $view = clone View::engine('Think');
        $view->config([
            'view_path' => __DIR__.'/'
        ]);
        $view->fetch('install',['a'=>1]);
    }
}
