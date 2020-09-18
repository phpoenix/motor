<?php

namespace app\admin\model;

use app\common\model\BaseModel;


class Goods extends BaseModel
{

    

    

    // 表名
    protected $name = 'goods';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [

    ];
    

    public function merchant()
    {
        return $this->belongsTo('Merchant', 'merchant_id', 'id')->joinType('LEFT');
    }

    public function goodstype()
    {
        return $this->belongsTo('Goodstype', 'goodstype_id', 'id')->joinType('LEFT');
    }


}
