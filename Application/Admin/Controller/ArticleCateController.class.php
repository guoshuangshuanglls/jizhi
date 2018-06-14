<?php
namespace Admin\Controller;
use Think\Controller;
/**
* 文章分类管理
*/
class ArticleCateController extends CommonController{
	// 文章分类列表
	public function ArticleCateList(){

		$ArticleCateModel = D('ArticleCate');
		$pid = I('pid');
		if($pid){
			$where = array('pid'=>$pid);
		}else{
			$where = array('pid'=>0);
		}
		
		$ArticleCateList = $ArticleCateModel->selectList($where,'','id asc',true);
		$ArticleCateList = $ArticleCateList['list'];
		foreach ($ArticleCateList as $key => $value) {
			$childNum = $ArticleCateModel->getInfoNum(array('status'=>1,'pid'=>$value['id']));
			$ArticleCateList[$key]['childNum'] = $childNum;
			$ArticleCateList[$key]['indate'] = date('Y-m-d H:i:s',$value['intime']);
		}
		$this->assign('ArticleCateList',$ArticleCateList);
		$this->assign('show',$ArticleCateList['show']);
		$this->display();
	}
	// 文章分类添加
	public function addCate(){

		// 获取一级分类
		$ArticleCateModel = D('ArticleCate');
		$where = array('pid'=>0,'status'=>1);
		$Info  = $ArticleCateModel->selectList($where,'','id asc',false);
		$this->assign('Info',$Info);
		$this->display();
	}

	// 添加分类操作
	public function addCateOp(){
		$cate_pid = I('post.cate_id');
		$cate_name= I('post.cate_name');
		$cate_desc= I('post.cate_desc');
		if(empty($cate_name)){
			$this->error('分类名称不能为空',U('ArticleCate/addCate'));
		}
		if(empty($cate_desc)){
			$this->error('分类简介不能为空',U('ArticleCate/addCate'));
		}
		$ArticleCateModel = D('ArticleCate');
		if($cate_pid){
			// 查询父分类的信息
			$Info = $ArticleCateModel->getInfo(array('id'=>$cate_pid));
			$data = array('cate_name'=>$cate_name,'cate_desc'=>$cate_desc,'pid'=>$cate_pid,'level'=>$Info['level']+1);
		}else{
			$data = array('cate_name'=>$cate_name,'cate_desc'=>$cate_desc,'pid'=>$cate_pid,'level'=>1);
		}
		
		$id = $ArticleCateModel->operationInfo($data);
		if($id){
			if($cate_pid){
				$ArticleCateModel->operationInfo(array('id'=>$id,'path'=>$Info['path'].'-'.$id),'id');
			}else{
				$ArticleCateModel->operationInfo(array('id'=>$id,'path'=>$id),'id');
			}
			$this->success('添加成功',U('ArticleCate/ArticleCateList'));
		}else{
			$this->error('添加失败，请重新添加',U('ArticleCate/addCate'));
		}

	}

	// 文章分类名称是否已经存在
	public function getCateNameExist(){
		if(IS_POST){
			// type 为 add 为添加检测   update 为修改检测
			$ArticleCateModel = D('ArticleCate');
			$cate_name = I('post.cate_name');
			$id = I('id');
			$type = I('type');
			if($type =='add'){
				$where = array('cate_name'=>$cate_name,'status'=>1);
			}elseif ($type == 'update') {
				$where = array('cate_name'=>$cate_name,'status'=>1,'id'=>array('neq',$id));
			}
			$Info  = $ArticleCateModel->getInfo($where);
			if($Info){
				echo 1;
				die;
			}else{
				echo 2;
				die;
			}
			
		}else{
			echo '非法请求';
			die;
		}
	}


	// 修改分类
	public function updateInfo(){
		$id = I('id');
		$ArticleCateModel = D('ArticleCate');
		$CateInfo = $ArticleCateModel->getInfo(array('id'=>$id));
		$ArticleCateModel = D('ArticleCate');
		$where = array('pid'=>0,'status'=>1);
		$Info  = $ArticleCateModel->selectList($where,'','id asc',false);
		if($CateInfo['pid'] > 0){
			$pidInfo = $ArticleCateModel->getInfo(array('id'=>$CateInfo['pid']));
			$CateInfo['pid_name'] = $pidInfo['cate_name'];
		}else{
			$CateInfo['pid_name'] = '顶级分类';
		}
		
		$this->assign('Info',$Info);
		$this->assign('cate_info',$CateInfo);
		$this->display();
		
	}

	//修改分类操作
	public function updateInfoOp(){
		$cate_name = I('cate_name');
  		$cate_desc = I('cate_desc');
  		$cid       = I('cid');
  		if(empty($cate_name)){
  			$this->error('请填写分类名称',U('ArticleCate/updateInfo',array('id'=>$cid)));
  		}
  		if(empty($cate_desc)){
  			$this->error('请填写分类描述',U('ArticleCate/updateInfo',array('id'=>$cid)));
  		} 		

  		$ArticleCateModel = D('ArticleCate');
  		$Info = $ArticleCateModel->operationInfo(array('id'=>$cid,'cate_name'=>$cate_name,'cate_desc'=>$cate_desc),'id');
  		if($Info){
  			$this->success('修改成功',U('ArticleCate/ArticleCateList'));
  		}else{
  			$this->error('修改失败，请重新操作',U('ArticleCate/updateInfo',array('id'=>$cid)));
  		}
	}


	// 修改分类状态
	public function updateSetStatus(){
		if(IS_POST){
			$ArticleCateModel = D('ArticleCate');
			$id = I('post.id');
			$data = array('id'=>$id);
			$CateInfo = $ArticleCateModel->getInfo(array('id'=>$id));
			if($CateInfo){
				if($CateInfo['status'] == 1){
					$where = array('status'=>2,'id'=>$id);
				}elseif ($CateInfo['status'] == 2) {
					$where = array('status'=>1,'id'=>$id);
				}

			}else{
				echo '没有此分类';
			}
			$returnInfo = $ArticleCateModel->operationInfo($where,'id');
			if($returnInfo){

				// 如果本分类是顶级分类，则查询顶级分类下的子分类
				if($CateInfo['pid'] == 0){
					if($CateInfo['status'] == 1){
						$data = array('status'=>2,'pid'=>$id);
					}elseif ($CateInfo['status'] == 2) {
						$data = array('status'=>1,'pid'=>$id);
					}
					$childInfo = $ArticleCateModel->operationInfo($data,'pid');
					if($childInfo){
						echo 1;
					}else{
						echo 2;
					}
				}else{
					echo 1;
				}
			}else{
				echo 2;
			}

		}
	}

}






?>