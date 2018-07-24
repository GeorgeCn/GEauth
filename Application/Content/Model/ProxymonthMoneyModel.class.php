<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/13
 * Time: 10:53
 */

namespace Content\Model;

class ProxymonthMoneyModel extends BaseModel
{
    protected $tableName = 'proxy_month_money';

    /**
     * 添加
     */
    public function addRow ($data){
        $data['create_at'] = utctime();
        $data['update_at'] = utctime();

        return $this->add($data);
    }


    /**
     * 编辑
     */
    public function saveRow ($data,$where = []) {
        $data['update_at'] = utctime();

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



}