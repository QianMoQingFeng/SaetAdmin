<?php
declare (strict_types = 1);

namespace app\admin\controller\admin;

use app\admin\AdminBase;

class Token extends AdminBase
{
    protected $switchAllowField = 'is_temporary';

}
