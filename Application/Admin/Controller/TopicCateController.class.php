<?php
namespace Admin\Controller;
use Think\Controller;
/***
***话题分类
***/
class TopicCateController extends CommonController{

	// 话题分类列表
	public function TopicCateList(){
		$TopicCateModel = D('TopicCate');
		$pid = I('pid');
		
		$searchname = I('searchname');
		if($searchname){
			$where = array('cate_name'=>array('like','%'.$searchname.'%'),'status'=>1);
		}else{
			$where = array('status'=>1);
		}
		
		$TopicCateList = $TopicCateModel->selectList($where,'','',true);
		$list = $TopicCateList['list'];
		foreach ($list as $key => $value) {
			$list[$key]['indate'] = date('Y-m-d H:i:s',$value['intime']);
		}
		$this->assign('list',$list);
		$this->assign('page',$TopicCateList['show']);
		$this->display();
	}

	// 添加话题分类
	public function addTopicCate(){

		$this->display();
	}

	// 添加话题分类的处理
	public function addTopicCateOp(){
		$cate_name = I('cate_name');
		$cate_desc = I('cate_desc');
		$TopicCateModel = D('TopicCate');
		$data = array('cate_name'=>$cate_name,'info'=>$cate_desc,'status'=>1,'intime'=>time());
		$InfoReturn = $TopicCateModel->operationInfo($data);
		if($InfoReturn){
			$this->success('添加成功',U('TopicCate/TopicCateList'));
		}else{
			$this->error('添加失败，请重新添加',U('TopicCate/addTopicCate'));
		}
	}


	// 禁用话题分类操作
	public function updateCateStatus(){
		if(IS_POST){
			$id = I('id');
			$TopicCateModel = D('TopicCate');
			$TopicCateInfo  = $TopicCateModel->getInfo(array('id'=>$id));
			if($TopicCateInfo['status'] == 1){
				$TopicCateModel->operationInfo(array('id'=>$id,'status'=>2),'id');
				$this->ajaxReturn(array('status'=>1,'msg'=>'禁用成功'));
			}elseif ($TopicCateInfo['status'] == 2) {
				$TopicCateModel->operationInfo(array('id'=>$id,'status'=>1),'id');
				$this->ajaxReturn(array('status'=>1,'msg'=>'启用成功'));
			}
		}else{
			echo '非法操作';
			exit;
		}
	}


	// 话题分类修改
	public function updateCate(){
		$id = I('id');
		$TopicCateModel = D('TopicCate');
		$TopicCateInfo  = $TopicCateModel->getInfo(array('id'=>$id));
		$this->assign('id',$id);
		$this->assign('TopicCateInfo',$TopicCateInfo);
		$this->display();
	}

	// 话题分类修改操作
	public function updateCateOp(){
		$id = I('id');
		$cate_name = I('cate_name');
		$cate_desc = I('cate_desc');
		$TopicCateModel = D('TopicCate');
		$data = array('cate_name'=>$cate_name,'info'=>$cate_desc,'id'=>$id);
		$ReturnInfo = $TopicCateModel->operationInfo($data,'id');
		if($ReturnInfo){
			$this->success('修改成功',U('TopicCateList'));
		}else{
			$this->error('修改失败',U('updateCate',array('id'=>$id)));
		}

	}


	// 查看分类是否存在
	public function getCateNameExist(){
		$cate_name = I('cate_name');
		$cate_id   = I('cate_id');
		$TopicCateModel = D('TopicCate');
		if($cate_id){
			$where = array('status'=>1,'cate_name'=>$cate_name,'id'=>array('neq',$cate_id));
		}else{
			$where = array('status'=>1,'cate_name'=>$cate_name);
		}
		$ReturnInfo = $TopicCateModel->getInfo($where);
		if(!empty($ReturnInfo)){
			echo 1;
		}else{
			echo 2;
		}
	}
}



?>