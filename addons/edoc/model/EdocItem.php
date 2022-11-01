<?php
namespace addons\edoc\model;

use think\Model;

class EdocItem extends Model
{
    protected $name = 'edoc_item';

    public function group()
    {
        return $this->belongsTo(EdocGroup::class, 'group_id');
    }
}
