<?php

namespace app\admin\library;

use think\helper\Str;

trait AdminTrait
{
    // DataTrait
    protected $switchAllowField = null;
    protected $with = [];


    public function index()
    {

        list($where, $limit, $page, $search) = $this->buildSearch();

        $model = $this->model;
        if (!empty($this->with)) {
            $model = $model->with($this->with);
        }

        if ($this->request->param('_label')) {
            $model = $model->field($this->request->param('_label'));;
        }

        $m = $model->where($where)->paginate(['list_rows' => $limit, 'page' => $page]);
        $res = ['list' => $m->items(), 'total' => $m->total()];

        if ($this->request->isAjax()) {
            success('res', $res);
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
            array_push($search, ['name',  "%$fastValue%",  'like']);
        }

        // success('',$search);

        $where = function ($query) use ($search, $alias, $bind, &$model) {
            if (!empty($model)) {
                // $model->alias($alias);
                // $model->bind($bind);
            }

            if (is_array($search)) {
                foreach ($search as $k => $v) {
                    $name  = $v[0];
                    $value = $v[1];
                    $exp   = $v[2];
                    if ($exp == 'where_day' || $exp == 'where_month' || $exp == 'where_year') {
                        $query->whereTime($v['name'], $v['value']);
                    } else {
                        $query->where($name, $exp, $value);
                    }
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

        // ??????????????????
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
        // ????????????????????????
        if (empty($this->with)) {
            $select = $model;
        } else {
            // ?????? ??????????????????
            foreach ($w as $k => $item) {
                if (strpos($item[0], '.')) {
                    $isJoin = true;
                    break;
                }
            }
            // ?????????????????????????????????  ??????????????????
            if ($isJoin) {
                $alias = $alias[$model->getTable()] = parse_name(basename(str_replace('\\', '/', get_class($model)))) . '.';
                $select = $model->withJoin($this->with);
                if (!strpos($key, '.')) {
                    $key = $alias . $key;
                }
                // ?????? ??????????????????
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
            $data = $this->request->param();
            ($row ?? $this->model)->save($data);
            success('????????????');
        }

        $this->fetch('', ['row' => $row]);
    }

    /**
     * ????????????
     * ??????ST-Table?????? ??????pk?????????????????????ST-Table??????config.pk????????????
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
                    success('????????????');
                } else {
                    error('????????????');
                }
            }
        }
        error('??????????????????' . $this->model->getPk() . '???????????????');
    }

    function switch()
    {
        if (!$this->switchAllowField) {
            error('????????????switchAllowField?????????????????????');
        }
        $params = $this->request->param();
        if (isset($params[$this->model->getPk()])) {
            $row = $this->model->find($params[$this->model->getPk()]);
            $allowField = $this->switchAllowField;
            $allowField = is_string($allowField) && strstr($this->switchAllowField, ',') ? explode(',', $allowField) : $allowField;
            $allowField = is_string($allowField) ? [$allowField] : $allowField;
            if ($row) {
                // ?????????$params,???????????????????????????
                $res = $row->allowField($allowField)->force()->save($params);
                if ($res) {
                    $row = $this->model->find($params[$this->model->getPk()]);
                    success('????????????', ['row' => $row]);
                }
            }
        }
        error('??????????????????' . $this->model->getPk() . '???????????????');
    }
}
