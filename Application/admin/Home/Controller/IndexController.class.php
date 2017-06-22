<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\AuthRuleModel;
class IndexController extends AuthController
{

    /*后台首页*/
    public function index()
    {
        $menus = $this->getMenus();
        $this->assign('menus',$menus);
        $this->assign('users',$_SESSION['USER_KEY']);
        $this->display();
    }


    protected function getMenus(){
        //获取相关权限的角色相应的权限后台菜单
        $AR = new AuthRuleModel();
        return $AR->initAuth();
    }
}