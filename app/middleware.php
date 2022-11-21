<?php
// 全局中间件定义文件
return [
    // 全局请求缓存
    // \think\middleware\CheckRequestCache::class,

    // Session初始化
    // \think\middleware\SessionInit::class
    // 多语言加载
    // \think\middleware\LoadLangPack::class,
    // Saet入口
    \saet\Index::class
];
