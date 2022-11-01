<?php
namespace app\admin\model\admin;
use think\Model;

class Token extends Model
{
    protected $name = 'admin_token';
    protected $autoWriteTimestamp = 'datetime';
}