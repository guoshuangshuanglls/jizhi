<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
class IndexController extends CommonController {
    public function index(){
    	$this->display('index');
    }

    public function welcome(){
    	$userInfo = session('userInfo');
        S('user',$userInfo);
    	$this->assign('uname',$userInfo['uname']);
    	$this->display();
    }

    public function myInfo(){
    	$userInfo = session('userInfo');
    	$this->assign('userInfo',$userInfo);
    	$this->display();
    }
}