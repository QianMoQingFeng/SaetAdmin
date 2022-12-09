<?php

declare(strict_types=1);

namespace saet;

use app\common\library\Token;
use think\exception\ValidateException;
use think\facade\Cookie;
use think\facade\Db;
use think\facade\Validate;

class Auth
{
    protected static $instance = null;
    protected $authType        = '';
    protected $authKey         = '';
    protected $authModel       = null;
    protected $allowFields     = '';     //true 表示全部允许
    protected $isSuper         = false;
    protected $info            = [];
    protected $token;


    public static function instance($options = [])
    {
        if (is_null(self::$instance)) self::$instance = new static([$options]);
        return self::$instance;
    }


    // 初始化
    public function init($token, $authType, $allowFields = '')
    {
        $this->authType    = $authType;
        $this->authKey     = substr($authType, 0, 1) . 'id';
        $this->allowFields = $allowFields;

        // 设置authModel
        $model = ['admin' => 'app\admin\model\Admin', 'user' => 'app\common\model\User'];
        $this->authModel = new ($model[$authType]);
        if ($token) {
            $res = Token::checkToken($token, $authType);
            if ($res['status'] == true) {
                $this->token = $token;
                $this->easyLogin($res['auth_id']);
            } else {
                // Cookie::delete('token');
                return $this->setError($res['message']);
            }
        }
        return true;
    }


    /**
     * 直接登录账号
     * @param int $aid
     * @return boolean
     */
    public function easyLogin($auth_id)
    {
        $info = $this->authModel->find($auth_id)->toArray();

        if ($info) {
            $info['token']    = $this->token;
            $info['groups']   = Db::name($this->authType . '_group')->select(explode(',', $info['group_ids']))->toArray();
            $this->info = $info;
            $this->info['rule_ids'] = $this->getRuleIds();
            $this->loginStatus = true;
            return $this->getInfo();
        } else {
            return $this->setError('admin is not found');
        }
    }



    public function getRuleIds()
    {

        $rule_ids = [];
        foreach ($this->info['groups'] as $key => $value) {
            $rule_ids = array_merge(explode(',', $value['rule_ids']), $rule_ids);
        }
        if (in_array('*', $rule_ids)) {
            $this->isSuper = true;
        }
        return $rule_ids;
    }

    /**
     * @description:获取会员基本信息
     */
    public function getInfo()
    {
        $info = $this->info;
        if (is_string($this->allowFields)) $this->allowFields = explode(',', $this->allowFields);
        if ($this->allowFields !== true && is_array($this->allowFields)) {
            $info = array_intersect_key($info, array_flip($this->allowFields));
        }
        return $info;
    }


    public function login($account, $password)
    {
        $field = Validate::is($account, 'email') ? 'email' : (Validate::regex($account, '/^1\d{10}$/') ? 'mobile' : 'username');
        $info = Db::name($this->authType)->where([$field => $account])->find();
        if ($info) {
            $passLen = strlen($password);
            if ($info['password'] != self::getEncryptPassword($password, $info['salt']) && $passLen < 30) {
                return $this->setError('Password is incorrect');
            }
            // 大于30识别为token
            if ($passLen >= 30) {
                $res = Token::checkToken($password, 'user');
                if ($res['status']) {
                    $this->token = $password;
                } else {
                    return $this->setError($res['message']);
                }
            } else {
                $this->token = Token::createToken($info[$this->authKey], $this->authType);
            }
            return $this->easyLogin($info[$this->authKey]);
        } else {
            return $this->setError($this->authType . " is not");
        }
        return true;
    }

    public static function register($authType, $info)
    {
        try {
            validate([
                'username' => "require|unique:$authType|min:4",
                'password' => 'min:8',
                'email'    => "unique:$authType|email",
                'mobile'   => "unique:$authType|mobile",
            ])->check($info);
        } catch (ValidateException $e) {
            return ['code' => 0, 'msg' => $e->getError()];
        }
        extract($info);
        $info['salt'] = \think\helper\Str::random(8, 2, '0123456789');
        $info['password'] = self::getEncryptPassword($info['password'], $info['salt']);

        $res = Db::name($authType)->save($info);
        if (!$res) {
            return ['code' => 0, 'msg' => "${authType}写入失败"];
        }
        return ['code' => 1];
    }

    /**
     * 是否已经登录
     *
     * @return boolean
     */
    public function isLogin()
    {
        return $this->loginStatus;
    }

    /**
     * 是否超级管理员
     *
     * @return boolean
     */
    public function isSuper()
    {
        return $this->isSuper;
    }

    public function getError()
    {
        return $this->errorMsg;
    }


    // 设置错误
    public function setError($msg)
    {
        $this->errorMsg = $msg;
        return false;
    }
    /**
     * 注销登录
     *
     * @return void
     */
    public function logout()
    {
        $res = Token::deleteToken($this->token, $this->authType);
        Cookie::delete($this->authType.'_token');
        return $res;
    }
    /**
     * 获取密码加密后的字符串
     * @param string $password 密码
     * @param string $salt     密码盐
     * @return string
     */
    public static function getEncryptPassword($password, $salt = '')
    {
        return sha1(sha1($password) . $salt);
    }
    /**
     *  检测是否存在  用于判断登录权限和操作权限
     *
     * @param array $arr
     * @return void
     */
    public function checkAction($arr = [])
    {
        $arr = is_array($arr) ? $arr : explode(',', $arr);
        if (!$arr) return false;
        $arr = array_map('strtolower', $arr);
        // 是否存在
        if (in_array(strtolower(request()->action()), $arr) || in_array('*', $arr)) return true;
        // 没找到匹配
        return false;
    }

    public function __get($name)
    {
        return $this->info ? $this->info[$name] : null;
    }


    private function __construct()
    {
    }

    /**
     * 防止实例被克隆（这会创建实例的副本）
     */
    private function __clone()
    {
    }

    /**
     * 防止反序列化（这将创建它的副本）
     */
    public function __wakeup()
    {
    }
}
