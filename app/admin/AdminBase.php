<?php

declare(strict_types=1);

namespace app\admin; // 注意命名空间规范

use app\admin\library\AdminAuth;
use think\Addons;
use think\App;
use think\exception\HttpResponseException;
use think\facade\Cookie;
use think\facade\Env;
use think\facade\View;
use think\Request;
use think\Response;

class AdminBase extends Addons
{
    use \app\admin\library\AdminTrait, \saet\ToolTrait;
    // app 容器
    protected $app;
    // 请求对象
    protected $request;
    // 视图模型
    protected $view;
    //  默认模型
    protected $model = null;
    //权限容器
    protected $auth;

    //无需登录与鉴权的方法
    protected $noLogin = [];

    //需要登录但无需鉴权的方法
    protected $noAuth = [''];

    //布局模板
    protected $layout = '../app/admin/view/public/layout.html';

    //视图模版后缀
    protected $viewSuffix = 'vue';

    //视图渲染变量
    protected $viewData;

    protected $assignErrMsg = 'vars为SaetAdmin预留渲染变量，不允许vars作为渲染变量名！';

    protected $switchAllowField = null;
    /**
     * 构造器
     * @param App $app
     */
    public function __construct(App $app)
    {
        parent::__construct($app);

        $this->app = $app;

        $this->request = $app->request;
        $this->view = clone View::engine('Think');
        $viewConfig = ['view_suffix' => $this->viewSuffix, 'taglib_build_in' => 'saet\ComponentTagLib,cx'];
        if ($this->app->isDebug()) {
            $viewConfig['tpl_cache'] = false;
        }

        $this->view->config($viewConfig);
        $this->view->layout($this->layout);
        $this->auth = AdminAuth::instance();

        if (!defined('IS_ADDON')) {
            define('IS_ADDON', false);
        }
        $config = [
            'isAdoon' => IS_ADDON,
            'addonName' => IS_ADDON ? $this->getAddonName() : false
        ];


        define('__CONFIG__', $config);
        if ($this->request->isAjax() == false) {


            $admin_theme_list = \app\admin\model\Config::where('group', 'admin_theme')->select();
            $adminTheme = [];
            foreach ($admin_theme_list as $key => $value) {
                if (substr($value['value'], 0, 1) == '{' && substr($value['value'], -1) == '}') {
                    $value['value'] = json_decode($value['value'], true);
                }
                $adminTheme[$value['name']] = $value['value'];
            }

            // dump($adminTheme);

            // $adminTheme = [
            //     'theme' => Env::get('stadmin.theme'),
            //     'color' => Env::get('stadmin.color'),
            //     'side_type' => 'float',
            //     'menu_type' => 'main',
            //     'menu' => ['collapse' => false, 'minimize' => false],
            //     'submenu' => ['collapse' => false],
            // ];
            // dump($adminTheme);

            $userAdminTheme = Cookie::get('admin_theme', $adminTheme);
            if (is_string($userAdminTheme)) {
                $userAdminTheme = json_decode($userAdminTheme, true);
            }

            $this->assign('adminTheme', $userAdminTheme);

            // $apiContUrl = $this->request->domain() . $this->request->root() . '/' . ($this->getAddonModule() ? $this->getAddonName() . '@admin/' : '') . $this->request->controller();
            // $apiBaseUrl = $this->request->domain() . $this->request->root() . '/' . ($this->getAddonModule() ? $this->getAddonName() . '@admin/' : '');
            $apiRootUrl = $this->request->domain() . $this->request->root() . '/';
            $apiContUrl = $this->request->domain() . $this->request->root() . '/' . (IS_ADDON ? __CONFIG__['addonName'] . '/' : '')  . $this->request->controller();
            $apiBaseUrl = $this->request->domain() . $this->request->root() . '/';
            $this->assign('apiContUrl', $apiContUrl);
            $this->assign('apiBaseUrl', $apiBaseUrl);
            $this->assign('apiRootUrl', $apiRootUrl);
        }


        // 兼容插件Admin模型

        $this->assign('__CONFIG__', __CONFIG__);
        if (IS_ADDON) {
            $view_path = $app->addons->getAddonsPath() . $this->getAddonName()  . '/admin/view' . DIRECTORY_SEPARATOR;
            $this->view->config([
                'view_path' => $view_path,
            ]);
        }


        // 初始化模型
        $this->setModel();

        $this->__initialize();
    }

    // 初始化
    protected function __initialize()
    {

        $token = $this->request->param('token', Cookie::get('token')) ?? $this->request->server('HTTP_TOKEN');
        $this->auth->init($token);

        $path = $this->request->pathinfo();

        $this->assign('rule', $path);

        $this->assign('admin', false);

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
            if ($this->auth->checkAction($this->noAuth) == false && !in_array('*', $this->auth->getRuleIds())) {
                $ruleId = \app\admin\model\admin\Rule::cache(true)->where('url', $path)->value('id');
                if (!in_array($ruleId, $this->auth->getRuleIds())) {
                    echo '你没有权限';
                    exit;
                }
            }
        }
        $onlySelf = $this->request->get('self', false);
        if ($onlySelf == false && !$this->request->isAjax() && $path !== 'index/login' && $path !== 'index/index') {
            $url = $this->request->baseFile() . '/index/index';
            echo "<script type='text/javascript'>window.location.href='$url'</script>";
            die;
        }

        $this->initialize();
    }
    public function initialize()
    {
    }


    protected function setModel($model = null)
    {

        if ($model) {
            if (is_object($model)) {
                $this->model = new $model;
            }
            if (is_string($model)) {
                $this->model = new $model();
            }
        } else {
            if (is_string($this->model)) {
                $this->model = new $this->model();
                return $this->model;
            }

            $controller = $this->request->controller();
            if (strpos($controller, '.') !== false) {
                $str = explode('.', $controller);
                $controller = $str[0] . '/' . $str[1];
            }
            $root = $this->getAddonName() ? 'addons/' . $this->getAddonName() : 'app';

            $model_this = str_replace('/', '\\', $root . '/' . app('http')->getName() . '/model/' . $controller);
            $model_common = str_replace(app('http')->getName(), $this->getAddonName() ? '' : 'common', $model_this);;
            try {
                $this->model = new $model_this();
            } catch (\Throwable $th) {
                try {
                    $this->model = new $model_common();
                } catch (\Throwable $th) {
                    $msg = "$model_this or $model_common not found";
                    return $msg;
                }
            }
        }
        return $this->model;
    }

    public function install()
    {
        return true;
    }

    /**
     * 插件卸载方法
     * @return bool
     */
    public function uninstall()
    {
        return true;
    }
}
