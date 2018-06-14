<?php
namespace Admin\Controller;
use Think\Controller;
vendor("WxPay.Api");
vendor("WxPay.WxPayNotify");
vendor("WxPay.NativePay");
vendor("WxPay.phpqrcode");
/***
***微信支付
***/
class WxplayController extends CommonController{

	// 下单获取二维码地址操作
	public function getOrderUrl(){
		$money = 0.01;
		$title = '购买会员';
		$ReturnInfo = $this->SubmitOrders($title,$money);
		// $qrcodeImg  = $this->getCode($ReturnInfo['code_url']);
		// var_dump($ReturnInfo['code_url']);
		$this->assign('qrcodeImg',$ReturnInfo['code_url']);
		$this->assign('ReturnInfo',$ReturnInfo);
		$this->display();
	}

	public function SubmitOrders($body,$money){
		$goodsid=time();
		$order  = time();
		$notify = new \NativePay();
		$input  = new \WxPayUnifiedOrder(); 
		$input->SetBody($body);//
		$input->SetAttach($body);
		$input->SetOut_trade_no($goodsid);//
		$input->SetTotal_fee($money*100);//   *100
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 7200));
		$input->SetNotify_url('http://'.$_SERVER['HTTP_HOST'].U('Wxplay/getrollback'));
		$input->SetTrade_type("NATIVE");
		$input->SetProduct_id($goodsid);
		$out_trade_no = $input->GetOut_trade_no();
		$result = $notify->GetPayUrl($input);
		return $result;
	}

	public function getCode($url){
		$url = urldecode($url);
		$size = 4;
		$img = \QRcode::png($url,false,QR_ECLEVEL_L,$size,2);
		return $img;
    }


    // 回调函数
    // public function getrollback(){
    // 	$rollback = new \WxPayNotify();
    // 	var_dump($rollback);
    // }
    public function getrollback(){
		$xml = $GLOBALS['HTTP_RAW_POST_DATA']; //返回的xml
		file_put_contents(dirname(__FILE__).'/xml.txt',$xml); //记录日志 支付成功后查看xml.txt文件是否有内容 如果有xml格式文件说明回调成功
		//file_get_contents(dirname(__FILE__).'/xml.txt');
		$xmlObj=simplexml_load_string($xml,'SimplexmlElement',LIBxml_NOCDATA); 
		$xmlArr=json_decode(json_encode($xmlObj),true);
		$out_trade_no=$xmlArr['out_trade_no']; //订单号
		$total_fee=$xmlArr['total_fee']/100; //回调回来的xml文件中金额是以分为单位的
		$result_code=$xmlArr['result_code']; //状态
		if($result_code=='SUCCESS'){ //数据库操作
			//处理数据库操作 例如修改订单状态 给账户充值等等 
			echo 'SUCCESS'; //返回成功给微信端 一定要带上不然微信会一直回调8次
			exit;	
		}else{ //失败
			return;
			exit;
		}
	}


	
}



?>