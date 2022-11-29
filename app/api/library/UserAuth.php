<?php

namespace app\api\library;


use app\common\library\Token;
use app\common\model\User;
use think\exception\ValidateException;
use think\facade\Cookie;
use think\facade\Validate;

class UserAuth extends \saet\Auth
{
    protected $authType = 'user';
    protected $authKey = 'uid';
    protected $auth;
    protected $token;
    protected $expireTime = 2626560;
    protected $allowFields = ['aid', 'avatar', 'username', 'nickname', 'groups']; //true 表示全部允许
    protected $isSuper = false;



    public function login($account, $password)
    {
        $field = Validate::is($account, 'email') ? 'email' : (Validate::regex($account, '/^1\d{10}$/') ? 'mobile' : 'username');
        $user = User::where([$field => $account])->find();
        if ($user) {
            $passLen = strlen($password);
            if ($user->password != self::getEncryptPassword($password, $user->salt) && $passLen < 30) {
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
                $this->token = Token::createToken($user->uid, 'admin');
            }

            return $this->easyLogin($user->uid);
        } else {
            return $this->setError('admin is not');
        }
        return true;
    }



    public static function register($info)
    {
        try {
            validate([
                'username'  =>  'require|unique:admin|min:4',
                'password'  =>  'min:8',
                'email1' =>  'unique:admin|email',
                'mobile' =>  'unique:admin|mobile',
            ])->check($info);
        } catch (ValidateException $e) {
            return ['code' => 0, 'msg' => $e->getError()];
        }
        extract($info);
        $info['salt'] = \think\helper\Str::random(8, 2, '0123456789');
        $info['password'] = self::getEncryptPassword($info['password'], $info['salt']);
        $admim = new User;
        $res = $admim->save($info);
        if (!$res) {
            return ['code' => 0, 'msg' => '管理员写入失败'];
        }
        return ['code' => 1];
    }



    public function getRuleIds()
    {
        $rule_ids = [];
        foreach ($this->auth->groups as $key => $value) {
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
}
