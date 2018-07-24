<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/13
 * Time: 10:53
 */

namespace Content\Model;

class ProxyStudentModel extends BaseModel
{
    protected $tableName = 'proxy_student';

    /**
     * 添加
     */
    public function addRow ($data){
        return $this->add($data);
    }


    /**
     * 编辑
     */
    public function saveRow ($data,$where = []) {
        return $where ? $this->where($where)->save($data) : $this->save($data);
    }


    /**
     * 获取单条数据
     */
    public function getRow ($where,$field='*')
    {
        return $this->field($field)->where($where)->find();;
    }


    /**
     * 获取多条数据
     */
    public function getAll ($where,$field='*',$order='')
    {
        $this->field($field)->where($where);

        if ($order) {
            $this->order($order);
        }

        return $this->select();
    }


    /**
     * 获取数量
     */
    public function getCount ($where=[]) {
        return $this->where($where)->count();
    }

    /**
     * @param string $field
     * @param array $where
     * @param $order
     * @return mixed
     */
    public function getProxyStudent ($field='*',$where=[],$order = 'student_user.create_time DESC') {
        $result = $this->field($field)
            ->join('LEFT JOIN student_user ON student_user.id = proxy_student.stu_id')
            ->join('LEFT JOIN activity ON activity.id = proxy_student.activity_id')
            ->where($where)
            ->order($order)
            ->select();
        return $result;
    }


}