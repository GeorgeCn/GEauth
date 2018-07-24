<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/13
 * Time: 10:54
 */

namespace Content\Repository;

class ProxyActivityChannelRepository
{
    private $proxyActivityChannel;

    public function __construct()
    {
        $this->proxyActivityChannel = D('Content/proxyActivityChannel');
    }


    /*************************** Model 映射方法 Start ********************************/

    /**
     * 添加
     */
    public function addRow($data)
    {
        return $this->proxyActivityChannel->addRow($data);
    }


    /**
     * 编辑
     */
    public function saveRow($data, $where = [])
    {
        return $this->proxyActivityChannel->saveRow($data, $where);
    }

    /**
     * 获取单条数据
     */
    public function getRow($where, $field = '*')
    {
        return $this->proxyActivityChannel->getRow($where, $field);
    }


    /**
     * 获取多条数据
     */
    public function getAll($where, $field = '*', $order = '')
    {
        return $this->proxyActivityChannel->getAll($where, $field, $order);
    }

    /*************************** Model 映射方法 End **********************************/

    /**
     * @param $activity_id int 活动id
     * @param $proxy_id int 代理id
     * @param $channel_id int 渠道id
     * @param $start_time int 开始时间
     * * @param $end_time int 结束时间
     * @return array 列表
     * @author zhangcheng
     * @description:获取活动代理列表
     */
    public function getProxyActivityList(
        $activity_id = 0,
        $proxy_id = 0,
        $channel_id = 0,
        $start_time = 0,
        $end_time = 0,
        $status = 2,
        $limit = '0,10',
        $field = '*'
    ) {
        $where = [];

        if ($activity_id) {
            $where['proxy_activity_channel.activity_id'] = $activity_id;
        }
        if ($proxy_id) {
            $where['proxy_admin.id'] =['in', explode(',',implode(',',$proxy_id['data']))];
        }

        if ($channel_id) {
            $where['proxy_activity_channel.channel_id'] = ['IN',$channel_id];
        }

        if ($start_time) {
            $where['proxy_admin.create_time'] = ['EGT', $start_time];
        }

        if ($end_time) {
            $where['proxy_admin.create_time'] = ['ELT', $end_time];
        }

        $data = $this->proxyActivityChannel->getAll($where, '*,proxy_admin.id as pid', '', $limit);
        $count = $this->proxyActivityChannel->getAllCount($where, 'proxy_admin.id as id', '', $limit);

        if ($data) {
            $result = [
                'code' => 1000,
                'msg' => '查询成功',
                'data' => $data,
                'count' => $count,
            ];
            return $result;
        } else {
            $result = [
                'code' => 1001,
                'msg' => '没有数据',
                'data' => [],
                'count' => 0,
            ];
            return $result;
        }
    }
}