<?php
/**
 * 菜单模块
 * Created by PhpStorm.
 * User: guolixun
 * Date: 2017/5/4
 * Time: 9:21
 */
namespace Home\Controller;
use Think\Controller;
use Home\Model\AuthRuleModel;
class MenuController extends Controller
{
    public function index(){
        $this->display();
    }

    public function getMenu(){
        $pageSize = I('pageSize',10,intval);
        $pageIndex = I('pageIndex',1,intval);
        $roleInfoCnt = M('auth_rule')->count();
        $orderInfo = M('auth_rule')->page($pageIndex,$pageSize)->select();
        $returnRes['res'] = $orderInfo;
        $returnRes['total'] = $roleInfoCnt;
        print_r(json_encode($returnRes));
    }

    //节点添加
    public function node_add(){
        $AR = new AuthRuleModel();
        $initResult = $AR->initAuth();
        $this->assign('data',json_encode($initResult,TRUE));
        if(IS_POST){
            //$msg = false;
            $data['name'] = I('post.firstname','','string');
            $data['title'] = strtolower(I('post.roledesc','','string'));
            $data['pid'] = I('post.pid',0,'intval');
            //var_dump($data);
            //exit;
            if(M('auth_rule')->add($data)){
                $AR = new AuthRuleModel();
                $AR->update_init_auth();
                $this->redirect('Menu/index');
            }
            //$this->ajaxReturn($msg,JSON);
        }
        $this->display();
    }


}