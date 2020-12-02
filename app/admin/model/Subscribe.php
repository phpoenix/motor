<?php

namespace app\admin\model;

use app\common\model\BaseModel;


class Subscribe extends BaseModel
{

    

    

    // 表名
    protected $name = 'subscribe';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'booktime_text',
    ];
    

    
    public function getBooktimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['booktime']) ? $data['booktime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setBooktimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

}
