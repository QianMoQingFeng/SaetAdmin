<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\admin\AdminBase;

class Home extends AdminBase
{

    // protected $noLogin = ['dashboard'];

    public function initialize()
    {
        // dump('home-initialize');
    }

  
    public function dashboard()
    {
        dump('dashboard');
        // die;
        $this->fetch();
    }

    public function index()
    {

        // $this->fetch();
    }

}
