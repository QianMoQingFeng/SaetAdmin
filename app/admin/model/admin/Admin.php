<?php
namespace app\admin\model\admin;

use think\Model;

class Admin extends Model
{
    protected $name = 'admin';
    protected $pk = 'aid';
    protected $append = ['rule_ids'];
    
    // public function getRuleIdsAttr($value)
    // {
    //     return 'strtolower($value)';
    // } 
}
