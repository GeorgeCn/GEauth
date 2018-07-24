<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/13
 * Time: 10:53
 */

namespace Content\Model;

class ProxyAdminModel extends BaseModel
{
    protected $tableName = 'proxy_admin';

    /**
     * 添加
     */
    public function addRow ($data){
        $data['create_time'] = utctime();

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
        return $this->field($field)->where($where)->find();
    }


    /**
     * 获取多条数据
     */
    public function getAll ($where,$field='*',$order = 'id desc',$limit)
    {
        $this->field($field)->where($where)->limit($limit)->order('id desc');

        if ($order) {
            $this->order($order);
        }else{
            $this->order('id desc');
        }

        return $this->select();
    }

    /**
     * [获取查询数量]
     * @Author   George  
     * @DateTime 2018-04-18T15:44:59+0800
     * @param    [type]                   $where                 [description]
     * @param    string                   $field                 [description]
     * @param    string                   $order                 [description]
     * @param    [type]                   $limit                 [description]
     * @return   [type]                                          [description]
     */
    public function getAllCount ($where,$field='*',$order='',$limit)
    {
        $this->field($field)->where($where)->limit($limit);

        if ($order) {
            $this->order($order);
        }

        return $this->count();
    }

    public function getProxyUrlById ($where,$field='*',$order='',$limit)
    {
        $this->field($field)
            ->join('LEFT JOIN proxy_activity_channel ON proxy_admin.channel = proxy_activity_channel.channel_id')
            ->group('proxy_admin.id,proxy_activity_channel.activity_id')
            ->where($where)->limit($limit);
        if ($order) {
            $this->order($order);
        }
        return $this->select();
    }
}