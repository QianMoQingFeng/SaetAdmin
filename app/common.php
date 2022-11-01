<?php
// 应用公共文件


/**
 * 核心函数, 将列表数据转化树形结构
 * 使用前提必须是先有父后有子, 即儿子的id必须小于父亲id
 * 列表数据必须安装id从小到大排序
 * @param [type] $array
 * @param string $childKey
 * @param integer $pid
 * @param integer $T_root_id
 * @param array $T_id_tree
 * @return Array
 */
function listToTree($array, $childKey = 'children', $parentField = 'pid', $pid = 0, $T_root_id = 0, $T_id_tree = [])
{
    $tree = array();
    $index = 0;
    foreach ($array as $key => $value) {

        $value['T_root_id'] = $T_root_id;
        if ($T_root_id == 0) {
            $value['T_root_id'] = $value['id'];
        }
        $value['T_id_tree'] = count($T_id_tree) ? $T_id_tree : [];
        array_push($value['T_id_tree'], $value['id']);

        $value['T_level'] = count($T_id_tree);


        if ($value[$parentField] == $pid) {

            $child = listToTree($array, $childKey,  $parentField, $value['id'], $value['T_root_id'], $value['T_id_tree']);
            if ($child) {
                $value[$childKey] = $child;
                $value['T_total'] = count($child);
                // 最佳同级数量
                foreach ($child as $k => $v) {
                    $value[$childKey][$k]['T_last_total'] = $value['T_total'];
                }
            }
            $value['T_index'] = $index++;
            $tree[] = $value;
        }
    }
    return $tree ? $tree : [];
}

function findInTree($tree, $id)
{
    foreach ($tree as $key => $value) {

        if ($id == $value['id']) {
            return $value;
        }
        if (isset($value['children'])) {
            $i = findInTree($value['children'], $id);
            if ($i) {
                return $i;
            }
        }
    }
    return false;
}

/**
 * @param string $format 格式化格式
 * @param string｜int $datetime  时间戳或Y-m-d H:i:s
 */

function datetime($format = 'Y-m-d H:i:s', $datetime = null)
{
    if (!$format) {
        $format = 'Y-m-d H:i:s';
    }
    if ($datetime === null || is_int($datetime)) {
        return date($format, $datetime ?? time());
    }
    if (is_string($datetime)) {
        return date($format, strtotime($datetime));
    }
}
