<?php
namespace app\index\controller;

use app\common\controller\Frontend;
use app\admin\model\Service as ServiceModel;
use app\admin\model\Register as RegisterModel;
use app\admin\model\Merchant;
use app\admin\model\Subscribe;
use think\facade\Config;
use app\common\model\User;

class Service extends Frontend
{
	protected $noNeedLogin = ['*'];

	public function _initialize(){
		parent::_initialize();
		$this->merchants = Merchant::select();
		foreach ($this->merchants as $key => &$value) {
		    $value->banner = 'http://'.$_SERVER['HTTP_HOST'].$value->banner;
		    $value->service = explode("@", $value->service);
		}
	}
	//洗车
	public function wash(){
		$this->find(1);
	}

	//车辆美容
	public function vehicle(){
		$this->find(11);
	}

	//维修与救援
	public function help(){
		$this->find(54);
	}

	//快修与保养
	public function repair(){
		$vehicle = ServiceModel::get(33);
		$images = explode(',', $vehicle->detailimages);
		foreach ($images as $key => &$value) {
			$value = 'http://'.$_SERVER['HTTP_HOST'].$value;
		}
		unset($value);
		$category = ServiceModel::where('pid',33)->select();
		foreach ($category as $k => $v) {
			$child = ServiceModel::where('pid',$v->id)->select();
			$v->child = $child;
		}
		unset($v);
		$vehicle->detailimages = $images;
		$vehicle->category = $category;
		$vehicle->merchant = $this->merchants;
		return rescode(200,[
				'data'=>$vehicle
			]);
	}

	//品质贴膜
	public function pasting(){
		$this->find(55);
	}

	//轮胎更换
	public function tire(){
		$this->find(56);
	}

	//查询类目
	public function find($id){

		$vehicle = ServiceModel::get($id);
		$images = explode(',', $vehicle->detailimages);
		foreach ($images as $k => &$v) {
			$v = 'http://'.$_SERVER['HTTP_HOST'].$v;
		}
		$vehicle->detailimages = $images;
		$category = ServiceModel::where('pid',$id)->select();
		$vehicle->category = $category;
		$vehicle->merchant = $this->merchants;
		return rescode(200,[
				'data'=>$vehicle
			]);

	}

	//预约基本信息
	public function subscribe(){
		$userinfo = RegisterModel::get(['user_id'=>1]);
		if (!$userinfo) {
			return rescode(400,['msg'=>"您还没有注册服务！"]);
		}

		//车平台提供的服务
		$services = ServiceModel::where('pid',0)->field('id,name')->select();
		
		return rescode(200,['userinfo'=>$userinfo,'service'=>$services]);
	}

	//预约记录
	public function record(){

		$params = $this->request->post();

		$data = [];

		$data['register_id'] = isset($params['id'])? $params['id'] :0;
		$data['booktime'] = isset($params['booktime'])? $params['booktime'] :0;
		$data['service_id'] = isset($params['service'])? $params['service'] :0;
		$data['mark'] = isset($params['mark'])? $params['mark'] :'';
		$data['name'] = isset($params['name'])? $params['name'] :'';
		$data['merchant_id'] = isset($params['merchant'])? $params['merchant'] :'';
		$data['createtime'] = time();
		
		$result = Subscribe::create($data);

		if($result){
			return rescode(200,[
				'data'=>$result
			]);
		}else{
			return rescode(400,['error'=>'程序在处理车辆注册时出现错误']);
		}
	}

	//轮胎更换 品牌占有率
	public function top10(){
		$data = Config::get('site.top10');
		return rescode(200,['data'=>array_slice($data, 0, 4)]);
	}

	//是否注册车平台会员
	public function isReg(){
		$userid = $this->auth->id;
		// $userid = 9;
		if (!$userid) {
			return rescode(400,['error'=>'未授权登录的用户']);
		}
		$register = RegisterModel::get(['user_id' => $userid]);
		if (!$register) {
			return rescode(200,['status'=>0, 'data'=>'未注册为车平台的会员']);
		}
		$user = User::get($userid);
		$register->avatar = $user->avatar;
		return rescode(200,['status'=>1, 'data'=>$register]);
		
	}
}