<?php
/**
 * Created User: lifeng
 * Created Date: 18/3/26 13:22
 * Current User:lifeng
 * History User:lifeng
 * Description:repository基类，定义增删改成四种基本操作，和select条件build
 */

namespace API\Common;


class BaseRepository
{
    protected $model;

    /**
     * @param array $filter 条件
     * @param array $field 字段
     * @param $order 排序
     * @param $limit 条数
     * @param $group  分钟
     * @return array
     * @author lifeng
     * @description:查询列表
     */
    function findList($filter = [], $field = '*', $order = 'id desc', $limit = null, $group = null)
    {
        return $this->model->getList($filter, $field, $order, $limit, $group);

    }

    protected function checkFilter($validOption, $filter)
    {

    }

    /**
     * @param array $filter 条件
     * @param string $field
     * @param string $order
     * @return array
     * @author lifeng
     * @description:查询多条数据
     */
    function find($filter = [], $field = '*', $order = 'id desc')
    {
        return $this->model->getRow($filter, $field, $order);

    }

    /**
     * @param array $data 数据
     * @return int
     * @author lifeng
     * @description:添加数据
     */
    function addData($data)
    {
        if (isset($data[0])) {
            return $this->model->addAll($data);

        } else {
            return $this->model->add($data);

        }

    }

    /**
     * @param array $filter 条件
     * @param array $data 新数据
     * @return int
     * @author lifeng
     * @description:编辑数据
     */
    function editData($filter, $data)
    {
        return $this->model->saveData($filter, $data);
    }

    /**
     * @param array $filter 条件
     * @param bool type 删除类型0为逻辑删除，1为物理删除
     * @return int
     * @author lifeng
     * @description:删除数据
     */
    function deleteData($filter, $type = 0)
    {
        return $this->model->deleteData($filter, $type);
    }

    public function getCount($filter)
    {
        return $this->model->getCount($filter);
    }
}