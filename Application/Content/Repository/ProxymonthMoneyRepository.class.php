<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/13
 * Time: 10:54
 */

namespace Content\Repository;

class ProxymonthMoneyRepository
{
    //ProxymonthMoneyModel
    private $proxyMonthMoney;

    public function __construct() {
        $this->proxyMonthMoney = D('Content/ProxymonthMoney');
    }


    /*************************** Model 映射方法 Start ********************************/

    /**
     * 添加
     */
    public function addRow ($data) {
        return $this->proxyMonthMoney->addRow($data);
    }


    /**
     * 编辑
     */
    public function saveRow ($data,$where = []) {
        return $this->proxyMonthMoney->saveRow($data, $where);
    }

    /**
     * 获取单条数据
     */
    public function getRow ($where,$field='*')
    {
        return $this->proxyMonthMoney->getRow($where,$field);
    }


    /**
     * 获取多条数据
     */
    public function getAll ($where,$field='*',$order='')
    {
        return $this->proxyMonthMoney->getAll($where,$field,$order);
	 }

    /*************************** Model 映射方法 End **********************************/


    /**
     * @param $data array 参数数组
     * @return array 数据
     * @author zhangchao
     * @description:添加and更新代理金额
     */
    public function addAndUpdateProxyMonthMoney ($data)
    {
        //定义返回数据格式
        $return = [
            'code' => 1000,
            'msg' => 'ok',
            'data' => []
        ];

        //查看根据代理和月份查看是否存在记录 如果存在就更新 不存在就新增
        $proxyMonthMoney = $this->getRow(['proxy_id'=>$data['proxy_id'],'month'=>$data['month']]);
        if ($proxyMonthMoney) {
            //存在记录就更新
            $data['update_at'] = time()-8*3600;
            unset($data['proxy_id'],$data['month']);
            if ($this->saveRow($data,['id'=>$proxyMonthMoney['id']]) === false) {
                $return['status'] = 1001;
                $return['msg'] = '更新失败';
            }
        } else {
            //不存在记录就新增
            $data['create_at'] = time()-8*3600;
            if ($this->addRow($data) === false) {
                $return['status'] = 1001;
                $return['msg'] = '新增失败';
            }
        }

        return $return;
    }


    /**
     * @param $ids array proxy_month_money表id
     * @param $displayStatus int 前台人员是否可见
     * @return array 数据
     * @author zhangchao
     * @description:更新代理奖励表前台人员是否可见
     */
    public function updateProxyMonthMoneyDisplayStatus ($ids,$displayStatus = 1)
    {
        //定义返回数据格式
        $return = [
            'code' => 1000,
            'msg' => 'ok',
            'data' => []
        ];

        if (!$ids || !is_array($ids)) {
            return $return;
        }

        $ids_str = implode(',',$ids);
        $displayStatus = ($displayStatus == 1) ? 1 : 0;
        if ($this->saveRow(['display_status'=>$displayStatus],['id'=>['in',$ids_str]]) === false) {
            $return['code'] = 1001;
            $return['msg'] = '更新失败';
        }

        return $return;
    }


    /**
     * @param $where array where条件
     * @param $limit string 比如1,10
     * @param $order string 排序
     * @return array 数据
     * @author zhangchao
     * @description:代理每月金额list查询
     */
    public function getProxyMonthMoneyList ($where,$limit,$order='')
    {
        //定义返回数据
        $return = [
            'code' => 1000,
            'msg' => 'ok',
            'data' => [
                'count' => 0,
                'data' => []
            ]
        ];

        /*
        //搜索条件
        $where_fields = ['proxy_name','channel_id','month'];
        $params_leftjoin = array();
        foreach ($where_fields as $field) {
            if (isset($where[$field]) && $where[$field]) {
                switch ($field) {
                    case 'proxy_name' :
                        $params_leftjoin['proxy_admin.name'] = ['like','%'.$where[$field].'%'];
                        break;
                    case 'channel_id' :
                        $params_leftjoin['channel_list.id'] = $where[$field];
                        break;
                    case 'month' :
                        //$params_leftjoin['proxy_month_money.month'] = $where[$field];

                        //现在要求把没有次月份的记录也展示出来
                        $params_leftjoin['_string'] = 'proxy_month_money.month is null OR proxy_month_money.month=0 OR proxy_month_money.month='.$where[$field];
                        break;
                    default :
                }
            }
        }

        //展示状态正常的代理
        $params_leftjoin['proxy_admin.status'] = 1;
        $left_obj = M('proxy_admin')
            ->join("channel_list on channel_list.id=proxy_admin.channel","left")
            ->join("proxy_month_money on proxy_month_money.proxy_id=proxy_admin.id","left")
            ->where($params_leftjoin);

        if ($order) {
            $left_obj->order($order);
        }

        if ($limit) {
            $left_obj->limit($limit);
        }

        $field = 'proxy_month_money.month,proxy_admin.id as id,proxy_admin.name as proxy_name,channel_list.channel_name,
        proxy_month_money.sum_money,proxy_month_money.deduct_money,proxy_month_money.tax_money,proxy_month_money.actual_money';

        $return['data']['data'] = $left_obj
            ->field($field)
            ->select();

        $left_obj_count = M('proxy_admin')
            ->join("channel_list on channel_list.id=proxy_admin.channel","left")
            ->join("proxy_month_money on proxy_month_money.proxy_id=proxy_admin.id","left")
            ->where($params_leftjoin);
        $return['data']['count'] = $left_obj_count->count();
        */

        //操蛋的产品 注释不写了 以后维护的人自己看代码 就让你蛋疼 因为当你知道产品的奇葩业务逻辑流程之后你会打他
        //搜索条件
        $yearMonthStart = 201801;
        $yearMonthEnd = date('Ym');
        if (!$where['month'] || $where['month'] > $yearMonthEnd) {
            return $return;
        }

        $where_fields = ['proxy_name','channel_id','month'];
        $params_leftjoin = array();
        foreach ($where_fields as $field) {
            if (isset($where[$field]) && $where[$field]) {
                switch ($field) {
                    case 'proxy_name' :
                        $params_leftjoin['proxy_admin.name'] = ['like','%'.$where[$field].'%'];
                        break;
                    case 'channel_id' :
                        $params_leftjoin['channel_list.id'] = $where[$field];
                        break;
                    default :
                }
            }
        }

        //展示状态正常的代理
        $params_leftjoin['proxy_admin.status'] = 1;
        $left_obj = M('proxy_admin')
            ->join("channel_list on channel_list.id=proxy_admin.channel","left")
            ->where($params_leftjoin);

        if ($order) {
            $left_obj->order($order);
        }

        if ($limit) {
            $left_obj->limit($limit);
        }

        $field = 'proxy_admin.id as id,proxy_admin.name as proxy_name,channel_list.channel_name';

        $list = $left_obj
            ->field($field)
            ->select();

        $left_obj_count = M('proxy_admin')
            ->join("channel_list on channel_list.id=proxy_admin.channel","left")
            ->where($params_leftjoin);
        $return['data']['count'] = $left_obj_count->count();

        if (!$list) {
            return $return;
        }

        $field = 'id,sum_money,deduct_money,tax_money,actual_money,display_status,comment';
        foreach ($list as $list_key => &$list_one) {
            $proxyMonthMoney = $this->getRow(['proxy_id'=>$list_one['id'],'month'=>$where['month']],$field);
            if ($proxyMonthMoney) {
                $list_one['proxy_month_money_id'] = $proxyMonthMoney['id'];
                $list_one['display_status'] = $proxyMonthMoney['display_status'];
                $list_one['sum_money'] = $proxyMonthMoney['sum_money'];
                $list_one['deduct_money'] = $proxyMonthMoney['deduct_money'];
                $list_one['tax_money'] = $proxyMonthMoney['tax_money'];
                $list_one['actual_money'] = $proxyMonthMoney['actual_money'];
                $list_one['comment'] = $proxyMonthMoney['comment'];
            } else {
                $list_one['proxy_month_money_id'] = 0;
                $list_one['display_status'] = 0;
                $list_one['sum_money'] = 0;
                $list_one['deduct_money'] = 0;
                $list_one['tax_money'] = 0;
                $list_one['actual_money'] = 0;
                $list_one['comment'] = '';
            }
        }

        $return['data']['data'] = $list;

        return $return;
    }


    /**
     * @param $proxy_id int 代理id
     * @param $yearMonth int 年月或者年 比如2018或者201804
     * @param $order string 排序
     * @return array 数据
     * @author zhangchao
     * @description:查询一个代理的每月金额列表
     */
    public function getProxyMonthMoney ($proxy_id=0,$yearMonth=0,$order='id DESC')
    {
        //定义返回数据
        $return = [
            'code' => 1000,
            'msg' => 'ok',
            'data' => []
        ];

        $where = [];

        if ($proxy_id) {
            $where['proxy_id'] = $proxy_id;
        }

        if ($yearMonth) {
            $where['month'] = ['like',$yearMonth.'%'];
        }

        $this->proxyMonthMoney->where($where);

        if ($order) {
            $this->proxyMonthMoney->order($order);
        }

        $result = $this->proxyMonthMoney->field('*')->select();

        //处理成需求方需要的格式
        $resultDate = [];
        if ($result) {
            foreach ($result as $resultKey => $resultOne) {
                $resultDate[$resultKey] = [
                    'month' => $resultOne['month'],
                    'sumMoney' => $resultOne['sum_money'],
                    'deductMoney' => $resultOne['deduct_money'],
                    'taxMoney' => $resultOne['tax_money'],
                    'actualMoney' => $resultOne['actual_money'],
                    'displayStatus' => $resultOne['display_status']
                ];
            }
        }

        $return['data'] = $resultDate;
        return $return;
    }




}