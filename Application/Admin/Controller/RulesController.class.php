<?php
namespace Admin\Controller;
class RulesController extends PrivateController
{
    /**
     * uesr 后台路由管理规则列表
     **/
    public function lists()
	{
		$this->model = D('AuthCate');
        //分配按钮
        $but = array(
            array(
                'url'   => 'ruledit',
                'name'  => '添加模块',
                'title' => '添加菜单',
                'type'  => 1 
            ),
        );
        self::isBut($but);
        $where = array(
            'status' => 1,
            'type'   => 0
        );
        $list = self::_modelCount($where);
        $dataArr = self::_modelSelect($where, 'id asc', "id,title,level,module,controller,name", $list['limit']);
        $toolsOptionArr = array(
            array('添加',1,'添加路由','useredit', U('useredit', array('id' => '___id___'))),
            array('编辑',1,'编辑路由','useredit', U('useredit', array('id' => '___id___'))),
            array('删除',2,'删除路由','adminuserdel', U('adminuserdel', array('id' => '___id___')),'你确认要删除吗？'),
        );
        $toolsOption = self::_listBut($toolsOptionArr);
        $thead = array(
        	array(
                'name'  => '序号',
                'field' => 'id',
                'width' => '120',
                'order' => 'desc'
            ),
            array(
                'name'  => '用户名',
                'field' => 'title',
                'width' => '120',
                'order' => ''
            ),
            array(
                'name'  => '等级',
                'width' => '90',
                'field' => 'level',
                'order' => ''
            ),
            array(
                'name'  => '模块',
                'width' => '150',
                'field' => 'module',
                'order' => ''
            ),
            array(
                'name'  => '控制器',
                'width' => '120',
                'field' => 'controller',
                'order' => ''
            ),
            array(
                'name'  => '路由',
                'width' => '120',
                'field' => 'name',
                'order' => ''
            ),
            array(
                'name'  => '操作',
                'width' => '80',
                'field' => '__TOOLS',
                'type'  => 'TOOLS'
            ),
        );
        foreach ($thead as $key => $value) {
            if(empty($toolsOption) && $value['field'] == '__TOOLS'){
                unset($thead[$key]);
            }
        }
        $list['toolsOption'] = $toolsOption;
        $list['thead'] = $thead;
        $list['tbody'] = $dataArr;
        if(IS_POST){
            $list['statusCode'] = 200;
            $list['message'] = '操作成功';
            die(json_encode($list));
        }
        $this->assign('list', json_encode($list));
		$this->display();
	}

	/**
     * group 后台用户分组添加编辑
     * @author 刘中胜
     * @time 2015-12-05
     **/
    public function ruledit()
    {
        $this->model = D('AuthCate');
        if(IS_POST){
            self::_modelAdd('user');
        }
        $id = I('get.id', 0, 'intval');
        if($id != 0){
            $where = array(
                'id'     => $id,
                'status' => 1
            );
            self::_oneInquire($where);
            $where = array(
                'uid' => $id
            );
            $group_id = M('group_access')->where($where)->getField('group_id', true);
            $this->assign('group_id', $group_id);
        }
        $where = array(
            'status' => 1
        );
        $list = D('Group')->dataSet($where, 'sort DESC', 'id,title');
        $this->assign('list', $list);
        $this->display();
    }
}
