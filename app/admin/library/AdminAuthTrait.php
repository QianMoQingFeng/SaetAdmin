<?php

namespace app\admin\library;

use think\facade\Cookie;
use app\admin\library\AdminAuth;

trait AdminAuthTrait
{
    //权限容器
    protected $auth;
    //Admin
    protected $admin;
    //无需登录与鉴权的方法
    protected $noLogin = [];
    //需要登录但无需鉴权的方法
    protected $noAuth = [''];
    // 无需添加外层框架
    protected $noFrame = [];
    public function initAdminAuthTrait()
    {

        $path = $this->request->pathinfo();
        $this->assign('rule', $path);

        $this->auth = AdminAuth::instance();
        $token = $this->request->param('token', Cookie::get('token')) ?? $this->request->server('HTTP_TOKEN');
        $this->auth->init($token);

        
        // 是否需要登录
        if (!$this->auth->checkAction($this->noLogin)) {
            //是否登录
            if ($this->auth->isLogin()) {
                $this->assign('admin', $this->auth->getAdminInfo());
            } else {
                $url = $this->request->baseFile() . '/index/login';
                echo "<script type='text/javascript'>window.location.href='$url'</script>";
                exit;
            }
            // 判断是否需要验证权限
            if ($this->auth->checkAction($this->noAuth) == false && !$this->auth->isSuper()) {
                $ruleId = \app\admin\model\admin\Rule::cache(true)->where('url', $path)->value('id');
                if (!in_array($ruleId, $this->auth->rule_ids)) {
                    echo '你没有权限';
                    exit;
                }
            }
        }

        $self = $this->request->get('_self', false);

        if ($self == false && $this->request->isAjax() == false && $this->auth->checkAction($this->noFrame) == false) {
            $url = $this->request->baseFile() . '/index/index';
            echo "<script type='text/javascript'>window.location.href='$url'</script>";
            die;
        }
    }
}
