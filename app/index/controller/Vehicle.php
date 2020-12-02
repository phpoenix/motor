<?php
namespace app\index\controller;

use app\common\controller\Frontend;
use think\facade\Db;
use app\admin\model\Vehicle as VehicleModel;
use app\admin\validate\Vehicle as Validate;

class Vehicle extends Frontend
{
	protected $noNeedLogin = ['*'];

	//添加车辆
	public function add(){
		$params = $this->request->post();

		$data = [];

		$data['user_id'] = 1;
		$data['imei'] = isset($params['imei'])? $params['imei'] :null;
		$data['motor'] = isset($params['motor'])? $params['motor'] :null;
		$data['type_id'] = isset($params['type_id'])? $params['type_id'] :0;
		$data['registertime'] = isset($params['registertime'])? strtotime($params['registertime']) :null;
		$data['km'] = isset($params['km'])? $params['km'] :0;
		$data['digit'] = isset($params['digit'])? $params['digit'] :null;
		$data['booktime'] = isset($params['booktime'])? strtotime($params['booktime']):null;
		$data['insurancetime'] = isset($params['insurancetime'])? strtotime($params['insurancetime']) : null;
		$data['license'] = isset($params['license'])? $params['license'] : '';
		$data['insurancetime'] = isset($params['insurancetime'])? strtotime($params['insurancetime']) : null;
		$data['travel'] = isset($params['travel'])? $params['travel'] : '';
		$data['licensetime'] = isset($params['licensetime'])? strtotime($params['licensetime']) : null;
		$data['number'] = isset($params['number'])? $params['number'] : '';
		$data['licensetime'] = isset($params['licensetime'])? strtotime($params['licensetime']) : null;
		$data['illegal'] = isset($params['illegal'])? 1 : 0;

		$result = VehicleModel::create($data);

		if($result){
			return rescode(200,[
				'data'=>$result
			]);
		}else{
			return rescode(400,['error'=>'程序在处理车辆注册时出现错误']);
		}
	}
		
}