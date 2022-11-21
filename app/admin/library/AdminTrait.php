<?php

namespace app\admin\library;

use think\helper\Str;

trait AdminTrait
{
    // DataTrait
    protected $switchAllowField = null;



    public function index()
    {
        list($where, $limit, $page, $search) = $this->buildSearch();
        $m = $this->model->where($where)->paginate(['list_rows' => $limit, 'page' => $page]);
        $res = ['list' => $m->items(), 'total' => $m->total()];

        if ($this->request->isAjax()) {
            $this->success('res', $res);
        }

        $this->assign($res);
        $this->fetch();
    }

    protected function buildSearch($config = [], $defaultWhere = [])
    {

        $model = isset($this->model) ? $this->model : $this->setModel();
        $key = $this->request->param('key', 'id');
        $order = $this->request->param('order', 'desc');
        $limit = $this->request->param('limit', 12);
        $page = $this->request->param('page', 1);
        $search = $this->request->param('search', []);
        $fastValue = $this->request->param('fast_value', null);

        extract($config);
        // $where = [];

        // foreach ($search as $k => &$item) {
        //     // switch ($item[1]) {
        //     //     case 'LIKE':
        //     //         $item[2] = "%$item[2]%";
        //     //         break;
        //     // }
        //     // if ($isJoin && !strpos($item[0], '.')) {
        //     //     $item[0] = $alias . $item[0];
        //     // }
        //     $where[$k] = array($item['name'], $item['exp'], $item['value']);
        // }

        $alias = null;
        $bind = null;

        if ($fastValue) {
            array_push($search, ['name' => 'id|token', 'exp' => 'like', 'value' => "%$fastValue%"]);
        }

        // $this->success('',$search);

        $where = function ($query) use ($search, $alias, $bind, &$model) {
            if (!empty($model)) {
                // $model->alias($alias);
                // $model->bind($bind);
            }

            foreach ($search as $k => $v) {
                if ($v['exp'] == 'where_day' || $v['exp'] == 'where_month' || $v['exp'] == 'where_year') {
                    $query->whereTime($v['name'], $v['value']);
                } else {
                    $query->where($v['name'], $v['exp'], $v['value']);
                }
            }
        };


        // $searcharr = is_array($searchfields) ? $searchfields : explode(',', $searchfields);
        // foreach ($searcharr as $k => &$v) {
        //     $v = stripos($v, ".") === false ? $aliasName . $v : $v;
        // }
        // unset($v);
        // $where[] = [implode("|", $searcharr), "LIKE", "%{$search}%"];


        $this->assign('LIMIT', $limit);

        return [$where, $limit, $page, $order, $key, $search];

        extract($config);

        $offset = ($page - 1) * $limit;
        $isJoin = false;

        // 生成查询条件
        $w = [];

        foreach ($where as $k => &$item) {
            switch ($item[1]) {
                case 'LIKE':
                    $item[2] = "%$item[2]%";
                    break;
            }
            if ($isJoin && !strpos($item[0], '.')) {
                $item[0] = $alias . $item[0];
            }
            $w[$k] = array($item[0], $item[1], $item[2]);
        }
        // if ($this->authValidate !== false && $this->auth->id !== 1) {
        //     $w[count($w)] = [$this->authValidate, '=', $this->auth->id];
        // }
        // 设置是否关联查询
        if (empty($this->with)) {
            $select = $model;
        } else {
            // 是否 带有关联查询
            foreach ($w as $k => $item) {
                if (strpos($item[0], '.')) {
                    $isJoin = true;
                    break;
                }
            }
            // 是否实际有关联查询条件  提升一定性能
            if ($isJoin) {
                $alias = $alias[$model->getTable()] = parse_name(basename(str_replace('\\', '/', get_class($model)))) . '.';
                $select = $model->withJoin($this->with);
                if (!strpos($key, '.')) {
                    $key = $alias . $key;
                }
                // 是否 带有关联查询
                foreach ($w as $k => $item) {
                    if (!strpos($item[0], '.')) {
                        $w[$k][0] = $alias . $item[0];
                        break;
                    }
                }
            } else {
                $select = $model->with($this->with);
            }
        }
        try {
            if ($select) {
                $select = $select->where($w)->where($defaultWhere);
            }
        } catch (\Throwable $th) {
            var_dump($select);
            exit;
        }

        // $total = $select->count();
        // $list = $select->order($key, $order)->limit($offset, $limit)->select()->toArray();
        // $res = ;

        return [$limit, $page, $order, $where, $key];
    }

    public function edit()
    {
        $pkValue = $this->request->param($this->model->getPk(), null);
        $row = $this->model->find($pkValue);

        if ($this->request->isAjax()) {
            // $data =   Request::only(['name', 'email']);
            $data = $this->request->param();
            $row->save($data);
            $this->success('res');
        }


        $this->fetch('', ['row' => $row]);
    }

    /**
     * 删除数据
     * 适配ST-Table组件 模型pk主键字段，需与ST-Table组件config.pk字段一致
     * @return Boolean
     */
    public function del()
    {
        $pkValue = $this->request->param($this->model->getPk(), null);
        if ($pkValue) {
            $row = $this->model->find($pkValue);
            if ($row) {
                $res = $row->delete();
                if ($res) {
                    $this->success('删除成功');
                } else {
                    $this->error('删除失败');
                }
            }
        }
        $this->error('未找到与主键' . $this->model->getPk() . '匹配的数据');
    }

    function switch()
    {
        if (!$this->switchAllowField) {
            $this->error('请先设置switchAllowField允许可切换字段');
        }
        $params = $this->request->param();
        if (isset($params[$this->model->getPk()])) {
            $row = $this->model->find($params[$this->model->getPk()]);
            $allowField = $this->switchAllowField;
            $allowField = is_string($allowField) && strstr($this->switchAllowField, ',') ? explode(',', $allowField) : $allowField;
            $allowField = is_string($allowField) ? [$allowField] : $allowField;
            if ($row) {
                // 不排除$params,可以更好的提示错误
                $res = $row->allowField($allowField)->force()->save($params);
                if ($res) {
                    $row = $this->model->find($params[$this->model->getPk()]);
                    $this->success('修改成功', ['row' => $row]);
                }
            }
        }
        $this->error('未找到与主键' . $this->model->getPk() . '匹配的数据');
    }
}
