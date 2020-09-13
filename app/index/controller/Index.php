<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\admin\model\Home;
use app\admin\model\Main;

class Index extends Frontend
{
    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function index()
    {
        $types = Main::select();
        foreach ($types as $key => &$value) {
            $value->logoimage = 'http://'.$_SERVER['HTTP_HOST'].$value->logoimage;
        }
        $home = Home::get(1);
        $banner = explode(',',$home->images);
        foreach ($banner as $key => &$value) {
            $value='http://'.$_SERVER['HTTP_HOST'].$value;
        }
        return rescode(200,['types'=>$types,'banner'=>$banner]);
    
    }

    public function news()
    {
        $newslist = [];

        return jsonp(['newslist' => $newslist, 'new' => count($newslist), 'url' => 'https://www.iuok.cn?ref=news']);
    }
}
