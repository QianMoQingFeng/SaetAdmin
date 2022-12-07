<?php

declare(strict_types=1);

namespace app\admin; // 注意命名空间规范

use think\Addons;
use think\App;
use think\exception\HttpResponseException;
use think\facade\Cookie;
use think\facade\Env;
use think\facade\View;
use think\Request;
use think\Response;
use think\Lang;
use saet\Controller;
use Symfony\Component\VarDumper\Server\DumpServer;

class AdminBase extends Controller
{
    use \app\admin\library\AdminTrait, \app\admin\library\AdminAuthTrait, \app\admin\library\SaetVueTrait;

    //  默认模型
    protected $model = null;
    protected $model_path = null;

    protected $view_layout = '../app/admin/view/public/layout.html';

    /**
     * 构造器
     * @param App $app
     */
    public function __construct(App $app)
    {


        parent::__construct($app);

        // 初始化模型
        $this->setModel();
        $this->initAdminAuthTrait();
        $this->InitSaetVueTrait();

        $config = [
            'isAdoon' => IS_ADDON,
            'addonName' => IS_ADDON ? $this->getAddonName() : false,
            'lang' => env('lang.DEFAULT_LANG')
        ];


        define('CONFIG', $config);

        if ($this->request->isAjax() == false) {
            $admin_theme_list = \app\admin\model\Config::where('group', 'admin_theme')->select();

            $adminTheme = [];
            foreach ($admin_theme_list as $key => $value) {
                if (substr($value['value'], 0, 1) == '{' && substr($value['value'], -1) == '}') {
                    $value['value'] = json_decode($value['value'], true);
                }
                $adminTheme[$value['name']] = $value['value'];
            }

            $userAdminTheme = Cookie::get('admin_theme', $adminTheme);
            if (is_string($userAdminTheme)) {
                $userAdminTheme = json_decode($userAdminTheme, true);
            }
            $this->assign('adminTheme', $userAdminTheme);
            $apiRootUrl = $this->request->domain() . $this->request->root() . '/';
            $apiContUrl = $this->request->domain() . $this->request->root() . '/' . (IS_ADDON ? 'addons/' . CONFIG['addonName'] . '/' : '')  . $this->request->controller();
            $baseUrl = $this->request->domain() . $this->request->root() . '/';
            $this->assign('apiContUrl', $apiContUrl);
            $this->assign('baseUrl', $baseUrl);
            $this->assign('apiRootUrl', $apiRootUrl);
        }

        // 兼容插件Admin模型
        $this->assign('CONFIG', CONFIG);

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
            if (is_string($this->model_path)) {
                $this->model = new ($this->model_path);
                return $this->model;
            }

            $controller = $this->request->controller();
            

            if (strpos($controller, '.') !== false) {
                $str = explode('.', $controller);
                $controller = $str[0] . '/' . \think\helper\Str::studly($str[1]);
            }else{
                $controller = \think\helper\Str::studly( $controller);
            }

            // $root = $this->getAddonName() ? 'addons/' . $this->getAddonName() : 'app';

            // $model_this = str_replace('/', '\\', $root . '/' . app('http')->getName() . '/model/' . $controller);
            // $model_common = str_replace(app('http')->getName(), $this->getAddonName() ? '' : 'common', $model_this);;

            $root         = IS_ADDON ? 'addons/' . $this->getAddonName() : 'app';
            $model_this   = str_replace('/', '\\', $root . '/' . app('http')->getName() . '/model/' . $controller);
            $model_common = str_replace(app('http')->getName(), 'common', $model_this);
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
}
