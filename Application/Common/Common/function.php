<?php

/**
 * 获取手机验证码
 * @param $appkey 
 * @param $secret 
 * @param $phone 手机号
 * @param $templateCode 模板id
 * @return 
*/
function getcode($appkey,$secret,$phone,$templateCode){
	$code = rand(100000,999999);
	include(APP_PATH.'/Common/Org/taobaosdk/TopSdk.php');
	$Top = new \TopClient;
	$Top->appkey = $appkey;
	$Top->secretKey =$secret;
	$req = new \AlibabaAliqinFcSmsNumSendRequest;
	$req->setExtend("123456");
	$req->setSmsType("normal");
	$req->setSmsFreeSignName("极致空间");
	$req->setSmsParam("{\"verifyCode\":\"".$code."\"}");
	$req->setRecNum($phone);
	$req->setSmsTemplateCode($templateCode);
	$resp = $Top->execute($req);
	$resp = json_decode(json_encode($resp),TRUE);
	if($resp['result']['err_code'] == '0' && $resp['result']['err_code'] == 'true'){
		session('tel_code',$code);
	}
	return $resp;
}

/**
*+----------------------------------------------------------
* 字符串截取，支持中文和其他编码
*+----------------------------------------------------------
* @static
* @access public
*+----------------------------------------------------------
* @param string $str 需要转换的字符串
* @param string $start 开始位置
* @param string $length 截取长度
* @param string $charset 编码格式
* @param string $suffix 截断显示字符
*+----------------------------------------------------------
* @return string
*+----------------------------------------------------------
*/

function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true){

  if(function_exists("mb_substr")){

     if($suffix){

      return mb_substr($str, $start, $length, $charset)."...";

     }else{

      return mb_substr($str, $start, $length, $charset);

     }

  }elseif(function_exists('iconv_substr')) {

       if($suffix){

            return iconv_substr($str,$start,$length,$charset)."...";

       }else{

        return iconv_substr($str,$start,$length,$charset);

       }

  }

    $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";

    $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";

    $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";

    $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";

    preg_match_all($re[$charset], $str, $match);

    $slice = join("",array_slice($match[0], $start, $length));

    if($suffix){ 

        return $slice."...";

    }else{

        return $slice;

    }

}







?>