<?php
namespace app\index\model;

use think\Model;

class Callback extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'loa_callback';

    protected $pk = 'id';
}