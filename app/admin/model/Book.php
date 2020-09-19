<?php

namespace app\admin\model;

use app\common\model\BaseModel;


class Book extends BaseModel
{

    

    

    // 表名
    protected $name = 'book';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'booktime_text',
        'category_text',
        'status_text'
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

    public function getStatusList()
    {
        return ['1' => __('Status 1'), '2' => __('Status 2'), '3' => __('Status 3'), '4' => __('Status 4')];
    }

    public function getCategoryList(){
        return ['1' => __('Category 1'), '2' => __('Category 2')];
    }

    public function getCategoryTextAttr($value,$data){
        $value = $value ? $value : (isset($data['category']) ? $data['category'] : '');
        $list = $this->getCategoryList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function user()
    {
        return $this->belongsTo('User', 'user_id', 'id')->joinType('LEFT');
    }


}
