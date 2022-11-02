<?php

namespace addons\edoc\admin\controller;

use app\admin\AdminBase;

class Doc extends AdminBase
{
    protected $model = 'addons\edoc\model\EdocItem';
    public function index()
    {
        list($where, $limit, $page, $search) = $this->buildSearch();
        $m = $this->model->with('group')->where($where)->paginate(['list_rows' => $limit, 'page' => $page]);
        $res = ['list' => $m->items(), 'total' => $m->total()];
        if ($this->request->isAjax()) {
            $this->success('res', $res);
        }
        $this->assign($res);
        $this->fetch();
    }
}
