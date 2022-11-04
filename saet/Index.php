<?php

namespace saet;

use Closure;
use think\App;
use think\Config;
use think\Cookie;
use think\Lang;
use think\Request;
use think\Response;

class Index
{
    /**
     * 路由初始化（路由规则注册）
     * @access public
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, Closure $next)
    {
        $installUrl = '/install.html';
        $isInstalled = file_exists(__DIR__ . '/installed.lock');
        if ($isInstalled == false && $installUrl != $request->server('REQUEST_URI')) {
            header("Location: $installUrl");
            exit;
        }
        \think\facade\Route::get('install', '\saet\core\install\Handle@install');
        return $next($request);
    }
}
