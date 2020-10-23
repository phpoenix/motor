<?php
/**
 *  ============================================================================
 *  Created by PhpStorm.
 *  User: Ice
 *  邮箱: ice@sbing.vip
 *  网址: https://sbing.vip
 *  Date: 2019/11/27 下午6:09
 *  ============================================================================
 */

// [ 应用入口文件 ]

namespace think;

//https安全域名token验证
if(isset($_GET['echostr'])){
	echo $_GET['echostr'];
	exit;
}

//微信接口配置
function checkSignature()
{
    $signature = $_GET["signature"];
    $timestamp = $_GET["timestamp"];
    $nonce = $_GET["nonce"];
	
    $token = '123';
    $tmpArr = array($token, $timestamp, $nonce);
    sort($tmpArr, SORT_STRING);
    $tmpStr = implode( $tmpArr );
    $tmpStr = sha1( $tmpStr );
    
    if( $tmpStr == $signature ){
        return true;
    }else{
        return false;
    }
}

checkSignature();

// 判断是否安装fastadmin-tp6
if (! is_file('../config/install.lock')) {
    header("location:./install.php");
    exit;
}

//是否composer
if (! file_exists('../vendor')) {
    exit('根目录缺少vendor,请先composer install');
}

require __DIR__.'/../vendor/autoload.php';

// $pos = strpos($_REQUEST['s'], '/');
// $route = substr($_REQUEST['s'], 0, $pos);
// if ($route == "carplatform") {
// 	return true;
// }

// 执行HTTP应用并响应
$http = (new App())->http;

$response = $http->run();

$response->send();

$http->end($response);
