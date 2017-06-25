<?php
/**
 * 通用继承类
 * Created by PhpStorm.
 * User: guolixun
 * Date: 2017/6/25
 * Time: 上午11:55
 */
namespace Home\Controller;
use Think\Controller;
use Think\Auth;

class CommonController extends Controller{
    //权限验证
    public function _initialize(){
        //先判断是否有用户信息
        $user_key = $_SESSION['USER_KEY'];
        if(!$user_key){
            $this->error("非法访问!正在跳转至登录页!",U('Public/login'));
        }
        //判断是否为超级管理员
        if($user_key['id'] == 1){
            return true;
        }
        //下面进行权限判断
        $auth = new Auth();
        $name = strtolower(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME);
        if(!$auth->check($name,$user_key['id'] )){
            $this->error("没有权限");
        }
    }
}
