<?php

namespace app\admin\model;

use app\common\model\BaseModel;


class Vehicle extends BaseModel
{

    

    

    // 表名
    protected $name = 'vehicle';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'registertime_text',
        'booktime_text',
        'insurancetime_text',
        'licensetime_text'
    ];
    

    



    public function getRegistertimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['registertime']) ? $data['registertime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getBooktimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['booktime']) ? $data['booktime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getInsurancetimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['insurancetime']) ? $data['insurancetime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getLicensetimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['licensetime']) ? $data['licensetime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setRegistertimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setBooktimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setInsurancetimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setLicensetimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


}
