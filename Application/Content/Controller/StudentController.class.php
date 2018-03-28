<?php
namespace Content\Controller;
class StudentController extends PublicController{
	/**
     * student 后台学生管理学生列表
     **/
    public function lists()
	{
		$this->model = D('Student');
		$but = array(
            array(
                'url'   => 'lists',
                'name'  => '搜索',
                'title' => '搜索条件',
                'type'  => 2
            ),
        );
        self::isBut($but);
        $id = I('post.id', 0, 'intval');
        if($id != 0){
            $where = array(
                'id'     => $id,
                'disabled' => 0
            );
        } else {
	        $where = array(
	            'disabled' => 1
	        );
        }
        $list = self::_modelCount($where);
        $dataArr = self::_modelSelect($where, 'id asc', "id,name,sex,birthday,status,created_time", $list['limit']);
        // dump($dataArr);exit;
        foreach ($dataArr as $key => &$value) {
            if($value['sex'] == 0){
                $value['sex'] = '保密';
            } else if($value['sex'] == 1) {
                $value['sex'] = '男';
            } else {
            	$value['sex'] = '女';
            }
            if($value['status'] == 1){
                $value['status'] = '待处理';
            } else {
            	$value['status'] = '暂无';
            }
            $value['created_time'] = formatTime($value['created_time']);
            
        }
        unset($value);
        $toolsOptionArr = array(
            array('编辑',1,'编辑路由','useredit', U('ruledit', array('id' => '___id___'))),
            array('删除',2,'删除路由','adminuserdel', U('ruledel', array('id' => '___id___')),'你确认要删除吗？'),
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
                'field' => 'name',
                'width' => '120',
                'order' => ''
            ),
            array(
                'name'  => '性别',
                'field' => 'sex',
                'width' => '120',
                'order' => 'desc'
            ),
            array(
                'name'  => '出生日期',
                'field' => 'birthday',
                'width' => '120',
                'order' => ''
            ),
            array(
                'name'  => '状态',
                'field' => 'status',
                'width' => '120',
                'order' => ''
            ),
            array(
                'name'  => '创建时间',
                'field' => 'created_time',
                'width' => '120',
                'order' => ''
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
}