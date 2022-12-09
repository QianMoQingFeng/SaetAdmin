<?php

namespace  saet;

use think\facade\Db;
use think\Model as ThinkModel;

class Model extends ThinkModel
{


    /**
     * 需要自动时间格式化的后缀
     * 仅对Int数据类型的时间戳生效
     * false 关闭
     * @var [String,Boolean,Array]
     */
    protected $autoTime = '_time';

    /**
     * 自动时间过滤字段
     *  
     * @var [String,Array,null]
     */
    protected $autoTimeFilter = null;

    /**
     * 单独处理时间转化格式
     *  
     * @var [del_time=>'Y-m-d H:i:s']
     */
    protected $autoTimeFormat = [];

    public static function onAfterRead($row)
    {
        $row->autoTime === false || self::initAutoTime($row);
    }

    /**
     * 自动时间处理 默认格式跟随 dateFormat
     * 仅对Int数据类型的时间戳生效
     * @param [type] $row
     * @return void
     */
    public static function initAutoTime($row)
    {
        $suffixs = is_string($row->autoTime) ? explode(',', $row->autoTime) : $row->autoTime;
        $filters = is_string($row->autoTimeFilter) ? explode(',', $row->autoTimeFilter) : $row->autoTimeFilter;
        $fields = array_keys($row->toArray());
        foreach ($fields as  $f) {

            if (($filters && in_array($f, $filters) === false) || !is_int($row->getData($f)) || !is_int($row->$f) || strlen((string)$row->getData($f)) != 10)  continue;

            foreach ($suffixs as $v) {
                if (\think\helper\Str::endsWith($f, $v)) {
                    $row->$f =  date(isset($row->autoTimeFormat[$f]) ? $row->autoTimeFormat[$f] : $row->dateFormat, $row->getData($f));
                    break;
                }
            }
        }
    }
}
