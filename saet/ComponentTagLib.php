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
        'component' => ['attr' => 'is,url', 'close' => 0],
        'package' => ['attr' => 'is', 'close' => 0]
    ];

    protected $componentList = [];
    protected $defindedComponent = [];
    protected $defindedPackage = [];
    protected $defindedPackageUrl = [];

    protected $packages = [
        'nprogress' => [
            '/static/package/nprogress/nprogress.min.js',
            '/static/package/nprogress/nprogress.min.css'
        ],
        'vue' => [
            '/static/package/vue/vue.global.prod.js'
        ],
        'element-plus' => [
            'urls' => [
                '/static/package/element-plus/index.full.min.js',
                '/static/package/element-plus/icon.min.js',
                '/static/package/element-plus/index.min.css',
                '/static/package/element-plus/dark.min.css',
                '/static/package/element-plus/locale/zh-cn.min.js'
            ],
            'rely' => ['vue']
        ],
        'sortable' => [
            '/static/package/sortable/sortable.min.js'
        ],
        'axios' => [
            '/static/package/axios/axios.min.js'
        ],
        'remixicon' => [
            '/static/package/remixicon/remixicon.css'
        ],
        'saet' => [
            'urls' => [
                '/static/package/string/string.min.js',
                '/static/saet/js/common.min.js',
                '/static/saet/css/common.min.css'
            ],
            'rely' => ['vue', 'element-plus']
        ],
    ];

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
        if (isset($tag['is'])) {
            $parse = self::importComponent($tag['is']);
        } else if (isset($tag['url'])) {
            dump($tag['url']);
            $parse = self::importComponent($tag['url']);
        }
        $parse = preg_replace('/<!--(.|\s)*?-->/', '', $parse); //删除注释
        return $parse;
    }



    public function importComponent($list)
    {
        if (is_string($list)) $list = explode(',', $list);
        $res = '';
        foreach ($list as $key => $value) {
            if (in_array($value . '.vue', $this->componentList) && !in_array($value, $this->defindedComponent)) {
                $content = file_get_contents(__DIR__ . '/component/' . $value . '.vue');
                $preg = '/{component is="(.*?)"\/}/';
                $res .= $content;
                preg_match_all($preg, $content, $importCom);
                if (count($importCom[1]) > 0) {
                    foreach ($importCom[0] as $key => $value) {
                        $res = str_replace($value, '', $res);
                        $res .= self::importComponent($importCom[1][$key]);
                    }
                }
            }
        }
        $this->defindedComponent = array_merge($this->defindedComponent, $list);
        return $res;
    }
    public function tagPackage($tag)
    {
        if (isset($tag['is'])) {
            $list = explode(',', $tag['is']);
            self::importPackage($list);
        }

        $res = $this->getPackageUrls($this->defindedPackage);

        return $res;
        // if (isset($tag['is'])) {
        //     $parse = self::import($tag['is']);
        // } else if (isset($tag['url'])) {
        //     dump($tag['url']);
        //     $parse = self::import($tag['url']);
        // }
        // $parse = preg_replace('/<!--(.|\s)*?-->/', '', $parse); //删除注释
        // return $parse;
    }
    public function importPackage($list)
    {


        foreach ($list as $key => $packname) {
            // dump(in_array($packname, $this->defindedPackage));
            // dump($packname);
            // dump($this->packages[$packname]);

            if (in_array($packname, $this->defindedPackage)) continue;

            if (isset($this->packages[$packname]['rely'])) {
                self::importPackage($this->packages[$packname]['rely']);
            }
            // $this->defindedPackage = array_merge($this->defindedPackage, [$packname]);
            array_push($this->defindedPackage,$packname);
        }
    }
    public function getPackageUrls($packs)
    {
        $res = '';
        foreach ($packs as $key => $packname) {
            $packurls = $this->packages[$packname]['urls'] ?? $this->packages[$packname];

            foreach ($packurls as $key => $url) {
                // <script src="/static/package/nprogress/nprogress.min.js"></script>
                // <link rel="stylesheet" href="/static/package/nprogress/nprogress.min.css">
                if (strrpos($url, '.js')) {
                    $res .= '<script src="' . $url . '"></script>';
                } else if (strrpos($url, '.css')) {
                    $res .= '<link rel="stylesheet" href="' . $url . '">';
                }
            }
        }
        return $res;
    }
}
