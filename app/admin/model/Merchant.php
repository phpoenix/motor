<?php

namespace app\admin\model;

use app\common\model\BaseModel;


class Merchant extends BaseModel
{

    

    

    // 表名
    protected $name = 'merchant';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'star_text'
    ];
    
    /**
    * @param Model $row
    */
    protected static function onAfterInsert($row){
        $pk = $row->getPk();
        $row->where($pk, $row[$pk])->update(['weigh' => $row[$pk]]);
    }

    
    public function getStarList()
    {
        return ['0' => __('Star 0'), '1' => __('Star 1'), '2' => __('Star 2'), '3' => __('Star 3'), '4' => __('Star 4'), '5' => __('Star 5')];
    }


    public function getStarTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['star']) ? $data['star'] : '');
        $list = $this->getStarList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}
