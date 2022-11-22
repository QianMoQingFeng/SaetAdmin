<?php
declare (strict_types = 1);

namespace app\admin\controller\admin;

use app\admin\AdminBase;
use think\View;
class Rule extends AdminBase
{

    protected $switchAllowField = 'is_menu_nav';

    public function index()
    {
        if ($this->auth->isSuper()) {
            $menuList = $menuList = $this->model->select()->toArray();
        } else {
            $menuList = $menuList = $this->model->select($this->auth->getRuleIds())->toArray();
        }
        $menuListTree = $menuList ? array_values(listToTree($menuList, 'children')) : [];
        $res = ['list' => $menuListTree, 'total' => count($menuList)];
        if ($this->request->isAjax()) {
            success('', $res);
        }
        $this->assign($res);
        $this->fetch();
    }

}
