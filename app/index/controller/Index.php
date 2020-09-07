<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\admin\model\Home;

class Index extends Frontend
{
    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function index()
    {
    
        $home = Home::get(1);
        $banner = explode(',',$home->images);
        foreach ($banner as $key => &$value) {
            $value='http://'.$_SERVER['HTTP_HOST'].$value;
        }
        return rescode(200,$banner);
    
    }

    public function news()
    {
        $newslist = [];

        return jsonp(['newslist' => $newslist, 'new' => count($newslist), 'url' => 'https://www.iuok.cn?ref=news']);
    }
}
