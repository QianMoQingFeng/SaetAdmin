<?php
declare (strict_types = 1);

namespace app\common\model;
use think\Model;

class UserToken  extends Model
{
    protected $name = 'user_token';
    protected $autoWriteTimestamp = 'datetime';
}