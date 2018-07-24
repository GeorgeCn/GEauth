<?php
namespace Content\Model;
use Think\Model;

class ChannelListModel extends BaseModel
{
    /**
     * 获取多条记录
     * @param array $filter
     * @param string $fields
     * @param bool $except
     * @param string $order
     * @param string $limit
     * @return mixed
     */
    public function getList(array $where, $fields = "*", $except = false, $order = 'id DESC')
    {
        return $this->where($where)->field($fields, $except)->order($order)->select();
    }

    public function getChannelInfo($id)
    {
        $where['id'] = $id;
        return $this->where($where)->find();
    }
}
