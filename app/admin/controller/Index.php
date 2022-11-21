<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\admin\AdminBase;
use app\admin\model\admin\Rule as AdminRule;
use saet\EnvLib;
use think\facade\Filesystem;
class Index extends AdminBase
{

    protected $noAuth = ['index'];
    protected $noLogin = ['login'];
    protected $noFrame = ['index','login'];

    public function index()
    {
        if($this->auth->isSuper()){
            $menuListOriginal = $menuList = AdminRule::select()->toArray();
        }else{
            $menuListOriginal = $menuList = AdminRule::select($this->auth->getRuleIds())->toArray();
        }

        $openMenu = null;
        $openRule = '';

        if (isset($_SERVER['HTTP_REFERER'])) {
            $referer = explode('.php/', $_SERVER['HTTP_REFERER']);
            if (isset($referer[1]) && $referer[1] != 'index/login') {
                $openRule = $referer[1];
                $whyIndex = strpos($openRule, '?');
                if ($whyIndex !== false) {
                    $openRuleAll = explode('?', $openRule);
                    $openRule = $openRuleAll[0];
                    $openUrlParam = $openRuleAll[1] ? $openRuleAll[1] : null;
                }
            }
        }
        
        $isRule = false;

        foreach ($menuList as $k => &$v) {
            $v['page_url'] = $v['url'];
            // 排除外链 设置参数
            if (!preg_match("/^http(s)?:\\/\\/.+/", $v['url'])) {
                $v['page_url'] = $v['nav_url'] = $this->request->baseFile() . '/' . $v['url'];

                // 设置参数
                $paramText = '';
                $linkSymbol = '&';
                $param = [];
                if (is_object($v['param']) && count((array) $v['param']) > 0) {
                    $param = array_merge($param, (array) $v['param']);
                }
                $i = 1;
                foreach ($param as $key => $value) {
                    if ($i == 1) {
                        $paramText .= '?';
                    }
                    if ($i == count($param)) {
                        $linkSymbol = '';
                    }
                    $paramText .= "$key=$value$linkSymbol";
                    $i++;
                }
                // 跟踪原地址参数
                if ($openRule && $v['url'] == $openRule && isset($openUrlParam)) {
                    $paramText .= ($paramText ? '&' : '?') . $openUrlParam;
                    $v['nav_url'] = $v['nav_url'] . ($openUrlParam ? '?' : '') . $openUrlParam;
                }
                $v['page_url'] = $v['page_url'] . $paramText . ($paramText ? '&_self=1' : '?_self=1');

                if ($openRule && $v['url'] == $openRule) {
                    $openMenu = $v;
                    $isRule = true;
                }

            }
            // 处理溢出权限
            // if (!in_array($v['id'], $rule_ids) && $this->auth->rule_ids != 0) {
            //     unset($list[$k]);
            // }
        }
       
        // 没有在规则表中则 直接打开
        if (isset($_SERVER['HTTP_REFERER']) && $isRule === false && isset($referer[1]) && $referer[1] != 'index/login') {
            $url = $_SERVER['HTTP_REFERER'];
            if (strpos($url, '?')) {
                $url = $url . '&_self=1';
            } else {
                $url = $url . '?_self=1';
            }
            echo "<script type='text/javascript'>window.location.href='$url'</script>";
            die;
        }
        // dump($menuList);
      
        $menuListTree = $menuList ? array_values(listToTree($menuList, 'children')) : [];

        $openMenuIds = [];

        array_push($openMenuIds, 1);

        // 默认选项卡
        if ($openMenu) {
            array_push($openMenuIds,$openMenu['id']);
            // $openMenu = findInTree($menuList,$openMenu['id']);
        }
       
        $this->assign('menuListOriginal', $menuListOriginal);
        $this->assign('menuListTree', $menuListTree);
        $this->assign('openMenuIds', $openMenuIds);
        $this->fetch();
    }



    
    public function login($account = null, $password = null)
    {

        $refererUrl = $_SERVER['HTTP_REFERER'] ?? $this->request->baseFile() . '/index/index';
       
        $this->assign('refererUrl', $refererUrl);
        if ($this->auth->isLogin()) {
            echo '已经登录过了';
            echo "<script type='text/javascript'>window.location.href='$refererUrl'</script>";
            die;
        }
        if ($this->request->isAjax()) {
            if (!$account || !$password) {
                $this->error('参数未填写');
            }
            $login = $this->auth->login($account, $password);
            if ($login) {
                $admin = $this->auth->getAdminInfo();
                $this->success('login ok', $admin);
            } else {
                $this->error($this->auth->getError());
            }
        }
        $this->fetch();
    }
    
    public function logout()
    {

        $res = $this->auth->logout();
        if ($res) {
            $this->success('logout success');
        }
        $this->success('logout success');
    }

    /**
     * 上传文件
     */
    public function upload()
    {
        $file = $this->request->file('file');
        $name = $file->md5() . '.' . $file->getOriginalExtension();
        $save = Filesystem::disk('public')->putFileAs(Date('Y/m/d'), $file, $name);
        if ($save) {
            $this->success('', '/update/' . $save);
        } else {
            $this->error('上传失败');
        }
    }
}
