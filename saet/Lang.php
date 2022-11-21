<?php

namespace saet;

use think\Lang as ThinkLang;

class Lang extends ThinkLang
{

    protected $langArray = [];

    public function loadLang($list)
    {
        foreach ((array) $list as $file) {
            if (is_file($file)) {
                $result = $this->parse($file);
                $this->langArray = $result + $this->langArray;
            }
        }
        return $this->langArray;
    }
}
