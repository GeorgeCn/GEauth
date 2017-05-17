<?php
/**
 * Created by PhpStorm.
 * User: guolixun
 * Date: 2017/5/10
 * Time: 14:37
 */
namespace Home\Model;
use Think\Model;

class AuthRuleModel extends Model{
    protected $AUTHROLE;

    public function initAuth(){
        $AuthMenu = F("AuthMenu");
         if(!$AuthMenu) {
            $AuthMenu = $this->menu_cache();
        }
        return $AuthMenu;
    }

    private function menu_cache($data=null){
        if (empty($data)) {
            $data = M("auth_rule")->field('id,title,pid')->select();
            foreach($data as $k=>$v){
                $data[$k]['name'] = $v['title'];
                $data[$k]['pId'] = $v['pid'];
                unset($data[$k]['title']);
                unset($data[$k]['pid']);
            }
            F("AuthMenu", $data);
        } else {
            F("AuthMenu", $data);
        }
        return $data;
    }

    /*递归
    * 将节点转换成树形结构的数组
    */
    private function listToTree($id=0) {
        $nodes = M("auth_rule");
        $data = $nodes->where("pid=".$id)->fileds()->select();
        if(empty($data)){
            return null;
        }
        foreach ($data as $k=>$v){
            $rescurtree =  $this->listToTree($v['id']);
            if(null != $rescurtree){
                $data[$k]['children'] = $rescurtree;
            }
        }
        return $data;
    }



}