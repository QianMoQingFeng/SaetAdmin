<?

declare (strict_types = 1);

namespace saet; // 注意命名空间规范

use app\admin\library\AdminAuth;
use think\Addons;
use think\App;
use think\exception\HttpResponseException;
use think\facade\Cookie;
use think\facade\Env;
use think\facade\View;
use think\Request;
use think\Response;

class AddonLib extends Addons
{


    
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
