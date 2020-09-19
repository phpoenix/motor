<?php

namespace app\admin\validate;

use think\Validate;

class Book extends Validate
{
    /**
     * 验证规则
     */
    protected $rule = [
        'telephone' => 'require|max:11|/^1[3-9]\d{9}$/'
    ];
    /**
     * 提示消息
     */
    protected $message = [
        'telephone' => '缺少手机号|手机号最多不超过11位|手机号码格式不正确'
    ];
    /**
     * 验证场景
     */
    protected $scene = [
        'add'  => [],
        'edit' => [],
    ];
    
}
