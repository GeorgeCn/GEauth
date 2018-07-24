<?php
namespace Content\Model;
class BaseModel extends \Common\Model\PublicModel{
    /*
    * 添加
    */
    public function addData($data){
        return $this->data($data)->add();
    }

    /*
    * 编辑
    */
    public function saveData($where,$data){
        return $this->where($where)->data($data)->save();
    }

    /*
    * 删除
    */
    public function daleteData($where){
        return $this->where($where)->delete();
    }
    /**
     * 获取列表
     * @param array $where 筛选条件
     * @param string $fields 字段
     * @param bool $order
     * @return array|bool
     * */
    public  function getList($where=array(),$fields='*',$order='id DESC'){
        return $this ->where($where)->order($order)->field($fields)->select();
    }

    /**
     * 获取单条数目
     *
     * @param array $filter 筛选条件
     * @param string $fields 字段
     * @param bool $except 字段是否是排除
     * @return array|bool
     * */
    public function getRow(array $filter, $fields = "*", $except = false,$order='')
    {
        $result = $this->where($filter)->field($fields, $except);
        if($order){
            $result->order($order);
        }
        return $result->find();
    }
}