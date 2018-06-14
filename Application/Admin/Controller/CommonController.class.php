<?php
	namespace Admin\Controller;
	use Think\Controller;
	/**
	 * 公共控制器
	 */
	 class CommonController extends Controller
	 {
	 	
	 	public function __construct()
	 	{
	 		if(!session('user_login')){
	 			$this->redirect('Login/index');
	 		}
	 		parent::__construct();
	 		
	 	}
	 } 



?>