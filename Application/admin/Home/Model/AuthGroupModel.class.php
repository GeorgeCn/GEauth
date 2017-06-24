<?php
/**
 * Created by PhpStorm.
 * User: guolixun
 * Date: 2017/5/11
 * Time: 16:53
 */
namespace Home\Model;
use Think\Model;

class AuthGroupModel extends Model{

    /*
     * create glx
     * 判断选中的角色权限
     * $data 初始化的权限列表
     * $id 角色id
     *
     */
    public function _is_checkedAuth($data,$id){
        $listsArr = $this->getAuthLists($id);
        foreach($data as $k=>$v){
            foreach($listsArr as $vo){
                //if(in_array($v['id'],$listsArr) ){
                    $data[$k]['checked'] = 'true';
                //}
            }
        }
        return $data;
    }

    //获取角色的管理权限列表
    private function getAuthLists($id){
        $listsStr =  M('auth_group')->where("id=%d",$id)->getField('rules');
        return explode(';',rtrim($listsStr,';'));
    }

}