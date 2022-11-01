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

trait AddonTrait
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

    public function initialize(){
        echo 1;
    }

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



}
