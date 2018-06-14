<?php
namespace Admin\Controller;
use Think\Controller;
/***
***话题
***/
class TopicController extends CommonController{

	// 话题列表
	public function TopicList(){
		$TopicModel = D('Topic');
		$searchname = I('searchname');
		if($searchname){
			$where = array('topic_name'=>array('like','%'.$searchname.'%'),'status'=>1);
		}else{
			$where = array('status'=>1);
		}
		
		$TopicList = $TopicModel->selectList($where,'','',true);
		$list = $TopicList['list'];
		foreach ($list as $key => $value) {
			$list[$key]['indate'] = date('Y-m-d H:i:s',$value['intime']);
		}
		$this->assign('list',$list);
		$this->assign('page',$TopicList['show']);
		$this->display();
	}

	// 添加话题
	public function addTopic(){
		$TopicCateModel = D('TopicCate');
		$TopicCateList  = $TopicCateModel->selectList(array('status'=>1),'','',false);
		$this->assign('TopicCateList',$TopicCateList);
		$this->display();
	}

	// 添加话题的处理
	public function addTopicOp(){
		$topic_name = I('topic_name');
		$topic_info = I('topic_info');
		$cateid     = I('cateid');
		$TopicModel = D('Topic');
		$data = array('topic_name'=>$topic_name,'topic_info'=>$topic_name,'status'=>1,'intime'=>time(),'topic_cid'=>$cateid,'indate'=>date('Y-m-d',time()));
		$InfoReturn = $TopicModel->operationInfo($data);
		if($InfoReturn){
			$this->success('添加成功',U('Topic/TopicList'));
		}else{
			$this->error('添加失败，请重新添加',U('Topic/addTopic'));
		}
	}


	// 禁用话题操作
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


	// 话题修改
	public function updateTopic(){
		$id = I('id');
		$TopicModel = D('Topic');
		$TopicInfo  = $TopicModel->getInfo(array('id'=>$id));
		$TopicCateModel = D('TopicCate');
		$TopicCateList  = $TopicCateModel->selectList(array('status'=>1),'','',false);

		$this->assign('TopicCateList',$TopicCateList);
		$this->assign('id',$id);
		$this->assign('TopicInfo',$TopicInfo);
		$this->display();
	}

	// 话题修改操作
	public function updateTopicOp(){
		$id = I('id');
		$topic_name = I('topic_name');
		$topic_info = I('topic_info');
		$TopicModel = D('Topic');
		$data = array('topic_name'=>$topic_name,'topic_info'=>$topic_info,'id'=>$id);
		$ReturnInfo = $TopicModel->operationInfo($data,'id');
		if($ReturnInfo){
			$this->success('修改成功',U('TopicList'));
		}else{
			$this->error('修改失败',U('updateTopic',array('id'=>$id)));
		}

	}


	// 查看话题是否存在
	public function getTopicNameExist(){
		$topic_name = I('topic_name');
		$topic_id   = I('topic_id');
		$TopicModel = D('Topic');
		if($topic_id){
			$where = array('status'=>1,'topic_name'=>$topic_name,'id'=>array('neq',$topic_id));
		}else{
			$where = array('status'=>1,'topic_name'=>$topic_name);
		}
		$ReturnInfo = $TopicModel->getInfo($where);
		if(!empty($ReturnInfo)){
			echo 1;
		}else{
			echo 2;
		}
	}
}



?>