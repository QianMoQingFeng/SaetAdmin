<?php

namespace app\admin\validate;

use think\Validate;

class Admin  extends Validate
{
    protected $rule = [
        'username'  =>  'require|unique:admin|min:4',
        'password'  =>  'min:8',
        'email1' =>  'unique:admin|email',
        'mobile' =>  'unique:admin|mobile',
    ];
    protected $message  =   [
        // 'username.require' => '用户名必须填写',
        // // 'username.unique'   => '该用户名已经注册过了',
        // 'password.min'     => '密码最少8位数',
        // 'email.unique'   => '该邮箱已经注册过了',
        // 'mobile.unique'   => '该手机已经注册过了',
    ];
}
