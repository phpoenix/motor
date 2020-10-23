<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\admin\model\Register as RegisterModel;
use app\admin\validate\Register as Validate;
use app\common\model\User;
use think\facade\Cookie;

class Register extends Frontend
{
	protected $noNeedLogin = ['*'];

	public function index(){

		$params = $this->request->post();
		$data = [];

		$data['user_id'] = 1;
		$data['mobile'] = isset($params['mobile'])? $params['mobile'] :"13633516851";
		$data['gender'] = isset($params['gender'])? $params['gender'] :2;
		$data['province'] = isset($params['province'])? $params['province'] :"山西省";
		$data['city'] = isset($params['city'])? $params['city'] :"晋中市";
		$data['district'] = isset($params['district'])? $params['district'] :"榆次区";
		$data['address'] = isset($params['address'])? $params['address'] :"龙田路";
		$data['number'] = isset($params['number'])? $params['number']:"晋K 88888";
		$data['km'] = isset($params['km'])? $params['km'] : 100;

		//短信验证码提交验证
		$yzm = isset($params['yzm'])? $params['yzm'] : null;
		$token = $_COOKIE['yzm'];
		
		if (! $this->check($yzm,$token)) {
			return rescode(400,['error'=>'验证码输入有误！']);
		}

		$validator = new Validate;
		if(!$validator->regex($data['mobile'],'mobile'))
			return rescode(400,['error'=>'手机号码不正确']);
		$result = RegisterModel::create($data);
		if($result){
			return rescode(200,[
				'data'=>$result
			]);
		}else{
			return rescode(400,['error'=>'程序在处理车辆注册时出现错误']);
		}
	}

	//短信验证
	public function check($yzm,$token){
		if (is_null($yzm) || is_null($token)) {
			return false;
		}

		// 再次加密，比对
	    if(md5(md5($yzm)) === $token){
	        return true;
	    }

	    return false;
	}

	//获取验证码
	public function input(){
		
   		$params = $this->request->post();
   		$telephone = isset($params['telephone'])? $params['telephone'] : null;
		$validator = new Validate;
		if(!$validator->regex($telephone,'mobile'))
			return rescode(400,['error'=>'手机号码不正确']);

		$host = "https://api.smsbao.com";
	    $path = "/sms";
	    $u = "yjssc";
	    $p = md5("yjssc");
	    $yzm = rand(1000,9999);
	    $c = urlencode("[车平台] 短信验证码：".$yzm.",请妥善保管。");
	    $sendurl = $host.$path."?u=".$u."&p=".$p."&m=".$telephone."&c=".$c;
	    
	    $result =file_get_contents($sendurl);
	    if (!$result) {
	    	setcookie('yzm',md5(md5($yzm)),time() - 3600);
	    	//设置token
	    	setcookie('yzm', md5(md5($yzm)), time() + 3600);
	    	return rescode(200,['data'=>$yzm,'msg'=>'发送验证码成功']);
	    }

	    return rescode(400,['error'=>'短信宝发送消息出错']);
	    
	}
}