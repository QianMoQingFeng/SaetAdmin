<?php

declare(strict_types=1);

namespace app\admin\controller;

use app\admin\AdminBase;

class Addon extends AdminBase
{
    public function index()
    {
        $addons = scandir(root_path() . '/addons');
        $list = [];
        foreach ($addons as $key => $value) {
            if (count(explode('.', $value)) == 1) {
                $addon = get_addons_info($value);
                if (count($addon)) {
                    array_push($list, $addon);
                }
            }
        }
        $total = count($list);

        // dump($list);
        $res = ['list' => $list, 'total' => $total];

        if ($this->request->isAjax())  $this->success('res', $res);
        $this->fetch('', $res);
    }
}
