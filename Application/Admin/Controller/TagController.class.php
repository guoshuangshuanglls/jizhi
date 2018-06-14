<?php
namespace Admin\Controller;
use Think\Controller;
//  结巴分词 start
use Think\Jieba\Jieba;
use Think\Jieba\Finalseg;
use Think\Jieba\JiebaAnalyse;
use Think\Jieba\Posseg;
// 结巴分词 end

/***
***标签列表
***/
class TagController extends CommonController{

	// 标签列表
	public function TagList(){
		$PinglunModel = D('Pinglun');
		$UserModel    = D('User');
		$ArticleModel = D('Article');
		$searchname   = I('searchname');
		$start		  = I('start');
		$end          = I('end');
		if($searchname){
			$where = "p.changtype = 1 and p.aid=a.id and p.status=1 and (a.art_name LIKE '%".$searchname."%' or p.content like '%".$searchname."%')";
		}else{
			$where = "p.changtype = 1 and p.aid=a.id and p.status=1";
		}
		if(!empty($start) && !empty($end)){
			$where .= " and p.indate BETWEEN '".$start."' and '".$end."'";
		}

		$table = "per_pinglun p,per_article a";
		$PinglunList = $PinglunModel->MultiTablelSelectList($table,$where,'p.*,a.art_name','',true);
		$list = $PinglunList['list'];
		foreach ($list as $key => $value) {
			$list[$key]['indate'] = date('Y-m-d H:i:s',$value['intime']);
			$list[$key]['nickname'] = $UserModel->getInfo(array('id'=>$value['uid']))['nickname'];
		}
		$this->assign('searchname',$searchname);
		$this->assign('start',$start);
		$this->assign('end',$end);
		$this->assign('list',$list);
		$this->assign('page',$PinglunList['show']);
		$this->display();
	}

	


	// 删除标签操作
	public function updateStatus(){
		if(IS_POST){
			$id = I('id');
			$TopicModel = D('Topic');
			$TopicInfo  = $TopicModel->getInfo(array('id'=>$id));
			if($TopicInfo['status'] == 1){
				$TopicModel->operationInfo(array('id'=>$id,'status'=>2),'id');
				$this->ajaxReturn(array('status'=>1,'msg'=>'禁用成功'));
			}elseif ($TopicInfo['status'] == 2) {
				$TopicModel->operationInfo(array('id'=>$id,'status'=>1),'id');
				$this->ajaxReturn(array('status'=>1,'msg'=>'启用成功'));
			}
		}else{
			echo '非法操作';
			exit;
		}
	}


	//添加标签
	public function TagAdd(){
		$this->display();
	}
	
}



?>