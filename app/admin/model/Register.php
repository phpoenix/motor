<?php

namespace app\admin\model;

use app\common\model\BaseModel;


class Register extends BaseModel
{

    

    

    // 表名
    protected $name = 'register';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [

    ];

    public function getGenderList()
    {
        return ['1' => __('Male'), '0' => __('Female')];
    }
    

    







}
