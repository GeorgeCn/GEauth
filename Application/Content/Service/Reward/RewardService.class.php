<?php
/**
 * [奖金管理 Service]
 * @Author   George              
 * @DateTime 2018-04-16T10:23:08+0800
 */
namespace Content\Service\Reward;
use Content\Service\BaseService;
use Content\Repository\ProxymonthMoneyRepository;

class RewardService extends BaseService
{
    private $rewRep;

    public function __construct()
    {
        parent::__construct();
        $this->rewRep = new ProxymonthMoneyRepository();
    }

    /**
     * [获取代理奖金]
     * @Author   George     
     * @DateTime 2018-04-16T15:41:45+0800
     * @return   [array]                   [各字段统计信息]
     */
    public function getRewardData($month, $agentName, $channelID, $limit, $toolsOption = null)
    {
        $dataArr = array();
        $where = [];
        //表头字段+样式
        $thead = array(
            array(
                'name'  => 'id',
                'field' => 'proxy_month_money_id',
                'width' => '',
                'type'  => 'hidden',
                'order' => 'desc'
            ),
            array(
                'name'  => '月份',
                'field' => 'month',
                'width' => '50',
                'order' => 'desc'
            ),
            array(
                'name'  => '代理ID',
                'field' => 'id',
                'width' => '40',
                'order' => ''
            ),
            array(
                'name'  => '代理名称',
                'field' => 'proxy_name',
                'width' => '60',
                'order' => ''
            ),
            array(
                'name'  => '来源',
                'field' => 'channel_name',
                'width' => '90',
                'order' => ''
            ),
            array(
                'name'  => '应发金额',
                'field' => 'sum_money',
                'width' => '50',
                'order' => ''
            ),
            array(
                'name'  => '扣无效数据',
                'field' => 'deduct_money',
                'width' => '50',
                'order' => ''
            ),
            array(
                'name'  => '扣个税',
                'field' => 'tax_money',
                'width' => '50',
                'order' => ''
            ),
            array(
                'name'  => '实发金额',
                'field' => 'actual_money',
                'width' => '50',
                'order' => ''
            ),
            array(
                'name'  => '备注',
                'field' => 'comment',
                'width' => '50',
                'order' => ''
            ),
            array(
                'name'  => '状态',
                'field' => 'display_status',
                'width' => '50',
                'order' => ''
            ),
            array(
                'name'  => '操作',
                'width' => '80',
                'field' => '__TOOLS',
                'type'  => 'TOOLS'
            ),
        );
        foreach ($thead as $key => $value) {
            if(empty($toolsOption) && $value['field'] == '__TOOLS'){
                unset($thead[$key]);
            }
        }
        $dataArr['toolsOption'] = $toolsOption;
        $dataArr['thead'] = $thead;

        if(!empty($month)) {
            $month = str_replace('-', '', $month);
            $where['month'] = $month;
        } else {
            $month = date('Ym');
            $where['month'] = $month;
        }
        if (!empty($agentName)) {
            $where['proxy_name'] = $agentName;    
        }
        if(!empty($channelID)) {
            $where['channel_id'] = $channelID;
        }

        $rewData = $this->rewRep->getProxyMonthMoneyList($where,$limit);
        //因为repository返回数据没有按要求,对返回值进行整理
        if(1000 == $rewData['code'] && !empty($rewData['data']['data'])) {
            foreach ($rewData['data']['data'] as $key => $val) {
                $rewData['data']['data'][$key]['month'] = $month;
                $rewData['data']['data'][$key]['sum_money'] /= 100;
                $rewData['data']['data'][$key]['deduct_money'] /= 100;
                $rewData['data']['data'][$key]['tax_money'] /= 100;
                $rewData['data']['data'][$key]['actual_money'] /= 100;
                $rewData['data']['data'][$key]['display_status'] = ($rewData['data']['data'][$key]['display_status'] ==1)?'已发送':'未发送';
            }
            $dataArr['tbody'] = $rewData['data']['data']; 
            $dataArr['count'] = $rewData['data']['count'];
        } else {
            $dataArr['tbody'] = []; 
            $dataArr['count'] = 0;
        }

        return $dataArr;
    }

    /**
     * [保存用户输入的奖金数据]
     * @Author   George                   <[<923143925@qq.com>]>
     * @DateTime 2018-04-20T15:11:07+0800
     * @return   [type]                   [description]
     */
    public function saveRewardData ($data)
    {
        if($data['sum_money']) {
            $data['sum_money'] *=100;
        }
        if($data['deduct_money']) {
            $data['deduct_money'] *= 100;
        }
        if($data['tax_money']) {
            $data['tax_money'] *= 100;
        }
        if($data['actual_money']) {
            $data['actual_money'] *= 100;
        }
        return $this->rewRep->addAndUpdateProxyMonthMoney($data);
    }

    public function showRewardData ($data)
    {
        return $this->rewRep->updateProxyMonthMoneyDisplayStatus($data);
    }
}