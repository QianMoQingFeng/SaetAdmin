<?php
declare (strict_types = 1);

namespace app\common\model;
use think\Model;

class User  extends Model
{
    protected $name = 'user';
    protected $pk = 'uid';
}