<?php
/**
 * Created User: lifeng
 * Created Date: 18/3/28 11:46
 * Current User:lifeng
 * History User:lifeng
 * Description:基类，定义基础方法
 */

namespace API\Common;

use Think\Model\RelationModel;

class BaseModel extends RelationModel
{
    public function getList(
        $filter = [],
        $field = '*',
        $order = 'id desc',
        $limit = null,
        $group = 'id'
    ) {
        try {
            $query = $this->where($filter)->field($field);
            if ($order) {
                $query->order($order);
            }
            if ($limit) {
                $query->limit($limit);
            }
            if ($group) {
                $query->group($group);
            }
            return [
                'code' => 1000,
                'data' => $query->select(),
                'msg' => '查询成功'
            ];
        } catch (\Exception $e) {
            return ['code' => 1001, 'data' => [], 'msg' => '查询失败'];
        }
    }

    public function getRow($filter = [], $field = '*', $order = 'id desc')
    {
        try {
            return [
                'code' => 1000,
                'data' => $this->where($filter)->field($field)->order($order)->find(),
                'msg' => '查询成功'
            ];
        } catch (\Exception $e) {
            return ['code' => 1001, 'data' => [], 'msg' => '查询失败'];
        }
    }

    public function addData($data = [])
    {
        try {
            if (isset($data[0])) {
                $id = $this->addAll($data);
            } else {
                $id = $this->add($data);
            }
            if ($id == false) {
                return ['code' => 1002, 'data' => $id, 'msg' => '新增失败'];
            }
            return ['code' => 1000, 'data' => $id, 'msg' => '新增成功'];
        } catch (\Exception $e) {
            return ['code' => 1002, 'data' => [], 'msg' => '新增失败'];
        }
    }

    public function saveData($filter = [], $data = [])
    {
        try {
            return [
                'code' => 1000,
                'data' => $this->where($filter)->save($data),
                'msg' => '编辑成功'
            ];
        } catch (\Exception $e) {
            return ['code' => 1003, 'data' => [], 'msg' => '编辑失败'];
        }
    }

    public function deleteData($filter = [], $type = 0)
    {
        try {
            if ($type == 0) {
                $affectNums = $this->where($filter)
                    ->save(['is_delete' => 1]);
            } else {
                $affectNums = $this->where($filter)->delete();
            }
            return [
                'code' => 1000,
                'data' => $affectNums,
                'msg' => '删除成功'
            ];
        } catch (\Exception $e) {
            return ['code' => 1004, 'data' => [], 'msg' => '删除失败'];
        }
    }

    public function getCount($filter = [])
    {
        try {
            return [
                'code' => 1000,
                'data' => $this->where($filter)->count(),
                'msg' => '查询成功'
            ];
        } catch (\Exception $e) {
            return ['code' => 1001, 'data' => [], 'msg' => '查询失败'];
        }
    }
}