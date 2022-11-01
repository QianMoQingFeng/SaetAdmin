<?php
declare (strict_types = 1);

namespace app\admin\controller\admin;

use app\admin\AdminBase;

class Group extends AdminBase
{

    protected $dataToView = true;

    public function initialize()
    {

    }

    /**
     * 设置分组权限
     *
     * @return void
     */
    public function auth()
    {
        $id = $this->request->param('id');
        $group = $this->model->find($id);

        if ($this->request->isAjax()) {
            $rules = $this->request->param('rules');
            $group->rule_ids = $rules;
            $res = $group->save();
            $this->success('设置成功');
        }

        $menuList = \app\admin\model\admin\Rule::field('title,id,pid')->select()->toArray();
        $rules = array_values(listToTree($menuList, 'children'));
        $this->assign('rules', $rules);
        $this->assign('group', $group);

        $this->fetch();
    }
}
