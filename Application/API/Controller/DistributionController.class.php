<?php
/**
 * Created User: wangkun
 * Created Date: 2018/4/18 17:36
 * Current User:wangkun
 * History User:wangkun
 * Description:代理人推广接口
 */

namespace API\Controller;

use API\Common\ApiController;
use API\Service\DistributionService;

class DistributionController extends ApiController
{
    private $distributionServ;

    public function __construct()
    {
        parent::__construct();
        $this->distributionServ = new DistributionService();
    }

    /**
     * @author wangkun
     * @description:我的推广二维码
     */
    public function myads()
    {
        $this->quickRes($this->distributionServ->getAds($this->userId));
    }

    public function lists()
    {
        $this->optionalParams(['stuName', 'phone', 'startTime', 'endTime']);
        $startTime = strtotime($this->params['starTime']);
        $endTime = strtotime($this->params['endTime']);
        $this->quickRes($this->distributionServ->getList($this->userId, $this->params['stuName'], $this->params['phone'], $startTime, $endTime));
    }
}