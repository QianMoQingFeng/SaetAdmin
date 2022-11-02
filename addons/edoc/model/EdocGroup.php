<?php
namespace addons\edoc\model;

use think\Model;

class EdocGroup extends Model
{
    protected $name = 'edoc_group';

    public function items()
    {
        return $this->hasMany(EdocItem::class,'type_id');
    }
}
