<?php
/**
 * Created User: Administrator
 * Created Date: 2018/4/19 20:22
 * Current User:Administrator
 * History User:历史修改者
 * Description:这个文件主要做什么事情
 */

namespace API\Service;

use API\Common\BaseService;
use Content\Repository\ProxyAdminRepository;
use Content\Repository\ProxyStudentRepository;

class DistributionService extends BaseService
{
    private $dealerRepo;
    private $proxyStuRepo;

    public function __construct()
    {
        parent::__construct();
        $this->dealerRepo = new ProxyAdminRepository();
        $this->proxyStuRepo = new ProxyStudentRepository();
    }

    public function getAds($dealerId)
    {
        $repoD = $this->dealerRepo->proxyUrl($dealerId);
        if ($repoD['code']==1001 || $repoD['code']==1000){
            $data = [];
            foreach ($repoD['data'] as $d) {
                $data[] = ['QRcode' => $d];
            }
            return $this->served(1,'',$data);
        }else{
            return $this->served(0);
        }
    }

    public function getList(
        $dealerId = "",
        $stuName = "",
        $phone = "",
        $startTime = "",
        $endTime = ""
    ) {
        $repoD = $this->proxyStuRepo->getProxyStudent($dealerId, $stuName,$phone, $startTime, $endTime);
        if ($repoD['code']==1000){
            array_walk($repoD['data'],function(&$val){
                if ($val['regDate']){
                    $val['regDate'] = date('Y-m-d', $val['regDate']);
                }
                if ($val['openDate']){
                    $val['openDate'] = date('Y-m-d', $val['openDate']);
                }
                if($val['paymentDate']){
                    $val['paymentDate'] = date('Y-m-d', $val['paymentDate']);
                }
            });
            return $this->served(1,'',$repoD['data']);
        }elseif($repoD['code']==1001){
            return $this->served(1, '', []);
        }else{
            return $this->served(0);
        }
    }
}