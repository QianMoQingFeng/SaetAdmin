<?php

namespace app\admin\library;

use think\facade\View;

trait SaetVueTrait
{

    public function InitSaetVueTrait()
    {
        $viewConfig = ['taglib_build_in' => 'saet\ComponentTagLib,cx'];
        if ($this->app->isDebug()) {
            $viewConfig['tpl_cache'] = false;
        }
        $this->view->config($viewConfig);
    }
}
