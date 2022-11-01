<?php
namespace app\admin\model;
use think\Model;

class Config extends Model
{
    protected $name = 'config';
    protected $pk = 'name';
    protected $autoWriteTimestamp = 'datetime';
}