<?php
/**
 * 角色模块
 * Created by PhpStorm.
 * User: guolixun
 * Date: 2017/5/4
 * Time: 18:47
 */
namespace Home\Controller;
use Think\Controller;

class RoleController extends Controller{

    /*
     * 角色列表
     */
    public function index(){
        $this->display();
    }
    //bootstrap-table插件获取角色数据
    public function getRolesInfo(){
        $pageSize = I('pageSize',10,intval);
        $pageIndex = I('pageIndex',1,intval);
        $roleInfoCnt = M('auth_group')->count();
        $orderInfo = M('auth_group')->page($pageIndex,$pageSize)->select();

        $returnRes['res'] = $orderInfo;
        $returnRes['total'] = $roleInfoCnt;
        print_r(json_encode($returnRes));
    }
    /**
     *Author:glx
     * 添加角色
     */
    public function role_add(){
        if(IS_POST){
            $arr['title'] = I('firstname','','string');
            $arr['desc'] = I('roledesc','','string');
            $arr['create_time'] = date('YY-mm-dd HH:ii:ss',time());
            if(M('auth_group') ->add($arr)){
                $this->success("添加成功",U('Role/index'));
            }
        }
        $this->display();
    }


    /**
     *Author:glx
     * 删除角色
     */
    public function role_del(){
        $id = I('id',0,'intval');
        $state = 0;
        if(M('auth_group')->where("id=%d",$id)->delete()){
            $state = 1;
        }
        $this->ajaxReturn($state,JSON);
    }

    /*
     * Author:glx
     * 编辑角色
     */
    public function role_edit(){
        $id = I('id',0,'intval');
        if(IS_POST){
            $arr['title'] = I('firstname','','string');
            $arr['desc'] = I('roledesc','','string');
            if(M('auth_group') ->add($arr)){
                $this->success("修改成功",U('Role/index'));
            }
        }
        $info = M('auth_group')->where("id = %d",$id)->find();
        $this->assign('info',$info);
        $this->display();
    }


    


}