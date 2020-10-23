<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\admin\model\Home;
use app\admin\model\Main;
use app\admin\model\Merchant;
use app\admin\model\Goods;

class Index extends Frontend
{
    protected $noNeedLogin = '';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function index()
    {
        /**
         * 主分类图片
         */
        $types = Main::select();
        foreach ($types as $key => &$value) {
            $value->logoimage = 'http://'.$_SERVER['HTTP_HOST'].$value->logoimage;
        }
        /**
         * 首页轮播图
         */
        $home = Home::get(1);
        $banner = explode(',',$home->images);
        foreach ($banner as $key => &$value) {
            $value='http://'.$_SERVER['HTTP_HOST'].$value;
        }
        /**
         * 商户列表
         */
        $merchant = Merchant::where('hot',1)->order('star,weigh','desc')->limit(3)->select();
        foreach ($merchant as $key => &$value) {
            $value->banner='http://'.$_SERVER['HTTP_HOST'].$value->banner;
        }

        return rescode(200,['types'=>$types,'banner'=>$banner,'merchant'=>$merchant]);
    
    }

    /**
     * 备品超市
     */
    public function market($type = 1){
        //热销品
        $goods = Goods::where(['goodstype_id'=>$type,'hot'=>1])->select();
        foreach ($goods as $key => $value) {
            $value->bannerimage='http://'.$_SERVER['HTTP_HOST'].$value->bannerimage;
        }
        //为你推荐
        $hot = $goods;
        return rescode(200,['goods'=>$goods,'hot'=>$goods]);
    }

    public function news()
    {
        $newslist = [];

        return jsonp(['newslist' => $newslist, 'new' => count($newslist), 'url' => 'https://www.iuok.cn?ref=news']);
    }
}
