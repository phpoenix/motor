<?php

namespace app\index\controller;

/**
 * https安全验证token验证
 */
class Certifycation
{
	protected $token = 'certifycation';

	/**
	 * 安全验证
	 */
	private function checkSignature()
	{
	    $signature = $_GET["signature"];
	    $timestamp = $_GET["timestamp"];
	    $nonce = $_GET["nonce"];

	    $token = 'certifycation';
	    $tmpArr = array($token, $timestamp, $nonce);
	    sort($tmpArr, SORT_STRING);
	    $tmpStr = implode( $tmpArr );
	    $tmpStr = sha1( $tmpStr );

	    if ($tmpStr == $signature ) {
	        return true;
	    } else {
	        return false;
	    }
	}

	public function index(){
		if ($this->checkSignature()) {

			//返回echostr
			$echostr = $_GET['echostr'];
			echo $echostr;
			exit;
		}
	}
}

