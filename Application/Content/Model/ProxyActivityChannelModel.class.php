<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/13
 * Time: 10:53
 */

namespace Content\Model;

class ProxyActivityChannelModel extends BaseModel
{
    protected $tableName = 'proxy_activity_channel';

    protected $tableAdmin = 'proxy_admin';

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
     * 获取活动列表多条数据
     */
    public function getAll ($where,$field='*',$order='',$limit)
    {
        $this->field($field)
        ->join('LEFT JOIN proxy_admin ON proxy_admin.channel = proxy_activity_channel.channel_id')
        ->group('proxy_activity_channel.activity_id,proxy_admin.id')
        ->where($where)->limit($limit);
        if ($order) {
            $this->order($order);
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
      $data= $this->field($field)
            ->join('LEFT JOIN proxy_admin ON proxy_admin.channel = proxy_activity_channel.channel_id')
            ->group('proxy_activity_channel.activity_id,proxy_admin.id')
            ->where($where)->select();
        return count($data);

    }

}