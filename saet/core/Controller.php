<?

namespace saet\core;

use saet\Lang as SaetLang;
use think\App;
use think\facade\View;
use think\Addons;
use think\facade\Cache;
use think\facade\Lang;

class Controller  extends Addons
{
    // 全部成员属性

    // app 容器
    protected $app;
    // 请求对象
    protected $request;
    // 当前插件标识
    protected $name;
    // 插件路径
    protected $addon_path;
    // 视图模型
    protected $view;
    // 模版后缀
    protected $view_suffix = 'vue';
    // 视图layout
    protected $view_layout;
    // 模块信息
    protected $addon_module = '';
    // 模块信息
    protected $controller_path = '';

    public function __construct(App $app)
    {
        parent::__construct($app);

        $this->loadLang();
    }

    // 加载目录
    private function loadLang()
    {

        $controller = str_replace('/_', '/', parse_name(str_replace('.', '/', $this->request->controller())));
        if (!$controller)  if (!defined('LANG_URL')) return define('LANG_URL', false);

        if (!defined('LANG_URL')) define('LANG_URL', (IS_ADDON ? '/addons_static' . '/' . $this->name . '/lang/' . ($this->addon_module ? '@' . $this->addon_module . '/' : '')  . $controller : '/app_static' . '/' . app('http')->getName() . '/lang/' . $controller) . '/' . $this->app->lang->getLangSet() . '.js');
        $langMd5 = Cache::get(LANG_URL, false);
        $langArray = [];
        if (IS_ADDON) {
            if ($this->addon_module) {
                array_push($langArray, $this->app->addons->getAddonsPath() . $this->name . DS . ($this->addon_module ? $this->addon_module . DS  : '') . 'lang' . DS . $this->app->lang->getLangSet() . '.php');
            } else {
                array_push($langArray, $this->app->addons->getAddonsPath() . $this->name . DS . 'lang' . DS . $this->app->lang->getLangSet() . '.php');
            }
            array_push($langArray,  $this->app->addons->getAddonsPath() . $this->name . DS . ($this->addon_module ? $this->addon_module . DS : '') . 'lang' . DS . $controller . DS .  $this->app->lang->getLangSet() . '.php');
        } else {
            // 加载app中控制器语言包
            $langArray = [app_path() . 'lang' . DS . $this->app->lang->getLangSet() . '.php', app_path() . 'lang' . DS .  $controller . DS . $this->app->lang->getLangSet() . '.php'];
        }
        // 写入语言包并返回传入的语言
        $SaetLang = new SaetLang($this->app);
        $addLangArr = $SaetLang->loadLang($langArray);
        $this->controller_path = IS_ADDON ? 'addons' . '/' . $this->name . ($this->addon_module ? '@' . $this->addon_module : '') . '/' . $controller : 'app' . '/' . app('http')->getName() . '/' . $controller;
        $langStr = json_encode($addLangArr);
        // 只对比覆盖，新增由路由操作
        if ($langMd5 !== false && $langMd5 != md5($langStr)) {
            // 刷新语言包
            Cache::set(LANG_URL, md5($langStr));
            $path = root_path() . 'public' . pathinfo(LANG_URL, PATHINFO_DIRNAME);
            $filepath =  root_path() . 'public' . LANG_URL;
            // 判断是否是目录
            if (!is_dir($path))  mkdir($path, 0755, true);
            // 创建新的语音文件
            file_put_contents($filepath, 'LANG["' .  $this->app->lang->getLangSet() . '"]=' . $langStr);
        }
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
