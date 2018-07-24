<?php
/**
 * [首页统计 Service]
 * @Author   George              
 * @DateTime 2018-04-16T10:23:08+0800
 */
namespace Content\Service\Account;
use Content\Service\BaseService;
use Content\Repository\ProxyStudentRepository;
use Content\Repository\ChannelListRepository;

class AccountService extends BaseService
{
    private $stuRep;

    public function __construct()
    {
        parent::__construct();
        $this->stuRep = new ProxyStudentRepository();
        $this->channelRep = new ChannelListRepository();
    }

    /**
     * [获取统计信息]
     * @Author   George                   <[<923143925@qq.com>]>
     * @DateTime 2018-04-16T15:41:45+0800
     * @return   [array]                   [各字段统计信息]
     */
    public function getStaticData() 
    {
        $channel = array('');
        //获取优氏英语子渠道
        $ysChannel = $this->channelRep->getTreeChild(1);
        array_push($ysChannel,'1');
        $ysChannel = implode($ysChannel,',');
        array_push($channel, $ysChannel);
        //获取至慧学堂子渠道
        $zhChannel = $this->channelRep->getTreeChild(218);
        array_push($zhChannel,'218');
        $zhChannel = implode($zhChannel,',');
        array_push($channel, $zhChannel);
      
        $dataArr = array();
        for($i=0; $i<3; $i++) {
            //按渠道统计
            $registNum = $this->stuRep->getRegisterStudentCount('', $channel[$i]);
            if(1000 == $registNum['code']) {
                $dataArr[$i]['registNum'] = $registNum['data'];
            } else {
                $dataArr[$i]['registNum'] = 0;
            }
            $classNum = $this->stuRep->getOpenCourseStudentCount('', $channel[$i]);
            if(1000 == $classNum['code']) {
                $dataArr[$i]['classNum'] = $classNum['data'];
            } else {
                $dataArr[$i]['classNum'] = 0;
            }
            $payNum = $this->stuRep->getPayStudentCount('', $channel[$i]);
            if(1000 == $payNum['code']) {
                $dataArr[$i]['payNum'] = $payNum['data'];
            } else {
                $dataArr[$i]['payNum'] = 0;
            }
            $payTotal =$this->stuRep->getPayStudentSumMoney('', $channel[$i]);

            if(1000 == $payTotal['code']) {
                $dataArr[$i]['payTotal'] = bcdiv($payTotal['data'], 100, 2);
            } else {
                $dataArr[$i]['payTotal'] = 0;
            }
        }

        return $dataArr;
    }
}