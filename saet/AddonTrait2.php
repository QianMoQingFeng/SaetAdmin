<?

declare(strict_types=1);

namespace saet; // 注意命名空间规范

use think\Addons;
use think\App;
use think\exception\HttpResponseException;
use think\facade\Cookie;
use think\facade\Env;
use think\facade\View;
use think\Request;
use think\Response;

trait AddonTrait2
{

    // app 容器
    protected $app;
    // 请求对象
    protected $request;
    // 视图模型
    protected $view;
    //权限容器
    protected $auth;
    //无需登录与鉴权的方法
    protected $noLogin = [];
    //需要登录但无需鉴权的方法
    protected $noAuth = [''];
    //视图模版后缀
    protected $viewSuffix = 'vue';
    //视图渲染变量
    protected $viewData;
    // vars变量提示
    protected $assignErrMsg = 'vars为SaetAdmin预留渲染变量，不允许vars作为渲染变量名！';

    protected $layout = '../addons/edoc/view/public/layout.html';

public function __construct(App $app){

}

    /**
     * 构造器
     * @param App $app
     */
    // public function __construct(App $app)
    // {
    //     $this->app = $app;
    //     $this->request = $app->request;
    //     $this->view = clone View::engine('Think');
    //     $viewConfig = ['view_suffix' => $this->viewSuffix, 'taglib_build_in' => 'saet\TagLib,cx'];
    //     if ($this->app->isDebug()) {
    //         $viewConfig['tpl_cache'] = false;
    //     }
    //     $this->view->config($viewConfig);
    //     $this->view->layout($this->layout);
    //     if ($this->getAddonName() != 'admin') {
    //         $view_path = $app->addons->getAddonsPath() . $this->getAddonName() . ($this->getAddonModule() ? '/' . $this->getAddonModule() : '') . '/view' . DIRECTORY_SEPARATOR;
    //         $this->view->config([
    //             'view_path' => $view_path,
    //         ]);
    //     }
    //     $this->_initialize();
    // }

   

    // 初始化
    protected function _initialize()
    {

        $token = $this->request->param('token', Cookie::get('token')) ?? $this->request->server('HTTP_TOKEN');
        // $this->auth->init($token);

        $path = $this->request->pathinfo();

        $this->assign('rule', $path);

        $this->assign('user', false);

        // 是否需要登录
        // if (!$this->auth->checkAction($this->noLogin)) {
        //     //是否登录
        //     if ($this->auth->isLogin()) {
        //         $this->assign('user', $this->auth->getAdminInfo());
        //     } else {
        //         $url = $this->request->baseFile() . '/admin/login';
        //         echo "<script type='text/javascript'>window.location.href='$url'</script>";
        //         exit;
        //     }
        //     // 判断是否需要验证权限
        //     if ($this->auth->checkAction($this->noAuth) == false && !in_array('*', $this->auth->getRuleIds())) {
        //         $ruleId = \app\admin\model\AdminRule::cache(true)->where('url', $path)->value('id');
        //         if (!in_array($ruleId, $this->auth->getRuleIds())) {
        //             echo '你没有权限';
        //             exit;
        //         }
        //     }
        // }

        $this->initialize();
    }
  

    /**
     * 加载模板输出
     * @param string $template
     * @param array $vars           模板文件名
     * @return false|mixed|string   模板输出变量
     * @throws \think\Exception
     */
    protected function fetch($template = '', $vars = [], $viewSuffix = null)
    {
        if ($this->request->isAjax()) {
            $this->error('ajax访问，fetch无法返回有效值');
        }
        if ($viewSuffix) {
            $this->view->config(['view_suffix' => $viewSuffix]);
        }
        if (count($vars) && in_array('vars', array_keys($vars))) {
            throw new \think\Exception($this->assignErrMsg, 10006);
        }
        $this->view->fetch($template, $vars);
    }

    /**
     * 渲染内容输出
     * @access protected
     * @param  string $content 模板内容
     * @param  array  $vars    模板输出变量
     * @return mixed
     */
    protected function display($content = '', $vars = [])
    {
        if (count($vars) && in_array('vars', array_keys($vars))) {
            throw new \think\Exception($this->assignErrMsg, 10006);
        }
        return $this->view->display($content, $vars);
    }

    /**
     * 渲染变量输出
     * @access protected
     * @param  string|array $name    变量名
     * @param  string  $vars         模板输出变量
     * @return mixed
     */
    protected function assign($name, $value = null)
    {
        $data = [];
        if (is_array($name)) {
            if (in_array('vars', array_keys($name))) {
                throw new \think\Exception($this->assignErrMsg, 10006);
            }
            $data = array_merge($data, $name);
        } else {
            if ($name === 'vars') {
                throw new \think\Exception($this->assignErrMsg, 10006);
            }
            $data[$name] = $value;
        }
        return $this->view->assign($data);
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


    /**
     * 操作成功返回的数据
     * @param string $msg    提示信息
     * @param mixed  $data   要返回的数据
     * @param int    $code   错误码，默认为1
     * @param string $type   输出类型
     * @param array  $header 发送的 Header 信息
     */
    protected function success($msg = '', $data = null, $code = 1, $type = null, array $header = [])
    {
        $this->result($msg, $data, $code, $type, $header);
    }

    /**
     * 操作失败返回的数据
     * @param string $msg    提示信息
     * @param mixed  $data   要返回的数据
     * @param int    $code   错误码，默认为0
     * @param string $type   输出类型
     * @param array  $header 发送的 Header 信息
     */
    protected function error($msg = '', $data = null, $code = 0, $type = null, array $header = [])
    {
        $this->result($msg, $data, $code, $type, $header);
    }
    /**
     * 返回封装后的API数据到客户端
     * @access protected
     * @param  mixed $data 要返回的数据
     * @param  integer $code 返回的code
     * @param  mixed $msg 提示信息
     * @param  string $type 返回数据格式
     * @param  array $header 发送的Header信息
     * @return void
     */
    protected function result($msg, $data = null, $code = 0, $type = null, array $header = [])
    {
        $result = [
            'code' => $code,
            'msg' => $msg,
            // 'time' => Request::instance()->server('REQUEST_TIME'),
            'data' => $data,
        ];
        // 如果未设置类型则自动判断
        $type = $type ? $type : ($this->request->param(config('var_jsonp_handler')) ? 'jsonp' : $this->getResponseType());

        if (isset($header['statuscode'])) {
            $code = $header['statuscode'];
            unset($header['statuscode']);
        } else {
            //未设置状态码,根据code值判断
            $code = $code >= 1000 || $code < 200 ? 200 : $code;
        }
        $response = Response::create($result, $type, $code)->header($header);
        throw new HttpResponseException($response);
        die;
    }
    /**
     * 获取当前的response 输出类型
     * @access protected
     * @return string
     */
    protected function getResponseType()
    {
        return $this->request->isJson() || $this->request->isAjax() ? 'json' : 'html';
    }
}
