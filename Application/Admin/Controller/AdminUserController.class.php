<?php
	namespace Admin\Controller;
	use Admin\Controller\CommonController;
	/**
	* 管理员管理
	*/
	class AdminUserController extends CommonController{
		
		// 用户列表
	    public function Userlist(){
	    	
	    	$AdminUser = D('AdminUser');
	    	$search    = I('post.search');
	    	if($search){
	    		$where     = array('uname'=>$search);
	    	}
	    	$AdminUserInfo = $AdminUser->selectList($where,'','',true);
	    	$this->assign('list',$AdminUserInfo['list']);
	    	$this->assign('show',$AdminUserInfo['show']);
			$this->display();	
		}

		// 添加后台用户
		public function addUser(){
			$this->display();
		}


		// 处理添加数据
		public function addUserOp(){
		
			$uname = I('uname');
			$pwd1  = I('pwd1');
			$pwd2  = I('pwd2');
			// 查询用户名是否存在
			$AdminUser = D('AdminUser');
			$UserInfo  = $AdminUser->getInfo(array('uname'=>$uname));
			if($UserInfo){
				$this->error('用户名已经存在',U('AdminUser/addUser'),2);
			}
			if(empty($pwd1)){
				$this->error('请输入密码',U('AdminUser/addUser'),2);
			}
			if(empty($pwd2)){
				$this->error('请输入确认密码',U('AdminUser/addUser'),2);
			}

			if($pwd1 != $pwd2){
				$this->error('两次密码不一致',U('AdminUser/addUser'),2);
			}

			$AdminUser = D('AdminUser');
			$data = array('uname'=>$uname,'pwd'=>md5(trim($pwd1)));
			$AddUserInfo = $AdminUser->addDate($data);
			if($AddUserInfo){
				$this->success('添加成功',U('AdminUser/Userlist'),2);
			}else{
				$this->error('添加失败',U('AdminUser/addUser'),2);
			}


		}
		// 查询用户名是否存在
		public function checkUserInfo(){
			$AdminUser = D('AdminUser');
			$uname = I('uname');
			$UserInfo = $AdminUser->getInfo(array('uname'=>$uname));
			if($UserInfo){
				echo 1;
			}else{
				echo 2;
			}
		}


		// 后台管理员用户禁止登陆
		public function banLogin(){
			if(IS_POST){
				$id = I('id');
				$AdminUser =D('AdminUser');
				$Info = $AdminUser->getInfo(array('id'=>$id));
				if($Info){
					if($Info['status'] == 1){
						$Info = $AdminUser->operationInfo(array('id'=>$id,'status'=>2),'id');
					}elseif ($Info['status'] == 2){
						$Info = $AdminUser->operationInfo(array('id'=>$id,'status'=>1),'id');
					}
					if($Info){
						$this->ajaxReturn(['status'=>1,'msg'=>'操作成功']);
					}else{
						$this->ajaxReturn(['status'=>0,'msg'=>'操作失败']);
					}
				}else{
					echo '此用户不存在';
					die;
				}
			}else{
				echo '非法请求';
				exit;
			}
			
		}


		// 获取验证码
		public function getCode(){
			// 发送手机验证码
			$appkey = C('APPKEY');
			$secret = C('SECRET');
			$tempid = C('TEMPLATE_CODE');
			$tel    = '18701228996';
			$Info   = getcode($appkey,$secret,$tel,$tempid);
			echo '<pre>';
			var_dump($Info);
			var_dump(session('tel_code'));
		}


		public function demo(){
			// $info = array('phone'=>'18701228995','accid'=>'befii2icuitu36o193prb4e6c5');
			// ksort($info);
			// $data = implode($info).'ZW_28imonline';
			// $data1 = md5($data);
			// // var_dump($data1);
			// var_dump(md5('admin'));
			var_dump($_SERVER['HTTP_REFERER']);
		}


	}



?>