<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
class GrabController extends CommonController{
	public function index(){
		$serach = I('serach');
		$Info = $this->option_info($serach);
		$this->display();
	}
    // 处理
    public function option_info($serach){
    	$url = 'http://weixin.sogou.com/weixin?type=1&query='.$serach.'&ie=utf8&s_from=input&_sug_=y&_sug_type_=';
		$Info = $this->curl($url);
		$preg = "/.*?<p class=\"tit\">\s*(.*?)\s*<\/p>.*?/";
		$preg_match_info= preg_match_all($preg, $Info,$newinfo);
		$addInfo = [];
		foreach ($newinfo[1] as $key => $value) {
			$str = '';
			$info = explode('</a>',$value);
			$titleInfo = explode('==">', $info[0])[1];
			$title_one = explode('<em>', $titleInfo)[0];
			$str .= $str.$title_one;
			$title_two = explode('<em>', $titleInfo)[1];
			$title_three = (explode('<!--red_end-->', (explode('<!--red_beg-->', $title_two)[1])));
			$str .= $title_three[0];
			$title_four = explode('</em>', $title_three[1]);
			$str .= $title_four[1];
			preg_match('/href=\"([^(\}>)]+)\"/', $info[0],$newurl);
			array_push($addInfo,array('url'=>html_entity_decode($newurl[1]),'title'=>$str));
		}
		return $addInfo;
    }

    private function curl($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }
}

?>