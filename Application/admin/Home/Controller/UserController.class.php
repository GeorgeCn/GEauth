<?php
/**
 * 管理员模块
 * Created by PhpStorm.
 * User: guolixun
 * Date: 2017/5/4
 * Time: 11:28
 */
namespace Home\Controller;
use Think\Controller;
use Home\Model\AdminModel;
class UserController extends Controller{

    /*
     * 管理员列表
     */
    public function index(){
        $this->display();
    }
    //bootstartp-table插件获取管理员数据
    public function getAdminUsers(){
        $pageSize = I('pageSize',10,intval);
        $pageIndex = I('pageIndex',1,intval);
        $userInfoCnt = M('admin')->count();
        $userInfo = M('admin')->page($pageIndex,$pageSize)->select();
        $returnRes['res'] = $userInfo;
        $returnRes['total'] = $userInfoCnt;
        print_r(json_encode($returnRes));
    }


    /**
     *Author:glx
     * 添加管理员
     */
    public function user_add(){
        if(IS_POST){
            $ADMIN = new AdminModel();
            $arr['loginname'] = I('firstname','','string');
            $arr['pwd'] = $ADMIN ->GetMd5Pwd(I("password",'','string'));
            $arr['mobile'] = I('mobile','','string');
            $arr['email'] = I('email','','string');
            $arr['create_time'] = date('YY-mm-dd HH:ii:ss',time());
            $ar['group_id'] = I('roleid',1,'intval');
            $res = Upload($_FILES);
            if($avatar = $res['savepath'].$res['savename']){
                $arr['avatar'] = $avatar;
            }
            M()->startTrans();
            $res = $ADMIN ->add($arr);
            $ar['uid'] = $res['id'];
            $re = M('auth_group_access')->add($ar);
            if($res && $re){
                M()->commit();
                $this->success("添加成功",U('User/index'));
            }else{
                M()->rollback();
            }
        }
        $roles = M('auth_group')->select();
        $this->assign('roles',$roles);
        $this->display();
    }

    /**
     *Author:glx
     * 删除管理员
     */
    public function user_del(){
        $id = I('id',0,'intval');
        $state = 0;
        M()->startTrans();
        $re = M('admin')->where("id=%d",$id)->delete();
        $re1 = M('auth_group_access')->where("uid=%d",$id)->delete();
        if($re && $re1){
            M()->commit();
            //删除对应文件夹中的头像文件
            $ADMIN = new AdminModel();
            $ADMIN->delImg($id);
            $state = 1;
        }else{
            M()->rollback();
        }
        $this->ajaxReturn($state,JSON);
    }

    /**
     *Author:glx
     * 禁用管理员
     */
    public function user_forbin(){
        $id = I('id',0,'intval');
        $states = 2;
        if(I('type',0,'intval')){
            //启用
            $states = 1;
        }
        $state = 0;
        if(M('admin')->where("id=%d",intval($id))->save(array('states'=>$states))){
            $state = 1;
        }
        $this->ajaxReturn($state,JSON);
    }

    /*
     * 编辑管理员
     */
    public function user_edit(){
        $id = I('id',0,'intval');
        if(IS_POST){
            $ADMIN = new AdminModel();
            $arr['loginname'] = I('firstname','','string');
            $arr['mobile'] = I('mobile','','string');
            $arr['email'] = I('email','','string');
            $res = Upload($_FILES);
            if($avatar = $res['savepath'].$res['savename']){
                //删除用户之前的头像文件
                $ADMIN->delImg($id);
                $arr['avatar'] = $avatar;
            }
            M()->startTrance();
            $r = $ADMIN ->where("id=%d",$id)->save($arr);
            $re = M('auth_group_access')->where("uid=%d",$id)->save(array('group_id'=>I('roleid',0,'intval')));
            if($re && $r){
                M()->commit();
                $this->success("操作成功",U('User/index'));
            }else{
                M()->rollback();
            }
        }
        $info = M('admin')->alias('a')->join('think_auth_group_access b ON b.uid = a.id')
            ->where("a.id = %d",$id)->where("a.id = 2")
            ->field('a.id,a.loginname,a.mobile,a.email,a.avatar,b.group_id')->find();
        $roles = M('auth_group')->select();
        $this->assign('roles',$roles);
        $this->assign('info',$info);
        $this->display();
    }
    

}
