<?php
namespace app\common\model;
use think\Model;

class Config extends Model
{
    protected $name = 'config';
    protected $pk = 'name';
    protected $autoWriteTimestamp = 'datetime';
}