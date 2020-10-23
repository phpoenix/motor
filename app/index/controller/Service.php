<?php
namespace app\index\controller;

use app\common\controller\Frontend;
use app\admin\model\Service as ServiceModel;
use app\admin\model\Merchant;

class Service extends Frontend
{
	protected $noNeedLogin = ['*'];

	public function _initialize(){
		parent::_initialize();
		$this->merchants = Merchant::select();
		foreach ($this->merchants as $key => &$value) {
		    $value->banner = 'http://'.$_SERVER['HTTP_HOST'].$value->banner;
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

	//快修与保养
	public function repair(){
		$this->find(33);
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
}