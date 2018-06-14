<?php
namespace Admin\Controller;
use Think\Controller;
/**
* 文章管理
*/
class ArticleController extends CommonController{
	// 文章列表
	public function ArticleList(){
		
		$ArticleModel = D('Article');
		$search_keyword = I('post.search_keyword');
		if($search_keyword){
			$where = array('status'=>1,'art_name|art_desc|content'=>array('like','%'.$search_keyword.'%'));
		}else{
			$where = array('status'=>1);
		}
		$list = $ArticleModel->selectList($where,'','',true);
		$admin_user_Model = D('AdminUser');
		$user_Model = D('User');
		$ArticleCateModel = D('ArticleCate');
		$page = $list['show'];
		$list = $list['list'];

		foreach ($list as $key => &$value) {

			if($value['u_type'] == 1){
				$list[$key]['username'] = $admin_user_Model->getInfo(array('id'=>$value['uid']))['uname'];
			}elseif ($value['u_type'] == 2) {
				$list[$key]['username'] = $user_Model->getInfo(array('id'=>$value['uid']))['username'];
			}

			$value['big_name'] = $ArticleCateModel->getInfo(array('id'=>$value['big_cid']))['cate_name'];
			$value['sm_name'] = $ArticleCateModel->getInfo(array('id'=>$value['sm_cid']))['cate_name'];
			$value['article_date'] = date('Y-m-d H:i:s',$value['intime']);
		}
		$this->assign('list',$list);
		$this->assign('page',$page);
		$this->display();
	}


	// 文章添加发布
	public function addArticle(){

		// 获取文章分类
		$ArticleCateModel = D('ArticleCate');
		$ArticleCateList  = $ArticleCateModel->selectList(array('pid'=>0,'status'=>1),'','',false);
		
		foreach ($ArticleCateList as $key => $value) {
			$ArticleCateList[$key]['child'] = $ArticleCateModel->selectList(array('pid'=>$value['id'],'status'=>1),'','',false);
		}
		$this->assign('ArticleCateList',$ArticleCateList);
		$this->display();
	}


	// 获取小分类
	public function AjaxgetSmCid(){
		if(IS_POST){
			$big_cid = I('cateid');
			$ArticleCateModel = D('ArticleCate');
			$childInfo = $ArticleCateModel->selectList(array('pid'=>$big_cid,'status'=>1),'','',false);
			$this->ajaxReturn($childInfo);
		}else{
			echo '非法请求';
		}
		

	}

	// 处理添加文章
	public function postArticleHandle(){
		
		$art_name = I('art_name');
		$art_desc = I('art_desc');
		$cateid   = I('cateid');
		$subcateid= I('subcateid');
		$article_readnum_v = I('article_readnum_v');
		$article_likenum_v = I('article_likenum_v');
		$editorValue = I('editorValue');
		$ArticleModel = D('Article');
		$uid = session('userInfo.id');
		$u_type = 1;
		$data = array('art_name'=>$art_name,'art_desc'=>$art_desc,'content'=>$editorValue,'big_cid'=>$cateid,'sm_cid'=>$subcateid,'like_num'=>$article_likenum_v,'look_num'=>$article_readnum_v,'intime'=>time(),'indate'=>date('Y-m-d',time()),'status'=>1,'uid'=>$uid,'u_type'=>$u_type);

		$art_id = $ArticleModel->operationInfo($data);
		if($art_id){

			if($_FILES['resp_pic']){
				// 处理上传图片
				$upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     3145728 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $savePath = WEB_ROOT.DS.'uplode'.DS.'data'.DS.'resp_pic'.DS;
			    $Info = $this->creatDir($savePath);
			    $upload->rootPath  =     $savePath; // // 设置附件上传根目录
			    $upload->autoSub   = false;
			    $upload->saveName  = $art_id.'_resp_pic';
			    // 上传文件 
			    $info   =   $upload->upload();
			    
			    if(!$info) {
			    // 上传错误提示错误信息
			        $this->error('文章添加成功，但是封面图上传失败，重新上传封面图',U('ArticleList'));
			        die;
			    }else{// 上传成功

			    	$data = array('id'=>$art_id,'resp_pic'=>DS.'uplode'.DS.'data'.DS.'resp_pic'.DS.$art_id.'_resp_pic.'.$info['resp_pic']['ext']);
			    	$ArticleModel->operationInfo($data,'id');
			        $this->success('添加成功',U('ArticleList'));
			        die;
			    }
			}

			$this->success('添加成功',U('ArticleList'));
			die;
		}else{
			$this->success('添加失败',U('addArticle'));
			die;
		}

	}


	// 修改
	public function updateArticle(){
		$artid = I('artid');
		$ArticleModel = D('Article');
		$ArtInfo      = $ArticleModel->getInfo(array('id'=>$artid));
		// 查询所有分类
		$ArticleCateModel = D('ArticleCate');
		$big_list = $ArticleCateModel->selectList(array('pid'=>0),'','',false);
		$sm_list  = $ArticleCateModel->selectList(array('pid'=>$ArtInfo['big_cid']),'','',false);
		$this->assign('art_id',$artid);
		$this->assign('big_list',$big_list);
		$this->assign('sm_list',$sm_list);
		$this->assign('ArtInfo',$ArtInfo);
		$this->display();
		
	}



	// 修改操作
	public function uploadArticleHandle(){
		$ArticleModel = D('Article');
		$art_id = I('art_id');
		$art_name = I('art_name');
		$art_desc = I('art_desc');
		$cateid   = I('cateid');
		$subcateid= I('subcateid');
		$article_readnum_v = I('article_readnum_v');
		$article_likenum_v = I('article_likenum_v');
		$editorValue = I('editorValue');
		$data = array('art_name'=>$art_name,'art_desc'=>$art_desc,'content'=>$editorValue,'big_cid'=>$cateid,'sm_cid'=>$subcateid,'like_num'=>$article_likenum_v,'look_num'=>$article_readnum_v,'id'=>$art_id);
		$InforReturn = $ArticleModel->operationInfo($data,'id');

		if($_FILES['resp_pic']['tmp_name']){
			// 处理上传图片
			$upload = new \Think\Upload();// 实例化上传类
		    $upload->maxSize   =     3145728 ;// 设置附件上传大小
		    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		    $savePath = WEB_ROOT.DS.'uplode'.DS.'data'.DS.'resp_pic'.DS;
		    $Info = $this->creatDir($savePath);
		    $upload->rootPath  =     $savePath; // // 设置附件上传根目录
		    $upload->autoSub   = false;
		    $upload->saveName  = $art_id.'_resp_pic';

		    // 删除原有图片
		    $ArticleInfo = $ArticleModel->where(array('id'=>$art_id))->find();
		    if($ArticleInfo['resp_pic']){
		    	if(file_exists(WEB_ROOT.$ArticleInfo['resp_pic'])){
			    	unlink(WEB_ROOT.$ArticleInfo['resp_pic']);
			    }
		    }

		    // 上传文件 
		    $info   =   $upload->upload();
		    if(!$info) {
		    // 上传错误提示错误信息
		        $this->error('封面图上传失败，重新上传封面图',U('updateArticle',array('artid'=>$art_id)));
		        die;
		    }else{// 上传成功

		    	$data = array('id'=>$art_id,'resp_pic'=>DS.'uplode'.DS.'data'.DS.'resp_pic'.DS.$art_id.'_resp_pic.'.$info['resp_pic']['ext']);
		    	$ArticleModel->operationInfo($data,'id');
		        $this->success('修改成功',U('ArticleList'));
		        die;
		    }
		}


	}

	// 删除文章
	public function deleteArticle(){
		$ArticleModel = D('Article');
		$artid = I('artid');
		$Info  = $ArticleModel->operationInfo(array('status'=>2,'id'=>$artid),'id');
		if($Info){
			$this->success('删除成功',U('ArticleList'));
		}else{
			$this->error('删除失败',U('ArticleList'));
		}
	}


	// 创建文件夹
	public function creatDir($dirPath){
		$state = false;
        if(!is_dir($dirPath)){
            $state = mkdir($dirPath,0777,true);
        }
        return $state;
	}



}






?>