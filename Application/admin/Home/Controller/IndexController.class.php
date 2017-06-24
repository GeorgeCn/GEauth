<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\AuthRuleModel;
class IndexController extends Controller
{

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

    /*后台首页*/
    public function index()
    {
        $menus = $this->getMenus();
        $this->assign('menus',$menus);
        $this->assign('users',$_SESSION['USER_KEY']);
        $this->display();
    }

    /*后台首页的主页*/
    public function index_v1(){
        $loginInfo = array();
        //获取用户登陆信息
        $loginInfo['ip'] = $_SERVER['REMOTE_ADDR'];
        $loginInfo['time'] = date('Y-m-d H:i:d',time());
        //$loginInfo['']
        $this->assign('loginInfo',$loginInfo);
        $this->display();
    }


    protected function getMenus(){
        //获取相关权限的角色相应的权限后台菜单
        $AR = new AuthRuleModel();
        return $AR->initMenu();
    }
}