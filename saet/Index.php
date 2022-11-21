<?php

namespace saet;

use Closure;
use think\App;
use think\facade\Cache;
use think\Lang;
use think\Request;
use think\Response;
use think\route\RuleItem;

class Index
{

    protected $app;
    protected $lang;

    public function __construct(App $app, Lang $lang)
    {
        $this->app    = $app;
        $this->lang   = $lang;
    }
    /**
     * 路由初始化（路由规则注册）
     * @access public
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, Closure $next)
    {

        define('DS', DIRECTORY_SEPARATOR);
        define('ROOT_PATH', root_path());
        define('APP_PATH', app_path());
        define('PUBLIC_PATH', public_path());
        define('RUNTIME_PATH', runtime_path());
        define('CONFIG_PATH', config_path());
        define('BASE_PATH', base_path());
        define('SAET_PATH', ROOT_PATH . 'saet/');

        // 检测是否安装
        $installUrl = '/install.html';
        $isInstalled = file_exists(SAET_PATH . 'install/installed.lock');
        // 
        if ($isInstalled == false && $installUrl != $request->server('REQUEST_URI')) {
            header("Location: $installUrl");
            exit;
        }

        // 安装引导
        \think\facade\Route::any('install', function () {
            request()->setAction('install');
            (new \saet\install\Handle(app()))->install();
        });

        // 生成前端语言文件 
        \think\facade\Route::any('/[:type]_static/[:addon]/lang/', function ($type, $addon) {
            // 首次创建前端语言包，单独路由速度大于控制器
            if ($type == 'addons' || $type == 'app') {
                $controller = str_replace('/' . pathinfo(request()->pathinfo(), PATHINFO_BASENAME), '', str_replace("$type/$addon/lang/", '', request()->pathinfo()));
                $lang = pathinfo(request()->pathinfo(), PATHINFO_FILENAME);
                $langPathList = [];
                if ($type == 'app') {
                    array_push($langPathList, $type . '/' . $addon . '/lang/' . $lang . '.php');
                    array_push($langPathList, $type . '/' . $addon . '/lang/' . $controller . '/' . $lang . '.php');
                } else if ($type == 'addons') {
                    preg_match_all('/\@(.*?)\//', request()->pathinfo(), $res);
                    if (isset($res[1][0])) {
                        $module = $res[1][0];
                        $controller = str_replace('@' . $module . '/', '', $controller);
                        array_push($langPathList, $type . '/' . $addon . '/' . $module . '/lang/' . $lang . '.php');
                        array_push($langPathList, $type . '/' . $addon . '/' . $module . '/lang/' . $controller . '/' . $lang . '.php');
                    } else {
                        array_push($langPathList, $type . '/' . $addon . '/lang/' .  $lang . '.php');
                        array_push($langPathList, $type . '/' . $addon . '/lang/' . $controller . '/' . $lang . '.php');
                    }
                }
                $langArray = [];
                foreach ($langPathList as $key => $url) {
                    if (is_file(ROOT_PATH . $url)) {
                        $v = include ROOT_PATH . $url;
                        $langArray = array_merge($langArray, $v);
                    }
                }
                $path = ROOT_PATH . 'public/' . pathinfo(request()->pathinfo(), PATHINFO_DIRNAME);
                //判断是否是目录
                if (!is_dir($path)) {
                    mkdir($path, 0755, true);
                }
                Cache::set('/' . request()->pathinfo(), md5(json_encode($langArray)));
                $langStr = 'LANG["' . $lang . '"]=' . json_encode($langArray);
                file_put_contents(ROOT_PATH . 'public/' . request()->pathinfo(), $langStr);
                header('Content-Type: application/javascript');
                echo $langStr;
            }
            exit;
        })->ext('js');
        return $next($request);
    }
}
