<?php

namespace Home\Controller;
use Home\Model\AdminModel;
use Think\Controller;

class PublicController extends Controller{

	public function login(){
		if(IS_POST){
			$ADMIN = new AdminModel();
			$pwd = $ADMIN->GetMd5Pwd(I('password','','string'));
			$res = M('admin')->where(array('loginname'=>I('username'),'pwd'=>$pwd))->find();
			if($res){
				$_SESSION['USER_KEY'] = $res;
				$this->redirect('Index/index');
			}else{
				$this->error("账号与密码不匹配");
			}
		}
		$this->display();
	}

	//登出
	public function logout(){
		session_destroy();
		$this->redirect("Public/login");
	}

	public function header(){
		$this->display();
	}

	//尾部文件
	public function footer(){
		$this->display();
	}

	//菜单文件
	public function menu(){
		$this->display();
	}
}