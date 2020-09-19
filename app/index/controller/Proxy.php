<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\admin\model\Book;
use app\admin\validate\Book as Validate;

class Proxy extends Frontend
{
	protected $noNeedLogin = ['*'];
	/**
	 * 预约信息收集
	 */
	public function collect(){
		$params = $this->request->post();
		$data = [];
		// $data = json_decode(html_entity_decode($data));
		if(isset($params['type'])){
			//todo 微信登录用户的id
			$data['user_id'] = 1;
			$data['category'] = $params['type'];
			$data['position'] = $params['address'];
			$data['lat'] = $params['latitude'];
			$data['lng'] = $params['longitude'];
			$data['telephone'] = $params['phone']? : '';
			$data['status'] = 1;
			$data['booktime'] = strtotime($params['date']);
			
			//后台验证手机号输入正确
			$validator = new Validate;
			if(!$validator->regex($data['telephone'],'mobile'))
				return rescode(400,['error'=>'手机号码不正确']);

			//创建预定信息
			$result = Book::create($data);
			if($result){
				return rescode(200,['data'=>$data]);
			}else{
				return rescode(400,['error'=>'程序在处理审车流程时出现错误']);
			}
		}
		
	}
}