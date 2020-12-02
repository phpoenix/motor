<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\admin\model\Home;
use app\admin\model\Main;
use app\admin\model\Register;
use app\admin\model\Merchant;
use app\admin\model\Goods;
use app\common\model\User;

class Index extends Frontend
{
    protected $noNeedLogin = 'getToken,storeToken,merchant,news,userInfo';
    protected $noNeedRight = '*';
    protected $layout = '';

    //用户注册
    protected $status = false;
    protected $userinfo;

    public function login(){
        //Vue前端授权用户登录
    }

    public function index()
    {
        header("Access-Control-Allow-Origin: *");
        // $param = $this->request->post();
        // if (!isset($param['token'])) {
        //     return rescode(400,['msg'=>"缺少token参数,无法识别用户"]);
        // }
        //用户是否已注册
        
        $info = Register::get(['user_id'=>$this->auth->id]);
        if ($info) {
            $this->status = true;
            $this->userinfo = $info;
        }
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

        return rescode(200,['status'=>$this->status,'types'=>$types,'banner'=>$banner,'merchant'=>$merchant]);
    
    }

    public function merchant(){
        $param = $this->request->post();
        if (isset($param['id'])) {
            $merchant = Merchant::get($param['id']);
            if ($merchant) {
                $merchant->bannerimages = explode(',', $merchant->bannerimages);
                $merchant->service = explode('@', $merchant->service);
                return rescode(200,['merchant'=>$merchant]);
            }
        }
        return rescode(400,['msg'=>"查无此商户"]);
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

    /**
     * 获取用户token
     */
    public function getToken(){
        
        $token = isset($_SESSION['user_token']) ? $_SESSION['user_token'] : null;
        if ($token) {
            return rescode(200,['token'=>$token]);
        }

        return rescode(200,['token'=>4]);
        // return rescode(400,['msg'=>'未登录的用户！']);
    }

    /**
     * 存储用户token
     */
    public function storeToken(){
        $id = $this->auth->id;
        header("Access-Control-Allow-Origin: *");
        header("Location:https://super.mynatapp.cc/dist/index.html?token=".base64_encode($id));
    }

    /**
     * 获取用户信息
     */
    public function userInfo(){
        $userinfo = User::get($this->auth->id);
        if ($userinfo) {
            return rescode(200,['user'=>$userinfo]);
        }
        return rescode(400,['msg'=>'用户未登录']);
    }

    /**
     * 腾讯位置调试
     */
    public function pos(){
        return $this->view->fetch();
    }
}
