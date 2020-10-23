<?php

namespace app\admin\model;

use app\common\model\BaseModel;


class Service extends BaseModel
{

    

    

    // 表名
    protected $name = 'service';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [

    ];
    

    







}
