<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	$ArticleModel = D('Article');
    	$ArticleCateModel = D('ArticleCate');
    	$ArticleInfo = $ArticleModel->selectList('','','',true);
    	foreach ($ArticleInfo['list'] as $key => $value) {
    		if($value['intime']){
    			$ArticleInfo['list'][$key]['intime'] = date('Y-m-d H:i:s',$value['intime']);
    		}
    		// smll cate
    		$CateInfo = $ArticleCateModel->getInfo(array('id'=>$value['sm_cid']));
    		$ArticleInfo['list'][$key]['cate_name'] = $CateInfo['cate_name'];
    	}
    	$ArticleCateList  = $ArticleCateModel->where(array('status'=>1))->limit(7)->select();
        foreach ($ArticleCateList as $k => $val) {
            $ArticleCateList[$k]['color'] = $this->randColor();
        }

    	$this->assign('ArticleCate',$ArticleCateList);
    	$this->assign('ArticleInfo',$ArticleInfo['list']);
        $this->display();
    }

    public function randColor(){
        $colors = ['#'];
        for($i = 0;$i<6;$i++){
            $colors[] = dechex(rand(0,15));
        }
        return implode('',$colors);
    }
    
}