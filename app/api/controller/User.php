<?php

declare(strict_types=1);

namespace app\api\controller;

use app\api\ApiBase;

class User extends ApiBase
{

    public function login($account = null, $password = null)
    {
        if ($this->request->isAjax()) {
            if (!$account || !$password) {
                error('参数未填写');
            }
            $login = $this->auth->login($account, $password);
            if ($login) {
                $info = $this->auth->getInfo();
                success('login ok', $info);
            } else {
                error($this->auth->getError());
            }
        }
    }

    public function info()
    {
        success('', $this->auth->getInfo());
    }
}
