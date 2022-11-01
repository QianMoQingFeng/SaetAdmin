<?php

namespace app\admin\library;

use app\admin\model\admin\Admin;
use app\admin\model\admin\Group as AdminGroup;
use app\common\library\Token;
use think\facade\Cookie;
use think\facade\Validate;

class AdminAuth
{
    protected static $instance = null;
    protected $admin;
    protected $token;
    protected $expireTime = 2626560;
    protected $allowFields = ['aid', 'avatar', 'user_name', 'nick_name', 'user_name', 'groups', 'rule_ids']; //true 表示全部允许
    protected $isSuper = false;
    public function __construct()
    {

    }

    public static function instance($options = [])
    {

        if (is_null(self::$instance)) {
            self::$instance = new static($options);
        }
        return self::$instance;
    }

    // 初始化
    public function init($token)
    {
        if ($token) {
            $res = Token::checkToken($token, 'admin');
            if ($res['status'] == true) {
                $this->token = $token;
                $this->easyLogin($res['auth_id']);
            } else {
                Cookie::delete('token');
                return $this->setError($res['message']);
            }
        }
        return true;
    }

    public function login($account, $password)
    {
        $field = Validate::is($account, 'email') ? 'email' : (Validate::regex($account, '/^1\d{10}$/') ? 'mobile' : 'user_name');
        $admin = Admin::where([$field => $account])->find();
        if ($admin) {
            $passLen = strlen($password);
            if ($admin->password != $this->getEncryptPassword($password, $admin->salt) && $passLen < 30) {
                return $this->setError('Password is incorrect');
            }
            if ($passLen >= 30) {
                $res = Token::checkToken($password, 'admin');
                if ($res['status']) {
                    $this->token = $password;
                } else {
                    return $this->setError($res['message']);
                }
            } else {
                $this->token = Token::createToken($admin->aid, 'admin');
            }
            Cookie::set('token', $this->token, $this->expireTime);
            Cookie::set('lastAdmin', json_encode($admin), 26265600);
            $this->easyLogin($admin->aid);
        } else {
            return $this->setError('admin is not');
        }
        return true;
    }
    /**
     * 退出登录
     *
     * @return void
     */
    public function logout()
    {
        Cookie::delete('token');
        $res = Token::deleteToken($this->token, 'admin');
        return $res;
    }

    /**
     * 直接登录账号
     * @param int $adminId
     * @return boolean
     */
    public function easyLogin($adminId)
    {
        $admin = Admin::find($adminId);
        if ($admin) {
            // $admin['token'] = $this->token;
            $this->admin = $admin;
            $this->loginStatus = true;
            return $this->getAdminInfo();
        } else {
            return $this->setError('admin is not found');
        }
    }

    /**
     * @description:获取会员基本信息
     */
    public function getAdminInfo()
    {
        $data = $this->admin ? $this->admin->toArray() : $this->admin;
        if (!$data) {
            return [];
        }
        if ($this->allowFields === true) {
            $admininfo = $data;
        } else {
            if (is_array($this->allowFields)) {
                $admininfo = array_intersect_key($data, array_flip($this->allowFields));
            }
        }
        $admininfo = array_merge($admininfo, ['token' => $this->token,'groups'  => $this->getGroups(),'rule_ids'  => $this->getRuleIds()]);
        return $admininfo;
    }

    /**
     * 获取分组信息
     *
     * @return Array
     */
    public function getGroups()
    {
        $arr = AdminGroup::select(explode(',', $this->admin->group_ids))->toArray();
        return $arr;
    }

    public function getRuleIds()
    {
        $rule_ids = [];
        $groups = $this->getGroups();
        foreach ($groups as $key => $value) {
            $rule_ids = array_merge(explode(',', $value['rule_ids']), $rule_ids);
        }
        if (in_array('*', $rule_ids)) {
            $this->isSuper = true;
        }
        return $rule_ids;
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

    public function __get($name)
    {
        return $this->admin ? $this->admin->$name : null;
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

    public function getError()
    {
        return $this->errorMsg;
    }

    // 检测是否存在  用于判断登录权限和操作权限
    public function checkAction($arr = [])
    {
        $arr = is_array($arr) ? $arr : explode(',', $arr);
        if (!$arr) {
            return false;
        }
        $arr = array_map('strtolower', $arr);
        // 是否存在
        if (in_array(strtolower(request()->action()), $arr) || in_array('*', $arr)) {
            return true;
        }

        // 没找到匹配
        return false;
    }
    // 设置错误
    public function setError($msg)
    {
        $this->errorMsg = $msg;
        return false;
    }
    /**
     * 获取密码加密后的字符串
     * @param string $password 密码
     * @param string $salt     密码盐
     * @return string
     */
    public function getEncryptPassword($password, $salt = '')
    {
        return sha1(sha1($password) . $salt);
    }
}
