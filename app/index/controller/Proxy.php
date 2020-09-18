<?php

namespace app\index\controller;

use app\common\controller\Frontend;

class Proxy extends Frontend
{
	protected $noNeedLogin = ['*'];
	/**
	 * 预约信息收集
	 */
	public function collect(){
		$data = $this->request->post();
		// $data = json_decode(html_entity_decode($data));
		return rescode(200,['data'=>$data]);
	}
}