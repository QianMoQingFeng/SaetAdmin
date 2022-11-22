<?php

declare(strict_types=1);

namespace app\admin\controller;

use app\admin\AdminBase;

class Config extends AdminBase
{
    public function index()
    {
        $groupList = json_decode($this->model->where('name', 'group')->value('value'));
        $list = $this->model->order('weight asc')->select()->toArray();
        foreach ($list as $key => $value) {
            if (!isset($list2[$value['group']])) {
                $list2[$value['group']] = [];
            }
            array_push($list2[$value['group']], $value);
        }
        $res = ['groupList' => $groupList, 'configList' => $list2];

        if ($this->request->isAjax()) {
            success('', $res);
        }
        
        $this->assign($res);
        $this->fetch();
    }

    public function edit_value()
    {
        if ($this->request->isAjax()) {
            $data = $this->request->post('data');
            foreach ($data as $key => $value) {
                $row = $this->model->find($key);
                $row->value = $value;
                $row->save();
            }
            success('修改成功');
        }
    }

    public function add()
    {
        if ($this->request->isAjax()) {
            $data = $this->request->post('data');
            if (!isset($data['weight'])) {
                $data['weight'] = $this->model->max('weight') + 10;
            }
            $this->model->save($data);
            success('');
        }
    }

    public function edit()
    {
        if ($this->request->isAjax()) {
            $data = $this->request->post('data');
            $row = $this->model->find($data['name']);
            $row->save($data);
            success('');
        }
    }

    public function setAdminTheme()
    {
        if ($this->request->isAjax()) {
            $data = $this->request->post('data');
            $list = $this->model->where('group', 'admin_theme')->select();
            foreach ($list as $key => $row) {
                if (isset($data[$row['name']]) && $data[$row['name']] != $row['value']) {
                    $row->value = gettype($data[$row['name']]) == 'array' ? json_encode($data[$row['name']]) : $data[$row['name']];
                    $row->save();
                }
            }
            success('设置成功');
        }
    }
}
