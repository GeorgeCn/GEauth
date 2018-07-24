<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/13
 * Time: 10:54
 */

namespace Content\Repository;

class ProxyAdminRepository
{
    //ProxyAdminModel
    private $proxyAdmin;

    public function __construct()
    {
        $this->proxyAdmin = D('Content/ProxyAdmin');
    }


    /*************************** Model 映射方法 Start ********************************/

    /**
     * 添加
     */
    public function addRow($data)
    {
        return $this->proxyAdmin->addRow($data);
    }


    /**
     * 编辑
     */
    public function saveRow($data, $where = [])
    {
        return $this->proxyAdmin->saveRow($data, $where);
    }

    /**
     * 获取单条数据
     */
    public function getRow($where, $field = '*')
    {
        return $this->proxyAdmin->getRow($where, $field);
    }


    /**
     * 获取多条数据
     */
    public function getAll($where, $field = '*', $order = '')
    {
        return $this->proxyAdmin->getAll($where, $field, $order);
    }

    /*************************** Model 映射方法 End **********************************/

    /**
     * 根据代理名称查询代理ID 模糊匹配
     */
    public function getProxyAdminIds($name)
    {
        $proxyAdmin = $this->proxyAdmin->getAll([
            'name' => [
                'like',
                '%' . $name . '%'
            ]
        ], 'id');
        if ($proxyAdmin) {
            $result = [
                'code' => 1000,
                'msg' => '查询成功',
                'data' => array_column($proxyAdmin, 'id'),
            ];
            return $result;
        } else {
            $result = [
                'code' => 1001,
                'msg' => '没有数据',
                'data' => [],
            ];
            return $result;
        }
    }

    /**
     * @param $proxy_id int 代理id
     * @param $channel_id int 渠道id
     * @param $start_time int 开始时间
     * * @param $end_time int 结束时间
     * @return array 列表
     * @author zhangcheng
     * @description:获取代理列表
     */
    public function getProxyAdminList(
        $proxy_id = 0,
        $channel_id = 0,
        $start_time = 0,
        $end_time = 0,
        $status = 2,
        $phone = 0,
        $limit = '0,10',
        $field = ''
    ) {
        $where = [];

        if ($proxy_id) {
            $where['proxy_admin.id'] = ['in', $proxy_id];
        }

        if ($channel_id) {
            $where['proxy_admin.channel'] = ['in', $channel_id];
        }
        
        if ($start_time && $end_time) {
            $where['proxy_admin.create_time'] = ['BETWEEN',"$start_time,$end_time"];
        }
        if ($status) {
            $where['proxy_admin.status'] = $status;
        }
        if ($phone) {
            $where['proxy_admin.phone'] = $phone;
        }
        $data = $this->proxyAdmin->getAll($where, $field, '', $limit);
        $count = $this->proxyAdmin->getAllCount($where, '', '', $limit);
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

    /**
     * 获取代理人信息
     */
    public function getProxyInfo($where)
    {
        $proxyAdmin = $this->proxyAdmin->getRow($where);
        if ($proxyAdmin) {
            $result = [
                'code' => 1000,
                'msg' => '查询成功',
                'data' => $proxyAdmin,
            ];
            return $result;
        } else {
            $result = [
                'code' => 1001,
                'msg' => '没有数据',
                'data' => [],
            ];
            return $result;
        }
    }

    /**
     * 代理人注册,如果存在并且为未审核，自动转为已审核
     * @param $data
     * @return array
     */
    public function proxyRegister($data)
    {
        $result = [
            'code' => 1002,
            'msg' => '添加失败',
        ];
        $proxyAdmin = $this->proxyAdmin->getRow(['name' => $data['name'], 'channel' => $data['channel']]);
        if (!$proxyAdmin) {
            $id = $this->proxyAdmin->addRow($data);
            if ($id) {
                $result = [
                    'code' => 1000,
                    'msg' => '添加成功',
                    'data' => $id,
                ];
            }
        } elseif ($proxyAdmin['status'] == 2 && $proxyAdmin['phone'] == '') {
            $this->proxyAdmin->saveRow(['phone' => $data['phone'], 'status' => 1],
                ['id' => $proxyAdmin['id']]);
            $result = [
                'code' => 1000,
                'msg' => '添加成功',
                'data' => $proxyAdmin['id'],
            ];
        }
        return $result;
    }

    /**
     * 获取代理二维码url
     * @param $id 代理id
     * @return array
     */
    public function proxyUrl($id)
    {
        $data = $this->proxyAdmin->getProxyUrlById(['proxy_admin.id' => $id],"*,proxy_admin.id as id");
        foreach ($data as $value) {
            if($value['activity_id']) {
                $result[] ="https://uathome.uuabc.com/activity/zhkcb.html"."?channel_id=".$value['channel']."&activity_id=".$value['activity_id']."&proxy_id=".$value['id'];
            }
            
            //$result[] =$_SERVER['HTTP_HOST']."/activity/zhkcb.html"."?channel_id=".$value['channel']."&activity_id=".$value['activity_id']."&proxy_id=".$value['id'];
        }
        if ($result) {
            $results = [
                'code' => 1000,
                'msg' => '查询成功',
                'data' => $result,
            ];
            return $results;
        } else {
            $results = [
                'code' => 1001,
                'msg' => '没有数据',
                'data' => [],
            ];
            return $results;
        }
    }
}