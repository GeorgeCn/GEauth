<?php
/**
 * 获取用户对应的菜单信息
 * Created by PhpStorm.
 * User: guolixun
 * Date: 2017/5/10
 * Time: 14:37
 */
namespace Home\Model;
use Think\Model;
use Think\Auth;

class AuthRuleModel extends Model{


    //用户权限列表初始化
    public function initAuth(){
        $AuthMenu = F("AuthMenu");
         if(!$AuthMenu) {
            $AuthMenu = $this->auth_cache();
        }
        return $AuthMenu;
    }
    
    private function auth_cache($data=null){
        if (empty($data)) {
            $data = M("auth_rule")->field('id,title,pid')->where('')->select();
            foreach($data as $k=>$v){
                $data[$k]['pId'] = $v['pid'];
                $data[$k]['name'] = $v['title'];
                unset($data[$k]['title']);
                unset($data[$k]['pid']);
            }
            F("AuthMenu", $data);
        } else {
            F("AuthMenu", $data);
        }
        return $data;
    }

    //更新用户权限列表缓存
    public function update_init_auth(){
        F('AuthMenu',$this->auth_cache());
    }

    //用户菜单初始化缓存
    public function initMenu(){
        $MenuCache = F("MuthMenu");
        if(!$MenuCache) {
            $MenuCache = $this->menu_cache();
        }
        return $MenuCache;
    }

    private function menu_cache($data=null){
        if (empty($data)) {
            $data = $this->getUserAuthMenus();
            F("MenuCache", $data);
        } else {
            F("MenuCache", $data);
        }
        return $data;
    }

    private function getUserAuthMenus(){
        //获取用户所属用户组
        $groups = $this->getGroup();
        $ids = array();//保存用户所属用户组设置的所有权限规则id
        foreach ($groups as $g) {
            $ids = array_merge($ids, explode(';', trim($g['rules'], ',')));
        }
        $ids = array_unique($ids);
        if(empty($ids)){
            return false;
        }
       return $this->getAuthLists($ids);
    }

    private function getAuthLists($ids){
        //$ids=array('2','3');
        $map =array(
            'id'=>array('in',$ids)
        );
        return $this->listToTree(M('auth_rule')->where($map)->select());
    }

    protected function getGroup(){
        $uid = $_SESSION['USER_KEY']['id'] ? $_SESSION['USER_KEY']['id']:'';
      //  static $groups = array();
//        if (isset($groups[$uid]))
//            return $groups[$uid];
        $user_groups = M()
            ->table('THINK_AUTH_GROUP_ACCESS'. ' a')
            ->where("a.uid='$uid' and g.status='1'")
            ->join('THINK_AUTH_GROUP'." g on a.group_id=g.id")
            ->field('uid,group_id,title,rules')->select();
        //$groups=$user_groups?:array();
        return $user_groups;
    }

    /*
    * 根据pid重新组装菜单信息
    */
    private function listToTree($list,$pk='id',$pid='pid',$child='_child',$root=0) {
        // 创建Tree
        $tree = array();
        if(is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] =& $list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId =  $data[$pid];
                if ($root == $parentId) {
                    $tree[] =& $list[$key];
                }else{
                    if (isset($refer[$parentId])) {
                        $parent =& $refer[$parentId];
                        $parent[$child][] =& $list[$key];
                    }
                }
            }
        }
        return $tree;
    }



}