<?php

namespace addons\edoc\controller;

require __DIR__ . '/../vendor/autoload.php';

use addons\edoc\model\EdocItem;
use Erusev\Parsedown\Parsedown;
// use addons\edoc\controller\Base;x`
use addons\edoc\Plugin;



class Doc extends Plugin
{
    protected $view_suffix = 'vue';

    public function index()
    {

        $diyname = is_numeric($this->request->param('diyname')) ? intval($this->request->param('diyname')) : $this->request->param('diyname');

        $field = 'id,pid,title,diyname,group_id';
        if ($diyname) {
            $row = EdocItem::where(is_numeric($diyname) ? ['id' => $diyname] : ['diyname' => $diyname])->field($field)->find();
            $this->assign('row', $row);
        }

        $menuList = EdocItem::with('group')->field($field)->select()->toArray();
        $menuListTree = $menuList ? array_values(listToTree($menuList, 'children')) : [];
        $openAllMenu = [];
        foreach ($menuListTree as $key => $value) {
            if ($value['children']) {
                array_push($openAllMenu, strval($value['id']));
            }
        }
        $this->assign('openAllMenu', $openAllMenu);
        $this->assign('menuList', $menuList);
        $this->assign('menuListTree', $menuListTree);

        $this->fetch();
    }

    public function item()
    {
        $id = $this->request->get('id');
        $Parsedown = new Parsedown();
        $doc = EdocItem::find($id);
        // $content = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $doc['src']);
        if ($doc) {
            $data =  $Parsedown->toHtml($doc['content']);
            // $data =  $doc['content'];
            $this->success('', $data);
        }
    }
}
