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
use Home\Controller\CommonController;

class AuthController extends CommonController{

    public function index(){
        $uid = I('get.id',1,'intval');
        $AR = new AuthRuleModel();
        $AG = new AuthGroupModel();
        $initResult = $AR->initAuth();
        $result = $AG->_is_checkedAuth($initResult,$uid);
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