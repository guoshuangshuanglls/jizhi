<?php
	namespace Admin\Controller;
	use Think\Controller;
	/**
	* 后台登陆
	*/
	class LoginController extends Controller{
		public function index(){
			if(session('user_login')){
				$this->redirect('Index/index');
			}
	
			$this->display();
		}

		public function loginMen(){
			$verify  = I('post.verify',0,'intval');
			$username= I('post.username');
			$password= I('post.password');
			if(empty($username)){
				$this->error('请输入用户名',U('Login/index'));
			}
			if(empty($password)){
				$this->error('请输入密码',U('Login/index'));
			}

			if(empty($verify)){
				$this->error('请输入验证码',U('Login/index'));
			}
			if(!$this->check_verify($verify, 1)) $this->error('验证码错误',U('Login/index'));

			$AdminUser = D('AdminUser');
			$UserInfo  = $AdminUser->getInfo(array('uname'=>$username,'pwd'=>md5(trim($password))));
		
			if(empty($UserInfo)){
				$this->error('用户名或密码错误',U('Login/index'));
			}else{
				session('user_login',true);
				session('userInfo',array('id'=>$UserInfo['id'],'uname'=>$username));
				$this->success('登录成功',U('Index/index'));
			}



		}


		// 退出登录
		public function loginout(){
			session(null);
			redirect(U('Login/index'));
		}


		// 获取验证码
	    public function verify() {
	        $config = array(
	            'expire'   => 120,
	            'length'   => 4,
	            'imageW'   => 200,
	            'imageH'   => 50,
	            'useCurve' => false,
	            'fontSize' => 25,
	            'codeSet'  => '0123456789'
	        );
	        $Verify = new \Think\Verify($config);
	        $Verify->entry(1);
	    }

	    private function check_verify($code, $id = '') {
	        $verify = new \Think\Verify();
	        return $verify->check($code, $id);
	    }
	}






?>