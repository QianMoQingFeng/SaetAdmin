<?php

namespace saet;

use think\template\TagLib;

class ComponentTagLib extends TagLib
{
    /**
     * 定义标签列表
     */
    protected $tags   =  [
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'component' => ['attr' => 'is', 'close' => 0]
    ];

    protected $componentList = [];
    protected $defindedList = [];
    public function __construct($template)
    {
        parent::__construct($template);
        foreach (scandir(__DIR__ . '/component') as $key => $value) {
            $isVue = \think\helper\Str::endsWith($value, '.vue');
            if ($isVue) {
                array_push($this->componentList, $value);
            }
        }
    }

    public function tagComponent($tag)
    {
        $parse = self::import($tag['is']);
        $parse = preg_replace('/<!--(.|\s)*?-->/', '', $parse); //删除注释
        return $parse;
    }

    public function import($list)
    {
        if (is_string($list)) $list = explode(',', $list);
        $res = '';
        foreach ($list as $key => $value) {
            if (in_array($value . '.vue', $this->componentList) && !in_array($value, $this->defindedList)) {
                $content = file_get_contents(__DIR__ . '/component/' . $value . '.vue');
                $preg = '/{component is="(.*?)"\/}/';
                $res .= $content;
                preg_match_all($preg, $content, $importCom);
                if (count($importCom[1]) > 0) {
                    foreach ($importCom[0] as $key => $value) {
                        $res = str_replace($value, '', $res);
                        $res .= self::import($importCom[1][$key]);
                    }
                }
            }
        }
        $this->defindedList = array_merge($this->defindedList, $list);
        return $res;
    }
}
