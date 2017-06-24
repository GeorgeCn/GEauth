<?php
/**
 * Created by PhpStorm.
 * User: guolixun
 * Date: 2017/5/4
 * Time: 9:21
 */
namespace Home\Controller;
use Home\Model\AuthRuleModel;
use Home\Model\AuthGroupModel;
use Think\Controller;
use Think\Auth;
use Think\Tree;

class AuthController extends Controller{
    /**
     * @return bool
     *Author:glx
     * 登录判断权限
     */
    protected function _initialize(){
        //先判断是否有用户信息
        $sess_users = $_SESSION['USER_KEY'];
        if(!$sess_users){
            $this->error("非法访问!正在跳转至登录页!",U('Public/login'));
        }
        //判断是否为超级管理员
        if($sess_users['id'] == 1){
            return true;
        }
        //下面进行权限判断
        $auth = new Auth();
        $name = strtolower(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME);
        if(!$auth->check($name,$sess_users['id'] )){
            $this->error("没有权限");
        }
    }


    public function index(){
        $uid = I('get.id',1,'intval');
        $AR = new AuthRuleModel();
        $AG = new AuthGroupModel();
        $initResult = $AR->initAuth();
        //var_dump($initResult);
        $result = $AG->_is_checkedAuth($initResult,$uid);
        //dump($result);
        //print_r(json_encode($result));
        $this->assign('data',json_encode($result,TRUE));
        if(IS_POST){
            $msg = false;
            $rulelist = I('post.lists','','string');
            $re = M('auth_group')->where("id=%d",I('post.uid',0,'intval'))->save(array('rules'=>$rulelist));
            if($re){
                $msg = true;
            }
            $this->ajaxReturn($msg,JSON);
        }
        $this->assign('uid',$uid);
        $this->display();
    }
    
}