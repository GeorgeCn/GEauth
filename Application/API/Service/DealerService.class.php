<?php
/**
 * Created User: Administrator
 * Created Date: 2018/4/18 11:15
 * Current User: wangkun
 * History User: wangkun
 * Description:代理人Service
 */

namespace API\Service;

use API\Common\BaseService;
use API\Repository\DealerRepository;
use Content\Repository\ProxymonthMoneyRepository;

class DealerService extends BaseService
{
    private $dealerRepo;
    private $monthMoneyRepo;

    public function __construct()
    {
        parent::__construct();
        $this->dealerRepo = new DealerRepository();
        $this->monthMoneyRepo = new ProxymonthMoneyRepository();
    }

    public function getDistributions($dealerId,$filter)
    {

    }

    /**
     * @param string $userId
     * @param string $year
     * @return array
     * @author 作者
     * @description:获取用户的推广财务信息
     */
    public function getFinance($userId,$year='')
    {
        $year = $year ? $year :date('Y');
        $servD = $this->monthMoneyRepo->getProxyMonthMoney($userId,$year,'month asc');
        $data = [];
        if ($servD['code']==1000){
            foreach ($servD['data'] as $d){
                if($d['displayStatus'] == 1) {
                    $data[] = [
                        'month' => str_replace($year,'',$d['month']),
                        'sumMoney' => $d['sumMoney']/100,
                        'deductMoney' => $d['deductMoney']/100,
                        'taxMoney' => $d['taxMoney']/100,
                        'actualMoney' => $d['actualMoney']/100,
                    ];  
                }
            }
            return $this->served(1,'',$data);
        }else{
            return $this->served(0);
        }
    }

    /**
     * @param $userId
     * @param $filter
     * @return array
     * @author 作者
     * @description:获取用户的信息
     */
    public function getInfo($userId,$filter=[])
    {
        if ($userId){
            $filter = array_merge(['dealerId'=>$userId],$filter);
        }
        $servD = $this->dealerRepo->getInfo($filter);
        if ($servD['code']==1000){
            return $this->served(1,'',$servD['data']);
        }else{
            return $this->served(0);
        }
    }

    public function saveInfo($userId, $info)
    {
        $servD = $this->dealerRepo->saveInfo(['id'=>$userId], $info);
        if ($servD['code']==1000){
            return $this->served(1);
        }else{
            return $this->served(0);
        }
    }
}