<?php

namespace app\admin\model;

use saet\Model;

class Admin extends Model
{
    protected $name = 'admin';
    protected $pk = 'aid';

    public function getAvatarAttr($value)
    {
        return $value ? cdnurl($value) : '/static/saet/img/avatar.png';
    }
}
