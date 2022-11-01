<?php
namespace addons\more_module\api\controller;

use addons\more_module\Plugin;
use saet\demo\AddonBaseController;
use think\facade\Config;

class Index extends Plugin
{
    public function link()
    {
        dump($this) ;
        echo 'hello link';
        $this->fetch();
    }
}