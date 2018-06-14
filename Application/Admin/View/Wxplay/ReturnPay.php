<?php
	$xml = $GLOBALS['HTTP_RAW_POST_DATA'].'<ceshi>111111</ceshi>'; //返回的xml
	file_put_contents(dirname(__FILE__).'/xml.txt',$xml); //记录日志 支付成功后查看xml
	if($xml){
		header('Location:/admin/Wxplay/getrollback?xml='.$xml);
	}else{
		header('Location:/admin/Wxplay/getrollback?xml='.$xml);
	}


?>