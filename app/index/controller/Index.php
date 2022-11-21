<?php

declare(strict_types=1);

namespace app\index\controller;

use app\index\IndexBase;

class Index extends IndexBase
{
    // protected $a = file_exists(__DIR__.'/installed.lock');
    public function index()
    {
        // dump($this->getAddonName());
        echo 1;
    }
    public function install()
    {
       $this->fetch();
    }
}
