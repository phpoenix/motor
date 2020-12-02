<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\admin\model\Book;
use app\admin\validate\Book as Validate;
use app\common\model\User;

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
			if (!isset($params['phone']) || !isset($params['date'])) {
				return rescode(400,['error'=>'信息填写不完整']);
			}
			//todo 微信登录用户的id
			$data['user_id'] = 1;
			$data['category'] = $params['type'];
			$data['position'] = isset($params['address']) ? $params['address'] : '';
			$data['lat'] = isset($params['latitude']) ? $params['latitude'] : '';
			$data['lng'] = isset($params['longitude']) ? $params['longitude'] : '';
			$data['telephone'] = $params['phone'];
			$data['status'] = 1;
			$data['booktime'] = strtotime($params['date']);
			
			//后台验证手机号输入正确
			$validator = new Validate;
			if(!$validator->regex($data['telephone'],'mobile'))
				return rescode(400,['error'=>'手机号码不正确']);

			//创建预定信息
			$result = Book::create($data);
			if($result){
				return rescode(200,[
					'data'=>[
						'username' => User::get($data['user_id'])->username,
						'position' => $data['position'],
						'booktime' => $params['date']
					]
				]);
			}else{
				return rescode(400,['error'=>'程序在处理审车流程时出现错误']);
			}
		}
		
	}
}